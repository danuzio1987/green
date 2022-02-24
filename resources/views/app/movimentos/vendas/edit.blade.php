@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Vendas')

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
        <h4 class="text-bold-600">Editar Venda</h4>
      </div>
      <div class="card-body">
        <p class="mb-2">
          As <code>vendas</code> precisam ser registradas na plataforma para o correto acompanhamento dos saldos dos insumos.
        </p>
        @livewire('movimento.venda-edit', ["venda" => $venda])
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
