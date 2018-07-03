<?php
namespace Alanmanderson\HeadCount\Services;

class UsPhoneNumberHandler implements PhoneNumberHandlerInterface{
    public function normalize($number){
        return substr(preg_replace('/[^0-9]/', '', $number), -10);
    }
}