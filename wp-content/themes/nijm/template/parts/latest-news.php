<section id="latestNews">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Webdesign en hosting blog</h2>
			</div>
		<?php
		$args = array( 'numberposts' => '3', 'post_status' => 'publish' );
		$recent_posts = wp_get_recent_posts( $args );
		$i = 1;
		foreach( $recent_posts as $recent ) { ?>
			<div class="col-12 col-md-4">
				<a href="<?php echo get_permalink( $recent["ID"] ); ?>" style="text-decoration:none; ">

					<div style="background-image:url('<?php echo get_the_post_thumbnail_url( $recent["ID"] ); ?>'); " class="image">
						<div class="date">
							<?php $d = new DateTime($recent['post_date'] ); ?>
							<span class="day"><?php echo $d->format('d' ); ?></span>
							<span class="month"><?php echo $d->format('M' ); ?></span>
							<span class="year"><?php echo $d->format('Y' ); ?></span>
						</div>
					</div>
					<h3 class="title"><?php echo $recent["post_title"]; ?></h3>
				</a>
			</div>
			<?php } wp_reset_query(); ?>
			<div class="col-12">
				<a href="https://nijm.nl/blog/" class="readmore" title="naar de blog">Naar volledig overzicht</a>
			</div>
		</div>
	</div>
</section>