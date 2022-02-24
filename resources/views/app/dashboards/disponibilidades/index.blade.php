@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Disponibilidades')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/danuzio/tabela-danuzio.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/plugins/extensions/swiper.css')}}">
<style>
.hiddenRow {
    padding: 0 !important;
}
</style>
@endsection

@section('content')
    @livewire('dashboard.disponibilidades.disp-component')
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
@endsection

@section('page-scripts')
<script src="{{asset('js/scripts/pages/dashboard-analytics.js')}}"></script>
{{--
<script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script>
--}}
<script src="{{asset('js/danuzio/dashboard/armazem.js')}}"></script>
@endsection
