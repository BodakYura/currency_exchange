<?php

require_once __DIR__ . '/vendor/autoload.php'; 

use Bodakyura\CurrencyExchange\Provider\ExchangeRateProvider;
use Bodakyura\CurrencyExchange\Provider\BinProvider;
use Bodakyura\CurrencyExchange\CurrencyExchange;

$currencyExchnage = new CurrencyExchange(
    new ExchangeRateProvider(),
    new BinProvider()
);

$results = $currencyExchnage->calculateCommission($argv[1]);

foreach ($results as $result) {
    echo $result . "\n";
}