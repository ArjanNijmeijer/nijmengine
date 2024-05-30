<?php require_once( __DIR__ . '/template/header.php'  ); ?>

    <main id="content" class="container" itemprop="mainContentOfPage" role="main">
        <div class="row">
            <div class="col-md-12">
	        <?php if ( function_exists( 'yoast_breadcrumb' ) && !is_front_page() ) { echo '<div class="wrap">'; yoast_breadcrumb( '<p id="breadcrumbs" itemprop="breadcrumb">','</p>' ); echo '</div>'; } ?>
            </div>
            
            <div class="col-md-12">
                <?php
                $id = 3671;
                $post = get_post( $id );
                $content = apply_filters('the_content', $post->post_content);
                ?>
                <h1><?php echo get_the_title($id  ); ?></h1>
                <?php echo $content; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Onze samenwerkingspartners</h2>
                <p>Met deze partners werken wij nauw samen. Zowel qua hosting als het bouwen van de websites. Nieuwsgierig welke projecten wij samen gedaan hebben? Klik dan op de logo's!</p>
            </div>
<?php

if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
			<header class="entry-header" style="height: 38px; width:100%; text-align:center;">
	    		<strong class="entry-title" itemprop="headline" style="display: block; color:#555;"><?php echo  get_the_title(); ?></strong>
			</header>

            <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1);">
				<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" style="vertical-align:middle; max-width:100%;" />
			</a>
			
			<div style="padding:16px 0 32px 0; text-align:center;">
				<a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">Bekijk partner</a>
			</div>
	    </article>

<?php endwhile; endif; ?>

        </div>

        <div class="row" style="margin-top:64px;">
            <div class="col-12">
                <h2>Onze hostingpartners</h2>
                <p>Voor deze partners verzorgen wij een veilige en snelle hostingomgeving.</p>
            </div>
            <article  <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">Solution Online</strong>
                </header>

                <a target="_blank" href="https://www.solutiononline.nl/"  title="Solution Online" class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2022/03/solution-online-logo.png" alt="Solution Online" style="vertical-align:middle; max-width:100%;" />
                </a>

                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>


            <article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">XLX Designz</strong>
                </header>

                <a target="_blank" href="https://www.xlxdesignz.nl/" title="XLX Designz"  class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2022/03/xlx-designz-logo.png" alt="XLX Designz" style="vertical-align:middle; max-width:100%;" />
                </a>

                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>

            <article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">IJver&Hart</strong>
                </header>

                <a target="_blank" href="https://ijverhart.nl/" title="IJver&Hart"  class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2022/04/cropped-IJverHart_Logo_250x100px_Mid-1.png" alt="IJver&Hart" style="vertical-align:middle; max-width:100%;" />
                </a>

                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>

            <article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">TheMarketingShop</strong>
                </header>

                <a target="_blank" href="https://www.themarketingshop.nl/" title="TheMarketingShop "  class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2022/04/themarketingshop.jpg" alt="TheMarketingShop " style="vertical-align:middle; max-width:100%;" />
                </a>
                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>
			
			
			<article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">BMS Design</strong>
                </header>

                <a target="_blank" href="https://www.bmsdesign.nl/" title="BMS Design "  class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2022/12/BMSdesign-logo-metslogan_homepage.jpg" alt="BMS Design " style="vertical-align:middle; max-width:100%;" />
                </a>
                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>
        </div>
		
		
		
		<div class="row" style="margin-top:64px;">
            <div class="col-12">
                <h2>Onze online marketingpartners</h2>
                <p>Online marketing nodig voor je website? Kijk eens bij deze partners.</p>
            </div>
            <article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">Convident</strong>
                </header>

                <a target="_blank" href="https://convident.nl/"  title="Convident" class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:50px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2023/04/convident-logo.png" alt="Convident" style="vertical-align:middle; max-width:60%;" />
                </a>

                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>
        </div>
		
		<div class="row" style="margin-top:64px;">
            <div class="col-12">
                <h2>Onze SEO copywritepartners</h2>
                <p>Zoekmachinevriendelijke teksten nodig? Kijk dan eens bij deze partners.</p>
            </div>
            <article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">Ten Have Tekst</strong>
                </header>

                <a target="_blank" href="https://tenhavetekst.nl/"  title="Ten Have Tekst" class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:50px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2023/02/tenhavetekst.png" alt="Ten Have Tekst" style="vertical-align:middle; max-width:60%;" />
                </a>

                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>
        </div>

        <div class="row" style="margin-top:64px;">
            <div class="col-12">
                <h2>Onze ICT-partner</h2>
                <p>Deze partners kunnen helpen bij gerelateerde ict zaken zoals het instellen van Office365 omgevingen.</p>
            </div>
            <article <?php post_class('col-6 col-md-3 item') ?> itemscope="itemscope" itemtype="https://schema.org/CreativeWork" class="portfolioItem" >
                <header class="entry-header" style="height: 38px; width:100%; text-align:center;">
                    <strong class="entry-title" itemprop="headline" style="display: block; color:#555;">Nijmko</strong>
                </header>

                <a target="_blank" href="https://www.nijmko.nl/"  title="Nijmko Telecom" class="entry-header" style="display:block; height:220px; overflow:hidden; border: 1px solid #DDD; border-radius: 4px; padding:80px 24px 0 24px; text-align:center; box-shadow: 0 8px 24px 0 rgba(36,37,42,0.1); ">
                    <img src="https://nijm.nl/wp-content/uploads/2022/04/nijmko-logo.png" alt="Nijmko Telecom" style="vertical-align:middle; max-width:100%;" />
                </a>

                <div style="padding:16px 0 32px 0; text-align:center;"></div>
            </article>
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