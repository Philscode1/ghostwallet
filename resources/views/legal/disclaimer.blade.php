@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center ">
        <div class="col col-md-8">
            @guest
                <a href="{{ route('welcome') }}" class="btn btn-back mb-2">< back</a>
            @else
                <a href="{{ route('home.index') }}" class="btn btn-back mb-2">< back</a>
            @endguest
            <div class="card">
                <div class="card-header">
                    <h3>Disclaimer</h3>
                </div>
                <div class="card-body">
                    <p>This is a hobby project. We do not guarantee the correctness of the asset prices displayed on this website! <br>www.ghostwallet.net only provids informations and doesn't offer any financial or investment advice.<br>The update timeframes change between asset classes as shown below.<br>
                        <strong>Cryptos: </strong>every 10 minutes <br>
                        <strong>Stocks: </strong>every 10 minutes (if exchange is open) <br>
                        <strong>Metals: </strong> every 3 hours (with a 30 min. delay)
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col col-md-8">
            <div class="card">
                <div class="card-header ">
                    <h3>Datasources</h3>
                </div>
                <div class="card-body">
                        <strong>Cryptos: </strong><a href="https://www.coingecko.com/en/api">https://www.coingecko.com/en/api</a>  <br>
                        <strong>Stocks: </strong><a href="https://www.stockdata.org/">https://www.stockdata.org/</a>  <br>
                        <strong>Metals: </strong><a href="https://metalpriceapi.com/">https://metalpriceapi.com/</a> 
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection