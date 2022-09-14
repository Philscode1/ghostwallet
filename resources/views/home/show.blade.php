@extends('layouts.app')
<?php
use Codenixsv\CoinGeckoApi\CoinGeckoClient;

$time = '24h';
//Get Input from Time option 'buttons'
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['time'])) {
        $time = $_GET['time'];
    }
}
//Dahboard Asset
// Price
$assetPrice = $prices[0]->price;
$assetPrice=number_format((float)$assetPrice, 2, '.', ' ');

//User Asset Value
$userAssetValue= $prices[0]->price * $userAsset[0]->amount;
$userAssetValue=number_format((float)$userAssetValue, 2, '.', ' ');

//Differnce
$assetDiff24h= $prices[0]->price * $userAsset[0]->amount - $prices[0]->price_24h * $userAsset[0]->amount;
$assetDiff24h=number_format((float)$assetDiff24h, 2, '.', ' ');

$assetDiff7d= $prices[0]->price * $userAsset[0]->amount - $prices[0]->price_7d * $userAsset[0]->amount;
$assetDiff7d=number_format((float)$assetDiff7d, 2, '.', ' ');

$assetDiff30d= $prices[0]->price * $userAsset[0]->amount - $prices[0]->price_30d * $userAsset[0]->amount;
$assetDiff30d=number_format((float)$assetDiff30d, 2, '.', ' ');
//Diference Color
$colorDiff = "#000000";
if ((${'assetDiff'. $time} < 0))
$colorDiff = "#FF0000";
else if ((${'assetDiff'. $time} > 0) )
$colorDiff = "#00FF00";

//Percentage
$percentAsset24h= ($prices[0]->price * $userAsset[0]->amount 
    - $prices[0]->price_24h * $userAsset[0]->amount) 
    / ($prices[0]->price * $userAsset[0]->amount) * 100 . ' % ';
$percentAsset24h=number_format((float)$percentAsset24h, 2, '.', '');

$percentAsset7d= ($prices[0]->price * $userAsset[0]->amount 
    - $prices[0]->price_7d * $userAsset[0]->amount) 
    / ($prices[0]->price * $userAsset[0]->amount) * 100 . ' % ';
$percentAsset7d=number_format((float)$percentAsset7d, 2, '.', '');

$percentAsset30d= ($prices[0]->price * $userAsset[0]->amount 
    - $prices[0]->price_30d * $userAsset[0]->amount) 
    / ($prices[0]->price * $userAsset[0]->amount) * 100 . ' % ';
$percentAsset30d=number_format((float)$percentAsset30d, 2, '.', '');
//--- percentage color -red +green
$color = "#000000";
if ((${'percentAsset' . $time} < 0))
$color = "#FF0000";
else if ((${'percentAsset' . $time} > 0) )
$color = "#00FF00";


//------CHARTS--------- 
$assetName= $asset->name;
$symbol= $asset->name_api;
$chartData[0] = 0;
$chartData[1] = 0;

//------CRYPTOCHART--------
/* If type = crypto getting the chart data with the correct time-option from the API and putting them into arrays. */
// 24h
if ($prices[0]->type == 1 && $time == '24h') { 
    $chartTime = time()-86400;
    $chartData = chartC($symbol, $chartTime);
}
//7d
if ($prices[0]->type == 1 && $time == '7d') { 
    $chartTime = time()-604800;
    $chartData = chartC($symbol, $chartTime);
}
// 30d
if ($prices[0]->type == 1 && $time == '30d') { 
    $chartTime = time()-2629743;
    $chartData = chartC($symbol, $chartTime);
}

/**
 * It takes a variable symbol and a variable chartTime ( 1d, 1w, 1m,) and returns an array with two arrays, one
 * with the times and one with the prices for the requested asset.
 * 
 * @param symbol The coin symbol, e.g. 'btc'
 * @param chartTime the time for the chart
 * 
 * @return $chartData An array of arrays.
 */
function chartC($symbol, $chartTime){
    $client = new CoinGeckoClient();
    $result = $client->ping();
    $result = $client->coins()->getMarketChartRange($symbol, 'usd', $chartTime, time());
    
    foreach ($result['prices'] as $key =>$value) {  
        $chartPrices[]= $value[1];
        $chartTimes[]= date(' d.m.  H:i',$value[0]/1000);
    }
    $chartData[0] =$chartTimes;
    $chartData[1] =$chartPrices;
    return $chartData;  
}

