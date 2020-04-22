<?php

namespace Isystems\Helpers;

class CustomHelper {

    public static function prepUrl($url) {
        if($url === 'http://' || $url === '')
            return '';

        $parse = parse_url($url);

        if(!$parse || !isset($parse['scheme']))
            $url = 'http://' . $url;

        return $url;
    }

    public static function cutString($str = '', $min = 3, $max = 15) {
        if(!$str)
            return $str;

        $len = mb_strlen($str);

        if($len <= $min || $len < $max)
            return $str;

        $result = '';
        for($i = 0; $i < $max; $i++) {
            $result .= $str[$i];
            if(mb_strlen($result) > $max - 2) {
                if(strpos($str, ' ')) {
                    $result = substr($str, strpos($str, ' '));
                } else {
                    $result = substr($str, 0, $max - 2);
                }

                break;
            }
        }
        return $result . '..';
    }

    static function clearString($str = '') {
        if($str === '')
            return '';

        $result = strip_tags(trim(str_replace(array('>', '<'), '', $str)));
        return $result;
    }
}