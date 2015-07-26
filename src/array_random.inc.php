<?php
/**
 * array_random.inc.php
 *
 * Copyright (c) 2015 algo13
 *
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */
/*
[standard/array]
mt_array_rand(): array_rand() with mt_rand().
array_random(): array_rand() with random_int().
array_random_callback(): array_rand() with callback function.
*/
function array_random_callback(array $array, callable $callback, $num = 1)
{
    if (!is_callable($callback)) {
        trigger_error('expects parameter 2 to be a valid callback, no array or string given', E_USER_WARNING);
        return null;
    }
    $num = intval($num);
    $count = count($array);
    if ($num <= 0 || $count < $num) {
        trigger_error('Second argument has to be between 1 and the number of elements in the array', E_USER_WARNING);
        return null;
    }
    $result = [];
    foreach (array_keys($array) as $key) {
        $random = $callback();
        if ($random === false) {
            return false;
        }
        if (floatval($random) < (floatval($num) / floatval($count))) {
            $result[] = $key;
            if (!--$num) {
              break;
            }
        }
        --$count;
    }
    return isset($result[1]) ? $result : $result[0];
}
function mt_array_rand(array $array, $num = 1)
{
    return array_random_callback(
        $array,
        function() {
            return (floatval(mt_rand()) / floatval(mt_getrandmax() + 1.0));
        },
        $num
    );
}
if (function_exists('ramdom_int')) {
    function array_random(array $array, $num = 1)
    {
        return array_random_callback(
            $array,
            function() {
                $ramdom = ramdom_int();
                return ($ramdom !== false)
                    ? (floatval($ramdom) / floatval(PHP_INT_MAX + 1.0))
                    : (floatval(mt_rand()) / floatval(mt_getrandmax() + 1.0));
            },
            $num
        );
    }
}
