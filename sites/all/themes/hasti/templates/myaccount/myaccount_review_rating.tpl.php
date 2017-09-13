<?php //krumo($order) ?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
  <h3>My Review and Ratings</h3>
  <div id="demo-top-bar">
    <div id="no-more-tables">
      <table class="table-bordered table-striped table-condensed cf reviewRatings">
        <thead>
          <tr>
            <td>
              S.No
            </td>
            <td>
              Product Name
            </td>
            <td>
              Product Image
            </td>
            <td>
              Ratings
            </td>
            <td>
              Review
            </td>
            <td>
              Review Date
            </td>
          </tr>
        </thead>
        <tbody>
        <?php 
          if($review['isError'] == 'false') {
          $i = 1;
          foreach ($review['productReviewList'] as $key => $reviewValue) { 
        ?>
          <tr>
            <td data-title="S.No">
              <?php echo $i;?>
            </td>
            <td data-title="Product Name">
              <?php 
                echo $reviewValue['productName'];
              ?>
            </td>
            <td data-title="Image">
              <?php
                $imgUrl = explode('/osafe_theme/images/catalog', $reviewValue['productImage']);
              ?>
              <img class="order-img" alt="<?php echo $reviewValue['productName'];?>" src="<?php echo drubiz_image($imgUrl[1]) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
            </td>
            <td data-title="Ratings">
              <?php 
                $rating = $reviewValue['productRating'];
                $ratingAverage = $rating;
                $path = drupal_get_path('module', 'fivestar');      
                drupal_add_js($path . '/js/fivestar.js');
                drupal_add_css($path . '/css/fivestar.css');
                echo theme('fivestar_static', array('rating' => $ratingAverage, 'stars' => 5, 'tag' => 'vote'));
              ?>
            </td>
            <td data-title="Review">
              <?php 
                echo $reviewValue['reviewComments'];
              ?>
            </td>
            <td data-title="Review Date">
              <?php 
                echo date("d/m/Y H:s",strtotime($reviewValue['postedDateTime']));
              ?>
            </td>
          </tr>
          <?php $i++; } } else { ?>
          <tr>
            <td colspan="6">
              <?php echo $review['_ERROR_MESSAGE_'];?>
            </td>
          </tr>
          <?php } ?>
        <tbody>
      </table>
    </div>
  </div>
</div>