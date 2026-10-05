<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('admin_assets/assets/') }}/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>@yield('title', 'Dashboard Admin - Gas-Jek')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin_assets/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/demo.css') }}" />
    @stack('styles')

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('admin_assets/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- 1. Panggil Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Layout container -->
        <div class="layout-page">

          <!-- 2. Panggil Header / Navbar Atas -->
          @include('layouts.admin.header')

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- 3. Wadah Konten Dinamis dari admin.blade.php -->
              @yield('content')
            </div>
            <!-- / Content -->

            <!-- 4. Panggil Footer -->
            @include('layouts.admin.footer')

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->

        </div>
        <!-- / Layout page -->

      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('admin_assets/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('admin_assets/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('admin_assets/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin_assets/assets/js/dashboards-analytics.js') }}"></script>
    @stack('scripts')
  </body>
</html>