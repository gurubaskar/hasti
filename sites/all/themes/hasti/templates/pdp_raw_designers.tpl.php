<?php
$ofbiz_url = variable_get("drubiz_ofbiz_url");
if(count($getRawMaterials['designers'])==0){?>
<p>No data found.</p>
<?php }else{
foreach ($getRawMaterials['designers'] as $keyRawMaterials => $valueRawMaterials) :?>
<div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="container-fluid" id="homepage">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h3>DESIGNERS</h3>
        </div>
        <div class="content-wrap"> <!-- content-wrap -->
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 left">
            <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage1'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
          </div>
          <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 right">
            <h3><?php echo $valueRawMaterials['name']; ?></h3>
            <p><?php echo $valueRawMaterials['description']; ?></p>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 img-wrap">
                  <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage2'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 img-wrap">
                  <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage3'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 img-wrap">
                  <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage4'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
                </div>
              </div>
            </div>
            <div class="btns-wrap">
              <span><a class="ui-link" href="#" data-ajax="false">Find my Collections</a></span>
            </div>
          </div>
        </div> <!-- content-wrap end -->

        <div class="content-wrap"> <!-- content-wrap -->
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 left">
            <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage1'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
          </div>
          <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8 right">
            <h3><?php echo $valueRawMaterials['name']; ?></h3>
            <p><?php echo $valueRawMaterials['description']; ?></p>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 img-wrap">
                  <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage2'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 img-wrap">
                  <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage3'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 img-wrap">
                  <img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['designerImage4'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');">
                </div>
              </div>
            </div>
            <div class="btns-wrap">
              <span><a class="ui-link" href="#" data-ajax="false">Find my Collections</a></span>
            </div>
          </div>
        </div> <!-- content-wrap end -->

    </div>
  </div>
</div>	
<?php endforeach; 
}?>