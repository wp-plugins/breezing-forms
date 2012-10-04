=== Breezing Forms ===
Contributors: crosstec
Donate link: http://crosstec.de/en/wordpress-forms-download.html
Tags: forms, form, mobile, captcha, contact, contact form, email, feedback, iphone, android, Post, widget
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: 1.1.1
License: GPL 2

Breezing Forms, a professional and enterprise featured form builder for WordPress.

== Description ==

[Demo Forms & Videos](http://crosstec.de/en/wordpress-forms-demos.html) |
[Website](http://crosstec.de/en/wordpress-forms-download.html) | 
[Documentation](http://crosstec.de/en/support/breezingforms-documentation.html "View Documentation") |
[Support Forum](http://crosstec.de/en/forums/index.html) 

With [Breezing Forms](http://crosstec.de/en/wordpress-forms-download.html) you can create desktop and mobile forms on-the-fly.

Includes features like true mobile support, Salesforce, Dropbox, Mailchimp, multipages, summary pages, payments, conditional fields, themes and many more. See [videos](http://crosstec.de/en/wordpress-forms-demos.html) to learn more about the features of Breezing Forms.

From simple forms up to complex form applications -- almost everything is possible! If you are a professional, serving multiple customers who frequently require forms or form based applications, then [Breezing Forms](http://crosstec.de/en/wordpress-forms-download.html) is the tool of your choice.

It doesn't stop at simple contact forms but you can create complex multipage forms and extend your forms the way you like to. Additionally, the forms are interchangeable with the the Joomla!® version. So if you serve customers on the both platforms, you simply export your existing forms and install on the target sites.

[Breezing Forms](http://crosstec.de/en/wordpress-forms-download.html) has a long history of innovations that haven't been seen in WordPress Plugins before and until today. We continuously develop and implement new interesting features. With [Breezing Forms](http://crosstec.de/en/wordpress-forms-download.html), you are holding a quality and value extension in your hands that you don't want to miss again. 

So if you need to collect data like contact forms, feedback forms, surveys, calculations, complex forms or any form that is supposed to do more than just collecting data, then [Breezing Forms](http://crosstec.de/en/wordpress-forms-download.html) is the right tool for you.

***No trial-ware, no light:*** The current version is a fully working GPL2 WordPress plugin. Members at [Crosstec](http://crosstec.de/) will have premium access to the latest versions + professional support.

= Features =

* True Mobile Support (Premium Upgrade): Create your form once and display for Desktop and Mobiles
* Business/CRM: Salesforce® integration  (Premium Upgrade)
* Sharing: Dropbox® integration  (Premium Upgrade)
* MailChimp Newsletter integration
* Multipage forms
* Responsive form layouts
* Widget Support
* Shortcode helper for posts and pages
* Powerful Conditional Fields without need for Javascript
* Ajax file uploads with progress bars
* PDF, CSV & XML export (in records and as attachments)
* Many themes included
* Maxlength for textareas including "chars left" display
* Summary item: Create summary pages quickly (including calculations if you want)
* Integrator - Use your forms to integrate with other extensions
* User Editable Forms
* 18 and counting form items (from simple input to captcha items)
* Multipage forms 
* PayPal and Direct Payment (Sofortüberweisung)
* "Pay to download file" feature
* Nativa Captcha and reCaptcha
* Calendar item
* Many pre-defined validations and actions
* Custom scripting
* Unlimited reply-to fields
* Reply-to files: attach files from your server to reply-to addresses
* Reply-to for select lists
* Reply-to addresses as sender addresses
* Filter data in reply-to emails
* Custom mail subjects
* File attachments from upload fields for admin and user mails
* Multiple recipients for the admin notification mails (themeable)
* User data is shown in the email notifications
* Database storage of all submitted data
* Documentation/tutorial videos
* Package system: Create your forms once and export them to other sites
* Scripts and CSS only printed when there is a form on the page (not in the entire site as this often happens with plugins)
* Developer friendly: Extend your forms within BreezingForms by using its PHP & Javascript API -- no hacking required.

[vimeo https://vimeo.com/50726688]

== Installation ==

Minimum requirements:    
    
 Wordpress 3.0+    
 PHP 5.x    
 MySQL 4.x+  

Installation from within backend:

1. In plugin manager, click "Add New"
2. Search for "breezingforms"
3. Click "install"
4. Activate the plugin once it is installed
5. Click on "BreezingForms" from the left menu and follow the instructions to complete the installation

FTP upload installation method:

1. Upload the `breezing-forms` folder to the `/wp-content/plugins/` directory using your FTP client
2. Activate the plugin through the 'Plugins' menu
3. Go to the BreezingForms menu, finish the installation and create a new custom form or install the sample form package that ships with BreezingForms
4. Use shortcode [breezingforms name="FORM NAME"] in pages and posts. Use the editor helper to create shortcodes with more options.
5. Or add a new Widget and select the forms to display

Zip upload installation method (make sure uploads up to 5MB are allowed for your hosting):

1. Login to your WordPress site administrator panel and head over the 'Plugins' menu  
2. Click 'Add New'  
3. Choose the 'Upload' option
4. Click **Choose file** (**Browse**) and select the breezing-forms.*.zip file.   
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

= Q. My form doesn't send emails. What did I do wrong? =

A. Most likely nothing. Please go to BreezingForms => Configuration => and enable SMTP. The default PHP email system often causes trouble. Usually, SMTP works best. Also make sure you enter the SMTP login and server data correctly (if required by the server) and that you give a proper Mailfrom address. Also make sure that email notifications are enabled in your form.

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

= 1.1.1 =
* Fixed an issue with the navigation opening in popups rather than in a new page

= 1.0.4 =
* Added direct payment (sofortüberweisung)

= 1.0.3 =
* Base path now dynamic, you may name the plugin folder as you like

= 1.0.2 =
* Fixed all references from plugins/breezingforms to plugins/breezing-forms. Sorry for that.

= 1.0.1 =
* Fixed a critical bug that caused BF not to run on windows servers
* Fixed CSS in tables according to new wp version 3.4.2

= 1.0 =
* Initial Revision