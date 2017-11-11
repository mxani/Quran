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
    
        $data=\App\suraList::get();

        if(empty($this->detect->data))
        {
            $i=$u->message->text;
            
        }
        else{ 
            $i=$this->detect->data->text;
           
        }
        $sureh=\App\suraList::where("start",">=",$i)->get()->first();
   dd($sureh);
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
        }  
        else {
            $send=new editMessageText([
            'chat_id'=>$u->message->from->id,
            'text'=>" خطا \nشماره صفحه را عددی بین ۱تا ۶۰۴ انتخاب کنید ",
            'parse_mode'=> "html",
            ]);
                $send();
            }
        $text="<a href='http://www.searchtruth.org/quran/images1/$s.jpg'>🌸🌼سوره مبارکه:$sureh->name 🌸🌼</a>\n ".
        "▪️"."جزء:".\App\Page::where("id",$i)->get()->first()->chapter.
        "                                              ".
        "📝"."صفحه:".$i."\n".
        " ▪️"."تعداد آیات:".$sureh->verses."\n";
        if ($this->detect->type=='callback_query'){
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>$text,
                'parse_mode'=> "html",
                'reply_markup'=> $this->kgnt1($i),
                ]);
                    $send();
        }
        else{      
        $send=new editMessageText([
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
    }

    
    }
  
    public function listshow($u)
    {
        if ($this->detect->type=='callback_query'){
            $send=new editMessageText([
                'chat_id'=>$this->update->callback_query->message->chat->id,
                'message_id'=>$this->update->callback_query->message->message_id,
                'text'=>"فهرست سوره ها ",
                'parse_mode'=> "html",
                'reply_markup'=> $this->keygnt(),
    
            ]);
            $send();   
        }
        else{ 
        $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>"فهرست سوره ها ",
            'parse_mode'=> "html",
            'reply_markup'=> $this->keygnt(),

        ]);
        $send();
        }
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
    
           
      if (!empty ($this->detect->data) && $this->detect->data->text=="next"."1")
      {
      $valuei=31;
      $max=56;
      $x=2;$b=0;
      }
      elseif(!empty ($this->detect->data) && $this->detect->data->text=="next"."2")
      {
        $valuei=59;
        $max=84;
       $x=3;
       $b=1;
      }
      elseif(!empty ($this->detect->data) && $this->detect->data->text=="next"."3")
      { 
        $valuei=87;
        $max=112;
        $x=4;$b=2;
      }
      else{
        $valuei=3;
        $max=28;
        $b=0;
        $x=1;
      }
     
        for ($i=$valuei; $i<=$max;$i+=4) {
            // $j=$i-1;$y=$i-2;
			$keys[]=[

                [
				"text"=>$data[$i]->name,
				"callback_data"=>interlink([
                    "goto"=>"quran@pagetopage",
                    "text"=>$data[$i]->start])
                ],
			[
				"text"=>$data[$i-1]->name,
				"callback_data"=>interlink([
                    "goto"=>"quran@pagetopage",
                    "text"=>$data[$i-1]->start])
                    
            ],
			[
				"text"=>$data[$i-2]->name,
				"callback_data"=>interlink([
                    "goto"=>"quran@pagetopage",
                    "text"=>$data[$i-2]->start])
            ],
            [
				"text"=>$data[$i-3]->name,
				"callback_data"=>interlink([
                    "goto"=>"quran@pagetopage",
                    "text"=>$data[$i-3]->start])  
            ]
			]; 
            }
            if($x==4)
            {
                $keys[]=[
                        
                    [
                        "text"=>$data[112]->name,
                        "callback_data"=>interlink([
                            "goto"=>"quran@pagetopage",
                            "text"=>$data[112]->strat])
                        ],
                    [
                        "text"=>$data[113]->name,
                        "callback_data"=>interlink([
                            "goto"=>"quran@pagetopage",
                            "text"=>$data[113]->strat])
                    ]
                        ];
                $keys[]=[
                    [
                    "text"=>" صفحه قبل",
                    "callback_data"=>interlink([
                        "goto"=>"quran@listshow",
                        "text"=>"next".$b])  
                    ]
                    ];        
            }

            elseif($x==1){
                $keys[]=[
                    [
                    "text"=>"صفحه بعد",
                    "callback_data"=>interlink([
                        "goto"=>"quran@listshow",
                        "text"=>"next".$x])  
                    ]
                    ];
            }
           else{   
          
            $keys[]=[
                [
                "text"=>"صفحه بعد",
                "callback_data"=>interlink([
                    "goto"=>"quran@listshow",
                    "text"=>"next".$x])  
                ],
                [
                    "text"=>"صفحه قبل",
                    "callback_data"=>interlink([
                        "goto"=>"quran@listshow",
                        "text"=>"next".$b])  
                    ]
             ];

            } 
         return json_encode(["inline_keyboard"=>$keys]);
        
    }

    public function kgnt1($i)
    {
        $keys[]=[
            [
            "text"=>"صفحه بعد",
            "callback_data"=>interlink([
                "goto"=>"quran@pagetopage",
                "text"=>$i+1])  
            ],
            [
                "text"=>"صفحه قبل",
                "callback_data"=>interlink([
                    "goto"=>"quran@pagetopage",
                    "text"=>$i-1])  
                ]
         ];
         return json_encode(["inline_keyboard"=>$keys]);
    }    

}
