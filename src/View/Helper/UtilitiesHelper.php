<?php

namespace App\View\Helper;

use Cake\View\Helper;

class UtilitiesHelper extends Helper
{
    
    /**
     * 
     * @param type $number
     * @param type $options
     * @return type
     */
    public function formatCurrency($number, $options = []) {
        
        if(is_numeric($number)) {
            $decimal = count(explode('.' , $number)) == 2 ? 2: 0;
            $decimal = (isset($options['places']) && $options['places']) ? $options['places'] : $decimal;
            
            $return = number_format($number, $decimal, '.', ' ') . ' €';
            
            $return .= isset($options['after']) ? $options['after'] : '';
            return $return;
        } else {
            $number = 0;
        }
        return $number . ' €';
    }
    
    /**
     * 
     * @param type $number
     * @param type $options
     * @return type
     */
    public function formatNumber($number, $options = []) {
        
        if($number) {
            $decimal = count(explode('.' , $number)) == 2 ?2: 0;
            $decimal = (isset($options['places']) && $options['places']) ? $options['places'] : $decimal;
            
            $return = number_format($number, $decimal, '.', ' ');
            
            $return .= isset($options['after']) ? $options['after'] : '';
            return $return;
        }
        return $number;
    }
    
    /**
     * 
     * @param type $number
     * @param type $options
     * @return type
     */
    public function formatCurencyPdf($number, $options = []) {
        
        if($number) {
            
            $decimal = (isset($options['places']) && $options['places']) ? $options['places'] : 2;
            
            $return = number_format($number, $decimal, '.', ' ');
            
            $return .= isset($options['after']) ? $options['after'] : '';
            return $return;
        }
        return $number;
    }
}