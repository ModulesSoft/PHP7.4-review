<?php
function randomName(string $extention)
{
    if (!$extention) {
        die('image extention not found!');
    }
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle($characters), -10) . '.' . $extention;
}
