<div class="col-lg-12 col-xs-12">
    <!-- small box -->
    <?php
    switch ($error->level) {
        case 1:
            $bg = 'bg-yellow-gradient';
            $header = 'LIBXML_ERR_WARNING';
            break;
        case 2:
            $bg = 'bg-red-gradient';
            $header = ' LIBXML_ERR_ERROR';
            break;
        case 3:
            $bg = 'bg-black-gradient';
            $header = 'LIBXML_ERR_FATAL';
            break;
    }
    ?>
    <a href="http://www.xmlsoft.org/html/libxml-xmlerror.html" target="_blank" class="small-box {{$bg}}">
        <div class="inner">
            <h3>
                {{$header}}
            </h3>
            <h4>
                Line: {{$error->line}}, Column: {{$error->column}}, Code: {{$error->code}}
            </h4>
            <h4>
                {{$error->message}}
            </h4>
        </div>
        <span class="small-box-footer">
            Click for more <i class="fa fa-arrow-circle-right"></i>
        </span>
    </a>
</div>

