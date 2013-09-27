<style type="text/css">
    #wphead { display:none !important; }
    #screen-meta { display:none !important; }
    #wpadminbar { display:none !important; }
    #adminmenu { display:none !important; }
    #adminmenuback { display:none !important; }
    #adminmenushadow { display:none !important; }
    #footer { display:none !important; }
    #footer { display:none !important; }
    #wpcontent, #footer {
        margin-left: 0px !important;
    }
    html.wp-toolbar {
        -moz-box-sizing: border-box;
        padding-top: 0px !important;
    }
    #wpbody {
        clear: both;
        margin-left: 0px !important;
    }
    #wpfooter{
        display: none;
    }
</style>
<?php
/**
* BreezingForms - A Joomla Forms Application
* @version 1.8
* @package BreezingForms
* @copyright (C) 2008-2012 by Markus Bopp
* @license Released under the terms of the GNU General Public License
**/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

echo '<button class="button-primary" onclick="saveText();parent.SqueezeBox.close();">'.JText::_('SAVE').'</button><p></p>';

global $wp_version;

if(version_compare($wp_version, '3.3','<') && version_compare($wp_version, '3.0','>=')){
    echo @the_editor('');
}else if(version_compare($wp_version, '3.3','>=')){
    echo wp_editor('', 'content');
}else{
    echo '<textarea style="width: 100%; height: 300px;" name="content" id="content" value="content"></textarea>'."\n";
}
echo '<br/>';
echo '<p></p><button class="button-primary" onclick="saveText();parent.SqueezeBox.close();">'.JText::_('SAVE').'</button>';
echo '<script>

function get_tinymce_content(){
    if (jQuery("#wp-content-wrap").hasClass("tmce-active")){
        return tinyMCE.activeEditor.getContent();
    }else{
        return jQuery("#content").val();
    }
}

function set_tinymce_content(val){
    if (jQuery("#wp-content-wrap").hasClass("tmce-active")){
        return tinyMCE.activeEditor.setContent(val);
    }else{
        return jQuery("#content").val(val);
    }
}

function bfLoadText(){
	var item = parent.app.findDataObjectItem(parent.app.selectedTreeElement.id, parent.app.dataObject);
        if(item && item.properties.type == "page"){
		set_tinymce_content(item.properties.pageIntro);
	} else if(item && item.properties.type == "section"){
		set_tinymce_content(item.properties.description);
	}
};
function saveText(){
	var item = parent.app.findDataObjectItem(parent.app.selectedTreeElement.id, parent.app.dataObject);
	if(item && item.properties.type == "page"){
		item.properties.pageIntro = get_tinymce_content();
	} else if(item && item.properties.type == "section"){
		item.properties.description = get_tinymce_content();
	}
}
setTimeout("bfLoadText()",500);
</script>';


