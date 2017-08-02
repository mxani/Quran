<?php

namespace App\Magazines;

use XB\theory\Magazine;
use XB\theory\telegramCollection;
use XB\telegramMethods\sendMessage;
use XB\telegramObjects\ReplyKeyboardMarkup;
use XB\telegramObjects\KeyboardButton;

class start extends Magazine{
    public function showMenu($u){
        $send=new sendMessage([
            'chat_id'=>$u->message->chat->id,
            'text'=>"<b>welcome</b> ".time(),
            'parse_mode'=>'html',
            'reply_markup'=>json_encode([
                'keyboard'=>[
                    ['ختم قران'],
                    ['ختم صلوات'],
                    ['نمایش قرآن'],
                    ['درباره ما'],
                ],
                'resize_keyboard'=>true,
                'one_time_keyboard'=>true,
            ]),
        ]);
        if(!$send()){
            \Storage::append('updates/last.json',"error: ".$send->getError());
        }
        
    }
    public function aboutUs($u){
        $send=new sendMessage([
            'chat_id'=>$u->message->chat->id,
            'text'=>"<b>about us</b> ".time(),
            'parse_mode'=>'html',
        ]);
        if(!$send()){
            \Storage::append('updates/last.json',"error: ".$send->getError());
        }
        
    }

}