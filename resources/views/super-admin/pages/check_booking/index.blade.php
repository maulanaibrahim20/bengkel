@extends('index')
@section('content')
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0 fs-5">Detail Servis</h3>
            </div>

            <div class="card-body">
                <div class="booking-info mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <span class="text-muted d-block">Booking Code:</span>
                                <strong>{{ $booking->booking_code }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <span class="text-muted d-block">Motor Type:</span>
                                <strong>{{ $motorcycle->type }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded bg-light">
                                <span class="text-muted d-block">Plate Number:</span>
                                <strong>{{ $motorcycle->plate }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ url('check-booking', ['booking_code' => $booking->booking_code]) }}" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Before Service Section -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 fs-6">Before Service</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="year_of_manufacture" class="form-label">Year of Manufacture</label>
                                        <input type="number" class="form-control" id="year_of_manufacture"
                                            name="year_of_manufacture"
                                            value="{{ old('year_of_manufacture', $motorDetails->year_of_manufacture ?? '') }}"
                                            required>
                                        <div class="invalid-feedback">Please provide the year of manufacture.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kilometer_before" class="form-label">Kilometer Reading</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="kilometer_before"
                                                name="kilometer_before"
                                                value="{{ old('kilometer_before', $motorDetails->kilometer_before ?? '') }}"
                                                required>
                                            <span class="input-group-text">km</span>
                                            <div class="invalid-feedback">Please provide kilometer reading before service.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="oil_before" class="form-label">Oil Condition</label>
                                        <select class="form-select" id="oil_before" name="oil_before" required>
                                            <option value="" disabled
                                                {{ old('oil_before', $motorDetails->oil_before ?? '') == '' ? 'selected' : '' }}>
                                                Select condition</option>
                                            <option value="Good"
                                                {{ old('oil_before', $motorDetails->oil_before ?? '') == 'Good' ? 'selected' : '' }}>
                                                Good</option>
                                            <option value="Fair"
                                                {{ old('oil_before', $motorDetails->oil_before ?? '') == 'Fair' ? 'selected' : '' }}>
                                                Fair</option>
                                            <option value="Poor"
                                                {{ old('oil_before', $motorDetails->oil_before ?? '') == 'Poor' ? 'selected' : '' }}>
                                                Poor</option>
                                            <option value="Critical"
                                                {{ old('oil_before', $motorDetails->oil_before ?? '') == 'Critical' ? 'selected' : '' }}>
                                                Critical</option>
                                        </select>
                                        <div class="invalid-feedback">Please select oil condition before service.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- After Service Section -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 fs-6">After Service</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="kilometer_after" class="form-label">Kilometer Reading</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="kilometer_after"
                                                name="kilometer_after"
                                                value="{{ old('kilometer_after', $motorDetails->kilometer_after ?? '') }}"
                                                required>
                                            <span class="input-group-text">km</span>
                                            <div class="invalid-feedback">Please provide kilometer reading after service.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="oil_after" class="form-label">Oil Condition</label>
                                        <select class="form-select" id="oil_after" name="oil_after" required>
                                            <option value="" disabled
                                                {{ old('oil_after', $motorDetails->oil_after ?? '') == '' ? 'selected' : '' }}>
                                                Select condition</option>
                                            <option value="New"
                                                {{ old('oil_after', $motorDetails->oil_after ?? '') == 'New' ? 'selected' : '' }}>
                                                New</option>
                                            <option value="Good"
                                                {{ old('oil_after', $motorDetails->oil_after ?? '') == 'Good' ? 'selected' : '' }}>
                                                Good</option>
                                            <option value="No Change"
                                                {{ old('oil_after', $motorDetails->oil_after ?? '') == 'No Change' ? 'selected' : '' }}>
                                                No Change</option>
                                        </select>
                                        <div class="invalid-feedback">Please select oil condition after service.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Confirm Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function() {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection
