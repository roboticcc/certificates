@component('mail::message')
Hello, {{$buyer_name. ' ' . $buyer_surname}}!

Here's the details of certificate you've recently purchased:

    Tree: {{$tree}}
    Amount: {{$amount}}
    Cost: {{$cost}} EUR

Use this key to activate your certificate on our website: <b>{{$activation_key}}</b>
@endcomponent
