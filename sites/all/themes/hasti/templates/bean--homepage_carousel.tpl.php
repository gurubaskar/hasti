<div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true">
	<div class="slides" data-group="slides">
		<ul style="position: relative; right: 3420px;">
<?php
  //print_r($bean->field_carousel_slide[LANGUAGE_NONE]);
  $slide_array = $bean->field_carousel_slide[LANGUAGE_NONE];
  $field_collections = array();
  foreach($slide_array as $index => $slider) {
    $field_item = $slider['value'];
    //echo "<br/> Field item = ", $field_item;
    $field_collection =  field_collection_item_load($field_item, $reset = FALSE);
    // $field_collections[] = $field_collection;
    //echo "<pre>";
    //print_r($field_collection);
    //echo "</pre>";
    $file_raw_url = $field_collection->field_carousel_image[LANGUAGE_NONE][0]['uri'];
    $width = $field_collection->field_carousel_image[LANGUAGE_NONE][0]['width'];
    $height = $field_collection->field_carousel_image[LANGUAGE_NONE][0]['height'];
    $file_url = file_create_url($file_raw_url);
    //echo "<br/> File url = ", $file_url;
    $field_caption_header = @$field_collection->field_caption_header[LANGUAGE_NONE][0]['value'];
    $field_caption_subheader = @$field_collection->field_caption_subheader[LANGUAGE_NONE][0]['value'];
    $field_caption_body = @$field_collection->field_caption_body[LANGUAGE_NONE][0]['value'];
    $field_carousel_link = @$field_collection->field_carousel_link[LANGUAGE_NONE][0]['url'];
    $field_carousel_link_text = @$field_collection->field_carousel_link[LANGUAGE_NONE][0]['title'];
    $title_is_link = (strpos($field_carousel_link, $field_carousel_link_text) === 0);
?>
  <li>
    <div class="slide-body" data-group="slide">
      <?php if ($title_is_link): ?>
        <a href="<?php echo $field_carousel_link; ?>">
      <?php endif; ?>
        <img src="<?php print $file_url ?>">
      <?php if ($title_is_link): ?>
        </a>
      <?php endif; ?>
      <div class="caption header" data-animate="slideAppearRightToLeft" data-delay="500" data-length="300" style="opacity: 1; margin-left: 0px; margin-right: 0px;">
      <h2><?php print $field_caption_header ?></h2>
      <div class="caption sub" data-animate="slideAppearLeftToRight" data-delay="800" data-length="300" style="opacity: 1; margin-left: 0px; margin-right: 0px;"><?php print $field_caption_subheader ?></div>
      </div>
      <div class="caption img-bootstrap" data-animate="slideAppearDownToUp" data-delay="200" style="opacity: 1; margin-top: 0px; margin-bottom: 0px;">
      <!--<img src="images/banner-slider/bootstrap.png">-->
      <?php print $field_caption_body ?>
      <?php if (!$title_is_link): ?>
          <button class="shopnow" onClick="location.href = '<?php print $field_carousel_link ?>'"><a style="color:#fff" href="<?php print $field_carousel_link ?>"><?php print $field_carousel_link_text ?></a></button>
      <?php endif; ?>
      <div class="caption img-twitter" data-animate="slideAppearUpToDown" style="opacity: 1; margin-top: 0px; margin-bottom: 0px;">
      <!--<img src="images/banner-slider/twitter.png">-->
      </div>
    </div>
    </div>
  </li>
<?php } ?>
    </ul>
  </div>
  <a class="slider-control left" href="#" data-jump="prev"><</a>
  <a class="slider-control right" href="#" data-jump="next">></a>
  <div class="pages">
    <a class="page" href="#" data-jump-to="1">1</a>
    <a class="page" href="#" data-jump-to="2">2</a>
    <a class="page" href="#" data-jump-to="3">3</a>
  </div>
</div>
<?php
  global $base_path;
  $hasti_theme_path = $base_path.drupal_get_path('theme', 'hasti') . '/js';
  echo '<script src="'.$hasti_theme_path.'/jquery.event.move.js"></script>'.PHP_EOL;
  echo '<script src="'.$hasti_theme_path.'/responsive-slider.js"></script>'.PHP_EOL;
  drupal_add_css(drupal_get_path('theme', 'hasti') . '/css/responsive-slider.css');
?>
<?php //krumo($field_collections); ?>