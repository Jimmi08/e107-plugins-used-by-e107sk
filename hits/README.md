# Hits
A simple page hit-counter for e107

## Features:
- Logs all hits to news items that are viewed. 
- Does not require javascript
- Reliable and accurate - hooks directly into news via php
- All hit counts are viewable from within the admin area. 

## Installation:
- Install the plugin via the Plugin Manager. 
- (optional) Add one or both of the following shortcodes to your news_template.php file within `$NEWS_TEMPLATE['view']['item']` or `$NEWS_VIEW_TEMPLATE['default']['item']`.

- {HITS_COUNTER} - for total hits
- {HITS_UNIQUE}  - for unique hits 


If using the shortcode(s) within a loop which could display multiple instances on a single page, eg. `$NEWS_TEMPLATE['default']['item']` or `$NEWS_TEMPLATE['list']['item']`, then enable the 'multi' option to optimize the database lookups. 

 - {HITS_COUNTER: multi=1}
 - {HITS_UNIQUE: multi=1}
