<?php 
/**
 * Custom Query for Car Taxonomies
 *
 * Function for custom query of car taxs.
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/capwebsolutions/taps-core-functionality
 * @author       Matt Ryan <matt@capwebsolutions.com>
 * @copyright    Copyright (c) 2026, Cap Web Solutions
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


$args = array(
'post_type' => 'attachment',
'tax_query' => array(
array(
'taxonomy' => 'car-number',
'field' => 'slug',
'terms' => '1050',
),
),
);
// $query = new WP_Query( $args );

// add_filter( 'kadence_blocks_pro_query_loop_query_vars', function( $query, $ql_query_meta, $ql_id ) {

//    if ( $ql_id == 517 ) {
//       $query['tax_query'] = array(
//         //  'relation' => 'AND', // Relation between taxonomies
         
//          array(
//             'taxonomy' => 'car-number',  // First taxonomy type
//             'field'    => 'slug',
//             'terms'    => '1000',         // Slug of the first taxonomy term
//          )
//       );
//    }

//    return $query;
// }, 10, 3 );