// ----STOCKCHART-----
// 24h
if ( $prices[0]->type == 2 && $time == "24h") {
    $interval = 'minute';
    // Check if Data is available and if it is call function graphs
    // If Tuesday-Saturday get the 24h Data
    if(date('w', time()) === '2'|'3'|'4'|'5'|'6') {
        $chartTimes=date('Y-m-d', time()-86400);
        $chartData= graphS($symbol, $chartTimes, $interval);
    } 
    //If Sunday no Data for 24h
    if(date('w', time()) === '0'){
        $chartMsg= 'Exchanges were closed in the last 24 hours.';
        
    } 
    //If Monday no Data for 24h
    if(date('w', time()) === '1'){
        $chartMsg= 'No 24 hours chart available' ;
        
    } 
}
//7d
if ( $prices[0]->type == 2 && $time == "7d") {
    $interval = 'hour';
    // Check if Data is available and if it is call function graphs
    // If Monday-Friday get the Data starting 7d ago 
    if(date('w', time()) === '1'|'2'|'3'|'4'|'5') {
        $chartTimes=date('Y-m-d', time()-604800);
        $chartData= graphS($symbol, $chartTimes, $interval);
    } 
    //If Sunday get Data starting from last Monday
    if(date('w', time()) === '0'){
        $chartTimes=date('Y-m-d', time()-518400);
        $chartData= graphS($symbol, $chartTimes, $interval);
    } 
    //If Sturday get the Data starting from last Monday
    if(date('w', time()) === '6'){
        $chartTimes=date('Y-m-d', time()-432000);
        $chartData= graphS($symbol, $chartTimes, $interval);
    } 
}
//30d
if ( $prices[0]->type == 2 && $time == "30d") {
    $interval = 'hour';
    // Check if Data is available and if it is call function graphs
    // If today is Wednesday-Sunday get the Data starting 30 days ago 
    if(date('w', time()) === '0'|'3'|'4'|'5'|'6') {
        $chartTimes=date('Y-m-d', time()-2592000);
        $chartData= graphS($symbol, $chartTimes, $interval);
    }
    // If today is Monday get the Data starting 28 days ago 
    if(date('w', time()) === '1') {
        $chartTimes=date('Y-m-d', time()-2419200);
        $chartData= graphS($symbol, $chartTimes, $interval);
    }
    // If today is Tuesday get the Data starting 29 days ago 
    if(date('w', time()) === '2') {
        $chartTimes=date('Y-m-d', time()-2505600);
        $chartData= graphS($symbol, $chartTimes, $interval);
    }
}
/**
 * It takes a stock symbol and a date range, and returns an array of two arrays, one of dates and one
 * of prices.
 * 
 * @param symbol The stock symbol you want to get data for.
 * @param chartTimes The date and time of the first data point you want to retrieve.
 * 
 * @return An array of two arrays. The first array is a list of dates and the second array is a list of
 * prices.
 */
function graphS($symbol, $chartTimes, $interval){
    $queryString = http_build_query([
        'symbols' => $symbol,
        'api_token' => env('API_TOKEN_STOCKS'),
        'interval' => $interval,
        'date_from' => $chartTimes,
        'extended_hours' => true,
    ]);
    $ch = curl_init(sprintf('%s?%s', 'https://api.stockdata.org/v1/data/intraday', $queryString));
    // dd($ch);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $apiResult = json_decode($json, true);
    
    if (isset($apiResult)) {
        foreach ($apiResult['data'] as $value) {    
                $graphTimes[] =date("d.m.  H:i", strtotime($value['date']));
                $graphPrices[]= $value['data']['close'];
        }
    }
    
    if (isset($graphTimes)) {
        $chartData[0] = array_reverse($graphTimes);
        $chartData[1] = array_reverse($graphPrices);
        return $chartData;
    }
    else{
        $chartData[0] =0;
        $chartData[1] =0;
        return $chartData;
    }
    
}

//------METALCHART--------
/* If type = metal getting the chart data with the correct time-option from the API and putting them into arrays. */
// 24h
if ($prices[0]->type == 3 && $time == '24h') { 
    // no data for 24h
}
//7d
if ($prices[0]->type == 3 && $time == '7d') { 
    $chartTime = time()-604800;
    $chartData = chartM($symbol, $chartTime);
}
// 30d
if ($prices[0]->type == 3 && $time == '30d') { 
    $chartTime = time()-2629743;
    $chartData = chartM($symbol, $chartTime);
}
/**
 * It takes a variable symbol and a variable chartTime ( 1d, 1w, 1m,) and returns an array with two arrays, one
 * with the times and one with the prices for the requested asset.
 * 
 * @param symbol The metal symbol, e.g. 'xau'
 * @param chartTime the time for the chart
 * 
 * @return $chartData An array of arrays.
 */
