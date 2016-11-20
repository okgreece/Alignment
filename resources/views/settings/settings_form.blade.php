<link href="{{ asset('/css/silk/silkstyle.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('/js/silk/silkform.js')}}"></script>
<script type="text/javascript" src="{{asset('/plugins/knob/jquery.knob.js')}}"></script>

@include('settings.partials.name_input')
<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Prefixes</a></li>
              <li><a href="#tab_2" data-toggle="tab">Comparison</a></li>
              <li><a href="#tab_3" data-toggle="tab">Linkage Rule</a></li>
              <li><a href="#tab_4" data-toggle="tab">Output</a></li>
              <li class="dropdown hidden">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
              </li>
              <li class="pull-right hidden"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  @include('settings.partials.prefixes')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                  @include('settings.partials.comparison')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                  @include('settings.partials.linkage_rule')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                  @include('settings.partials.output')
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
{{--@include('settings.partials.source')--}}
{{--@include('settings.partials.target')--}}
