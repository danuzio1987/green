@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} <strong><a href="https://www.instagram.com.br/danuzioferreira" target="_blank" rel="danuzio">Danúzio Ferreira</a></strong>. Todos os direitos reservados. <br>
<span>Desenvolvido com ☕ e 🍺 em São Luís (MA)</span>
@endcomponent
@endslot
@endcomponent
