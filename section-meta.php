<?php

/* Post meta
=========================================================== */

add_action( 'add_meta_boxes', 'veuse_sections_meta_section' );

function veuse_sections_meta_section()
{
	add_meta_box( 'veuse_sections_data', __('Section Settings','veuse-sections'), 'veuse_sections_data_cb', 'sections', 'normal', 'high' );
}

function veuse_sections_data_cb( $post )
{
	$prefix = 'veuse_section';
	
	$values = get_post_custom( $post->ID );
	
	$custom_css = isset( $values[$prefix.'_custom_css'] ) ?  $values[$prefix.'_custom_css'][0] : '';
	$background_image = isset( $values[$prefix.'_background_image'] ) ?  $values[$prefix.'_background_image'][0]  : '';
	$background_color = isset( $values[$prefix.'_background_color'] ) ?  $values[$prefix.'_background_color'][0]  : '';
	$background_position = isset( $values[$prefix.'_background_position'] ) ?  $values[$prefix.'_background_position'][0]  : '';
	$background_repeat = isset( $values[$prefix.'_background_repeat'] ) ?  $values[$prefix.'_background_repeat'][0]  : '';
	$padding_top = isset( $values[$prefix.'_padding_top'] ) ?  $values[$prefix.'_padding_top'][0]  : '';
	$padding_bottom = isset( $values[$prefix.'_padding_bottom'] ) ?  $values[$prefix.'_padding_bottom'][0]  : '';
	$margin_bottom = isset( $values[$prefix.'_margin_bottom'] ) ?  $values[$prefix.'_margin_bottom'][0]  : '';
	$border_top_color = isset( $values[$prefix.'_border_top_color'] ) ?  $values[$prefix.'_border_top_color'][0]  : '';
	$border_bottom_color = isset( $values[$prefix.'_border_bottom_color'] ) ?  $values[$prefix.'_border_bottom_color'][0]  : '';
	
	$fullwidth = isset($values[$prefix.'_fullwidth'])  ?   $values[$prefix.'_fullwidth'][0] : '';
	$parallax = isset( $values[$prefix.'_parallax'] ) ?  $values[$prefix.'_parallax'][0]  : '';
	$parallax_speed = isset( $values[$prefix.'_parallax_speed'] ) ?  $values[$prefix.'_parallax_speed'][0]  : '';
	$overlay = isset( $values[$prefix.'_overlay'] ) ?  $values[$prefix.'_overlay'][0]  : '';
		
	$skin =  isset($values[$prefix.'_skin'])  ?  $values[$prefix.'_skin'][0]  : '';
	$textshadow =  isset($values[$prefix.'_textshadow'])  ?  $values[$prefix.'_textshadow'][0]  : '';
	

	/* Form here */
	?>
	
	<div>
	
		<ul class="veuse-section-tabnav">
			<li><a href="#veuse-section-tab-1">Colors and background</a></li>
			<li><a href="#veuse-section-tab-2">Padding and margins</a></li>
			<li><a href="#veuse-section-tab-3">Custom css</a></li>
		</ul>
	
		<section class="veuse-section-tab" id="veuse-section-tab-1">
		<table class="form-table" width="100%">
			<tbody>
			
				<tr>
					<th scope="row" style="text-align:left" colspan="2"><h2><?php _e('Text Color','veuse-sections');?></h2></th>

				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_skin"><?php _e('Text color','veuse-sections');?></label></th>
					<td>
						<select name="<?php echo $prefix;?>_skin"  style="width: 240px">
							<option value="light" <?php echo $skin == 'light' ? 'selected="selected"' : '';?> ><?php _e('Dark text ( for light background )','veuse-sections');?></option>
							<option value="dark"  <?php echo $skin == 'dark' ?  'selected="selected"' : '';?> ><?php _e('Light text ( for dark backgrounds )','veuse-sections');?></option>
					
						</select>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_parallax"><?php _e('Text shadow','veuse-sections');?></label></th>
					<td>
						<input type="checkbox" name="<?php echo $prefix;?>_textshadow" id="<?php echo $prefix;?>_textshadow" <?php checked( $textshadow, 'on' ); ?> />
						<label for="<?php echo $prefix;?>_textshadow"><?php _e('Add a shadow to text to make it stand out from the background','veuse-sections');?></label>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left" colspan="2"><h2><?php _e('Background Settings','veuse-sections');?></h2></th>

				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_background_image"><?php _e('Background Image','veuse-sections');?></label></th>
					<td>
						<script>
						jQuery(document).ready(function($){
 
							$('#veuse-background-image-upload').click(function(e) {
						 	
						 		e.preventDefault();
								
								frame = wp.media({
								 	title : 'Select image',
								 	frame: 'post',
								 	multiple : false, // set to false if you want only one image
								 	library : { type : 'image'},
								 	button : { text : 'Insert image' },
								});
								
								frame.on('close',function(data) {
								 	var imageArray = [];
								 	images = frame.state().get('selection');
								 	images.each(function(image) {
										imageArray.push(image.attributes.url); // want other attributes? Check the available ones with console.log(image.attributes);
										$('#veuse-background-image-upload').hide();
										$('#veuse-background-image-remove').show();
									 });
						 
									 jQuery('#veuse_section_background_image').val(imageArray.join(",")); // Adds all image URL's comma seperated to a text input
								 
									 jQuery('#background-container').append('<img src="'+ imageArray.join(",") + '" style="max-width:500px;"/>');
								
								});
								
								frame.open();
						
							});
							
							$(document).on('click','#veuse-background-image-remove', function(e) {
								
								e.preventDefault();
								
								$('#veuse-background-image-remove').hide();
								$('#veuse-background-image-upload').show();
								$('#background-container img').remove();
								$('#veuse_section_background_image').val('');
								
							});
							
						});
						</script>
												
							<div id="background-container" style="max-width:500px;">
								
								<?php 
								if(!empty($background_image)){
									
									echo '<img src="'.$background_image .'" style="max-width:500px">';
									
								}
								?>
								
							</div>
							<input type="hidden" name="<?php echo $prefix;?>_background_image" id="veuse_section_background_image" value="<?php echo $background_image; ?>" size="30"/>
						
							<input type="button" name="staff-background" id="veuse-background-image-upload" class="button button-secondary" value="<?php _e('Add background image','veuse-sections');?>"  style="<?php echo !empty($background_image) ? 'display:none;' : '';?>"/>
							<input type="button" name="" id="veuse-background-image-remove" class="button button-primary" value="<?php _e('Remove image','veuse-sections');?>" style="<?php echo empty($background_image) ? 'display:none;' : '';?>"/>
										
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_background_color"><?php _e('Background Color','veuse-sections');?></label></th>
					<td><input type="text" name="<?php echo $prefix;?>_background_color" id="<?php echo $prefix;?>_background_color" value="<?php echo $background_color; ?>" size="30"/>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_background_position"><?php _e('Background Position','veuse-sections');?></label></th>
					<td>
						<select name="<?php echo $prefix;?>_background_position"  style="width: 240px">
							<option value="top left" <?php echo $background_position == 'top left' ? 'selected="selected"' : '';?> ><?php _e('Top Left','veuse-sections');?></option>
							<option value="top center" <?php echo $background_position == 'top center' ? 'selected="selected"' : '';?> ><?php _e('Top Center','veuse-sections');?></option>
							<option value="top right" <?php echo $background_position == 'top right' ? 'selected="selected"' : '';?> ><?php _e('Top Right','veuse-sections');?></option>

							<option value="center left" <?php echo $background_position == 'center left' ? 'selected="selected"' : '';?> ><?php _e('Center Left','veuse-sections');?></option>
							<option value="center center" <?php echo $background_position == 'center center' ? 'selected="selected"' : '';?> ><?php _e('Center Center','veuse-sections');?></option>
							<option value="center right" <?php echo $background_position == 'center right' ? 'selected="selected"' : '';?> ><?php _e('Center Right','veuse-sections');?></option>
							
							<option value="bottom left" <?php echo $background_position == 'bottom left' ? 'selected="selected"' : '';?> ><?php _e('Bottom Left','veuse-sections');?></option>
							<option value="bottom center" <?php echo $background_position == 'bottom center' ? 'selected="selected"' : '';?> ><?php _e('Bottom Center','veuse-sections');?></option>
							<option value="bottom right" <?php echo $background_position == 'bottom right' ? 'selected="selected"' : '';?> ><?php _e('Bottom Right','veuse-sections');?></option>
							
							<option value="fixed" <?php echo $background_position == 'fixed' ? 'selected="selected"' : '';?> ><?php _e('Fixed Position','veuse-sections');?></option>
							
					
						</select>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_background_repeat"><?php _e('Background Repeat','veuse-sections');?></label></th>
					<td>
						<select name="<?php echo $prefix;?>_background_repeat"  style="width: 240px">
							<option value="repeat" <?php echo $background_repeat== 'repeat' ? 'selected="selected"' : '';?> ><?php _e('Repeat','veuse-sections');?></option>
							<option value="no-repeat" <?php echo $background_repeat== 'no-repeat' ? 'selected="selected"' : '';?> ><?php _e('No Repeat','veuse-sections');?></option>
							<option value="repeat-x" <?php echo $background_repeat== 'repeat-x' ? 'selected="selected"' : '';?> ><?php _e('Repeat Horisontally','veuse-sections');?></option>
							<option value="repeat-y" <?php echo $background_repeat== 'repeat-y' ? 'selected="selected"' : '';?> ><?php _e('Repeat Vertically','veuse-sections');?></option>					
						</select>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_overlay"><?php _e('Pattern overlay','veuse-sections');?></label></th>
					<td>
						<select name="<?php echo $prefix;?>_overlay"  style="width: 240px">
							<option value=""><?php _e('No overlay','veuse-sections');?></option>
							<option value="darken" <?php echo $overlay== 'darken' ? 'selected="selected"' : '';?> ><?php _e('Black transparency','veuse-sections');?></option>		
							<option value="lighten" <?php echo $overlay== 'lighten' ? 'selected="selected"' : '';?> ><?php _e('White transparency','veuse-sections');?></option>		
							
							<option value="white-diagonal" <?php echo $overlay== 'white-diagonal' ? 'selected="selected"' : '';?> ><?php _e('White diagonal lines','veuse-sections');?></option>
							<option value="white-horisontal" <?php echo $overlay== 'white-horisontal' ? 'selected="selected"' : '';?> ><?php _e('White horisontal lines','veuse-sections');?></option>
							<option value="black-diagonal" <?php echo $overlay== 'black-diagonal' ? 'selected="selected"' : '';?> ><?php _e('Black diagonal lines','veuse-sections');?></option>
							<option value="black-horisontal" <?php echo $overlay== 'black-diagonal' ? 'selected="selected"' : '';?> ><?php _e('Black horisontal lines','veuse-sections');?></option>				
									
						</select>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_parallax"><?php _e('Parallax Effect','veuse-sections');?></label></th>
					<td>
						<input type="checkbox" name="<?php echo $prefix;?>_parallax" id="<?php echo $prefix;?>_parallax" <?php checked( $parallax, 'on' ); ?> />
						<label for="<?php echo $prefix;?>_parallax"><?php _e('Enable parallax scroll effect. ( Requires a repeating background image)','veuse-sections');?></label>
					</td>
				</tr>
				
				
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_parallax_speed"><?php _e('Parallax speed','veuse-sections');?></label></th>
					<td>
						<select name="<?php echo $prefix;?>_parallax_speed"  id="<?php echo $prefix;?>_parallax_speed" style="width: 240px">		
							<option value="0.10" <?php selected($parallax_speed, '0.10');?>><?php _e('10 ms','veuse-sections');?></option>
							<option value="0.15" <?php selected($parallax_speed, '0.15');?>><?php _e('15 ms','veuse-sections');?></option>
							<option value="0.20" <?php selected($parallax_speed, '0.20');?>><?php _e('20 ms','veuse-sections');?></option>
							<option value="0.25" <?php selected($parallax_speed, '0.25');?>><?php _e('25 ms','veuse-sections');?></option>
							<option value="0.30" <?php selected($parallax_speed, '0.30');?>><?php _e('30 ms','veuse-sections');?></option>
							<option value="0.35" <?php selected($parallax_speed, '0.35');?>><?php _e('35 ms','veuse-sections');?></option>
							<option value="0.40" <?php selected($parallax_speed, '0.40');?>><?php _e('40 ms','veuse-sections');?></option>
							<option value="0.45" <?php selected($parallax_speed, '0.45');?>><?php _e('45 ms','veuse-sections');?></option>
							<option value="0.50" <?php selected($parallax_speed, '0.50');?>><?php _e('50 ms','veuse-sections');?></option>				
						</select>
					</td>
				</tr>
				
				
				</tbody>
				</table>
				
				</section>
		
				<section class="veuse-section-tab" id="veuse-section-tab-2">
				
				<table class="form-table" width="100%">
				<tbody>
				
				<tr>
					<th scope="row" style="text-align:left" colspan="2"><h2><?php _e('Padding and Margins','veuse-sections');?></h2></th>
	
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_padding_top"><?php _e('Top Padding','veuse-sections');?></label></th>
					<td>
						<input type="text" name="<?php echo $prefix;?>_padding_top" id="<?php echo $prefix;?>_padding_top" value="<?php echo $padding_top; ?>" size="4"/> <span class="example">px</span>
					</td>
				</tr>


				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_padding_bottom"><?php _e('Bottom Padding','veuse-sections');?></label></th>
					<td>
						<input type="text" name="<?php echo $prefix;?>_padding_bottom" id="<?php echo $prefix;?>_padding_bottom" value="<?php echo $padding_bottom; ?>" size="4"/> <span class="example">px</span>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_margin_bottom"><?php _e('Bottom Margin','veuse-sections');?></label></th>
					<td>
						<input type="text" name="<?php echo $prefix;?>_margin_bottom" id="<?php echo $prefix;?>_margin_bottom" value="<?php echo $margin_bottom; ?>" size="4"/> <span class="example">px</span>
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left" colspan="2"><h2><?php _e('Border','veuse-sections');?></h2></th>
	
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_border_top_color"><?php _e('Border Top Color','veuse-sections');?></label></th>
					<td>
						<input type="text" name="<?php echo $prefix;?>_border_top_color" id="<?php echo $prefix;?>_border_top_color" value="<?php echo $border_top_color; ?>" size="4"/> (example: #000000)
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_border_bottom_color"><?php _e('Border Bottom Color','veuse-sections');?></label></th>
					<td>
						<input type="text" name="<?php echo $prefix;?>_border_bottom_color" id="<?php echo $prefix;?>_border_bottom_color" value="<?php echo $border_bottom_color; ?>" size="4"/> (example: #000000)
					</td>
				</tr>
				
				<tr>
					<th scope="row" style="text-align:left" colspan="2"><h2><?php _e('Content Width','veuse-sections');?></h2></th>
				</tr>
				
				<tr>
					<?php $field_id_value = get_post_meta($post->ID, $prefix.'_fullwidth', true);
						if($field_id_value == "yes") $field_id_checked = 'checked="checked"';
						else  $field_id_checked = ''; ?>
    
					<th scope="row" style="text-align:left"><label for="<?php echo $prefix;?>_fullwidth"><?php _e('Fullwidth content','veuse-sections');?></label></th>
					<td>
						<input type="checkbox" name="<?php echo $prefix;?>_fullwidth" value="yes" id="<?php echo $prefix;?>_fullwidth" <?php echo $field_id_checked; ?> />
						<label for="<?php echo $prefix;?>_fullwidth"><?php _e('Let content span full width','veuse-sections');?></label>
					</td>
				</tr>
				
				
				</tbody>
				</table>
				
				</section>
		
				<section class="veuse-section-tab" id="veuse-section-tab-3">
				
				<table class="form-table" width="100%">
				<tbody>
				
				<script>
				
				jQuery(document).delegate('#<?php echo $prefix;?>_custom_css', 'keydown', function(e) { 
					  var keyCode = e.keyCode || e.which; 
					
					  if (keyCode == 9) { 
					    e.preventDefault(); 
					    var start = jQuery(this).get(0).selectionStart;
					    var end = jQuery(this).get(0).selectionEnd;
					
					    // set textarea value to: text before caret + tab + text after caret
					    jQuery(this).val(jQuery(this).val().substring(0, start)
					                + "\t"
					                + jQuery(this).val().substring(end));
					
					    // put caret at right position again
					    jQuery(this).get(0).selectionStart = 
					    jQuery(this).get(0).selectionEnd = start + 1;
					  } 
					});
					
				
				</script>
				
				<tr>
					<th scope="row" style="text-align:left"><strong><?php _e('Custom css','veuse-sections');?></strong></th>
					<td><textarea name="<?php echo $prefix;?>_custom_css" id="<?php echo $prefix;?>_custom_css" style="width:100%" rows="10"><?php echo $custom_css; ?></textarea>
					<label><?php printf(__('Prefix each style with #veuse-section-%s.','veuse'), get_the_ID() );?> <?php printf(__('E.g #veuse-section-%s h1 { color:#fff}','veuse'), get_the_ID() );?></label>
					</td>
					</td>
				</tr>

			
			</tbody>
		</table>
		
		
		
		</section>
		
	</div>
	
	
	
	<?php

	wp_nonce_field( 'veuse_sections_nonce', 'meta_box_nonce' );?>
	

	
	
	<?php }




add_action( 'save_post', 'veuse_sections_save_meta' );


function veuse_sections_save_meta( $post_id ){

	$prefix = 'veuse_section';

	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'veuse_sections_nonce' ) ) return;

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_posts' ) ) return;


	// Probably a good idea to make sure your data is set
	if( isset( $_POST[$prefix.'_background_image'] ) )
	update_post_meta( $post_id, $prefix.'_background_image',  $_POST[$prefix.'_background_image'] );
	else
	delete_post_meta($post_id, $prefix.'_background_image');
	
	if( isset( $_POST[$prefix.'_background_color'] ) )
	update_post_meta( $post_id, $prefix.'_background_color',  $_POST[$prefix.'_background_color'] );
	else
	delete_post_meta($post_id, $prefix.'_background_color');
	
	if( isset( $_POST[$prefix.'_skin'] ) )
	update_post_meta( $post_id, $prefix.'_skin',  $_POST[$prefix.'_skin'] );
	else
	delete_post_meta($post_id, $prefix.'_skin');
	
	if( isset( $_POST[$prefix.'_background_position'] ) )
	update_post_meta( $post_id, $prefix.'_background_position',  $_POST[$prefix.'_background_position'] );
	else
	delete_post_meta($post_id, $prefix.'_background_position');
	
	if( isset( $_POST[$prefix.'_background_repeat'] ) )
	update_post_meta( $post_id, $prefix.'_background_repeat',  $_POST[$prefix.'_background_repeat'] );
	else
	delete_post_meta($post_id, $prefix.'_background_repeat');
	
	if( isset( $_POST[$prefix.'_padding_top'] ) )
	update_post_meta( $post_id, $prefix.'_padding_top',  $_POST[$prefix.'_padding_top'] );
	else
	delete_post_meta($post_id, $prefix.'_padding_top');
	
	if( isset( $_POST[$prefix.'_padding_bottom'] ) )
	update_post_meta( $post_id, $prefix.'_padding_bottom',  $_POST[$prefix.'_padding_bottom'] );
	else
	delete_post_meta($post_id, $prefix.'_padding_bottom');
	
	if( isset( $_POST[$prefix.'_margin_bottom'] ) )
	update_post_meta( $post_id, $prefix.'_margin_bottom',  $_POST[$prefix.'_margin_bottom'] );
	else
	delete_post_meta($post_id, $prefix.'_margin_bottom');
	
	if( isset( $_POST[$prefix.'_parallax'] ) )
	update_post_meta( $post_id, $prefix.'_parallax',  $_POST[$prefix.'_parallax'] );
	else
	delete_post_meta($post_id, $prefix.'_parallax');
	
	if( isset( $_POST[$prefix.'_parallax_speed'] ) )
	update_post_meta( $post_id, $prefix.'_parallax_speed',  $_POST[$prefix.'_parallax_speed'] );
	else
	delete_post_meta($post_id, $prefix.'_parallax');
	
	if( isset( $_POST[$prefix.'_overlay'] ) )
	update_post_meta( $post_id, $prefix.'_overlay',  $_POST[$prefix.'_overlay'] );
	else
	delete_post_meta($post_id, $prefix.'_overlay');
	
	if( isset($_POST[$prefix.'_fullwidth'] ) )
	update_post_meta( $post_id, $prefix.'_fullwidth', $_POST[$prefix.'_fullwidth'] );
	else
	delete_post_meta( $post_id, $prefix.'_fullwidth' );
	
	if( isset($_POST[$prefix.'_border_top_color'] ) )
	update_post_meta( $post_id, $prefix.'_border_top_color', $_POST[$prefix.'_border_top_color'] );
	else
	delete_post_meta( $post_id, $prefix.'_border_top_color' );
	
	if( isset($_POST[$prefix.'_border_bottom_color'] ) )
	update_post_meta( $post_id, $prefix.'_border_bottom_color', $_POST[$prefix.'_border_bottom_color'] );
	else
	delete_post_meta( $post_id, $prefix.'_border_bottom_color' );
	
	
	if( isset($_POST[$prefix.'_textshadow'] ) )
	update_post_meta( $post_id, $prefix.'_textshadow', $_POST[$prefix.'_textshadow'] );
	else
	delete_post_meta( $post_id, $prefix.'_textshadow' );
	
	
	if( isset($_POST[$prefix.'_custom_css'] ) )
	update_post_meta( $post_id, $prefix.'_custom_css', $_POST[$prefix.'_custom_css'] );
	else
	delete_post_meta( $post_id, $prefix.'_custom_css' );
	
	
		
}