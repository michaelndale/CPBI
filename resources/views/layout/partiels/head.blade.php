
<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ @$title }} | GoProjects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('elements/assets/img/favicons/logo.png') }}">
    <script src="{{ asset('elements/assets/js/config.js') }}"></script>
    <link href="{{ asset('elements/vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('elements/assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
    <script src="{{ asset('elements/jquery-3.7.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('elements/notify.js') }}"></script>
    <script src="{{ asset('elements/sweetalert2@11.js') }}" type="text/javascript"></script>
   
    <link href="{{ asset('elements/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('elements/unicons.iconscout.com/release/v4.0.8/css/line.css') }}">
    <link href="{{ asset('elements/assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
    
 <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
    <link href="{{ asset('elements/vendors/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('elements/vendors/leaflet.markercluster/MarkerCluster.css') }}" rel="stylesheet">
    <link href="{{ asset('elements/vendors/leaflet.markercluster/MarkerCluster.Default.css') }}" rel="stylesheet">
  </head>
  <body>
  <main class="main" id="top">