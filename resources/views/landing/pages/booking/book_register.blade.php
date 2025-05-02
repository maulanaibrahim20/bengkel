<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .bg-cover {
            background-image: url('{{ url('/img/background.jpg') }}');
            /* Ganti dengan gambar kamu */
            background-size: cover;
            background-position: center;
            position: relative;
            height: 100vh;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            /* efek gelap transparan */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        .btn-yellow {
            background-color: #d81324;
            color: #000;
            font-weight: 600;
        }

        .btn-skip {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 3;
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="bg-cover">
        <div class="overlay"></div>
        <a href="{{ url('/') }}" class="btn-skip">Skip</a>
        <div class="container h-100 d-flex justify-content-center align-items-center content">
            <div class="text-center text-white">
                <h2 class="fw-bold">Buat akun dengan dua langkah mudah</h2>
                <p class="mb-4">Untuk menggunakan layanan kami, kita harus terhubung terlebih dahulu</p>
                <a href="{{ url('/register') }}" class="btn btn-yellow px-4 py-2 rounded-pill">OK, Buat akun saya
                    sekarang</a>
            </div>
        </div>
    </div>
</body>

</html>
