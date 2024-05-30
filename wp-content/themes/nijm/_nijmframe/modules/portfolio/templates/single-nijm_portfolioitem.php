<?php require_once( __DIR__ . '/template/header.php'  ); ?>

    <main id="content" class="container" itemprop="mainContentOfPage" role="main">
        <div class="row">
            <div class="col-md-12">
                <?php if ( function_exists( 'yoast_breadcrumb' ) && !is_front_page() ) { echo '<div class="wrap">'; yoast_breadcrumb( '<p id="breadcrumbs" itemprop="breadcrumb">','</p>' ); echo '</div>'; } ?>
				<?php if ( function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
			</div>
        </div>
        <div class="row" style="position:relative;">
            <?php if (have_posts()) : while( have_posts()) : the_post(); $values = get_fields( get_the_ID() ); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('col-12') ?>>

                <header class="entry-header">
                    <h1 class="entry-title" itemprop="headline" ><?php echo get_the_title(); ?></h1>
                </header>

                <div class="entry-content" itemprop="text" style="padding-right:100px;">
                    <?php the_content(); ?>
                </div>

				<div style="margin-top:48px;">
                <a href="<?php echo $values['website']; ?>" title="Naar <?php echo $values['website']; ?>" rel="noopener nofollow" class="button" target="_blank">Bekijk de website</a>
				<div>
            </article>
            <?php endwhile; endif; ?>
        </div>
    </main>

<?php require_once( __DIR__ . '/template/footer.php'  );