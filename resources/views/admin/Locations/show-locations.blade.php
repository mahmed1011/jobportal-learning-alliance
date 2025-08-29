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
                            <h5 class="mb-0">All Locations</h5>
                            <button id="addLocationBtn" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#locationModal">
                                <i class="bx bx-map icon-sm"></i> Add Location
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-striped border-top" id="example">
                                <thead class="table-light">
                                    <tr class="text-muted text-uppercase small">
                                        <th>#</th>
                                        <th>City</th>
                                        <th>Area</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($locations as $key => $location)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $location->city }}</td>
                                            <td>{{ $location->area ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="text-primary fs-5 editLocationBtn"
                                                    data-id="{{ $location->id }}" data-city="{{ $location->city }}"
                                                    data-area="{{ $location->area }}" data-bs-toggle="modal"
                                                    data-bs-target="#locationModal">
                                                    <i class='bx bx-edit'></i>
                                                </a>

                                                <form action="{{ route('locations.destroy', $location->id) }}"
                                                    method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this location?')"
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

                <!-- Add/Edit Location Modal -->
                <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="locationForm" method="POST">
                                @csrf
                                <div id="formMethod"></div>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="locationModalLabel">Add Location</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="city_name" class="form-label">City</label>
                                        <select name="city" id="city_name" class="form-select" required>
                                            <option value="" disabled selected>-- Select City --</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="area_name" class="form-label">Area</label>
                                        <input type="text" name="area" id="area_name" class="form-control">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Add Location</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("locationForm");
                        const cityInput = document.getElementById("city_name");
                        const areaInput = document.getElementById("area_name");
                        const title = document.getElementById("locationModalLabel");
                        const methodDiv = document.getElementById("formMethod");
                        const submitBtn = document.getElementById("modalSubmitBtn");

                        // ADD button
                        document.getElementById("addLocationBtn").addEventListener("click", function() {
                            form.action = "{{ route('locations.store') }}"; // POST
                            methodDiv.innerHTML = ""; // clear _method
                            cityInput.value = "";
                            areaInput.value = "";
                            title.textContent = "Add Location";
                            submitBtn.textContent = "Add Location";
                        });

                        // EDIT buttons
                        document.querySelectorAll(".editLocationBtn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let id = this.dataset.id;
                                let city = this.dataset.city;
                                let area = this.dataset.area;

                                form.action = "/locations/" + id; // PUT route
                                methodDiv.innerHTML = `{!! method_field('PUT') !!}`;
                                cityInput.value = city;
                                areaInput.value = area;
                                title.textContent = "Edit Location";
                                submitBtn.textContent = "Update Location";
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </body>

    </html>
@endsection
