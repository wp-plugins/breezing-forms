<?php
/**
* BreezingForms - A Joomla Forms Application
* @version 1.8
* @package BreezingForms
* @copyright (C) 2008-2012 by Markus Bopp
* @license Released under the terms of the GNU General Public License
**/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

jimport('joomla.version');
$version = new JVersion();

class HTML_facileFormsConf
{
	public static function edit($option, $caller, $pkg, $downloadfile='')
	{
		global $ff_mossite, $ff_config, $ff_admsite, $ff_admicon, $ff_version;
?>
		<form action="admin.php?page=breezingforms" method="post" name="adminForm">
		<div style="float:right;">
                <button class="button-primary" onclick="submitbutton('save');"><?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_SAVE'); ?></button>
                <button class="button-secondary" onclick="submitbutton('instpackage');"><?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_PKGINSTLR'); ?></button>
                <button class="button-secondary" onclick="submitbutton('makepackage');"><?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_CREAPKG'); ?></button>
                </div>
                <div style="clear:both;"></div>
                <p></p>
                <table cellpadding="4" cellspacing="1" border="0" class="adminform" style="width:100%;">
			
                    <tr>
                        <td colspan="3"><legend>Basic Email Settings</legend></td>
                    </tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_DEFAULTEMAIL'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" name="emailadr" value="<?php echo $ff_config->emailadr; ?>"/></td>
				<td><input type="hidden" name="images" value="<?php echo $ff_config->images; ?>"/></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_MAILER'); ?></td>
				<td colspan="3">
                                    <input type="radio" name="mailer" value="smtp"<?php echo $ff_config->mailer == 'smtp' ? ' checked="checked"' : ''; ?>/> SMTP
                                    <input type="radio" name="mailer" value="mail"<?php echo $ff_config->mailer == 'mail' ? ' checked="checked"' : ''; ?>/> PHP
                                    <input type="radio" name="mailer" value="sendmail"<?php echo $ff_config->mailer == 'sendmail' ? ' checked="checked"' : ''; ?>/> Sendmail
                                </td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SENDMAIL'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="sendmail" value="<?php echo $ff_config->sendmail; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_MAILFROM'); ?> <em>(email address)</em></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="mailfrom" value="<?php echo $ff_config->mailfrom; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_FROMNAME'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="fromname" value="<?php echo $ff_config->fromname; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
                        <td colspan="3"><legend>Advanced Email Settings</legend></td>
                        </tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SMTPAUTH'); ?></td>
				<td colspan="3">
                                    <input type="radio" name="smtpauth" value="1"<?php echo $ff_config->smtpauth == 1 ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_YES'); ?>
                                    <input type="radio" name="smtpauth" value="0"<?php echo $ff_config->smtpauth == 0 ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_NO'); ?>
                                    
                                </td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SMTPSECURE'); ?></td>
				<td colspan="3">
                                    
                                    <input type="radio" name="smtpsecure" value="none"<?php echo $ff_config->smtpsecure == 'none' ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_NONE'); ?>
                                    <input type="radio" name="smtpsecure" value="ssl"<?php echo $ff_config->smtpsecure == 'ssl' ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SSL'); ?>
                                    <input type="radio" name="smtpsecure" value="tls"<?php echo $ff_config->smtpsecure == 'tls' ? ' checked="checked"' : ''; ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_TLS'); ?>
                                </td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SMTPPORT'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="smtpport" value="<?php echo $ff_config->smtpport; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SMTPUSER'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="smtpuser" value="<?php echo $ff_config->smtpuser; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SMTPPASS'); ?></td>
				<td colspan="3"><input type="password" style="width:100%" maxlength="255" name="smtppass" value="<?php echo $ff_config->smtppass; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_SMTPHOST'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="smtphost" value="<?php echo $ff_config->smtphost; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr>
                        <td colspan="3"><legend>CSV Export Settings</legend></td>
                        </tr>
                        
