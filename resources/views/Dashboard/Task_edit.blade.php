<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<style>
    #attechments_preview img {
        width: 150px;
        margin: 10px;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    #attechments_preview img:hover {
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }

    .remove-image {
        cursor: pointer;
        display: block;
        margin-top: 5px;
        color: red;
    }
</style>
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
                                            <input type="text" class="form-control" name="task_title" id="task_title" value="{{ $new->title }}" placeholder="Enter Task Title" />
                                            <div class="invalid-feedback" id="task_title-error"></div>
                                        </div>
                                        
                                        <div class="mb-3 col-4">
                                            <label for="task_description" class="form-label">Task Description</label>
                                            <textarea id="task_description" name="task_description" class="form-control" placeholder="Enter Post Description">{{ $new->description }}</textarea>
                                            <div class="invalid-feedback" id="task_description-error"></div>
                                        </div>

                                        <div class="mb-3 col-4">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="text" class="form-control" name="start_date" value="{{ $new->start_date }}" placeholder="DD-MM-YYYY" id="start_date" />
                                            <div class="invalid-feedback" id="start_date-error"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-4">
                                            <label for="due_date" class="form-label">Due Date</label>
                                            <input type="text" class="form-control" name="due_date" value="{{ $new->due_date }}" placeholder="DD-MM-YYYY" id="due_date" />
                                            <div class="invalid-feedback" id="due_date-error"></div>
                                        </div>

                                        <div class="mb-3 col-4">
                                            <label for="assign" class="form-label">Assign</label>
                                            <select class="form-select" id="assign" name="assign">
                                                <option value="" hidden>Select Assign User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" {{ $assignedUserId == $user->id ? 'selected' : '' }}>
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
                                                <option value="Urgent" {{ $new->priority == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                                <option value="High Priority" {{ $new->priority == 'High Priority' ? 'selected' : '' }}>High Priority</option>
                                                <option value="Normal Priority" {{ $new->priority == 'Normal Priority' ? 'selected' : '' }}>Normal Priority</option>
                                                <option value="Low Priority" {{ $new->priority == 'Low Priority' ? 'selected' : '' }}>Low Priority</option>
                                            </select>
                                            <div class="invalid-feedback" id="priority-error"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-12">
                                            <label for="attechments" class="form-label">Select Attachments Files</label>
                                            <div id="other_drop_zone" class="border-dashed p-5 text-center" style="border: 2px dashed gray; border-radius: 10px; cursor: pointer;">
                                                <i class="fas fa-images fa-3x mb-3" style="color: #8e54e9; font-size: 10rem;"></i>
                                                <p>Drag & Drop your images here or click anywhere to select files</p>
                                                <div id="other_file_name" class="mt-2"></div>
                                                <div id="attechments_preview" class="mt-3 text-center">
                                                    @if(isset($existingAttachments) && is_array($existingAttachments))
                                                        @foreach($existingAttachments as $attachment)
                                                            <div class="preview-image">
                                                                <img src="{{ asset('assets/Task-Attechments/' . $attachment) }}" alt="attachment">
                                                                <span class="remove-image" data-image-name="{{ $attachment }}">Remove</span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="file" class="form-control d-none" id="attechments" name="attechments[]" accept="image/*" multiple>
                                            <input type="hidden" id="removed_attachments" name="removed_attachments" value="">
                                        </div>

                                        <script>
                                            let oldImages = @json($existingAttachments);

                                            document.getElementById('other_drop_zone').addEventListener('click', function(event) {
                                                if (!event.target.classList.contains('remove-image')) {
                                                    document.getElementById('attechments').click();
                                                }
                                            });

                                            const previewContainer = document.getElementById('attechments_preview');
                                            const fileInput = document.getElementById('attechments');
                                            const removedAttachmentsInput = document.getElementById('removed_attachments');

                                            function removeFile(index, previewElement, imageName = null) {
                                                previewElement.remove();

                                                if (imageName) {
                                                    oldImages.splice(index, 1);

                                                    const removedImages = removedAttachmentsInput.value ? removedAttachmentsInput.value.split(',') : [];
                                                    removedImages.push(imageName);
                                                    removedAttachmentsInput.value = removedImages.join(',');
                                                } else {
                                                    const dt = new DataTransfer();
                                                    const { files } = fileInput;

                                                    Array.from(files).forEach((file, i) => {
                                                        if (i !== index - oldImages.length) {
                                                            dt.items.add(file);
                                                        }
                                                    });

                                                    fileInput.files = dt.files;
                                                }
                                            }

                                            document.querySelectorAll('.remove-image').forEach((removeBtn, index) => {
                                                removeBtn.addEventListener('click', function() {
                                                    const imageName = removeBtn.getAttribute('data-image-name');
                                                    removeFile(index, removeBtn.parentElement, imageName);
                                                });
                                            });

                                            fileInput.addEventListener('change', function(event) {
                                                const files = event.target.files;

                                                Array.from(files).forEach((file, index) => {
                                                    const reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        const preview = document.createElement('div');
                                                        preview.classList.add('preview-image', 'new-upload');

                                                        const img = document.createElement('img');
                                                        img.src = e.target.result;
                                                        img.alt = file.name;

                                                        const removeBtn = document.createElement('span');
                                                        removeBtn.innerText = 'Remove';
                                                        removeBtn.classList.add('remove-image');

                                                        removeBtn.addEventListener('click', function() {
                                                            removeFile(index + oldImages.length, preview);
                                                        });

                                                        preview.appendChild(img);
                                                        preview.appendChild(removeBtn);
                                                        previewContainer.appendChild(preview);
                                                    };
                                                    reader.readAsDataURL(file);
                                                });
                                            });
                                        </script>
                                    </div>


                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Update Task</button>
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
                    url: '{{ route("task.update", $new->id) }}',
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
