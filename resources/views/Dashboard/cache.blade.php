<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('Layouts.Sidenavbar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('Layouts.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Cache
                        </h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="card card-statistics p-3 rounded">
                                    <div class="text-center">
                                        <h3>Cache Setting</h3>
                                    </div>
                                    <div id="alert-container">
                                        @if (session('success'))
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Success!',
                                                        text: "{{ session('success') }}",
                                                        showConfirmButton: true
                                                    });
                                                });
                                            </script>
                                        @endif
                                        @if (session('error'))
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error!',
                                                        text: "{{ session('error') }}",
                                                        showConfirmButton: true
                                                    });
                                                });
                                            </script>
                                        @endif
                                    </div>
                                    <div>
                                        <button class="btn btn-primary mt-2" onclick="clearCache('cache-clear')">Cache
                                            Clear</button>                                            
                                        <button class="btn btn-primary mt-2"
                                            onclick="clearCache('route-cache-clear')">Route
                                            Cache Clear</button>
                                        <button class="btn btn-primary mt-2"
                                            onclick="clearCache('config-cache-clear')">Config
                                            Cache Clear</button>
                                        <button class="btn btn-primary mt-2"
                                            onclick="clearCache('view-cache-clear')">View Cache
                                            Clear</button>
                                        <button class="btn btn-primary mt-2"
                                            onclick="clearCache('compiled-cache-clear')">Compiled File
                                            Clear</button>
                                        <button class="btn btn-primary mt-2"
                                            onclick="clearCache('optimize-cache-clear')">Optimize Cache
                                            Clear</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            function clearCache(action) {
                                $.ajax({
                                    url: '/' + action,
                                    type: 'GET',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: response.success,
                                            showConfirmButton: true
                                        });
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: 'An error occurred while clearing the cache.',
                                            showConfirmButton: true
                                        });
                                    }
                                });
                            }
                        </script>


                    </div>
                </div>
                <!-- / Content -->

                @include('Layouts.footer')

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
