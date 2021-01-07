<?php

namespace App\Utils;

class Currencies {
    
    public static function getName(string $currency_code)
    {
        $currencies = require '../resources/utils/currencies.php';
        return $currencies[$currency_code]['name'];
    }

    public static function getSymbol(string $currency_code)
    {
        $currencies = require '../resources/utils/currencies.php';
        return $currencies[$currency_code]['symbol'];
    }
}
