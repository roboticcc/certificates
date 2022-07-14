<?php

use App\Models\Certificate;

/** @var $active_certificates Certificate used to loop through active certificate and create somewhat listview of activated certs*/

?>

    
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Certificates</title>
    @vite(['resources/js/app.js'])
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1 class="my-md-5 my-3 d-flex justify-content-center">Tree Certificates Are Sold Here</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Activated Certificates</h3>
            <div class="col-md-4">
                <form action="/activate" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name='activation_key' type="text" class="form-control" placeholder="Activation Key" aria-describedby="button-addon">
                        <button class="btn btn-primary" type="submit" id="activation-key">Activate</button>
                    </div>
                </form>
            </div>
            @foreach($active_certificates->reverse() as $certificate)
            <ul class="list-group mb-4">
                <li class="list-group-item list-group-item-action d-flex justify-content-between">
                    CERTIFICATE #{{$certificate->id}} <br><br>
                    For: {{$certificate->buyer_name}} {{$certificate->buyer_surname}}<br>
                    Tree: {{$certificate->tree}}<br>
                    Cost: {{$certificate->cost}}<br>
                    Date: {{$certificate->updated_at}}
                </li>
            </ul>
            @endforeach
            {{$active_certificates->links()}}
        </div>
        <div class="col-md-6">
            <h3>Buy a Tree</h3>
            <div class="d-inline-block" style="margin-bottom: 20px;">Current balance: {{$current_balance}} EUR</div>
            <div class="col-lg-8 col-md-8">
                <form action="/order" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input name="buyer_name" type="text" class="form-control" placeholder="Specify your name" id="floatingName" required oninvalid="this.setCustomValidity('Please, fill out your name')">
                        <label for="floatingName">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="buyer_surname" type="text" class="form-control" placeholder="Specify your surname" id="floatingSurname" required oninvalid="this.setCustomValidity('Please, fill out your surname')">
                        <label for="floatingSurname">Surname</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="buyer_email" type="email" class="form-control" placeholder="Specify your email" id="floatingEmail" required oninvalid="this.setCustomValidity('Please, fill out your email')">
                        <label for="floatingEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="tree" type="text" class="form-control" placeholder="Specify your email" id="floatingTree" required oninvalid="this.setCustomValidity('Please, specify the desired tree')">
                        <label for="floatingTree">Tree</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="amount" class="form-select" id="floatingSelectAmount" name="trees_amount" required oninvalid="this.setCustomValidity('Please, choose the amount of trees')">
                            <option selected="">Choose the amount of trees</option>
                            @for($i = 1; $i <= 20; $i++)
                                {
                                <option value="{{$i}}">{{$i}}</option>
                                }
                            @endfor
                        </select>
                        <label for="floatingSelectTree">Amount</label>
                    </div>
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label class="col-sm-4 control-label opacity-50">Currency</label>
                        <div class="col-sm-8">
                            <label class="radio-inline currency"> <input type="radio" checked>EUR</label>
                            <label class="radio-inline currency"> <input type="radio" disabled>RUB</label>
                            <label class="radio-inline currency"> <input type="radio" disabled>USD</label>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="col-sm-4 control-label opacity-50">Balance</label>
                        <div class="col-sm-8">
                            <label class="balance"><input type="radio" id="seasonSummer" value="accountBalance" checked>Account balance</label>
                        </div>
                    </div>
                    <div>
                        <p style="font-size: 17px" id="subTotal"> </p>
                    </div>
                    <button class="btn btn-primary" type="submit">Purchase</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
