<?php
/**
 * Debug media
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/capwebsolutions/taps-core-functionality
 * @author       Matt Ryan <matt@capwebsolutions.com>
 * @copyright    Copyright (c) 2026, Matt Ryan
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Output a simple debug grid of attachments (6 columns) filtered by attachment_category term IDs 1000-1050.
 *
 * Usage: visit any page while logged in as an admin and add `?taps_debug_media=1` to the URL.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function taps_debug_media_grid_output() {
    // Find all terms for the taxonomy and filter by term_id range
    $all_terms = get_terms( array(
        'taxonomy'   => 'attachment_category',
        'hide_empty' => false,
    ) );

    $valid_term_ids = array();
    if ( ! empty( $all_terms ) && ! is_wp_error( $all_terms ) ) {
        foreach ( $all_terms as $term ) {
            // if ( is_numeric( $term->term_id ) && $term->term_id >= 1000 && $term->term_id <= 1050 ) {
            if ( $term->name >= '1000' && $term->name <= '1050' ) {
                $valid_term_ids[] = (int) $term->term_id;
            }
        }
    }

    if ( empty( $valid_term_ids ) ) {
        echo '<p>No attachment_category terms found in the 1000–1050 range.</p>';
        return;
    }

    // Query attachments that have at least one of the valid terms
    $attachments = get_posts( array(
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => -1,
        'post_mime_type' => 'image',
        'tax_query'      => array(
            array(
                'taxonomy' => 'attachment_category',
                'field'    => 'term_id',
                'terms'    => $valid_term_ids,
                'operator' => 'IN',
            ),
        ),
    ) );

    if ( empty( $attachments ) ) {
        echo '<p>No attachments found for the selected attachment_category terms.</p>';
        return;
    }

    // Render a responsive table-like grid, 6 columns wide
    $columns = 6;
    $count = 0;

    echo '<div style="overflow:auto;">';
    echo '<table style="width:100%; border-collapse:collapse;">';
    echo '<tbody>';

    foreach ( $attachments as $att ) {
        // Only display attachments that have at least one valid term (defensive double-check)
        $terms = wp_get_post_terms( $att->ID, 'attachment_category' );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            continue;
        }

        $term_ids_in_range = array();
        foreach ( $terms as $t ) {
            if ( is_numeric( $t->term_id ) && $t->term_id >= 1000 && $t->term_id <= 1050 ) {
                $term_ids_in_range[] = (int) $t->term_id;
            }
        }

        if ( empty( $term_ids_in_range ) ) {
            continue; // skip attachments with no terms in the required range
        }

        if ( 0 === $count % $columns ) {
            echo '<tr>';
        }

        $thumb = wp_get_attachment_image( $att->ID, 'thumbnail', false, array( 'style' => 'display:block; margin:0 auto 6px;' ) );
        $file_path = get_attached_file( $att->ID );
        $filename = $file_path ? basename( $file_path ) : $att->post_name;
        $term_list = esc_html( implode( ', ', $term_ids_in_range ) );

        echo '<td style="vertical-align:top; padding:8px; border:1px solid #eee; text-align:center; width:' . floor(100 / $columns) . '%;">';
        echo $thumb;
        echo '<div style="font-size:12px; word-break:break-all;">' . esc_html( $filename ) . '</div>';
        echo '<div style="font-size:12px; color:#666;">' . $term_list . '</div>';
        echo '</td>';

        $count++;
        if ( 0 === $count % $columns ) {
            echo '</tr>';
        }
    }

    // Close last row, filling empty cells if needed
    if ( 0 !== $count % $columns ) {
        $remaining = $columns - ( $count % $columns );
        for ( $i = 0; $i < $remaining; $i++ ) {
            echo '<td style="border:1px solid #eee; padding:8px;">&nbsp;</td>';
        }
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

// Only output when on the dedicated debug page and viewed by an admin.
add_action( 'template_redirect', function() {
    if ( is_admin() ) {
        return;
    }

    if ( ! ( function_exists( 'current_user_can' ) && current_user_can( 'manage_options' ) ) ) {
        return;
    }

    if ( function_exists( 'is_page' ) && is_page( 'debug-page' ) ) {
        taps_debug_media_grid_output();
        // stop normal page rendering so only debug output shows
        exit;
    }
} );
