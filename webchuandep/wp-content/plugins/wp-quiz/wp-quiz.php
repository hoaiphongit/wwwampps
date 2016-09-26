<?php
/*
 * Plugin Name: WP Quiz
 * Plugin URI:  https://mythemeshop.com/plugins/wp-quiz/
 * Description: WP Quiz makes it incredibly easy to add professional, multimedia quizzes to any website! Fully feature rich and optimized for social sharing. Make your site more interactive!
 * Version:     1.0.3
 * Author:      MyThemeShop
 * Author URI:  https://mythemeshop.com/
 *
 * Text Domain: wp-quiz
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // disable direct access
}

if ( ! class_exists( 'WP_Quiz_Plugin' ) ) :


/**
 * Register the plugin.
 *
 * Display the administration panel, insert JavaScript etc.
 */
class WP_Quiz_Plugin {
	
	/**
     * @var string
     */
    public $version = '1.0.3';

	/**
	 * @var WP Quiz
	 */
	public $quiz = null;
	
	/**
	 * Init
	 */
	public static function init() {

		$wp_quiz = new self();

	}
	
	/**
     * Constructor
     */
    public function __construct() {

		$this->define_constants();
		$this->includes();
		$this->setup_actions();
		$this->setup_filters();
		$this->setup_shortcode();

	}
	
	/**
	 * Define WP Quiz constants
	 */
	private function define_constants() {

		define( 'WP_QUIZ_VERSION',    $this->version );
		define( 'WP_QUIZ_BASE_URL',   trailingslashit( plugins_url( 'wp-quiz' ) ) );
		define( 'WP_QUIZ_ASSETS_URL', trailingslashit( WP_QUIZ_BASE_URL . 'assets' ) );
		define( 'WP_QUIZ_PATH',       plugin_dir_path( __FILE__ ) );

	}
	
	/**
     * Load required classes
	 */
    private function includes() {
	
		//auto loader
		spl_autoload_register( array( $this, 'autoloader' ) );

	}
	
	/**
     * Autoload classes 
     */
    public function autoloader( $class ) {

        $dir = WP_QUIZ_PATH . 'inc' . DIRECTORY_SEPARATOR;
		$class_file_name = 'class-' . str_replace( array( 'wp_quiz_', '_' ), array( '', '-' ), strtolower( $class ) ) . '.php';
		if ( file_exists( $dir . $class_file_name ) ) {
			require $dir . $class_file_name;
		}

	}
	
	/**
     * Register the [wp_quiz] shortcode.
     */
	private function setup_shortcode() {

		add_shortcode( 'wp_quiz', array( $this, 'register_shortcode' ) );
		
	}
	
