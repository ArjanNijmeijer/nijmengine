<aside id="sidebar" class="col-md-4 col-xs-12" itemscope="itemscope" itemtype="https://schema.org/WPSideBar">
    <div class="widget">
        <div class="contactInfo" itemscope itemtype="https://schema.org/Organization" >
            <span itemprop="name" class="org fn name">NIJM Webdesign &amp; Hosting</span><br/>
            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <span itemprop="streetAddress" class="address adr">Tinnegieter 33</span><br/>
                <span itemprop="postalCode" class="postcode">9502 EX</span>
                <span itemprop="addressLocality">Stadskanaal</span><br/>
                <span itemprop="addressRegion">Groningen</span><br/>
            </div>

            <a href="tel:0612715083" class="phonenumber phone tel" title="telefoonnummer: 0612715083" rel="nofollow" >WhatsApp/Storingsnummer: <span itemprop="telephone">06 127 150 83</span></a>
            <a href="tel:0599820299" class="phonenumber phone tel" title="telefoonnummer: 0599 820 299" rel="nofollow" >Tel: <span itemprop="telephone">0599 820 299</span></a>
            <a href="mailto:info@nijm.nl" itemprop="email" title="E-mailadres: info@nijm.nl" class="email" rel="nofollow">info@nijm.nl</a><br/>
        </div>
    </div>
    <?php
	$args = array(
		'posts_per_page'   => 6,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true ); 
		
	$latestNews = get_posts( $args );
?>
	<div class="widget">
		<strong class="title widget-title widgettitle">Laatste artikelen</strong>

			<div class="boxContent">
				<ul id="latestNews">
			
<?php foreach($latestNews AS $news){ 

$dateArray = explode(' ', $news->post_date);
$date = reset($dateArray);
$dateNames = array(
	'01' => 'Jan',
	'02' => 'Feb',
	'03' => 'Maa',
	'04' => 'Apr',
	'05' => 'Mei',
	'06' => 'Jun',
	'07' => 'Jul',
	'08' => 'Aug',
	'09' => 'Sep',
	'10' => 'Okt',
	'11' => 'Nov',
	'12' => 'Dec'
);

$date = explode('-', $date);
$date = $date[2].'<br/>'.$dateNames[ $date[1] ];
?>
					<li class="newsItem">
						<span class="date"><a href="<?php echo site_url(); ?>/<?php echo $news->post_name; ?>"><?php echo $date; ?></a></span>
						<a class="url" href="<?php echo site_url(); ?>/<?php echo $news->post_name; ?>" title="<?php echo $news->post_title; ?>"><?php echo $news->post_title; ?></a>
					</li>
<?php } ?>
				</ul>
			</div>
	</div>
		
	<?php if ( !function_exists('dynamic_sidebar')
            || !dynamic_sidebar() ) : ?>
    <?php endif; ?>

</aside>