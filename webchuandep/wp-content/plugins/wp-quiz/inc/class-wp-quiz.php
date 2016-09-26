<?php
/**
 * Generic WP_Quiz class. Extended by library specific classes.
 */
class WP_Quiz {

	/**
	 * quiz ID
	 */
	public $id = 0;
	
	/**
	 * quiz settings
	 */
	public $settings = array();
	
	/**
	 * quiz questions
	 */
	public $questions = array(); 
	
	/**
	 * quiz results
	 */
	public $results = array(); 
	
	/**
	 * quiz type
	 */
	public $type = '';
	
	/**
	 * unique identifier
	 */
	public $identifier = 0; 
	
	/**
     * Constructor
     */
    public function __construct( $id ) {
        
		$this->id 		= $id;
		$this->settings 	= get_post_meta( $id, 'settings', true );
		$this->questions 	= get_post_meta( $id, 'questions', true );
		$this->results 		= get_post_meta( $id, 'results', true );
		$this->type			= get_post_meta( $id, 'quiz_type', true );
		$this->identifier 	= 'wp_quiz_' . $this->id;
		
    }
	
	/**
     * @return string unique identifier for quiz
     */
	protected function get_identifier() {
		return $this->identifier;
	}
	
	/**
     * Output the HTML
     *
     * @return string HTML
     */
	public function render_public_quiz() {
        
		$html[] = '<!-- wp quiz -->';
		$html[] = '<div class="wq_quizCtr ' . $this->settings[ 'question_layout' ] . ' ' . $this->type . '_quiz" ' . $this->get_data_attrs() . '>';
		$html[] = '   	<div class="wq_quizProgressBarCtr">';
		$html[] = '        ' . $this->get_html_progress_bar();
		$html[] = '   	</div>';
		$html[] = '   	<div class="wq_questionsCtr" >';
		$html[] = '        ' . $this->get_html_questions();
		$html[] = '   	</div>';
		$html[] = '   	<div class="wq_resultsCtr">';
		$html[] = '        ' . $this->get_html_results();
		$html[] = '   	</div>';
		$html[] = '   	<!-- promote link -->';
		$html[] = '        ' . $this->get_html_promote_link();
		$html[] = '   	<!--// promote link-->';
		$html[] = '   	<!-- retake button -->';
		$html[] = '        ' . $this->get_html_retake_button();
		$html[] = '   	<!--// retake button-->';
		$html[] = '</div>';
		$html[] = '<!--// wp quiz-->';
		
		$wp_quiz = implode( "\n", $html );

        $wp_quiz = apply_filters( 'wp_quiz_output', $wp_quiz, $this->id, $this->settings );

        return $wp_quiz;
	}
	
	public function get_data_attrs(){
		
		$data = '';
		$data .= 'data-current-question="0" ';
		$data .= 'data-questions-answered="0" ';
		$data .= 'data-questions="' .count( $this->questions ). '" ';
		$data .= 'data-transition_in="' . $this->settings[ 'animation_in' ] . '" ';
		$data .= 'data-transition_out="' . $this->settings[ 'animation_out' ] . '" ';
		$data .= 'data-correct-answered="0" ';
		$data .= 'data-quiz-pid="' . $this->id . '" ';
		$data .= 'data-share-url="' . get_permalink( $this->id ) . '" ';
		$data .= 'data-post-title="' . get_the_title( $this->id ) . '" ';
		$data .= 'data-retake-quiz="' . $this->settings[ 'restart_questions' ]. '" ';
		$data .= 'data-question-layout="' . $this->settings[ 'question_layout' ]. '" ';
		$data .= 'data-featured-image="' . wp_get_attachment_url( get_post_thumbnail_id( $this->id ) ) . '" ';
		$data .= 'data-excerpt="' . get_post_field( 'post_excerpt', $this->id ) . '"';
		$data .= 'data-ajax-url="' . admin_url( 'admin-ajax.php' ) . '"';
		$data .= 'data-auto-scroll="' . $this->settings[ 'auto_scroll' ]. '" ';
		
		$data = apply_filters( 'wp_quiz_data_attrs', $data, $this->id, $this->settings );
		
		return $data;
	}
	
	public function get_html_progress_bar(){
		
		$display = $this->settings[ 'question_layout' ] == 'single' ? 'none' : 'block';
		$display = $this->type == 'swiper' ? 'none' : $display;
		$html[] = '<!-- progress bar -->';
		$html[] = 	'<div class="wq_quizProgressBarCtr" style="display:'.$display.'">';
		$html[] =		'<div class="wq_quizProgressBar">';
		$html[] =			'<span style="background-color:' .$this->settings[ 'bar_color' ]. '" class="wq_quizProgressValue"></span>';
		$html[] =		'</div>';
		$html[] = 	'</div>';
		$html[] = '<!--// progress bar-->';
		
		$progress_bar = implode( "\n", $html );
		
		return $progress_bar;
	}
	
