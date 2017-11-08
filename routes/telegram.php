<?php
use XB\theory\Shoot;
use XB\telegramMethods\sendMessage;



$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='/start';
},'start@showMenu');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='درباره ربات';
},'start@aboutUs');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='نمایش متن قرآن';
},'quran@show');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='نمایش تصویر قرآن';
},'quran@pageShow');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='فهرست سوره ها';
},'quran@listshow');

$this->trigger(function($u){
   
    return !empty ($u->callback_query->data) &&  array_search( $u->callback_query->data,["","next","back","showpagetopage"] )  ;
},'quran@gallery');//becuse didnt reeds first element i write empity element here->["","next","back"] 

if (!empty($this->detect->data->goto)){
    $this->trigger(function($u){ return true ;},$this->detect->data->goto);}

$this->trigger(function($u){
    if(empty($u->message->text)){
        return false;
    }
 
   $A=preg_match("/^\d+$/", $u->message->text, $output_array);
    return  !empty($u->message->text) && !empty($output_array) ;
 },'quran@pagetopage');

 $this->trigger(function($u){
   
    $surapage=range(0, 604);
    return !empty ($u->callback_query->data) &&  array_search( $u->callback_query->data,$surapage )  ;
},'quran@gotolist');

$this->trigger(function(&$u){
    return !empty ($u->callback_query->id) && $u->callback_query->data=="nextpage";
},'quran@secendlistshow');

$this->trigger(function(&$u){
    return !empty ($u->callback_query->id) && $u->callback_query->data=="backpage";
},'quran@listshow');

$this->trigger(function($u,&$s){
    if(empty($u->callback_query->data)){
        return false;
    }
    $data=explode('/',$u->callback_query->data);
    if($data[0]=='page' && 
        is_numeric($data[1]) &&
        $data[1]>=1 && $data[1]<=604){
            $s=(int)$data[1];
            return true;
        }
    return false;
},'quran@goto');