                         <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_CSVDELIMITER'); ?></td>
				<td colspan="3"><input type="text" size="1" maxlength="1" name="csvdelimiter" value="<?php echo htmlentities(stripslashes($ff_config->csvdelimiter), ENT_QUOTES, 'UTF-8'); ?>"/></td>
				<td></td>
			</tr>
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_CSVQUOTE'); ?></td>
				<td colspan="3"><input type="text" size="1" maxlength="1" name="csvquote" value="<?php echo htmlentities(stripslashes($ff_config->csvquote), ENT_QUOTES, 'UTF-8'); ?>"/></td>
				<td></td>
			</tr>
                        <tr>
				<td><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_CSVQUOTENEWLINE'); ?></td>
                                <td colspan="3"><input type="radio" name="cellnewline" value="0"<?php echo $ff_config->cellnewline == 0 ? ' checked="checked"' : '' ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_CSVQUOTENEWLINE_REGULAR'); ?> <input type="radio" name="cellnewline" value="1"<?php echo $ff_config->cellnewline != 0 ? ' checked="checked"' : '' ?>/> <?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_CSVQUOTENEWLINE_QUOTED'); ?></td>
				<td></td>
			</tr>
                        
                        <tr>
                        <td colspan="3"><legend>Misc</legend></td>
                        </tr>
                        
                        <tr>
				<td width="25%"><?php echo BFText::_('COM_BREEZINGFORMS_CONFIG_FFUPLOADS'); ?></td>
				<td colspan="3"><input type="text" style="width:100%;" maxlength="255" name="uploads" value="<?php echo $ff_config->uploads; ?>"/></td>
				<td></td>
			</tr>
                        
                        <tr><td colspan="6">Version: BreezingForms <?php echo $ff_version; ?></td></tr>
			
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="configuration" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="caller_url" value="<?php echo htmlspecialchars($caller, ENT_QUOTES); ?>" />
		<input type="hidden" name="pkg" value="<?php echo $pkg; ?>" />
                <p></p>
                <div style="float:right;">
                <button class="button-primary" onclick="submitbutton('save');"><?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_SAVE'); ?></button>
                <button class="button-secondary" onclick="submitbutton('instpackage');"><?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_PKGINSTLR'); ?></button>
                <button class="button-secondary" onclick="submitbutton('makepackage');"><?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_CREAPKG'); ?></button>
                </div>
                <div style="clear:both;"></div>
                
		</form>
