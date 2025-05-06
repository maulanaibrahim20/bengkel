@extends('index')
@section('content')
    <!-- Page Header with Improved Design -->
    <div class="page-header bg-light rounded-3 shadow-sm mb-4 p-4">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title fw-bold text-primary mb-2">User Profile</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}"
                                class="text-decoration-none"><i class="fa fa-home me-1"></i>Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Sidebar with Improved Design -->
        <div class="col-md-4 col-lg-3">
            <div class="card profile-sidebar border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-body p-0">
                    <!-- Background Cover Image -->
                    <div class="profile-bg-cover bg-primary" style="height: 100px;"></div>

                    <div class="p-4">
                        <!-- Profile Image with Better Positioning -->
                        <div class="profile-image-wrap text-center position-relative" style="margin-top: -60px;">
                            <div class="profile-image mb-3">
                                @php
                                    use Illuminate\Support\Str;

                                    $user = Auth::user();
                                    $image = $user->profile_image;

                                    $defaultImages = [
                                        1 => 'img/adminsuper123.png',
                                        2 => 'img/adminsuper123.png',
                                        3 => 'assets/img/profiles/avatar-01.jpg',
                                    ];

                                    $defaultImage =
                                        $defaultImages[$user->role_id] ?? 'assets/img/profiles/avatar-01.jpg';

                                    $imageUrl = Str::startsWith($image, ['http://', 'https://'])
                                        ? $image
                                        : asset($image ?: $defaultImage);
                                @endphp

                                <img src="{{ $imageUrl }}"
                                    class="rounded-circle img-fluid border border-4 border-white shadow" alt="User Profile"
                                    style="width: 120px; height: 120px; object-fit: cover;">

                                <div class="profile-status online"></div>
                            </div>
                            <div class="edit-profile-image position-absolute"
                                style="bottom: 0; right: 35%; background-color: #fff; padding: 8px; border-radius: 50%; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                <a href="#" data-bs-toggle="tooltip" title="Change Profile Picture">
                                    <i class="fa fa-camera text-primary"></i>
                                </a>
                            </div>
                        </div>

                        <div class="profile-info text-center mt-2">
                            <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                            <div class="text-muted small mb-3">
                                <i class="fa fa-calendar-alt me-1"></i> Member since
                                {{ $user->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Contact Information with Icons -->
                        <div class="profile-contact-info">
                            <h5 class="mb-3 fw-semibold text-primary"><i class="fa fa-address-card me-2"></i>Contact
                                Information</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex align-items-center">
                                    <span
                                        class="contact-icon bg-primary-light text-primary rounded-circle me-3 d-inline-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <a href="tel:+62{{ $user->phone }}" class="text-body text-decoration-none">(+62)
                                        {{ $user->phone }}</a>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <span
                                        class="contact-icon bg-primary-light text-primary rounded-circle me-3 d-inline-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <a href="mailto:{{ $user->email }}"
                                        class="text-body text-decoration-none">{{ $user->email }}</a>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <span
                                        class="contact-icon bg-primary-light text-primary rounded-circle me-3 d-inline-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;">
                                        <i class="fa fa-birthday-cake"></i>
                                    </span>
                                    <span>{{ $user->birth_date ?? 'Not specified' }}</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <span
                                        class="contact-icon bg-primary-light text-primary rounded-circle me-3 d-inline-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px;">
                                        <i class="fa fa-map-marker-alt"></i>
                                    </span>
                                    <span>{{ $user->address ?? 'Not specified' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="card border-0 shadow-sm rounded-3 mb-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center p-4 border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="fa fa-user-circle me-2"></i>Profile Information
                    </h5>
                    <a href="#" class="btn btn-primary editBtn rounded-pill px-4" data-id="{{ $user->id }}">
                        <i class="fa fa-pencil me-2"></i> Edit Profile
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="info-group mb-4 p-3 bg-light rounded-3">
                                <label class="d-block text-muted small mb-2 fw-semibold">Full Name</label>
                                <div class="info-value fs-5">{{ $user->name }}</div>
                            </div>

                            <div class="info-group mb-4 p-3 bg-light rounded-3">
                                <label class="d-block text-muted small mb-2 fw-semibold">Gender</label>
                                <div class="info-value fs-5">
                                    @if ($user->gender == 'male')
                                        <i class="fa fa-mars text-primary me-2"></i>Laki-Laki
                                    @elseif($user->gender == 'female')
                                        <i class="fa fa-venus text-pink me-2"></i>Perempuan
                                    @else
                                        <i class="fa fa-genderless text-muted me-2"></i>Not specified
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="info-group mb-4 p-3 bg-light rounded-3">
                                <label class="d-block text-muted small mb-2 fw-semibold">Status</label>
                                <div class="info-value fs-5">
                                    @if ($user->status == 1)
                                        <span class="badge bg-success-light text-success py-2 px-3 rounded-pill">
                                            <i class="fa fa-check-circle me-2"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger-light text-danger py-2 px-3 rounded-pill">
                                            <i class="fa fa-times-circle me-2"></i>Not Active
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-group mb-4 p-3 bg-light rounded-3">
                                <label class="d-block text-muted small mb-2 fw-semibold">Last Login</label>
                                <div class="info-value fs-5">
                                    <i class="fa fa-clock text-info me-2"></i>
                                    {{ $user->last_login_at ?? 'Not available' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="profile_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fa fa-edit me-2"></i>Edit Profile Information</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="modal-content"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            $('.form-select').select2({
                minimumResultsForSearch: 10,
                width: '100%'
            });
        });

        $(document).on('click', '.editBtn', function() {

            const id = $(this).data('id');
            console.log(id);

            const baseUserPrefix = "{{ request()->segment(1) }}";

            $.ajax({
                url: '/' + baseUserPrefix + '/profile/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $('#modal-content').html(response);
                    $('#profile_info').modal('show');
                },
                error: function() {
                    Swal.fire('Gagal', 'Gagal memuat data.', 'error');
                }
            });
        });
    </script>
@endsection
