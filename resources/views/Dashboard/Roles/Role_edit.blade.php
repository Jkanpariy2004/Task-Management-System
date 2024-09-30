<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<!-- Add Flatpickr CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" /> -->
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('Dashboard.Layouts.Sidenavbar')

        <div class="layout-page">

            @include('Dashboard.Layouts.header')


            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <h5 class="card-header">Update Role</h5>
                            <div class="card-body">
                                <form id="RoleForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="role_name" class="form-label">Role Name</label>
                                        <input type="text" class="form-control" name="role_name" id="role_name" value="{{ $new->role_name }}" placeholder="Enter User Name" />
                                        <div class="invalid-feedback" id="role_name-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Update Role</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @include('Dashboard.Layouts.footer')

                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>

    <div class="drag-target"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        $('input, select, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
            $('#' + $(this).attr('id') + '-error').text('');
        });

        $('#RoleForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;

            var role_name = $('#role_name').val();
            if (role_name.trim() === '') {
                $('#role_name').addClass('is-invalid');
                $('#role_name-error').text('Role Name is required');
                isValid = false;
            }

            if (isValid) {
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route("update.role", $new->id) }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000,
                            timerProgressBar: true,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = '/admin/role';
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value[0]);
                        });
                    }
                });
            }
        });
    });
</script>
