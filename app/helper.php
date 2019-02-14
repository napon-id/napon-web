<?php

if(!function_exists('currency')) {
    function formatCurrency($number, $currency = 'IDR')
    {
        if($currency == 'USD') {
            return number_format($number, 2, '.', ',');
        }
        return 'Rp. ' . number_format($number, 2, ',', '.');
    }
}
?>
