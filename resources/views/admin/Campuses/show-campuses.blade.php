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
                            <h5 class="mb-0">All Campuses</h5>
                            <button id="addCampusBtn" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#campusModal">
                                <i class="bx bx-building-house icon-sm"></i> Add Campus
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-striped border-top" id="example">
                                <thead class="table-light">
                                    <tr class="text-muted text-uppercase small">
                                        <th>#</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($campuses as $key => $campus)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if ($campus->logo_path)
                                                    <img src="{{ asset('storage/' . $campus->logo_path) }}" alt="Logo"
                                                        width="50" class="rounded">
                                                @else
                                                    <span class="text-muted">No Logo</span>
                                                @endif
                                            </td>
                                            <td>{{ $campus->name }}</td>
                                            <td>{{ $campus->city }}</td>
                                            <td>{{ $campus->address }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="text-primary fs-5 editCampusBtn"
                                                    data-id="{{ $campus->id }}" data-name="{{ $campus->name }}"
                                                    data-city="{{ $campus->city }}" data-address="{{ $campus->address }}"
                                                    data-logo="{{ $campus->logo_path }}" data-bs-toggle="modal"
                                                    data-bs-target="#campusModal">
                                                    <i class='bx bx-edit'></i>
                                                </a>


                                                <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this campus?')"
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

                <!-- Add/Edit Campus Modal -->
                <div class="modal fade" id="campusModal" tabindex="-1" aria-labelledby="campusModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="campusForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div id="formMethod"></div>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="campusModalLabel">Add Campus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Campus Name</label>
                                        <input type="text" name="name" id="campus_name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="campus_city" class="form-label">City</label>
                                        <select name="city" id="campus_city" class="form-select" required>
                                            <option value="" disabled selected>-- Select City --</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" id="campus_address" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Logo</label>
                                        <input type="file" name="logo" class="form-control">
                                        <!-- Preview (visible only when editing) -->
                                        <div id="logoPreviewContainer" class="mt-2" style="display:none;">
                                            <p class="small text-muted mb-1">Current Logo:</p>
                                            <img id="logoPreview" src="" alt="Campus Logo" width="80"
                                                class="rounded shadow-sm border">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Add
                                        Campus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("campusForm");
                        const nameInput = document.getElementById("campus_name");
                        const cityInput = document.getElementById("campus_city");
                        const addressInput = document.getElementById("campus_address");
                        const title = document.getElementById("campusModalLabel");
                        const methodDiv = document.getElementById("formMethod");
                        const submitBtn = document.getElementById("modalSubmitBtn");
                        const logoPreviewContainer = document.getElementById("logoPreviewContainer");
                        const logoPreview = document.getElementById("logoPreview");

                        // ADD button
                        document.getElementById("addCampusBtn").addEventListener("click", function() {
                            form.action = "{{ route('campuses.store') }}"; // POST
                            methodDiv.innerHTML = "";
                            nameInput.value = "";
                            cityInput.value = "";
                            addressInput.value = "";
                            title.textContent = "Add Campus";
                            submitBtn.textContent = "Add Campus";

                            // hide logo preview
                            logoPreviewContainer.style.display = "none";
                            logoPreview.src = "";
                        });

                        // EDIT buttons
                        document.querySelectorAll(".editCampusBtn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.dataset.id;
                                let name = this.dataset.name;
                                let city = this.dataset.city;
                                let address = this.dataset.address;
                                let logo = this.dataset.logo; // new: logo_path pass karna hoga

                                form.action = "/campuses/" + id;
                                methodDiv.innerHTML = `{!! method_field('PUT') !!}`;
                                nameInput.value = name;
                                cityInput.value = city;
                                addressInput.value = address;
                                title.textContent = "Edit Campus";
                                submitBtn.textContent = "Update Campus";

                                // show logo preview if exists
                                if (logo && logo !== "") {
                                    logoPreview.src = "/storage/" + logo;
                                    logoPreviewContainer.style.display = "block";
                                } else {
                                    logoPreviewContainer.style.display = "none";
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </body>

    </html>
@endsection
