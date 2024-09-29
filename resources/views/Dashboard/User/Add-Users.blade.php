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
                            <h5 class="card-header">Create User</h5>
                            <div class="card-body">
                                <form id="UsersForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">User Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter User Name" />
                                        <div class="invalid-feedback" id="name-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">User Email</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter User Email" />
                                        <div class="invalid-feedback" id="email-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">User Mobile</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter User Mobile" />
                                        <div class="invalid-feedback" id="mobile-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">User designation</label>
                                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter User designation" />
                                        <div class="invalid-feedback" id="designation-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="joining_date" class="form-label">User Joining Date</label>
                                        <input type="text" class="form-control" name="joining_date" placeholder="DD-MM-YYYY" id="joining_date" />
                                        <div class="invalid-feedback" id="joining_date-error"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="birth_date" class="form-label">User Birth Date</label>
                                        <input type="text" class="form-control" name="birth_date" placeholder="DD-MM-YYYY" id="birth_date" />
                                        <div class="invalid-feedback" id="birth_date-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="company" class="form-label">Company</label>
                                        <select class="form-select" id="company" name="company">
                                        <option value="" hidden>Select Users Company</option>
                                            @foreach ($companys as $company)
                                                <option value="{{ $company->id }}">
                                                    {{ $company->c_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Add User</button>
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

        $('#UsersForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '/admin/users/submit',
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
                        window.location.href = '/admin/users';
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
        });

        flatpickr("#joining_date", {
            dateFormat: "d-m-Y"
        });
        flatpickr("#birth_date", {
            dateFormat: "d-m-Y"
        });
    });
</script>
