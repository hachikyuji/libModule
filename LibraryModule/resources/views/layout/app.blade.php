<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class = "antialiased">
<header>
<!-- component -->
<div class="bg-gray-100 flex justify-center items-center h-screen">
    <!-- Left: Image -->
    <div class="w-1/2 h-screen hidden lg:block">
    <img src="{{ asset('images/Plm1.jpg') }}" alt="PLM Image" class="w-full h-full object-cover">

</div>
<!-- Right: Login Form -->
<div class="lg:p-36 md:p-52 sm:20 p-8 w-full lg:w-1/2">
  <h1 class="text-2xl font-semibold mb-4">PLM Library Login</h1>
  <form action="{{ route('login') }}" method="POST">
    @csrf
    <!-- Username Input -->
    <div class="mb-4">
      <label for="username" class="block text-gray-600">Email</label>
      <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" autocomplete="off" required>
    </div>
    <!-- Password Input -->
    <div class="mb-4">
      <label for="password" class="block text-gray-600">Password</label>
      <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-blue-500" autocomplete="off" required>
    </div>
    <!-- Login Button -->
    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md py-2 px-4 w-full">Login</button>
  </form>

  </div>
</div>
</div>

    <div>
        {{ $slot }}
    </div>
</header>
</body>
</html>