function chartM($symbol, $chartTime) {
        
    $from= date('Y-m-d', $chartTime);
    $till= date('Y-m-d', time());
    $ch = curl_init('https://api.metalpriceapi.com/v1/timeframe?api_key='. env('API_TOKEN_METALS') .'&base='.$symbol.'&currencies=USD&units=gram&start_date='.$from.'&end_date='.$till);

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    $priceM = json_decode($output, true);
    curl_close($ch);
    foreach ($priceM['rates'] as $key => $value) {    
        $chartTimes[] = date('d.m', strtotime($key));
        $chartPrices[]= $value['USD'];
    }
    $chartData[0] = $chartTimes;
    $chartData[1]= $chartPrices;
    return $chartData;  
}
?>
<!-- CONTENT SHOW -->
@section('content')
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
<!-- Show-Chart -->
<section class="container pb-3">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <canvas id="myChart" width="800" height="450"></canvas>
        </div>
    </div>
</section>
<!-- Asset-Dashboard -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header card-header-flexbox">
                    <h2>{{ $asset->name}}{{' $' . $assetPrice . ' '}}<span class="percent-show" style='color: <?php echo  $color;  ?>'>{{${'percentAsset'. $time} . '%'}}</span></h2>
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
                <!-- Asset Dashboard -->
                <div class="card-body">
                    <div class="show-grid">
                        <div class="grid-item">{{$userAsset[0]->amount . ' ' . $asset->symbol }}</div>
                        <div class="grid-item">{{'$' . $userAssetValue}}</div>
                        <div class="grid-item">
                            <span style='color: <?php echo  $colorDiff;  ?>'>{{${'assetDiff'. $time} . '$' }}</span><br>
                            <span class="change">Change ({{$time}})</span>
                        </div>
                    </div>
                    <div class="button-row mt-3 mb-4">
                        <a href="{{ route('home.edit',$asset->id) }}"class="btn btn-secondary">edit</a>

                        <form action="{{ route('home.destroy',$asset->id) }}" method="POST" class="delete" data-title="{{ $asset->name }}"data-body="{{'Delete Asset from your Portfolio?'}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger fa fa-trash"><strong>X</strong></button>
                        </form>
                    </div>
                    <article>
                        {!!$asset->description!!}
                    </article>
                </div>
            </div>
            <a href="{{ route('home.index') }}" class="btn btn-back mt-2">< back</a>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalDeleteLabel"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-outline-danger">Delete</button>
            </div>
        </div>
    </div>
 </div>
<script>
// Delete function
    (function($){
        $('form.delete').on('submit',function(e){
            e.preventDefault();
            const form = $(this);
            const modalBox = $('#modalDelete');
                //console.log(form,modalBox);
            modalBox.modal("show");

            $('.alert.alert-success').remove();

            $('#modalDeleteTitle').text($(this).data('title'));
            $('#modalDeleteLabel').text($(this).data('body'));

            $('#modalDelete .btn-outline-danger').off().on('click',function(e){
                modalBox.modal("hide");
                $.ajax({
                    url: form.attr('action'),
                    method: "DELETE",
                    data: form.serialize(),
                    success: function(response){
                        window.location.href = "{{ route('home.index') }}";
                    },
                    error: function(xhr){
                        console.log(xhr.status, xhr.statusText);
                    }
                });
            });
        })
    })(jQuery)

    </script>

<script type="text/javascript">
    // Chartdata
    var assetName = <?php echo json_encode($assetName)?>;
    var chartPrices = <?php echo json_encode($chartData[1]) ?>;
    var chartTimes = <?php echo json_encode($chartData[0]) ?>;
    if (chartTimes == 0) { 
        document.getElementById('myChart').style.display = 'none';
    }
    // <!-- Loading Page Animation -->
    $(window).on('load', function () {
        setInterval(function() {
            $('#loading').hide();
            // $("#loading").fadeOut("slow")
        }, 1000);
    }) 
</script>
        </script>
<script src="{{ asset('chart.js/chart.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="{{ asset('js/line-chart.js') }}" defer></script>
@endsection