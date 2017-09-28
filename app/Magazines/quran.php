<?php

namespace App\Magazines;

use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;
use App\Page;

class quran extends Magazine
{

    public function show($u)
    {
        $page = Page::first();

        $send = new sendMessage( [
            'chat_id'      => $u->message->chat->id,
            'text'         => $this->msgText( $page ),
            'parse_mode'   => 'html',
            'reply_markup' => json_encode( [
                'inline_keyboard' => [
                    [
                        [
                            'text'          => ' صفحه بعد ◀',
                            'callback_data' => 'page/' . ( $page->id + 1 ),
                        ]
                    ],
                    [
                        [
                            'text'          => '10 صفحه بعد ⏪',
                            'callback_data' => 'page/' . ( $page->id + 10 ),
                        ]
                    ],
                    [
                        [
                            'text'          => '100 صفحه بعد ⏮',
                            'callback_data' => 'page/' . ( $page->id + 100 ),
                        ]
                    ],
                ],
            ] ),
        ] );
        if (! $send()) {
            \Storage::append( 'logs/last.json', "error: " . $send->getError() );

            return;
        }
    }

    public function pageShow($u)
    {
        
        $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>"اگر می خواهید صفحه به صفحه قرآن را ورق بزنید نمایش صفحه به صفحه را انتخاب کنید در غیر این صورت صفحه مورد نظر خود را وارد کنید ",
            'parse_mode'=> "html",
            'reply_markup'=>'{"inline_keyboard":[
				  [
				  {
				  "text":"نمایش صفحه به صفحه ",
				  "callback_data":"showpagetopage"
				  }
				  ]
		  ]
		  }'
        ]);
        $send();
    }

    public function pagetopage($u)
    {
            $i=$u->message->text;
        if ($i>0&& $i<605) {
            if ($i<10) {
                $s="00".$i;
            }
            if (10<=$i) {
                $s="0".$i;
            }
            if (100<=$i &&604>=$i) {
                $s=$i;
            }
                
            $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>"<a href='http://www.searchtruth.org/quran/images1/$s.jpg'>$s</a> ",
            'parse_mode'=> "html",
            'reply_markup'=>'{"inline_keyboard":[
				  [
				  {
				  "text":"next",
				  "callback_data":"next"
				  },
				  {
				  "text":"back",
				  "callback_data":"back"
				  }
				  ]
		  ]
		  }'
            ]);
                $send();
        } else {
            $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>" خطا \nشماره صفحه را عددی بین ۱تا ۶۰۴ انتخاب کنید ",
            'parse_mode'=> "html",
            ]);
                $send();
        }
    }
  
    public function listshow($u)
    {
        $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>"فهرست سوره ها ",
            'parse_mode'=> "html",
            'reply_markup'=> $this->keygnt(),

        ]);
        $send();
    }

    public function secendlistshow($u)
    {
        $send=new sendMessage([
            'chat_id'=>$u->callback_query->from->id,
            'text'=>"فهرست سوره ها ",
            'parse_mode'=> "html",
            'reply_markup'=> $this->nextlist(),

        ]);
        $send();
    } 
    public function gotolist($u)

    {
         $i=$u->callback_query->data;
    
            if ($i<10) {
                $s="00".$i;
            }
            if (10<=$i) {
                $s="0".$i;
            }
            if (100<=$i &&604>=$i) {
                $s=$i;
            }
        
         $send=new sendMessage([
            'chat_id'=>$u->callback_query->from->id,
            'text'=>"<a href='http://www.searchtruth.org/quran/images1/$s.jpg'>$s</a> ",
            'parse_mode'=> "html",
            'reply_markup'=>'{"inline_keyboard":[
                [
                {
                "text":"next",
                "callback_data":"next"
                },
                {
                "text":"back",
                "callback_data":"back"
                }
                ]
        ]
        }'
        ]);
        $send();
    }
    

    public function gallery($u)
    {
        
          $photo=$u->callback_query->data;
          
          if ($photo=="showpagetopage"){
              $photo="next";
              $i=001;
          }
        
        if ($photo=="next") {
           
              $i=$u->callback_query->message->text;
              $i=$i+1;
            if($i>=1 && $i<=604){
                if ($i<10) {
                    $s="00".$i;
                }
                if (10<=$i) {
                    $s="0".$i;
                }
                if (100<=$i && $i<=604) {
                    $s=$i;
                }
                    
                    $send=new editMessageText([
                    'chat_id'=>$u->callback_query->from->id,
                    'message_id'=>$u->callback_query->message->message_id,
                    'text'=>"<a href='http://www.searchtruth.org/quran/images1/$s.jpg'>$i</a> ",
                    'parse_mode'=> "html",
                    'reply_markup'=>'{"inline_keyboard":[
                    [
                    {
                    "text":"next",
                    "callback_data":"next"
                    },
                    {
                    "text":"back",
                    "callback_data":"back"
                    }
                    ]
            ]
            }'
                    ]);
                $send() ;
         }
         else {
            $send=new sendMessage([
            'chat_id'=>$u->callback_query->from->id,
            'text'=>" خطا \nصفحه بعدی وجود ندارد  ",
            'parse_mode'=> "html",
            ]);
                $send();
        }
        }
        if ($photo=="back") {
              $i=$u->callback_query->message->text;
              $i=$i-1;
            if($i>=1 && $i<=604){
                if ($i<10) {
                    $s="00".$i;
                }
                if (10<=$i) {
                    $s="0".$i;
                }
                if (100<=$i) {
                    $s=$i;
                }
                    
                    $send=new editMessageText([
                    'chat_id'=>$u->callback_query->from->id,
                    'message_id'=>$u->callback_query->message->message_id,
                    'text'=>"<a href='http://www.searchtruth.org/quran/images1/$s.jpg'>$i</a> ",
                    'parse_mode'=> "html",
                    'reply_markup'=>'{"inline_keyboard":[
                    [
                    {
                    "text":"next",
                    "callback_data":"next"
                    },
                    {
                    "text":"back",
                    "callback_data":"back"
                    }
                    ]
            ]
            }'
                    ]);
                $send() ;
            }
            else {
                $send=new sendMessage([
                'chat_id'=>$u->callback_query->from->id,
                'text'=>" خطا \nصفحه قبل وجود ندارد  ",
                'parse_mode'=> "html",
                ]);
                    $send();
            }
        }
    }
    public function goto($u, $s)
    {
        $page = Page::find( $s );

        $keys = [ ];
        if ($s + 1 <= 604) {
            $keys[0][] = [ 'text' => 'صفحه بعد ◀', 'callback_data' => 'page/' . ( $page->id + 1 ) ];
        }
        if ($s - 1 > 0) {
            $keys[0][] = [ 'text' => '▶ صفحه قبل', 'callback_data' => 'page/' . ( $page->id - 1 ) ];
        }
        if ($s + 10 <= 604) {
            $keys[1][] = [ 'text' => '10 صفحه بعد ⏪', 'callback_data' => 'page/' . ( $page->id + 10 ) ];
        }
        if ($s - 10 > 0) {
            $keys[1][] = [ 'text' => '⏩ 10 صفحه قبل', 'callback_data' => 'page/' . ( $page->id - 10 ) ];
        }
        if ($s + 100 <= 604) {
            $keys[2][] = [ 'text' => '100 صفحه بعد ⏮', 'callback_data' => 'page/' . ( $page->id + 100 ) ];
        }
        if ($s - 100 > 0) {
            $keys[2][] = [ 'text' => '⏭ 100 صفحه قبل', 'callback_data' => 'page/' . ( $page->id - 100 ) ];
        }

        $edit = new editMessageText( [
            'chat_id'      => $u->callback_query->message->chat->id,
            'message_id'   => $u->callback_query->message->message_id,
            'text'         => $this->msgText( $page ),
            'parse_mode'   => 'html',
            'reply_markup' => json_encode( [
                'inline_keyboard' => $keys,
            ] ),
        ] );
        if (! $edit()) {
            \Storage::append( 'logs/last.json', "error: " . $edit->getError() );

            return;
        }
    }

    public function msgText($page)
    {
        $msg = "سوره: " . $page->sura .
                "\n\n==============================\n" .
                str_replace( [ '<(', ')>', ',', 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ' ],
                    [
                        " «(",
                        ")» ",
                        "",
                        "\n🌸 بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ 🌸\n\n"
                    ], $page->text ) .
                "\n______________________________\n" .
                "جزء($page->chapter)\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t" .
                "صفحه($page->id)" . "\n";

        return $msg;
    }
    public function keygnt()
    {
    
            $data=\App\suraList::get();
            $keys=[];
        for ($i=2; $i<=60;$i+=3) {
			$j=$i-1;$y=$i-2;
			$keys[]='[{
				"text":"'.$data[$i]->name.'",
				"callback_data":"'.$data[$i]->start.'"
			},
			{
				"text":"'.$data[$j]->name.'",
				"callback_data":"'.$data[$j]->start.'"
			},
			{
				"text":"'.$data[$y]->name.'",
				"callback_data":"'.$data[$y]->start.'"
			}
			]';
			if ($i==59){
                $keys[]='[{
                "text":"صفحه بعد",
                "callback_data":"nextpage"    
                }]';
            }
        }
        
         return '{"inline_keyboard":['.implode(",", $keys).']}';
        
    }
    public function nextlist()
    {
            $data=\App\suraList::get();
            $keys=[];
        for ($i=62; $i<=114;$i+=3) {
			$j=$i-1;$y=$i-2;
			$keys[]='[{
				"text":"'.$data[$i]->name.'",
				"callback_data":"'.$data[$i]->start.'"
			},
			{
				"text":"'.$data[$j]->name.'",
				"callback_data":"'.$data[$j]->start.'"
			},
			{
				"text":"'.$data[$y]->name.'",
				"callback_data":"'.$data[$y]->start.'"
			}
			]';
			
             } 
            
        
         return '{"inline_keyboard":['.implode(",", $keys).']}';
        
    }
}
