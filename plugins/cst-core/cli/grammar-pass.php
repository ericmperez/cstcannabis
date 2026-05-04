<?php
/**
 * WP-CLI Command: Apply safe mechanical PR Spanish fixes to imported course.
 *
 * Usage: wp cst grammar-pass [--dry-run]
 *
 * Applies ONLY the deterministic replacements identified in
 * docs/CONTENT-REVIEW.md as safe automation candidates:
 *
 *   1. U+2011 NON-BREAKING HYPHEN → plain U+002D in law citations / acronyms
 *      so we don't ship a course mixing two visually-identical glyphs.
 *   2. "neuropsico-funcionales" → "neuropsicofuncionales" (closed compound).
 *   3. "co-medicación" → "comedicación".
 *   4. "auto-chequeo" → "autochequeo".
 *   5. "auto-evaluación" / "auto-Evaluación" → "autoevaluación".
 *   6. Strip leftover Gemini chrome wrapping lesson 300.
 *   7. Strip stray trailing " 4" from topics post 618 title.
 *   8. Agreement fix on lessons 92 + 305:
 *      "tu orientación y conocimiento, representa" → "...representan".
 *   9. Strip empty/whitespace-only <p> </p>, <h3> </h3>, <span class=""></span>
 *      chrome that survived the WXR import.
 *
 * Title-casing, straight-vs-curly quotes, and anglicism choices are NOT
 * touched — those are judgment calls left for an editor.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WP_CLI' ) ) {
    return;
}

WP_CLI::add_command( 'cst grammar-pass', function ( $args, $assoc_args ) {

    $dry_run = isset( $assoc_args['dry-run'] );
    $changed = 0;
    $checked = 0;

    // Replacements applied to every lesson + topic body.
    $body_replacements = [
        // Hyphen normalization in law citations and acronyms.
        'Ley 22‑2000'              => 'Ley 22-2000',
        'Ley 42‑2017'              => 'Ley 42-2017',
        'Ley 229‑2003'             => 'Ley 229-2003',
        'DSM‑5'                    => 'DSM-5',
        'DSM‑IV'                   => 'DSM-IV',
        'SBIRT‑'                   => 'SBIRT-',
        'ride‑hailing'             => 'ride-hailing',
        'ride‑sharing'             => 'ride-sharing',
        // Closed-compound errors flagged in the review.
        'neuropsico‑funcionales'   => 'neuropsicofuncionales',
        'neuropsico-funcionales'   => 'neuropsicofuncionales',
        'co‑medicación'            => 'comedicación',
        'co-medicación'            => 'comedicación',
        'auto‑chequeo'             => 'autochequeo',
        'auto-chequeo'             => 'autochequeo',
        'auto-Evaluación'          => 'autoevaluación',
        'auto-evaluación'          => 'autoevaluación',
        'auto‑evaluación'          => 'autoevaluación',
        // Agreement bug.
        'orientación y conocimiento, representa un compromiso'
            => 'orientación y conocimiento, representan un compromiso',
    ];

    // Get all lesson + topic post IDs.
    $ids = get_posts( [
        'post_type'      => [ 'lesson', 'topics' ],
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ] );

    WP_CLI::log( sprintf( 'Scanning %d posts...', count( $ids ) ) );

    foreach ( $ids as $id ) {
        $checked++;
        $post = get_post( $id );
        if ( ! $post ) {
            continue;
        }

        $original_title   = $post->post_title;
        $original_content = $post->post_content;

        $new_title   = $original_title;
        $new_content = $original_content;

        // Title-only fix: stray trailing " 4" on topics 618.
        if ( 618 === (int) $id && preg_match( '/\) 4\s*$/', $new_title ) ) {
            $new_title = preg_replace( '/\) 4\s*$/', ')', $new_title );
        }

        // Apply body replacements.
        foreach ( $body_replacements as $needle => $replacement ) {
            $new_content = str_replace( $needle, $replacement, $new_content );
        }

        // Strip empty <p> </p> / <h3> </h3> / <span class=""></span> chrome.
        $new_content = preg_replace( '#<p[^>]*>\s*(?:&nbsp;|\xc2\xa0|\s)?\s*</p>#u', '', $new_content );
        $new_content = preg_replace( '#<h3[^>]*>\s*(?:&nbsp;|\xc2\xa0|\s)?\s*</h3>#u', '', $new_content );
        $new_content = preg_replace( '#<span class="">\s*</span>#', '', $new_content );

        // Lesson 300 — leftover Gemini chrome wrapper. Unwrap the inner content.
        if ( 300 === (int) $id ) {
            $new_content = preg_replace(
                '#<div\s+id="model-response-message-content[^"]*"[^>]*>(.*?)</div>\s*$#s',
                '$1',
                $new_content
            );
        }

        if ( $new_title === $original_title && $new_content === $original_content ) {
            continue;
        }

        $changed++;

        WP_CLI::log( sprintf( 'Post %d (%s): would change.', $id, $post->post_type ) );
        if ( $new_title !== $original_title ) {
            WP_CLI::log( sprintf( '  title: "%s" → "%s"', $original_title, $new_title ) );
        }
        if ( $new_content !== $original_content ) {
            // Diff-ish — log only the first 6 differing snippets.
            $count = 0;
            foreach ( $body_replacements as $needle => $replacement ) {
                $hits = substr_count( $original_content, $needle );
                if ( $hits > 0 ) {
                    WP_CLI::log( sprintf( '  body: %d× "%s" → "%s"', $hits, $needle, $replacement ) );
                    $count += $hits;
                    if ( $count > 6 ) {
                        WP_CLI::log( '  ...' );
                        break;
                    }
                }
            }
        }

        if ( ! $dry_run ) {
            wp_update_post( [
                'ID'           => $id,
                'post_title'   => $new_title,
                'post_content' => $new_content,
            ], true );
        }
    }

    WP_CLI::log( '' );
    if ( $dry_run ) {
        WP_CLI::success( sprintf( 'Dry-run complete. %d/%d posts would change.', $changed, $checked ) );
        WP_CLI::log( 'Re-run without --dry-run to apply.' );
    } else {
        WP_CLI::success( sprintf( 'Applied. %d/%d posts updated.', $changed, $checked ) );
    }
} );
