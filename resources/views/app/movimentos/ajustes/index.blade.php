@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Ajustes')

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
        <h4 class="card-title">Controle de Ajustes de Estoque</h4>
      </div>
      <div class="card-body">
        <p class="mb-2">
          Aqui são geridos todos os <code>ajustes</code> nos saldos dos estoques. Lembre-se de, sempre que possível, detalhar o <strong>motivo</strong> do ajuste.
        </p>
        <div class="row match-height">
          <div class="col-12">
              @livewire('movimento.ajuste-component')
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
