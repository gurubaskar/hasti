
<div class="col-xs-12 col-sm-12 col-md-12 story-detail">
<h3> <?php echo $storyDetails['storyDetail'][0]['storyName'];?></h3>
    <p> <?php echo $storyDetails['storyDetail'][0]['storyDesc'];?></p>
    	<div class="img-wrap">
        <?php if(!empty($storyDetails['storyDetail'][0]['storyImage1']) and $storyDetails['storyDetail'][0]['storyImage1'] != null) { ?>
        <div class="col-xs-12 col-sm-8 col-md-8 story-imgleft">
          <div class="row">
            <img src="<?php print current_theme_path() . $storyDetails['storyDetail'][0]['storyImage1'] ?>" class="img-responsive" onerror="onImgStoryError(this, 'Story-Details');" />
          </div>
        </div>
        <?php } if(!empty($storyDetails['storyDetail'][0]['storyImage2']) and $storyDetails['storyDetail'][0]['storyImage2'] != null) {?>
        <div class="col-xs-12 col-sm-4 col-md-4 story-imgright">
          <div class="col-xs-12 col-sm-12 col-md-12">
           <img src="<?php print current_theme_path() . $storyDetails['storyDetail'][0]['storyImage2'] ?>" class="img-responsive" onerror="onImgStoryError(this, 'Story-Details');" />
          </div>
        
        <?php } if(!empty($storyDetails['storyDetail'][0]['storyImage3']) and $storyDetails['storyDetail'][0]['storyImage3'] != null) {?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <img src="<?php print current_theme_path() .$storyDetails['storyDetail'][0]['storyImage3'] ?>" class="img-responsive" onerror="onImgStoryError(this, 'Story-Details');" />
        </div>
        <?php } ?>
      </div>
      </div>
    <div class="btns-wrap">
     <span><a href="#" class="shareStory" data-ajax="false">Share this story</a></span>
    </div>
    <div style="clear: both; display: none;" id="socialIcons">
    <?php
    $block = module_invoke('social_share', 'block_view', 'block_delta');
    print render($block['content']);
    ?>
</div>
</div>