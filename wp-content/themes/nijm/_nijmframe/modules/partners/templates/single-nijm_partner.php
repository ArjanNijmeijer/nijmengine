<?php require_once( __DIR__ . '/template/header.php'  ); ?>

    <main id="content" class="container" itemprop="mainContentOfPage" role="main">
        <div class="row">
            <div class="col-md-12">
                <?php if ( function_exists( 'yoast_breadcrumb' ) && !is_front_page() ) { echo '<div class="wrap">'; yoast_breadcrumb( '<p id="breadcrumbs" itemprop="breadcrumb">','</p>' ); echo '</div>'; } ?>
            </div>
        </div>
        <div class="row" style="position:relative;">

                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" style="position:absolute; right:0; height:auto; width:200px;" />


            <?php if (have_posts()) : while( have_posts()) : the_post(); $values = get_fields( get_the_ID() ); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('col-12 col-md-10') ?>>


                <header class="entry-header">
                    <h1 class="entry-title" itemprop="headline" ><?php echo get_the_title(); ?></h1>
                </header>

                <div class="entry-content" itemprop="text" style="padding-right:100px;">
                    <?php the_content(); ?>
                </div>

                <a href="<?php echo $values['website']; ?>" rel="noopener nofollow" target="_blank">Bekijk de website</a>

            </article>
            <?php endwhile; endif; ?>

            <section class="col-12" style="margin-top:64px;">
                <h2>Gezamenlijke projecten</h2>

                <?php
                $args = array(
                    'post_type'			=> 'nijm_portfolioitem',
                    'posts_per_page'	=> -1,
                    'post_status'       => 'publish',
                    'order'             => 'DESC',
                    'meta_query'	=> array(
                    'relation'		=> 'OR',
                       array(
                           'key'	 	=> 'partner',
                           'value'	    =>  get_the_ID(),
                           'compare' 	=> 'LIKE',
                       ),
                   ),
                );

                $projects = new WP_Query( $args );

                ?>
                <div class="row">
                   <?php while( $projects->have_posts() ) : $projects->the_post(); ?>

                         <div class="col-6 col-md-4" style="margin-bottom:24px;">
                             
							<img style="height:200px; border: 1px solid #DDD; border-radius: 4px; width:100%; object-fit:cover;  object-position:top center;" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" />
                             
                             <p style="text-align: center;"><?php echo get_the_title();  ?></p>
                         </div>
                <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </section>
        </div>
    </main>

<?php require_once( __DIR__ . '/template/footer.php'  );