<?php 
$ofbiz_url = variable_get("drubiz_ofbiz_url");
foreach ($getRawMaterials['rawMaterials'] as $keyRawMaterials => $valueRawMaterials) :?>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 raw-heading">
              <h3><?php echo $valueRawMaterials['internalName']; ?></h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
            <?php echo $valueRawMaterials['longDescription']; ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 raw-right">
              <div class="btns-wrap">
                <span><a class="ui-link" href="#" data-ajax="false">Find Collections</a></span>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pr-5"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['rawMaterialImage1'];?>" alt="Khadi"></div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pl-5"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['rawMaterialImage2'];?>" alt="Khadi"></div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pr-5"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['rawMaterialImage3'];?>" alt="Khadi"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pr-5 pl-5"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['rawMaterialImage4'];?>" alt="Khadi"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pl-5"><img class="img-responsive" src="<?php echo $ofbiz_url.$valueRawMaterials['rawMaterialImage5'];?>" alt="Khadi"></div>
              </div>
            </div>
	
<?php endforeach; ?>