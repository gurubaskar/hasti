<?php

/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
?>
<?php if ($search_results): ?>
  <div class="col-xs-12 col-sm-9 col-md-9 plp-right">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 sortby">
        <div class="sort-wrap">
          <span>Sort By</span>
          <?php echo theme('drubiz_search_sort') ?>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 searchresult">
      <?php print $search_results; ?>
    </div>
      <div class="paging-result">
      </div>
    </div>
  </div>
  <?php print $pager; ?>
<?php else : ?>
  <h2><?php print t('Your search yielded no results');?></h2>
  <?php print search_help('search#noresults', drupal_help_arg()); ?>
<?php endif; ?>
