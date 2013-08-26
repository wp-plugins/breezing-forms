<?php
/*
Plugin Name: Breezing Forms
Plugin URI: http://crosstec.de/en/wordpress-forms-download.html
Description: A professional forms plugin for wordpress.
Version: 1.2.6
Author: Crosstec GmbH & Co. KG
Author URI: http://crosstec.de
License: GPL2
*/
?>
<?php
/*  Copyright 2012 Crosstec GmbH & Co. KG  (email : markus.bopp@crosstec.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('BF_PLUGINS_URL', plugins_url());
define('BF_FOLDER', basename(dirname(__FILE__)));
define('BF_SITE_URL', get_option('siteurl'));

$bf_wp_query_tmp = null;
$bf_wpdb_tmp = null;

// frontend requires jquery, just to make sure
add_action('init', 'breezingforms_init');
function breezingforms_init(){
    global $bf_wp_query_tmp, $wp_query, $bf_wpdb_tmp, $wpdb;
    $bf_wp_query_tmp = $wp_query;
    $bf_wpdb_tmp = $wpdb;
    wp_enqueue_script('jquery');
}
// building preview
add_action('init', 'breezingforms_preview_init');
function breezingforms_preview_init(){
    
    global $bf_wp_query_tmp, $wp_query, $wp_the_query, $bf_wpdb_tmp, $wpdb;
    
    if( isset($_GET['plugin']) && $_GET['plugin'] == 'breezingforms' && isset($_GET['preview']) && $_GET['preview'] == 'true' ){
        if ( !defined( 'ABSPATH' ) && !defined( 'XMLRPC_REQUEST' )) {
            global $wp;
            $root = dirname(dirname(dirname(dirname(__FILE__))));
            include_once( $root.'/wp-config.php' );
            $wp->init();
            $wp->register_globals();
        }
        wp_enqueue_script('jquery');
        header("Content-Type: text/html; charset=utf-8");
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head();?>
    </head>
    <body>
    <?php
        echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
        echo breezingforms_site();
    ?>
    <?php wp_footer(); ?>
    </body>
    </html>
    <?php
        wp_cache_init();
        global $wp_query, $wp_the_query, $wpdb;
        $wp_query = $wp_the_query = $bf_wp_query_tmp;
        $wpdb = $bf_wpdb_tmp;
        exit;
    }
}
// disable the admin bar in previews
if( isset($_GET['plugin']) && $_GET['plugin'] == 'breezingforms' && isset($_GET['preview']) && $_GET['preview'] == 'true' ){
    add_filter('show_admin_bar', '__return_false'); 
    if(function_exists('show_admin_bar')){
        show_admin_bar(false);
    }
}
// used for all admin ajax requests
if(isset($_REQUEST['action']) && $_REQUEST['action'] != 'breezingformsajax'){
    add_action('wp_ajax_breezingformsadminajax', 'breezingformsadminajax');
}else{
    add_action('wp_ajax_breezingformsajax', 'breezingformsajax');
}
function breezingformsadminajax(){
    breezingforms_admin();
    die();
}
// used for all public ajax requests
add_action('wp_ajax_nopriv_breezingformsajax', 'breezingformsajax');
function breezingformsajax(){
    echo breezingforms_site();
    die();
}

// enqeue all required scripts & css
if( ( isset($_GET['page']) && $_GET['page'] == 'breezingforms' ) || ( isset($_POST['page']) && $_POST['page'] == 'breezingforms' ) ){
    add_action('admin_print_scripts', 'breezingforms_add_admin_scripts');
}
function breezingforms_add_admin_scripts(){
    // scripts
    wp_enqueue_script(mt_rand(0, mt_getrandmax()), WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/media/system/js/mootools-core.js');
    wp_enqueue_script(mt_rand(0, mt_getrandmax()), WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/media/system/js/core.js');
    wp_enqueue_script(mt_rand(0, mt_getrandmax()), WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/media/system/js/mootools-more.js');
    wp_enqueue_script(mt_rand(0, mt_getrandmax()), WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/media/system/js/modal.js');
    wp_enqueue_script(mt_rand(0, mt_getrandmax()), WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/media/system/js/tabs.js');
    // styles
    
    echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/media/system/css/modal.css"/>';
    
    if(isset($_REQUEST['task']) && $_REQUEST['task'] == 'editform' && $_REQUEST['act'] == 'editpage' || (isset($_REQUEST['act'])  && $_REQUEST['act'] == 'configuration') ){
        echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/administrator/templates/bluestork/css/template.css"/>';
    }
}
// building the tinymce shortcode helper
add_action('admin_init', 'breezingforms_admin_mce');
add_action('admin_footer',  'breezingforms_insert_form_popup');
function breezingforms_admin_mce(){
    add_filter('media_buttons_context', 'breezingforms_insert_form_button'); 
}
function breezingforms_insert_form_button($content){
    $content .= '<a href="#TB_inline?width=450&height=550&inlineId=breezingforms_insert_form" class="thickbox" title="BreezingForms"><img src="'.WP_PLUGIN_URL.'/'.BF_FOLDER.'/breezingforms-icon.png" alt="BreezingForms" /></a>';
    return $content;
}
function breezingforms_insert_form_popup(){
    global $wpdb, $table_prefix;
    $title = 'BreezingForms Shortcode Helper';
    if(WPLANG == 'de-DE'){
        $title = 'BreezingForms Shortcode Hilfe';
    }
    $breezingforms_formname = 'Select form';
    if(WPLANG == 'de-DE'){
        $breezingforms_formname = 'Formular wählen';
    }
    $breezingforms_iframe = 'Run in iFrame';
    if(WPLANG == 'de-DE'){
        $breezingforms_iframe = 'Im iFrame laden';
    }
    $breezingforms_iframe_autoheight = 'Enable iFrame autoheight';
    if(WPLANG == 'de-DE'){
        $breezingforms_iframe_autoheight = 'Automatische Höhe des iFrames einschalten';
    }
    $breezingforms_iframe_width = 'iFrame width';
    if(WPLANG == 'de-DE'){
        $breezingforms_iframe_width = 'iFrame Breite';
    }
    $breezingforms_iframe_height = 'iFrame height';
    if(WPLANG == 'de-DE'){
        $breezingforms_iframe_height = 'iFrame Höhe';
    }
    $breezingforms_add_shortcode = 'Add Shortcode';
    if(WPLANG == 'de-DE'){
        $breezingforms_add_shortcode = 'Shortcode hinzufügen';
    }
?>
    <script type="text/javascript">
    function breezingforms_insert_form(){
        var autoheight = jQuery('input[name=breezingforms_iframe_autoheight]:checked').val();
        var iframe = jQuery('input[name=breezingforms_iframe]:checked').val();
        var name = jQuery('#breezingforms_form').val();
        var width = jQuery('#breezingforms_iframe_width').val();
        var height = jQuery('#breezingforms_iframe_width').val();
        var win = window.dialogArguments || opener || parent || top;
        win.send_to_editor('[breezingforms name="'+name+'"'+(iframe == 1 ? ' iframe="1"' : '')+(autoheight == 1 ? ' iframe_autoheight="1"' : '')+(height != "" ? ' iframe_height="'+height+'"' : '')+(width != "" ? ' iframe_width="'+width+'"' : '')+']');
    }
    </script>
    <div id="breezingforms_insert_form" style="display:none;">
        <h3><?php echo $title;?></h3>
        <p>
            <label for="breezingforms_form"><?php echo $breezingforms_formname;?>:</label>
            <select class="widefat" id="breezingforms_form" name="breezingforms_form">
            <?php
            $myforms = $wpdb->get_results( "SELECT `name`, `title` FROM " . $table_prefix . 'facileforms_forms Where published = 1 Order By `ordering`');
            foreach($myforms As $myform){
            ?>
                <option value="<?php echo $myform->name;?>"><?php echo htmlentities($myform->title . ' ('.$myform->name.')', ENT_QUOTES, 'UTF-8');?></option>
            <?php
            }
            ?>
            </select>
        </p>
        
        <p><label for="breezingforms_iframe"><?php echo $breezingforms_iframe;?>:</label>
        <br/>
        <input type="radio" id="breezingforms_iframe_no" name="breezingforms_iframe" value="0" checked="checked"/>
        <label for="breezingforms_iframe_no"><?php _e('no') ?></label>
        <input type="radio" id="breezingforms_iframe_yes" name="breezingforms_iframe" value="1"/>
        <label for="breezingforms_iframe_yes"><?php _e('yes') ?></label>
        </p>
        
        <p><label for="breezingforms_iframe_autoheight"><?php echo $breezingforms_iframe_autoheight;?>:</label>
        <br/>
        <input type="radio" id="breezingforms_iframe_autoheight_no" name="breezingforms_iframe_autoheight" value="0" checked="checked"/>
        <label for="breezingforms_iframe_autoheight_no"><?php _e('no') ?></label>
        <input type="radio" id="breezingforms_iframe_yes" name="breezingforms_iframe_autoheight" value="1"/>
        <label for="breezingforms_iframe_autoheight_yes"><?php _e('yes') ?></label>
        </p>
        
        <p><label for="breezingforms_iframe_width"><?php echo $breezingforms_iframe_width;?>:</label>
        <input type="text" class="widefat" id="breezingforms_iframe_width" name="breezingforms_iframe_width" value="" /></p>

        <p><label for="breezingforms_iframe_height"><?php echo $breezingforms_iframe_height;?>:</label>
        <input type="text" class="widefat" id="breezingforms_iframe_height" name="breezingforms_iframe_height" value="" /></p>

        <p><button onclick="breezingforms_insert_form()"><?php echo $breezingforms_add_shortcode;?></button></p>
        
    </div>
<?php
}
// init the administration on direct plugin call
if(is_admin() && ( ( isset($_GET['plugin']) && $_GET['plugin'] == 'breezingforms' ) || ( isset($_POST['plugin']) && $_POST['plugin'] == 'breezingforms' ) ) ){
    add_action('admin_init', 'breezingforms_admin');
}
// init the administration on menu call
add_action('admin_menu', 'breezingforms_admin_init');
function breezingforms_admin_init(){
    add_object_page('BreezingForms', 'BreezingForms', 'administrator', 'breezingforms', 'breezingforms_admin', BF_PLUGINS_URL . '/'.BF_FOLDER.'/breezingforms-icon.png');
    add_submenu_page('breezingforms', 'BreezingForms', 'Records', 'administrator', 'admin.php?page=breezingforms&act=recordmanagement');
    add_submenu_page('breezingforms', 'BreezingForms', 'Forms', 'administrator', 'admin.php?page=breezingforms&act=manageforms');
    add_submenu_page('breezingforms', 'BreezingForms', 'Scripts', 'administrator', 'admin.php?page=breezingforms&act=managescripts');
    add_submenu_page('breezingforms', 'BreezingForms', 'Pieces', 'administrator', 'admin.php?page=breezingforms&act=managepieces');
    add_submenu_page('breezingforms', 'BreezingForms', 'Configuration', 'administrator', 'admin.php?page=breezingforms&act=configuration');
}
// ADMINISTRATOR bootstrapping joomla platform & breezingforms
function breezingforms_admin(){
    
    global $bf_wp_query_tmp, $wp_query, $wp_the_query, $bf_wpdb_tmp, $wpdb;
    
    if(!is_admin()) die();
    
    // session mayhem
    $session_name = "wordpress_" . md5( get_site_url() );
    if (!isset($_COOKIE[$session_name]))
    {
        @setcookie($session_name, session_id(), time() - 3600);
    }else{
        session_id(md5($_COOKIE[$session_name]));
    }
    @session_start();
    // mayhem end
    
    define('_JEXEC', 1);
    define('DS', DIRECTORY_SEPARATOR);

    define('JPATH_BASE', dirname(__FILE__).DS.'platform'.DS.'administrator');
    include_once dirname(__FILE__) . '/platform/administrator/includes/defines.php';
    
    include_once dirname(__FILE__) . '/platform/configuration.php';
    require_once(JPATH_SITE.'/libraries/cms/version/version.php');
    
    require_once JPATH_SITE.'/administrator/includes/framework.php';
    require_once JPATH_SITE.'/administrator/includes/helper.php';
    require_once JPATH_SITE.'/administrator/includes/toolbar.php';
    
    // fixating to breezingforms
    JRequest::setVar('option', 'com_breezingforms');
    JRequest::setVar('tmpl', 'component');
    
    jimport('joomla.application.helper');
    $client = new stdClass;
    $client->name = 'administrator';
    $client->path = JPATH_BASE;

    JApplicationHelper::addClientInfo($client);

    // Mark afterLoad in the profiler.
    JDEBUG ? $_PROFILER->mark('afterLoad') : null;

    // Instantiate the application.
    $app = JFactory::getApplication('administrator');
    
    // Load Library language
    $lang = JFactory::getLanguage();
    $lang->load('lib_joomla', JPATH_ADMINISTRATOR);
    
    // Initialise the application.
    $app->initialise(array(
            'language' => $app->getUserState('application.lang')
    ));

    // Mark afterIntialise in the profiler.
    JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

    // Dispatch the application.
    $app->dispatch();

    // Mark afterDispatch in the profiler.
    JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

    // Render the application.
    $app->render();

    // Mark afterRender in the profiler.
    JDEBUG ? $_PROFILER->mark('afterRender') : null;

    // Return the response.
    echo $app;
    
    wp_cache_init();
    global $wp_query, $wp_the_query, $wpdb;
    $wp_query = $wp_the_query = $bf_wp_query_tmp;
    $wpdb = $bf_wpdb_tmp;
}

// FRONTEND SCRIPTS
// enqeue all required scripts & css to go into the footer
// dirtiest trick ever, thanks Matt ;)

$bf_processor = null;
$add_my_script = false;

add_action('wp_footer', 'breezingforms_print_scripts');
 
function breezingforms_print_scripts() {
	global $add_my_script, $bf_processor;

	if (!$add_my_script){
            return;
        }
        
        if($bf_processor != null){
            //echo $bf_processor->quickmode->fetchFoot(JFactory::getDocument()->getHeadData());
            //$bf_processor->quickmode->renderScriptsAndCss();
        }
    
}

// FRONTEND bootstrapping
add_shortcode( 'breezingforms', 'breezingforms_site' );

function breezingforms_site($atts = array()){
    
    global $add_my_script, $bf_wp_query_tmp, $wp_query, $wp_the_query, $bf_wpdb_tmp, $wpdb;
    
    // session mayhem
    $session_name = "wordpress_" . md5( get_site_url() );
    if (!isset($_COOKIE[$session_name]))
    {
        @setcookie($session_name, session_id(), time() - 3600);
    }else{
        session_id(md5($_COOKIE[$session_name]));
    }
    @session_start();
    // mayhem end
    
    $add_my_script = true;
    
    if(!isset($_REQUEST['ff_name'])){
        $_GET['ff_name'] = $_POST['ff_name'] = $_REQUEST['ff_name'] = isset($atts['name']) ? $atts['name'] : '';
    }
    
    if(!isset($_REQUEST['ff_form'])){
        $_GET['ff_form'] = $_POST['ff_form'] = $_REQUEST['ff_form'] = isset($atts['ff_form']) ? $atts['id'] : '';
    }
    
    if(isset($atts['iframe']) && $atts['iframe']){
        ob_start();
        $width = 'width="100%"';
        $height = '';
        if(!isset($atts['iframe_autoheight']) || $atts['iframe_autoheight'] == 0){
            if(isset($atts['iframe_width']) && $atts['iframe_width']){
                $width = 'width="'.$atts['iframe_width'].'"';
            }
            if(isset($atts['iframe_height']) && $atts['iframe_height']){
                $height = ' height="'.$atts['iframe_height'].'" ';
            }
        }
        
        echo '<iframe class="breezingforms_iframe" '.$width.''.$height.'frameborder="0" allowtransparency="true" scrolling="no" src="index.php?plugin=breezingforms&preview=true&ff_frame=1&ff_name='.$_GET['ff_name'].'"></iframe>'."\n";
        if(isset($atts['iframe_autoheight']) && $atts['iframe_autoheight']){
            echo '<script type="text/javascript" src="'.WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/components/com_breezingforms/libraries/jquery/jq.iframeautoheight.js"></script>'."\n";
            echo '<script type="text/javascript">
            <!--
            jQuery(document).ready(function() {
                jQuery(".breezingforms_iframe").css("width", "100%");
                jQuery(".breezingforms_iframe").iframeAutoHeight({heightOffset: 15, debug: false, diagnostics: false});
            });
            //-->
            </script>'."\n";
        }
        $c = ob_get_contents();
        ob_end_clean();
        wp_cache_init();
        global $wp_query, $wp_the_query, $wpdb;
        $wp_query = $wp_the_query = $bf_wp_query_tmp;
        $wpdb = $bf_wpdb_tmp;
        return $c;
    }
    
    if(!defined('_JEXEC')){
        define('_JEXEC', 1);
    }
    if(!defined('DS')){
        define('DS', DIRECTORY_SEPARATOR);
    }

    if(!defined('JPATH_BASE')){
        define('JPATH_BASE', dirname(__FILE__).DS.'platform');
    }
    include_once dirname(__FILE__) . '/platform/includes/defines.php';
    
    include_once dirname(__FILE__) . '/platform/configuration.php';
    require_once(JPATH_SITE.'/libraries/cms/version/version.php');
    
    require_once JPATH_SITE.'/includes/framework.php';
    
    // fixating to breezingforms
    JRequest::setVar('option', 'com_breezingforms');
    JRequest::setVar('tmpl', 'component');
    
    jimport('joomla.application.helper');
    $client = new stdClass;
    $client->name = 'site';
    $client->path = JPATH_BASE;

    JApplicationHelper::addClientInfo($client);

    // Instantiate the application.
    $app = JFactory::getApplication('site');

    $app->setTemplate('system');
    
    // Initialise the application.
    $app->initialise();

    // Mark afterIntialise in the profiler.
    JDEBUG ? $_PROFILER->mark('afterInitialise') : null;

    // Dispatch the application.
    $app->dispatch();
    
    // passing the processor back, so the scripts can be rendered
    global $bf_processor, $ff_processor;
    $bf_processor = $ff_processor;
    
    // Mark afterDispatch in the profiler.
    JDEBUG ? $_PROFILER->mark('afterDispatch') : null;

    // Render the application.
    $app->render();

    // Mark afterRender in the profiler.
    JDEBUG ? $_PROFILER->mark('afterRender') : null;

    // making the shortcode appear at the right spot
    //if(!JFactory::getSession()->get('com_breezingforms.mobile', false)){
        ob_start();
    //}
    
    // Return the response.
    echo $app;
    
    //if(!JFactory::getSession()->get('com_breezingforms.mobile', false)){
        $c = ob_get_contents();
        ob_end_clean();
        wp_cache_init();
        global $wp_query, $wp_the_query, $wpdb;
        $wp_query = $wp_the_query = $bf_wp_query_tmp;
        $wpdb = $bf_wpdb_tmp;
        
        return $c;
    //}
        
    unset($_GET['ff_name']);
    unset($_POST['ff_name']);
    unset($_REQUEST['ff_name']);
        
    unset($_GET['ff_form']);
    unset($_POST['ff_form']);
    unset($_REQUEST['ff_form']);
}

if(class_exists('WP_Widget')){
    require_once(WP_PLUGIN_DIR . '/'.BF_FOLDER.'/BreezingFormsWidget.php');
    add_action('widgets_init', create_function('', 'return register_widget("BreezingFormsWidget");'));
}

