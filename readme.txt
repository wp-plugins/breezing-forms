=== Breezing Forms ===
Contributors: crosstec
Donate link: http://crosstec.de/en/wordpress-forms-download.html
Tags: forms, form, captcha, contact, contact form, email, feedback, plugin, poll, Post, widget, survey
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 1.0

BreezingForms, an enterprise featured and professional form builder for Wordpress.

== Description ==
BreezingForms, an enterprise featured and professional form builder for WordPress. From simple forms up to complex form applications -- almost everything is possible! If you are a professional, serving multiple customers who frequently require forms or form based applications, then BreezingForms is the tool of your choice.

BreezingForms has a long history of innovations that haven't been seen in WordPress Plugins before and until today. We continuously develop and implement new interesting features. With BreezingForms, you are holding a quality and value extension in your hands that you don't want to miss again. 

No trial-ware, no light: The current version is a fully working GPL2 WordPress plugin. Members at [Crosstec](http://crosstec.de/) will have premium access to the latest versions + professional support.

[Website](http://crosstec.de/en/wordpress-forms-download.html) 
[Documentation](http://crosstec.de/en/support/breezingforms-documentation.html "View Documentation")
[Support Forum](http://crosstec.de/en/forums/index.html) 

= Features =

* Complete set of regular form creation features
* Mobile Support (Premium Upgrade): Create your form once and display for Desktop and Mobiles
* Business/CRM: Salesforce® integration  (Premium Upgrade)
* Sharing: Dropbox® integration  (Premium Upgrade)
* Newsletters: MailChimp® integration
* Conditional fields
* Multi file uploads with progress bars
* Summary Items
* Maximum length counters for textareas
* Captcha: Native and reCaptcha
* Email templates (shortcode & php based)
* PDF, CSV, XML attachments in reply-to emails
* PayPal payments (including pay-to-download-file)
* Multipage forms
* Responsive form layouts
* Form themes
* Widget Support
* Shortcode helper for posts and pages
* Record Export: PDF, CSV and XML
* Package system: Create your forms once and export them to other sites
* Scripts and CSS only printed when there is a form on the page (not in the entire site as this often happens with plugins)
* Developer friendly: Extend your forms within BreezingForms by using its PHP & Javascript API -- no hacking required.


== Installation ==

Minimum requirements:    
    
 Wordpress 3.0+    
 PHP 5.x    
 MySQL 4.x  

Standard installation method:

1. Upload the `breezingforms` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu
3. Go to the BreezingForms menu, finish the installation and create a new custom form or install the sample form package that ships with BreezingForms
4. Use shortcode [breezingforms name="FORM NAME"] in pages and posts. Use the editor helper to create shortcodes with more options.
5. Or add a new Widget and select the forms to display

Upload installation method (make sure uploads up to 5MB are allowed for your hosting):

1. Login to your WordPress site administrator panel and head over the 'Plugins' menu  
2. Click 'Add New'  
3. Choose the 'Upload' option
4. Click **Choose file** (**Browse**) and select the BreezingForms zip file.   
5. Click **Install Now** button.    
6. Once it is complete, activate the plugin.   
7. Go to the BreezingForms menu, finish the installation and create a new custom form or install the sample form package that ships with BreezingForms
8. Use shortcode [breezingforms name="FORM NAME"] in pages and posts. Use the editor helper to create shortcodes with more options.
9. Or add a new Widget and select the forms to display


== Screenshots ==
1. Example job application form with "Glossy Blue" theme
2. Form builder

== Frequently Asked Questions ==

= Q. After installation, I always get the configuration screen. How can I get past it? =

A. Please make sure the file and folder permissions are set correctly. The webserver use has to be able to write into the /wp-content/ folder. 

= Q. When I save a form I get a "catchable fatal error". What to do? =

A. This is most likely a permission issue. Please make sure to apply the appropriate rights to your files and folders. You can also try to 777 the folder /wp-content/breezingforms/ajax_cache/ (or create it if it doesn't exist). Please revert the permissions once you are sure that this was the reason.

= Q. I am pretty sure the permissions on my server are correct, but I still can't get past the setup screen (or still getting "catchable fatal error"). What else can I do? =

A. If not exists, create the folder /wp-content/breezingforms/. Inside that folder, create an empty file called "facileforms.process.php". Open BreezingForms again and see if you can get past the setup this time. If you still get "catchable fatal error", try the FTP layer settings in the facileforms.config.php. The FTP can help fixing permission issues.

= Q. Where do I find uploaded files? =

A. By default, all uploads go into /wp-content/breezingforms/uploads/. You can change the upload folder in the main configuration or for each upload element in its advanced configuration.

= Q. Where do I put a form theme? =

A. All themes go into the folder /wp-content/breezingforms/themes/. After that, the theme will be available from the theme selection in the form editor.

= Q. I want to edit the appearance of the PDF. How can I do that? =

A. You find the templates for the PDFs in /wp-content/breezingforms/pdftpl/. One template is for record exports, the other for attachments.


[Ask more questions in our forums](http://crosstec.de/en/forums/index.html "BreezingForms Forums")

== Changelog ==
= 1.0 =
* Initial Revision