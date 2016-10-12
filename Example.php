<?php

die("This is non working example code. Please adapt to your needs");

include "../httpful/httpful.phar";
include "MonsumAPI.php";
include "MonsumCustomer.php";
include "MonsumProduct.php";
include "MonsumAddon.php";
include "MonsumSubscription.php";
include "MonsumInvoice.php";
include "MonsumSubscriptionsOfCustomer.php";

date_default_timezone_set("Europe/Zurich");

$a = new MonsumAPI(array(MonsumAPI::MONSUM_API_CACHE     => true, 
                         MonsumAPI::MONSUM_API_CACHE_DIR => "../cache", // no trailing slash
                         MonsumAPI::MONSUM_API_CACHE_AGE => 300, // 5 minutes
                         MonsumAPI::MONSUM_API_DEBUG     => false,
                         MonsumAPI::MONSUM_API_LOGFILE   => "../log/monsum_api.log",
                         MonsumAPI::MONSUM_API_URL       => "https://app.monsum.com/api/1.0/api.php",
                         MonsumAPI::MONSUM_API_KEY       => "123",  
                         MonsumAPI::MONSUM_API_EMAIL     => "user@domain.tld"));

$t = new MonsumCustomer($a);
$t->loadCustomerByID("1234567");
$t->dump();

$t = new MonsumProduct($a);
$t->loadProductByID("abc123");
$t->dump();

$t = new MonsumAddon($a);
$t->loadAddonByID("def123");
$t->dump();

$t = new MonsumSubscription($a);
$t->loadSubscriptionByID("123456789");
$t->dump();

$t = new MonsumSubscriptionsOfCustomer($a, "1234567");
foreach ($t as $key => $value) {
    print "SUBSCRIPTION_ID: " . $key . " START: " . $value->getStart();
}

$t = new MonsumInvoice($a);
$t->loadInvoiceByNumber("1234567890");
$t->dump();
$t->sendByEMail("some@email.com", "Subject", "Message");



?>
