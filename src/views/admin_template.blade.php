<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ ($page_title)?Session::get('appname').': '.strip_tags($page_title):"Admin Area" }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name='generator' content='CRUDBooster 5.4.6'/>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon"
          href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="{{asset("plugin/fontawesome-pro-5.7.2/css/all.min.css")}}" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="{{asset("vendor/crudbooster/ionic/css/ionicons.min.css")}}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css"/>

    <!-- JqxWidgets CSS -->
    <link rel="stylesheet" href="https://jqwidgets.com/public/jqwidgets/styles/jqx.base.css" />
    <link rel="stylesheet" href="http://aosdev.xyz/jqwidgets-extreme/css/jqwidgets-extreme.css" />

    <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/main.css").'?r='.time()}}'/>
    <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/smaller-input.css").'?r='.time()}}'/>

    <!-- Bootsrap Toggle -->
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"/>
    
    <!-- load css -->
    <style type="text/css">
        @if($style_css)
            {!! $style_css !!}
        @endif
    </style>
    @if($load_css)
        @foreach($load_css as $css)
            <link href="{{$css}}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

    <style type="text/css">
        .dropdown-menu-action {
            left: -130%;
        }

        .btn-group-action .btn-action {
            cursor: default
        }

        #box-header-module {
            box-shadow: 10px 10px 10px #dddddd;
        }

        .sub-module-tab li {
            background: #F9F9F9;
            cursor: pointer;
        }

        .sub-module-tab li.active {
            background: #ffffff;
            box-shadow: 0px -5px 10px #cccccc
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
            border: none;
        }

        .nav-tabs > li > a {
            border: none;
        }

        .breadcrumb {
            margin: 0 0 0 0;
            padding: 0 0 0 0;
        }

        .form-group > label:first-child {
            display: block
        }
    </style>

    @stack('head')
</head>
<body class="@php echo (Session::get('theme_color'))?:'skin-blue'; echo ' '; echo config('crudbooster.ADMIN_LAYOUT'); @endphp {{($sidebar_mode)?:''}}">
<div id='app' class="wrapper">

<!-- Header -->
@if(!isset($_GET["singleviewmode"]) )
    @include('crudbooster::header')
@endif

<!-- Sidebar -->

@if(!isset($_GET["singleviewmode"]) )
    @include('crudbooster::sidebar')
@endif

