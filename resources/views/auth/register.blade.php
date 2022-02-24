@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','Cadastro')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- register section starts -->
<section class="row flexbox-container">
  <div class="col-xl-8 col-10">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- register section left -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            <div class="row">
              <div class="col-12 text-center">
                <img src="{{asset('images/logo/logo_green.png')}}" alt="">
              </div>
            </div>
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="text-center mb-2 text-bold-600">Novo Cadastro</h4>
              </div>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row my-75">
                  <div class="col-6 form-group mb-50">
                    <label class="text-bold-600" for="first_name">Nome</label>
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"  autocomplete="off" autofocus placeholder="Primeiro Nome">
                    @error('first_name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-6 form-group mb-50">
                    <label class="text-bold-600" for="last_name">Sobrenome</label>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="off" autofocus placeholder="Último Nome">
                    @error('last_name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="row my-75">
                  <div class="col-12 form-group mb-50">
                    <label class="text-bold-600" for="email">E-mail</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="off" placeholder="Cadastre um e-mail válido">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="row my-75">
                  <div class="col-6 form-group mb-2">
                    <label class="text-bold-600" for="password">Sua senha</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" placeholder="Escolha uma senha">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="col-6 form-group mb-2">
                    <label class="text-bold-600" for="password-confirm">Confirmação da Senha</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password" placeholder="Confirme a senha">
                  </div>
                </div>
                <button type="submit" class="btn btn-secondary glow position-relative w-100">
                  CADASTRAR
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>
              <hr>
              <div class="text-center"><small class="mr-25">Já possui uma conta?</small>
                <a href="{{asset('login')}}"><small>Entre Aqui</small> </a>
              </div>
              
            </div>
            <div class="row">
              <div class="col-12 text-center">
                <span class="text-muted"><small>Desenvolvido com ☕ e 🍺 em São Luís (MA)</small></span>
              </div>
            </div>
          </div>
        </div>
        <!-- image section right -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-0">
            <img class="img-fluid" src="{{asset('images/login-magnolia.png')}}" alt="branding logo" width="100%">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- register section endss -->
@endsection
