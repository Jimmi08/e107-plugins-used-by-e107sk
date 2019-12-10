# [e107 JM Core plugin](https://www.e107sk.com)

## Warning

No warning. The plugin for personal use. Use it only if you know what are you doing.

## Status

Released version 1.2.0.  

## Download and Installation

Download from github, rename folder and install it. Or download it from https://www.e107sk.com/download/.

## Help & Support
The support forum for this plugin is available on:  https://www.e107sk.com/forum/

## Copyright and License

e107 stuff is released under GPL licence.
 
## Credits

Many thanks to e107 for great CMS.

## What is inside?

- fix for missing titles in the main menu in the admin area
- formatted sidebar navbar headers in the admin area
- export selected theme prefs from core prefs
- added bootstrap label and badge bbcodes
- attempt to use plugin shortcode for bootstrap user navigation with using sitelinks handler and navigation template 
- temp place for custom download shortcodes to avoid core shortcodes limitations, thanks to Achim for inspiration 
- 1.3  One Page plugin functionality, just one click and all pages are redirected to frontpage. Except excluded urls. 
- 1.4  Menus overview moved from JMTheme plugin. The way how to clean menus without the need to use PHPMyAdmin. This way it can be used for simple themes (not variable headers and footers).
- 1.5  Menus overview removed in favour of JM Theme 2.1 (it's able now to work with both theme versions). Version number chanched to 1.3 
- 1.5.1 ADDED back theme prefs export, core version didn't work with theme installation, only with manual import

## What is removed because it was implemented in core?

- TEMP REMOVED workaround for theme preferencies export
- workaround for variable header and footer, now there are magic shortcodes {---HEADER---} and {---FOOTER---}
- {MENUAREA} shortcode, it's now in core. {DEFAULT_MENUAREA} is available in JM Theme

