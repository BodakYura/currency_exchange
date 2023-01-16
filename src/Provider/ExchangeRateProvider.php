<?php

namespace Bodakyura\CurrencyExchange\Provider;

use Bodakyura\CurrencyExchange\Exception\UnsupportedCurrencyException;

class ExchangeRateProvider implements ExchangeRateProviderInterface {

    private const ACCESS_KEY = '6d1b58970118e41433783523';

    /**
     * @param string $currency
     * @param string $baseCurrency
     * 
     * @return float
     */
    public function getRate(string $currency, string $baseCurrency): float 
    {
        $resource = sprintf('https://v6.exchangerate-api.com/v6/%s/latest/%s', self::ACCESS_KEY, $baseCurrency);    
        $result = @file_get_contents($resource);
        $rates = @json_decode($result, true)['conversion_rates'];

        if (!isset($rates[$currency])) {
            throw new UnsupportedCurrencyException('This currency is not supported');
        }

        return @json_decode($result, true)['conversion_rates'][$currency];
    }
}

?>