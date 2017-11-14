<?php
use XB\theory\Shoot;
use XB\telegramMethods\sendMessage;



$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='/start';
},'start@showMenu');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='🤖درباره ربات';
},'start@aboutUs');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='🔎جستجوی صفحات';
},'quran@pageShow');

$this->trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='📋فهرست سوره ها';
},'quran@listshow');


if (!empty($this->detect->data->goto)){
    $this->trigger(function($u){ return true ;},$this->detect->data->goto);}

$this->trigger(function($u){
    if(empty($u->message->text)){
        return false;}
    return !empty($u->message->text) ;
 },'quran@pagetopage');

$this->trigger(function($u){
    return !empty ($u->callback_query->id) && $u->callback_query->data=="backpage";
},'quran@listshow');