<!-- Content Wrapper. Contains page content -->
    @if(!isset($_GET["singleviewmode"]) )
    <div class="content-wrapper">
    @else   
        <div class="content-wrapper" style="margin-left: 0px;">
    @endif
        <section class="content-header">
            <?php
            $module = CRUDBooster::getCurrentModule();
            
            $singleviewmode1 = "";
            $singleviewmode2 = "";

            if(isset($_GET["singleviewmode"])){
                $subject_id = $_GET["subject_id"];
                $topic_id = $_GET["topic_id"];
                $sub_topic_id = $_GET["sub_topic_id"];

                $singleviewmode1 = "&singleviewmode=true&subject_id=$subject_id&topic_id=$topic_id&sub_topic_id=$sub_topic_id"; 
                $singleviewmode2 = "?singleviewmode=true&subject_id=$subject_id&topic_id=$topic_id&sub_topic_id=$sub_topic_id"; 
            }
            
            
            ?>
            @if($module)
                <h1>
                    <i class='{{$module->icon}}'></i> {{($page_title)?:$module->name}} &nbsp;&nbsp;

                    <!--START BUTTON -->
                    @if(CRUDBooster::getCurrentMethod() == 'getIndex')
                        @if($button_show)
                            <a href="{{ CRUDBooster::mainpath().'?'.http_build_query(Request::all()) }}" id='btn_show_data' class="btn btn-sm btn-primary"
                               title="{{trans('crudbooster.action_show_data')}}">
                                <i class="fas fa-table"></i> {{trans('crudbooster.action_show_data')}}
                            </a>
                        @endif

                        @if($button_add && CRUDBooster::isCreate())
                            <a href="{{ CRUDBooster::mainpath('add'). '?return_url='.urlencode(Request::fullUrl() ).'&parent_id='.g('parent_id').'&parent_field='. $parent_field . $singleviewmode1 }}"
                               id='btn_add_new_data' class="btn btn-sm btn-success" title="{{trans('crudbooster.action_add_data')}}">
                                <i class="fas fa-plus-circle"></i> {{trans('crudbooster.action_add_data')}}
                            </a>
                        @endif
                    @endif


                    @if($button_export && CRUDBooster::getCurrentMethod() == 'getIndex')
                        <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='{{$build_query}}' title='Export Data'
                           class="btn btn-sm btn-primary btn-export-data">
                            <i class="fas fa-upload"></i> {{trans("crudbooster.button_export")}}
                        </a>
                    @endif

                    @if($button_import && CRUDBooster::getCurrentMethod() == 'getIndex')
                        <a href="{{ CRUDBooster::mainpath('import-data') . $singleviewmode2 }}" id='btn_import_data' data-url-parameter='{{$build_query}}' title='Import Data'
                           class="btn btn-sm btn-primary btn-import-data">
                            <i class="fas fa-download"></i> {{trans("crudbooster.button_import")}}
                        </a>
                    @endif

                <!--ADD ACTIon-->
                    @if(!empty($index_button))

                        @foreach($index_button as $ib)
                            <a href='{{$ib["url"]}}' id='{{str_slug($ib["label"])}}' class='btn {{($ib['color'])?'btn-'.$ib['color']:'btn-primary'}} btn-sm'
                               @if($ib['onClick']) onClick='return {{$ib["onClick"]}}' @endif
                               @if($ib['onMouseOver']) onMouseOver='return {{$ib["onMouseOver"]}}' @endif
                               @if($ib['onMouseOut']) onMouseOut='return {{$ib["onMouseOut"]}}' @endif
                               @if($ib['onKeyDown']) onKeyDown='return {{$ib["onKeyDown"]}}' @endif
                               @if($ib['onLoad']) onLoad='return {{$ib["onLoad"]}}' @endif
                            >
                                <i class='{{$ib["icon"]}}'></i> {{$ib["label"]}}
                            </a>
                    @endforeach
                @endif
                <!-- END BUTTON -->
                </h1>


                @if( !isset($_GET["singleviewmode"]) )
                <ol class="breadcrumb">
                    <li><a href="{{CRUDBooster::adminPath()}}"><i class="fas fa-dashboard"></i> {{ trans('crudbooster.home') }}</a></li>
                    <li class="active">{{$module->name}}</li>
                </ol>
                @endif

            @else
                <h1>{{Session::get('appname')}}
                    <small>Information</small>
                </h1>
            @endif
        </section>


        <!-- Main content -->
        <section id='content_section' class="content">

            @if(@$alerts)
                @foreach(@$alerts as $alert)
                    <div class='callout callout-{{$alert["type"]}}'>
                        {!! $alert['message'] !!}
                    </div>
                @endforeach
            @endif


            @if (Session::get('message')!='')
                <div class='alert alert-{{ Session::get("message_type") }}'>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fas fa-info"></i> {{ trans("crudbooster.alert_".Session::get("message_type")) }}</h4>
                    {!!Session::get('message')!!}
                </div>
            @endif



        <!-- Your Page Content Here -->
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    
    @if(!isset($_GET["singleviewmode"]) )
        @include('crudbooster::footer')
    @endif


</div><!-- ./wrapper -->


@include('crudbooster::admin_template_plugins')

<!-- load js -->
@if($load_js)
    @foreach($load_js as $js)
        <script src="{{$js}}"></script>
    @endforeach
@endif
<script type="text/javascript">
    var site_url = "{{url('/')}}";
    @if($script_js)
        {!! $script_js !!}
    @endif
</script>

@stack('bottom')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>
