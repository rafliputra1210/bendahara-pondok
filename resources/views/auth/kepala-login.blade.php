<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login Kepala Madrasah</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="w-full max-w-md bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-2 text-center">Login Kepala Madrasah</h2>
    <p class="text-sm text-gray-600 mb-4 text-center">
      Masuk menggunakan akun dengan role <strong>kepala</strong>.
    </p>

    @if($errors->any())
      <div class="mb-3 text-sm text-red-700 bg-red-100 p-2 rounded">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('kepala.login.attempt') }}">
      @csrf

      <label class="block text-sm mb-1">Email</label>
      <input
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        class="w-full p-2 border rounded mb-3"
      >

      <label class="block text-sm mb-1">Password</label>
      <input
        type="password"
        name="password"
        required
        class="w-full p-2 border rounded mb-3"
      >

      <label class="inline-flex items-center mb-4">
        <input type="checkbox" name="remember" class="mr-2">
        <span class="text-sm">Ingat saya</span>
      </label>

      <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded">
        Masuk sebagai Kepala
      </button>
    </form>

    <p class="mt-4 text-xs text-gray-500 text-center">
      Bukan Kepala Madrasah? Gunakan halaman login Bendahara.
    </p>
  </div>
</body>
</html>
