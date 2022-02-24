@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Pedidos')

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
        <h4 class="card-title">Gestão de Pedidos</h4>
      </div>
      <div class="card-body">
        <p class="mb-2">
          <code>Pedidos</code> são solicitações de insumos aos Fornecedores. Esta é a forma principal de <strong>entrada de insumos</strong> nos armazéns.
        </p>
        <div class="row match-height">
          <div class="col-12">
              @livewire('pedidos.pedido-component')
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
