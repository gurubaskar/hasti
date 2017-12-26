/**
 * @file
 * Handles binding the infinite scroll library to the page.
 */

(function ($) {
  Drupal.behaviors.apachesolr_infinite_scroll = {
    attach:function () {
      // Make sure that autopager plugin is loaded.
      if ($.autopager) {
        var pager_selector   = Drupal.settings.apachesolr_infinite_scroll.pager_selector;
        var next_selector    = Drupal.settings.apachesolr_infinite_scroll.next_selector;
        var content_selector = Drupal.settings.apachesolr_infinite_scroll.content_selector;
        var img_path         = Drupal.settings.apachesolr_infinite_scroll.ajax_loading_image_path;
        var img              = '<div id="apachesolr_infinite_scroll-ajax-loader"><img src="' + img_path + '" alt="loading..."/></div>';
        var insert_mode      = Drupal.settings.apachesolr_infinite_scroll.insert_mode;
        var insert_selector  = Drupal.settings.apachesolr_infinite_scroll.insert_selector;

        $(pager_selector).hide();

        var autopager_settings = {
          link: next_selector,
          content: content_selector,
          page: 0,
          start: function () {
            $(pager_selector).after(img);
          },
          load: function (current, next) {
            $('div#apachesolr_infinite_scroll-ajax-loader').remove();
          }
        }

        if (insert_mode != '' && insert_selector.length > 0) {
          autopager_settings[insert_mode] = insert_selector;
        }

        $.autopager(autopager_settings);
      }
      else {
        alert(Drupal.t('Autopager jquery plugin in not loaded.'));
      }
    }
  }
})(jQuery);
