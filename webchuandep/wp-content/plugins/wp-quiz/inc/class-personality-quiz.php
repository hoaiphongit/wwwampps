<?php
/**
 * Override parent 'WP_Quiz' class with personality quiz specific markup,
 * 
 */
class WP_Quiz_Personality_Quiz extends WP_Quiz {
	
	public function get_html_questions(){
		
		$questionsHTML 	= '';
		
		if( !empty( $this->questions ) ){
			if( $this->settings[ 'question_layout' ] == 'single' ){
				$ad_display = 'block';
				$display_continue = 'none';
			}else{
				$ad_display = 'none';
				$display_continue = 'block';
			}

			foreach( $this->questions as $key => $question ){
				$mediaHTML = '';
				if( $question[ 'mediaType' ] == 'image' ){
					if( !empty( $question[ 'image' ] ) ) {
						$mediaHTML = '<div class="wq_questionImage"><img src="' . $question[ 'image' ] . '" /><span>'.$question[ 'imageCredit' ].'</span></div>';
					}
				} else if ( $question[ 'mediaType' ] == 'video' ){
					if( !empty( $question[ 'video' ] ) ){
						if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $question[ 'video' ], $match ) ){
							if( !empty( $match[ 1 ] ) ){
								$mediaHTML = '<div class="ui embed media-'.$key.'" data-source="youtube" data-id="' . $match[ 1 ] . '"  data-placeholder="'.$question[ 'imagePlaceholder' ].'" data-icon="video play"></div>';
							}
						} else if ( preg_match( '#(?:https?://)?(?:www.)?(?:player.)?vimeo.com/(?:[a-z]*/)*([0-9]{6,11})[?]?.*#', $question[ 'video' ], $match ) ) {
							if( !empty( $match[ 1 ] ) ){
								$mediaHTML = '<div class="ui embed media-'.$key.'" data-source="vimeo" data-id="' . $match[ 1 ] . '"  data-placeholder="'.$question[ 'imagePlaceholder' ].'" data-icon="video play"></div>';
							}
						} else {
							$mediaHTML = '<div class="ui embed media-'.$key.'" data-url="'.$question[ 'video' ].'" data-placeholder="'.$question[ 'imagePlaceholder' ].'" data-icon="video play"></div>';
						}
						$autoplay = !empty( $question[ 'imagePlaceholder' ] ) ? 'true':'false';
						$mediaHTML .= '<script>jQuery(document).ready(function($){$(".ui.media-'.$key.'").embed({"autoplay":'.$autoplay.'});});</script>'; 
					}
				}
			
				$answersHTML = '';
				if( isset( $question[ 'answers' ] ) ){	
					if( $this->settings[ 'rand_answers' ] ) {
						shuffle( $question[ 'answers' ] );
					}
					$answersHTML    =   '<div class="wq_answersWrapper">';
					$answersHasImage = false;
					foreach( $question[ 'answers' ] as $answer ){
						if( !empty( $answer[ 'image' ] ) ) {
							$answersHasImage = true;
							$answersHTML = '';
							$answersHTML = '<div class="wq_answersWrapper">';
							break;
						}
						$answersHTML .= '
							<div class="wq_singleAnswerCtr wq_IsPersonality" style="background-color:'.$this->settings[ 'background_color' ].'; color:' . $this->settings[ 'font_color' ] . ';">
								<textarea style="display:none;" class="wq_singleAnswerResultCtr" >' . json_encode( isset( $answer[ 'results' ] ) ? $answer[ 'results' ] : '' ) . '</textarea>
								<label class="wq_answerTxtCtr">' . $answer[ 'title' ] . '</label>
							</div>
						';
					}
				
					if( $answersHasImage ){
						$cols = apply_filters( 'wp_quiz_img_answer_cols', 3 ); // 2 columns if anything else is passed
						if ( 3 === $cols ) {
							$col_class = 'col-md-wq-4';
						} else {
							$col_class = 'col-md-wq-6';
							$cols = 2;
						}
						$i=0;
						$answersHTML .= '<div class="row">';
						foreach( $question[ 'answers' ] as $answer ){
							$answerImgHTML      =   '';
							$answerTitle = '';
							$answerImgHTML = '<div class="wq_answerImgCtr"><img src="' . $answer[ 'image' ] . '"></div>';
							$answerTitle = empty( $answer[ 'title' ] ) ? '&nbsp;' : $answer[ 'title' ];
							$answersHTML .= '
								<div class="'.$col_class.'">
									<div class="wq_singleAnswerCtr wq_IsPersonality" style="background-color:'.$this->settings[ 'background_color' ].'; color:' . $this->settings[ 'font_color' ] . ';">
										<textarea style="display:none;" class="wq_singleAnswerResultCtr" >' . json_encode( isset( $answer[ 'results' ] ) ? $answer[ 'results' ] : '' ) . '</textarea>
										' . $answerImgHTML . '
										<label class="wq_answerTxtCtr">' . $answerTitle . '</label>
									</div>
								</div>
							';
							$i++;
							if ( $i%$cols == 0 ) 
								$answersHTML .= '</div><div class="row">';
						}
						$answersHTML .= '</div>';
					}
					$answersHTML .=   '</div>';
				}
				
				$display = $key == 0 ? 'block' : 'none';
				if( $this->settings[ 'question_layout' ] == 'single' ){
					$display = 'block';
				}
				$questionsHTML .= '
					<div class="wq_singleQuestionWrapper wq_IsPersonality" data-question-answered="1" style="display:'.$display.';">
						<div class="wq_singleQuestionCtr">
							<div class="wq_questionTextWrapper quiz-clearfix">
								<div class="wq_questionTextCtr" style="background-color:'.$this->settings[ 'background_color' ].'; color:' . $this->settings[ 'font_color' ] . ';"> 
									<h4>'. $question[ 'title' ] . '</h4>
								</div>
							</div>
							<div class="wq_questionMediaCtr">	
								' . $mediaHTML . '
							</div>
							<div class="wq_questionAnswersCtr">
								' . $answersHTML. '
							</div>
							<span class="wq_retakeQuestionPlaceholder" data-bg-color="" data-font-color=""></span>
						</div>
						<div class="wq_continue" style="display:none;">
							<button class="wq_btn-continue">'.__( 'Continue &gt;&gt;', 'wp-quiz' ).'</button>
						</div>
					</div>
				';	
			}
		}
		return $questionsHTML;
	}
	
	public function get_html_results(){
		
		$resultsHTML = '';
		$shareHTML = $this->get_html_share();
		if( !empty( $this->results ) ){
			for( $i = 0; $i < count( $this->results ); $i++ ){
				$resultImgHTML = '';
				if( !empty( $this->results[ $i ][ 'image' ] ) ){
					$resultImgHTML = '<p><img class="wq_resultImg" src="' . $this->results[ $i ][ 'image' ] . '"/></p>';
				}
				$resultsHTML .= '
					<div style="display:none;" class="wq_singleResultWrapper wq_IsPersonality" data-points="0" data-rid="' . $i . '">
						<span class="wq_quizTitle">' . get_the_title( $this->id ) . '</span>
						<div class="wq_resultTitle" data-title="' . $this->results[ $i ][ 'title' ] . '"></div>
						' . $resultImgHTML .  '
						<div class="wq_resultDesc">' . $this->results[ $i ][ 'desc' ] . '</div>
						' . $shareHTML . '
					</div>
				';
			}
		}
		
		return $resultsHTML;
	}
}