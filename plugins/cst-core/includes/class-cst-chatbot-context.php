<?php
/**
 * CST_Chatbot_Context — Builds knowledge base from cst_faq CPT posts.
 *
 * Provides local FAQ matching when no LLM API is configured.
 * Searches question titles and answer content for keyword matches.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Chatbot_Context {

    /**
     * Find the best FAQ match for a user message.
     *
     * Returns the FAQ answer if a match is found, or empty string if no match.
     */
    public static function find_answer( string $message ): string {
        $faqs    = self::get_faqs();
        $message = self::normalize( $message );

        if ( empty( $message ) || empty( $faqs ) ) {
            return '';
        }

        $best_score = 0;
        $best_answer = '';

        foreach ( $faqs as $faq ) {
            $score = self::score_match( $message, $faq['question'], $faq['answer'] );
            if ( $score > $best_score ) {
                $best_score  = $score;
                $best_answer = $faq['answer'];
            }
        }

        // Minimum threshold for a useful match.
        if ( $best_score < 2 ) {
            return '';
        }

        return $best_answer;
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
                'answer'   => wp_strip_all_tags( get_the_content() ),
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
     * Invalidate FAQ cache when a FAQ post is saved/deleted.
     */
    public static function flush_cache(): void {
        delete_transient( 'cst_faq_knowledge_base' );
    }
}

// Flush cache when FAQs change.
add_action( 'save_post_cst_faq', [ 'CST_Chatbot_Context', 'flush_cache' ] );
add_action( 'delete_post', function ( $post_id ) {
    if ( get_post_type( $post_id ) === 'cst_faq' ) {
        CST_Chatbot_Context::flush_cache();
    }
} );
