<?php

namespace Bodakyura\CurrencyExchange\Provider;

interface BinProviderInterface {

    /**
     * @param int $bin
     * 
     * @return string
     */
    public function getAlpha(int $bin): string;    
}

?>