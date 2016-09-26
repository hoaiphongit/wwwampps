<?php 

add_action( 'admin_enqueue_scripts', 'mts_diry_pointer_header' );
function mts_diry_pointer_header() {
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'mts_diry_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'mts_diry_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function mts_diry_pointer_footer() {
    $pointer_content = '<h3>Awesomeness!</h3>';
    $pointer_content .= '<p>You have just Installed Diary WordPress Theme by MyThemeShop.</p>';
	$pointer_content .= '<p>You can Trigger The Awesomeness using this Amazing Option Panel.</p>';
    $pointer_content .= '<p>If you face any problem, feel free to <a href="http://community.mythemeshop.com/">contact us</a></p>';
?>
<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {
    $('#toplevel_page_theme_options').pointer({
        content: '<?php echo $pointer_content; ?>',
        position: {
            edge: 'left',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'mts_diry_pointer',
                action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');
});
// ]]></script>
<?php
}

?>