<?php require_once( 'template/header.php' ); ?>
<div id="content">
	<div class="container">
   	 	<article <?php post_class() ?> id="post-<?php the_ID(); ?>"  role="main">
   	 		
	   		<h1>Oeps! De pagina is niet gevonden.</h1>                                
	        <p>Er is iets mis gegaan. Deze pagina bestaat niet (meer). Wanneer u deze foutmelding blijft krijgen verzoeken wij u contact met ons op te nemen via het <a href="<?php echo $config->site['url']; ?>/contact" title="contactformulier">contactformulier</a>.</p>			
	       
	        <h2>Maar wat nu?</h2>
	        <p>Om verder te gaan kunt u:</p>
			
			<ul>
				<li><a href="http://www.nijm.nl" title="Naar de homepagina <?php echo $config->site['url']; ?>">Naar de hoofdpagina gaan door hier te klikken.</a></li>
				<li>Via het menu bovenin verder bladeren</li>		
				<li><a href="#" onclick="history.go(-1); return false;">Terug keren naar de vorige pagina door hier te klikken.</a></li>				
			</ul>
			
			<p>Of doorzoek deze website:</p> 
			<div id="searchbar">
				<form method="post" id="searchform" action="<?php echo $config->site['url']; ?>">
					<fieldset>
						<label>
							<input type="text" value="" name="s" id="s" size="35" onfocus="this.value=''" class="text" />
						</label> 
						<label>
							<input type="submit" id="searchsubmit" class="submit" value="Zoeken" />
						</label>
					</fieldset>
				</form>
			</div>
		</article>
	</div>
</div>
<?php require_once( 'template/footer.php' );