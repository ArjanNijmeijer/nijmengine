<?php require_once( __DIR__ . '/template/header.php'  ); ?>

    <main id="content" class="container" itemprop="mainContentOfPage" role="main">
        <div class="row">
            <div class="col-md-12">
	        <?php if ( function_exists( 'yoast_breadcrumb' ) && !is_front_page() ) { echo '<div class="wrap">'; yoast_breadcrumb( '<p id="breadcrumbs" itemprop="breadcrumb">','</p>' ); echo '</div>'; } ?>
            </div>
            
            <div class="col-md-12">
                <?php
                $id = 6;
                $post = get_post( $id );
                $content = apply_filters('the_content', $post->post_content);
                ?>
                <h1><?php echo get_the_title(6); ?></h1>
                <?php echo $content; ?>
            </div>
        </div>
        <div class="row">
<?php

global $wp_query;

$args = array_merge( $wp_query->query_vars, array( 'posts_per_page' => '24' ) );
query_posts( $args );

if (have_posts()) : while (have_posts()) : the_post(); $fields = get_fields( get_the_ID() ); ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class('col-sm-6 col-md-4 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
			<?php if( strlen( trim( get_the_content() ) ) > 5 ) { ?>
				<a class="hover" href="<?php echo get_the_permalink(); ?>" title="Naar project">
			<?php } ?>
			
			<header class="entry-header" style="height: 64px; width:100%; text-align:center;">
	    		<strong class="entry-title" itemprop="headline" style="display: block; color:#555;"><?php echo ( !is_front_page() ? get_the_title() : bloginfo( 'name' ) ); ?></strong>
			</header>

            <div style="position:relative; height:220px;  overflow:hidden; background:#FFF url('<?php echo get_the_post_thumbnail_url(); ?>') no-repeat  center top; background-size:cover;  border: 1px solid #DDD;border-radius: 4px; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1);">
				<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" style="max-width:100%;" />
			</div>

			<div style="padding:16px 0 32px 0; text-align:center;">

                <?php if( is_array($fields['partner']) && count( $fields['partner'] ) > 0 ){ ?><label style="font-style:italic;">In samenwerking met:</label><br/>  <?php foreach( $fields['partner'] AS $partner ){ ?>
                 <a href="<?php echo get_the_permalink( $partner ); ?>" title="samenwerking met <?php echo get_the_title( $partner ); ?>">
                     <img style="height:60px; margin-top:8px; width:100px; object-fit:contain;  vertical-align: middle;" src="<?php echo get_the_post_thumbnail_url( $partner ); ?>" alt="samenwerking met <?php echo get_the_title( $partner ); ?>" />
                 </a>
                <?php } } ?>
			</div>

			<div class="entry-content" itemprop="text">
				<?php // the_content(__('Lees verder')); ?>
				<p><?php the_tags('<strong>Kernwoorden:</strong> ', ', ', '<br />'); ?> </p>
			</div>

			<div class="meta">
				<span class="date updated">Datum <?php echo the_date(); ?></span>
				<span class="vcard author">
					<span class="fn"><?php echo get_the_author(); ?></span>
				</span>
			</div>
			<?php if( strlen( trim( get_the_content() ) ) > 5 ) { ?>
				</a>
			<?php } ?>
	    </article>

<?php endwhile; endif; ?>

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

<?php require_once( __DIR__ . '/template/footer.php'  );