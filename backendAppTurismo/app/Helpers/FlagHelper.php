<?php

if (!function_exists('getFlagEmoji')) {
    function getFlagEmoji($iso)
    {
        $iso = strtoupper($iso);

        return mb_chr(127397 + ord($iso[0]), 'UTF-8') .
               mb_chr(127397 + ord($iso[1]), 'UTF-8');
    }
}
