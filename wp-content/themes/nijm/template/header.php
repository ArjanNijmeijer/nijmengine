<!DOCTYPE html>
<html id="nijm" lang="<?php bloginfo('language'); ?>" prefix="og: http://ogp.me/ns#">
<head>
	<?php $values = get_fields(); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <base href="<?php echo site_url(); ?>">

    <meta name="author" 		content="Arjan Nijmeijer - NIJM Webdesign &amp; Hosting"  />
	<meta name="copyright" 		content="Nijm Webdesign &amp; Hosting - Stadskanaal" />
    <meta name="robots" 		content="index, follow" />
    <meta name="revisit-after" 	content="1 month" />

    <link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_url');?>/assets/images/favicon.ico" />
    <link rel="apple-touch-icon" href="<?php bloginfo('template_url');?>/assets/images/nijm-nl.png" />

    <meta name="geo.country" content="NL" />
    <meta name="geo.region" content="NL-GR" />
    <meta name="geo.placename" content="Stadskanaal" />
    <meta name="geo.position" content="52.984074;6.982133" />
    <meta name="ICBM" content="52.984074, 6.982133" />

    <link rel="manifest" href="<?php bloginfo('template_url'); ?>/manifest.json" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#09a858" />
    
    <?php wp_head(); ?>
	
	<?php if( isset( $values['structureddata'] ) && strlen( $values['structureddata'] > 1 ) ){ 
	?>
	<script type="application/ld+json">
	<?php echo $values['structureddata']; ?> 
	</script>
	<?php }?>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">

<div><a id="quickacces" title="Direct naar de inhoud" href="#content">Direct naar de inhoud.</a></div>

<div id="top" class="col-md-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li><i class="icon-chat"></i> <a href="tel:0612715083">06 127 150 83</a></li>
                    <li><i class="icon-phone"></i> <a href="tel:0599820299">0599 820 299</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<header id="header" itemscope itemtype="https://schema.org/WPHeader">
    <div class="container">
        <div class="row">
            <div class="col-8 col-md-3">
                <a href="<?php echo get_option('home'); ?>" title="Nijm.nl" id="logo">
                     <?php echo file_get_contents( dirname( __FILE__ ) . '/../assets/images/svg/nijm-logo.svg' ); ?>
                </a>

                <?php /*
                <?php if(is_home() ){ ?>
                    <p class="site-title" itemprop="headline">NIJM Blogpagina</p>
                <?php }else{ ?>
                <h1 class="site-title" itemprop="headline"><?php echo get_the_title(); ?></h1>
                <?php } ?>
                <p class="site-description" itemprop="description">Websites, Webshops en Webapplicaties</p>
                */ ?>
            </div>

            <nav id="menu" class="nav-primary col-md-9 col-12" itemscope itemtype="https://schema.org/SiteNavigationElement">

                <div id="mobile-menu">
                    <button id="icon" class="animation--spin" type="button" aria-label="menu">
                          <span class="box">
                            <span class="inner"></span>
                          </span>
                    </button>
                </div>

                <?php
                    $menuParams = array(
                        'theme_location'  => 'primary',
                        'menu'            => 'Hoofdmenu',
                        'container'       => 'div',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'col-md-12',
                        'menu_id'         => 'nav',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 2,
                        'walker'          => new NijmMenuWalker
                    );

                    wp_nav_menu( $menuParams );
				 ?>
            </nav>
        </div>
    </div>
</header>
