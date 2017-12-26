DESCRIPTION
==========

Leverages the jQuery Autopager library (same library as views_infinite_scroll) to replace the pager on Apache Solr search results pages with an infinite scroll loader.


DEPENDENCIES
============

* Apache Solr 1.x  -- https://www.drupal.org/project/apachesolr
* Libraries API -- https://www.drupal.org/project/libraries
* jQuery Autopager Library -- https://code.google.com/p/jquery-autopager/

INSTALLATION
============

* Download this module to your /sites/all/modules folder
* Download the jQuery Autopager library and save to /sites/all/libraries/autopager
  * This should happen automatically if you download via drush.
* Enable the module


CONFIGURATION
=============

One the module is enabled, you can select which Solr search result pages will
use the Infinite Scroll library by going to /admin/config/search/apachesolr/search-pages.

When creating or editing a search page, there is a new section under
"Advanced Search Page Options" called "Infinite Scroll Settings".  Expand this
section to enable/disable infinite scroll for this search result page or to
adjust the selectors used for updating the content.
