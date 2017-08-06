<?php
use XB\theory\Shoot;
// use XB\theory\telegramCollection;
// use XB\telegramMethods\sendMessage;
// // use XB\telegramObjects\InlineKeyboardMarkup;
// use XB\telegramObjects\InlineKeyboardButton;

$this->trigger(function($u){
    return true;
},function($u){
    Storage::put("updates/last.json", "$u\n\n".
    file_get_contents('php://input')."\n\n"
    );
});

/*
$this->trigger(function($u){return true;},function($u){
    empty($u->message->from->first_name)  or print "\nmessage:".$u->message->from->first_name;
    empty($u->callback_query->from->first_name)  or print "\ncallback_query:".$u->callback_query->from->first_name;
    // print_r($u);die();
    });//*/

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='/start';
},'start@showMenu');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='درباره ما';
},'start@aboutUs');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='نمایش قرآن';
},'quran@show');

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