<?php
/**
* BreezingForms - A Joomla Forms Application
* @version 1.8
* @package BreezingForms
* @copyright (C) 2008-2012 by Markus Bopp
* @license Released under the terms of the GNU General Public License
**/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

function is_ip($ip) {
    $ispv6 = isIPv6($ip);
    if($ispv6) return true;
    
$valid = true;

$ip = explode(".", $ip);
   foreach($ip as $block) {
       if(!is_numeric($block)) {
           $valid = false;
       }
   }
return $valid;
}

function isIPv6($ip) { 
    return (preg_match('#^[0-9A-F]{0,4}(:([0-9A-F]{0,4})){0,7}$#s', $ip)) ? true : false; 
}

class bfRecordManagement
{
	/**
	 * @var JDatabase
	 */
	private $db = null;

        function record()
        {

        }

	function __construct()
	{
		$this->db = JFactory::getDBO();
	}

	public function editRecord()
	{
                JToolBarHelper::title('<img src="'. JURI::root() . 'administrator/components/com_breezingforms/libraries/jquery/themes/easymode/i/logo-breezingforms.png'.'" align="top"/>');
		$ids = JRequest::getVar('ids', array());
		if(is_array($ids) && count($ids) != 0)
		{
			$this->db->setQuery("Select * From #__facileforms_records As records Where records.id = " . intval($ids[0]));
			$head = $this->db->loadObjectList();

			$this->db->setQuery("Select * From #__facileforms_subrecords As subrecords Where subrecords.record = " . intval($ids[0]));
			$entries = $this->db->loadObjectList();

			if(count($head) && count($entries))
			{
				$this->db->setQuery("Update #__facileforms_records Set viewed = 1 Where id = " . intval($ids[0]));
				$this->db->query();

				//$this->recordHtml($head[0], $entries);
                                $rec = $head[0];
                                $subs = $entries;
                                ?>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<form action="admin.php?page=breezingforms" method="post" name="adminForm" id="adminForm" class="adminForm">
                    <div style="float:right;">
                        <button class="button-primary" onclick="submitbutton('save');"><?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_SAVE'), ENT_QUOTES, 'UTF-8'); ?></button>
                        &nbsp;&nbsp;
                        <input onclick="submitbutton('cancel');" type="submit" value="<?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_CANCEL'), ENT_QUOTES, 'UTF-8'); ?>"/>
                    </div>
                    <div style="clear:both"></div>
                    <p></p>
                    <table width="100%" border="0">
                    <tr>
				<td></td>
				<td colspan="2">
						<table class="widefat">
                                                    <thead><th colspan="7"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_SUBMVALUES'); ?></th></thead>
                                                    <tbody>
							<tr>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_RECORDID'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_ELEMENTID'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_TITLE'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_NAME'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_TYPE'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_VALUE'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_EDIT'); ?></strong></td>
							</tr>
<?php
			for($i=0; $i < count( $subs ); $i++) {
				$sub = $subs[$i];
?>
							<tr>
								<td nowrap valign="top"><?php echo $sub->id; ?></td>
								<td nowrap valign="top"><?php echo $sub->element; ?></td>
								<td nowrap valign="top"><?php echo htmlentities($sub->title, ENT_QUOTES, 'UTF-8'); ?></td>
								<td nowrap valign="top"><?php echo $sub->name; ?></td>
								<td nowrap valign="top"><?php echo $sub->type; ?></td>
								<td valign="top">
                                                                    <?php
                                                                       
                                                                if($sub->type != 'File Upload'){
                                                                    echo '<div style="overflow: auto; max-height: 300px; width: 250px;">';
                                                                    echo htmlentities($sub->value, ENT_QUOTES, 'UTF-8');
                                                                    echo '</div>';
                                                                }else {
                                                                    if(trim($sub->value)){
                                                                        echo '<div style="white-space: nowrap; overflow: auto; max-height: 300px; width: 250px;">';
                                                                        $files = explode("\n", str_replace("\r","",$sub->value));
                                                                        $fileIdx = 0;
                                                                        foreach($files As $file){
                                                                            if(!JFile::exists($file)){
                                                                                echo 'file not found on server:<br/>' . basename($file).'<br/>';
                                                                            }else{
                                                                                echo 'Image/File preview and download in Pro version only<br/>' . basename($file).'<br/>';
                                                                            }
                                                                            echo '<br/>';
                                                                            $fileIdx++;
                                                                        }
                                                                        echo '</div>';
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                                </td>
								<td valign="top">
								<?php
								if($sub->type != 'Textarea' && $sub->type != 'File Upload')
								{
								?>
									<input type="text" name="ff_nm_<?php echo $sub->name; ?>" value="<?php echo htmlentities($sub->value, ENT_QUOTES, 'UTF-8'); ?>" style="width:200px;"/>
								<?php
								}
								else
								{
								?>
									<textarea name="ff_nm_<?php echo $sub->name; ?>" style="width:200px;height:100px;"><?php echo htmlentities($sub->value, ENT_QUOTES, 'UTF-8'); ?></textarea>
								<?php
								}
								?>
								<input type="checkbox" value="<?php echo $sub->name; ?>" name="update[]"/>
								</td>
							</tr>
                                                        <tbody>
<?php
			} // for
?>
						</table>
                                    <p></p>
				</td>
				<td></td>
			</tr>
                        <tr>
				<td></td>
				<td colspan="2">
						<table class="widefat">
                                                        <thead>
                                                            <th colspan="5"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_SUBMINFO'); ?></th>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_SUBMITTED'); ?></strong></td>
								<td nowrap><strong>IP</strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_PROVIDER'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_OPSYS'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_BROWSER'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap valign="top"><?php echo $rec->submitted; ?></td>
								<td nowrap valign="top"><?php echo $rec->ip; ?></td>
								<td nowrap valign="top"><?php echo htmlspecialchars($rec->provider, ENT_QUOTES); ?></td>
								<td nowrap valign="top"><?php echo htmlspecialchars($rec->opsys, ENT_QUOTES); ?></td>
								<td valign="top"><?php echo htmlspecialchars($rec->browser, ENT_QUOTES); ?></td>
							</tr>
                                                        </tbody>
						</table>
                                    <p></p>
				</td>
				<td></td>
			</tr>


			<tr>
				<td></td>
				<td colspan="2">
						<table class="widefat">
                                                    <thead><th colspan="5"><?php echo BFText::_('COM_BREEZINGFORMS_PAYMENT_INFORMATION'); ?><th></thead>
                                                    <tbody>
                                                    <tr>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_TRANSACTION_ID'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_TRANSACTION_DATE'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_TESTACCOUNT'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_DOWNLOAD_TRIES'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap valign="top"><?php echo $rec->paypal_tx_id; ?></td>
								<td nowrap valign="top"><?php echo $rec->paypal_payment_date ?></td>
								<td nowrap valign="top"><?php echo $rec->paypal_testaccount ? BFText::_('COM_BREEZINGFORMS_YES') : BFText::_('COM_BREEZINGFORMS_NO'); ?></td>
								<td valign="top"><?php echo $rec->paypal_download_tries ?></td>
							</tr>
                                                    </tbody>
						</table>
                                    <p></p>
				</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>
						<table class="widefat">
                                                    <thead><th colspan="5"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_RECORDINFO'); ?></th></thead>
                                                    <tbody>	
                                                    <tr>
								<td nowrap><strong>ID</strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_VIEWED'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_EXPORTED'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_ARCHIVED'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap><?php echo $rec->id; ?></td>
								<td nowrap><?php if ($rec->viewed) echo BFText::_('COM_BREEZINGFORMS_RECORDS_YES'); else echo BFText::_('COM_BREEZINGFORMS_RECORDS_NO'); ?></td>
								<td nowrap><?php if ($rec->exported) echo BFText::_('COM_BREEZINGFORMS_RECORDS_YES'); else echo BFText::_('COM_BREEZINGFORMS_RECORDS_NO'); ?></td>
								<td nowrap><?php if ($rec->archived) echo BFText::_('COM_BREEZINGFORMS_RECORDS_YES'); else echo BFText::_('COM_BREEZINGFORMS_RECORDS_NO'); ?></td>
							</tr>
                                                    </tbody>
						</table>
				</td>
				<td>
						<table class="widefat">
                                                    <thead><th colspan="5"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_FORMINFO'); ?></th></thead>
                                                    <tbody>
                                                    <tr>
								<td nowrap><strong>ID</strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_TITLE'); ?></strong></td>
								<td nowrap><strong><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_NAME'); ?></strong></td>
							</tr>
							<tr>
								<td nowrap><?php echo $rec->form; ?></td>
								<td nowrap><?php echo $rec->title; ?></td>
								<td nowrap><?php echo $rec->name; ?></td>
							</tr>
                                                    </tbody>
						</table>
				</td>
				<td></td>
			</tr>
		</table>
                    
                    <div style="float:right;">
                        <p></p>
					<button class="button-primary" onclick="submitbutton('save');"><?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_SAVE'), ENT_QUOTES, 'UTF-8'); ?></button>
					&nbsp;&nbsp;
                                        <input onclick="submitbutton('cancel');" type="submit" value="<?php echo htmlentities(BFText::_('COM_BREEZINGFORMS_TOOLBAR_CANCEL'), ENT_QUOTES, 'UTF-8'); ?>"/>
				
                    </div>
                    
		<input type="hidden" name="option" value="com_breezingforms" />
		<input type="hidden" name="act" value="<?php echo JRequest::getVar('act', '') ?>" />
		<input type="hidden" id="limitstart" name="limitstart" value="<?php echo JRequest::getInt('limitstart',0); ?>" />
		<input type="hidden" id="mylimit" name="mylimit" value="<?php echo JRequest::getInt('mylimit',20); ?>" />
		<input type="hidden" id="form" name="form" value="<?php echo JRequest::getInt('form',0); ?>" />
		<input type="hidden" id="search" name="search" value="<?php echo JRequest::getVar('search',''); ?>" />
		<input type="hidden" name="txtsearch" value="<?php echo JRequest::getWord('txtsearch','false'); ?>" />
		<input type="hidden" name="order" value="<?php echo JRequest::getWord('order','DESC') ?>" />
		<input type="hidden" name="orderBy" value="<?php echo JRequest::getWord('orderBy','submitted') ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="record_id" value="<?php echo $rec->id; ?>" />
		</form>
<?php
			}
			else
			{
				echo '
                                <form action="admin.php?page=breezingforms" method="post" name="adminForm" id="adminForm" class="adminForm">
                                        <input type="hidden" name="option" value="com_breezingforms" />
                                        <input type="hidden" name="act" value="'.JRequest::getVar('act', '').'" />
                                        <input type="hidden" id="limitstart" name="limitstart" value="'.JRequest::getInt('limitstart',0).'" />
                                        <input type="hidden" id="mylimit" name="mylimit" value="'.JRequest::getInt('mylimit',20).'" />
                                        <input type="hidden" id="form" name="form" value="'.JRequest::getInt('form',0).'" />
                                        <input type="hidden" id="search" name="search" value="'.JRequest::getVar('search','').'" />
                                        <input type="hidden" name="txtsearch" value="'.JRequest::getWord('txtsearch','false').'" />
                                        <input type="hidden" name="order" value="'.JRequest::getWord('order','DESC').'" />
                                        <input type="hidden" name="orderBy" value="'.JRequest::getWord('orderBy','submitted').'" />
                                        <input type="hidden" name="task" value="cancel" />
                                </form>
                                <script type="text/javascript">
                                document.adminForm.submit();
                                </script>
                            ';
			}
		}
	}

	public function listRecords()
	{
                JToolBarHelper::title('<img src="'. JURI::root() . 'administrator/components/com_breezingforms/libraries/jquery/themes/easymode/i/logo-breezingforms.png'.'" align="top"/>');
		JToolBarHelper::custom('exportPdf',    'ff_download',             'ff_download_f2',             BFText::_('COM_BREEZINGFORMS_PDF'),    false);
		JToolBarHelper::custom('exportCsv',    'ff_download',             'ff_download_f2',             BFText::_('COM_BREEZINGFORMS_CSV'),    false);
		JToolBarHelper::custom('exportXml',    'ff_download',             'ff_download_f2',             BFText::_('COM_BREEZINGFORMS_XML'),    false);
		JToolBarHelper::custom('remove',    'delete.png',       'delete_f2.png',    BFText::_('COM_BREEZINGFORMS_TOOLBAR_DELETE'),    false);
		JToolBarHelper::custom('all',    'ff_switch',             'ff_switch_f2',             BFText::_('COM_BREEZINGFORMS_ALL'),    false);
		JToolBarHelper::custom('viewed',    'ff_switch',             'ff_switch_f2',             BFText::_('COM_BREEZINGFORMS_TOOLBAR_VIEWED'),    false);
		JToolBarHelper::custom('exported',  'ff_switch',             'ff_switch_f2',             BFText::_('COM_BREEZINGFORMS_TOOLBAR_EXPORTED'),  false);
		JToolBarHelper::custom('archived',  'ff_switch',             'ff_switch_f2',             BFText::_('COM_BREEZINGFORMS_TOOLBAR_ARCHIVED'),  false);

		JFactory::getDocument()->addStyleDeclaration(
			'

			.icon-32-ff_switch {
				background-image:url(components/com_breezingforms/images/icons/switch.png);
			}

			.icon-32-ff_switch_f2 {
				background-image:url(components/com_breezingforms/images/icons/switch_f2.png);
			}

			.icon-32-ff_download {
				background-image:url(components/com_breezingforms/images/icons/download.png);
			}

			.icon-32-ff_download_f2 {
				background-image:url(components/com_breezingforms/images/icons/download_f2.png);
			}

			'
		);

		//print_r($_REQUEST);
		$ids = JRequest::getVar('ids', array());
		$offset = JRequest::getInt('limitstart', 0);
		$limit  = JRequest::getInt('mylimit', 20);

		if(JRequest::getVar('task','') == 'all')
		{
			JFactory::getSession()->set('bfStatus', '');
		}
		else if(JRequest::getVar('task','')=='exported')
		{
			JFactory::getSession()->set('bfStatus', 'exported');
		}
		else if(JRequest::getVar('task','')=='archived')
		{
			JFactory::getSession()->set('bfStatus', 'archived');
		}
		else if(JRequest::getVar('task','')=='viewed')
		{
			JFactory::getSession()->set('bfStatus', 'viewed');
		}
		else if(JRequest::getVar('task','')=='remove')
		{
                        // CONTENTBUILDER
                        $isContentBuilder = false;
                        jimport('joomla.filesystem.file');
                        jimport('joomla.filesystem.folder');
                        jimport( 'joomla.database.table' );
                        jimport( 'joomla.event.dispatcher' );
                        jimport('joomla.version');
                        
                        if(JFile::exists(JPATH_SITE . DS . 'administrator' . DS . 'components' . DS . 'com_contentbuilder' . DS . 'classes' . DS . 'contentbuilder.php'))
                        {
                            $isContentBuilder = true;
                        }
                        // CONTENTBUILDER END
                        
                        $is15 = true;
                        $version = new JVersion();
                        if (version_compare($version->getShortVersion(), '1.6', '>=')) {
                           $is15 = false; 
                        }
                        
			$size = count($ids);
			for($i = 0; $i < $size; $i++)
			{
                                if($isContentBuilder){
                                   $this->db->setQuery("Select `form`.id As form_id, `form`.reference_id, `form`.delete_articles From #__facileforms_records As r, #__contentbuilder_forms As form Where form.reference_id = r.form And r.id =  " . $this->db->Quote($ids[$i])); 
                                   $cbRecords = $this->db->loadAssocList();
                                   foreach($cbRecords As $cbRecord){
                                       $this->db->setQuery("Delete From #__contentbuilder_list_records Where form_id = ".intval($cbRecord['form_id'])." And record_id = " . $this->db->Quote($ids[$i]));
                                       $this->db->query();
                                       $this->db->setQuery("Delete From #__contentbuilder_records Where `type` = 'com_breezingforms' And `reference_id` = ".$this->db->Quote($cbRecord['reference_id'])." And record_id = " . $this->db->Quote($ids[$i]));
                                       $this->db->query();
                                       if($cbRecord['delete_articles']){
                                            $this->db->setQuery("Select article_id From #__contentbuilder_articles Where form_id = ".intval($cbRecord['form_id'])." And record_id = " . $this->db->Quote($ids[$i]));
                                            $articles = $this->db->loadResultArray();
                                            if( count($articles) ){
                                                $article_items = array();
                                                foreach($articles As $article){
                                                    $article_items[] = $this->db->Quote('com_content.article.'.$article);
                                                    $dispatcher = JDispatcher::getInstance();
                                                    $table = JTable::getInstance('content');
                                                    // Trigger the onContentBeforeDelete event.
                                                    if(!$is15 && $table->load($article)){
                                                        $dispatcher->trigger('onContentBeforeDelete', array('com_content.article', $table));
                                                    }
                                                    $this->db->setQuery("Delete From #__content Where id = ".intval($article));
                                                    $this->db->query();
                                                    // Trigger the onContentAfterDelete event.
                                                    $table->reset();
                                                    if(!$is15){
                                                        $dispatcher->trigger('onContentAfterDelete', array('com_content.article', $table));
                                                    }
                                                }
                                                $this->db->setQuery("Delete From #__assets Where `name` In (".implode(',', $article_items).")");
                                                $this->db->query();
                                            }
                                       }
                                       
                                       $this->db->setQuery("Delete From #__contentbuilder_articles Where form_id = ".intval($cbRecord['form_id'])." And record_id = " . $this->db->Quote($ids[$i]));
                                       $this->db->query();
                                   }
                                }
                                
				$this->db->setQuery("Delete From #__facileforms_records Where id = " . $this->db->Quote($ids[$i]));
				$this->db->query();
				$this->db->setQuery("Delete From #__facileforms_subrecords Where record = " . $this->db->Quote($ids[$i]));
				$this->db->query();
			}
                        
		}
		else if(JRequest::getVar('task','')=='save')
		{
			$id = JRequest::getInt('record_id', 0);
			$updates = JRequest::getVar('update', array());
			foreach($updates As $update)
			{
				$this->db->setQuery("Update #__facileforms_subrecords Set value = ".$this->db->Quote(JRequest::getVar('ff_nm_'.$update,''))." Where name = ".$this->db->Quote($update)." And record = " . $id);
				$this->db->query();
			}
		}
		else if(JRequest::getVar('task','')=='exportXml' && JRequest::getInt('exportt',0) == 1)
		{
			$this->expxml($ids);
		}
		else if(JRequest::getVar('task','')=='exportCsv' && JRequest::getInt('exportt',0) == 1)
		{
			$this->expcsv($ids);
		}
		else if(JRequest::getVar('task','')=='exportPdf' && JRequest::getInt('exportt',0) == 1)
		{
			$this->exppdf($ids);
		}

		if(JRequest::getInt('status_update',0) == 1)
		{
			$offset = 0;
			$limit = 20;
			JRequest::setVar('limitstart', 0);
			JRequest::setVar('mylimit', 20);
		}

		if(JRequest::getInt('id', 0) != '' && JRequest::getInt('viewed', -1) != -1)
		{
			$value = 1;
			if(JRequest::getInt('viewed', -1) == 1)
			{
				$value = 0;
			}
			$this->db->setQuery("Update #__facileforms_records Set viewed = ".$value." Where id = " . JRequest::getInt('id', 0));
			$this->db->query();
		}

		if(JRequest::getInt('id', 0) != '' && JRequest::getInt('exported', -1) != -1)
		{
			$value = 1;
			if(JRequest::getInt('exported', -1) == 1)
			{
				$value = 0;
			}
			$this->db->setQuery("Update #__facileforms_records Set exported = ".$value." Where id = " . JRequest::getInt('id', 0));
			$this->db->query();
		}

		if(JRequest::getInt('id', 0) != '' && JRequest::getInt('archived', -1) != -1)
		{
			$value = 1;
			if(JRequest::getInt('archived', -1) == 1)
			{
				$value = 0;
			}
			$this->db->setQuery("Update #__facileforms_records Set archived = ".$value." Where id = " . JRequest::getInt('id', 0));
			$this->db->query();
		}

		if(JRequest::getInt('status_update',0) == 1 && JRequest::getVar('write_status','') != '')
		{
			$in = '';

			if(is_array($ids) && count($ids) != 0)
			{
				$status = '';
				if(JFactory::getSession()->get('bfStatus', '') == 'exported')
				{
					$status = "exported = ".(JRequest::getVar('write_status','') == 'set' ? 1 : 0);
				}
				else
				if(JFactory::getSession()->get('bfStatus', '') == 'archived')
				{
					$status = "archived = ".(JRequest::getVar('write_status','') == 'set' ? 1 : 0);
				}
				else
				if(JFactory::getSession()->get('bfStatus', '') == 'viewed')
				{
					$status = "viewed = ".(JRequest::getVar('write_status','') == 'set' ? 1 : 0);
				}

				if($status != '' )
				{
					$size = count($ids);
					for($i = 0; $i < $size; $i++)
					{
						$this->db->setQuery("Update #__facileforms_records Set $status Where id = " . $this->db->Quote($ids[$i]));
						$this->db->query();
						//echo $this->db->getQuery() . '<br/>';
					}
				}
			}
		}

		$ands = '';
		$subs = '';

		if(JRequest::getVar('search','') != '')
		{
			//echo JRequest::getVar('txtsearch','false');
			if(JRequest::getVar('txtsearch','false')=='true')
			{
				$subs .= ', #__facileforms_subrecords As subrecord';
				$ands .= 'subrecord.value Like ' . $this->db->Quote('%'.JRequest::getVar('search','').'%') . ' And record.id = subrecord.record And ';
			}

			$headerSearch = '';
			if(is_numeric(JRequest::getVar('search','')))
			{
				$headerSearch .= 'record.id = ' . intval(JRequest::getVar('search','')) . ' Or ';
			}

			$ex = explode('-', JRequest::getVar('search',''));
			//print_r($ex);
			if(count($ex) == 3 && checkdate($ex[1], $ex[2], $ex[0]))
			{
				$headerSearch .= "record.submitted Between '" . $ex[0] . '-' . $ex[1] . '-' . $ex[2] . " 00:00:00' And '" . $ex[0] . '-' . $ex[1] . '-' . $ex[2] . " 23:59:59' Or ";
				$headerSearch .= "record.paypal_payment_date Between '" . $ex[0] . '-' . $ex[1] . '-' . $ex[2] . " 00:00:00' And '" . $ex[0] . '-' . $ex[1] . '-' . $ex[2] . " 23:59:59' Or ";
			}

			if(is_ip(JRequest::getVar('search','')))
			{
				$headerSearch .= 'record.ip = ' . $this->db->Quote(JRequest::getVar('search','')) . ' Or ';
			}

			if(substr(trim(JRequest::getVar('search','')), 0,4) == 'tx: ')
			{
				$text = trim(JRequest::getVar('search',''));
				$text = substr($text, 3,strlen($text));
				$headerSearch .= 'record.paypal_tx_id Like ' . $this->db->Quote('%'.$text) . ' Or ';
			}

			if($headerSearch == '' && JRequest::getVar('txtsearch','false')!='true')
			{
				$headerSearch .= 'record.`name` Like ' . $this->db->Quote('%'.trim(JRequest::getVar('search','')).'%') . ' Or ';
			}

			if($headerSearch != '')
			{
				$headerSearch = substr($headerSearch,0,strlen($headerSearch)-4);
				$ands .= "(".$headerSearch.") And ";
			}
		}

		if(JRequest::getInt('form',0) != 0)
		{
			$ands .= 'record.form = ' . $this->db->Quote(JRequest::getInt('form',0)) . ' And ';
		}

		if(JFactory::getSession()->get('bfStatus', '') == 'exported')
		{
			$ands .= "record.exported = 1 And";
		}
		else
		if(JFactory::getSession()->get('bfStatus', '') == 'archived')
		{
			$ands .= "record.archived = 1 And";
		}
		else
		if(JFactory::getSession()->get('bfStatus', '') == 'viewed')
		{
			$ands .= "record.viewed = 1 And";
		}

		if($ands != '')
		{
			$ands = 'Where ' . substr($ands,0,strlen($ands)-4);
		}

		$limiter = " Limit $offset, $limit";
		if($limit == 0)
		{
			$limiter = '';
		}

		$this->db->setQuery("Select Distinct SQL_CALC_FOUND_ROWS record.* From #__facileforms_records As record $subs $ands Order By record.".JRequest::getWord('orderBy','submitted')." ".(JRequest::getWord('order','DESC') == 'DESC' || JRequest::getWord('order','DESC') == '' ? 'DESC' : 'ASC').$limiter);
		$rows = $this->db->loadObjectList();
                
		//echo $this->db->getQuery();
		$this->db->setQuery("SELECT FOUND_ROWS();");
		$foundRows = $this->db->loadResult();
                jimport('joomla.html.pagination');
		$pagination = new JPagination($foundRows, $offset, $limit);

		$this->db->setQuery("Select Distinct form As id, `name`, title From #__facileforms_records Order By title");
		$forms = $this->db->loadObjectList();
		$size = count($forms);
		$formsArray = array();
		for($i = 0;$i < $size;$i++)
		{
			if(!isset($formsArray['_'.$forms[$i]->id])){
				$formsArray['_'.$forms[$i]->id] = $forms[$i];
			}
		}

                $forms = $formsArray;
                ?>
<script type="text/javascript">
var bf_submitbutton = function(pressbutton)
			{
                                var form = document.adminForm;
                                form.exportt.value = 0;
				switch (pressbutton) {
					case 'exportCsv':
					case 'exportXls':
					case 'exportPdf':
					case 'exportXml':
                                                
						if (form.boxchecked.value==0) {
							alert("<?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_PLSSELECTRECS'); ?>");
							return false;
						} // if
                                                form.action = 'admin.php?plugin=breezingforms';
						form.exportt.value = 1;
						break;
					case 'viewed':
					case 'exported':
					case 'archived':
                                                form.action = 'admin.php?page=breezingforms';
						var writeStatus = false;
						for(var i = 0; i < form.write_status.length; i++)
						{
							if(form.write_status[i].checked && (form.write_status[i].value == 'set' || form.write_status[i].value == 'unset'))
							{
								writeStatus = true;
								break;
							}
						}
						if (writeStatus && form.boxchecked.value==0) {
							alert("<?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_PLSSELECTRECS'); ?>");
							return;
						} // if
						form.status_update.value = 1;
						break;
					default:
						break;
				} // switch
				switch (pressbutton) {
					case 'remove':
						if (!confirm("<?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_ASKDELETE'); ?>")) return;
						break;
					default:
						break;
				} // switch
				submitform(pressbutton);
                                setTimeout("document.adminForm.action = 'admin.php?page=breezingforms'; document.adminForm.exportt.value = 0;", 500);
}; // submitbutton

if(typeof Joomla != "undefined"){
    Joomla.submitbutton = bf_submitbutton;
}else{
    submitbutton = bf_submitbutton;
}

function bf_listItemTask( id, task )
{
	var f = document.adminForm;
	cb = eval( 'f.' + id );
	if (cb) {
		for (i = 0; true; i++) {
			cbx = eval('f.cb'+i);
			if (!cbx) break;
				cbx.checked = false;
			} // for
			cb.checked = true;
			f.boxchecked.value = 1;
			submitbutton(task);
		}
	return false;
} // listItemTask
</script>
<style type="text/css">
/* Pagination on backend */
.button1,
.button1 div {
	height: 1%;
	float: right;
}

.button2-left,
.button2-right,
.button2-left div,
.button2-right div {
	float: left;
}

.button1 {
	white-space: nowrap;
	padding-left: 10px;
	margin-left: 5px;
}

.button1 .next {
}

.button1 a {
	display: block;
	height: 26px;
	float: left;
	line-height: 26px;
	font-size: 1.091em;
	font-weight: bold;
	color: #333;
	cursor: pointer;
	padding: 0 35px 0 6px;
}

.button1 a:hover {
	text-decoration: none;
	color: #0B55C4;
}

.button2-left a,
.button2-right a,
.button2-left button,
.button2-right button,
.button2-left span,
.button2-right span {
	display: block;
	height: 22px;
	float: left;
	line-height: 22px;
	font-size: 1em;
	color: #333;
	cursor: pointer;
}

.button2-left span,.button2-right span {
	cursor: default;
	color: #999;
}

.button2-left .page a,
.button2-right .page a,
.button2-left .page span,
.button2-right .page span,
.button2-left .blank a,
.button2-right .blank a,
.button2-left .blank span,
.button2-right .blank span,
.button2-left .blank button,
.button2-right .blank button {
	padding: 0 6px;
}

.page span,.blank span {
	color: #000;
	font-weight: bold;
}

.button2-left a:hover,
.button2-right a:hover,
.button2-left button:hover,
.button2-left button:hover	{
	text-decoration: none;
	color: #0B55C4;
}

.button2-left a,
.button2-left span,
.button2-left button {
	padding: 0 24px 0 6px;
}

.button2-right a,
.button2-right span,
.button2-right button {
	padding: 0 6px 0 24px;
}

.button2-left {
	float: left;
	margin-right: 10px;
}

.button2-right {
	float: left;
	margin-left: 5px;
	margin-right: 10px;
}


a.pointer { cursor: pointer; }

button {
	margin-top: 4px;
	background: #fff;
	border: 1px solid #ccc;
	text-decoration: none;
}

button:hover {
	cursor: pointer;
	background: #E8F6FE;
	text-decoration: none;
	border: 1px solid #aaa;
}

div.button2-left button {
	background: transparent;
	margin-top: 0;
	border: 0 solid #ccc;
}

div.button2-left button {
	background: transparent;
	border: 0 solid #aaa;
}
.pagination div.limit {
	float: left;
	height: 22px;
	line-height: 22px;
	margin: 0 10px;
}

.pagination div.limit select#limit {
	width: 50px;
}

.pagination {
	display: inline-block;
	padding: 0;
	margin: 0 auto;
}
</style>
State:
<a href="javascript:bf_submitbutton('all');void(0);" style="<?php echo JFactory::getSession()->get('bfStatus', '') == '' ? 'font-weight: bold;' : '';?>">Any</a>
|
<a href="javascript:bf_submitbutton('viewed');void(0);" style="<?php echo JFactory::getSession()->get('bfStatus', '') == 'viewed' ? 'font-weight: bold;' : '';?>">
<?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_VIEWED');?>
</a>
|              
<a href="javascript:bf_submitbutton('exported');void(0);" style="<?php echo JFactory::getSession()->get('bfStatus', '') == 'exported' ? 'font-weight: bold;' : '';?>">
<?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_EXPORTED');?>
</a>
|                            
<a href="javascript:bf_submitbutton('archived');void(0);" style="<?php echo JFactory::getSession()->get('bfStatus', '') == 'archived' ? 'font-weight: bold;' : '';?>">
<?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_ARCHIVED');?>
</a>
|
Records: <?php echo $foundRows;?>
<div style="float:right">
                        <button onclick="bf_submitbutton('remove')" class="button-primary">
                        Delete Selected Records
                        </button>
                        <button onclick="bf_submitbutton('exportPdf')" class="button">
                        Export <?php echo BFText::_('COM_BREEZINGFORMS_PDF');?>
                        </button>
                                
                        <td align="right" width="50%" nowrap>
                        <button onclick="bf_submitbutton('exportCsv')" class="button">
                        Export <?php echo BFText::_('COM_BREEZINGFORMS_CSV');?>
                        </button>

                        <button onclick="bf_submitbutton('exportXml')" class="button">
                        Export <?php echo BFText::_('COM_BREEZINGFORMS_XML');?>
                        </button>

                        </div>
<p></p>
<form action="admin.php?page=breezingforms" method="post" name="adminForm">
    Change State: <input type="radio" name="write_status" value=""<?php echo JRequest::getVar('write_status','') == '' ? ' checked="checked"' : ''; ?>/>  <?php echo BFText::_('COM_BREEZINGFORMS_NONE'); ?> <input type="radio" name="write_status" value="unset"<?php echo JRequest::getVar('write_status','') == 'unset' ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_UNSET'); ?> <input type="radio" name="write_status" value="set"<?php echo JRequest::getVar('write_status','') == 'set' ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_SET'); ?>
    <p></p>
<div id="editcell">

