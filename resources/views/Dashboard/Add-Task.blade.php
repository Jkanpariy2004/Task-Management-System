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
                            <h5 class="card-header">Create Task</h5>
                            <div class="card-body">
                                <form id="TaskForm">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label for="task_title" class="form-label">Task Title</label>
                                            <input type="text" class="form-control" name="task_title" id="task_title" placeholder="Enter Task Title" />
                                            <div class="invalid-feedback" id="task_title-error"></div>
                                        </div>
                                        
                                        <div class="mb-3 col-4">
                                            <label for="task_description" class="form-label">Task Description</label>
                                            <textarea id="task_description" name="task_description" class="form-control" placeholder="Enter Post Description"></textarea>
                                            <div class="invalid-feedback" id="task_description-error"></div>
                                        </div>

                                        <div class="mb-3 col-4">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="text" class="form-control" name="start_date" placeholder="DD-MM-YYYY" id="start_date" />
                                            <div class="invalid-feedback" id="start_date-error"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label for="due_date" class="form-label">Due Date</label>
                                            <input type="text" class="form-control" name="due_date" placeholder="DD-MM-YYYY" id="due_date" />
                                            <div class="invalid-feedback" id="due_date-error"></div>
                                        </div>

                                        <div class="mb-3 col-4">
                                            <label for="assign" class="form-label">Assign</label>
                                            <select class="form-select" id="assign" name="assign">
                                                <option value="" hidden>Select Assign User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback" id="assign-error"></div>
                                        </div>

                                        <div class="mb-3 col-4">
                                            <label for="priority" class="form-label">Priority</label>
                                            <select class="form-select" id="priority" name="priority">
                                                <option value="" hidden>Select Task Priority</option>
                                                <option value="Urgent">Urgent</option>
                                                <option value="High Priority">High Priority</option>
                                                <option value="Normal Priority">Normal Priority</option>
                                                <option value="Low Priority">Low Priority</option>
                                            </select>
                                            <div class="invalid-feedback" id="priority-error"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Create Task</button>
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

        $('#TaskForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;

            var task_title = $('#task_title').val();
            if (task_title.trim() === '') {
                $('#task_title').addClass('is-invalid');
                $('#task_title-error').text('Task Title is required');
                isValid = false;
            }

            var task_description = $('#task_description').val();
            if (task_description.trim() === '') {
                $('#task_description').addClass('is-invalid');
                $('#task_description-error').text('Task Description is required');
                isValid = false;
            }

            var start_date = $('#start_date').val();
            if (start_date.trim() === '') {
                $('#start_date').addClass('is-invalid');
                $('#start_date-error').text('Start date is required');
                isValid = false;
            }

            var due_date = $('#due_date').val();
            if (due_date === '') {
                $('#due_date').addClass('is-invalid');
                $('#due_date-error').text('Due date is required');
                isValid = false;
            }

            var assign = $('#assign').val();
            if (assign === '') {
                $('#assign').addClass('is-invalid');
                $('#assign-error').text('Assign User is required');
                isValid = false;
            }

            var priority = $('#priority').val();
            if (priority.trim() === '') {
                $('#priority').addClass('is-invalid');
                $('#priority-error').text('Task Priority is required');
                isValid = false;
            }

            if (isValid) {
                var formData = new FormData(this);

                $.ajax({
                    url: '/Submit-Task',
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
                            window.location.href = '/task';
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

        flatpickr("#start_date", {
            dateFormat: "d-m-Y"
        });
        flatpickr("#due_date", {
            dateFormat: "d-m-Y"
        });
    });
</script>
