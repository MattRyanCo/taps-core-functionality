<?php
/**
 * Tweak and manage customizations specific to Media Library Assistant plugin
 * 
 * Requires Media Library Assistant plugin to be installed and activated.
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/capwebsolutions/taps-core-functionality
 * @author       Matt Ryan <matt@capwebsolutions.com>
 * @copyright    Copyright (c) 2026, Matt Ryan
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


// Check if Media Library Assistant is active and exit early if not
if ( ! class_exists( 'MLA' ) ) {
	return;
}

/**
 * Update media library item to extract car number from file and add it as taxonomy. 
 */
// add_filter( 'mla_add_attachment_metadata', 'tuckerclub_assign_category_from_filename', 10, 2 );
add_filter( 'mla_update_attachment_metadata_postfilter', 'tuckerclub_assign_category_from_filename', 10, 2 );

function tuckerclub_assign_category_from_filename( $metadata, $post_id ) {

    $file = get_attached_file( $post_id );
    $filename = basename( $file );

    // Find first 4-digit sequence
    if ( preg_match( '/(\d{4})/', $filename, $matches ) ) {
        $code = $matches[1];

        // Taxonomy slug for Att. Category
        $taxonomy = 'attachment_category';

        // Create term if it doesn't exist
        $term = term_exists( $code, $taxonomy );
        if ( ! $term ) {
            $term = wp_insert_term( $code, $taxonomy );
        }

        // Assign term to attachment
        if ( ! is_wp_error( $term ) ) {
            wp_set_object_terms( $post_id, intval( $term['term_id'] ), $taxonomy, false );
        }
    }

    return $metadata;
}


// Example concept based on MLA documentation
add_filter('mla_gallery_link_url', 'my_custom_mla_cpt_link', 10, 3);
function my_custom_mla_cpt_link($link_url, $attachment_id, $gallery_id) {
    // Example: Check if the image has a specific taxonomy term
    $terms = get_the_terms($attachment_id, 'attachment_tag');
    
    if ($terms && !is_wp_error($terms)) {
        // Logic to find the related CPT post
		// Get the post ID of the related Car CPT that is named after the attachment's taxonomy term
		$cpt_post = get_page_by_title($terms[0]->name, OBJECT, 'car');
		$cpt_post_id = $cpt_post ? $cpt_post->ID : 0;	
        // Return the CPT permalink instead of the default media file link
        return get_permalink($cpt_post_id); 
    }
    
    return $link_url;
}