<?php

namespace App\Magazines;

use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;
use App\Page;

class quran extends Magazine{
    public function show($u){
        $page= Page::first();
        // echo $this->sura;
        $text="☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\nجزء($page->chapter)\n☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\n".
        str_replace(['<','>','بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ'],
        ['(',')',"\n🌸🌸🌸🌸🌸🌸🌸🌸🌸\nبِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ\n🌸🌸🌸🌸🌸🌸🌸🌸🌸\n"],$page->text).
        "\n☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\nصفحه($page->id)\n☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\n";
        
        $send=new sendMessage([
            'chat_id'=>$u->message->chat->id,
            'text'=>$text,
            'parse_mode'=>'html',
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        [
                            'text'=>'◀️','callback_data'=>'page/'.($page->id+1),
                        ]
                    ],
                    [
                        [
                            'text'=>'⏪','callback_data'=>'page/'.($page->id+10),
                        ]
                    ],
                    [
                        [
                            'text'=>'⏮','callback_data'=>'page/'.($page->id+100),
                        ]
                    ],
                ],
            ]),
        ]);
        if(!$send()){
            \Storage::append('logs/last.json',"error: ".$send->getError());
            return ;
        }
    }
    public function goto($u,$s){
        $page= Page::find($s);
        // echo $this->sura;
        $text="☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\nجزء($page->chapter)\n☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\n".
        str_replace(['<','>','بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ'],
        ['(',')',"\n🌸🌸🌸🌸🌸🌸🌸🌸🌸\nبِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ\n🌸🌸🌸🌸🌸🌸🌸🌸🌸\n"],$page->text).
        "\n☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\nصفحه($page->id)\n☘️☘️☘️☘️☘️☘️☘️☘️☘️☘️☘\n";
        
        $edit=new editMessageText([
            'chat_id'=>$u->callback_query->message->chat->id,
            'message_id'=>$u->callback_query->message->message_id,
            'text'=>$text,
            'parse_mode'=>'html',
        ]);
        if(!$edit()){
            \Storage::append('logs/last.json',"error: ".$edit->getError());
            return ;
        }

        $keys=[];
        if($s+1<=604){
            $keys[0][]=['text'=>'◀️','callback_data'=>'page/'.($page->id+1)];
        }
        if($s-1>0){
            $keys[0][]=['text'=>'▶️','callback_data'=>'page/'.($page->id-1)];
        }
        if($s+10<=604){
            $keys[1][]=['text'=>'⏪','callback_data'=>'page/'.($page->id+10)];
        }
        if($s-10>0){
            $keys[1][]=['text'=>'⏩','callback_data'=>'page/'.($page->id-10)];
        }
        if($s+100<=604){
            $keys[2][]=['text'=>'⏮','callback_data'=>'page/'.($page->id+100)];
        }
        if($s-100>0){
            $keys[2][]=['text'=>'⏭','callback_data'=>'page/'.($page->id-100)];
        }

        $edit=new editMessageReplyMarkup([
            'chat_id'=>$u->callback_query->message->chat->id,
            'message_id'=>$u->callback_query->message->message_id,
            'reply_markup'=>json_encode([
                'inline_keyboard'=>$keys,
            ]),
        ]);
        if(!$edit()){
            \Storage::append('logs/last.json',"error: ".$edit->getError());
            return ;
        }
    }
}