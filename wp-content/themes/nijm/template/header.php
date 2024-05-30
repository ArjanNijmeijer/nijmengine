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

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <?php wp_head(); ?>
	
	<?php if( isset( $values['structureddata'] ) && strlen( $values['structureddata'] > 1 ) ){ ?>
	<script type="application/ld+json">
	<?php echo $values['structureddata']; ?> 
	</script>
	<?php }?>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">\

<header id="header" itemscope itemtype="https://schema.org/WPHeader">
    <div class="container">
        <div class="row">
            <div class="col-8 col-md-3">
                <a href="<?php echo get_option('home'); ?>" title="Nijm.nl" id="logo">
                     <?php echo file_get_contents( dirname( __FILE__ ) . '/../assets/images/svg/nijm-logo.svg' ); ?>
                </a>
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
