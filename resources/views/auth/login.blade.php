@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="text-center mt-5">Login</h3>
                <form method="POST" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail Address</label>
                        <input id="email"
                               type="email"
                               class="form-control @error('error') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}"
                               autocomplete="email"
                               autofocus
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password"
                               type="password"
                               class="form-control @error('error') is-invalid @enderror"
                               name="password"
                               autocomplete="current-password"
                               required>
                        @error('error')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
