<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Price;
use App\Models\News;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;

//--------CRYPTO Prices-----------
/**
 * It takes a string as an argument, and returns the current price of the coin in USD
 * 
 * @param priceTarget The coin you want to get the current price of.
 * 
 * @return The current price of the coin in USD
 */
function priceC($priceTargetC){
    $client = new CoinGeckoClient();
    $data = $client->ping();
    $data = $client->simple()->getPrice($priceTargetC,'usd');
    foreach ($data as $value) {
        $priceC = $value['usd'];
        return $priceC;
    }
}

/**
 * It takes a coin name as a parameter, and returns the price of that coin 24 hours ago
 * 
 * @param priceTarget The coin you want to get the price of.
 * 
 * @return The price of the coin in USD 24 hours ago.
 */
function priceC24h($priceTarget){
    $client = new CoinGeckoClient();
    $result = $client->ping();
    $result = $client->coins()->getMarketChartRange($priceTarget, 'usd', time()-86400, time());
    return $result['prices'][0][1];
}

/**
 * It takes a coin name as a parameter, and returns the price of that coin in USD from 7 days ago
 * 
 * @param priceTarget The coin you want to get the price of.
 * 
 * @return The price of the coin in USD from 7 days ago
 */
function priceC7d($priceTarget){
    
    $client = new CoinGeckoClient();
    $result = $client->ping();
    $result = $client->coins()->getMarketChartRange($priceTarget, 'usd', time()-604800, time());
    return $result['prices'][0][1];
}

/**
 * It returns the price of a coin in USD from 30 days ago.
 * 
 * @param priceTarget The coin you want to get the price of.
 * 
 * @return The price of the coin in USD from 7 days ago.
 */
function priceC30d($priceTarget){
    $client = new CoinGeckoClient();
    $result = $client->ping();
    $result = $client->coins()->getMarketChartRange($priceTarget, 'usd', time()-2592000, time());
    return $result['prices'][0][1];
}

/**
 * It takes string as an argument, and returns the current price of that stock in USD.
 * 
 * @param priceTargetS The stock symbol you want to get the current price for.
 * 
 * @return The current price of the stock in USD
 */