<?php
		if ($downloadfile != '') {
?>
		<script type="text/javascript">onload=function(){document.dldform.submit();}</script>
		<form action="<?php echo WP_PLUGIN_URL;?>/<?php echo BF_FOLDER;?>/platform/administrator/components/com_breezingforms/admin/download.php" method="post" name="dldform">
		<input type="hidden" name="filename" value="<?php echo $downloadfile; ?>" />
		</form>
<?php
		} // if
	} // edit

	public static function instPackage($option, $caller, $pkg, &$rows)
	{
		global $ff_mossite, $ff_config, $ff_admpath, $mainframe;
		$startdir = '{mospath}/administrator/components/com_breezingforms/packages/samples.english.xml';
?>
		<script type="text/javascript">
		<!--
		function submitbutton(pressbutton)
		{
			var form = document.adminForm;
			switch (pressbutton) {
				case 'delpkgs':
					if (form.boxchecked.value==0) {
						alert("<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELPKGSFIRST'); ?>");
						return;
					} // if
					break;
				default:
					break;
			} // switch
			switch (pressbutton) {
				case 'start':
					if (form.uploadpackage.checked) {
						if (form.uploadfile.value == '') {
							alert("<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_NOUPLOADFILE'); ?>");
							form.uploadfile.focus();
							return;
						} // if
						pressbutton = 'uploadpackage';
					} else
						if (form.localpackage.checked) {
							if (form.installfile.value == '') {
								alert("<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_NOFILENAME'); ?>");
								form.installfile.focus();
								return;
							} // if
							pressbutton = 'localpackage';
						} else {
							alert("<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELECTMODE'); ?>");
							return;
						} // if
					break;
				case 'delpkgs':
					if (!confirm("<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ASKUNINST'); ?>")) return;
					break;
				default:
					break;
			} // switch
			submitform(pressbutton);
		} // submitbutton

		function clickInstMode(value)
		{
			var form = document.adminForm;
			switch (parseInt(value)) {
				case 0:
					document.getElementById('div_uploadpackage').style.display='';
					document.getElementById('div_localpackage').style.display='none';
					break;
				default:
					document.getElementById('div_uploadpackage').style.display='none';
					document.getElementById('div_localpackage').style.display='';
					break;
			} // switch
		} // clickInstMode
		//-->
		</script>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script type="text/javascript" src="<?php echo $ff_mossite; ?>/components/com_breezingforms/libraries/js/overlib_mini.js"></script>

		<form action="admin.php?page=breezingforms" method="post" name="adminForm" enctype="multipart/form-data" >
		<table cellpadding="4" cellspacing="1" border="0">
			<tr>
				<td valign="top" nowrap>
					<table class="adminheading">
						<tr><td align="top"><strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_INSTALLPKG'); ?></strong></td></tr>
					</table>
				</td>
				<td nowrap width="50">
				</td>
				<td nowrap width="100%">
<?php
			if ((bool)ini_get('file_uploads')) {
				$upldattr = ' checked="checked"';
				$uplddisp = '';
				$loclattr = '';
				$locldisp = ' style="display:none;"';
			} else {
				$upldattr = ' disabled="disabled"';
				$uplddisp = ' style="display:none;"';
				$loclattr = ' checked="checked"';
				$locldisp = '';
			} // if
?>
					<input type="radio" id="uploadpackage" name="tasksel" value="0" onclick="clickInstMode(this.value)"<?php echo $upldattr; ?>/>
					<label for="uploadpackage"> <?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CLIENTUPLOAD'); ?></label>
					<br/>
					<input type="radio" id="localpackage" name="tasksel" value="1" onclick="clickInstMode(this.value)"<?php echo $loclattr; ?>/>
					<label for="localpackage"> <?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SERVERINSTALL'); ?></label>
					<div id="div_uploadpackage"<?php echo $uplddisp; ?>>
						<br/>
						<input type="file" id="uploadfile" name="uploadfile" size="70" />
					</div>
					<div id="div_localpackage"<?php echo $locldisp; ?>>
						<br/>
						<input type="text" id="installfile" name="installfile" size="80" value="<?php echo $startdir; ?>"/>
					</div>
				</td>
                                <td align="right" valign="top" nowrap>
                                       <button onclick="submitbutton('uploadpackage')" class="button">
                                        <?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_INSTPKG');?>
                                        </button>

                                        <button onclick="submitbutton('delpkgs')" class="button">
                                        <?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_UINSTPKGS');?>
                                        </button>

                                        <button onclick="submitbutton('edit')" class="button">
                                        <?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_CANCEL');?>
                                        </button>
                                </td>
			</tr>
		</table>
		<table class="widefat">
                    <thead>
			<tr>
				<th nowrap align="center"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
				<th nowrap colspan="4" align="left"><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE'); ?></th>
				<th nowrap colspan="2" align="left"><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR'); ?></th>
			</tr>
                    </thead>
                    <tbody>
<?php               
			$k = 0;
			for($i=0; $i < count($rows); $i++) {
				$row = $rows[$i];
				$url = htmlspecialchars($row->url);
				if (substr($url,0,7)=='http://') $url = substr($url,7);
				$email = htmlspecialchars($row->email);
				if (substr($email,0,7)=='mailto:') $email = substr($email,7);
?>
				<tr class="row<?php echo $k; ?>">
					<td nowrap valign="top" align="center"><input type="checkbox" id="cb<?php echo $i; ?>" name="ids[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
					<td nowrap valign="top" align="left">
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ID'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_NAME'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_VERS'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CREATEDATE'); ?></strong>
					</td>
					<td nowrap valign="top" align="left">
						<?php echo htmlspecialchars($row->id); ?><br/>
						<?php echo htmlspecialchars($row->name); ?><br/>
						<?php echo htmlspecialchars($row->version); ?><br/>
						<?php echo htmlspecialchars($row->created); ?>
					</td>
					<td nowrap valign="top" align="left">
						<br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_TITLE'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_DESC'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CPYRT'); ?></strong>
					</td>
					<td nowrap valign="top" align="left">
						<br/>
						<?php echo htmlspecialchars($row->title); ?><br/>
						<?php echo htmlspecialchars($row->description); ?><br/>
						<?php echo htmlspecialchars($row->copyright); ?>
					</td>
					<td nowrap valign="top" align="left">
						<br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_NAME'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_EMAIL'); ?></strong><br/>
						<strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_URL'); ?></strong>
					</td>
					<td nowrap valign="top" align="left" width="100%">
						<br/>
						<?php echo htmlspecialchars($row->author); ?><br/>
						<?php if ($email!='') echo '<a href="mailto:'.$email.'">'.$email.'</a>'; else echo '&nbsp;' ;?><br/>
						<?php if ($url!='') echo '<a href="http://'.$url.'" target="_blank">http://'.$url.'</a>'; else echo '&nbsp;' ;?>
					</td>
				</tr>
