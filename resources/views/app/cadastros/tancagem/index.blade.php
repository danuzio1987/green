@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Tancagens')

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
<div class="row match-height">
  <div class="col-xl-12">
    <div class="card bg-transparent shadow-none border">
      <div class="card-header">
        <h4 class="card-title">Gestão de Tancagem</h4>
      </div>
      <div class="card-body">
        <p class="mb-2">
          <code>Tancagem</code> é a capacidade de estocagem de insumo de cada armazém. Estes valores determinarão os limites críticos para gestão dos estoques.
        </p>
        <div class="row match-height">
          <div class="col-12">
              @livewire('cadastros.tancagem.tancagem-component')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/polyfill.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
@endsection
