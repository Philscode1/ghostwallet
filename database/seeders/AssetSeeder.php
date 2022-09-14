<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asset::create([
            'name' => 'Bitcoin',
            'symbol' => 'BTC',
            'name_api' => 'bitcoin',
            'description' => 'Bitcoin is a digital currency which operates free of any central control or the oversight of banks or governments. Instead it relies on peer-to-peer software and cryptography.
            <br><br>
            A public ledger records all bitcoin transactions and copies are held on servers around the world. Anyone with a spare computer can set up one of these servers, known as a node. Consensus on who owns which coins is reached cryptographically across these nodes rather than relying on a central source of trust like a bank.
            <br><br>
            Every transaction is publicly broadcast to the network and shared from node to node. Every ten minutes or so these transactions are collected together by miners into a group called a block and added permanently to the blockchain.',
            'active' => 1,
        ]);
        Asset::create([
            'name' => 'Tesla',
                'symbol' => 'TSLA',
                'name_api' => 'TSLA',
                'description' => 'Tesla, Inc. designs, develops, manufactures, leases, and sells electric vehicles, and energy generation and storage systems in the United States, China, and internationally. The company operates in two segments, Automotive, and Energy Generation and Storage. <br><br>

                The Automotive segment offers electric vehicles, as well as sells automotive regulatory credits. It provides sedans and sport utility vehicles through direct and used vehicle sales, a network of Tesla Superchargers, and in-app upgrades; and purchase financing and leasing services. <br><br>
                This segment is also involved in the provision of non-warranty after-sales vehicle services, sale of used vehicles, retail merchandise, and vehicle insurance, as well as sale of products through its subsidiaries to third party customers; services for electric vehicles through its company-owned service locations, and Tesla mobile service technicians; and vehicle limited warranties and extended service plans.<br><br>
                The Energy Generation and Storage segment engages in the design, manufacture, installation, sale, and leasing of solar energy generation and energy storage products, and related services to residential, commercial, and industrial customers and utilities through its website, stores, and galleries, as well as through a network of channel partners. This segment also offers service and repairs to its energy product customers, including under warranty; and various financing options to its solar customers. <br><br>
                The company was formerly known as Tesla Motors, Inc. and changed its name to Tesla, Inc. in February 2017. Tesla, Inc. was founded in 2003 and is headquartered in Palo Alto, California.',
                'active' => 1,
        ]);
        
        Asset::create([
            'name' => 'Gold',
                'symbol' => 'XAU',
                'name_api' => 'XAU',
                'description' => 'Gold, Metallic chemical element, one of the transition elements, chemical symbol Au, atomic number 79. <br><br>
                It is a dense, lustrous, yellow, malleable precious metal, so durable that it is virtually indestructible, often found uncombined in nature. <br><br>
                Jewelry and other decorative objects have been crafted from gold for thousands of years. <br><br>
                It has been used for coins, to back paper currencies, and as a reserve asset. <br><br>
                Gold is widely distributed in all igneous rocks, usually pure but in low concentrations; its recovery from ores and deposits has been a major preoccupation since ancient times. ',
                'active' => 1,
        ]);
    
        Asset::create([
            'name' => 'Apple',
                'symbol' => 'AAPL',
                'name_api' => 'AAPL',
                'description' => 'Apple Inc. designs, manufactures, and markets smartphones, personal computers, tablets, wearables, and accessories worldwide. It also sells various related services. <br><br>
                The company offers iPhone, a line of smartphones; Mac, a line of personal computers; iPad, a line of multi-purpose tablets; and wearables, home, and accessories comprising AirPods, Apple TV, Apple Watch, Beats products, HomePod, iPod touch, and other Apple-branded and third-party accessories. <br><br>
                It also provides AppleCare support services; cloud services store services; and operates various platforms, including the App Store, that allow customers to discover and download applications and digital content, such as books, music, video, games, and podcasts. <br><br>
                In addition, the company offers various services, such as Apple Arcade, a game subscription service; Apple Music, which offers users a curated listening experience with on-demand radio stations; Apple News+, a subscription news and magazine service; Apple TV+, which offers exclusive original content; Apple Card, a co-branded credit card; and Apple Pay, a cashless payment service, as well as licenses its intellectual property. <br><br>
                The company serves consumers, and small and mid-sized businesses; and the education, enterprise, and government markets. It sells and delivers third-party applications for its products through the App Store. <br><br>
                The company also sells its products through its retail and online stores, and direct sales force; and third-party cellular network carriers, wholesalers, retailers, and resellers. <br><br>
                Apple Inc. was founded in 1977 and is headquartered in Cupertino, California',
                'active' => 1,
        ]);

    
        Asset::create([
            'name' => 'Microsoft',
                'symbol' => 'MSFT',
                'name_api' => 'MSFT',
                'description' => 'Microsoft Corporation develops, licenses, and supports software, services, devices, and solutions worldwide. <br><br>
                Its Productivity and Business Processes segment offers Office, Exchange, SharePoint, Microsoft Teams, Office 365 Security and Compliance, and Skype for Business, as well as related Client Access Licenses (CAL); Skype, Outlook.com, OneDrive, and LinkedIn; and Dynamics 365, a set of cloud-based and on-premises business solutions for small and medium businesses, organizations, and enterprise divisions.<br><br>
                Its Intelligent Cloud segment licenses SQL, Windows Servers, Visual Studio, System Center, and related CALs; GitHub that provides a collaboration platform and code hosting service for developers; and Azure, a cloud platform. <br><br>
                It also offers support services and Microsoft consulting services to assist customers in developing, deploying, and managing Microsoft server and desktop solutions; and training and certification to developers and IT professionals on Microsoft products. <br><br>
                Its More Personal Computing segment provides Windows original equipment manufacturer (OEM) licensing and other non-volume licensing of the Windows operating system; Windows Commercial, such as volume licensing of the Windows operating system, Windows cloud services, and other Windows commercial offerings; patent licensing; Windows Internet of Things; and MSN advertising. <br><br>
                It also offers Surface, PC accessories, PCs, tablets, gaming and entertainment consoles, and other devices; Gaming, including Xbox hardware, and Xbox content and services; video games and third-party video game royalties; and Search, including Bing and Microsoft advertising.<br><br>
                It sells its products through OEMs, distributors, and resellers; and directly through digital marketplaces, online stores, and retail stores. <br><br>
                It has a collaboration with Dynatrace, Inc., Morgan Stanley, Micro Focus, WPP plc, ACI Worldwide, Inc., and iCIMS, Inc.<br><br> 
                Microsoft Corporation was founded in 1975 and is headquartered in Redmond, Washington.',
                'active' => 1,
        ]);
    
    Asset::create([
        'name' => 'Ethereum',
            'symbol' => 'ETH',
            'name_api' => 'ethereum',
            'description' => 'Ethereum is an open source, distributed software platform that is based on blockchain technology. It has its own native cryptocurrency called Ether and a programming language called Solidity.<br><br>
            Blockchain is a distributed ledger technology that keeps a permanent, tamper-proof list of records. <br><br>
            Ethereum is Bitcoin\'s main competitor.
            <br><br>
            Ethereum enables developers to build decentralized applications. Miners produce Ether tokens that can be used as a currency and to pay for usage fees on the Ethereum network. The platform also supports smart contracts, which are a type of digital contract.
            <br><br>
            Cryptocurrency researcher Vitalik Buterin first described Ethereum in a proposal in 2013 that suggested the addition of a scripting language for programming to Bitcoin. 
            <br><br>
            Ethereum\'s development was funded by an online crowdsale, which is crowdfunding done through issuing cryptocurrency tokens, and the project came online on July 30, 2015.',
            'active' => 1,
    ]);
    }
}
