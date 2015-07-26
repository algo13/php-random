<?php
/**
 * random_shuffle.inc.php
 *
 * Copyright (c) 2015 algo13
 *
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */
/*
[standard/array]shuffle()
bool random_shuffle_callback(array &$array, callable $callback): shuffle() with callback function.
bool mt_shuffle(array &$array): shuffle() with mt_rand().
if (function_exists('ramdom_int')) {
    bool random_shuffle(array &$array): shuffle() with random_int().
}

[standard/string]str_shuffle()
string str_random_shuffle_callback($str, callable $callback): str_shuffle() with callback function.
string mt_str_shuffle(string $str): str_shuffle() with random_int().
if (function_exists('ramdom_int')) {
    string str_random_shuffle(string $str): str_shuffle() with random_int().
}

[mbstring/mbstring] shuffle(), str_shuffle()
if (extension_loaded('mbstring')) {
    string mb_str_random_shuffle_callback(string $str, callable $callback, string $encoding = mb_internal_encoding())
    string mb_mt_str_shuffle(string $str, string $encoding = mb_internal_encoding())
    if (function_exists('ramdom_int')) {
        string mb_str_random_shuffle(string $str, string $encoding = mb_internal_encoding())
    }
}
*/
function random_shuffle_callback(array &$array, callable $callback)
{
    if (!is_callable($callback)) {
        trigger_error('expects parameter 2 to be a valid callback, no array or string given', E_USER_WARNING);
        return false;
    }
    $array = array_values($array);
    $count = count($array);
    if ($count <= 1) {
        return false;
    }
    while (--$count) {
        $random = $callback($count);
        if ($random === false) {
            return false;
        }
        if($count !== $random) {
            //swap: list($array[$count], $array[$random]) = array($array[$count], $array[$random]);
            $tmp = $array[$count];
            $array[$count] = $array[$random];
            $array[$random] = $tmp;
        }
    }
    return true;
}
function mt_shuffle(array &$array)
{
    return random_shuffle_callback($array, function($max) { return mt_rand(0, $max); });
}
if (function_exists('ramdom_int')) {
    function random_shuffle(array &$array)
    {
        return random_shuffle_callback($array, function($max) { return ramdom_int(0, $max) ?: mt_rand(0, $max); });
    }
}
function str_random_shuffle_callback($str, callable $callback)
{
    $array = str_split($str);
    if (random_shuffle_callback($array, $callback)) {
        return implode('', $array);
    }
    return false;
}
function mt_str_shuffle($str)
{
    return str_random_shuffle_callback($array, function($max) { return mt_rand(0, $max); });
}
if (function_exists('ramdom_int')) {
    function str_random_shuffle($str)
    {
        return str_random_shuffle_callback($array, function($max) { return ramdom_int(0, $max) ?: mt_rand(0, $max); });
    }
}
if (extension_loaded('mbstring')) {
    function mb_str_random_shuffle_callback($str, callable $callback, $encoding = null)
    {
        if (func_num_args() < 3) {
            $encoding = mb_internal_encoding();
        }
        $array = array();
        {   // BLOCK:$array = mb_str_split($str, $encoding);
            $len = mb_strlen($str, $encoding);
            if ($len === false) {
                return false;
            }
            for ($start = 0; $start < $len; ++$start) {
                $array[] = mb_substr($str, $start, 1, $encoding);
            }
        }
        if (random_shuffle_callback($array, $callback)) {
            return implode('', $array);
        }
        return false;
    }
    function mb_mt_str_shuffle($str, $encoding = null)
    {
        return (func_num_args() < 2)
            ? mb_str_random_shuffle_callback($str, function($max) { return mt_rand(0, $max); })
            : mb_str_random_shuffle_callback($str, function($max) { return mt_rand(0, $max); }, $encoding);
    }
    if (function_exists('ramdom_int')) {
        function mb_str_random_shuffle($str, $encoding = null)
        {
            return (func_num_args() < 2)
                ? mb_str_random_shuffle_callback($str, function($max) { return ramdom_int(0, $max) ?: mt_rand(0, $max); })
                : mb_str_random_shuffle_callback($str, function($max) { return ramdom_int(0, $max) ?: mt_rand(0, $max); }, $encoding);
        }
    }
}
