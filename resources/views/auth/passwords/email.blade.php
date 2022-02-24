@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Recuperar senha')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- forgot password start -->
<section class="row flexbox-container">
  <div class="col-xl-7 col-md-9 col-10  px-0">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-forgot password -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2">
            <div class="card-header pb-1">
              <div class="text-bold-600">
                <h4 class="text-center mb-2">Fala sério... esqueceu a senha?! 🤦</h4>
              </div>
            </div>
            <div class="form-group d-flex justify-content-between align-items-center mb-2">
              <div class="text-left">
                <div class="ml-3 ml-md-2 mr-1">
                  <a href="{{asset('login')}}"  class="card-link btn btn-outline-primary text-nowrap">Login</a>
                </div>
              </div>
              <div class="mr-3">
                <a href="#" data-toggle="modal" data-target="#default" class="card-link btn btn-outline-primary text-nowrap">Cadastrar</a>
              </div>
            </div>
            <div class="card-body">
              <div class="text-muted text-center mb-2">
                <p class="mb-0 pb-0">
                  <small>
                    Insira o e-mail cadastrado para criar uma nova senha.
                  </small>
                </p>
                <p class="pt-0 mt-0">
                  <small class="text-danger">
                    (e vê se não esquece mais! 😬)
                  </small>
                </p>
                
              </div>
              {{-- form --}}
              <form class="mb-2" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group mb-2">
                  <label class="text-bold-600" for="email">E-mail cadastrado</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="E-mail cadastrado">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <button type="submit" class="btn btn-secondary glow position-relative w-100">
                  CRIAR NOVA SENHA
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>

              <div class="text-center mb-2">
                <a href="{{asset('login')}}">
                  <small class="text-muted">Oops.. eu lembrei da minha senha! CLICA AQUI.</small>
                </a>
              </div>
              <div class="row">
                <div class="col-12 text-center pt-5">
                  <span class="text-muted"><small>Desenvolvido com ☕ e 🍺 em São Luís (MA)</small></span>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-0 m-0">
          <img class="img-fluid m-0 p-0" src="{{asset('images/login-magnolia.png')}}" alt="branding logo" width="100%" height="100%">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="myModalLabel1">SOLICITAÇÃO DE ACESSO</h3>
          <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="p-1">
                <h5>Vamos com calma!!!! 😎</h5>
                <p class="user-profile-ellipsis">
                  Acesso de novos usuário ao sistema só é feito mediante convite! <br>
                  Entre em contato com o <strong>Administrador</strong> e solicite seu acesso.
                </p>
            </div>
            </div>
            <div class="col-12">
              <div class="card-header">
                <div class="card-title-details d-flex align-items-center">
                  <div class="avatar bg-rgba-primary p-25 mr-2 ml-0">
                    <img class="img-fluid" src="{{asset('images/avatar/vilarinho.jpg')}}" alt="img placeholder"
                      height="70" width="70">
                  </div>
                  <div>
                    <h5>Rodrigo Vilarinho</h5>
                    <div class="card-subtitle">rvilarinho@grupomagnolia.com.br</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Entendi! 👍</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- forgot password ends -->
@endsection
