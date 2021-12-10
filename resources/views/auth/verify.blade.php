@extends('layouts.app')

@section('content')

<div class="vh-100 d-flex justify-content-center align-items-center">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h1>{{ __('Verify Your Email Address') }}</h1>
      </div>
      <div class="card-body">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        {{ __('Before proceeding, please check your email for a verification link.') }}<br>
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
      </div>
      <!-- /.login-card-body -->
</div>
@endsection