    <table class="adminlist" width="100%">
	    			<tr>
	    				<td>    
                                            
			    			<?php echo BFText::_('COM_BREEZINGFORMS_FILTER'); ?>:
			    			<input type="text" name="search" value="<?php echo htmlentities(JRequest::getVar('search',''),ENT_QUOTES, 'UTF-8'); ?>" onchange="form.status_update.value = 1;"/>
                                                <input type="checkbox" id="txtsearch" name="txtsearch" onclick="form.status_update.value = 1;" value="true"<?php echo JRequest::getWord('txtsearch','false') == 'true' ? ' checked="checked"' : ''; ?>/> <label for="txtsearch">Search in records</label> 
                                                <select name="form" onchange="form.status_update.value = 1;">
			    				<option value=""><?php echo BFText::_('COM_BREEZINGFORMS_ALL'); ?></option>
			    				<?php
								foreach($forms As $form)
								{
									if(trim($form->name) != '')
									{
										echo '<option value="'.$form->id.'"'.(JRequest::getInt('form',0) == $form->id ? ' selected="selected"' : '').'>'.htmlentities($form->title, ENT_QUOTES, 'UTF-8').' ('.htmlentities($form->name, ENT_QUOTES, 'UTF-8').')</option>'."\n";
									}
								}
			    				?>
			    			</select>
                                                <button onclick="document.adminForm.submit()" class="button">Filter</button>
						</td>
						<td align="right" valign="top">
                                                    
