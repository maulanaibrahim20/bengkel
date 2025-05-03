<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
        <title>Update Profile</title>
    @else
        <title>Buat Akun</title>
    @endauth
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
        }

        .form-card {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }

        .form-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .btn-yellow {
            background-color: #d81324;
            ;
            border: none;
            color: white;
            font-weight: 600;
        }

        .btn-yellow:hover {
            background-color: #d81324;
            ;
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
    @auth
        <img src="{{ url('/img/background1.jpg') }}" alt="Background" class="bg-img">
        @if (!session('new_register'))
            <a href="{{ url('/user/dashboard') }}" class="btn-skip">Skip</a>
        @endif
    @else
        <img src="{{ url('/img/background.jpg') }}" alt="Background" class="bg-img">
    @endauth
    <div class="overlay"></div>


    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
