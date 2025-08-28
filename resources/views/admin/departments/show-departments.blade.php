@extends('admin.layouts')

@section('content')
    <html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
        data-assets-path="../assets/" data-template="vertical-menu-template-free">

    <body>
        @include('sweetalert::alert')
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <div class="layout-page">
                    <div class="card mt-5 shadow-sm rounded" style="margin: 31px;">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light border-bottom">
                            <h5 class="mb-0">All Departments</h5>
                            <button id="addDeptBtn" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#departmentModal">
                                <i class="bx bx-plus icon-sm"></i> Add Department
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-striped border-top">
                                <thead class="table-light">
                                    <tr class="text-muted text-uppercase small">
                                        <th>#</th>
                                        <th>Department Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $key => $department)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $department->name }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="text-primary fs-5 editDepartmentBtn"
                                                    data-id="{{ $department->id }}" data-name="{{ $department->name }}"
                                                    data-bs-toggle="modal" data-bs-target="#departmentModal">
                                                    <i class='bx bx-edit'></i>
                                                </a>

                                                <form action="{{ route('departments.destroy', $department->id) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this department?')"
                                                        class="btn btn-link text-danger fs-5 p-0 m-0">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add/Edit Department Modal -->
                <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="departmentForm" method="POST">
                                @csrf
                                <div id="formMethod"></div>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="departmentModalLabel">Add Department</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="dept_name" class="form-label">Department Name</label>
                                        <input type="text" name="name" id="dept_name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Add
                                        Department</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("departmentForm");
                        const nameInput = document.getElementById("dept_name");
                        const title = document.getElementById("departmentModalLabel");
                        const methodDiv = document.getElementById("formMethod");
                        const submitBtn = document.getElementById("modalSubmitBtn");

                        // ADD button
                        document.getElementById("addDeptBtn").addEventListener("click", function() {
                            form.action = "{{ route('departments.store') }}"; // POST
                            methodDiv.innerHTML = ""; // clear _method
                            nameInput.value = ""; // empty field
                            title.textContent = "Add Department";
                            submitBtn.textContent = "Add Department";
                        });

                        // EDIT buttons
                        document.querySelectorAll(".editDepartmentBtn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.dataset.id;
                                let name = this.dataset.name;

                                form.action = "/departments/" + id; // PUT route
                                methodDiv.innerHTML = `{!! method_field('PUT') !!}`;
                                nameInput.value = name; // fill input
                                title.textContent = "Edit Department";
                                submitBtn.textContent = "Update Department";
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </body>

    </html>
@endsection
