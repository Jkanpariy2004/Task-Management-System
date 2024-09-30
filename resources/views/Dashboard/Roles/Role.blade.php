<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<style>
    .large-checkbox {
        transform: scale(1.5);
        margin-right: 8px;
    }

    .permission-checkboxes label {
        font-size: 1rem;
    }

    .modal-body {
        font-size: 1.1rem;
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Role
                        </h4>

                        <div class="card p-4">
                            <div class="card-datatable table-responsive pt-0">

                                <div class="d-flex mb-3">
                                    <div class="w-50 text-start">
                                        <h3>Role Data</h3>
                                    </div>
                                    <div class="w-50 text-end">
                                        <a href="{{ route('add.role') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-sm-1"></i>Add Role
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
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Assign Permission</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
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

                                        $(document).ready(function() {
                                            $.ajax({
                                                type: "GET",
                                                url: "{{ route('role.fetch') }}",
                                                dataType: "json",
                                                success: function(response) {
                                                    $('#example').DataTable().clear().destroy();

                                                    let tableData = [];

                                                    $.each(response.roles, function(key, item) {
                                                        const modalId =
                                                        `exampleModal-permission-${item.id}`; // Unique modal ID

                                                        tableData.push([
                                                            `<input type="checkbox" class="select-item animated-checkbox" data-id="${item.id}" />`,
                                                            item.id,
                                                            item.role_name,
                                                            `
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#${modalId}">
            Permission
        </button>
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="exampleModalLabel-permission-${item.id}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content h-auto">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel-permission-${item.id}">Assign Permission</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <form action="/assign-permission" method="POST">
                            @csrf
                            <input type="hidden" name="role_id" value="${item.id}">
                            @foreach ($permissions as $permission)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="permission-name">
                                        <strong>{{ $permission->permission_name }}</strong>
                                    </div>
                                    <div class="permission-checkboxes d-flex">
                                        <label class="form-check-label me-4">
                                            <input class="form-check-input large-checkbox" type="checkbox" name="permissions[{{ $permission->id }}][list]" {{ isset($userPermissions[$permission->id]['list']) && $userPermissions[$permission->id]['list'] ? 'checked' : '' }}> List
                                        </label>
                                        <label class="form-check-label me-4">
                                            <input class="form-check-input large-checkbox" type="checkbox" name="permissions[{{ $permission->id }}][create]" {{ isset($userPermissions[$permission->id]['create']) && $userPermissions[$permission->id]['create'] ? 'checked' : '' }}> Create
                                        </label>
                                        <label class="form-check-label me-4">
                                            <input class="form-check-input large-checkbox" type="checkbox" name="permissions[{{ $permission->id }}][update]" {{ isset($userPermissions[$permission->id]['update']) && $userPermissions[$permission->id]['update'] ? 'checked' : '' }}> Update
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input large-checkbox" type="checkbox" name="permissions[{{ $permission->id }}][delete]" {{ isset($userPermissions[$permission->id]['delete']) && $userPermissions[$permission->id]['delete'] ? 'checked' : '' }}> Delete
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <div class="w-100 text-end">
                                <button type="submit" class="btn btn-primary">Assign Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        `,
                                                            `<div>
            <a href="/admin/role/edit/${item.id}" class="btn btn-sm btn-icon item-edit">
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
                                                        columnDefs: [{
                                                            targets: 0,
                                                            orderable: false
                                                        }],
                                                        drawCallback: function(settings) {
                                                            $('.item-delete').off('click').on('click', function(
                                                                event) {
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
                                                                            url: '{{ route('delete.role', ':id') }}'
                                                                                .replace(
                                                                                    ':id',
                                                                                    id),
                                                                            method: 'GET',
                                                                            data: {
                                                                                _token: '{{ csrf_token() }}'
                                                                            },
                                                                            success: function(
                                                                                response
                                                                            ) {
                                                                                Swal.fire({
                                                                                        icon: 'success',
                                                                                        title: 'Deleted!',
                                                                                        text: response
                                                                                            .message,
                                                                                        timer: 3000,
                                                                                        timerProgressBar: true,
                                                                                        confirmButtonText: 'OK'
                                                                                    })
                                                                                    .then(
                                                                                        () => {
                                                                                            $('#example')
                                                                                                .DataTable()
                                                                                                .row(
                                                                                                    $(event
                                                                                                        .target
                                                                                                    )
                                                                                                    .closest(
                                                                                                        'tr'
                                                                                                    )
                                                                                                )
                                                                                                .remove()
                                                                                                .draw();
                                                                                        }
                                                                                    );
                                                                            },
                                                                            error: function(
                                                                                xhr,
                                                                                status,
                                                                                error
                                                                            ) {
                                                                                console
                                                                                    .error(
                                                                                        'Error deleting post:',
                                                                                        xhr,
                                                                                        status,
                                                                                        error
                                                                                    );
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Error!',
                                                                                    text: 'An error occurred while deleting the Company.',
                                                                                    confirmButtonText: 'OK'
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            });
                                                        }
                                                    });
                                                }
                                            });

                                            $('#select-all').on('click', function() {
                                                const isChecked = $(this).prop('checked');
                                                $('.select-item').prop('checked', isChecked);
                                            });

                                            $('#bulk-delete-btn').on('click', function(event) {
                                                event.preventDefault();
                                                const selectedIds = [];
                                                $('.select-item:checked').each(function() {
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
                                                            url: '{{ route('bulk.delete.company') }}',
                                                            method: 'POST',
                                                            data: {
                                                                ids: selectedIds,
                                                                _token: '{{ csrf_token() }}'
                                                            },
                                                            success: function(response) {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: 'Deleted!',
                                                                    text: 'Selected items have been deleted.',
                                                                    confirmButtonText: 'OK'
                                                                }).then(() => {
                                                                    var table = $('#example')
                                                                        .DataTable();
                                                                    selectedIds.forEach(function(
                                                                        id) {
                                                                        table.row($(
                                                                                    `input[data-id="${id}"]`
                                                                                )
                                                                                .closest(
                                                                                    'tr'))
                                                                            .remove();
                                                                    });
                                                                    table.draw();

                                                                    $('#select-all').prop('checked',
                                                                        false);
                                                                });
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error('Error deleting items:', xhr,
                                                                    status, error);
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
