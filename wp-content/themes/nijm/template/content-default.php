<?php if( has_post_thumbnail() ){ ?>
 <div id="headerImage">
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <img src="<?php the_post_thumbnail_url('original' ); ?>" alt="<?php echo get_the_title(); ?>" />
             </div>
         </div>
     </div>
 </div>
<?php } ?>

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
            </header>

            <div class="entry-content" itemprop="text">
                <?php the_content(); ?>
            </div>
        </article>
        <?php endwhile; endif; ?>
    </div>
</main>