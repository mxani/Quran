<?php
use XB\theory\Shoot;
// use XB\theory\telegramCollection;
// use XB\telegramMethods\sendMessage;
// // use XB\telegramObjects\InlineKeyboardMarkup;
// use XB\telegramObjects\InlineKeyboardButton;

Shoot::trigger(function($u){
    return true;
},function($u){
    Storage::put("updates/last.json", "$u\n\n".
    file_get_contents('php://input')."\n\n"
    );
});

// Shoot::trigger(function($u){return true;},'sayHello@test');

Shoot::trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='/start';
},'start@showMenu');

Shoot::trigger(function(&$u){
    return !empty($u->message->text) && $u->message->text=='درباره ما';
},'start@aboutUs');