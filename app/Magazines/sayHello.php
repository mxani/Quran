<?php

namespace App\Magazines;

use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;

class sayHello extends Magazine{
    public function test($u){
        $send=new sendMessage([
            'chat_id'=>$u->message->chat->id,
            'text'=>"===========\nHELLO. 🤝\n===========",
            'parse_mode'=>'html',
        ]);
        $send();
    }

}