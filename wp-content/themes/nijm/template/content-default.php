    <?php
    if( is_front_page() )
    {
	    require_once( 'modules/blocks.php' );
    }

     if( get_the_ID() == 71 || get_the_ID() == 76 || get_the_ID() == 2 ){
            ?>
            <section>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d23745.9273262113!2d6.9857293!3d52.9852598!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xde083dd84ec4f188!2sNIJM+Webdesign+%26+Hosting!5e1!3m2!1snl!2snl!4v1518219445123" width="600" height="450" frameborder="0" style="width:100%; height:350px; border:none;" allowfullscreen></iframe>
            </section>

            <?php
     }
     elseif( is_single() && has_post_thumbnail() ){
        ?>
         <div id="headerImage">
             <div class="container">
                 <div class="row">
                     <div class="col-md-12">
	                     <img src="<?php the_post_thumbnail_url('original' ); ?>" alt="<?php echo get_the_title(); ?>" />
                     </div>
                 </div>
             </div>
         </div>
         <?php
     }elseif( !is_front_page() ) {
	 
	 $style = '';
	 if( has_post_thumbnail() ){ 
		$image = get_the_post_thumbnail_url();
		
		$style = 'style="background-image:url( ' . $image . ' ); background-size:cover; background-position:center center;"';
	 } ?>
         <div id="headerImage" <?php echo $style; ?> >
		 
		 </div>
         <?php
     }
    ?>
    <main id="content" class="container">
        <div class="row">
            <?php
            if( function_exists( 'yoast_breadcrumb' ) && !is_front_page() ) { yoast_breadcrumb( '<div class="col-12"><p id="breadcrumbs" itemprop="breadcrumb">','</p></div>' ); }
			if( function_exists( 'rank_math_the_breadcrumbs') && !is_front_page() ){ echo '<div class="col-12">'; rank_math_the_breadcrumbs(); echo '</div>'; } 
			?>
			
            <?php if ( have_posts()) : while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'col-12'); ?> id="post-<?php the_ID(); ?>" itemscope="itemscope" itemtype="https://schema.org/CreativeWork" >
                <header class="entry-header">
                    <h1 class="entry-title" itemprop="headline"><?php echo get_the_title(); ?></h1>

                    <?php if( is_single( ) ) { ?>

                    <ul class="meta">
                        <li class="vcard author"><span class="icon-author">door:</span>  <em class="fn" itemprop="author"><?php echo get_the_author(); ?></em></li>
                        <li><span class="icon-calendar">op:</span> <i class="date updated" itemprop="datePublished"><?php echo get_the_date('d M Y'); ?></i></li>
                        <li><span class="icon-calendar">laatste wijziging:</span> <i class="date updated" itemprop="dateModified"><?php echo get_the_modified_date('d M Y'); ?></i></li>
                        <li><span class="icon-tags">tags:</span> <?php echo get_the_tag_list('<span class="tag">', '','</span>'); ?></li>
                    </ul>

                    <?php } ?>
                </header>

                <div class="entry-content" itemprop="text">
                    <?php the_content( __('Lees verder') ); ?>
                </div>

	            <?php if( !is_single( ) ) { ?>
                <footer class="meta">
                    <span>Datum <?php echo get_the_modified_date(); ?></span>
                    <span class="vcard author">
                        <span class="fn"><?php echo get_the_author(); ?></span>
                    </span>
                </footer>
                <?php } ?>

	            <?php
                if ( is_singular() && comments_open() ) {
	                comments_template();
	            }
	            ?>
            </article>
            <?php endwhile; endif; ?>
        </div>
    </main>

    <?php
    global $post;
    $tags = wp_get_post_tags($post->ID);

    if ($tags)
    {
	    $tag_ids = array();
	    foreach( $tags as $individual_tag)
	    {
		    $tag_ids[] = $individual_tag->term_id;
		    $args = array(
			    'tag__in' 			=> $tag_ids,
			    'post__not_in' 		=> array($post->ID),
			    'posts_per_page'	=> 8, // Number of related posts to display.
			    'caller_get_posts'	=> 1,
                'orderby'           => 'date',
                'order'             => 'DESC',
		    );
	    }

	    $my_query = new wp_query( $args );

	    if( $my_query->have_posts() )
	    {
		    ?>
            <section id="relatedposts" itemscope itemtype="http://schema.org/WebPage">
                <div class="container" >
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <strong class="title">Gerelateerde berichten</strong>
                        </div>

                        <?php while( $my_query->have_posts() ) { $my_query->the_post();?>
                            <article class="col-md-3">
                                <a rel="external" itemprop="relatedLink" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                    <?php
                                    if ( has_post_thumbnail() ) {

                                        the_post_thumbnail('blog' );
                                    }
                                    else
                                    {
                                        echo '<div class="placeholder"></div>';
                                    }
                                    ?>
                                    <strong><?php the_title(); ?></strong>
                                </a>
                            </article>
                        <?php } ?>
                    </div>
                </div>
            </section>
		    <?php
	    }
    }

    wp_reset_query();
    ?>

    <?php if( !is_front_page() ){
        require_once( 'modules/blocks.php' );
    }else{
	    require_once( 'modules/latest-news.php' );
    }
    
	require_once( 'modules/testimonials.php' );