<?php

namespace Bodakyura\CurrencyExchange\Provider;

use Bodakyura\CurrencyExchange\Exception\UnsupportedCurrencyException;

class BinProvider implements BinProviderInterface {

   /**
     * @param int $bin
     * 
     * @return string
     */
    public function getAlpha(int $bin): string 
    {
        $resource = sprintf('https://lookup.binlist.net/%s', $bin);   

        $binResults = @file_get_contents($resource);

        if (!$binResults ) {
            throw new UnsupportedCurrencyException('This currency is not supported');
        }

        $result = json_decode($binResults);

        return $result->country->alpha2;
    }
}

?>