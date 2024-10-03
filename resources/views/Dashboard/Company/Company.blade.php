<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('Dashboard.Layouts.Sidenavbar')

        <div class="layout-page">

            @include('Dashboard.Layouts.header')

            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Company
                        </h4>

                        <div class="card p-4">
                            <div class="card-datatable table-responsive pt-0">
                                <div class="d-flex mb-3">
                                    <div class="w-50 text-start">
                                        <h3>Company Data</h3>
                                    </div>

                                    <div class="w-50">
                                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#csvModal">
                                            <i class="ti ti-plus me-sm-1"></i>
                                            <span class="mt-1">Import CSV</span>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="csvModal" tabindex="-1"
                                            aria-labelledby="csvModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="csvModalLabel">Import CSV</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="csvForm" action="{{ route('import.csv') }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="csvFile" class="form-label">Select CSV
                                                                    File</label>
                                                                <input type="file" name="csv_file"
                                                                    class="form-control" id="csvFile" accept=".csv">
                                                                @error('csv_file')
                                                                    <div class="alert alert-danger">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary">Upload</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="javascript:void(0);" onclick="exportPDF()" class="btn btn-info">
                                            <i class="ti ti-file-description me-1"></i>
                                            <span class="mt-1">Export PDF</span>
                                        </a>

                                        <script>
                                            function exportPDF() {
                                                Swal.fire({
                                                    title: 'Processing...',
                                                    text: 'Generating PDF, please wait...',
                                                    allowOutsideClick: false,
                                                    didOpen: () => {
                                                        Swal.showLoading();
                                                    }
                                                });

                                                fetch('{{ route('company.export.pdf') }}')
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error('Network response was not ok');
                                                        }
                                                        return response.blob();
                                                    })
                                                    .then(blob => {
                                                        const url = window.URL.createObjectURL(blob);
                                                        const a = document.createElement('a');
                                                        a.style.display = 'none';
                                                        a.href = url;
                                                        a.download = 'companies.pdf';
                                                        document.body.appendChild(a);
                                                        a.click();
                                                        window.URL.revokeObjectURL(url);
                                                        Swal.fire('Success!', 'PDF generated successfully.', 'success');
                                                    })
                                                    .catch(error => {
                                                        Swal.fire('Error!', 'There was a problem generating the PDF: ' + error.message, 'error');
                                                    });
                                            }
                                        </script>

                                        <a href="/admin/company/add" class="btn btn-primary">
                                            <i class="ti ti-plus me-sm-1"></i>
                                            <span class="mt-1">Add Company</span>
                                        </a>
                                        <a href="#" id="bulk-delete-btn" class="btn btn-danger">
                                            <i class="ti ti-trash me-sm-1"></i>
                                            <span class="mt-1">Bulk Delete</span>
                                        </a>
                                    </div>
                                </div>
                                <table class="table" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><input type="checkbox" id="select-all"
                                                    class="animated-checkbox" /></th>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Company Name</th>
                                            <th class="text-center">Company Email</th>
                                            <th class="text-center">Company Phone No.</th>
                                            <th class="text-center">Company Address</th>
                                            <th class="text-center">City</th>
                                            <th class="text-center">Country</th>
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
                                            $('#example').DataTable({
                                                processing: true,
                                                ajax: {
                                                    url: "/admin/company/fetch-company",
                                                    dataType: "json",
                                                    dataSrc: "companys"
                                                },
                                                columns: [{
                                                        data: null,
                                                        render: function(data, type, row) {
                                                            return `<input type="checkbox" class="select-item animated-checkbox" data-id="${row.id}" />`;
                                                        }
                                                    },
                                                    {
                                                        data: "id"
                                                    },
                                                    {
                                                        data: "c_name"
                                                    },
                                                    {
                                                        data: "c_email"
                                                    },
                                                    {
                                                        data: "c_phone_no"
                                                    },
                                                    {
                                                        data: "c_address"
                                                    },
                                                    {
                                                        data: "city"
                                                    },
                                                    {
                                                        data: "country"
                                                    },
                                                    {
                                                        data: null,
                                                        render: function(data, type, row) {
                                                            return `<div>
                                                            <a href="/admin/company/edit/${row.id}" class="btn btn-sm btn-icon item-edit">
                                                                <i class="text-primary ti ti-pencil"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-icon item-delete" href="#" data-id="${row.id}">
                                                                <i class="text-danger ti ti-trash"></i>
                                                            </a>
                                                        </div>`;
                                                        }
                                                    }
                                                ],
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
                                                    $('.item-delete').off('click').on('click', function(event) {
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
                                                                    url: `/admin/company/delete/${id}`,
                                                                    method: 'GET',
                                                                    data: {
                                                                        _token: '{{ csrf_token() }}'
                                                                    },
                                                                    success: function(response) {
                                                                        Swal.fire({
                                                                            icon: 'success',
                                                                            title: 'Deleted!',
                                                                            text: 'The Company has been deleted.',
                                                                            confirmButtonText: 'OK'
                                                                        }).then(() => {
                                                                            $('#example')
                                                                                .DataTable()
                                                                                .row($(event
                                                                                        .target
                                                                                    )
                                                                                    .closest(
                                                                                        'tr'
                                                                                    )
                                                                                )
                                                                                .remove()
                                                                                .draw();
                                                                        });
                                                                    },
                                                                    error: function(xhr, status,
                                                                        error) {
                                                                        console.error(
                                                                            'Error deleting post:',
                                                                            xhr, status,
                                                                            error);
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
