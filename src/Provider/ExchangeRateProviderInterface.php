<?php

namespace Bodakyura\CurrencyExchange\Provider;

interface ExchangeRateProviderInterface {

    public const EUR_CODE = 'EUR';

    /**
     * @param string $currency
     * @param string $baseCurrency
     * 
     * @return float
     */
    public function getRate(string $currency, string $baseCurrency): float;

}

?>