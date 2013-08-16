=== Breezing Forms ===
Contributors: crosstec
Donate link: http://crosstec.de/en/wordpress-forms-download.html
Tags: forms, contact form, form builder, email form, feedback form, order form, admin, page, plugin, Post, widget, responsive
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 1.2.5.20
License: GPL 2

Professional form builder for any kind of form you need in WordPress. Powerful and flexible, yet easy to use.

== Description ==

[Pro Version](http://crosstec.de/en/wordpress-forms-download.html) |
[WP Themes](http://crosstec.de/en/wordpress/wordpress-themes.html) | 
[Demo Forms](http://crosstec.de/en/wordpress-forms-demos.html) |
[Form Themes](http://crosstec.de/en/markets/breezingforms-themes.html) | 
[Pre-Made Forms](http://crosstec.de/en/markets/breezingforms-form-apps.html) | 
[Documentation](http://crosstec.de/en/support/breezingforms-documentation.html "View Documentation") |
[Support Forum](http://crosstec.de/en/forums/51-breezingforms-for-wordpress.html) 

Forms for professionals. The only form builder for WordPress that is capable of creating simple forms but also dealing with large and complex form applications. You can either use it the regular way, without any coding and create standard forms rapidly or if you need to create more, extend with bits of js or php, without the need to hack the plugin.

Drag and drop is good, quick form creation is better. [Breezing Forms](http://crosstec.de/en/wordpress-forms-download.html) provides a clever interface to add and manage form elements quickly -- while quick means easy. 

The admin ui helps you to keep track of your form structure. No matter if simple or complicated forms, you never get lost in scrolling to find your fields.

The results are great, too. Checkout some [demo forms](http://crosstec.de/en/wordpress-forms-demos.html).

[Contact forms](http://crosstec.de/en/wordpress-forms-download.html), feedback forms, order forms or any other kind of form you need in WordPress are possible with just this plugin. Use the flexibility of Breezing Forms to create even complex form applications -- for both, mobile devices and desktop by creating only one form -- less work, double the fun.

When talking about mobile forms, we are not just talking about responsive layouts (which are supported anyway) but about displaying your forms in an app way manner -- easier for your website visitors to handle even complex data input and not getting irritated by the rest of your website's contents.

As example, please open this form with your desktop and mobile browser:
[Mobile Form Demo](http://crosstec.de/.sub-breezingformswpdemo/)

= Key Features =

* Unlimited Fields ***(Pro Version)***
* [Mobile Forms](http://crosstec.de/en/mobile-wordpress-forms.html) ***(Pro Version)***
* Business/CRM: Salesforce® integration ***(Pro Version)***
* Sharing: Dropbox® integration ***(Pro Version)***
* Upload image preview ***(Pro Version)***
* 25+ pre-made, great looking form themes ***(Pro Version)***
* Pre-made form samples ***(Pro Version)***
* Max. 5 Fields (Free Version)
* MailChimp Newsletter integration
* Multipage forms
* Conditional Fields
* Responsive forms
* 18 and counting form items (from simple input to captcha items)
* Ajax file uploads with progress bars
* Nativa Captcha and reCaptcha
* Summary item: Create summary pages quickly (including calculations if you want)
* Maxlength for textareas including "chars left" display
* Calendar item
* PayPal and Direct Payment (sofort.com)
* "Pay to download file" feature
* Custom email subjects
* Reply-to fields
* File attachments from uploads for admin and reply-to emails
* Reply-to files: attach files from your server to reply-to addresses
* Reply-to for select lists
* Reply-to addresses as sender addresses
* Data filter for reply-tos
* Multiple recipients for the admin notification mails (themeable)
* User data  email notifications
* PDF, CSV & XML export (in records and as attachments)
* Many pre-defined validations and actions
* Custom scripting
* Database storage of all submitted data
* Package system: Create your forms once and export them to other sites
* Developer friendly: Extend your forms within BreezingForms by using its PHP & Javascript API -- no hacking required.
* Documentation/tutorial videos
* Scripts and CSS only printed when there is a form on the page (not in the entire site as this often happens with plugins)
* Widget Support
* Shortcode helper for posts and pages

***If you got any questions on the pro, please don't hesitate to contact us at <sales@crosstec.de>***

Building forms introduction:
[vimeo https://vimeo.com/51411276]

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
1. Job application form with "Aqua" form-theme
2. Example job application form with "Glossy Blue" form-theme
3. Form settings admin
4. Sample record with image previews

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

[Ask more questions in our forums](http://crosstec.de/en/forums/51-breezingforms-for-wordpress.html "BreezingForms Forums")

== Changelog ==

= 1.2.5.20 =
* Tested with WordPress 3.6 final and everything appears to be working well. WP_DEBUG should for now be turned off, because not everything is yet php strict mode compatible. Will address that in the next updates.

= 1.2.5.18 =
* Fixed a captcha bug that happened under certain server configurations

= 1.2.5.16 =
* Complete backend interface overhaul. Now feels like home in WordPress
* Fixed session based issues that happen under certain circumstances in administration

= 1.2.5.12 =
* backend message colors changed

= 1.2.5.9 =
* fixed theme load order
* fixed themes's button and fieldset label css

= 1.2.5.6 =
* fixed iframe autoheight for forms, now also works with google chrome and mobile devices

= 1.2.5.1 =
* main plugin code cleanup, added new screenshot and text changes to readme.txt

= 1.2.4 =
* Removed deprecated the_editor call for newer WP versions. Will now fallback depending on the WP version that is in use.

= 1.2.3 =
* Added ipv6 support in record management search

= 1.2.2 =
* Fixed a mysql bug upon installation, relevant for mysql >= 5.6
* Adjusted readme.txt

= 1.2.1 =
* Swaped submission values in manage records with the head data as requested by users

= 1.2.0 =
* Fixed non-working summarize bug

= 1.1.9 =
* Fixed frontend query error with super cache

= 1.1.8 =
* Fixed caching problems (Fatal Error)
* Fixed non-working shortcode helper in WP 3.5.1
* Fixed backend action button styles in WP 3.5.1
* Fixed reply-to address problems on shared hosts that prevent manipulating the sender address

= 1.1.4 =
* Fixed a bug in manage records that appears after record deletion
* Added a tutorial video to the listing page

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