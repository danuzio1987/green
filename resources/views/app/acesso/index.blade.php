@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Meu Perfil')

{{-- vendor styles --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
@endsection
{{-- page styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/extensions/toastr.css')}}">
@endsection

@section('content')
<!-- account setting page start -->
<section id="page-account-settings">
<div class="row match-height">
  <div class="col-xl-12">
    <div class="card bg-transparent shadow-none border">
      <div class="card-header">
        <h4 class="card-title">Perfis de Acesso</h4>
      </div>
      <div class="card-body">
        <p class="mb-2">
          Nesta seção estão todas as informações para a gestão completa do seu perfil.
        </p>
        <div class="row match-height">
          <div class="col-12">
            @livewire('acesso.acl-component')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 
</section>
<!-- account setting page ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/polyfill.min.js')}}"></script>
@endsection

@section('page-scripts')
@endsection
