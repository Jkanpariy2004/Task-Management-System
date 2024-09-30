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
                            <h5 class="card-header">Create Admin</h5>
                            <div class="card-body">
                                <form id="RoleForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="admin_name" class="form-label">Admin Name</label>
                                        <input type="text" class="form-control" name="admin_name" id="admin_name" placeholder="Enter Admin Name" />
                                        <div class="invalid-feedback" id="admin_name-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="admin_email" class="form-label">Admin Email</label>
                                        <input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="Enter Admin Email" />
                                        <div class="invalid-feedback" id="admin_email-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="admin_role" class="form-label">Company</label>
                                        <select class="form-select" id="admin_role" name="admin_role">
                                        <option value="" hidden>Select Admin Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">
                                                    {{ $role->role_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Create Admin</button>
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

            var admin_name = $('#admin_name').val();
            if (admin_name.trim() === '') {
                $('#admin_name').addClass('is-invalid');
                $('#admin_name-error').text('Name is required');
                isValid = false;
            }

            var admin_email = $('#admin_email').val();
            if (admin_email.trim() === '') {
                $('#admin_email').addClass('is-invalid');
                $('#admin_email-error').text('Email is required');
                isValid = false;
            }

            var admin_role = $('#admin_role').val();
            if (admin_role.trim() === '') {
                $('#admin_role').addClass('is-invalid');
                $('#admin_role-error').text('Role is required');
                isValid = false;
            }

            if (isValid) {
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route("insert.admins") }}',
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
                            window.location.href = '/admin/admins';
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
