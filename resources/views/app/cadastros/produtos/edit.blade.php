@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Editar Produto')

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
    <div class="col-12">

      <div class="card bg-transparent shadow-none border">
          
          <div class="card-body">
            <h4 class="mb-2 text-bold-600">
              FORMULÁRIO DE EDIÇÃO DE PRODUTO
              <span class="badge badge-info ml-1" >{{$produto->name}}</span>
            </h4>
            

            @livewire('cadastros.produtos.produto-edit', ['produto' => $produto])

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
