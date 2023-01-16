<?php

namespace Bodakyura\CurrencyExchange;

use Bodakyura\CurrencyExchange\Provider\ExchangeRateProviderInterface;
use Bodakyura\CurrencyExchange\Provider\BinProviderInterface;

class CurrencyExchange {

    /**
     * @var ExchangeRateProviderInterface
     */
    private $exchangeRateProvider;

    /**
     * @var BinProviderInterface
     */
    private $binProvider;
    
    public function __construct(
        ExchangeRateProviderInterface $exchangeRateProvider,
        BinProviderInterface $binProvider
    ) {
        $this->exchangeRateProvider = $exchangeRateProvider;
        $this->binProvider = $binProvider;
    }

    public function calculateCommission(string $filePath): array
    {
        $result = [];
        
        foreach (explode("\n", file_get_contents($filePath)) as $row) {

            if (empty($row)) continue;
        
            try {
                $data = json_decode($row, false, 512, JSON_THROW_ON_ERROR);
            
                $alpha = $this->binProvider->getAlpha($data->bin);
            
                $isEu = $this->isEu($alpha);    
            
                $rate = $this->exchangeRateProvider->getRate($data->currency, ExchangeRateProviderInterface::EUR_CODE);   
                
                $amount = $data->amount;

               if ($rate > 0) {
                    $amount = $data->amount / $rate;
               }

               $commssion = $amount * ($isEu ? 0.01 : 0.02); 
        
               $result[] = round($commssion, 2, PHP_ROUND_HALF_UP);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        return $result;
    }

    /**
     * @param string $currencyCode
     * 
     * @return bool
     */
    private function isEu(string $currencyCode): bool 
    {
        $euCurrencies = [
            'AT',
            'BE',
            'BG',
            'CY',
            'CZ',
            'DE',
            'DK',
            'EE',
            'ES',
            'FI',
            'FR',
            'GR',
            'HR',
            'HU',
            'IE',
            'IT',
            'LT',
            'LU',
            'LV',
            'MT',
            'NL',
            'PO',
            'PT',
            'RO',
            'SE',
            'SI',
            'SK',
        ];

        if (in_array($currencyCode, $euCurrencies)) {
            return true;
        }

        return false;
    }
}

?>