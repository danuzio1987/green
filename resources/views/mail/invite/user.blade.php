@component('mail::message')
# Fala comigo {{$user->first_name}} {{$user->last_name}}!!

Você acaba de ser convidado(a) para ter acesso à plataforma de controle de estoque da <strong>GREEN</strong> Combustíveis.

@component('mail::button', ['url' => $url])
Aceitar Convite
@endcomponent

Esta plataforma inaugura uma nova forma de controlar estoque: de forma totalmente intuitiva e integrada, trazendo mais segurança e dinamismo para a rotina da <strong>GREEN</strong>.

Você tem um papel fundamental nesse processo! 🎖️

Nos vemos lá!<br>
{{ config('app.name') }}🐽💚
@endcomponent
