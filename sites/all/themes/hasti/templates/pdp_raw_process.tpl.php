<?php 
$ofbiz_url = variable_get("drubiz_ofbiz_url");
if(count($getRawMaterials['productionProcesses'])==0){?>
<p>No data found.</p>
<?php }else{
foreach ($getRawMaterials['productionProcesses'] as $keyRawMaterials => $valueRawMaterials) :?>
<div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="row">
    <div class="container-fluid rawmaterial">
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
              <h3>PROCESS</h3>
            </div>
          </div>
          <div class="content-wrap"> <!-- content-wrap -->

            <div id="khadi-info">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 raw-heading">
                <div class="row">
                  <h3><?php echo $valueRawMaterials['taskName']; ?></h3>
                </div>
              </div>
              <!-- <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 raw-right">
                <div class="btns-wrap">
                  <span><a class="ui-link" href="#" data-ajax="false">Find Collections</a></span>
                </div>
              </div> -->

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pl0">
                <p><?php echo $valueRawMaterials['description']; ?></p>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 remove-pad">
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pl0 pr-9"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['productionProcImage1'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');"></div>
                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pl0"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['productionProcImage2'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');"></div>
                </div>
                <div class="row remove-pad">
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pl0"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['productionProcImage3'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');"></div>
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pr-8 pl0"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['productionProcImage4'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');"></div>
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pl-5"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['productionProcImage5'];?>" alt="Khadi" onerror="onImgError(this, 'PLP-Thumb');"></div>
                </div>
              </div>
            </div>
          </div> <!-- content-wrap end -->
      </div>
    </div>
  </div>
</div>
	
<?php endforeach; 
}?>