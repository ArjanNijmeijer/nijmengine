<?php
class Team extends Dataclass{
	public static $identifier = 'nijm_team';
	
	public $id = 'nijm_team';

	public $values = array();
	public $position = 'normal';
	public $priority = 'default';
		
	public function __construct()
	{
		$this->values = array(
			'public' 			=> true,
			'menu_position' 	=> 5,
			'menu_icon' 		=> 'dashicons-businessperson',
			'show_ui' 			=> true,
			'capability_type' 	=> 'post',
			'hierarchical' 		=> false,
			'taxonomies' 		=> array(),
			'has_archive' 		=> true,
			'show_in_rest'		=> true,
			'rewrite' 			=> array( 'slug' => 'teams' ),
			'supports' 			=> array( 'title', 'editor', 'thumbnail' ),
			// 'publicly_queryable'  => false,
			'labels' => array(
				'name' 					=> __( 'Teams' ),
				'singular_name' 		=> __( 'Team' ),
				'add_new' 				=> __( 'Team toevoegen'),
				'add_new_item' 			=> __( 'Nieuw team toevoegen'),
				'edit' 					=> __( 'Wijzigen' ),
				'edit_item' 			=> __( 'Team wijzigen'),
				'new_item' 				=> __( 'Nieuw team'),
				'view' 					=> __( 'Bekijk team' ),
				'view_item' 			=> __( 'Bekijk team'),
				'search_items' 			=> __( 'Zoek team'),
				'not_found' 			=> __( 'Geen teams'),
				'not_found_in_trash' 	=> __( 'Geen teams gevonden in prullenbak'),
				'item_meta_label'		=> __( 'Team eigenschappen' )
			)
		);
		
		add_filter( 'manage_'.$this->id.'_posts_columns', array( $this, 'posts_columns' ), 5 );
		add_action( 'manage_'.$this->id.'_posts_custom_column',  array( $this, 'posts_custom_columns' ), 5, 2 );
	}

	public function posts_columns( $defaults )
	{
        $defaults['thumbnail'] = __( 'Afbeelding' );

        return $defaults;
	}

	public function posts_custom_columns( $column_name, $post_id )
	{		
		if ( $column_name == 'thumbnail' ) 
		{
			return the_post_thumbnail( 'thumbnail' );
		}
		elseif ( $column_name == 'type' )
        {
            echo ucfirst( get_field('type', $post_id ) );
            return true;
        }
		else
		{
			return get_post_meta( $post_id, '_'.$column_name, true );
		}

		return false;
	}
}