			    		</td>
					</tr>
				</table>
    <p></p>
    <table class="widefat">
    <thead>
        <tr>
        	<th nowrap align="center"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=id"><?php echo BFText::_('COM_BREEZINGFORMS_ID'); ?></a>
            </th>
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=submitted"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_SUBMITTED'); ?></a>
            </th>
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=title"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_TITLE'); ?></a>
            </th>
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=name"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_NAME'); ?></a>
            </th>
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=paypal_tx_id"><?php echo BFText::_('COM_BREEZINGFORMS_PAYMENT_TX_ID'); ?></a>
            </th>
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=paypal_payment_date"><?php echo BFText::_('COM_BREEZINGFORMS_PAYMENT_TX_DATE'); ?></a>
            </th>
            <!--<th nowrap align="center"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_VIEWED'); ?></th>-->
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=viewed"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_VIEWED'); ?></a>
            </th>
            <!--<th nowrap align="center"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_EXPORTED'); ?></th>-->
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=exported"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_EXPORTED'); ?></a>
            </th>
            <!--<th nowrap align="center"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_ARCHIVED'); ?></th>-->
            <th>
                <a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;order=<?php echo JRequest::getVar('order', 'DESC') == 'DESC' ? 'ASC' : 'DESC'; ?>&amp;orderBy=archived"><?php echo BFText::_('COM_BREEZINGFORMS_RECORDS_ARCHIVED'); ?></a>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php
    $k = 0;
    $cnt = count( $rows );
    for ($i=0; $i < $cnt; $i++)
    {
        $row = $rows[$i];
        if ($row->viewed) $view_src = BF_PLUGINS_URL . "/".BF_FOLDER."/joomla-platform/administrator/components/com_breezingforms/images/icons/publish_g.png"; else $view_src = BF_PLUGINS_URL . "/".BF_FOLDER."/joomla-platform/administrator/components/com_breezingforms/images/icons/publish_x.png";
	if ($row->exported) $exp_src = BF_PLUGINS_URL . "/".BF_FOLDER."/joomla-platform/administrator/components/com_breezingforms/images/icons/publish_g.png"; else $exp_src = BF_PLUGINS_URL . "/".BF_FOLDER."/joomla-platform/administrator/components/com_breezingforms/images/icons/publish_x.png";
	if ($row->archived) $arch_src = BF_PLUGINS_URL . "/".BF_FOLDER."/joomla-platform/administrator/components/com_breezingforms/images/icons/publish_g.png"; else $arch_src = BF_PLUGINS_URL . "/".BF_FOLDER."/joomla-platform/administrator/components/com_breezingforms/images/icons/publish_x.png";
        ?>
        <tr class="<?php echo "row$k"; ?>">
            <td nowrap align="center"><input type="checkbox" id="cb<?php echo $i; ?>" name="ids[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
			<td nowrap align="left"><a href="#" onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $row->id; ?></a></td>
			<td nowrap align="left"><a href="#" onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $row->submitted; ?></a></td>
			<td nowrap align="left"><?php echo $row->title; ?></td>
			<td nowrap align="left"><?php echo $row->name; ?></td>
			<td nowrap align="left"><?php echo $row->paypal_tx_id; ?></td>
			<td nowrap align="left"><?php echo $row->paypal_payment_date; ?></td>
			<td nowrap align="center"><a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;id=<?php echo $row->id ?>&amp;viewed=<?php echo $row->viewed ?>&amp;order=<?php echo JRequest::getWord('order','DESC') ?>&amp;orderBy=<?php echo JRequest::getWord('orderBy','submitted') ?>"><img src="<?php echo $view_src; ?>" alt="+" border="0" /></a></td>
			<td nowrap align="center"><a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;id=<?php echo $row->id ?>&amp;exported=<?php echo $row->exported ?>&amp;order=<?php echo JRequest::getWord('order','DESC') ?>&amp;orderBy=<?php echo JRequest::getWord('orderBy','submitted') ?>"><img src="<?php echo $exp_src; ?>" alt="+" border="0" /></a></td>
			<td nowrap align="center"><a href="admin.php?page=breezingforms&amp;act=recordmanagement&amp;txtsearch=<?php echo JRequest::getWord('txtsearch','false'); ?>&amp;search=<?php echo htmlentities(JRequest::getVar('search',''), ENT_QUOTES, 'UTF-8'); ?>&amp;form=<?php echo htmlentities(JRequest::getVar('form',''), ENT_QUOTES, 'UTF-8'); ?>&amp;task=<?php echo JRequest::getVar('task',''); ?>&amp;limitstart=<?php echo JRequest::getInt('limitstart',0); ?>&amp;mylimit=<?php echo JRequest::getInt('mylimit',20); ?>&amp;id=<?php echo $row->id ?>&amp;archived=<?php echo $row->archived ?>&amp;order=<?php echo JRequest::getWord('order','DESC') ?>&amp;orderBy=<?php echo JRequest::getWord('orderBy','submitted') ?>"><img src="<?php echo $arch_src; ?>" alt="+" border="0" /></a></td>
        </tr>
        <?php
        $k = 1 - $k;
    }
    ?>
    </tbody>
    </table>
</div>

<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="option" value="com_breezingforms" />
<input type="hidden" id="task" name="task" value="<?php echo JRequest::getVar('task',''); ?>" />
<input type="hidden" name="act" value="recordmanagement" />
<input type="hidden" name="status_update" value="0" />
<input type="hidden" name="order" value="<?php echo JRequest::getWord('order','DESC') ?>" />
<input type="hidden" name="orderBy" value="<?php echo JRequest::getWord('orderBy','submitted') ?>" />
<input type="hidden" id="limitstart" name="limitstart" value="<?php echo JRequest::getInt('limitstart',0); ?>" />
<input type="hidden" id="mylimit" name="mylimit" value="<?php echo JRequest::getInt('mylimit',20); ?>" />
<input type="hidden" id="exportt" name="exportt" value="0" />

</form>

<table class="widefat">
	<tfoot>
    	<tr>
    		<td colspan="14">
    			<form action="#">
    				<?php echo $pagination->getListFooter() ?>
    			</form>
    		</td>
    	</tr>
	</tfoot>
</table>

<script>
// fixing limit, since it seems not to be available through JRequest or even $_POST/$_GET/$_REQUEST
document.getElementById('limit').onchange =
function(){
	document.getElementById('mylimit').value = document.getElementById('limit').options[document.getElementById('limit').selectedIndex].value;
	document.adminForm.submit();
};
</script>

<?php
	}

	function expxml($ids)
	{
		global $database, $ff_admsite, $ff_compath, $ff_version, $mosConfig_fileperms;
		$database = JFactory::getDBO();
		$xmlname = $ff_compath.'/exports/ffexport-'.date('YmdHis').'.xml';

		$ids = implode(',', $ids);
		$database->setQuery(
			"select * from #__facileforms_records where id in ($ids) order by id"
		);
		$recs = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		} // if

		$xml  = '<?xml version="1.0" encoding="utf-8" ?>'.nl().
				'<FacileFormsExport type="records" version="'.$ff_version.'">'.nl().
				indent(1).'<exportdate>'.date('Y-m-d H:i:s').'</exportdate>'.nl();

		$form = '';
		for($r = 0; $r < count($recs); $r++) {
			$rec = $recs[$r];
			$xml .= indent(1).'<record id="'.$rec->id.'">'.nl().
					indent(2).'<submitted>'.$rec->submitted.'</submitted>'.nl().
					indent(2).'<user_id>'.$rec->user_id.'</user_id>'.nl().
					indent(2).'<username>'.htmlspecialchars($rec->username).'</username>'.nl().
					indent(2).'<user_full_name>'.htmlspecialchars($rec->user_full_name).'</user_full_name>'.nl().
					indent(2).'<form>'.$rec->form.'</form>'.nl().
					indent(2).'<title>'.htmlspecialchars($rec->title).'</title>'.nl().
					indent(2).'<name>'.$rec->name.'</name>'.nl().
					indent(2).'<ip>'.$rec->ip.'</ip>'.nl().
					indent(2).'<browser>'.htmlspecialchars($rec->browser).'</browser>'.nl().
					indent(2).'<opsys>'.htmlspecialchars($rec->opsys).'</opsys>'.nl().
					indent(2).'<provider>'.$rec->provider.'</provider>'.nl().
					indent(2).'<viewed>'.$rec->viewed.'</viewed>'.nl().
					indent(2).'<exported>'.$rec->exported.'</exported>'.nl().
					indent(2).'<archived>'.$rec->archived.'</archived>'.nl().
					indent(2).'<pptxid>'.$rec->paypal_tx_id.'</pptxid>'.nl().
					indent(2).'<pppdate>'.$rec->paypal_payment_date.'</pppdate>'.nl().
					indent(2).'<pptestacc>'.$rec->paypal_testaccount.'</pptestacc>'.nl().
					indent(2).'<ppdltries>'.$rec->paypal_download_tries.'</ppdltries>'.nl();
			$database->setQuery(
				"select subs.* from #__facileforms_subrecords As subs, #__facileforms_elements As els where els.id=subs.element And subs.record = $rec->id order by ordering"
			);
			$subs = $database->loadObjectList();
			for($s = 0; $s < count($subs); $s++) {
				$sub = $subs[$s];
                                if($sub->type == 'File Upload' && strpos(strtolower($sub->value), '{cbsite}') === 0){
                                    $out = '';
                                    $nl = '';
                                    $_values = explode("\n",str_replace("\r",'',$sub->value));
                                    $length = count($_values);
                                    $i = 0;
                                    foreach($_values As $_value){
                                       if($i+1 < $length){
                                           $nl = "\n";
                                       }else{
                                           $nl = '';
                                       }
                                       $out .= str_replace(array('{cbsite}','{CBSite}'), array(JPATH_SITE, JPATH_SITE), $_value).$nl;
                                       $i++;
                                    }
                                    $sub->value = $out;
                                }
				$xml .= indent(2).'<subrecord id="'.$sub->id.'">'.nl().
						indent(3).'<element>'.$sub->element.'</element>'.nl().
						indent(3).'<name>'.$sub->name.'</name>'.nl().
						indent(3).'<title>'.htmlspecialchars($sub->title).'</title>'.nl().
						indent(3).'<type>'.$sub->type.'</type>'.nl().
						indent(3).'<value>'.htmlspecialchars($sub->value).'</value>'.nl().
						indent(2).'</subrecord>'.nl();
			} // for
			$xml .= indent(1).'</record>'.nl();
		} // for
		$xml .= '</FacileFormsExport>'.nl();

		//$xmlname = JFile::makeSafe($xmlname);
		if (!JFile::write($xmlname,$xml)) {
			echo "<script> alert('".addslashes(BFText::_('COM_BREEZINGFORMS_RECORDS_XMLNORWRTBL'))."'); window.history.go(-1);</script>\n";
			exit();
		} // if

		$database->setQuery(
			"update #__facileforms_records set exported=1 where id in ($ids)"
		);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} // if
		else
		{
			@ob_end_clean();
			$_size = filesize($xmlname);
			$_name = basename($xmlname);
			@ini_set("zlib.output_compression", "Off");
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: private");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=$_name");
			header("Accept-Ranges: bytes");
			header("Content-Length: $_size");
			readfile($xmlname);
			exit;
		}

	} // expxml
        
        function renderFile($file, $record_id, $element_id, $file_index){
            if(JRequest::getVar('renderFile','') != '' && md5(basename($file).$record_id.$element_id.$file_index) == JRequest::getVar('renderFile','')){
                ob_end_clean();
                $this->resizeFile($file, 200, 200, '#ffffff', 'simple');
                exit;
            }
            if(JRequest::getVar('downloadFile','') != '' && md5(basename($file).$record_id.$element_id.$file_index) == JRequest::getVar('downloadFile','')){
                ob_end_clean();
                $this->downloadFile($file);
                exit;
            }
            $image = @getimagesize( $file );
            $ids = JRequest::getVar('ids', array());
            if($image !== false){
                echo '<a href="admin-ajax.php?action=breezingformsadminajax&task=edit&form=&write_status=&act=recordmanagement&status_update=0&Order=ASC&orderBy=submitted&limitstart=0&mylimit=20&exportt=0&ids[]='.intval($ids[0]).'&downloadFile='.md5(basename($file).$record_id.$element_id.$file_index).'"><img src="admin-ajax.php?action=breezingformsadminajax&task=edit&form=&write_status=&act=recordmanagement&status_update=0&Order=ASC&orderBy=submitted&limitstart=0&mylimit=20&exportt=0&ids[]='.intval($ids[0]).'&renderFile='.md5(basename($file).$record_id.$element_id.$file_index).'" border=\"0\"/></a><br/>';
            }else{
                echo '<a href="admin-ajax.php?action=breezingformsadminajax&task=edit&form=&write_status=&act=recordmanagement&status_update=0&Order=ASC&orderBy=submitted&limitstart=0&mylimit=20&exportt=0&ids[]='.intval($ids[0]).'&downloadFile='.md5(basename($file).$record_id.$element_id.$file_index).'">'.basename($file).'</a>';
            }
        }
        
        public function downloadFile($filename){
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: inline; filename="'.basename($filename).'"');
            header('Content-Length: ' . @filesize($filename));
            $chunksize = 1*(1024*1024); // how many bytes per chunk
            $buffer = '';
            $handle = @fopen($filename, 'rb');
            if ($handle === false) {
              return false;
            }
            while (!@feof($handle)) {
              $buffer = @fread($handle, $chunksize);
              print $buffer;
            }
            return @fclose($handle);
        }
        
        public function exifImageType($filename){
            // some hosting providers think it is a good idea not to compile in exif with php...
            if ( ! function_exists( 'exif_imagetype' ) ) {
                if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) {
                    return $type;
                }
                return false;
            }else{
                return exif_imagetype($filename);
            }
        }

        public function resizeFile($path, $width, $height, $bgcolor = '#ffffff', $type = ''){
            $image = @getimagesize( $path );

            if($image !== false){

               if($image[0] > 16384){
                   return;
               }

               if($image[1] > 16384){
                   return;
               }

               $col_ = $bgcolor;
               if($bgcolor !== null){
                   $col = array();
                   $col[0] = intval(@hexdec(@substr($bgcolor, 1, 2)));
                   $col[1] = intval(@hexdec(@substr($bgcolor, 3, 2)));
                   $col[2] = intval(@hexdec(@substr($bgcolor, 5, 2)));
                   $col_ = $col;
               }
               $exif_type = $this->exifImageType( $path );
               // try to prevent memory issues
               $memory = true;

               $imageInfo = $image;

               $MB = 1048576;
               $K64 = 65536;
               $TWEAKFACTOR = 1.5;
               $channels = isset($image['channels']) ? $image['channels'] : 0;
               $memoryNeeded = round(( $image[0] * $image[1]
                       * $image['bits']
                       * ($channels / 8)
                       + $K64
                       ) * $TWEAKFACTOR
               );

               $ini = 8 * $MB;
               if(ini_get('memory_limit') !== false){
                   $ini = $this->returnBytes(ini_get('memory_limit'));
               }
               $memoryLimit = $ini;
               if (function_exists('memory_get_usage') &&
                       memory_get_usage() + $memoryNeeded > $memoryLimit) {
                   $memory = false;
               }
               if($memory){
                   switch ($exif_type){
                       case IMAGETYPE_JPEG2000 :
                       case IMAGETYPE_JPEG :
                           $resource = @imagecreatefromjpeg($path);
                           if($resource){
                               $resized = @$this->resize_image($resource, $width, $height, $type == 'crop' ? 1 : ( $type == 'simple' ? 3 : 2), $col_);
                               if($resized) {
                                   ob_start();
                                   @imagejpeg($resized);
                                   $buffer = ob_get_contents();
                                   ob_end_clean();
                                   if($exif_type == IMAGETYPE_JPEG2000){
                                       header('Content-Type: ' . @image_type_to_mime_type(IMAGETYPE_JPEG2000));
                                   }else{
                                       header('Content-Type: ' . @image_type_to_mime_type(IMAGETYPE_JPEG));
                                   }
                                   header('Content-Disposition: inline; filename="'.basename($path).'"');
                                   echo $buffer;
                                   @imagedestroy($resized);
                               }
                               @imagedestroy($resource);
                           }
                           break;
                       case IMAGETYPE_GIF :
                           $resource = @imagecreatefromgif($path);
                           if($resource){
                               $resized = @$this->resize_image($resource, $width, $height, $type == 'crop' ? 1 : ( $type == 'simple' ? 3 : 2), $col_);
                               if($resized) {
                                   ob_start();
                                   @imagegif($resized);
                                   $buffer = ob_get_contents();
                                   ob_end_clean();
                                   header('Content-Type: ' . @image_type_to_mime_type(IMAGETYPE_GIF));
                                   header('Content-Disposition: inline; filename="'.basename($path).'"');
                                   echo $buffer;
                                   @imagedestroy($resized);
                               }
                               @imagedestroy($resource);
                           }
                           break;
                       case IMAGETYPE_PNG :
                           $resource = @imagecreatefrompng($path);
                           if($resource){
                               $resized = @$this->resize_image($resource, $width, $height, $type == 'crop' ? 1 : ( $type == 'simple' ? 3 : 2), $col_);
                               if($resized) {
                                   ob_start();
                                   @imagepng($resized);
                                   $buffer = ob_get_contents();
                                   ob_end_clean();
                                   header('Content-Type: ' . @image_type_to_mime_type(IMAGETYPE_PNG));
                                   header('Content-Disposition: inline; filename="'.basename($path).'"');
                                   echo $buffer;
                                   @imagedestroy($resized);
                               }
                               @imagedestroy($resource);
                           }
                           break;
                   }
               }
            }
        }

        public function resize_image($source_image, $destination_width, $destination_height, $type = 0, $bgcolor = array(0,0,0)) {
            // $type (1=crop to fit, 2=letterbox)
            $source_width = imagesx($source_image);
            $source_height = imagesy($source_image);
            $source_ratio = $source_width / $source_height;
            if($destination_height == 0 && $type == 3){
                $destination_height = $source_height;
            }
            $destination_ratio = $destination_width / $destination_height;
            if($type == 3){

                $old_width  = $source_width;
                $old_height = $source_height;

                // Target dimensions
                $max_width = $destination_width;
                $max_height = $destination_height;
                // Get current dimensions

                // Calculate the scaling we need to do to fit the image inside our frame
                $scale      = min($max_width/$old_width, $max_height/$old_height);

                // Get the new dimensions
                $destination_width  = ceil($scale*$old_width);
                $destination_height = ceil($scale*$old_height);

                $new_destination_width = $destination_width;
                $new_destination_height = $destination_height;

                $source_x = 0;
                $source_y = 0;
                $destination_x = 0;
                $destination_y = 0;

            } else if ($type == 1) {
                // crop to fit
                if ($source_ratio > $destination_ratio) {
                    // source has a wider ratio
                    $temp_width = (int) ($source_height * $destination_ratio);
                    $temp_height = $source_height;
                    $source_x = (int) (($source_width - $temp_width) / 2);
                    $source_y = 0;
                } else {
                    // source has a taller ratio
                    $temp_width = $source_width;
                    $temp_height = (int) ($source_width * $destination_ratio);
                    $source_x = 0;
                    $source_y = (int) (($source_height - $temp_height) / 2);
                }
                $destination_x = 0;
                $destination_y = 0;
                $source_width = $temp_width;
                $source_height = $temp_height;
                $new_destination_width = $destination_width;
                $new_destination_height = $destination_height;
            } else {
                // letterbox
                if ($source_ratio < $destination_ratio) {
                    // source has a taller ratio
                    $temp_width = (int) ($destination_height * $source_ratio);
                    $temp_height = $destination_height;
                    $destination_x = (int) (($destination_width - $temp_width) / 2);
                    $destination_y = 0;
                } else {
                    // source has a wider ratio
                    $temp_width = $destination_width;
                    $temp_height = (int) ($destination_width / $source_ratio);
                    $destination_x = 0;
                    $destination_y = (int) (($destination_height - $temp_height) / 2);
                }
                $source_x = 0;
                $source_y = 0;
                $new_destination_width = $temp_width;
                $new_destination_height = $temp_height;
            }
            $destination_image = imagecreatetruecolor($destination_width, $destination_height);
            if ($type == 2) {
                imagefill($destination_image, 0, 0, imagecolorallocate($destination_image, $bgcolor[0], $bgcolor[1], $bgcolor[2]));
            }
            imagecopyresampled($destination_image, $source_image, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height);
            return $destination_image;
        }

        public function returnBytes($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);
            switch($last) {
                // The 'G' modifier is available since PHP 5.1.0
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }

            return $val;
        }

	function exppdf($ids)
	{
		global $ff_compath;

                $file = WP_CONTENT_DIR.'/breezingforms/pdftpl/export_custom_pdf.php';
		if(!JFile::exists($file)){
			$file = WP_CONTENT_DIR.'/breezingforms/pdftpl/export_pdf.php';
		}

		$ids = implode(',', $ids);
		$this->db->setQuery(
			"select * from #__facileforms_records where id in ($ids) order by submitted Desc"
		);
		$recs = $this->db->loadObjectList();

                $this->db->setQuery(
			"update #__facileforms_records set exported=1 where id in ($ids)"
		);
                $this->db->query();

		ob_end_clean();
		ob_start();
		require_once($file);
		$c = ob_get_contents();
		ob_end_clean();

		require_once(JPATH_SITE.'/administrator/components/com_breezingforms/libraries/tcpdf/tcpdf.php');

		$pdf = new TCPDF();
                $pdf->setPrintHeader(false);
		$pdf->AddPage();
		$pdf->writeHTML($c);
		$pdfname = $ff_compath.'/exports/ffexport-pdf-'.date('YmdHis').'.pdf';
		$pdf->lastPage();
		$pdf->Output($pdfname, "F");
		$pdf->Output(basename($pdfname), "D");
		exit;
	}

	function getSubrecords($recordId)
	{
		$this->db->setQuery(
				"select Distinct subs.* from #__facileforms_subrecords As subs, #__facileforms_elements as els where els.id=subs.element And subs.record = ".intval($recordId)." order by els.ordering"
			);
		return $this->db->loadObjectList();
	}

	function expcsv(array $ids)
	{
                global $ff_config;

                $csvdelimiter = stripslashes($ff_config->csvdelimiter);
                $csvquote = stripslashes($ff_config->csvquote);
                $cellnewline = $ff_config->cellnewline == 0 ? "\n" : "\\n";

		$fields = array();
		$lines = array();
		$ids = implode(',', $ids);
		$this->db->setQuery(
			"select * from #__facileforms_records where id in ($ids) order by submitted Desc"
		);
		$recs = $this->db->loadObjectList();
		$recsSize = count($recs);
		for($r = 0; $r < $recsSize; $r++) {

                        $rec = $recs[$r];

			$lineNum = count($lines);
                        
			$fields['ID'] = true;
			$fields['SUBMITTED'] = true;
			$fields['USER_ID'] = true;
			$fields['USERNAME'] = true;
			$fields['USER_FULL_NAME'] = true;
			$fields['TITLE'] = true;
			$fields['IP'] = true;
			$fields['BROWSER'] = true;
			$fields['OPSYS'] = true;
			$fields['TRANSACTION_ID'] = true;
			$fields['DATE'] = true;
			$fields['TEST_ACCOUNT'] = true;
			$fields['DOWNLOAD_TRIES'] = true;

			$lines[$lineNum]['ID'][] = $rec->id;
			$lines[$lineNum]['SUBMITTED'][] = $rec->submitted;
			$lines[$lineNum]['USER_ID'][] = $rec->user_id;
			$lines[$lineNum]['USERNAME'][] = $rec->username;
			$lines[$lineNum]['USER_FULL_NAME'][] = $rec->user_full_name;
			$lines[$lineNum]['TITLE'][] = $rec->title;
			$lines[$lineNum]['IP'][] = $rec->ip;
			$lines[$lineNum]['BROWSER'][] = $rec->browser;
			$lines[$lineNum]['OPSYS'][] = $rec->opsys;
			$lines[$lineNum]['TRANSACTION_ID'][] = $rec->paypal_tx_id;
			$lines[$lineNum]['DATE'][] = $rec->paypal_payment_date;
			$lines[$lineNum]['TEST_ACCOUNT'][] = $rec->paypal_testaccount;
			$lines[$lineNum]['DOWNLOAD_TRIES'][] = $rec->paypal_download_tries;

			$rec = $recs[$r];
			$this->db->setQuery(
				"select Distinct * from #__facileforms_subrecords where record = $rec->id order by id"
			);
			$subs = $this->db->loadObjectList();
			$subsSize = count($subs);
			for($s = 0; $s < $subsSize; $s++) {
				$sub = $subs[$s];
				if($sub->name != 'bfFakeName' && $sub->name != 'bfFakeName2' && $sub->name != 'bfFakeName3' && $sub->name != 'bfFakeName4'){
					if(!isset($fields[$sub->name]))
					{
						$fields[$sub->name] = true;
					}
                                        if($sub->type == 'File Upload' && strpos(strtolower($sub->value), '{cbsite}') === 0){
                                            $out = '';
                                            $nl = '';
                                            $_values = explode("\n",str_replace("\r",'',$sub->value));
                                            $length = count($_values);
                                            $i = 0;
                                            foreach($_values As $_value){
                                               if($i+1 < $length){
                                                   $nl = "\n";
                                               }else{
                                                   $nl = '';
                                               }
                                               $out .= str_replace(array('{cbsite}','{CBSite}'), array(JPATH_SITE, JPATH_SITE), $_value).$nl;
                                               $i++;
                                            }
                                            $sub->value = $out;
                                        }
					$lines[$lineNum][$sub->name][] = $sub->value;
				}
			}
		}

		$head = '';
		//ksort($fields);
		$lineLength = count($lines);
		foreach($fields As $fieldName => $null)
		{
			$head .= $csvquote.$fieldName.$csvquote.$csvdelimiter;
			for($i = 0; $i < $lineLength;$i++)
			{
				if(!isset($lines[$i][$fieldName]))
				{
					$lines[$i][$fieldName] = array();
				}
			}
		}

		$head = substr($head,0,strlen($head)-1) . nl();

		$out = '';
		for($i = 0; $i < $lineLength;$i++)
		{
			//ksort($lines[$i]);
			foreach($lines[$i] As $line){
				$out .= $csvquote.str_replace($csvquote,$csvquote.$csvquote,str_replace("\n",$cellnewline,str_replace("\r","",implode('|',$line)))).$csvquote.$csvdelimiter;
			}
			$out = substr($out,0,strlen($out)-1);
			$out .= nl();
		}

		$csvname = JPATH_SITE.'/components/com_breezingforms/exports/ffexport-'.date('YmdHis').'.csv';
		JFile::makeSafe($csvname);
		if (!JFile::write($csvname,$headout = $head.$out)) {
			echo "<script> alert('".addslashes(BFText::_('COM_BREEZINGFORMS_RECORDS_XMLNORWRTBL'))."'); window.history.go(-1);</script>\n";
			exit();
		} // if

                $this->db->setQuery(
			"update #__facileforms_records set exported=1 where id in ($ids)"
		);
                $this->db->query();

		/*
		$data = JFile::read($csvname);
		$files[] = array('name' => basename($csvname), 'data' => $data);

		$zip = JArchive::getAdapter('zip');
		$path = JPATH_SITE.'/components/com_breezingforms/exports/ffexport-csv-'.date('YmdHis').'.zip';
		$zip->create($path, $files);
		JFile::delete($csvname);
		*/
		@ob_end_clean();
		$_size = filesize($csvname);
		$_name = basename($csvname);
		@ini_set("zlib.output_compression", "Off");

                Header("Content-Type: text/comma-separated-values; charset=utf-8");
                Header("Content-Disposition: attachment;filename=\"$_name\"");
                Header("Content-Transfer-Encoding: 8bit");

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: private");
		//header("Content-Type: application/octet-stream");
		//header("Content-Disposition: attachment; filename=$_name");
		//header("Accept-Ranges: bytes");
		//header("Content-Length: $_size");
                ob_start();
		readfile($csvname);
                $c = ob_get_contents();
                ob_end_clean();
                if(function_exists('mb_convert_encoding')){
                    $to_encoding = 'UTF-16LE';
                    $from_encoding = 'UTF-8';
                    echo chr(255).chr(254).mb_convert_encoding( $c, $to_encoding, $from_encoding);
                } else {
                    echo $c;
                }
		exit;
	}
}


