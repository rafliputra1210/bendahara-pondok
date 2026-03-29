@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Buat Password Baru</h2>

  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ $email ?? old('email') }}" required>
      @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>Password</label>
      <input type="password" name="password" required>
      @error('password') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Reset Password</button>
  </form>
</div>
@endsection
