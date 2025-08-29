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
                            <h5 class="mb-0">All Employment Types</h5>
                            <button id="addEmpTypeBtn" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#employmentTypeModal">
                                <i class="bx bx-plus icon-sm"></i> Add Employment Type
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-striped border-top" id="example">
                                <thead class="table-light">
                                    <tr class="text-muted text-uppercase small">
                                        <th>#</th>
                                        <th>Employment Type</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employmentTypes as $key => $type)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $type->name }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);"
                                                    class="text-primary fs-5 editEmploymentTypeBtn"
                                                    data-id="{{ $type->id }}" data-name="{{ $type->name }}"
                                                    data-bs-toggle="modal" data-bs-target="#employmentTypeModal">
                                                    <i class='bx bx-edit'></i>
                                                </a>

                                                <form action="{{ route('employment-types.destroy', $type->id) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this employment type?')"
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

                <!-- Add/Edit Employment Type Modal -->
                <div class="modal fade" id="employmentTypeModal" tabindex="-1" aria-labelledby="employmentTypeModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="employmentTypeForm" method="POST">
                                @csrf
                                <div id="formMethod"></div>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="employmentTypeModalLabel">Add Employment Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="emp_type_name" class="form-label">Employment Type</label>
                                        <input type="text" name="name" id="emp_type_name" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Add Employment
                                        Type</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("employmentTypeForm");
                        const nameInput = document.getElementById("emp_type_name");
                        const title = document.getElementById("employmentTypeModalLabel");
                        const methodDiv = document.getElementById("formMethod");
                        const submitBtn = document.getElementById("modalSubmitBtn");

                        // ADD button
                        document.getElementById("addEmpTypeBtn").addEventListener("click", function() {
                            form.action = "{{ route('employment-types.store') }}"; // POST
                            methodDiv.innerHTML = ""; // clear _method
                            nameInput.value = ""; // empty field
                            title.textContent = "Add Employment Type";
                            submitBtn.textContent = "Add Employment Type";
                        });

                        // EDIT buttons
                        document.querySelectorAll(".editEmploymentTypeBtn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.dataset.id;
                                let name = this.dataset.name;

                                form.action = "/employment-types/" + id; // PUT route
                                methodDiv.innerHTML = `{!! method_field('PUT') !!}`;
                                nameInput.value = name; // fill input
                                title.textContent = "Edit Employment Type";
                                submitBtn.textContent = "Update Employment Type";
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </body>

    </html>
@endsection
