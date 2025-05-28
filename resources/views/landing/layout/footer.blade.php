@php
    use App\Models\Config;
    use App\Models\Service;
@endphp
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                @php
                    $address = Config::where('key', 'contact_address')->first();
                    $workingHours = Config::where('key', 'contact_open_hours')->first();

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
                <h4 class="text-light mb-4">Address</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $address->value }}</p>
                <p class="mb-2">
                    <i class="fa fa-phone-alt me-3"></i>
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $messageTemplate }}"
                        class="text-light text-decoration-none" target="_blank">
                        {{ $phone->value }}
                    </a>
                </p>
                @php
                    $email = Config::where('key', 'contact_email')->first();
                @endphp
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ $email->value }}</p>
                {{-- <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div> --}}
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Opening Hours</h4>
                @php
                    $workingHours = Config::where('key', 'contact_open_hours')->first();
                    $openHoursParts = explode(':', $workingHours->value, 2);

                    $days = trim($openHoursParts[0]);
                    $hours = trim($openHoursParts[1]);
                @endphp
                <h6 class="text-light">{{ $days }}:</h6>
                <p class="mb-4">{{ $hours }}</p>
                <h6 class="text-light">Minggu:</h6>
                <p class="mb-0">Istirahat BOSS</p>
            </div>
            <div class="col-lg-3 col-md-6">
                @php
                    $service = Service::orderByDesc('id')->get();
                @endphp
                <h4 class="text-light mb-4">Services</h4>
                @foreach ($service as $s)
                    @auth
                        <a class="btn btn-link" href="#">{{ $s->name }}</a>
                    @else
                        <a class="btn btn-link" href="{{ route('login') }}">{{ $s->name }}</a>
                    @endauth
                @endforeach

            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-light mb-4">Promo Bulan Ini</h4>
                <ul class="list-unstyled text-light">
                    <li><i class="fa fa-check text-primary me-2"></i> Gratis cuci motor setiap servis lengkap</li>
                    <li><i class="fa fa-check text-primary me-2"></i> Diskon 10% untuk ganti oli</li>
                </ul>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="https://freewebsitecode.com">{{ config('app.name') }}</a>, All
                    Right
                    Reserved.
                    Designed By <a class="border-bottom" href="#">DL Services IT</a>
                </div>
                {{-- <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="">Home</a>
                        <a href="">Cookies</a>
                        <a href="">Help</a>
                        <a href="">FQAs</a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>