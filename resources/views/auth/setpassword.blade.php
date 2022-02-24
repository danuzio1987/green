@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Definir Senha')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
@endsection

@section('content')
<!-- reset password start -->
<section class="row flexbox-container" style="background: #295872;">
    <div class="col-xl-7 col-10">
        <div class="card bg-authentication mb-0">
            <div class="row m-0">
                <!-- left section-login -->
                <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">
                        <div class="row">
                          <div class="col-12 text-center px-auto mx-auto">
                            <img src="{{asset("images/logo/logo_green.png")}}" class="img-fluid" alt="">
                          </div>
                        </div>
                        <div class="card-header pb-1">
                            <div class="card-title">
                                <h4 class="text-center text-bold-600 mb-2">Defina sua senha de acesso</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="mb-2" action="{{route('setpassword.store')}}" method="post">
                              @csrf
                                <div class="form-group">
                                    <label class="text-bold-600" for="password">Nova Senha</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Escolha uma nova senha">
                                    @error('password')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-bold-600" for="password_confirmation">Confirme a senha</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password" placeholder="Confirme a nova senha">
                                    @error('password_confirmation')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-secondary glow position-relative w-100">
                                  Definir Senha
                                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                                </button>
                            </form>
                            <div class="row">
                              <div class="col-12 text-center">
                                <span class="text-muted"><small>Desenvolvido com ☕ e 🍺 em São Luís (MA)</small></span>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right section image -->
                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                    <img class="img-fluid" src="{{asset('images/pages/reset-password.png')}}"
                        alt="branding logo">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- reset password ends -->
@endsection
