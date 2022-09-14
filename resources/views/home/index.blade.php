@extends('layouts.app')
@section('content')

<?php

use GrahamCampbell\ResultType\Success;

$sum = 0; 
$sum_24h=0; $sum_7d=0; $sum_30d=0;
$percent_24h=0; $percent_7d=0; $percent_30d=0;
$percentSum_24h=0; $percentSum_7d=0; $percentSum_30d=0;
$time = '24h';


//Get Input from Time option 'buttons'
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['time'])) {
            $time = $_GET['time'];
        }
    }
?>

    <!-- LOADING ANIMATION -->
    <div id="loading" class="center">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
<!-- TICKER -->
<div class="ticker-wrap">
    <div class="ticker">
        @foreach($assets as $asset)
        @foreach($asset->prices as $price)
        <?php
        // Ticker Prices
        $tickerPrice = $price->price;
        $tickerPrice =number_format((float)$tickerPrice, 2, '.', ' ');
        //Ticker Percentage 
        $tickerPercent24h = ($price->price - $price->price_24h) / $price->price * 100;
        $tickerPercent24h=number_format((float)$tickerPercent24h, 2, '.', '');
        $tickerColor = "#FFFFFF";
            if (($tickerPercent24h < 0))
            $tickerColor = "#FF0000";
            else if (($tickerPercent24h > 0) )
            $tickerColor = "#00FF00";
        ?>
        <div class="ticker__item">{{$asset->name .' ' . '$' . $tickerPrice}}
            <span class="percent-home" style='color: <?php echo  $tickerColor;  ?>'>{{$tickerPercent24h . ' %'}}</span>
        </div>
        @endforeach
        @endforeach
    </div>
</div>
<!-- DIAGRAM -->
<div class="container pb-4">
    <div class="row">
        <div class="col-lg-6 m-auto">
        <canvas id="pie-chart" style='display: none;'></canvas>
        </div>
    </div>
</div>
<!-- DASHBOARD & NEWS -->
@if( session('success') )
    <div class="alert alert-success success-added mt-3 mx-auto" role="alert">
        {{ session('success') }}
    </div>
    @endif
