<?php
class bf_config{
    public $mailer = "mail";
    public $mailfrom = "";
    public $fromname = "";
    public $smtpauth = "0";
    public $smtpsecure = "none";
    public $smtpport = "25";
    public $smtpuser = "";
    public $smtppass = "";
    public $smtphost = "localhost";
    public $sendmail = "/usr/sbin/sendmail";
    public $ftp_host = "127.0.0.1";
    public $ftp_port = "21";
    public $ftp_user = "";
    public $ftp_pass = "";
    public $ftp_root = "";
    public $ftp_enable = "0";
    public $stylesheet = "1";
    public $wysiwyg = "1";
    public $areasmall = "4";
    public $areamedium = "12";
    public $arealarge = "20";
    public $limitdesc = "100";
    public $emailadr = "";
    public $images = "{mossite}/components/com_breezingforms/images";
    public $uploads = "{contentdir}/breezingforms/uploads";
    public $movepixels = "5";
    public $compress = "1";
    public $livesite = "0";
    public $getprovider = "0";
    public $gridshow = "1";
    public $gridsize = "10";
    public $gridcolor1 = "#e0e0ff";
    public $gridcolor2 = "#ffe0e0";
    public $viewed = "0";
    public $exported = "0";
    public $archived = "0";
    public $formname = "";
    public $menupkg = "";
    public $formpkg = "";
    public $scriptpkg = "FF";
    public $piecepkg = "FF";
    public $csvdelimiter = ";";
    public $csvquote = "\"";
    public $cellnewline = "1";
    
    function __construct() {
        
        global $table_prefix;
        
        if(@file_exists(WP_CONTENT_DIR . '/breezingforms/facileforms.config.php')){
            require_once(WP_CONTENT_DIR . '/breezingforms/facileforms.config.php');
        }
        
        define('BF_MAILER', $this->mailer);
        define('BF_MAILFROM', $this->mailfrom);
        define('BF_FROMNAME', $this->fromname);
        define('BF_SMTPAUTH', $this->smtpauth);
        define('BF_SMTPSECURE', $this->smtpsecure);
        define('BF_SMTPPORT', $this->smtpport);
        define('BF_SMTPUSER', $this->smtpuser);
        define('BF_SMTPPASS', $this->smtppass);
        define('BF_SMTPHOST', $this->smtphost);
        define('BF_SENDMAIL', $this->sendmail);
        
        define('BF_FTPHOST', $this->ftp_host);
        define('BF_FTPPORT', $this->ftp_port);
        define('BF_FTPUSER', $this->ftp_user);
        define('BF_FTPPASS', $this->ftp_pass);
        define('BF_FTPROOT', $this->ftp_root);
        define('BF_FTPENABLE', $this->ftp_enable);
        
        define('BF_DBPREFIX', $table_prefix);
    }
    
}

new bf_config();

class JConfig
{
        // MAIL SETTINGS
        // set $mailer = 'smtp' for smtp and fill in the login data
        // other $mailer options: 'mail' and 'sendmail'
        public $mailer		= BF_MAILER;
	public $mailfrom	= BF_MAILFROM;
	public $fromname	= BF_FROMNAME;
	
        // SMTP EMAIL SETTINGS
	public $smtpauth	= BF_SMTPAUTH;
	public $smtpsecure      = BF_SMTPSECURE;
	public $smtpport	= BF_SMTPPORT;
	public $smtpuser	= BF_SMTPUSER;
	public $smtppass	= BF_SMTPPASS;
	public $smtphost	= BF_SMTPHOST; // usually localhost
        
        // IF 'mail' is choosen (default usually ok)
        public $sendmail	= BF_SENDMAIL;
        
        // FTP SETTINGS
        // This helps if you have permission issues on your server
        // for example on file uploads
        public $ftp_host	= BF_FTPHOST; // the ip or DNS name of the FTP server
	public $ftp_port	= BF_FTPPORT;
	public $ftp_user	= BF_FTPUSER;
	public $ftp_pass	= BF_FTPPASS;
	public $ftp_root	= BF_FTPROOT; // the base folder you get into after FTP login with your regular client
	public $ftp_enable	= BF_FTPENABLE; // set to 1 to enable the FTP layer
        
        #####################
        
        
        ### CAUTION: DO NOT CHANGE ANYTHING FROM HERE !!! ###
	public $dbtype		= 'mysql';
	public $host		= DB_HOST;
	public $user		= DB_USER;
	public $password	= DB_PASSWORD;
	public $db		= DB_NAME;
	public $dbprefix	= BF_DBPREFIX;
	public $tmp_path	= '/tmp';
	public $log_path	= '/var/logs';
	public $debug		= 0;
	public $caching		= '0';
	public $cachetime	= '900';
	public $language	= WPLANG;
	public $secret		= null;
	public $editor		= 'none';
	public $offset		= 0;
	public $lifetime	= 1440;
        public $session_handler = 'none';
        public $debug_lang      = 0;
        public $error_reporting = 0;
}
