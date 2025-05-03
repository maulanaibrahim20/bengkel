@extends('components.index-with-bg')
@section('content')
    <div class="container h-100 d-flex justify-content-center align-items-center content">
        <div class="form-card">
            <div class="form-title">Lengkapi Data Diri Anda</div>

            <form action="{{ url('/user/update/profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="firstName" class="form-label">Nama Depan</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" value="{{ $firstName }}"
                        placeholder="Nama Depan">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Nama Belakang</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" value="{{ $lastName }}"
                        placeholder="Nama Belakang">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}"
                        disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <div class="input-group">
                        <select class="form-select" style="max-width: 100px;" disabled>
                            <option selected>+62</option>
                        </select>
                        <input type="text" class="form-control" name="phone" placeholder="821xxxxxxx">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="laki" value="Laki-laki">
                        <label class="form-check-label" for="laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="perempuan" value="Perempuan">
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <select class="form-select" id="provinsi" name="provinsi">
                        <option selected disabled>Pilih Provinsi</option>
                        @foreach ($wilayah as $provinsi)
                            <option value="{{ $provinsi['id'] }}">{{ ucwords(strtolower($provinsi['name'])) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-yellow w-100">Selesaikan Pendaftaran</button>
            </form>
        </div>
    </div>
@endsection