<div class="container">
    <div class="row ">
        <div class="col-lg-8 pb-3">
            <div class="card">
                <div class="card-header card-header-flexbox">
                    <h1>{{ __('Dashboard') }}</h1> 
                    
                    <!-- select time-options -->
                    <form action="" method="GET" class="card-header-time">
                        <input type="submit" value="24h" name="time" class="btn btn-outline-secondary btn-time"
                        <?php if($time == "24h"){echo 'id="active"';}  ?>/>
                        <input type="submit" value="7d" name="time" class="btn btn-outline-secondary btn-time"
                        <?php if($time == "7d"){echo 'id="active"';}  ?>/>
                        <input type="submit" value="30d" name="time"  class="btn btn-outline-secondary btn-time"
                        <?php if($time == "30d"){echo 'id="active"';}  ?>/>
                    </form>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <!-- Home Dashboard -->
                    <section id="home-wallet">
                        @foreach($userAssets as $userAsset)
                        @foreach($userAsset->prices as $price)
                        <?php 
                            // ----Asset Price Now---
                            $assetPrice= $price->price * $userAsset->pivot->amount;
                            $assetPrice=number_format((float)$assetPrice, 2, '.', ' ');
                            // <!-- Total Sum -->
                            $sum+= $price->price * $userAsset->pivot->amount; 
                            $sum_24h+= $price->price_24h * $userAsset->pivot->amount;
                            $sum_7d+= $price->price_7d * $userAsset->pivot->amount;
                            $sum_30d+= $price->price_30d * $userAsset->pivot->amount;   
                            // <!-- Percentage Asset -->
                            if ($userAsset->pivot->amount != 0) {
                                $percentAsset_24h= ($price->price * $userAsset->pivot->amount 
                                - $price->price_24h * $userAsset->pivot->amount) 
                                / ($price->price * $userAsset->pivot->amount) * 100 . ' % ';

                                $percentAsset_7d= ($price->price * $userAsset->pivot->amount 
                                - $price->price_7d * $userAsset->pivot->amount) 
                                / ($price->price * $userAsset->pivot->amount) * 100 . ' % ';

                                $percentAsset_30d= ($price->price * $userAsset->pivot->amount 
                                - $price->price_30d * $userAsset->pivot->amount) 
                                / ($price->price * $userAsset->pivot->amount) * 100 . ' % ';
                            }
                            $percentAsset_24h=number_format((float)$percentAsset_24h, 2, '.', '');
                            $percentAsset_7d=number_format((float)$percentAsset_7d, 2, '.', '');
                            $percentAsset_30d=number_format((float)$percentAsset_30d, 2, '.', '');
                            //CHARTDATA ARRAYS
                            $chartValues[]=$price->price * $userAsset->pivot->amount;
                            $chartLabels[] = $userAsset->symbol;
                            $chartIds[] = $userAsset->id;
                                
                                
                        ?>
                        @endforeach
                        <?php 
                        // <!-- Percentage color Assets-->
                                $colorAsset = "#FFFFFF";
                                if ((${'percentAsset_' . $time} < 0))
                                $colorAsset = "#FF0000";
                                else if ((${'percentAsset_' . $time} > 0) )
                                $colorAsset = "#00FF00";
                                
                            ?>
                        <!-- Dashboard -->
                        <a href="{{ route('home.show',$userAsset->id) }}" class="text-decoration-none">
                            <div class="home-grid mb-3">
                                <div class="grid-item">{{$userAsset->name}}</div>
                                <div class="grid-item">{{$userAsset->symbol .' '. $userAsset->pivot->amount}}</div>
                                <div class="grid-item">{{'$' . $assetPrice . ' '}}
                                    <span class="percent-home"
                                        style='color: <?php echo  $colorAsset;  ?>'>{{${'percentAsset_'. $time} .  '%'}}</span></div>
                            </div>
                        </a> 
                        
                        @endforeach
                        <!--  total -->
                        <?php 
                        if ($sum != 0) {
                            $percentSum_24h= ($sum-$sum_24h) / $sum * 100;
                            $percentSum_7d= ($sum-$sum_7d) / $sum * 100;
                            $percentSum_30d= ($sum-$sum_30d) / $sum * 100;
                        }
                        $percentSum_24h=number_format((float)$percentSum_24h, 2, '.', '');
                        $percentSum_7d=number_format((float)$percentSum_7d, 2, '.', '');
                        $percentSum_30d=number_format((float)$percentSum_30d, 2, '.', '');
                        $sum=number_format((float)$sum, 2, '.', ' ');

                        //--- percentage color
                        $colorTotal = "#000000";
                        if ((${'percentSum_' . $time}< 0))
                        $colorTotal = "#FF0000";
                        else if ((${'percentSum_' . $time} > 0) )
                        $colorTotal = "#00FF00";
                        
                        ?>
                        <div class="total-home text-center mt-4"> {{'$'. $sum}} <span class="percent-home"
                                style='color: <?php echo  $colorTotal;  ?>'>{{${'percentSum_' . $time} . ' %'}}</span>
                        </div>
                    </section>
                </div>
            </div>
            <a href="{{ route('home.create')}}" class="btn btn-outline-secondary my-3">Add Asset</a>
            
        </div>

        <!-- NEWS-->
        <section class="col-lg-4" id="news">
            <div class="card">
                <div class="card-header"><h2>{{ __('News') }}</h2></div>
                <div class="card-body">
                    @foreach ($allNews as $news)
                    <div class="news-item">
                        <h4>{{$news->title}}</h4>
                        <img class="news-image" src="{{$news->image_url}}" alt="related image to article">
                        <p>{{$news->description}}</p>
                        <p class="source">Source: <a href="{{$news->url}}">{{$news->source}}</a></p>
                        
                    </div>
                    @endforeach

                </div>
                {{ $allNews->links('pagination::bootstrap-5') }}
        </section>
    </div>

    <!-- Delete Msg  -->
    <?php
    if (session()->has('success')) {
        session()->forget('success'); 
    }
    ?>

    <!-- Php Arrays to JS -> PIE-CHARTDATA -->
    <script type="text/javascript"> 
    
    var chartIds = [
    <?php if (isset($chartIds)) { 
        echo json_encode($chartIds, true); }
    ?>];
    var chartValues = [
    <?php if (isset($chartValues)) { 
        echo json_encode($chartValues, true); }
    ?>];
    
    var chartLabels = [
    <?php if (isset($chartLabels)) { 
        echo json_encode($chartLabels, true); } 
    ?>];

// <!-- Loading Page Animation -->
    $(window).on('load', function () {
        setInterval(function() {
            $('#loading').hide();
            // $("#loading").fadeOut("slow")
        }, 1000);
    }) 
</script>
    
</div>
<script src="{{ asset('chart.js/chart.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="{{ asset('js/home.js') }}" defer></script>
@endsection
