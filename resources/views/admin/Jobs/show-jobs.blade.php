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
                            <h5 class="mb-0">All Jobs</h5>
                            <button id="addJobBtn" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#jobModal">
                                <i class="bx bx-briefcase icon-sm"></i> Add Job
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-striped border-top" id="example">
                                <thead class="table-light">
                                    <tr class="text-muted text-uppercase small">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Department</th>
                                        <th>Employment Type</th>
                                        <th>Campus</th>
                                        <th>Status</th>
                                        <th>Posted</th>
                                        <th>Expire</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $key => $job)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $job->title }}</td>
                                            <td>{{ $job->department->name ?? '-' }}</td>
                                            <td>{{ $job->employmentType->name ?? '-' }}</td>
                                            <td>
                                                @foreach (json_decode($job->campus_ids, true) ?? [] as $cid)
                                                    <span
                                                        class="badge bg-info">{{ \App\Models\Campus::find($cid)->name ?? '' }}</span>
                                                @endforeach
                                            </td>

                                            <td><span
                                                    class="badge bg-{{ $job->status == 'published' ? 'success' : ($job->status == 'draft' ? 'secondary' : 'danger') }}">
                                                    {{ ucfirst($job->status) }}</span></td>
                                            <td>{{ $job->posted_at->diffForHumans() }}</td>
                                            <td>{{ \Carbon\Carbon::parse($job->expires_at)->format('d-m-Y') }}</td>


                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="text-primary fs-5 editJobBtn"
                                                    data-id="{{ $job->id }}" data-title="{{ $job->title }}"
                                                    data-department="{{ $job->department_id }}"
                                                    data-employment="{{ $job->employment_type_id }}"
                                                    data-location="{{ $job->location_id }}"
                                                    data-campuses='@json(json_decode($job->campus_ids, true))'
                                                    data-description="{{ $job->description }}"
                                                    data-status="{{ $job->status }}" data-bs-toggle="modal"
                                                    data-bs-target="#jobModal">
                                                    <i class='bx bx-edit'></i>
                                                </a>



                                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this job?')"
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

                <!-- Add/Edit Job Modal -->
                <div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="jobForm" method="POST">
                                @csrf
                                <div id="formMethod"></div>

                                <div class="modal-header">
                                    <h5 class="modal-title" id="jobModalLabel">Add Job</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Job Title</label>
                                        <input type="text" name="title" id="job_title" class="form-control" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Department</label>
                                            <select name="department_id" id="job_department" class="form-control" required>
                                                <option value="">Select</option>
                                                @foreach ($departments as $dep)
                                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Employment Type</label>
                                            <select name="employment_type_id" id="job_employment" class="form-control"
                                                required>
                                                <option value="">Select</option>
                                                @foreach ($employmentTypes as $et)
                                                    <option value="{{ $et->id }}">{{ $et->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Select Campuses</label>
                                        <div id="campusCheckboxes" class="border rounded p-3"
                                            style="max-height: 250px; overflow-y: auto; background: #f9f9f9;">
                                            @foreach ($campuses as $campus)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input campus-checkbox" type="checkbox"
                                                        name="campus_ids[]" value="{{ $campus->id }}"
                                                        id="campus_{{ $campus->id }}">
                                                    <label class="form-check-label fw-semibold"
                                                        for="campus_{{ $campus->id }}">
                                                        {{ $campus->name }}
                                                        <small class="text-muted d-block">
                                                            {{ $campus->city }} – {{ $campus->address }}
                                                        </small>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <small class="text-muted">Select one or more campuses where this job will be
                                            available.</small>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="job_description" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" id="job_status" class="form-control" required>
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="closed">Closed</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Expires At</label>
                                        <input type="date" name="expires_at" id="job_expires" class="form-control">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Add Job</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("jobForm");
                        const title = document.getElementById("jobModalLabel");
                        const methodDiv = document.getElementById("formMethod");
                        const submitBtn = document.getElementById("modalSubmitBtn");

                        // ADD
                        document.getElementById("addJobBtn").addEventListener("click", function() {
                            form.action = "{{ route('jobs.store') }}";
                            methodDiv.innerHTML = "";
                            form.reset();
                            title.textContent = "Add Job";
                            submitBtn.textContent = "Add Job";
                        });

                        // EDIT
                        // EDIT
                        document.querySelectorAll(".editJobBtn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                let campuses = JSON.parse(this.dataset.campuses || "[]");
                                let campusSelect = document.getElementById("job_campus");

                                form.action = "/jobs/" + this.dataset.id;
                                methodDiv.innerHTML = `{!! method_field('PUT') !!}`;
                                document.getElementById("job_title").value = this.dataset.title;
                                document.getElementById("job_department").value = this.dataset.department;
                                document.getElementById("job_employment").value = this.dataset.employment;
                                document.getElementById("job_location").value = this.dataset.location;
                                document.getElementById("job_description").value = this.dataset.description;
                                document.getElementById("job_status").value = this.dataset.status;
                                title.textContent = "Edit Job";
                                submitBtn.textContent = "Update Job";

                                // ✅ Preselect multiple campuses
                                Array.from(campusSelect.options).forEach(opt => {
                                    opt.selected = campuses.includes(parseInt(opt.value));
                                });
                            });
                        });

                    });
                </script>
            </div>
        </div>
    </body>

    </html>
@endsection