	public function get_html_share(){
		
		$html[] = '<!-- social share -->';
		$html[] = 	'<div class="wq_shareCtr">';
		if( isset( $this->settings[ 'share_buttons' ] ) ){	
			$share_buttons = $this->settings[ 'share_buttons' ];
			$html[] =		'<p style="font-size:14px;">' . __( 'Share your Results :', 'wp-quiz') . '</p>';
			if( in_array( 'fb', $share_buttons ) ){
				$html[] =	'<button class="wq_shareFB"><span>' . __( 'Facebook', 'wp-quiz') . '</span></button>';
			}
			if( in_array( 'tw', $share_buttons ) ){
				$html[] =	'<button class="wq_shareTwitter"><span>' . __( 'Twitter', 'wp-quiz') . '</span></button>';
			}
			if( in_array( 'g+', $share_buttons ) ){
				$html[] =	'<button class="wq_shareGP"><span>' . __( 'Google+', 'wp-quiz') . '</span></button>';
			}
			if( in_array( 'vk', $share_buttons ) ){
				$html[] =	'<button class="wq_shareVK"><span>' . __( 'VK', 'wp-quiz') . '</span></button>';
			}
		}
		$html[] = 	'</div>';
		$html[] = '<!--// social share-->';
		
		$social_shares = implode( "\n", $html );
		
		$social_shares = apply_filters( 'wp_quiz_shares', $social_shares, $this->id, $this->settings );
		
		return $social_shares;
	
	}

	public function get_html_promote_link(){

		$promote_plugin = $this->settings[ 'promote_plugin' ];
		$html = array();
		if( $promote_plugin ){
			$html[] = '<div style="width:100%;text-align:right;" class="wq_promoteQuizCtr" >';
			$html[] = 	'<span style="font-size:11px;">' . __( 'Powered by ', 'wp-quiz' ) . '<a href="https://mythemeshop.com/plugins/wp-quiz/" target="_blank">' . __( 'WordPress Quiz Plugin', 'wp-quiz' ) . '</a></span>';
			$html[] = '</div>';
		}
		
		$promote_link = implode( "\n", $html );
		$promote_link = apply_filters( 'wp_quiz_promote_plugin', $promote_link, $this->id, $this->settings );
		
		return $promote_link;
	}
	
	public function get_html_retake_button(){
		
		$html[] = '<div class="wq_retakeQuizCtr" >';
		$html[] = 	'<button style="display:none;" class="wq_retakeQuizBtn"><i class="fa fa-undo"></i>&nbsp;' . __( 'PLAY AGAIN !', 'wp-quiz' ) . '</button>';
		$html[] = '</div>';
		
		$retake_button = implode( "\n", $html );
		
		$retake_button = apply_filters( 'wp_quiz_capture_email', $retake_button, $this->id, $this->settings );
		
		return $retake_button;
	}
	
	/**
	 * Include quiz assets
     */
	public function enqueue_scripts() {
		
		wp_enqueue_script( 'wp_quiz-front-js', WP_QUIZ_ASSETS_URL . 'js/main.min.js', array( 'jquery', 'semantic-transition-js', 'semantic-embed-js', 'flip-js' ), WP_QUIZ_VERSION );
		wp_enqueue_script( 'semantic-transition-js', WP_QUIZ_ASSETS_URL . 'js/transition.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
		wp_enqueue_script( 'semantic-embed-js', WP_QUIZ_ASSETS_URL . 'js/embed.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
		wp_enqueue_script( 'flip-js', WP_QUIZ_ASSETS_URL . 'js/jquery.flip.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
		
		wp_localize_script( 'wp_quiz-front-js', 'wq_l10n', array(
				'correct' 				=> __( 'Correct !', 'wp-quiz' ),
				'wrong'					=> __( 'Wrong !', 'wp-quiz' ),
				'captionTrivia' 		=> __( 'You got %%score%% of %%total%%', 'wp-quiz' ),
				'captionPersonality' 	=> __( 'You\'re %%personality%%', 'wp-quiz' ),
				'captionTriviaFB'		=> __( 'I got %%score%% of %%total%%, and you?', 'wp-quiz' ),
				'captionPersonalityFB'	=> __( 'I\'m %%personality%%, and you are?', 'wp-quiz' ),
			) 
		);
		// this will be added to the bottom of the page as <head> has already been processed by WordPress sorry.
		wp_enqueue_style( 'semantic-transition-css', WP_QUIZ_ASSETS_URL . 'css/transition.min.css', array(), WP_QUIZ_VERSION );
		wp_enqueue_style( 'semantic-embed-css', WP_QUIZ_ASSETS_URL . 'css/embed.min.css', array(), WP_QUIZ_VERSION );
		//wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', false, WP_QUIZ_VERSION );
		wp_enqueue_style( 'traditional-skin-css', WP_QUIZ_ASSETS_URL . 'css/traditional-skin.css', array(), WP_QUIZ_VERSION );
		wp_enqueue_style( 'wp_quiz-front-css', WP_QUIZ_ASSETS_URL . 'css/main.css', false, WP_QUIZ_VERSION );
		
		do_action( 'wp_quiz_register_public_styles' );
	}
}