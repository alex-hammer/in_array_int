<?php

class Tools
{
    public static function formatSeconds($iSeconds) {
        return number_format($iSeconds, 10, ".", " ");
    }

    public static function formatBytes($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');

        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
}
