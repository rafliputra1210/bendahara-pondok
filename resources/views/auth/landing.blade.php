<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>SIM Bendahara - Pilih Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center">
  <div class="max-w-xl w-full bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-bold text-center mb-2">Selamat datang di Sistem bendahara Digital</h1>
    <p class="text-center text-gray-600 mb-6">
      Silakan masuk menggunakan akun Anda untuk mengelola data bendahara.:
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <a href="{{ route('login') }}"
         class="block text-center border border-green-500 text-green-600 font-semibold py-3 rounded-xl hover:bg-green-50">
        Login Di sini Admin/ Kepala Bendahara
      </a>

      {{-- <a href="{{ route('kepala.login') }}"
         class="block text-center border border-blue-500 text-blue-600 font-semibold py-3 rounded-xl hover:bg-blue-50">
        Login Kepala Madrasah
      </a> --}}
    </div>

    <p class="mt-6 text-xs text-gray-400 text-center">
      © {{ date('Y') }} SIM Bendahara Pondok
    </p>
  </div>
</body>
</html>
