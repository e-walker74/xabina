<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 29.09.14
 * Time: 22:08
 */

class FileService {

    public static function fromBytes($size){
        $k = $size / 1024;
        $m = $k / 1024;
        $g = $m / 1024;
        if($k <= 0.1){
            return number_format($size, 1, '.', ' ') . 'b';
        } elseif($k > 0.1){
            return number_format($k, 1, '.', ' ') . 'kb';
        } elseif($m > 0.1) {
            return number_format($k, 1, '.', ' ') . 'mb';
        } elseif($g > 0.1) {
            return number_format($g, 1, '.', ' ') . 'gb';
        }
    }

    private static function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

} 