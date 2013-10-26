<?php
// Template Name: Search Map
get_header(); 
?>
	<?php
	$purl = get_post_type_archive_link('property');
	?>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		function insertParam(key, value)
		{
		    key = escape(key); value = escape(value);

		    var kvp = document.location.search.substr(1).split('&');

		    var i=kvp.length; var x; while(i--) 
		    {
		        x = kvp[i].split('=');

		        if (x[0]==key)
		        {
		                x[1] = value;
		                kvp[i] = x.join('=');
		                break;
		        }
		    }

		    if(i<0) {kvp[kvp.length] = [key,value].join('=');}

		    //this will reload the page, it's likely better to store this until finished
		    document.location.search = kvp.join('&'); 
		}
		function removeParameter(url, parameter)
		{
		  var urlparts= url.split('?');

		  if (urlparts.length>=2)
		  {
		      var urlBase=urlparts.shift(); //get first part, and remove from array
		      var queryString=urlparts.join("?"); //join it back up

		      var prefix = encodeURIComponent(parameter)+'=';
		      var pars = queryString.split(/[&;]/g);
		      for (var i= pars.length; i-->0;)               //reverse iteration as may be destructive
		          if (pars[i].lastIndexOf(prefix, 0)!==-1)   //idiom for string.startsWith
		              pars.splice(i, 1);
		      url = urlBase+'?'+pars.join('&');
		  }
		  return url;
		}
		$('select[name=sorting]').change(function() {
			var current_option = $(this).find('option:selected').val();
			if(current_option != '') {
				insertParam('area', current_option)
			} 
		});
		$('select[name=sorting2]').change(function() {
			var current_option = $(this).find('option:selected').val();
			if(current_option != '') {
				insertParam('area', 'district_' + current_option)
			} 
		});		
	});
	</script>
	<div id="main">
		<div class="width-container">

				<div class="content-boxed">
					<h2 class="title-bg"><?php echo of_get_option('search_results_text', 'Map Search'); ?></h2>


					<div id="sortable-search">

						<select name="sorting" style="float:left;"> 
							<option value="recent"><?php _e('Choose Area','progressionstudios'); ?></option>
							<?php
							global $wpdb;
							 $tax_terms = $wpdb->get_col("SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = 'pyre_address' ORDER BY meta_value" );
							?>
		
							<?php
							foreach ($tax_terms as $tax_term) {
							  echo '<option>' . '' . $tax_term .'</option>';
							}
							?>						
							</select>				
						<select name="sorting2" style="float:left;">  
							<option value="recent"><?php _e('Choose District','progressionstudios'); ?></option>
							<?php
							global $wpdb;
							 $tax_terms = $wpdb->get_col("SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = 'pyre_district' ORDER BY meta_value" );
							?>
		
							<?php
							foreach ($tax_terms as $tax_term) {
							  echo '<option>' . '' . $tax_term .'</option>';
							}
							?>						
							</select>								
					</div>	
					
					<div id="map-container">
						<div id="map-listing"></div>
					</div>

						<script type="text/javascript"> 

						jQuery.getJSON('<?php echo site_url(); ?>/json/?area=<?php echo $_GET['area']?>', function(myMarkers){

							jQuery("#map-listing").goMap({
								markers: myMarkers,
								disableDoubleClickZoom: true,
								zoom: 14,
								address: '', //have this be the first items address so that one is centered
								maptype: 'ROADMAP' 
							});
							jQuery.goMap.fitBounds('visible'); 
						});				
						</script>

				<div class="clearfix"></div>

			</div>

			<?php wp_reset_query() ?>
	

		<div class="clearfix"></div>
		</div><!-- close .width-container -->
	</div><!-- close #main -->
<?php get_footer(); ?>