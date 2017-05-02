<?php
/**
 * @file
 * drubiz_features.features.inc
 */

/**
 * Implements hook_node_info().
 */
function drubiz_features_node_info() {
  $items = array(
    'product' => array(
      'name' => t('Product'),
      'base' => 'node_content',
      'description' => t('OfBiz Products.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
