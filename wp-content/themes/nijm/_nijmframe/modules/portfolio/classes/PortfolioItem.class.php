<?php
class PortfolioItem extends Dataclass{
	
	public static $identifier = 'nijm_portfolioitem';

    public $id = 'nijm_portfolioitem';

    public $values = array();
    public $position = 'normal';
    public $priority = 'default';

    public $singularName = 'portfolio item';
    public $pluralName = 'portfolio';
		
	public function __construct()
	{
		$this->values = array(
			'public' 			=> true,
			'menu_position' 	=> 5,
			'menu_icon' 		=> 'dashicons-groups',
			'show_ui' 			=> true,
			'capability_type' 	=> 'post',
			'hierarchical' 		=> false,
			'taxonomies' 		=> array( 'category' ),
			'has_archive' 		=> true,

			'rewrite' 			=> array( 'slug' => 'portfolio' ),
			'supports' 			=> array( 'title', 'editor', 'thumbnail' ),
			'publicly_queryable'    => true,
            'show_in_rest'          => true,
			
			'labels' => array(
                'name' 					=> __( ucfirst( $this->pluralName ) ),
                'singular_name' 		=> __( ucfirst( $this->singularName ) ),
                'item_meta_label'       => __( ucfirst( $this->singularName ) ),
                'add_new' 				=> __( ucfirst( $this->singularName ) . ' toevoegen'),
                'add_new_item' 			=> __( 'Nieuwe ' . $this->singularName . ' toevoegen'),
                'edit' 					=> __( 'Wijzigen' ),
                'edit_item' 			=> __( ucfirst( $this->singularName ) . ' wijzigen'),
                'new_item' 				=> __( 'Nieuwe ' . $this->singularName ),
                'view' 					=> __( 'Bekijk ' . $this->singularName ),
                'view_item' 			=> __( 'Bekijk ' . $this->singularName ),
                'search_items' 			=> __( 'Zoek ' . $this->singularName ),
                'not_found' 			=> __( 'Geen ' . $this->pluralName ),
                'not_found_in_trash' 	=> __( 'Geen ' . $this->singularName . ' gevonden in prullenbak'),
            ),
		);
		
		add_filter( 'manage_'.$this->id.'_posts_columns', array( $this, 'posts_columns' ), 5 );
		add_action( 'manage_'.$this->id.'_posts_custom_column',  array( $this, 'posts_custom_columns' ), 5, 2 );
	}

	public function posts_columns( $defaults )
	{
		return array(
			'thumbnail' 	=> __( 'Afbeelding' ),
			'title'			=> __( 'Naam' ),
			'website'		=> __( 'Website' ),
            'partner'		=> __( 'Partner' ),
		);
	}

    public function posts_custom_columns( $column_name, $post_id ) : bool
    {
        if( $column_name == 'thumbnail' )
        {
            echo the_post_thumbnail( 'thumbnail' );
            return true;
        }
        elseif( $column_name == 'partner' )
        {
            $partners = get_field( 'partner' );
            if( !$partners ){
                echo 'NIJM Webdesign & Hosting';
            }
            else{
                foreach( $partners AS $partner ) {
                    echo get_the_title($partner).' ';
                }
            }
            return true;
        }
        else
        {
            echo get_post_meta( $post_id, '_'.$column_name, true );
            return true;
        }

        return false;
    }
}