function priceS($priceTargetS) {
    $queryString = http_build_query([
        'api_token' => env('API_TOKEN_STOCKS'),
        'symbols' => $priceTargetS,
        'filter_entities' => 'true',
        'limit' => 50,
    ]);
    $ch = curl_init(sprintf('%s?%s', 'https://api.stockdata.org/v1/data/quote', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $priceS = json_decode($json, true);
    return $priceS['data'][0]['price'];
}

/**
 * It takes a stock ticker symbol as input, and returns the closing price of that stock from the
 * previous day.
 * 
 * @param priceTarget The stock symbol you want to get the price for.
 * 
 * @return The price of the stock from the previous day.
 */
function priceS24h($priceTarget) {
    $queryString = http_build_query([
        'api_token' => env('API_TOKEN_STOCKS'),
        'symbols' => $priceTarget,
        'date' => date('Y-m-d', time()-86400),
        'filter_entities' => 'true',
        'limit' => 50,
    ]);
    $ch = curl_init(sprintf('%s?%s', 'https://api.stockdata.org/v1/data/quote', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $apiResult = json_decode($json, true);
    return $apiResult['data'][0]['previous_close_price'];
}

/**
 * It takes a stock ticker symbol as input, and returns the closing price of that stock from 7 days ago.
 * 
 * If the current day is Tuesday-Friday, get the EOD price from 7 days ago. If the current day is
 * Saturday, get the EOD price from 8 days ago. If the current day is Sunday, get the EOD price from 9
 * days ago. If the current day is Monday, get the EOD price from 10 days ago
 * 
 * @param priceTarget The stock symbol you want to get the price for.
 * 
 * @return the closing price of the stock 7 days ago.
 */
function priceStock7d($priceTarget) {
    //Check if 7 Days EOD Data is available (Tuesday-Friday)
    if(date('w', time()) === '2'|'3'|'4'|'5') {
        $timeTarget=date('Y-m-d', time()-604800);
    } 
    //If Sunday add 2 more days to get Friday EOD
    if(date('w', time()) === '0'){
        $timeTarget=date('Y-m-d', time()-777600);    
    } 
    //If Monday add 3 more days to get Friday EOD
    if(date('w', time()) === '1'){
        $timeTarget=date('Y-m-d', time()-864000);
    } 
    //If Saturday add 1 more days to get Friday EOD
    if(date('w', time()) === '6'){
        $timeTarget=date('Y-m-d', time()-691200);
    } 
    $queryString = http_build_query([
        'api_token' => env('API_TOKEN_STOCKS'),
        'symbols' => $priceTarget,
        'date' => $timeTarget,
    ]); 
    $ch = curl_init(sprintf('%s?%s', 'https://api.stockdata.org/v1/data/eod', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $apiResult = json_decode($json, true);
    // dd($apiResult);
    return $apiResult['data'][0]['close'];
}

/**
 * It takes a stock ticker symbol as input, and returns the closing price of that stock from 30 days ago.
 * 
 * If the the day 30 days ago is Sunday, get the EOD price from 32 days ago. If the the day 30 days ago is Monday, get the EOD price from 33 days ago. If the the day 30 days ago is Saturday, get the EOD price from 31 days ago.
 * @param priceTarget The stock symbol you want to get the price for.
 * 
 * @return the closing price of the stock 30 days ago.
 */
function priceStock30d($priceTarget) {
    $timeTarget= date('Y-m-d', time()-2592000);
    $timeStamp= strtotime($timeTarget);
    //Get the day 30 days ago
    $day= date('w',$timeStamp);
    //If Sunday add 2 more days to get Friday EOD
    if ($day === '0') {
        $timeTarget= date('Y-m-d', time()-2764800);
    }
    //If Monday add 3 more days to get Friday EOD
    if ($day === '1') {
        $timeTarget= date('Y-m-d', time()-2851200);
    }
    //If Saturday add 1 more days to get Friday EOD
    if ($day === '6') {
        $timeTarget= date('Y-m-d', time()-2678400);
    }
    $queryString = http_build_query([
        'api_token' => env('API_TOKEN_STOCKS'),
        'symbols' => $priceTarget,
        'date' => $timeTarget,
    ]); 
    $ch = curl_init(sprintf('%s?%s', 'https://api.stockdata.org/v1/data/eod', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $apiResult = json_decode($json, true);
    return $apiResult['data'][0]['close'];
}

//--------METALS----------
/**
 * It takes the priceTargetM and uses it to get the current price of the metal in USD.
 * 
 * @param priceTargetM The metal you want to get the current price of.
 * 
 * @return The current price of the metal in USD
 */
function priceM($priceTarget) {
    $ch = curl_init('https://api.metalpriceapi.com/v1/latest?api_key='. env('API_TOKEN_METALS') .'&base='.$priceTarget.'&currencies=USD');

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    $priceM = json_decode($output, true);
    curl_close($ch);
    return $priceM['rates']['USD'];  
}
/**
 * It takes the priceTargetM and uses it to get the price from 24 hours ago of the metal in USD.
 * 
 * @param priceTargetM The metal you want to get the price of.
 * 
 * @return The price from 24hours ago of the metal in USD
 */
function priceM24h($priceTarget) {
    $timeTarget= date('Y-m-d', time()-86400);
    $ch = curl_init('https://api.metalpriceapi.com/v1/'.$timeTarget.'?api_key='. env('API_TOKEN_METALS') .'&base='.$priceTarget.'&currencies=USD');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $apiResult = json_decode($output, true);
    curl_close($ch);
    var_dump($apiResult);
    return $apiResult['rates']['USD']; 
}
/**
 * It takes the priceTargetM and uses it to get the price from 7 days ago of the metal in USD.
 * 
 * @param priceTargetM The metal you want to get the price of.
 * 
 * @return The price from 7 days ago of the metal in USD
 */
function priceM7d($priceTarget) {
    $timeTarget= date('Y-m-d', time()-604800);
    $ch = curl_init('https://api.metalpriceapi.com/v1/'.$timeTarget.'?api_key='. env('API_TOKEN_METALS') .'&base='.$priceTarget.'&currencies=USD');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $apiResult = json_decode($output, true);
    curl_close($ch);
    var_dump($apiResult);
    return $apiResult['rates']['USD']; 
}
/**
 * It takes the priceTargetM and uses it to get the price from 30 days ago of the metal in USD.
 * 
 * @param priceTargetM The metal you want to get the price of.
 * 
 * @return The price from 30 days ago of the metal in USD
 */
function priceM30d($priceTarget) {
    $timeTarget= date('Y-m-d', time()-2592000);
    $ch = curl_init('https://api.metalpriceapi.com/v1/'.$timeTarget.'?api_key='. env('API_TOKEN_METALS') .'&base='.$priceTarget.'&currencies=USD');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $apiResult = json_decode($output, true);
    curl_close($ch);
    var_dump($apiResult);
    return $apiResult['rates']['USD']; 
}
//-----NEWS------
/**
 * It takes the API token, language, symbols, and limit and returns the Newsdata.
 * 
 * @return An array of News-arrays.
 */
function finNews() {
    $queryString = http_build_query([
        'api_token' => env('API_TOKEN_STOCKS'),
        'language' => 'en',
        'symbols' => 'TSLA', 'AAPL', 'MSF', 'AMZN', 'META',
        'limit' => 5,
    ]);
    $ch = curl_init(sprintf('%s?%s', 'https://api.stockdata.org/v1/news/all', $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $allNews = json_decode($json, true);
    return $allNews['data'];
}

class PriceController extends Controller
{
    // Crypto Current Price
    public function c1()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a crypto, and if it is, it is getting the current price and updating the price column in the prices table. */
            if ($price->prices[0]->type == 1) {
                $newPrice=priceC($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Crypto 24h Prices
    public function c2()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a crypto, and if it is, it is getting the price 24 hours ago and updating the price_24h column in the prices table. */
            if ($price->prices[0]->type == 1) {
                $newPrice=priceC24h($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_24h' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
        
    }
    //Crypto 7d Prices
    public function c3()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a crypto, and if it is, it is getting the price 7 days ago and updating the price_7d column in the prices table. */
            if ($price->prices[0]->type == 1) {
                $newPrice=priceC7d($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_7d' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Crypto 7d Prices
    public function c4()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

             /* Checking if the asset is a crypto, and if it is, it is getting the price 30 days ago and updating the price_30d column in the prices table. */
             if ($price->prices[0]->type == 1) {
                $newPrice=priceC30d($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_30d' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Stock current Prices
    public function s1()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a stock, and if it is, it is getting the current price and updating the price column in the prices table. */
            if ($price->prices[0]->type == 2) {
                $newPrice=priceS($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Stock 24h Prices
    public function s2()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a stock, and if it is, it is getting the price 24 hours ago and updating the price_24h column in the prices table. */
            if ($price->prices[0]->type == 2) {
                $newPrice=priceS24h($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_24h' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Stock 7d Prices
    public function s3()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a stock, and if it is, it is getting the price 7 days ago and
            updating the price_7d column in the prices table. */
            if ($price->prices[0]->type == 2) {
                $newPrice=priceStock7d($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_7d' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Stock 30d Prices
    public function s4()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a stock, and if it is, it is getting the price 30 days ago and updating the price_30d column in the prices table. */
            if ($price->prices[0]->type == 2) {
                $newPrice=priceStock30d($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_30d' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }

    //Metal Current Prices
    public function m1()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a metal, and if it is, it is getting the price  and updating the price column in the prices table. */
            if ($price->prices[0]->type == 3) {
                $newPrice=priceM($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Metal 24h Prices
    public function m2()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a metal, and if it is, it is getting the price from 24 hours ago and updating the price column in the prices_24h table. */
            if ($price->prices[0]->type == 3) {
                $newPrice=priceM24h($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_24h' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Metal 7d Prices
    public function m3()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a metal, and if it is, it is getting the price from 7 days ago ago and updating the price column in the prices_7d table. */
            if ($price->prices[0]->type == 3) {
                $newPrice=priceM7d($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_7d' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }
    //Metal 30d Prices
    public function m4()
    {
        $prices= Asset::with('prices')->get();
        foreach ($prices as $price) {

            /* Checking if the asset is a metal, and if it is, it is getting the price from 30 days ago and updating the price column in the prices_30d table. */
            if ($price->prices[0]->type == 3) {
                $newPrice=priceM30d($price->name_api);
                if ($newPrice != null) {
                    DB::table('prices')
                    ->where('asset_id', $price->id)
                    ->update(['price_30d' => $newPrice,
                    "updated_at" => date('Y-m-d H:i:s') ]);
                }
            }
        }
        return redirect()->route('home.index')->with('success', 'Prices updated');
    }

    //----NEWS------
    //Get the latest 5 News-articles and save them in news table
    public function news()
    {
        $allNews= finNews();

        DB::table('news')
                ->where('id', 1)
                ->update([
                    'title' => $allNews[0]['title'],
                    'description' => $allNews[0]['description'],
                    'url' => $allNews[0]['url'],
                    'image_url' => $allNews[0]['image_url'],
                    'source' => $allNews[0]['source']
                ]);

                DB::table('news')
                ->where('id', 2)
                ->update([
                    'title' => $allNews[1]['title'],
                    'description' => $allNews[1]['description'],
                    'url' => $allNews[1]['url'],
                    'image_url' => $allNews[1]['image_url'],
                    'source' => $allNews[1]['source']
                ]);

                DB::table('news')
                ->where('id', 3)
                ->update([
                    'title' => $allNews[2]['title'],
                    'description' => $allNews[2]['description'],
                    'url' => $allNews[2]['url'],
                    'image_url' => $allNews[2]['image_url'],
                    'source' => $allNews[2]['source']
                ]);

                DB::table('news')
                ->where('id', 4)
                ->update([
                    'title' => $allNews[3]['title'],
                    'description' => $allNews[3]['description'],
                    'url' => $allNews[3]['url'],
                    'image_url' => $allNews[3]['image_url'],
                    'source' => $allNews[3]['source']
                ]);

                DB::table('news')
                ->where('id', 5)
                ->update([
                    'title' => $allNews[4]['title'],
                    'description' => $allNews[4]['description'],
                    'url' => $allNews[4]['url'],
                    'image_url' => $allNews[4]['image_url'],
                    'source' => $allNews[4]['source']
                ]);

        return redirect()->route('home.index')->with('success', 'Prices updated');
    }

}











