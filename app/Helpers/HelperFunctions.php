<?php
namespace App\Helpers;

class HelperFunctions
{
    public static function generateRandomPassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=';
        return substr(str_shuffle($chars), 0, $length);
    }
}