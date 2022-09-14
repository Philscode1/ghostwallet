@extends('layouts.app')

@section('content')
    
        <div class="container px-3 welcome-box">
            <h1 class="welcome-h1">Ghost Wallet</h1>
            <div class="row align-items-end h-100">
                <div class="col col-md-6 mb-3 ">
                    
                    <p class="welcome-p my-3">One portfolio app to watch all your investments </p>
                    <p class="welcome-p2 pt-4">Keep track of all your different assets:</p>
                    <ul class="welcome-ul mb-3"> 
                        <li>Stocks</li>
                        <li>Crypto</li>
                        <li>Metals</li>
                        <li>Etfs & Funds</li>
                    </ul>
                    <div class="text-center mt-5">
                        @guest
                            <a class="btn btn-welcome mx-3 mb-2" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                            <a class="btn btn-welcome mx-3 mb-2" href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                        @else
                            <a class="btn btn-welcome" href="{{ route('home.index') }}">{{ __('Home') }}</a>
                        @endguest
                    </div>
                    <p class="welcome-p3 mt-5">
                    Stay up to date and watch the growth of your investments! <br> <br> 
                    Create your virtual portfolio and add your assets. <br>
                    Keep track of all your stocks, cryptocurrencys, bonds and more!<br><br>
                    No connection to your wallet, exchange or broker required.<br><br>
                    Ghost Wallet a multi asset portfolio tracking app. <br><br>
                    100% Free
                    </p>
                </div>
            </div>
        </div>
<script>
    let element = document.getElementById('main');
    element.classList.add('main-welcome');

</script>
@endsection    
