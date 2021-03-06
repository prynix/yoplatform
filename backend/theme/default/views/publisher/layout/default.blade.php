<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Yomedia</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="/favico.ico" type="image/x-icon" >
		<!-- text fonts -->
		{{ HTML::style("{$assetURL}css/bootstrap-default.min.css") }}
        {{ HTML::style("{$assetURL}css/font-awesome.min.css") }}

		<!-- ace styles -->
		{{ HTML::style("{$assetURL}css/admin.css") }}
        {{ HTML::style("{$assetURL}css/fb_theme.css") }}

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		{{ HTML::script("{$assetURL}js/html5shiv.js") }}
		{{ HTML::script("{$assetURL}js/respond.min.js") }}
		<![endif]-->
        <script type="text/javascript">

            var root    = "{{{ URL::to('/') }}}/{{{ Config::get('backend.uri').'/publisher' }}}/";
            var assetURL =   "{{{ URL::to('/') }}}/public/";
            var module  = "{{{ Request::segment(3) }}}";

        </script>

        {{ HTML::script("{$assetURL}js/vendor/modernizr-2.6.2.min.js") }}
        {{ HTML::script("{$assetURL}js/vendor/jquery-1.10.2.min.js") }}
        {{ HTML::script("{$assetURL}js/plugins.js") }}
        {{ HTML::script("{$assetURL}js/bootstrap.min.js") }}
        {{ HTML::script("{$assetURL}js/bootstrap-datepicker.js") }}
        {{ HTML::script("{$assetURL}js/admin.js") }}
        {{ HTML::script("{$assetURL}js/bootstrap-checkbox.min.js") }}

    </head>
    <body class="fb_theme">
        
        <!-- HEADER -->
        @include("includes.header")
        <!-- END HEADER -->

        @if( Session::has('flash-message') )
            <div class="container">
                <div class="flash-message text-center">
                    {{Session::get('flash-message')}}
                </div>
            </div>
        @endif

        <div id="main">
            <div class="main-wrapper">
                <div class="container">
                    <div class="row">
                        <div id="right" class="col-xs-12 wrapper-publisher">
                            {{ isset($content) ? $content : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
