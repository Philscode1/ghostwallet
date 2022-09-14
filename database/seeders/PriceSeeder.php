<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Price::create([
            'asset_id' => 1,
            'type' => 1,
            'price' => 23817.00,
            'price_24h' => 21693.00,
            'price_7d' => 23023.00,
            'price_30d' => 20624.00,
        ]);
        Price::create([
            'asset_id' => 2,
            'type' => 2,
            'price' => 842.90,
            'price_24h' => 824.87,
            'price_7d' => 816.73,
            'price_30d' => 685.23,
        ]);
        Price::create([
            'asset_id' => 3,
            'type' => 3,
            'price' => 1736.90,
            'price_24h' => 1755.43,
            'price_7d' => 1726.55,
            'price_30d' => 1818.42,
        ]);
        Price::create([
            'asset_id' => 4,
            'type' => 2,
            'price' => 157.66,
            'price_24h' => 156.00,
            'price_7d' => 154.09,
            'price_30d' => 139.23,
        ]);
        Price::create([
            'asset_id' => 5,
            'type' => 2,
            'price' => 276.43,
            'price_24h' => 268.55,
            'price_7d' => 260.00,
            'price_30d' => 260.23,
        ]);
        Price::create([
            'asset_id' => 6,
            'type' => 1,
            'price' => 1721.89,
            'price_24h' => 1628.00,
            'price_7d' => 1603.45,
            'price_30d' => 1126.43,
        ]);
    }
}
