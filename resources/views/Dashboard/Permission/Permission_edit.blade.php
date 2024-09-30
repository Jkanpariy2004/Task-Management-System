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
                            <h5 class="card-header">Create Permission</h5>
                            <div class="card-body">
                                <form id="PermissionForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="permission_name" class="form-label">Permission Name</label>
                                        <div id="permission_name_wrapper" class="form-control d-flex flex-wrap"
                                            style="min-height: 45px; padding: 5px;"></div>
                                        <input type="text" class="form-control mt-2" id="permission_name_input"
                                            placeholder="Enter Permission Name" />
                                        <div class="invalid-feedback" id="permission_name-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Add Permission</button>
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
        var permissionNames = [];

        $('#permission_name_input').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                var inputValue = $(this).val().trim();

                if (inputValue && !permissionNames.includes(inputValue)) {
                    permissionNames.push(inputValue);
                    $('#permission_name_wrapper').append(
                        `<span class="badge bg-primary d-flex align-items-center me-2 mb-2">
                        <p class="mb-0 fs-5">${inputValue}</p>
                        <button type="button" class="btn-close ms-2 bg-danger text-white" aria-label="Close"></button>
                    </span>`
                    );
                    $(this).val('');
                }
            }
        });

        $(document).on('click', '.btn-close', function() {
            var badge = $(this).parent();
            var valueToRemove = badge.find('p').text().trim();
            permissionNames = permissionNames.filter(function(name) {
                return name !== valueToRemove;
            });
            badge.remove();
        });

        $('#PermissionForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;

            if (permissionNames.length === 0) {
                $('#permission_name_input').addClass('is-invalid');
                $('#permission_name-error').text('At least one Permission Name is required');
                isValid = false;
            } else {
                $('#permission_name_input').removeClass('is-invalid');
                $('#permission_name-error').text('');
            }

            if (isValid) {
                var formData = new FormData(this);
                formData.append('permission_name', permissionNames.join(','));

                $.ajax({
                    url: '{{ route('submit.permission') }}',
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
                            window.location.href = '/admin/permission';
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
