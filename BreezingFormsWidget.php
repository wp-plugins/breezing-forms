<?php
// no translations yet, let's do it quick and dirty for now
$breezingforms_widget_description = 'Display a BreezingForms form';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_description = 'Zeige ein BreezingForms Formular';
}
$breezingforms_widget_title = 'Widget Title';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_title = 'Widget Titel';
}
$breezingforms_widget_formname = 'Formname';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_formname = 'Formularname';
}
$breezingforms_widget_iframe = 'Run in iFrame';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_iframe = 'Im iFrame laden';
}
$breezingforms_widget_iframe_autoheight = 'iFrame Autoheight';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_iframe_autoheight = 'iFrame Automatische Höhe';
}
$breezingforms_widget_iframe_height = 'iFrame height';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_iframe_height = 'iFrame Höhe';
}
$breezingforms_widget_iframe_width = 'iFrame width';
if( WPLANG == 'de-DE' ){
    $breezingforms_widget_iframe_width = 'iFrame Breite';
}


class BreezingFormsWidget extends WP_Widget {

	function BreezingFormsWidget() {
                global $breezingforms_widget_description;
                
		$widget_ops = array( 'description' => $breezingforms_widget_description );
		$this->WP_Widget(false, 'BreezingForms', $widget_ops);
	}

	function widget( $args, $instance ) {
                extract($args);
        
                $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
        
		echo $before_widget;
		
                if ( $title ){
                    echo $before_title . stripslashes($title) . $after_title;
                }
                
                $width = 'width="100%"';
                $height = '';
                if(!isset($instance['iframe_autoheight']) || $instance['iframe_autoheight'] == 0){
                    if(isset($instance['iframe_width']) && $instance['iframe_width']){
                        $width = 'width="'.$instance['iframe_width'].'"';
                    }
                    if(isset($instance['iframe_height']) && $instance['iframe_height']){
                        $height = ' height="'.$instance['iframe_height'].'" ';
                    }
                }
                echo '<iframe class="breezingforms_iframe_widget" '.$width.''.$height.'frameborder="0" allowtransparency="true" scrolling="no" src="index.php?plugin=breezingforms&preview=true&ff_frame=1&ff_name='.$instance['name'].'"></iframe>'."\n";
                if(isset($instance['iframe_autoheight']) && $instance['iframe_autoheight']){
                    echo '<script type="text/javascript" src="'.WP_PLUGIN_URL . '/'.BF_FOLDER.'/platform/components/com_breezingforms/libraries/jquery/jq.iframeautoheight.js"></script>'."\n";
                    echo '<script type="text/javascript">
                    <!--
                    jQuery(document).ready(function() {
                        jQuery(".breezingforms_iframe_widget").css("width", "100%");
                        jQuery(".breezingforms_iframe_widget").iframeAutoHeight({heightOffset: 15, debug: false, diagnostics: false});
                    });
                    //-->
                    </script>';
                }
                
                echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) { 
                global $wpdb, $table_prefix;
                global $breezingforms_widget_iframe_width, 
                       $breezingforms_widget_iframe_height, 
                       $breezingforms_widget_iframe_autoheight, 
                       $breezingforms_widget_title, 
                       $breezingforms_widget_formname, 
                       $breezingforms_widget_iframe;
                
		$instance = wp_parse_args( (array) $instance, array('title' => false, 'form' => false, 'description' => false, 'size' => 20, 'select_width' => false) );
?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo $breezingforms_widget_title;?>:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( stripslashes($instance['title']) ); ?>" /></p>

                <p>
                <label for="<?php echo $this->get_field_id('name'); ?>"><?php echo $breezingforms_widget_formname;?>:</label>
                <select class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>">
                <?php
                $myforms = $wpdb->get_results( "SELECT `name`, `title` FROM " . $table_prefix . 'facileforms_forms Where published = 1 Order By `ordering`');
                foreach($myforms As $myform){
                ?>
                    <option value="<?php echo $myform->name;?>"<?php echo $myform->name == esc_attr( stripslashes(isset($instance['name']) ? $instance['name'] : '' ) ) ? ' selected="selected"' : ''?>><?php echo htmlentities($myform->title . ' ('.$myform->name.')', ENT_QUOTES, 'UTF-8');?></option>
                <?php
                }
                ?>
                </select>
                </p>
                
                <!-- not yet available
                <p><label for="<?php echo $this->get_field_id('iframe'); ?>"><?php echo $breezingforms_widget_iframe;?>:</label>
                <input type="radio" id="<?php echo $this->get_field_id('iframe'); ?>_no" name="<?php echo $this->get_field_name('iframe'); ?>" value="0"<?php echo !isset($instance['iframe']) || ( isset($instance['iframe']) && $instance['iframe'] == 0 ) ? ' checked="checked"' : ''; ?>/>
                <label for="<?php echo $this->get_field_id('iframe'); ?>_no"><?php _e('no') ?></label>
                <input type="radio" id="<?php echo $this->get_field_id('iframe'); ?>_yes" name="<?php echo $this->get_field_name('iframe'); ?>" value="1"<?php echo isset($instance['iframe']) && $instance['iframe'] == 1 ? ' checked="checked"' : ''; ?>/>
                <label for="<?php echo $this->get_field_id('iframe'); ?>_yes"><?php _e('yes') ?></label>
                </p>-->
                
                <p><label for="<?php echo $this->get_field_id('iframe_autoheight'); ?>"><?php echo $breezingforms_widget_iframe_autoheight;?>:</label>
                <input type="radio" id="<?php echo $this->get_field_id('iframe_autoheight'); ?>_no" name="<?php echo $this->get_field_name('iframe_autoheight'); ?>" value="0"<?php echo !isset($instance['iframe_autoheight']) || ( isset($instance['iframe']) && $instance['iframe_autoheight'] == 0 ) ? ' checked="checked"' : ''; ?>/>
                <label for="<?php echo $this->get_field_id('iframe_autoheight'); ?>_no"><?php _e('no') ?></label>
                <input type="radio" id="<?php echo $this->get_field_id('iframe'); ?>_yes" name="<?php echo $this->get_field_name('iframe_autoheight'); ?>" value="1"<?php echo isset($instance['iframe_autoheight']) && $instance['iframe_autoheight'] == 1 ? ' checked="checked"' : ''; ?>/>
                <label for="<?php echo $this->get_field_id('iframe_autoheight'); ?>_yes"><?php _e('yes') ?></label>
                </p>
                
                <p><label for="<?php echo $this->get_field_id('iframe_width'); ?>"><?php echo $breezingforms_widget_iframe_width;?>:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('iframe_width'); ?>" name="<?php echo $this->get_field_name('iframe_width'); ?>" value="<?php echo esc_attr( stripslashes(isset($instance['iframe_width']) ? $instance['iframe_width'] : '' ) ); ?>" /></p>
                
                <p><label for="<?php echo $this->get_field_id('iframe_height'); ?>"><?php echo $breezingforms_widget_iframe_height;?>:</label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('iframe_height'); ?>" name="<?php echo $this->get_field_name('iframe_height'); ?>" value="<?php echo esc_attr( stripslashes(isset($instance['iframe_height']) ? $instance['iframe_height'] : '' ) ); ?>" /></p>
                
<?php 
	}
}

?>