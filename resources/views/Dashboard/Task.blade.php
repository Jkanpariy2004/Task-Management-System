<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<style>
    td .model-dialog {
        text-align: left !important;
    }

    .comment-section {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .comments-display {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 20px;
    }

    .comment-input {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        padding: 20px;
    }

    .comment {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .comment-author {
        font-weight: bold;
    }

    .comment-time {
        font-size: 0.9em;
        color: #777;
    }

    .comments-list {
        max-height: 500px;
        overflow-y: auto; 
    }

</style>

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('Dashboard.Layouts.Sidenavbar')

        <div class="layout-page">

            @include('Dashboard.Layouts.header')

            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Task
                        </h4>

                        <div class="card p-4">
                            <div class="card-datatable table-responsive pt-0">

                                <div class="d-flex mb-3">
                                    <div class="w-50 text-start">
                                        <h3>Task Data</h3>
                                    </div>
                                    <div class="w-50 text-end">
                                        <a href="/add-task" class="btn btn-primary">
                                            <i class="ti ti-plus me-sm-1"></i>Add Task
                                        </a>

                                        <a href="#" id="bulk-delete-btn" class="btn btn-danger">
                                            <i class="ti ti-trash me-sm-1"></i>Bulk Delete
                                        </a>
                                    </div>
                                </div>
                                <table class="table" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><input type="checkbox" id="select-all"
                                                    class="animated-checkbox" /></th>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">Due Date</th>
                                            <th class="text-center">Priority</th>
                                            <th class="text-center">Comment</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        @if (session('success'))
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success!',
                                                text: "{{ session('success') }}",
                                                confirmButtonText: 'OK'
                                            });
                                        @endif

                                        @if (session('error'))
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error!',
                                                text: "{{ session('error') }}",
                                                confirmButtonText: 'OK'
                                            });
                                        @endif

                                        $(document).ready(function () {
                                            $.ajax({
                                                type: "GET",
                                                url: "/fetch-task",
                                                dataType: "json",
                                                success: function (response) {
                                                    $('#example').DataTable().clear().destroy();

                                                    let tableData = [];
                                                    $.each(response.tasks, function (key, item) {
                                                        tableData.push([
                                                            `<input type="checkbox" class="select-item animated-checkbox" data-id="${item.id}" />`,
                                                            item.id,
                                                            item.title,
                                                            item.description,
                                                            item.start_date,
                                                            item.due_date,
                                                            item.priority,
                                                            `
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-${item.id}">
                                                                Comments
                                                            </button>

                                                            <div class="modal fade" id="exampleModal-${item.id}" tabindex="-1" aria-labelledby="exampleModalLabel-${item.id}" aria-hidden="true">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content h-50">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel-${item.id}">Comments</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body text-start">
                                                                            <div id="commentList-${item.id}" class="comments-list overflow-auto" style="flex-grow: 1; max-height: 300px;" data-comment-count="{{ $comments->count() }}">
                                                                                @if($comments->isNotEmpty())
                                                                                    <ul>
                                                                                        @foreach($comments as $comment)
                                                                                            <li class="mb-2" data-comment-id="{{ $comment->id }}">
                                                                                                <strong>{{ $comment->user_id ?? 'Anonymous' }}:</strong> 
                                                                                                {{ $comment->comment_text }} 
                                                                                                <small>{{ \Carbon\Carbon::parse($comment->created_at)->setTimezone('Asia/Kolkata')->format('d/m/Y h:i a') }}</small>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </div>

                                                                            <form class="commentForm" data-post-id="${item.id}">
                                                                                @csrf
                                                                                <div class="comment-input d-flex gap-3">
                                                                                    <input name="comment_text" class="form-control" placeholder="Leave a comment..." required />
                                                                                    <input type="hidden" name="post_id" value="${item.id}">
                                                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            `,
                                                            `<div>
                                                                <a href="/task-edit/${item.id}" class="btn btn-sm btn-icon item-edit">
                                                                    <i class="text-primary ti ti-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-sm btn-icon item-delete" href="#" data-id="${item.id}">
                                                                    <i class="text-danger ti ti-trash"></i>
                                                                </a>
                                                            </div>`
                                                        ]);
                                                    });

                                                    $('#example').DataTable({
                                                        data: tableData,
                                                        lengthMenu: [7, 10, 25, 50, 75, 100],
                                                        responsive: true,
                                                        paging: true,
                                                        searching: true,
                                                        ordering: true,
                                                        columnDefs: [{ targets: 0, orderable: false }],
                                                        drawCallback: function (settings) {
                                                            $('.item-delete').off('click').on('click', function (event) {
                                                                event.preventDefault();
                                                                const id = $(this).data('id');
                                                                Swal.fire({
                                                                    title: 'Are you sure?',
                                                                    text: "You won't be able to revert this!",
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'Yes, delete it!'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        $.ajax({
                                                                            url: `/task-delete/${id}`,
                                                                            method: 'GET',
                                                                            data: { _token: '{{ csrf_token() }}' },
                                                                            success: function () {
                                                                                Swal.fire({
                                                                                    icon: 'success',
                                                                                    title: 'Deleted!',
                                                                                    text: 'The Task has been deleted.',
                                                                                    confirmButtonText: 'OK'
                                                                                }).then(() => {
                                                                                    $('#example').DataTable().row($(event.target).closest('tr')).remove().draw();
                                                                                });
                                                                            },
                                                                            error: function (xhr, status, error) {
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Error!',
                                                                                    text: 'An error occurred while deleting the task.',
                                                                                    confirmButtonText: 'OK'
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            });

                                                            $('.commentForm').off('submit').on('submit', function (event) {
                                                                event.preventDefault();
                                                                const postId = $(this).data('post-id');
                                                                const form = $(this);
                                                                const commentText = form.find('input[name="comment_text"]').val();

                                                                $.ajax({
                                                                    url: '/store-comments',
                                                                    method: 'POST',
                                                                    data: form.serialize(),
                                                                    success: function (response) {
                                                                        let newComment = `
                                                                            <li class="mb-2">
                                                                                <strong>${response.comment.user_id}:</strong> 
                                                                                ${response.comment.comment_text} 
                                                                                <small>${new Date(response.comment.created_at).toLocaleString('en-IN', { timeZone: 'Asia/Kolkata', dateStyle: 'short', timeStyle: 'short' })}</small>
                                                                            </li>`;

                                                                        $(`#commentList-${response.comment.post_id}`).append(newComment);

                                                                        form.find('input[name="comment_text"]').val('');
                                                                    },
                                                                    error: function (xhr, status, error) {
                                                                        Swal.fire({
                                                                            icon: 'error',
                                                                            title: 'Error!',
                                                                            text: 'Failed to post the comment.',
                                                                            confirmButtonText: 'OK'
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        }
                                                    });
                                                }
                                            });

                                            // Bulk delete functionality...
                                            $('#select-all').on('click', function () {
                                                const isChecked = $(this).prop('checked');
                                                $('.select-item').prop('checked', isChecked);
                                            });

                                            $('#bulk-delete-btn').on('click', function (event) {
                                                event.preventDefault();
                                                const selectedIds = [];
                                                $('.select-item:checked').each(function () {
                                                    selectedIds.push($(this).data('id'));
                                                });

                                                if (selectedIds.length === 0) {
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'No selection',
                                                        text: 'Please select at least one item to delete.',
                                                        confirmButtonText: 'OK'
                                                    });
                                                    return;
                                                }

                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: `You are about to delete ${selectedIds.length} items!`,
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, delete them!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: '/bulk-delete-task',
                                                            method: 'POST',
                                                            data: {
                                                                ids: selectedIds,
                                                                _token: '{{ csrf_token() }}'
                                                            },
                                                            success: function () {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Deleted!',
                                                                    text: 'Selected items have been deleted.',
                                                                    confirmButtonText: 'OK'
                                                                }).then(() => {
                                                                    var table = $('#example').DataTable();
                                                                    selectedIds.forEach(function (id) {
                                                                        table.row($(`input[data-id="${id}"]`).closest('tr')).remove();
                                                                    });
                                                                    table.draw();

                                                                    $('#select-all').prop('checked', false);
                                                                });
                                                            },
                                                            error: function (xhr, status, error) {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Error!',
                                                                    text: 'An error occurred while deleting items.',
                                                                    confirmButtonText: 'OK'
                                                                });
                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Content -->

                @include('Dashboard.Layouts.footer')

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