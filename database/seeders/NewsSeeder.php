<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::create([
            'title' => 'Elon Musk Has a Surprise About Inflation',
            'description' => 'Tesla CEO has promised the electric vehicle maker will lower prices as soon as inflation ebbs.',
            'url' => 'https://www.thestreet.com/technology/elon-musk-has-a-surprise-about-inflation',
            'image_url' => 'https://www.thestreet.com/.image/t_share/MTgxMDc5NTAwMzc1NzI5NTEy/elon-musk_2.jpg',
            'source' => 'news.google.com',
        ]);
        News::create([
            'title' => 'Elon Musk: Net Worth, Investments, Crypto Portfolio 2022',
            'description' => 'Net Worth$250 billionAge51BornJune 28, 1971NationalitySouth AfricanSource of WealthElectric Vehicles Elon Musk is a South African entrepreneur, innovator…',
            'url' => 'https://www.investortrip.com/elon-musk/',
            'image_url' => 'https://www.investortrip.com/wp-content/uploads/cropped-android-chrome-512x512-1.png',
            'source' => 'investortrip.com',
        ]);
        News::create([
            'title' => 'Top 5 2nd Quarter Trades of PACIFIC SUN FINANCIAL CORP',
            'description' => 'GuruFocus Article or News written by insider and the topic is about:',
            'url' => 'https://www.gurufocus.com/news/1838292/top-5-2nd-quarter-trades-of-pacific-sun-financial-corp',
            'image_url' => 'https://static.gurufocus.com/images/logo_global.png',
            'source' => 'gurufocus.com',
        ]);
        News::create([
            'title' => 'Elon Musk Delivers Good News on Inflation',
            'description' => 'Tesla CEO has promised the electric vehicle maker will lower prices as soon as inflation ebbs.',
            'url' => 'https://www.thestreet.com/technology/elon-musk-delivers-good-news-on-inflation',
            'image_url' => 'https://www.thestreet.com/.image/t_share/MTgxMDc5NTAwMzc1NzI5NTEy/elon-musk_2.jpg',
            'source' => 'thestreet.com',
        ]);
        News::create([
            'title' => 'Alibaba Stock Slides After Report Of Jack Ma\'s Ant Plan: Hang Seng Falls Despite Wall Street Rally',
            'description' => 'Hong Kong’s benchmark Hang Seng Index was in the red on Friday, losing over 0.5% in opening trade, despite a continuing rally on Wall Street. Alibaba shares fell close to 4% following reports Chinese billionaire Jack Ma is planning to cede control of Ant Group',
            'url' => 'https://www.benzinga.com/markets/asia/22/07/28259658/alibaba-shares-fall-over-2-5-nio-surges-hang-seng-opens-in-the-red-defying-continuing-rally-on-wall',
            'image_url' => 'https://cdn.benzinga.com/files/images/story/2022/07/28/shutterstock_1478039207.jpg?width=1200&height=800&fit=crop',
            'source' => 'benzinga.com',
        ]);
    }
}
