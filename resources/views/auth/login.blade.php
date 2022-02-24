@extends('layouts.fullLayoutMaster')
{{-- title --}}

@section('title','Login')

{{-- page scripts --}}

@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- login page start -->
<section id="auth-login" class="row flexbox-container">
  <div class="col-xl-8 col-11">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-login -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
            
            <div class="row">
              <div class="col-12 d-md-block d-none text-center align-self-center p-2">
                <img src="{{asset("images/logo/logo_green.png")}}" class="img-fluid" alt="">
              </div>
            </div>

            <div class="row">
              <div class="col-12 text-center">
                <h4 class="text-bold-600 text-muted">SISTEMA DE CONTROLE DE ESTOQUE</h4>
              </div>
            </div>
           
            <div class="card-body">
              {{-- form  --}}
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-50">
                  <label class="text-bold-600" for="email">E-mail cadastrado</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus placeholder="Informe o e-mail cadastrado">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="text-bold-600" for="password">Senha</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password" placeholder="Digite a senha">
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                  <div class="text-left">
                    <div class="checkbox checkbox-sm">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label" for="remember">
                        <small>Permanecer logado</small>
                      </label>
                    </div>
                  </div>
                  <div class="text-right">
                    <a href="{{ route('password.request') }}" class="card-link"><small>Esqueceu sua senha?</small></a>
                  </div>
                </div>
                <button type="submit" class="btn btn-secondary glow w-100 position-relative">
                  Entrar
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>
              <hr>
              <div class="text-center">
                <small class="mr-25">Não tem uma conta?</small>
                <a href="#" data-toggle="modal" data-target="#default"><small>Solicite cadastro</small></a>
              </div>
            </div>

            <div class="row">
              <div class="col-12 text-center">
                <span class="text-muted"><small>Desenvolvido com ☕ e 🍺 em São Luís (MA)</small></span>
              </div>
            </div>

          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-0">
          <img class="img-fluid" src="{{asset('images/login-magnolia.png')}}" alt="Grupo Magnólia" width="100%">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- login page ends -->
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
@endsection
