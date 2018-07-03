<?php
namespace Alanmanderson\HeadCount\Services;

interface PhoneNumberHandlerInterface {
    public function normalize($number);
}