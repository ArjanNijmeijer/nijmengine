<?php
$products = array(
	'website'	=> array(
		'name'			=> 'Website of Webshop',
		'image'			=> get_site_url() . '/wp-content/themes/nijm/assets/images/svg/nijm-webdesign-logo.svg',
		'description' 	=> '<strong>Een mooie en vindbare website of webshop?</strong> Vraag ons naar de mogelijkheden. Kijk snel op onze <a href="onze-diensten/webdesign/" title="Meer informatie over webdesign">Webdesign</a> pagina en bekijk wat NIJM Webdesign &amp; Hosting voor jou kan betekenen. ',
		'currency'		=> 'EUR',
		'price'			=> '350.00',
		'priceLabel'	=> '350,00',
		'afterPrice'	=> 'Heb je al een website.',
		'url'			=> 'onze-diensten/webdesign/',
		'subject'		=> 'webdesign',
        'color'         => '#0e6435',
		'colorsec'      => '#0e6435'
 	),
	'hosting'	=> array(
		'name'			=> 'Betrouwbare hosting',
		'image'			=> get_site_url() . '/wp-content/themes/nijm/assets/images/svg/nijm-webhosting-logo.svg',
		'description' 	=> '<strong>Jouw website veilig en altijd bereikbaar?</strong> Jouw website of webshop moet natuurlijk ten aller tijden bereikbaar en veilig zijn. Onze hosting pakketten bieden de oplossing!',
		'currency'		=> 'EUR',
		'price'			=> '8.00',
		'priceLabel'	=> '8,00',
		'afterPrice'	=> 'per maand heb je een eigen domein inclusief e-mailadressen en webruimte!',
		'url'			=> 'onze-diensten/hosting/',
		'subject'		=> 'hosting',
		'color'         => '#2c718d',
		'colorsec'      => '#2c718d'
	),
	'onderhoud'	=> array(
		'name'			=> 'Professioneel onderhoud',
		'image'			=> get_site_url() . '/wp-content/themes/nijm/assets/images/svg/nijm-webonderhoud-logo.svg',
		'description' 	=> '<strong>Zelf geen tijd om je website te beheren?</strong> Dan hebben wij de juiste service voor jou! Met onze onderhoudscontracten besteed je het bijwerken van de website aan ons uit! ',
		'currency'		=> 'EUR',
		'price'			=> '150.00',
		'priceLabel'	=> '150,00',
		'afterPrice'	=> 'kunt u uw website laten onderhouden!',
		'url'			=> 'onze-diensten/website-onderhoud/',
		'subject'		=> 'onderhoud',
		'color'         => '#5e2a57',
		'colorsec'      => '#5e2a57'
	)
);
?>

<section id="nijm_products">
    <div class="container">
        <div class="row">
            <h2 class="col-md-12">Webdesign, webshops, onderhoud en hosting</h2>

            <?php foreach( $products AS $key => $product){ ?>
            <article itemscope itemtype="https://schema.org/Product" class="col-md-4 col-xs-12">
                <div class="product">
                    <h3 class="fn" itemprop="name" style="background-color: <?php echo $product['color']; ?>;"><?php echo $product['name']; ?></h3>
                    <figure itemprop="image" content="<?php echo $product['image']; ?>">
                      <img height="61" width="150" itemscope itemtype="https://schema.org/ImageObject" itemprop="contentUrl" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
                  	</figure>
					
					
					
                    <p class="description" itemprop="description"><?php echo $product['description']; ?></p>
                    <p class="more"><a style="background-color: <?php echo $product['colorsec']; ?>;" class="url" itemprop="url" href="<?php echo $product['url']; ?>" title="Meer informatie over <?php echo $product['subject']; ?>">Alles over <?php echo $product['subject']; ?></a></p>
                </div>
				
				<div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
					<span itemprop="priceCurrency" content="EUR"></span><span
						  itemprop="price" content="100"></span>
					<link itemprop="availability" href="https://schema.org/InStock" />
					<span itemprop="priceValidUntil" content="30 <?php echo date('m Y'); ?>"></span>
				  </div>
            </article>
            <?php } ?>
        </div>
    </div>
</section>