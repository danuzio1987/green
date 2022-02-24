@component('mail::message')
# 🎁 Surpresaaaa!!!!

Fala comigo <strong>{{$user_name}}</strong>!!

Você recebeu este convite para ter acesso à plataforma de controle de estoque da <strong>GREEN Combustíveis</strong>. 🥳

Vê se não fica só no <strong>cheirinho</strong> e clica no botão abaixo para se cadastrar. 💚🐽

@component('mail::button', ['url' => route('register') ])
Cadastrar Agora
@endcomponent

Saudações alviverdes!,<br>
{{ config('app.name') }}
@endcomponent
