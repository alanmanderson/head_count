<?php
namespace Alanmanderson\HeadCount\Services;

class NexmoInboundSms {
    public $type, $to, $from, $messageId, $messageTimestamp, $text, $keyword;
    public function __construct($type, $to, $from, $messageId, $messageTimestamp, $text, $keyword){
        $this->type = $type;
        $this->to = $to;
        $this->from = $from;
        $this->messageId = $messageId;
        $this->messageTimestamp = $messageTimestamp;
        $this->text = $text;
        $this->keyword = $keyword;
    }
}