<?php

namespace App\Magazines;

use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;
use App\Page;

class quran extends Magazine
{
    public function erorr($u)
    {
    $send=new sendMessage([
        'chat_id'=>$u->message->from->id,
        'text'=>" ❌خطا ❌\nشماره صفحه را عددی بین ۱تا ۶۰۴ انتخاب کنید ",
        'parse_mode'=> "html",
        ]);
            $send();
    }

    public function pageShow($u)
    {
        $this->share["tex"]="✔️شماره صفحه مورد نظر خود را وارد کنید ؟ \n\n📌در قسمت'جستجوی صفحات' شما می توانید در هر مرحله که باشید شماره صفحه را وارد کنید و صفحه مورد نظر خود را مشاهده کنید ";
        $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>$this->share['tex'],
            'parse_mode'=> "html",
        ]);
        $send();
       
    }


    public function pagetopage($u)
    {  
        if (!empty($u->message->text) && !empty($this->share['tex']) && $u->message->text!=='🔎جستجوی صفحات')
        {
       
        $A=preg_match("/^\d+$/", $u->message->text, $output_array);
        if(empty($output_array)){
            $this->erorr($u);
        }
         }
        $data=\App\suraList::get();

        if(empty($this->detect->data))
        {
            $i=$u->message->text;
            
        }
        else{ 
            $i=$this->detect->data->text;
           
        }$s=0;
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
            if( $u->message->text!=='🤖درباره ربات' && $u->message->text!=='🔎جستجوی صفحات' && $u->message->text!=='📋فهرست سوره ها')
            {  
            $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>" ❌خطا ❌\nشماره صفحه را عددی بین ۱تا ۶۰۴ انتخاب کنید ",
            'parse_mode'=> "html",
            ]);
                $send();
            }return;
        }
            $sureh=\App\Page::where("id",">=",$i)->get()->first()->sura;
            $secsure=explode(",",$sureh);
            if(!empty($secsure[1]))
            { 
                $sureh=$secsure[1];
            }
            $tedad=\App\suraList::where("name",$sureh)->get()->first()->verses;
        $text="<a href='http://www.searchtruth.org/quran/images1/$s.jpg'>🌸سوره مبارکه:$sureh 🌸</a>\n ".
        "▪️"."جزء:".\App\Page::where("id",$i)->get()->first()->chapter.
        "                                              ".
        "📝"."صفحه:".$i."\n".
        " ▪️"."تعداد آیات:".$tedad."\n";
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
        $send=new sendMessage([
        'chat_id'=>$u->message->from->id,
        'text'=>$text,
        'parse_mode'=> "html",
        'reply_markup'=>$this->kgnt1($i)
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
                'text'=>" 📋فهرست سوره ها: ",
                'parse_mode'=> "html",
                'reply_markup'=> $this->keygnt(),
    
            ]);
            $send();   
        }
        else{ 
        $send=new sendMessage([
            'chat_id'=>$u->message->from->id,
            'text'=>" 📋فهرست سوره ها: ",
            'parse_mode'=> "html",
            'reply_markup'=> $this->keygnt(),

        ]);
        $send();
        }
    } 

    public function goto($u)
    {
       
        $i=$this->detect->data->page;
        $page=\App\Page::where("id",$i)->get()->first();
       

        $edit = new editMessageText( [
            'chat_id'      => $u->callback_query->message->chat->id,
            'message_id'   => $u->callback_query->message->message_id,
            'text'         => $this->msgText($page),
            'parse_mode'   => 'html',
            'reply_markup'=> $this->kgnt1($i),
        ] );
        if (! $edit()) {
            \Storage::append( 'logs/last.json', "error: " . $edit->getError() );

            return;
        }
    }

    public function msgText($page)
    {
        $msg = "سوره:🌼🌺 " . $page->sura ."🌼🌺".
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
                    "text"=>" ▶️صفحه قبل ",
                    "callback_data"=>interlink([
                        "goto"=>"quran@listshow",
                        "text"=>"next".$b])  
                    ]
                    ];        
            }

            elseif($x==1){
                $keys[]=[
                    [
                    "text"=>"صفحه بعد ◀️",
                    "callback_data"=>interlink([
                        "goto"=>"quran@listshow",
                        "text"=>"next".$x])  
                    ]
                    ];
            }
           else{   
          
            $keys[]=[
                [
                "text"=>"صفحه بعد ◀️",
                "callback_data"=>interlink([
                    "goto"=>"quran@listshow",
                    "text"=>"next".$x])  
                ],
                [
                    "text"=>" ▶️ صفحه قبل",
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
        if (!empty($this->detect->data->text)||empty($this->detect->data)){  
              $keys[]=[
        
                   [
                    "text"=>"نمایش متن",
                    "callback_data"=>interlink([
                        "goto"=>"quran@goto",
                        "page"=>$i])  
                    ]
                           ]; 
          if ($i>1 && $i<604){                  
                $keys[]=[
                    [
                    "text"=>"صفحه بعد◀️",
                    "callback_data"=>interlink([
                        "goto"=>"quran@pagetopage",
                        "text"=>$i+1])  
                    ],
                    [
                        "text"=>"▶️صفحه قبل",
                        "callback_data"=>interlink([
                            "goto"=>"quran@pagetopage",
                            "text"=>$i-1])  
                        ]
                ];           
            }
          elseif($i=1){
            $keys[]=[
                [
                "text"=>"صفحه بعد◀️",
                "callback_data"=>interlink([
                    "goto"=>"quran@pagetopage",
                    "text"=>$i+1])  
                ]
                ];
           }
           elseif($i=604){
            $keys[]=[
                [
                    "text"=>"▶️صفحه قبل",
                    "callback_data"=>interlink([
                        "goto"=>"quran@pagetopage",
                        "text"=>$i-1])  
                    ]
            ]; 
           }

            }
   
        if(!empty($this->detect->data->page)){
            $keys[]=[
                
                [
                    "text"=>"↪️بازگشت به نمایش تصویر",
                    "callback_data"=>interlink([
                        "goto"=>"quran@pagetopage",
                        "text"=>$i])  
                    ]
                    ];  
            $keys[]=[
                [
                "text"=>"صفحه بعد◀️",
                "callback_data"=>interlink([
                    "goto"=>"quran@goto",
                    "page"=>$i+1])  
                ],
                [
                    "text"=>"▶️صفحه قبل",
                    "callback_data"=>interlink([
                        "goto"=>"quran@goto",
                        "page"=>$i-1])  
                    ]
                    ];        
        }
       
         return json_encode(["inline_keyboard"=>$keys]);
    }    

}
