@php
$pageConfigs = ['bodyCustomClass' => 'bg-full-screen-image'];
@endphp

@extends('layouts.fullLayoutMaster')

@section('title','Confirme seu e-mail')

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center flexbox-container">
    <div class="col-md-8">
      <div class="card">

        <div class="row p-2">
          <div class="col-12 text-center">
            <img src="{{asset('images/logo/logo_green.png')}}" alt="">
          </div>
        </div>

        <div class="card-header">
          <h4 class="text-bold-600">
            Confirme seu endereço de e-mail.
          </h4>
        </div>

        <div class="card-body">
          @if (session('resent'))
            <div class="alert alert-success" role="alert">
              Um link de verificação foi enviado para seu e-mail.
            </div>
          @endif

          Antes de seguir, enviamos uma mensagem para confirmar seu e-mail. Caso não tenha recebido o e-mail,
          <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">clique aqui para solicitar outro</button>.
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
