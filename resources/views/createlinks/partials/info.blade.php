
    <div class="box-header with-border">
        <h3 class="box-title">
            <?php
            if (isset($header)) {
                echo $header;
            } else {
                echo "No Selected Entity";
            }
            //echo "Label";
            ?>
        </h3>
        <div class="box-tools pull-right" >
            <button type="button" title="Click for more details" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="<?php echo "details_" . $dump; ?>" class="infobox">
            <?php
            if (isset($details)) {
                echo $details;
            } else {
                echo "<i>(click on an element to provide more info)</i>";
            }
            ?>
        </div>
    </div>
    <!-- /.box-body -->