<?php
				$k = 1 - $k;
			} // for
?>
                    </tbody>
		</table>
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="configuration" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="caller_url" value="<?php echo htmlspecialchars($caller, ENT_QUOTES); ?>" />
		<input type="hidden" name="pkg" value="<?php echo $pkg; ?>" />
		</form>
<?php
	} // instPackage

	public static function makePackage($option, $caller, $pkg, $lists)
	{
		global $ff_mossite, $ff_config;
		$startdir = '{mossite}/administrator/components/com_breezingforms/packages';
		$rows = $lists['pkgnames'];
		$empty = false; $selpkg = '';
		if (count($rows)) foreach ($rows as $row) {
			if ($row->package=='') $empty = true;
			if ($row->package==$pkg) $selpkg = $pkg;
		} // foreach
?>
		<script type="text/javascript">
			<!--
			onload = function()
			{
				var form = document.adminForm;
<?php
				echo "\t\t\t\tpkgChange('$selpkg');\n"
?>
				form.pkg.focus();
			} // onload

			function setSelection(topic, selected)
			{
				var form = document.adminForm;
				var opts;
				switch (topic) {
					case  2: opts = form.id_menusel.options; break;
					case  3: opts = form.id_scriptsel.options; break;
					case  4: opts = form.id_piecesel.options; break;
					default: opts = form.id_formsel.options;
				} // switch
				for (var i = 0; i < opts.length; i++) opts[i].selected = selected;
			} // setSelection

			var pkgs = [
<?php
			$first = true;
			$pkgs = $lists['packages'];
			if (count($pkgs)) foreach ($pkgs as $pkg1) {
				if (!$first) echo ",\n";
				echo "\t\t\t\t[".
					"\"".addslashes($pkg1->id)."\",".
					"\"".addslashes($pkg1->name)."\",".
					"\"".addslashes($pkg1->version)."\",".
					"\"".addslashes($pkg1->title)."\",".
					"\"".addslashes($pkg1->author)."\",".
					"\"".addslashes($pkg1->email)."\",".
					"\"".addslashes($pkg1->url)."\",".
					"\"".addslashes($pkg1->description)."\",".
					"\"".addslashes($pkg1->copyright)."\"]";
				$first = false;
			} // foreach
			echo "\n";
?>
			];

			function pkgChange(pkg)
			{
				if (pkg == '') {
					document.getElementById('menusel').style.display = '';
					document.getElementById('scriptsel').style.display = '';
				} else {
					document.getElementById('menusel').style.display = 'none';
					document.getElementById('scriptsel').style.display = 'none';
				} // if
				var p;
				var form = document.adminForm;
				for (p = 0; p < pkgs.length; p++) {
					if (pkgs[p][0]==pkg) {
						form.pkg_name.value         = pkgs[p][1];
						form.pkg_version.value      = pkgs[p][2];
						form.pkg_title.value        = pkgs[p][3];
						form.pkg_author.value       = pkgs[p][4];
						form.pkg_email.value        = pkgs[p][5];
						form.pkg_url.value          = pkgs[p][6];
						form.pkg_description.value  = pkgs[p][7];
						form.pkg_copyright.value    = pkgs[p][8];
						break;
					} // if
				} // for
			} // pkgChange

			function submitbutton( pressbutton )
			{
				if (pressbutton == 'mkpackage') {
					var invalidChars = /\W\./;
					var form = document.adminForm;
					error = '';
					foc = '';
					if (form.pkg_name.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTPACKAGENAME'); ?>\n";
						if (foc=='') foc = form.pkg_name;
					} else
						if (invalidChars.test(form.pkg_name.value)) {
							error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTIDENTIFIER'); ?>\n";
							if (foc=='') foc = form.pkg_name;
						} // if
					if (form.pkg_version.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTVERSION'); ?>\n";
						if (foc=='') foc = form.pkg_version;
					} // if
					if (form.pkg_title.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTTITLE'); ?>\n";
						if (foc=='') foc = form.pkg_title;
					} // if
					if (form.pkg_author.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTAUTHORNM'); ?>\n";
						if (foc=='') foc = form.pkg_author;
					} // if
					if (form.pkg_email.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTAUTHORMAIL'); ?>\n";
						if (foc=='') foc = form.pkg_email;
					} // if
					if (form.pkg_url.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTAUTHORURL'); ?>\n";
						if (foc=='') foc = form.pkg_url;
					} // if
					if (form.pkg_description.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTDESCR'); ?>\n";
						if (foc=='') foc = form.pkg_description;
					} // if
					if (form.pkg_copyright.value=='') {
						error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ENTCOPYRT'); ?>\n";
						if (foc=='') foc = form.pkg_copyright;
					} // if
					if (form.pkg.value=='') {
						var cnt = 0;
						var i;
						opts = form.id_scriptsel.options;
						for (i = 0; i < opts.length; i++) if (opts[i].selected) cnt++;
						opts = form.id_piecesel.options;
						for (i = 0; i < opts.length; i++) if (opts[i].selected) cnt++;
						opts = form.id_formsel.options;
						for (i = 0; i < opts.length; i++) if (opts[i].selected) cnt++;
						opts = form.id_menusel.options;
						for (i = 0; i < opts.length; i++) if (opts[i].selected) cnt++;
						if (cnt == 0)
							error += "<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELECTAPKG'); ?>\n";
					} // if
					if (error) {
						alert(error);
						if (foc != '') foc.focus();
						return;
					} // if
				} // if
				submitform( pressbutton );
			} // submitbutton
			//-->
		</script>
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script type="text/javascript" src="<?php echo $ff_mossite; ?>/components/com_breezingforms/libraries/js/overlib_mini.js"></script>
		<form action="admin.php?page=breezingforms" method="post" name="adminForm">
		<table cellpadding="4" cellspacing="1" border="0" class="adminform" style="width:300px;">
			<tr><td colspan="4" class="title" ><strong><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CREATEPKG'); ?></strong></td></tr>
			<tr>
				<td></td>
				<td colspan="2">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ID'); ?>:</td>
							<td nowrap width="100%">
								<select id="id_pkg" name="pkg" class="inputbox" onchange="pkgChange(this.value);" size="1">
<?php
									$rows = $lists['pkgnames'];
									if (!$empty) {
										if ($pkg == '') $sel = ' selected="selected"'; else $sel = '';
										echo '<option value=""'.$sel.'></option>';
									} // if
									if (count($rows)) foreach ($rows as $row) {
										if ($pkg == $row->package) $sel = ' selected="selected"'; else $sel = '';
										echo '<option value="'.$row->package.'"'.$sel.'>'.$row->package.'</option>';
									} // foreach
?>
								</select>
							</td>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_NAME'); ?>:</td>
							<td nowrap width="100%"><input type="text" name="pkg_name" size="30" maxlength="30"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_VERS'); ?>:</td>
							<td nowrap><input type="text" name="pkg_version" size="30" maxlength="30"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_TITLE'); ?>:</td>
							<td nowrap width="100%"><input type="text" name="pkg_title" size="50" maxlength="50"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_NAME'); ?>:</td>
							<td nowrap><input type="text" name="pkg_author" size="50" maxlength="50"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_EMAIL'); ?>:</td>
							<td nowrap><input type="text" name="pkg_email" size="50" maxlength="50"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_URL'); ?>:</td>
							<td nowrap><input type="text" name="pkg_url" size="50" maxlength="50"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_DESC'); ?>:</td>
							<td nowrap><input type="text" name="pkg_description" size="100" maxlength="100"/></td>
						</tr>
						<tr>
							<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CPYRT'); ?>:</td>
							<td nowrap><input type="text" name="pkg_copyright" size="100" maxlength="100"/></td>
						</tr>
					</table>
				</td>
				<td></td>
			</tr>
			<tr id="menusel" style="display:none;">
				<td></td>
				<td>
					<fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_FORMSEL'); ?></legend>
					<table align="center" cellpadding="4" cellspacing="1" border="0">
						<tr>
							<td nowrap style="text-align:center">
								<select id="id_formsel" name="formsel[]" class="inputbox" size="15" multiple="multiple">
<?php
									$rows = $lists['forms'];
									for ($i = 0; $i < count($rows); $i++) {
										$row = $rows[$i];
										echo '<option value="'.$row->id.'">'.$row->title.'</option>';
									} // for
?>
								</select><br/><br/>
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELECTALL'); ?>" onclick="setSelection(1,true)" />&nbsp;
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CLRSELECTION'); ?>" onclick="setSelection(1,false)" />
							</td>
						</tr>
					</table>
					</fieldset>
				</td>
				<td>
					<fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_MENUSEL'); ?></legend>
					<table align="center" cellpadding="4" cellspacing="1" border="0">
						<tr>
							<td nowrap style="text-align:center">
								<select id="id_menusel" name="menusel[]" class="inputbox" size="15" multiple="multiple">
<?php
									$rows = $lists['compmenus'];
									for ($i = 0; $i < count($rows); $i++) {
										$row = $rows[$i];
										echo '<option value="'.$row->id.'">'.$row->title.'</option>';
									} // for
?>
								</select><br/><br/>
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELECTALL'); ?>" onclick="setSelection(2,true)" />&nbsp;
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CLRSELECTION'); ?>" onclick="setSelection(2,false)" />
							</td>
						</tr>
					</table>
					</fieldset>
				</td>
				<td></td>
			</tr>
			<tr id="scriptsel" style="display:none;">
				<td></td>
				<td>
					<fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SCRIPTSEL'); ?></legend>
					<table align="center" cellpadding="4" cellspacing="1" border="0">
						<tr>
							<td nowrap style="text-align:center">
								<select id="id_scriptsel" name="scriptsel[]" class="inputbox" size="15" multiple="multiple">
<?php
									$rows = $lists['scripts'];
									for ($i = 0; $i < count($rows); $i++) {
										$row = $rows[$i];
										echo '<option value="'.$row->id.'">'.$row->title.'</option>';
									} // for
?>
								</select><br/><br/>
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELECTALL'); ?>" onclick="setSelection(3,true)" />&nbsp;
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CLRSELECTION'); ?>" onclick="setSelection(3,false)" />
							</td>
						</tr>
					</table>
					</fieldset>
				</td>
				<td>
					<fieldset><legend><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PIECESEL'); ?></legend>
					<table align="center" cellpadding="4" cellspacing="1" border="0">
						<tr>
							<td nowrap style="text-align:center">
								<select id="id_piecesel" name="piecesel[]" class="inputbox" size="15" multiple="multiple">
<?php
									$rows = $lists['pieces'];
									for ($i = 0; $i < count($rows); $i++) {
										$row = $rows[$i];
										echo '<option value="'.$row->id.'">'.$row->title.'</option>';
									} // for
?>
								</select><br/><br/>
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SELECTALL'); ?>" onclick="setSelection(4,true)" />&nbsp;
								<input class="button" type="button" value="<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CLRSELECTION'); ?>" onclick="setSelection(4,false)" />
							</td>
						</tr>
					</table>
					</fieldset>
				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap colspan="2" style="text-align:right">
                                        <input onclick="submitbutton('mkpackage');" type="submit" value="<?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_CONTINUE'); ?>"/>
					&nbsp;&nbsp;
                                        <input onclick="submitbutton('edit');" type="submit" value="<?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_CANCEL'); ?>"/>
				</td>
				<td></td>
			</tr>

		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="configuration" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="caller_url" value="<?php echo htmlspecialchars($caller, ENT_QUOTES); ?>" />
		</form>
<?php
	} // makePackage

	public static function message($option, $caller, $pkg, $message, $task='edit')
	{
?>
		<script type="text/javascript">onload=function(){submitform('<?php echo $task; ?>');}</script>
		<form action="admin.php?page=breezingforms" method="post" name="adminForm" >
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="configuration" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="caller_url" value="<?php echo htmlspecialchars($caller, ENT_QUOTES); ?>" />
		<input type="hidden" name="pkg" value="<?php echo $pkg; ?>" />
		<input type="hidden" name="mosmsg" value="<?php echo $message; ?>" />
		</form>
<?php
	} // message

	public static function showParam(&$inst, $tag)
	{
		if (array_key_exists($tag, $inst->params[0])) echo $inst->params[0][$tag];
	} // showParam

	public static function showPackage($option, $caller, $pkgid, &$inst)
	{
?>
		<form action="admin.php?page=breezingforms" method="post" name="adminForm">
		<table cellpadding="0" cellspacing="0" border="0" class="adminform" style="width:600px;">
			<tr><th colspan="4" class="title" >BreezingForms - <?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PKGREPORT'); ?></th></tr>
<?php
		if (array_key_exists('pkgid', $inst->params[0])) {
			$pkgid = $inst->params[0]['pkgid'];
?>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ID'); ?>:</td>
				<td nowrap><?php echo $pkgid; ?></td>
				<td></td>
			</tr>
<?php
		} else
			$pkgid = '';
?>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_INSTTYPE'); ?>:</td>
				<td nowrap width="100%"><?php HTML_facileFormsConf::showParam($inst, 'pkgtype'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_FFVERSION'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'pkgversion'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_NAME'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'name'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_TITLE'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'title'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PACKAGE').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_VERS'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'version'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap valign="top"><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_DESC'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'description'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CPYRT'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'copyright'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_CREATEDATE'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'creationDate'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_NAME'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'author'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_EMAIL'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'authorEmail'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_AUTHOR').' '.BFText::_('COM_BREEZINGFORMS_INSTALLER_URL'); ?>:</td>
				<td nowrap><?php HTML_facileFormsConf::showParam($inst, 'authorUrl'); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_SCRIPTSIMP'); ?>:</td>
				<td nowrap><?php echo count($inst->scripts); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_PIECESIMP'); ?>:</td>
				<td nowrap><?php echo count($inst->pieces); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_FORMSIMP'); ?>:</td>
				<td nowrap><?php echo count($inst->forms); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_ELEMSIMP'); ?>:</td>
				<td nowrap><?php echo count($inst->elements); ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td nowrap><?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_MENUSIMP'); ?>:</td>
				<td nowrap><?php echo count($inst->menus); ?></td>
				<td></td>
			</tr>
<?php
			if (count($inst->warnings)) {
?>
			<tr>
				<td></td>
				<td nowrap colspan="2">
					<hr/><br/>
					<?php echo BFText::_('COM_BREEZINGFORMS_INSTALLER_WARNINGS'); ?>:<br/><br/>
<?php
					foreach ($inst->warnings as $warn) echo $warn.'<br/>';
?>
				</td>
				<td></td>
			</tr>
<?php
			} // if
?>
			<tr>
				<td></td>
				<td nowrap colspan="2" style="text-align:right">
                                        <input onclick="submitbutton('instpackage');" type="submit" value="<?php echo BFText::_('COM_BREEZINGFORMS_TOOLBAR_CLOSE'); ?>"/>
				</td>
				<td></td>
			</tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="act" value="configuration" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="caller_url" value="<?php echo htmlspecialchars($caller, ENT_QUOTES); ?>" />
		<input type="hidden" name="pkg" value="<?php echo $pkgid; ?>" />
		</form>
<?php
	} // showPackage
} // class HTML_facileFormsConf
?>