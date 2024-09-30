<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Creation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/css/email.css" />
</head>
<body>
    <div class="container mt-5">
        <h2>Create Password</h2>
        <form id="PasswordCreateForm" method="POST">
            @csrf
            <input type="hidden" class="form-control" id="token" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password">
                    <button type="button" class="btn btn-outline-dark" id="togglePassword">Show</button>
                </div>
                <div class="invalid-feedback" id="password-error"></div>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                    <button type="button" class="btn btn-outline-dark" id="toggleConfirmPassword">Show</button>
                </div>
                <div class="invalid-feedback" id="confirmPassword-error"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Password</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            @endif
        });

        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = 'Show';
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordField = document.getElementById('confirmPassword');
            const toggleButton = document.getElementById('toggleConfirmPassword');
            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                confirmPasswordField.type = 'password';
                toggleButton.textContent = 'Show';
            }
        });

        $(document).ready(function() {
            $('input, select, textarea').on('input', function() {
                $(this).removeClass('is-invalid');
                $('#' + $(this).attr('id') + '-error').text('');
            });

            $('#PasswordCreateForm').on('submit', function(e) {
                e.preventDefault();

                var isValid = true;

                var password = $('#password').val();
                if (password.trim() === '') {
                    $('#password').addClass('is-invalid');
                    $('#password-error').text('Password is required');
                    isValid = false;
                }

                var confirmPassword = $('#confirmPassword').val();
                if (confirmPassword.trim() === '') {
                    $('#confirmPassword').addClass('is-invalid');
                    $('#confirmPassword-error').text('Confirm Password is required');
                    isValid = false;
                }

                if (isValid) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: '/admin/admins/password-creation',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.success,
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#PasswordCreateForm')[0].reset();
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').text('');
                            });
                        },
                        error: function(xhr,response) {
                            if (xhr.status === 404) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Token is Expired. User not found!',
                                    icon: 'error',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    confirmButtonText: 'OK'
                                });
                            }else{
                                var errors = xhr.responseJSON.errors;
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').text('');

                                $.each(errors, function(key, value) {
                                    $('#' + key).addClass('is-invalid');
                                    $('#' + key + '-error').text(value[0]);
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