	/**
	 * Hook WP Quiz into WordPress
	 */
	private function setup_actions() {

		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 10 );
		add_action( 'wp_head', array( $this, 'wp_quiz_head' ), 1 );
		add_action( 'wp_quiz_admin_page', array( $this, 'admin_import_export' ), 2 );
		
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'enter_title_here', array( $this, 'enter_title_here' ) );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		add_action( 'manage_wp_quiz_posts_custom_column', array( $this, 'manage_wp_quiz_columns' ), 10, 2 );
		add_action( 'edit_form_after_title', array( $this, 'add_shortcode_before_editor' ) );
		
		//Save form posts
		add_action( 'admin_post_wp_quiz', array( $this, 'save_post_form' ) );
		
		//Ajax
		add_action( 'wp_ajax_wq_quizResults', array( $this, 'wp_quiz_results' ) );
		add_action( 'wp_ajax_nopriv_wq_quizResults', array( $this, 'wp_quiz_results' ) );
		add_action( 'wp_ajax_wq_submitInfo', array( $this, 'wp_quiz_user_info' ) );
		add_action( 'wp_ajax_nopriv_wq_submitInfo', array( $this, 'wp_quiz_user_info' ) );
		
		add_action( 'wp_ajax_check_image_file', array( $this, 'wp_quiz_check_image_file' ) );
		add_action( 'wp_ajax_check_video_file', array( $this, 'wp_quiz_check_video_file' ) );
	}
	
	/**
	 * Hook WP Quiz into WordPress
	 */
	private function setup_filters() {
		
		add_filter( 'manage_edit-wp_quiz_columns', array(  $this, 'add_new_wp_quiz_columns' ) );
		add_filter( 'screen_layout_columns', array( $this, 'on_screen_layout_columns'), 10, 2 );
		add_filter( 'the_content', array( $this, 'create_quiz_page' ) );
	}
	
	/**
     * Register Quiz post type
	 */
	public static function register_post_type() {
		
		$labels = array(
			'name'               => __( 'WP Quiz', 'wp-quiz' ),
			'menu_name'          => __( 'WP Quiz', 'wp-quiz' ),
			'singular_name'      => __( 'WP Quiz', 'wp-quiz' ),
			'name_admin_bar'     => _x( 'WP Quiz', 'name admin bar', 'wp-quiz' ),
			'all_items'          => __( 'All Quizzes', 'wp-quiz' ),
			'search_items'       => __( 'Search Quizzes', 'wp-quiz' ),
			'add_new'            => _x( 'Add New', 'quiz', 'wp-quiz' ),
			'add_new_item'       => __( 'Add New WP Quiz', 'wp-quiz' ),
			'new_item'           => __( 'New Quiz', 'wp-quiz' ),
			'view_item'          => __( 'View Quiz', 'wp-quiz' ),
			'edit_item'          => __( 'Edit Quiz', 'wp-quiz' ),
			'not_found'          => __( 'No Quizzes Found.', 'wp-quiz' ),
			'not_found_in_trash' => __( 'WP Quiz not found in Trash.', 'wp-quiz' ),
			'parent_item_colon'  => __( 'Parent Quiz', 'wp-quiz' ),
		);
		
		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Holds the quizzes and their data.', 'wp-quiz' ),
			'menu_position'      => 5,
			'menu_icon'			 => 'dashicons-editor-help',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'author', 'thumbnail', 'excerpt' ),
		);
		
		register_post_type( 'wp_quiz', $args );
		/*
		if ( false === get_option('wp_quiz_version') ) {
			flush_rewrite_rules();
			update_option('wp_quiz_version', WP_QUIZ_VERSION );
		}
		*/
	}

	/**
	 * Fix permalinks on plugin activation
     */
	public static function flush_rewrites() {
		self::register_post_type();
		flush_rewrite_rules();
	}
	
	/**
	 * Add meta boxes
     */
	public function add_meta_boxes(){
		
		add_meta_box(
			'quiz-content',
			_x( 'Quiz', 'metabox title', 'wp-quiz' ),
			array( $this, 'quiz_content_meta_box' ),
			'wp_quiz',
			'normal',
			'high'
		);
		
	}
	
	/**
	 * Add meta boxes content
     */
	public function quiz_content_meta_box() {
		
		$quiz_type = get_post_meta( get_the_ID(), 'quiz_type', true );
		
		$quiz_types = array(
			'trivia' 		=> __( 'Trivia', 'wp-quiz' ),
			'personality'	=> __( 'Personality', 'wp-quiz' ),
			'flip'			=> __( 'Flip Cards', 'wp-quiz' ),
		);
		
		$animations = array(
			'fade','scale', 'fade up', 'fade down', 'fade left', 'fade right', 'horizontal flip', 'vertical flip', 
			'drop', 'fly left', 'fly right', 'fly up', 'fly down', 'swing left', 'swing right', 'swing up', 
			'swing down', 'browse', 'browse right', 'slide down', 'slide up', 'slide left', 'slide right'
		);
		
		$share_buttons = array(
			'fb' => __( 'Facebook', 'wp-quiz' ),
			'tw' => __( 'Twitter', 'wp-quiz' ),
			'g+' => __( 'Google +', 'wp-quiz' ),
			'vk' => __( 'VK', 'wp-quiz' )
		);
		
		$defaults = get_option( 'wp_quiz_default_settings' );
		unset( $defaults[ 'share_meta' ] );
		
		foreach( $defaults as $key => $value ){
			
			$defaults[ $key ][ 'question_layout' ]	= 'single';
			$defaults[ $key ][ 'skin' ]				= 'traditional';
			$defaults[ $key ][ 'bar_color' ]		= '#00c479';
			$defaults[ $key ][ 'font_color' ]		= '#444';
			$defaults[ $key ][ 'background_color' ]	= '';
			$defaults[ $key ][ 'animation_in' ]		= 'fade';
			$defaults[ $key ][ 'animation_out' ]	= 'fade';
			$defaults[ $key ][ 'size' ]				= 'full';
			$defaults[ $key ][ 'custom_width' ]		= '338';
			$defaults[ $key ][ 'custom_height' ]	= '468';
		}
		
		wp_localize_script( 'wp_quiz-react', 'quiz', array(
			'types'				=>  $quiz_types,
			'typeSelected'		=>  '' === $quiz_type ? 'trivia' : $quiz_type,
			'nonce'				=>  wp_create_nonce( 'quiz-content' ),
			'questions'			=>  get_post_meta( get_the_ID(), 'questions', true ),
			'results'			=>  get_post_meta( get_the_ID(), 'results', true ),
			'settings'			=>  get_post_meta( get_the_ID(), 'settings', true),
			'defaultSettings'	=>  $defaults[ 'defaults' ],
			'animations'		=>  $animations,
			'shareButtons'		=>  $share_buttons,
			'defaultSkins'		=>  array( 'trad' => '#f2f2f2' ),
			'proImage'			=>  WP_QUIZ_ASSETS_URL . 'image/wp-quiz-pro-small.jpg',
			'proBanner'			=>  WP_QUIZ_ASSETS_URL . 'image/wp-quiz-pro.jpg',
			'proLink'			=>  'https://mythemeshop.com/plugins/wp-quiz-pro/'
		) );
		?>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$('#tabs').tab();
					$('.color-field').wpColorPicker();
				});
			</script> 
		<?php
	}
	
	/**
     * Register admin JavaScript
     */
	public function admin_enqueue_scripts( $hook ){
		
		global $typenow;
		
		if( $typenow !== "wp_quiz" ){
			return;
		}
		
		if ( $hook == "post.php" || $hook == "post-new.php" ) {
			wp_enqueue_style( 'bootstrap-grid', WP_QUIZ_ASSETS_URL . 'css/bootstrap.min.css', array(), WP_QUIZ_VERSION );
			wp_enqueue_style( 'wp_quiz-css', WP_QUIZ_ASSETS_URL . 'css/new-quiz.css', array(), WP_QUIZ_VERSION );
			wp_enqueue_style( 'semantic-checkbox-css', WP_QUIZ_ASSETS_URL . 'css/checkbox.min.css', array(), WP_QUIZ_VERSION );
			wp_enqueue_style( 'chosen-css', WP_QUIZ_ASSETS_URL . 'css/chosen.min.css', array(), WP_QUIZ_VERSION );
			wp_enqueue_style( 'semantic-embed-css', WP_QUIZ_ASSETS_URL . 'css/embed.min.css', array(), WP_QUIZ_VERSION );
		
			
			wp_enqueue_script( 'wp_quiz-react', WP_QUIZ_ASSETS_URL . 'js/content.min.js', array( 'jquery', 'semantic-checkbox-js', 'chosen-js', 'wp-color-picker', 'wp_quiz-bootstrap' ), WP_QUIZ_VERSION, true );
			wp_enqueue_script( 'wp_quiz-bootstrap', WP_QUIZ_ASSETS_URL . 'js/bootstrap.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
			wp_enqueue_script( 'semantic-checkbox-js', WP_QUIZ_ASSETS_URL . 'js/checkbox.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
			wp_enqueue_script( 'chosen-js', WP_QUIZ_ASSETS_URL . 'js/chosen.jquery.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
			wp_enqueue_script( 'semantic-embed-js', WP_QUIZ_ASSETS_URL . 'js/embed.min.js', array( 'jquery' ), WP_QUIZ_VERSION );
		
			wp_enqueue_style( 'wp-color-picker' );
			
			wp_localize_script( 'wp_quiz-react', 'l10n', array(
				'labelSelectType' 		=> 	__( 'Select Quiz Type', 'wp-quiz' ),
				'questions'				=> 	__( 'Questions', 'wp-quiz' ),
				'addQuestion'			=> 	__( 'Add Question', 'wp-quiz' ),
				'editQuestion'			=> 	__( 'Edit Question', 'wp-quiz' ),
				'results'				=> 	__( 'Results', 'wp-quiz' ),
				'addResult' 			=> 	__( 'Add Result', 'wp-quiz' ),
				'editResult' 			=> 	__( 'Edit Result', 'wp-quiz' ),
				'addAnswer' 			=> 	__( 'Add Answer', 'wp-quiz' ),
				'editAnswer'			=> 	__( 'Edit Answer', 'wp-quiz' ),
				'addExplanation' 		=> 	__( 'Add Explanation', 'wp-quiz' ),
				'editExplanation'		=> 	__( 'Edit Explanation', 'wp-quiz' ),
				'edit'					=> 	__( 'Edit', 'wp-quiz' ),
				'delete'				=> 	__( 'Delete', 'wp-quiz' ),
				'question'				=> 	_x( 'Title', 'input label', 'wp-quiz' ),
				'result'				=> 	_x( 'Result', 'input label', 'wp-quiz' ),
				'answer'				=> 	_x( 'Answer', 'input label', 'wp-quiz' ),
				'explanation'			=> 	_x( 'Explanation', 'input label', 'wp-quiz' ),
				'image'					=> 	_x( 'Image', 'input label', 'wp-quiz' ),
				'frontImage'			=> 	_x( 'Front Image', 'input label', 'wp-quiz' ),
				'backImage'				=> 	_x( 'Back Image', 'input label', 'wp-quiz' ),
				'backImageDesc'			=> 	_x( 'Back Image Description', 'input label', 'wp-quiz' ),
				'imageCredit'			=> 	_x( 'Image Credit', 'input label', 'wp-quiz' ),
				'mediaType' 			=> 	_x( 'Media Type', 'input label', 'wp-quiz' ),
				'videoUrl'				=> 	_x( 'Youtube/Vimeo/Custom URL', 'input label', 'wp-quiz' ),
				'placeholderImage'		=> 	_x( 'Image Placeholder', 'input label', 'wp-quiz' ),
				'isCorrect' 			=> 	_x( 'Is Correct Answer', 'input label', 'wp-quiz' ),
				'minCorrect' 			=> 	_x( 'Minimum Correct', 'input label', 'wp-quiz' ),
				'maxCorrect' 			=> 	_x( 'Maximum Correct', 'input label', 'wp-quiz' ),
				'minScore'				=> 	_x( 'Minimum Score', 'input label', 'wp-quiz' ),
				'maxScore'				=> 	_x( 'Maximum Score', 'input label', 'wp-quiz' ),
				'desc'					=> 	_x( 'Description', 'input label', 'wp-quiz' ),
				'shtDesc'				=> 	_x( 'Short Description', 'input label', 'wp-quiz' ),
				'lngDesc'				=> 	_x( 'Long Description', 'input label', 'wp-quiz' ),
				'pointsResult'			=>  _x( 'Points', 'input label', 'wp-quiz' ),
				'pointsExplain'			=>  __( '(Association: 0-no, 1-normal, 2-strong)', 'wp-quiz' ),
				'cancel'				=> 	__( 'Cancel', 'wp-quiz' ),
				'saveChanges' 			=> 	__( 'Save Changes', 'wp-quiz' ),
				'videoEmbed' 			=> 	__( 'Video/Custom Embed', 'wp-quiz' ),
				'noMedia'				=> 	__( 'No Media', 'wp-quiz' ),
				'generalSettings'		=> 	__( 'General Settings', 'wp-quiz' ),
				'randomizeQuestions'	=> 	__( 'Randomize Questions', 'wp-quiz' ),
				'randomizeAnswers'		=> 	__( 'Randomize Answers', 'wp-quiz' ),
				'restartQuestions'		=> 	__( 'Restart Questions', 'wp-quiz' ),
				'promote'				=> 	__( 'Promote the plugin', 'wp-quiz' ),
				'embedToggle'			=> 	__( 'Show embed code toggle', 'wp-quiz' ),
				'shareButtons'			=> 	__( 'Share buttons', 'wp-quiz' ),
				'countDown'				=>  __( 'Countdown timer [Seconds/question]', 'wp-quiz' ),
				'countExplain'			=>  __( '(Works only when multiple page layout is selected)', 'wp-quiz' ),
				'autoScroll'			=>  __( 'Auto scroll to next question (applies to one page layout)', 'wp-quiz' ),
				'forceAction'			=> 	__( 'Force action to see results', 'wp-quiz' ),
				'forceAction0'			=> 	__( 'No Action', 'wp-quiz' ),
				'forceAction1'			=> 	__( 'Capture Email', 'wp-quiz' ),
				'forceAction2'			=> 	__( 'Facebook Share', 'wp-quiz' ),
				'showAds'				=> 	__( 'Show Ads', 'wp-quiz' ),
				'adsAfterN'				=> 	__( 'Ads after every nth question', 'wp-quiz' ),
				'adCodes'				=> 	__( 'Ad Codes', 'wp-quiz' ),
				'customizeLayout'		=> 	__( 'Customize Layout and Colors', 'wp-quiz' ),
				'questionsLayout'		=> 	__( 'Questions layout', 'wp-quiz' ),
				'showAll'				=> 	__( 'Show all', 'wp-quiz' ),
				'mutiplePages'			=> 	__( 'Multiple pages', 'wp-quiz' ),
				'chooseSkin'			=> 	__( 'Choose skin', 'wp-quiz' ),
				'traditionalSkin'		=> 	__( 'Traditional Skin', 'wp-quiz' ),
				'flatSkin'				=> 	__( 'Modern Flat Skin', 'wp-quiz' ),
				'progressColor'			=> 	__( 'Progress bar color', 'wp-quiz' ),
				'questionColor'			=> 	__( 'Font color', 'wp-quiz' ),
				'questionBgColor'		=> 	__( 'Background color', 'wp-quiz' ),
				'animationIn'			=> 	__( 'Animation In', 'wp-quiz' ),
				'animationOut'			=> 	__( 'Animation Out', 'wp-quiz' ),
				'quizSize'				=> 	__( 'Quiz Size', 'wp-quiz' ),
				'custom'				=> 	__( 'Custom', 'wp-quiz' ),
				'customSize'			=> 	__( 'Custom Size', 'wp-quiz' ),
				'width'					=>  __( 'Width:' , 'wp-quiz' ),
				'height'				=>  __( 'Height:' , 'wp-quiz' ),
				'customExplain'			=>  __( 'set width and height in px', 'wp-quiz' ),
				'fullWidth'				=> 	__( 'Full Width (responsive)', 'wp-quiz' ),
				'answers'				=> 	__( 'Answers', 'wp-quiz' ),
				'ajax_url'				=>	admin_url( 'admin-ajax.php' ),
				'proText'				=> 	__( 'Pro feature', 'wp-quiz' ),
				'buyPro'				=> 	__( 'Buy WP Quiz Pro', 'wp-quiz' ),
				'proTitle'				=> 	__( 'Buy WP Quiz Pro', 'wp-quiz' ),
				'proNoticeHeader'		=> 	__( 'Like WP Quiz Plugin? You will LOVE WP Quiz Pro!', 'wp-quiz' ),
				'personalityNotice'		=> 	__( 'Please add the Results and save the draft before adding questions', 'wp-quiz' ),
				'proNotice'				=>  __( 'New Quiz type Swiper, Show Ads in the quizzes, Countdown Timer, Open graph integration, Player tracking, Force users to Subscribe to see the results and much more.', 'wp-quiz' )
			) );
		}
		add_thickbox();
		
	}
	
	public function enter_title_here( $text ) {
		
		global $typenow;

		if ( ! is_admin() || 'wp_quiz' !== $typenow ) 
			return $text;

		return _x( 'Quiz Title', 'new quiz title placeholder', 'wp-quiz' );
	}

	public function add_shortcode_before_editor() {
		global $typenow;

		if ( 'wp_quiz' === $typenow && isset( $_GET['post'] ) ) {
			echo '<div class="inside"><strong style="padding: 0 10px;">'.__( 'Shortcode:', 'wp-quiz' ).'</strong> <input type="text" value=\'[wp_quiz id="'.trim( $_GET['post'] ).'"]\' readonly="readonly" /></div>';
		}
	}
	
	public function wp_quiz_pro_param_notice( $link ){
		
		$params[ 'wp_quiz_pro' ] = 'true';
		$link = add_query_arg( $params, $link );
		
		return $link;
	}
	
	public function save_post( $post_id, $post ){
		
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'quiz_nonce' ), 'quiz-content' ) ) 
			return $post_id;

		$post_type = get_post_type_object( $post->post_type );

		if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) 
			return $post_id; 
		
		$quiz_type = get_post_meta( $post_id, 'quiz_type', true );
		$new_quiz_type = filter_input( INPUT_POST, 'quiz_type', FILTER_SANITIZE_STRING );
		if ( $new_quiz_type && ( '' === $quiz_type || $quiz_type !== $new_quiz_type ) ) {
			update_post_meta( $post_id, 'quiz_type', $new_quiz_type );
		}
		
		//todo: sanitize all inputs
		$settings = $this->prepare_checkbox_options( $_POST[ 'settings' ] );
		$questions = '';
		if( isset( $_POST[ 'questions' ] ) ){
			$questions = array_values( $_POST[ 'questions' ] );
			foreach( $questions as $key => $question ){
				$questions[ $key ][ 'answers' ]  = array_values( $question[ 'answers' ] );
			}
		}
		
		update_post_meta( $post_id, 'questions', $questions );
		if( isset( $_POST[ 'results' ] ) && !empty( $_POST[ 'results' ] ) )	
			update_post_meta( $post_id, 'results', $_POST[ 'results' ] );
		update_post_meta( $post_id, 'settings', $settings );
		
	}
	
	public function prepare_checkbox_options( $post ){
		
		$settings_key = array( 'rand_answers', 'restart_questions', 'promote_plugin', 'auto_scroll' );
		foreach(  $settings_key as  $key ){
			if( isset( $post[ $key ] )  && $post[ $key ] == "1" )
				$post[ $key ] = 1;
			else
				$post[ $key ] = 0;
		}
		return $post;
	}
	
	public function add_new_wp_quiz_columns( $columns ) {
		
		$new_columns['cb']          =   '<input type="checkbox" />';
		$new_columns['title']       =   __( 'Quiz Name', 'wp-quiz' );
		$new_columns['shortcode']   =   __( 'Shortcode', 'wp-quiz' );
		$new_columns['type']        =   __( 'Quiz type', 'wp-quiz' );
		$new_columns['date']        =   __( 'Date', 'wp-quiz' );
		
		return $new_columns;
		
	}
	
	public function manage_wp_quiz_columns( $column_name, $id ){
		
		global $wpdb;
		$type = get_post_meta( $id, 'quiz_type', true );
		switch ($column_name) {
			case 'shortcode':
				echo '<div class="field"><input type="text" readonly value="[wp_quiz id=&quot;' . $id . '&quot;]" onClick="this.select();" style="width:100%;"></div>';
				break;
			case 'type':
				if( $type ) echo ucfirst($type);
				break;
			default:
				break;
		} // end switch
		
	}
	
	/**
	 * Add the config page
     */
	public function register_admin_menu() {
		
		global $wp_quiz_page_hook;
		$page_hook = add_submenu_page( 'edit.php?post_type=wp_quiz' , __( 'General Settings', 'wp-quiz' ), __( 'General Settings', 'wp-quiz' ), 'manage_options', 'wp_quiz_config', array( 'WP_Quiz_Page_Config', 'page' ) );
		add_action( 'load-' . $page_hook, array( 'WP_Quiz_Page_Config', 'load' ) );
		add_action( 'admin_print_styles-' . $page_hook, array( 'WP_Quiz_Page_Config', 'admin_print_styles' ) );

		do_action( 'wp_quiz_admin_page' );
	}

	/**
     * Add the import/export page
     */
    public function admin_import_export() {
		
		$page_hook = add_submenu_page( 'edit.php?post_type=wp_quiz', __( 'Import/Export', 'wp-quiz-pro' ), __( 'Import/Export', 'wp-quiz-pro' ), 'manage_options', 'wp_quiz_ie', array( 'WP_Quiz_Page_Import_Export', 'page' ) );
		add_action( 'load-' . $page_hook, array( 'WP_Quiz_Page_Import_Export', 'load' ) );
		add_action( 'admin_print_styles-' . $page_hook, array( 'WP_Quiz_Page_Import_Export', 'admin_print_styles' ) );

	}
	
	public function on_screen_layout_columns( $columns, $screen_id ){
		
		if ( $screen_id == 'wp_quiz_page_wp_quiz_config' ) {
			$columns['wp_quiz_page_wp_quiz_config'] = 2;
		} else if ( $screen_id == 'wp_quiz_page_wp_quiz_ie' ) {
			$columns['wp_quiz_page_wp_quiz_ie'] = 2;
		}
		return $columns;
	}
	
	/**
     * Shortcode used to display quiz
     *
     * @return string HTML output of the shortcode
     */
	public function register_shortcode( $atts ) {

		if ( !isset( $atts['id'] ) ) {
			return false;
		}
		
		// we have an ID to work with
        $quiz = get_post( $atts['id'] );

        // check the quiz is published and the ID is correct
        if ( ! $quiz || $quiz->post_status != 'publish' || $quiz->post_type != 'wp_quiz' ) {
            return "<!-- wp_quiz {$atts['id']} not found -->";
        }
		
		// lets go
       $this->set_quiz( $atts['id'] );
	   $this->quiz->enqueue_scripts();
	   
       return  $this->quiz->render_public_quiz();
	}
	
	/**
     * Initialise translations
     */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( 'wp-quiz', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}
	
	/**
     * Set the current quiz
     */
	public function set_quiz( $id ) {

		$quiz_type = get_post_meta( $id, 'quiz_type', true );
		$this->quiz = $this->create_quiz( $quiz_type, $id );

	}
	
	/**
	 * Called on save form. Only POST allowed.
	 */
	public function save_post_form() {

		//Allowed Pages
		if ( ! in_array( $_POST[ 'page' ], array ( 'wp_quiz_config' ) ) )
			wp_die( __( 'Cheating, huh?', 'wp-quiz' ) );

		//nonce check
		check_admin_referer( $_POST[ 'page' ] . '_page' );

		if ( ! current_user_can( 'manage_options' ) )
			wp_die( __( 'Cheating, huh?', 'wp-quiz' ) );

		$location = '';
		
		//Call method to save data
		if ( $_POST[ 'page' ] == 'wp_quiz_config' ){
			WP_Quiz_Page_Config::save_post_form();
			$location = admin_url() . 'edit.php?post_type=wp_quiz&page=wp_quiz_config';
		}
		//Back to topic
		$location = add_query_arg( 'message', 3, $location );
		wp_safe_redirect( $location );
		exit;
	}
	
	/**
     * Create a new quiz based on the quiz type
     */
	private function create_quiz( $type, $id ) {

		switch ( $type ) {
			case 'trivia':
				return new WP_Quiz_Trivia_Quiz( $id );
			case 'personality':
				return new WP_Quiz_Personality_Quiz( $id );
			case 'flip':
				return new WP_Quiz_Flip_Quiz( $id );
			default:
				break;
		} // end switch

	}
	
	public function create_quiz_page( $content ){
		
		global $post;

		if( $post->post_type != "wp_quiz" ){
			return $content;
		}

		if( !is_single() ){
			return $content;
		}

		$quiz_html = $this->register_shortcode( array( 'id' => $post->ID ) );
		return $quiz_html . $content;
		
	}
	
	public function wp_quiz_check_image_file(){
		
		$output = array( 'status' => 1 );
		$check = false;
		if( @getimagesize( $_POST[ 'url' ] ) )
			$check = true;
			
		$output[ 'check' ] = $check;
		
		wp_send_json( $output );
	}
	
	public function wp_quiz_check_video_file(){
		
		$output = array( 'status' => 1 );
		$check = false;
		$id = $_POST[ 'video_id' ];
		$url = "//www.youtube.com/oembed?url=http://www.youtube.com/watch?v=$id&format=json";
		$headers = get_headers( $url );
		if( substr( $headers[0], 9, 3 ) !== "404" ){
			$check = true;
		}
		
		$output[ 'check' ] = $check;
		wp_send_json( $output );
	}
	
	public static function activate_plugin(){
		
		// Don't activate on anything less than PHP 5.2.7 or WordPress 3.1
		if ( version_compare( PHP_VERSION, '5.2.7', '<' ) || version_compare( get_bloginfo( 'version' ), '3.4', '<' ) || ! function_exists( 'spl_autoload_register' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			deactivate_plugins( basename( __FILE__ ) );
			if ( isset( $_GET['action'] ) && ( $_GET['action'] == 'activate' || $_GET['action'] == 'error_scrape' ) ) {
				deactivate_plugins( basename( __FILE__ ) );
				wp_die( __( 'WP Quiz requires PHP version 5.2.7 with spl extension or greater and WordPress 3.4 or greater.', 'wp-quiz' ) );
			}
		}
		
		//Dont't activate if wp quiz pro is active
		if( defined( 'WP_QUIZ_PRO_VERSION' ) ){
			deactivate_plugins( basename( __FILE__ ) );
			wp_die( __( 'Please deactivate WP Quiz Pro plugin', 'wp-quiz' ) );
		}
		
		include( 'inc/activate-plugin.php' );

		self::flush_rewrites();
	}
	
	public function wp_quiz_get_ip(){
		
		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {
			$headers = apache_request_headers();
		} else {
			$headers = $_SERVER;
		}

		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
		} else if( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		} else {
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
		}
		return $the_ip;
		
	}
	public function wp_quiz_head(){
		$this->head_script();
	}
	
	public function head_script(){
		$settings = get_option( 'wp_quiz_default_settings' );
		?>
			<script>
				window.fbAsyncInit = function() {
					FB.init({
						appId    : <?php echo $settings[ 'defaults' ][ 'fb_app_id' ] ?>,
						xfbml    : true,
						version  : 'v2.5'
					});
				};

				(function(d, s, id){
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) {return;}
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#version=v2.5";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
		<?php
		if ( is_singular( array('wp_quiz') ) && isset( $settings[ 'defaults' ][ 'share_meta' ] ) && 1 === $settings[ 'defaults' ][ 'share_meta' ] ) {
			global $post, $wpseo_og;
			$twitter_desc = $og_desc = str_replace( array( "\r", "\n" ), '', strip_tags( $post->post_excerpt ) );
			if( defined( 'WPSEO_VERSION' ) ){	
				remove_action( 'wpseo_head', array( $wpseo_og, 'opengraph' ), 30 );
				remove_action( 'wpseo_head', array( 'WPSEO_Twitter', 'get_instance' ), 40 );
				//use description from yoast
				$twitter_desc 	= get_post_meta( $post->ID, '_yoast_wpseo_twitter-description', true );
				$og_desc 		= get_post_meta( $post->ID, '_yoast_wpseo_opengraph-description', true );
			}
			?>
			<meta name="twitter:title" content="<?php echo get_the_title(); ?>">
			<meta name="twitter:description" content="<?php echo $twitter_desc; ?>">
			<meta name="twitter:domain" content="<?php echo esc_url( site_url() ); ?>">
			<meta property="og:url" content="<?php the_permalink(); ?>" />
			<meta property="og:title" content="<?php echo get_the_title(); ?>" />
			<meta property="og:description" content="<?php echo $og_desc; ?>" />
			<?php
			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'full', true );
				$thumb_url = $thumb_url_array[0];
				?>
				<meta name="twitter:card" content="summary_large_image">
				<meta name="twitter:image:src" content="<?php echo $thumb_url; ?>">
				<meta property="og:image" content="<?php echo $thumb_url; ?>" />
				<meta itemprop="image" content="<?php echo $thumb_url; ?>">
			<?php
			}
		}
	}
	
}

endif;

add_action( 'plugins_loaded', array( 'WP_Quiz_Plugin', 'init' ), 10 );
register_activation_hook( __FILE__, array( 'WP_Quiz_Plugin', 'activate_plugin' ) );