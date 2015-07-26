# php-random
Failback for PHP5 of added CSPRNG Functions(ramdom_byte(), ramdom_int()) in PHP7. and better shuffle functions.

## Features
* `src/fallback_random.inc.php` (Failback for PHP5)
  ```
  define PHP_INT_MIN
  string random_bytes(int $length)
  int random_int(int $min , int $max)
  ```

* `src/array_random.inc.php` (array_rand() with ...)
  ```
   int mt_array_rand(array $array, $num = 1)
   int array_random(array $array, $num = 1)
   int array_random_callback(array $array, callable $callback, $num = 1)
  ```

* `src/random_shuffle.inc.php` (shuffle(), str_shuffle() with ...)
  ```
  bool random_shuffle_callback(array &$array, callable $callback) //< shuffle() with callback function.
  bool mt_shuffle(array &$array) //< shuffle() with mt_rand().
  bool random_shuffle(array &$array) //< shuffle() with random_int().
  string str_random_shuffle_callback($str, callable $callback) //< str_shuffle() with callback function.
  string mt_str_shuffle(string $str) //< str_shuffle() with random_int().
  string str_random_shuffle(string $str) //< str_shuffle() with random_int().
  string mb_str_random_shuffle_callback(string $str, callable $callback, string $encoding = mb_internal_encoding())
  string mb_mt_str_shuffle(string $str, string $encoding = mb_internal_encoding())
  string mb_str_random_shuffle(string $str, string $encoding = mb_internal_encoding())
  ```

## Getting Started
```
require_once 'php-ramdom/src/fallback_random.inc.php';
require_once 'php-ramdom/src/array_random.inc.php';
require_once 'php-ramdom/src/random_shuffle.inc.php';
```

## See Also
* [ramdom_int()](http://php.net/manual/function.random-int.php)
* [ramdom_byte()](http://php.net/manual/function.random-bytes.php)
* [mt_rand()](http://php.net/manual/function.mt-rand.php)
* [array_rand()](http://php.net/manual/function.array-rand.php)
* [shuffle()](http://php.net/manual/function.shuffle.php)
* [str_shuffle()](http://php.net/manual/function.str-shuffle.php)


## License
php-ramdom is licensed under the MIT license.
