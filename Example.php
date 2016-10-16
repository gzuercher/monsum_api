<?php

die("This is example code. Change to your needs");

// HTTPFUL Library
// http://phphttpclient.com/
include "../httpful/httpful.phar";

include "MonsumAPI.php";
include "MonsumCustomer.php";
include "MonsumCustomers.php";
include "MonsumProduct.php";
include "MonsumProducts.php";
include "MonsumProductsNoAddons.php";
include "MonsumAddon.php";
include "MonsumAddons.php";
include "MonsumSubscription.php";
include "MonsumSubscriptionsOfCustomer.php";
include "MonsumInvoice.php";
include "MonsumInvoicesOfCustomer.php";

date_default_timezone_set("Europe/Zurich");

$a = new MonsumAPI(array(MonsumAPI::MONSUM_API_CACHE     => true, 
                         MonsumAPI::MONSUM_API_CACHE_DIR => "./cache", // no trailing slash
                         MonsumAPI::MONSUM_API_CACHE_AGE => 300, // 5 minutes
                         MonsumAPI::MONSUM_API_DEBUG     => false,
                         MonsumAPI::MONSUM_API_LOGFILE   => "./monsum_api.log",
                         MonsumAPI::MONSUM_API_URL       => "https://app.monsum.com/api/1.0/api.php",
                         MonsumAPI::MONSUM_API_KEY       => "123",  
                         MonsumAPI::MONSUM_API_EMAIL     => "user@domain.tld"));

$t = new MonsumCustomer($a);
$t->loadCustomerByID("1234567");
$t->dump();

$t = new MonsumCustomers($a);
foreach ($t as $key => $value) {
    print "CUSTOMER_ID: " . $key . " DATA: " . $value->getOrganization();
}

$t = new MonsumProduct($a);
$t->loadProductByID("abc123");
$t->dump();

$t = new MonsumProducts($a);
foreach ($t as $key => $value) {
    print "PRODUCT_ID: " . $key . " DATA: " . $value->getTitle();
}

$t = new MonsumProductsNoAddons($a);
foreach ($t as $key => $value) {
    print "PRODUCT__NOADDONS_ID: " . $key . " DATA: " . $value->getTitle();
}

$t = new MonsumAddon($a);
$t->loadAddonByID("def123");
$t->dump();

$t = new MonsumAddons($a);
foreach ($t as $key => $value) {
    print "ADDON_ID: " . $key . " DATA: " . $value->getTitle();
}

$t = new MonsumSubscription($a);
$t->loadSubscriptionByID("123456789");
$t->dump();

$t = new MonsumSubscriptionsOfCustomer($a, "1234567");
foreach ($t as $key => $value) {
    print "SUBSCRIPTION_ID: " . $key . " DATA: " . $value->getStart();
}

$t = new MonsumInvoice($a);
$t->loadInvoiceByNumber("1234567890");
$t->dump();
$t->sendByEMail("some@email.com", "Subject", "Message");

t = new MonsumInvoicesOfCustomer($a, "1234567");
foreach ($t as $key => $value) {
    print "INVOICE_ID: " . $key . " DATA: " . $value->getInvoiceDate();
}

?>