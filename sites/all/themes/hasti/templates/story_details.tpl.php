
<div class="col-xs-12 col-sm-12 col-md-12 story-detail">
<h3> <?php echo $storyDetails['storyDetail'][0]['storyName'];?></h3>
<div id="">
<?php //echo "<pre>";print_r($storyDetails['storyDetail'][0]['storyVideo']);?>
  
    <div><p> <?php echo $storyDetails['storyDetail'][0]['storyDesc'];?></p></div>
    <div>
    	<div class="img-wrap">
        <?php if(!empty($storyDetails['storyDetail'][0]['storyImage1']) and $storyDetails['storyDetail'][0]['storyImage1'] != null) { ?>
          <img src="<?php print current_theme_path() . $storyDetails['storyDetail'][0]['storyImage1'] ?>" class="img-responsive" />
        <?php } if(!empty($storyDetails['storyDetail'][0]['storyImage2']) and $storyDetails['storyDetail'][0]['storyImage2'] != null) {?>
          <img src="<?php print current_theme_path() . $storyDetails['storyDetail'][0]['storyImage2'] ?>" class="img-responsive" />
        <?php } if(!empty($storyDetails['storyDetail'][0]['storyImage3']) and $storyDetails['storyDetail'][0]['storyImage3'] != null) {?>
          <img src="<?php print current_theme_path() .$storyDetails['storyDetail'][0]['storyImage3'] ?>" class="img-responsive" />
        <?php } if(!empty($storyDetails['storyDetail'][0]['storyImage4']) and $storyDetails['storyDetail'][0]['storyImage4'] != null) {?>
          <img src="<?php print current_theme_path() .$storyDetails['storyDetail'][0]['storyImage4'] ?>" class="img-responsive" />
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
</div>