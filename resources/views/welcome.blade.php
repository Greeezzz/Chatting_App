<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 3px solid #6b7280;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-gray-800 rounded-2xl p-8 shadow-2xl transition-transform transform hover:scale-105 w-full max-w-md border border-gray-700">
            <h1 class="text-4xl font-bold text-center text-white mb-6">Welcome</h1>
            
            <div class="flex justify-center space-x-4 mb-8">
                <a href="{{ route('login') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300">Login</a>
                <a href="{{ route('register') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300">Register</a>
            </div>

            <div class="flex flex-col items-center text-center">
                <div class="avatar mb-4">
                    <img src="https://i.pinimg.com/474x/70/18/c0/7018c0e8825584d52f3b4bf1d3ab1e0d.jpg" alt="Chelo">
                </div>
                <h2 class="text-2xl font-bold text-white">Chelo Arung Samudro</h2>
                <p class="text-gray-400">WhatsApp: 083875095310</p>
                <p class="text-gray-400">Class: XI A</p>
                <p class="text-gray-400">TikTok: @reezzznt</p>
            </div>
        </div>
    </div>
</body>
</html>
