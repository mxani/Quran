{
    "inline_keyboard":[
    
    @for($i=0;$i<=1;$i+=3)
   

    [
                {
                    "text":"{{$data[$i]->name}}",
                    "callback_data":"{{ interlink(["id"=>$data[$i]->start,"goto"=>"quran@gotolist"])}}"
                },
                {
                    "text":"{{$data[$i+1]->name}}",
                    "callback_data":"{{ interlink(["id"=>$data[$i+1]->start,"goto"=>"quran@gotolist"])}}"
                }, 
                 {
                    "text":"{{$data[$i+2]->name}}",
                    "callback_data":"{{ interlink(["id"=>$data[$i+2]->start,"goto"=>"quran@gotolist"])}}"
                }
    ]
    @endfor
    ]
} 