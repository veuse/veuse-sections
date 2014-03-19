<?php

		/* Section meta */
		
		$skin = get_post_meta($section->ID,'veuse_section_skin',true);
		$textshadow = get_post_meta($section->ID,'veuse_section_textshadow',true);

		$customCss = get_post_meta($section->ID,'veuse_section_custom_css',true);
		$bgColor = get_post_meta($section->ID,'veuse_section_background_color',true);
		$bgRepeat = get_post_meta($section->ID,'veuse_section_background_repeat',true);
		$bgPosition = get_post_meta($section->ID,'veuse_section_background_position',true);
		$background_image = get_post_meta($section->ID,'veuse_section_background_image',true);
		//$background_image_src = wp_get_attachment_image_src( $background_image, 'full' );
		
		$paddingTop	 = get_post_meta($section->ID,'veuse_section_padding_top',true);
		$paddingBottom  = get_post_meta($section->ID,'veuse_section_padding_bottom',true);
		
		$marginBottom  = get_post_meta($section->ID,'veuse_section_margin_bottom',true);
		
		$borderBottomColor  = get_post_meta($section->ID,'veuse_section_border_bottom_color',true);
		$borderTopColor  = get_post_meta($section->ID,'veuse_section_border_top_color',true);
		
		$fullwidth  = get_post_meta($section->ID,'veuse_section_fullwidth',true);
		$parallax  = get_post_meta($section->ID,'veuse_section_parallax',true);
		$parallax_speed  = get_post_meta($section->ID,'veuse_section_parallax_speed',true);
		
		$overlay  = get_post_meta($section->ID,'veuse_section_overlay',true);
		
				
		if(!empty($skin)){
			$skinStr = $skin;
		} else {
			$skinStr = '';
		}
		
		if($textshadow == 'on'){
			$shadowStr = 'textshadow';
		} else {
			$shadowStr = '';
		}

		if(!empty($background_image)){
			$imagestring = 'background-image: url('.$background_image.');';
		} else {
			$imagestring = '';
		}
		
		if(!empty($bgColor)){
			$bgColorStr = 'background-color:'.$bgColor.';';
		} else {
			$bgColorStr = '';
		}
		
		if(!empty($borderBottomColor)){
			$borderBottomColorStr = 'border-bottom:1px solid '.$borderBottomColor.';';
		} else {
			$borderBottomColorStr = '';
		}
		
		if(!empty($borderTopColor)){
			$borderTopColorStr = 'border-top:1px solid '.$borderTopColor.';';
		} else {
			$borderTopColorStr = '';
		}
		
		if(!empty($bgRepeat)){
			$bgRepeatStr = 'background-repeat:'.$bgRepeat.';';
		} else {
			$bgRepeatStr = '';
		}
		
		if(!empty($bgPosition)){
			$bgPositionStr = 'background-position:'.$bgPosition.';';
		} else {
			$bgPositionStr = '';
		}
		
		if(isset($paddingTop)){
			$paddingTopStr = 'padding-top:'.$paddingTop.'px;';
		} else {
			$paddingTopStr = '';
		}
		
		if(isset($paddingBottom)){
			$paddingBottomStr = 'padding-bottom:'.$paddingBottom.'px;';
		} else {
			$paddingBottomStr = '';
		}
		
		if(!empty($overlay)){
			$overlayStr = '<span class="section-overlay overlay-'.$overlay.'"></span>';
		} else {
			$overlayStr = '';
		}
		
		if(!empty($marginBottom)){
			$marginBottomStr = 'margin-bottom:'.$marginBottom.'px;';
		} else {
			$marginBottomStr = '';
		}
		
		if($parallax == 'on'){
			$parallaxStr = 'parallax';
		} else {
			$parallaxStr = '';
		}
		
		
		
	
?>
<style>

	#veuse-section-<?php echo $section->ID;?>{		
		<?php echo $imagestring;?> 
		<?php echo $borderBottomColorStr;?> 
		<?php echo $borderTopColorStr;?> 
		<?php echo $bgColorStr;?> 
		<?php echo $bgPositionStr;?> 
		<?php echo $bgRepeatStr;?> 
		<?php echo $paddingTopStr;?> 
		<?php echo $paddingBottomStr;?> 
		<?php echo $marginBottomStr; ?>				
	}
	
	<?php echo $customCss;?>

</style>

<div id="veuse-section-<?php echo $section->ID;?>" class="veuse-section-block veuse-section-block-<?php echo $skinStr;?> <?php echo $parallaxStr; ?> <?php echo $shadowStr;?> " data-speed="">

	<?php echo $overlayStr;?>
	
	<?php if($fullwidth != 'yes'){?>
	<div class="row">
		<div class="column">
		<?php } ?>
			<?php 
				$content = $section->post_content;
						
				if(function_exists('siteorigin_panels_setting')){
					if ( in_array( $post->post_type, siteorigin_panels_setting('post-types') ) ) {
						$panel_content = siteorigin_panels_render( $section->ID );
						if ( !empty( $panel_content ) )  
							$content = $panel_content;
						
					} else {
						
						
						$content = get_the_content();
					}
				}
						
				echo do_shortcode($content);												
			?>
			<?php if($fullwidth != 'yes'){?>			
		</div>
		
	</div>
	<?php } ?>
	
	
	<?php if($parallax == 'on'):?>
	<script>
	jQuery(function($){
		jQuery('.parallax').parallax({	
			speed: <?php echo $parallax_speed;?>
		});
	});
	</script>
	
	<?php endif;?>
	
</div>