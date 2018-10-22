<!DOCTYPE html>
<html lang="zh-Hant-TW">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{env('WEBSITE_NAME')}}</title>

    <!-- Favicons -->
    <link href="{{url('img/favicon.ico')}}" rel="icon">
    <link href="{{url('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">
    @yield('fonts')

    <!-- Bootstrap CSS File -->
    <link href="{{url('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Libraries CSS Files -->
    <link href="{{url('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{url('plugins/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{url('plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{url('plugins/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{url('plugins/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
    <!-- Main Stylesheet File -->
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    @yield('css')
  </head>

  @yield('body')

  <!-- JavaScript Libraries -->
  <script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{url('plugins/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{url('plugins/easing/easing.min.js')}}"></script>
  <script src="{{url('plugins/superfish/hoverIntent.js')}}"></script>
  <script src="{{url('plugins/superfish/superfish.min.js')}}"></script>
  <script src="{{url('plugins/wow/wow.min.js')}}"></script>
  <script src="{{url('plugins/waypoints/waypoints.min.js')}}"></script>
  <script src="{{url('plugins/counterup/counterup.min.js')}}"></script>
  <script src="{{url('plugins/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{url('plugins/isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{url('plugins/lightbox/js/lightbox.min.js')}}"></script>
  <script src="{{url('plugins/touchSwipe/jquery.touchSwipe.min.js')}}"></script>
  <!-- Slimscroll -->
  <script src="{{url('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{url('plugins/contactform/contactform.js')}}"></script>
  <!-- Template Main Javascript File -->
  <script src="{{url('js/main.js')}}"></script>
  @yield('js')
</html>