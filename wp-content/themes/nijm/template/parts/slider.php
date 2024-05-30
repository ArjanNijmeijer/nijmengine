<?php 
$numberOfWebsites = 5;

$sw_args = array(
    'post_type' 		=> 'nijm_portfolioitem',
    'posts_per_page'	=> '-1'
);

$query = new WP_Query( $sw_args );

$featuredWebsites = array();
$otherWebsites = array();
$websites = array();

if ( $query->have_posts() ) 
{
	while ( $query->have_posts() ) 
	{
		$query->the_post();
		$postmeta = get_post_meta( get_the_id() );
		
		if( $postmeta['_featured'] == 'featured' )
		{
			$featuredWebsites[] = array(
				//'thumbnail' 	=> get_the_post_thumbnail( get_the_id(), array( 405,226 ) ),
				'thumbnail' 	=> get_the_post_thumbnail( get_the_id(), 'portfolio' ),
				'title'			=> get_the_title(),
				'url' 			=> get_permalink( get_the_id() ),
				'description' 	=> get_the_content(),
				'meta'			=> $postmeta
			);
		}
		else 
		{
			$otherWebsites[] = array(
			//	'thumbnail' 	=> get_the_post_thumbnail( get_the_id(), array( 405,226 ) ),
				'thumbnail' 	=> get_the_post_thumbnail( get_the_id(), 'portfolio' ),
				'title'			=> get_the_title(),
				'url' 			=> get_permalink( get_the_id() ),
				'description' 	=> get_the_content(),
				'meta'			=> $postmeta
			);
		}
	}
}

if( !sizeof( $featuredWebsites ) || sizeof( $featuredWebsites ) < $numberOfWebsites )
{
	$websites = $featuredWebsites;
	
	$i = sizeof( $websites );
	while( $i <= $numberOfWebsites )
	{
		$website = array_shift( $otherWebsites );
		$websites[] = $website;
		$i++;
	}
}
else
{
	$websites = $featuredWebsites;
}

?>
<section id="slider">
	<div class="wrapper">
	<h2>Website en webshop portfolio</h2>
	<ul>
	<?php             				
	foreach( $websites AS $website )
	{
	?>
		<li class="slide">
			<figure class="img">
				<?php echo $website['thumbnail']; ?>
				<figcaption><?php echo $website['title']; ?></figcaption>
			</figure> 
		
	  		<div class="mobi">
	            <strong><?php echo $website['title']; ?></strong> 
	            <p class="sliderText">
	            	<?php echo $website['description']; ?><br/>
	            	<a href="<?php echo $website['url']; ?>" class="moreInfo" title="<?php echo $website['title']; ?>">Meer over deze opdracht</a>
	            </p>  
	        </div>
		</li>
	<?php
	}
	?>
	</ul> 
	</div> 
</section>