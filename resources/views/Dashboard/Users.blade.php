<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<style>
    td{
        width: 11% !important;
    }
</style>

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('Layouts.Sidenavbar')

        <div class="layout-page">

            @include('Layouts.header')

            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Users
                        </h4>

                        <div class="card p-4">
                            <div class="card-datatable table-responsive pt-0">

                                <div class="d-flex mb-3">
                                    <div class="w-50 text-start">
                                        <h3>User Data</h3>
                                    </div>
                                    <div class="w-50 text-end">
                                        <a href="/add-users" class="btn btn-primary">
                                            <i class="ti ti-plus me-sm-1"></i>Add User
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
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Designation</th>
                                            <th class="text-center">Joining Date</th>
                                            <th class="text-center">Birth Date</th>
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
                                                url: "/fetch-users",
                                                dataType: "json",
                                                success: function(response) {
                                                    $('#example').DataTable().clear().destroy();

                                                    let tableData = [];

                                                    $.each(response.users, function(key, item) {
                                                        tableData.push([
                                                            `<input type="checkbox" class="select-item animated-checkbox" data-id="${item.id}" />`,
                                                            item.id,
                                                            item.name,
                                                            item.email,
                                                            item.mobile,
                                                            item.designation,
                                                            item.joining_date,
                                                            item.birth_date,
                                                            `<div>
                                                                <a href="/users-edit/${item.id}" class="btn btn-sm btn-icon item-edit">
                                                                    <i class="text-primary ti ti-pencil"></i>
                                                                </a>
                                                                <a class="btn btn-sm btn-icon item-delete" href="#" data-id="${item.id}">
                                                                    <i class="text-danger ti ti-trash"></i>
                                                                </a>
                                                                <a class="btn btn-sm btn-icon item-mail" href="#" data-email="${item.email}">
                                                                    <i class="text-success ti ti-mail"></i>
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
                                                                            url: `/users-delete/${id}`,
                                                                            method: 'GET',
                                                                            data: {
                                                                                _token: '{{ csrf_token() }}'
                                                                            },
                                                                            success: function(response) {
                                                                                Swal.fire({
                                                                                    icon: 'success',
                                                                                    title: 'Deleted!',
                                                                                    text: 'The post has been deleted.',
                                                                                    confirmButtonText: 'OK'
                                                                                })
                                                                                .then(() => {
                                                                                    $('#example').DataTable().row($(event.target).closest('tr')).remove().draw();
                                                                                });
                                                                            },
                                                                            error: function(xhr,status,error) {
                                                                                console.error('Error deleting post:',xhr,status,error);
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Error!',
                                                                                    text: 'An error occurred while deleting the post.',
                                                                                    confirmButtonText: 'OK'
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            });

                                                            $('.item-mail').off('click').on('click', function(event) {
                                                                event.preventDefault();
                                                                const email = $(this).data('email');

                                                                Swal.fire({
                                                                    title: 'Send Invitation',
                                                                    text: `Send an invitation to ${email}?`,
                                                                    icon: 'info',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Yes, send it!'
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {

                                                                        Swal.fire({
                                                                            title: 'Processing...',
                                                                            text: 'Invitation Mail Sending in Process, please wait...',
                                                                            allowOutsideClick: false,
                                                                            didOpen: () => {
                                                                                Swal.showLoading();
                                                                            }
                                                                        });


                                                                        $.ajax({
                                                                            url: '/send-invitation',
                                                                            method: 'POST',
                                                                            data: {
                                                                                email: email,
                                                                                _token: '{{ csrf_token() }}'
                                                                            },
                                                                            success: function(response) {
                                                                                Swal.fire({
                                                                                    icon: 'success',
                                                                                    title: 'Sent!',
                                                                                    text: 'Invitation email has been sent.',
                                                                                    confirmButtonText: 'OK'
                                                                                });
                                                                            },
                                                                            error: function(xhr, status, error) {
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Error!',
                                                                                    text: 'An error occurred while sending the email.',
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
                                                            url: '/bulk-delete-users',
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
                                                                    var table = $('#example').DataTable();
                                                                    selectedIds.forEach(function(id) {
                                                                        table.row($(`input[data-id="${id}"]`).closest('tr')).remove();
                                                                    });
                                                                    table.draw();

                                                                    $('#select-all').prop('checked',false);
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
