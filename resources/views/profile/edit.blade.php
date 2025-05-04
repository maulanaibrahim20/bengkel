<form action="{{ url('/super-admin/profile/update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="profile-img-wrap edit-img text-center mb-4">
        <img class="rounded-circle"
            src="{{ $user->profile_image ? asset($user->profile_image) : url('/assets/img/profiles/avatar-01.jpg') }}"
            alt="user" width="120">
        <div class="fileupload btn btn-sm btn-primary mt-2">
            <span><i class="fa fa-upload me-1"></i> Change Photo</span>
            <input class="upload" type="file" name="profile_image">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Birth Date</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                <input class="form-control" type="date" name="birth_date" value="{{ $user->birth_date }}">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Gender</label>
            <select class="form-select" name="gender">
                <option value="">-- Select Gender --</option>
                <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Laki-Laki
                </option>
                <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Perempuan
                </option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Phone Number</label>
            <div class="input-group">
                <span class="input-group-text">(+62)</span>
                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
            </div>
        </div>
        {{-- <div class="col-md-12 mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
        </div> --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="3">{{ $user->address }}</textarea>
        </div>
    </div>

    <div class="submit-section text-end mt-4">
        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
