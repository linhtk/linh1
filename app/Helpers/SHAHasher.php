<?php
namespace App\Helpers;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class SHAHasher implements HasherContract {

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @return array   $options
     * @return string
     */
    public function make($value, array $options = array()) {
        $salt = config('const.const_salt');
        return hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256', $value, $salt),$salt),$salt),$salt),$salt);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = array()) {
        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array()) {
        return false;
    }

}
