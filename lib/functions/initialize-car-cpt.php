<?php 
/**
 * Initialize the Car custom post type with reusable pattern
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/capwebsolutions/taps-core-functionality
 * @author       Matt Ryan <matt@capwebsolutions.com>
 * @copyright    Copyright (c) 2026, Matt Ryan
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


// add_filter( 'new_template', 'add_reusable_pattern_to_car_template' );

function add_reusable_pattern_to_car_template( $template, $post_type, $post ) {
    // Replace 'your_custom_post_type' with your actual CPT slug
    if ( 'car' === $post_type ) {
        // Define the blocks you want to insert
        // You can use block names like 'core/paragraph', 'core/image', or your custom pattern
        $template = array(
            array(
                'core/block',
                array(
                    'ref' => 781, // The ID of saved Reusable Pattern - Car Details
                ),
            ),
        );
    }
    return $template;
};

add_action( 'init', 'tuckerclub_car_post' );
function tuckerclub_car_post() {
	$labels = [
		'name'                     => esc_html__( 'Cars', 'tuckerclub' ),
		'singular_name'            => esc_html__( 'Car', 'tuckerclub' ),
		'add_new'                  => esc_html__( 'Add New', 'tuckerclub' ),
		'add_new_item'             => esc_html__( 'Add New Car', 'tuckerclub' ),
		'edit_item'                => esc_html__( 'Edit Car', 'tuckerclub' ),
		'new_item'                 => esc_html__( 'New Car', 'tuckerclub' ),
		'view_item'                => esc_html__( 'View Car', 'tuckerclub' ),
		'view_items'               => esc_html__( 'View Cars', 'tuckerclub' ),
		'search_items'             => esc_html__( 'Search Cars', 'tuckerclub' ),
		'not_found'                => esc_html__( 'No cars found.', 'tuckerclub' ),
		'not_found_in_trash'       => esc_html__( 'No cars found in Trash.', 'tuckerclub' ),
		'parent_item_colon'        => esc_html__( 'Parent Car:', 'tuckerclub' ),
		'all_items'                => esc_html__( 'All Cars', 'tuckerclub' ),
		'archives'                 => esc_html__( 'Car Archives', 'tuckerclub' ),
		'attributes'               => esc_html__( 'Car Attributes', 'tuckerclub' ),
		'insert_into_item'         => esc_html__( 'Insert into car', 'tuckerclub' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this car', 'tuckerclub' ),
		'featured_image'           => esc_html__( 'Featured image', 'tuckerclub' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'tuckerclub' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'tuckerclub' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'tuckerclub' ),
		'menu_name'                => esc_html__( 'Cars', 'tuckerclub' ),
		'filter_items_list'        => esc_html__( 'Filter cars list', 'tuckerclub' ),
		'filter_by_date'           => esc_html__( '', 'tuckerclub' ),
		'items_list_navigation'    => esc_html__( 'Cars list navigation', 'tuckerclub' ),
		'items_list'               => esc_html__( 'Cars list', 'tuckerclub' ),
		'item_published'           => esc_html__( 'Car published.', 'tuckerclub' ),
		'item_published_privately' => esc_html__( 'Car published privately.', 'tuckerclub' ),
		'item_reverted_to_draft'   => esc_html__( 'Car reverted to draft.', 'tuckerclub' ),
		'item_scheduled'           => esc_html__( 'Car scheduled.', 'tuckerclub' ),
		'item_updated'             => esc_html__( 'Car updated.', 'tuckerclub' ),
	];
	$args = [
		'label'               => esc_html__( 'Cars', 'tuckerclub' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => false,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-car',
		'capability_type'     => 'post',
		'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields'],
		'taxonomies'          => ['post_tag'],
		'rewrite'             => [
			'with_front' => false,
		],
		// 'template' => array( 
		// 	array('core/block', array(
		// 	'ref' => 781, // The ID of saved Reusable Pattern - Car Details
		// 	)),
		// ),
		// 'template_lock' => 'false',
	];

	register_post_type( 'car', $args );
}