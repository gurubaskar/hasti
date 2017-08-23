<div class="col-xs-12 col-sm-12 col-md-12"  id="story">
<h3>Story</h3>
<div id="">

  <div class="container-fluide">
 <div class="row">
<?php 
//print_r($storyArray);
foreach ($storyArray['storyList'] as $story) {
?>
 <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="box">
          <div class="img-wrap">
            <a class="pdpUrl ui-link" title="<?php echo $story['storyName'] ?>" href="<?php echo url('story-details')?>/<?php echo $story['storyId'] ?>" id="<?php echo $story['storyId'] ?>" data-ajax="false">
              <!--img alt="<?php echo drubiz_image($story['storyImage']); ?>" title="<?php echo $story['storyName']; ?>" src="<?php echo drubiz_image($story['storyImage']); ?>" -->
              <img alt="/drubiz_hasti/sites/all/themes/hasti/images/products/small/100050C.jpg" title="Women very long kurta" src="/drubiz_hasti/sites/all/themes/hasti/images/products/small/100050B.jpg" onmouseover="src='/drubiz_hasti/sites/all/themes/hasti/images/products/small/100050C.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/drubiz_hasti/sites/all/themes/hasti/images/products/small/100050B.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP- Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
          </a>
        </div>
      <div class="title"><?php echo $story['storyName'] ?></div>
    </div>
  </div>
 <?php  }  ?> 
 </div> 
 </div>
</div>
</div>