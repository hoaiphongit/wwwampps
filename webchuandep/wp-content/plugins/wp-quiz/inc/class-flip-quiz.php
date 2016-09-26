<?php
/**
 * Override parent 'WP_Quiz' class with flip quiz specific markup,
 * 
 */
class WP_Quiz_Flip_Quiz extends WP_Quiz {
	
	public function get_html_questions(){
		
		$questionsHTML 	= '';
		
		if( !empty( $this->questions ) ){				
			$custom_class = '';
			$image_height = '';
			$height = 'auto;';
			$width = '100%;';
			$css_height = '';
			if( isset( $this->settings[ 'size' ] ) && $this->settings[ 'size' ] == 'custom' ) {
				if( isset( $this->settings[ 'custom_height' ] ) && !empty( $this->settings[ 'custom_height' ] ) ){
					$height = $this->settings[ 'custom_height' ] . 'px;';
					$front_height = $this->settings[ 'custom_height' ] - 52;
					$custom_class = 'custom';
					$image_height = 'height: 100% !important;';
					$css_height   = '.wq_IsFlip .front.custom, .wq_IsFlip .back.custom{height: '. $front_height. 'px !important}';
				}
				if( isset( $this->settings[ 'custom_width' ] ) && !empty( $this->settings[ 'custom_width' ] ) ){
					$width = $this->settings[ 'custom_width' ] . 'px;';
				}				
				$questionsHTML .= '<style>@media screen and (max-width:' . $this->settings[ 'custom_width' ] . 'px){.wq_singleQuestionWrapper{width:100%!important;height:auto!important}}'. $css_height .'</style>';
			}
			$style = 'width:' . $width . 'height:'.  $height;
			
			foreach( $this->questions as $key => $question ){
				$position = $key + 1;
				$desc = !empty( $question[ 'desc' ] ) ? '<div class="desc"><div>' . $question[ 'desc' ] . '</div></div>' : '';
				
				$questionsHTML .= '<div class="wq_singleQuestionWrapper wq_IsFlip" style="margin-left:auto;margin-right:auto;'.$style.'">
					<div class="item_top">
						<div class="title_container">
							<div class="wq_questionTextCtr" style="color:'.$this->settings[ 'font_color' ].'">
								<h4>' . $question[ 'title' ] . '</h4>
							</div>
						</div>
					</div>
					<div class="front '.$custom_class.'">
						<img style="'.$image_height.'" src="' . $question[ 'image' ] . '" /><span class="credits">'.$question[ 'imageCredit' ].'</span>
						<span class="desc">' . __( 'Click to Flip', 'wp-quiz' ) . '</span>
					</div>
					<div class="back '.$custom_class.'"> 
						<img style="'.$image_height.'" src="' . $question[ 'backImage' ] . '" /><span class="credits">'.$question[ 'backImageCredit' ].'</span>
						' . $desc . '
					</div></div>';
			}

		}
		return $questionsHTML;
	}
	
	public function get_html_results(){
		
		if( isset( $this->settings[ 'share_buttons' ] ) && !empty( $this->settings[ 'share_buttons' ] ) ){	
			$shareHTML = $this->get_html_share();
			$resultsHTML = '<div class="wq_singleResultWrapper" style="display:block;">' . $shareHTML . '</div>'; 
			$str_to_remove = __( 'Share your Results :', 'wp-quiz');
			return str_replace( $str_to_remove, '', $resultsHTML );
		}
		
	}
}