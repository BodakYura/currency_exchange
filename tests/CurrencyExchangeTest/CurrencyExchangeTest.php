<?php

namespace CurrencyConverterTest;

use Bodakyura\CurrencyExchange\CurrencyExchange;
use PHPUnit\Framework\TestCase;
use Bodakyura\CurrencyExchange\Provider\ExchangeRateProviderInterface;

class CurrencyExchangeTest extends TestCase {

    public function testCalculateCommission()
    {
        $testFilePath = __DIR__ . '/data/input.txt';
        $rateProvider = $this->createMock('Bodakyura\CurrencyExchange\Provider\ExchangeRateProviderInterface');
        $binProvider = $this->createMock('Bodakyura\CurrencyExchange\Provider\BinProviderInterface');

        $expectedResult = [
            1,
            0.46,
            1.43,
            2.4,
            45.08,
        ]; 

        $mapBin = [
            [45717360, 'DK'],
            [516793, 'LT'],
            [45417360, 'JP'],
            [41417360, 'US'],
            [4745030, 'GB']
        ];

        $mapRate = [
            ['EUR', ExchangeRateProviderInterface::EUR_CODE, 1,], 
            ['USD', ExchangeRateProviderInterface::EUR_CODE, 1.082], 
            ['JPY', ExchangeRateProviderInterface::EUR_CODE, 140.3114], 
            ['USD', ExchangeRateProviderInterface::EUR_CODE, 1.082], 
            ['GBP', ExchangeRateProviderInterface::EUR_CODE, 0.8873]
        ];

        $rateProvider->expects($this->any())
            ->method('getRate')
            ->will($this->returnValueMap($mapRate));
        
        $binProvider->expects($this->any())
            ->method('getAlpha')
            ->will($this->returnValueMap($mapBin));   
        
        $currencyExchange = new CurrencyExchange($rateProvider, $binProvider);   

        $this->assertEmpty(array_diff($expectedResult, $currencyExchange->calculateCommission($testFilePath)));
    }
}

?>