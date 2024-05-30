<div style="width:100%; height:64px; background:#CCC; ">

</div>

<main id="content" class="container"  itemprop="mainContentOfPage" role="main">
    <div class="content row" >
        <?php if ( function_exists( 'yoast_breadcrumb' ) && !is_front_page() ) { echo '<div class="col-md-12">'; yoast_breadcrumb( '<p id="breadcrumbs" itemprop="breadcrumb">','</p>' ); echo '</div>'; } ?>
        <div class="introduction col-md-12">
        <?php if( is_category() ){ ?>
            <h1><?php echo single_cat_title(); ?></h1>
            <?php echo category_description(); ?>
        <?php } else {
            $blogpageID = get_option('page_for_posts', true);
            ?>
            <h1><?php echo get_the_title( $blogpageID ); ?></h1>
            <?php
            $content_post = get_post( $blogpageID );
            $content = $content_post->post_content;
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
            echo $content;
         }
         ?>
        </div>
    </div>
    <div class="row row-eq-height">
    <?php
     if ( have_posts()) : while ( have_posts()) : the_post(); ?>
        <article <?php post_class('col-md-4 col-sm-6 col-12 item') ?> id="post-<?php the_ID(); ?>" itemscope="itemscope" itemtype="https://schema.org/CreativeWork" >
            <div class="holder">
                <header class="entry-header">
                    <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                        <?php
                        if ( has_post_thumbnail() ) {

                           the_post_thumbnail('blog' );
                        }
                        else
                        {
                            echo '<div class="placeholder"></div>';
                        }
                        ?>

                         <h2 class="entry-title" itemprop="headline" style="height:72px;"><?php echo get_the_title(); ?></h2>
                    </a>
                </header>

                <div class="entry-content" itemprop="text">
                    <div style="height:136px; overflow:hidden;"><?php the_excerpt(); ?></div>
                    <p class="readmore"><a href="<?php echo get_the_permalink(); ?>" title="Lees verder over <?php echo get_the_title(); ?>">Lees verder</a></p>
                </div>

                <div class="meta">
                    <span class="date updated">Geschreven op <?php echo get_the_modified_date(); ?></span>
                door <span class="vcard author"><span class="fn"><?php echo get_the_author(); ?></span></span>
                </div>

            </div>
        </article>
    <?php endwhile;  endif; ?>
    </div>
    <div class="pagination col-md-12">
        <?php
        $args = array(
            'show_all'           => true,
            'end_size'           => 1,
            'mid_size'           => 2,
            'prev_next'          => true,
            'prev_text'          => __('« Vorige'),
            'next_text'          => __('Volgende »'),
            'type'               => 'plain',
            'add_args'           => false,
            'add_fragment'       => '',
            'before_page_number' => '',
            'after_page_number'  => ''
        );

        echo paginate_links( $args );
        ?>
    </div>
</main>