<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
        @if (!session('new_register'))
            <title>Selamat Datang {{ auth()->user()->name }}</title>
        @endif
        <title>Update Profile</title>
    @else
        <title>Buat Akun</title>
    @endauth
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .bg-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .overlay {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8));
            position: fixed;
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

        /* Logo styling */
        .logo-large {
            max-width: 70%;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
        }

        /* Greeting card styling */
        .greeting-card {
            animation: fadeIn 1s ease-in-out;
        }

        .greeting-name {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .greeting-message {
            font-size: 1.6rem;
            line-height: 1.4;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        /* Message card styling */
        .message-card {
            max-width: 500px;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.7s ease-out;
            line-height: 1.6;
        }

        .tagline {
            font-size: 1.1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Button styling */
        .btn-custom {
            background-color: #d81324;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(216, 19, 36, 0.4);
            transition: all 0.3s ease;
            border: none;
            animation: pulse 2s infinite;
        }

        .btn-custom:hover {
            background-color: #c01020;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(216, 19, 36, 0.5);
        }

        .text-custom-yellow {
            color: #ffc107 !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .btn-skip {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 3;
            color: white;
            text-decoration: none;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .btn-skip:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(216, 19, 36, 0.6);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(216, 19, 36, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(216, 19, 36, 0);
            }
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .logo-large {
                max-width: 85%;
            }

            .greeting-message {
                font-size: 1.4rem;
            }

            .message-card {
                padding: 20px 15px;
                margin-left: 10px;
                margin-right: 10px;
            }
        }

        @media (max-width: 576px) {
            .logo-large {
                max-width: 75%;
            }

            .greeting-message {
                font-size: 1.2rem;
            }

            .btn-custom {
                width: 90%;
                max-width: 280px;
            }

            .greeting-name {
                font-size: 1.2rem;
            }
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
    @include('components.alert')
</body>

</html>
