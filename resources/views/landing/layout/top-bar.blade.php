@php
    use App\Models\Config;
@endphp

<div class="container-fluid bg-light p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                @php
                    $address = Config::where('key', 'contact_address')->first();
                @endphp
                <small>{{ $address->value }}</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center py-3">
                <small class="far fa-clock text-primary me-2"></small>
                @php
                    $workingHours = Config::where('key', 'contact_open_hours')->first();
                @endphp
                <small>{{$workingHours->value}}</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            @php
                $phone = Config::where('key', 'contact_phone')->first();
                $rawNumber = $phone->value;

                $onlyNumbers = preg_replace('/\D/', '', $rawNumber);

                if (substr($onlyNumbers, 0, 1) === '0') {
                    $whatsappNumber = '62' . substr($onlyNumbers, 1);
                } else {
                    $whatsappNumber = $onlyNumbers;
                }

                $messageTemplate = urlencode("Halo, saya ingin menanyakan ketersediaan barang di bengkel Anda. Apakah saat ini masih tersedia?");
            @endphp

            <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $messageTemplate }}" target="_blank"
                    class="text-decoration-none d-inline-flex align-items-center">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>{{ $phone->value }}</small>
                </a>
            </div>

            {{-- <div class="h-100 d-inline-flex align-items-center">
                <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-sm-square bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
            </div> --}}
        </div>
    </div>
</div>