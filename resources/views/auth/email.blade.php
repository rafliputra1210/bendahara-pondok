@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Reset Password</h2>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div>
      <label>Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required>
      @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit">Kirim Link Reset</button>
  </form>
</div>
@endsection
