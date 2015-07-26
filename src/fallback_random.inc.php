<?php
/**
 * fallback_random.inc.php
 *
 * Copyright (c) 2015 algo13
 *
 * This software is released under the MIT License.
 * http://opensource.org/licenses/mit-license.php
 */
if (!defined('PHP_INT_MIN')) {
    define('PHP_INT_MIN', ~PHP_INT_MAX);
}
if (!function_exists('random_bytes')) {
    function random_bytes($length)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $crypto_strong = false;
            $bytes = openssl_random_pseudo_bytes($length, $crypto_strong); //< RAND_pseudo_bytes
            if (($bytes !== false) && ($crypto_strong === true)) {
                return $bytes;
            }
        }
        if(function_exists('mcrypt_create_iv')) {
            return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM); //< /dev/urandom
        }
        return false;
    }
}
if (!function_exists('random_int')) {
    function random_int($min = PHP_INT_MIN, $max = PHP_INT_MAX)
    {
        if ($min >= $max) {
            trigger_error('Minimum value must be less than the maximum value', E_USER_WARNING);
            return false;
        }
        $umax = $max - $min;
        $result = random_bytes(PHP_INT_SIZE);
        if ($result === false) {
            return false;
        }
        $ULONG_MAX = (PHP_INT_MAX - PHP_INT_MIN);
        $result = hexdec(bin2hex($result));
        if ($umax === $ULONG_MAX) {
            return intval($result);
        }
        $umax++;
        if (($umax & ($umax - 1)) != 0) {
            $limit = $ULONG_MAX - fmod($ULONG_MAX, $umax) - 1;
            while ($result > $limit) {
                $result = random_bytes(PHP_INT_SIZE);
                if ($result === false) {
                    return false;
                }
                $result = hexdec(bin2hex($result));
            }
        }
        return intval(fmod($result, $umax) + $min);
    }
}
