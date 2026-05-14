<?php
/**
 * CST_Chatbot_Context — Knowledge base for the chatbot.
 *
 * Pulls FAQs (cst_faq CPT) + the cannabis course post and its Tutor LMS
 * lessons, normalizes them into a single document set, and exposes:
 *
 *   - find_answer()       — local keyword matcher used when no LLM is wired.
 *   - get_knowledge_text() — flat text blob ready to inject as LLM context.
 *
 * Both consume the same cached document set, so the LLM and the fallback
 * matcher always see the same "memory."
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Chatbot_Context {

    private const COURSE_SLUG       = 'curso-cannabis';
    private const KB_CACHE_TTL      = HOUR_IN_SECONDS;
    private const MAX_CONTEXT_CHARS = 12000;

    /**
     * Find the best knowledge-base match for a user message.
     *
     * Searches FAQs first (highest weight) then the course/lesson body
     * text. Returns the matched answer or empty string when nothing
     * crosses the minimum-relevance threshold.
     */
    public static function find_answer( string $message ): string {
        $docs    = self::get_knowledge_base();
        $message = self::normalize( $message );

        if ( empty( $message ) || empty( $docs ) ) {
            return '';
        }

        $best_score = 0;
        $best_answer = '';

        foreach ( $docs as $doc ) {
            $score = self::score_match( $message, $doc['title'], $doc['content'] );
            // FAQs are authoritative — boost their score so they win ties
            // against incidental course-body keyword overlap.
            if ( 'faq' === $doc['type'] ) {
                $score = (int) ( $score * 1.5 );
            }
            if ( $score > $best_score ) {
                $best_score  = $score;
                $best_answer = $doc['content'];
            }
        }

        // Minimum threshold for a useful match.
        if ( $best_score < 2 ) {
            return '';
        }

        return $best_answer;
    }

    /**
     * Combined knowledge base: FAQs + course + lessons.
     *
     * Cached per language (via Polylang current_language) so EN visitors
     * get EN translations when present.
     *
     * @return array<int, array{type:string, title:string, content:string}>
     */
    public static function get_knowledge_base(): array {
        $lang          = function_exists( 'pll_current_language' ) ? (string) pll_current_language() : '';
        $transient_key = 'cst_chatbot_kb_' . ( $lang ?: 'default' );
        $cached        = get_transient( $transient_key );

        if ( false !== $cached ) {
            return $cached;
        }

        $docs = array_merge(
            array_map(
                static function ( $faq ) {
                    return [
                        'type'    => 'faq',
                        'title'   => $faq['question'],
                        'content' => $faq['answer'],
                    ];
                },
                self::get_faqs()
            ),
            self::get_course_content()
        );

        set_transient( $transient_key, $docs, self::KB_CACHE_TTL );

        return $docs;
    }

    /**
     * Plain-text knowledge base for injection as LLM context.
     *
     * Truncated to MAX_CONTEXT_CHARS to keep prompt cost bounded.
     */
    public static function get_knowledge_text(): string {
        $sections = [];
        foreach ( self::get_knowledge_base() as $doc ) {
            $label = 'faq' === $doc['type'] ? 'FAQ' : ucfirst( $doc['type'] );
            $sections[] = '[' . $label . '] ' . $doc['title'] . "\n" . $doc['content'];
        }
        $text = implode( "\n\n---\n\n", $sections );

        if ( mb_strlen( $text ) > self::MAX_CONTEXT_CHARS ) {
            $text = mb_substr( $text, 0, self::MAX_CONTEXT_CHARS ) . "\n[…truncated]";
        }

        return $text;
    }

    /**
     * Course post + all attached Tutor LMS lessons, as KB documents.
     *
     * @return array<int, array{type:string, title:string, content:string}>
     */
    private static function get_course_content(): array {
        $course = get_page_by_path( self::COURSE_SLUG, OBJECT, 'courses' );
        if ( ! $course || 'publish' !== $course->post_status ) {
            return [];
        }

        $course_id = $course->ID;
        if ( function_exists( 'pll_get_post' ) && function_exists( 'pll_current_language' ) ) {
            $translated = pll_get_post( $course_id, (string) pll_current_language() );
            if ( $translated ) {
                $course    = get_post( $translated );
                $course_id = $translated;
            }
        }

        $docs = [];
        $docs[] = [
            'type'    => 'course',
            'title'   => get_the_title( $course ),
            'content' => self::strip( $course->post_content ),
        ];

        // Tutor LMS attaches lessons via post_parent on the 'lesson' CPT.
        // Fall back gracefully when Tutor isn't installed.
        if ( post_type_exists( 'lesson' ) ) {
            $lessons = get_posts( [
                'post_type'      => 'lesson',
                'post_parent'    => $course_id,
                'posts_per_page' => 50,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ] );
            foreach ( $lessons as $lesson ) {
                $docs[] = [
                    'type'    => 'lesson',
                    'title'   => $lesson->post_title,
                    'content' => self::strip( $lesson->post_content ),
                ];
            }
        }

        return $docs;
    }

    /**
     * Convert raw post_content to plain text suitable for matching/LLM context.
     */
    private static function strip( string $content ): string {
        return trim( wp_strip_all_tags( strip_shortcodes( $content ) ) );
    }

    /**
     * Get all FAQs from the cst_faq CPT.
     */
    public static function get_faqs(): array {
        $transient_key = 'cst_faq_knowledge_base';
        $cached = get_transient( $transient_key );

        if ( false !== $cached ) {
            return $cached;
        }

        $query = new WP_Query( [
            'post_type'      => 'cst_faq',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ] );

        $faqs = [];
        while ( $query->have_posts() ) {
            $query->the_post();
            $faqs[] = [
                'id'       => get_the_ID(),
                'question' => get_the_title(),
                'answer'   => wp_strip_all_tags( strip_shortcodes( get_the_content() ) ),
            ];
        }
        wp_reset_postdata();

        // Cache for 1 hour.
        set_transient( $transient_key, $faqs, HOUR_IN_SECONDS );

        return $faqs;
    }

    /**
     * Score how well a message matches a FAQ entry.
     */
    private static function score_match( string $message, string $question, string $answer ): int {
        $question_normalized = self::normalize( $question );
        $answer_normalized   = self::normalize( $answer );

        // Extract words (minimum 3 characters).
        $message_words = array_filter(
            explode( ' ', $message ),
            function ( $w ) { return mb_strlen( $w ) >= 3; }
        );

        if ( empty( $message_words ) ) {
            return 0;
        }

        $score = 0;
        foreach ( $message_words as $word ) {
            // Higher weight for question matches.
            if ( str_contains( $question_normalized, $word ) ) {
                $score += 3;
            }
            // Lower weight for answer body matches.
            if ( str_contains( $answer_normalized, $word ) ) {
                $score += 1;
            }
        }

        return $score;
    }

    /**
     * Normalize text for matching: lowercase, remove accents, strip punctuation.
     */
    private static function normalize( string $text ): string {
        $text = mb_strtolower( $text );
        $text = self::remove_accents( $text );
        $text = preg_replace( '/[^\p{L}\p{N}\s]/u', ' ', $text );
        $text = preg_replace( '/\s+/', ' ', $text );
        return trim( $text );
    }

    /**
     * Remove common Spanish/English accents.
     */
    private static function remove_accents( string $text ): string {
        $map = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'ü' => 'u', 'ñ' => 'n',
            'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
        ];
        return strtr( $text, $map );
    }

    /**
     * Invalidate FAQ + knowledge-base cache. Polylang languages are
     * stored under distinct keys; clear the common ones plus default.
     */
    public static function flush_cache(): void {
        delete_transient( 'cst_faq_knowledge_base' );
        delete_transient( 'cst_chatbot_kb_default' );
        if ( function_exists( 'pll_languages_list' ) ) {
            foreach ( (array) pll_languages_list() as $code ) {
                delete_transient( 'cst_chatbot_kb_' . $code );
            }
        } else {
            // Common slugs to cover non-Polylang installs that still
            // happen to switch locales.
            foreach ( [ 'es', 'en' ] as $code ) {
                delete_transient( 'cst_chatbot_kb_' . $code );
            }
        }
    }
}

// Flush cache when FAQs, the course post, or any lesson changes.
add_action( 'save_post_cst_faq', [ 'CST_Chatbot_Context', 'flush_cache' ] );
add_action( 'save_post_courses', [ 'CST_Chatbot_Context', 'flush_cache' ] );
add_action( 'save_post_lesson',  [ 'CST_Chatbot_Context', 'flush_cache' ] );
add_action( 'delete_post', function ( $post_id ) {
    if ( in_array( get_post_type( $post_id ), [ 'cst_faq', 'courses', 'lesson' ], true ) ) {
        CST_Chatbot_Context::flush_cache();
    }
} );
