#!/usr/bin/php
<?php

// HTTPFUL Library
// http://phphttpclient.com/
include "../../httpful/httpful.phar";

// Use PHP Library from
// http://csv.thephpleague.com/
use League\Csv\Writer;
require '../../league_csv/vendor/autoload.php';

include "../MonsumAPI.php";
include "../MonsumProduct.php";
include "../MonsumProducts.php";

date_default_timezone_set("Europe/Zurich");

$a = new MonsumAPI(array(MonsumAPI::MONSUM_API_CACHE     => true, 
                         MonsumAPI::MONSUM_API_CACHE_DIR => "./cache", // no trailing slash
                         MonsumAPI::MONSUM_API_CACHE_AGE => 300, // 5 minutes
                         MonsumAPI::MONSUM_API_DEBUG     => false,
                         MonsumAPI::MONSUM_API_LOGFILE   => "./log/monsum_api.log",
                         MonsumAPI::MONSUM_API_URL       => "https://app.monsum.com/api/1.0/api.php",
                         MonsumAPI::MONSUM_API_KEY       => "123",  
                         MonsumAPI::MONSUM_API_EMAIL     => "user@domain.tld"));


$writer = Writer::createFromPath("monsum_products.csv", "w");
$writer->insertOne(["id", "number", "title", "description", "isgross", "unitprice", "setupfee", "allowmultiple", 
                    "currencycode", "isdigital", "vatpercent", "sinterval", "snumevents", "strial", "sduration", 
                    "sdurationfollow", "sdurationcancel", "isaddon"]);

$p = new MonsumProducts($a);
foreach ($p as $key => $value) {
    $writer->insertOne([$value->getID(), 
                        $value->getNumber(),
                        $value->getTitle(),
                        $value->getDescription(),
                        $value->isGross(),
                        $value->getUnitPrice(),
                        $value->getSetupFee(),
                        $value->allowMultiple(),
                        $value->getCurrencyCode(),
                        $value->isDigital(),
                        $value->getVATPercent(),
                        $value->getSubscriptionInterval(),
                        $value->getSubscriptionNumberEvents(),
                        $value->getSubscriptionTrial(),
                        $value->getSubscriptionDuration(),
                        $value->getSubscriptionDurationFollow(),
                        $value->getSubscriptionCancellation(),
                        $value->isAddon()
                        ]);
}

?>