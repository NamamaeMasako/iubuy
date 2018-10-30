<!DOCTYPE html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('WEBSITE_NAME')}} Back</title>

        <!-- Favicons -->
        <link rel="shortcut icon" href="{{url('/img/favicon.ico')}}">

        <!-- Fonts -->
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">
        @yield('fonts')

        <!-- CSS -->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{url('plugins/font-awesome/css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('css/adminlte.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{url('plugins/iCheck/all.css')}}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{url('plugins/morris/morris.css')}}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{url('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{url('plugins/datepicker/datepicker3.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{url('plugins/daterangepicker/daterangepicker-bs3.css')}}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
        <!-- Ion Slider -->
        <link rel="stylesheet" href="{{url('plugins/ionslider/ion.rangeSlider.css')}}">
        <!-- ion slider Nice -->
        <link rel="stylesheet" href="{{url('plugins/ionslider/ion.rangeSlider.skinNice.css')}}">
        <!-- 自訂 -->
        <link rel="stylesheet" href="{{url('css/message.css')}}">
        <link rel="stylesheet" href="{{url('css/header.css')}}">
        @yield('css')
    </head>
    @yield('body')
    <!-- JS -->
    <!-- jQuery -->
    <script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery Cookie -->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
        $(function() {
            $('.sidebar').slimscroll({
                height: '100%'
            });
        })
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="{{url('plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{url('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{url('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{url('plugins/morris/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{url('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{url('plugins/knob/jquery.knob.js')}}"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- datepicker -->
    <script src="{{url('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Ion Slider -->
    <script src="{{url('plugins/ionslider/ion.rangeSlider.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{url('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{url('js/adminlte.js')}}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{url('plugins/iCheck/icheck.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{url('plugins/fastclick/fastclick.js')}}"></script>
    <!-- 查詢引擎變更 -->
    <script>
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass   : 'iradio_minimal-blue'
        })
        if(Cookies.get('search-engine')){
            change_search(Cookies.get('search-engine'));
        }
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass   : 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
        })
        function change_search(engine = "google") {
            $('#all-engine li').removeClass('active');
            $("#search-icon").removeClass();
            $("#search-icon").addClass('fa');
            switch(engine){
                case "google":
                    $("#search-form").attr("action","https://www.google.com.tw/search");
                    $("#search-input").attr("name","q");
                    $("#search-icon").addClass("fa-google"); 
                    break;
                case "yahoo":
                    $("#search-form").attr("action","https://tw.search.yahoo.com/search");
                    $("#search-input").attr("name","p");
                    $("#search-icon").addClass("fa-yahoo");
                    break;
                case "youtube":
                    $("#search-form").attr("action","https://www.youtube.com/results");
                    $("#search-input").attr("name","search_query");
                    $("#search-icon").addClass("fa-youtube");
                    break;
            }
            $("#"+engine).addClass("active");
            Cookies.set('search-engine', engine);
        }
    </script>
    <!-- active navigation tab -->
    <script>
        signPost('{{\Session::get('active-tab')}}');
        function signPost(tab) {
            $("#sidebar-menu li a").removeClass('active');
            $("#"+tab).addClass("active");
        }
    </script>
    <!-- auto collapse message -->
    <script>
        setTimeout(autoCollapseMsg,3000);
        function autoCollapseMsg(){
            if(!$(".message .card").hasClass("collapsed-card")){
                $("[data-widget='collapse']").click();
            }
        }
    </script>
    @yield('js')
</html>
