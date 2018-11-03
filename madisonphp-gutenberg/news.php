<?php
//no direct running of this php file
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'init', 'create_post_news' );
function create_post_news() {
  register_post_type( 'news',
    array(
      'labels' => array(
        'name' => __( 'News Articles' ),
        'singular_name' => __( 'News Article' ),
		'add_new'			 => __( 'Add New News Article' ),
		'add_new_item'       => __( 'Add New News Article' ),
		'new_item'           => __( 'New News Article' ),
		'edit_item'          => __( 'Edit News Article' ),
		'view_item'          => __( 'View News Article' ),
		'all_items'          => __( 'All News Articles' ),
		'search_items'       => __( 'Search News Articles' ),
		'parent_item_colon'  => __( 'Parent News Articles:' ),
		'not_found'          => __( 'No news articless found.' ),
		'not_found_in_trash' => __( 'No news articles found in trash.' )
	  ),
      'public' => true,
      'show_in_rest' => true,
      'rewrite' => array(
        'slug' => 'about/news',
        'with_front' => false
      ),
      'template' => array(
            array( 'core/paragraph', array(
                'placeholder' => 'Add News...',
            ) ),
            array( 'core/heading', array(
                'placeholder' => 'Add Author...',
            ) ),
            array( 'core/image', array(
                'align' => 'left',
            ) ),
            array( 'core/paragraph', array(
                'placeholder' => 'Add About Author...',
            ) ),
        ),
        'template_lock' => 'insert',
		'supports' => array(
			'title',
			'editor',
			'revisions',
      		'thumbnail',
		)
    )
  );
}


?>