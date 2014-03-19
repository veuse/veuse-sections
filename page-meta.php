<?php

/* Post meta
=========================================================== */

add_action( 'add_meta_boxes', 'veuse_sections_meta_box_add' );

function veuse_sections_meta_box_add()
{
	add_meta_box( 'veuse_sections_meta', __('Page sections','veuse-sections'), 'veuse_sections_meta_box_cb', 'page', 'normal', 'high' );
}

function veuse_sections_meta_box_cb( $post )
{
	$prefix = 'veuse_sections';
	
	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'post_title',
		'order'            => 'DESC',
		'post_type'        => 'sections',
		'post_status'      => 'publish',

	); 
	
	$sections = get_posts($args);

	$blocks_above = get_post_meta($post->ID, $prefix.'_blocks_above', true);
	$blocks_below = get_post_meta($post->ID, $prefix.'_blocks_below', true);

	wp_nonce_field( 'veuse_sections_nonce', 'meta_box_nonce' );?>
	
	<div class="clearfix">

		
		<p><?php _e('Add section to your page. You can order the sections via drag and drop. These sections can be added before and after your page-content, and is not part of the page editor-content.','veuse-sections');?></p>
		
			
			<div class="half">
			<h3><?php _e('Sections above content area','veuse-sections');?></h3>
		
		
			<select id="blocks_above" name="<?php echo $prefix;?>_blocks_above[]" class="multiselect" multiple="multiple" >
				<?php foreach ($sections as $section){
					
					if(!in_array($section->ID, $blocks_above)){
						echo '<option value="'.$section->ID.'">'.$section->post_title.'</option>';
					}
				}?>
				
				<?php foreach ($blocks_above as $section){
					
					if( in_array($section, $blocks_above )){
						echo '<option value="'.$section.'" selected="selected">'.get_the_title($section).'</option>';
					}
				}?>

			</select>
			
			</div>
			<div class="half">
		<h3><?php _e('Sections below content area','veuse-sections');?></h3>
			
		
			<select id="blocks_below" name="<?php echo $prefix;?>_blocks_below[]" class="multiselect" multiple="multiple" >
				<?php foreach ($sections as $section){
					
					if(!in_array($section->ID, $blocks_below)){
						echo '<option value="'.$section->ID.'">'.$section->post_title.'</option>';
					}
				}?>
				
				<?php foreach ($blocks_below as $section){
					
					if( in_array($section, $blocks_below )){
						echo '<option value="'.$section.'" selected="selected">'.get_the_title($section).'</option>';
					}
				}?>
			</select>
			</div>
				
			
	</div>

	
	 <script>
  
  jQuery(function(){
             jQuery("#blocks_above").multiselect();
             jQuery("#blocks_below").multiselect();
                        
     });
  </script>
	
	
	<?php }




add_action( 'save_post', 'veuse_sections_meta_box_save' );


function veuse_sections_meta_box_save( $post_id ){

	$prefix = 'veuse_sections';

	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'veuse_sections_nonce' ) ) return;

	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_posts' ) ) return;

	// now we can actually save the data
	$allowed = array(
		'a' => array( // on allow a tags
			'href' => array() // and those anchors can only have href attribute
		)
	);

	// Probably a good idea to make sure your data is set
	if( isset( $_POST[$prefix.'_blocks_above'] ) )
	update_post_meta( $post_id, $prefix.'_blocks_above',  $_POST[$prefix.'_blocks_above'] );
	else
	delete_post_meta($post_id, $prefix.'_blocks_above');
	
	if( isset( $_POST[$prefix.'_blocks_below'] ) )	
	update_post_meta( $post_id, $prefix.'_blocks_below',  $_POST[$prefix.'_blocks_below'] );
	else
	delete_post_meta($post_id, $prefix.'_blocks_below');
		


	/*
	if( isset( $_POST[$prefix.'_select'] ) )
		update_post_meta( $post_id, $prefix.'_select', esc_attr( $_POST[$prefix.'_select'] ) );
	*/

}