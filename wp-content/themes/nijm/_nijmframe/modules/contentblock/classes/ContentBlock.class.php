<?php
class ContentBlock extends Dataclass{
	public static $identifier = 'nijm_contentblock';
	
	public $id = 'nijm_contentblock';

	public $values = array();
	public $position = 'normal';
	public $priority = 'default';
		
	public function __construct()
	{
		$this->values = array(
			'public' 			=> true,
			'menu_position' 	=> 5,
			'menu_icon' 		=> 'dashicons-grid-view',
			'show_ui' 			=> true,
			'capability_type' 	=> 'post',
			'hierarchical' 		=> false,
			'taxonomies' 		=> array( ),
			'has_archive' 		=> false,

			'rewrite' 			=> array(  ),
			'supports' 			  => array( 'title', 'editor', 'thumbnail' ),
			'publicly_queryable'  => false,
			'show_in_rest'      => true,
			'labels' => array(
				'name' 					=> __( 'Content blok' ),
				'singular_name' 		=> __( 'Content blok' ),
				'add_new' 				=> __( 'Content blok toevoegen'),
				'add_new_item' 			=> __( 'Nieuwe content blok toevoegen'),
				'edit' 					=> __( 'Wijzigen' ),
				'edit_item' 			=> __( 'Content blok wijzigen'),
				'new_item' 				=> __( 'Nieuwe content blok'),
				'view' 					=> __( 'Bekijk content blok' ),
				'view_item' 			=> __( 'Bekijk content blok'),
				'search_items' 			=> __( 'Zoek content blokken'),
				'not_found' 			=> __( 'Geen content blokken'),
				'not_found_in_trash' 	=> __( 'Geen content blokken gevonden in prullenbak'),
                'item_meta_label'       => __( 'Content blok'),
			)
		);
		
		add_filter( 'manage_'.$this->id.'_posts_columns', array( $this, 'posts_columns' ), 5 );
		add_action( 'manage_'.$this->id.'_posts_custom_column',  array( $this, 'posts_custom_columns' ), 5, 2 );

		add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id, $args ){
			// Nothing to do
			if( 'delete_post' !== $cap || empty( $args[0] ) )
				return $caps;

			// Target the payment and transaction post types
			if( in_array( get_post_type( $args[0] ), [ 'nijm_contentblock' ], true ) )
				$caps[] = 'do_not_allow';

			return $caps;
		}, 10, 4 );
	}

	public function posts_columns( $defaults )
	{
		return array(
			'title'			=> __( 'Naam' )
		);
	}

	public function posts_custom_columns( $column_name, $post_id )
	{		
		if ( $column_name == 'thumbnail' ) 
		{
			return the_post_thumbnail( 'thumbnail' );
		}
		else
		{
			return get_post_meta( $post_id, '_'.$column_name, true );
		}

		return false;
	}
}