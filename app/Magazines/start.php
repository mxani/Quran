<?php

namespace App\Magazines;

use App\Member;
use XB\theory\Magazine;
use XB\theory\telegramCollection;
use XB\telegramMethods\sendMessage;
use XB\telegramObjects\ReplyKeyboardMarkup;
use XB\telegramObjects\KeyboardButton;

class start extends Magazine {
	public function showMenu( $u ) {
		if(Member::where('user_id',$u->message->from->id)->count()==0){
			Member::create( [
				'user_id'    => $u->message->from->id,
				'first_name' => $u->message->from->first_name,
				'username'   => empty($u->message->from->username)?'':$u->message->from->username,
				'last_name'   => empty($u->message->from->last_name)?'':$u->message->from->last_name,
			] );
		}


		$send = new sendMessage( [
			'chat_id'      => $u->message->chat->id,
			'text'         => "کاربر گرامی " . $u->message->from->first_name . " عزیز خوش آمدید.🌺🌺"."\n".
"ربات قرآنی @nurolmobin_bot با محوریت دردسترس بودن قرآن برای همگان در فضای مجازی"."\n"."📚راهنما:"."\n".
" \n 1️⃣ اگر به دنبال صفحه خاصی هستید 'جستجو صفحات' را انتخاب کنید
\n2️⃣ اگر به دنبال سوره خاصی هستید 'فهرست سوره ها' را انتخاب کنید\n
➕ در ضمن صفحات قرآن هم به صورت فایل تصویری و هم بصورت فایل متنی موجود می باشد ",
			'parse_mode'   => 'html',
			'reply_markup' => json_encode( [
				'keyboard'          => [
					
					[ '📋فهرست سوره ها' ],
					[ '🔎جستجوی صفحات' ],
					[ '🤖درباره ربات' ],
				],
				'resize_keyboard'   => true,
				'one_time_keyboard' => true,
			] ),
		] );
		if ( ! $send() ) {
			\Storage::append( 'updates/last.json', "error: " . $send->getError() );
		}


	}

	public function aboutUs( $u ) {
		$send = new sendMessage( [
			'chat_id'    => $u->message->chat->id,
			'text'       => "ربات قرآنی نورالمبین" .
			                "\n نسخه 1.1.0" . "\n\n ارتباط با پشتیبانی : " ."@telerobotic_bot\n",
			'parse_mode' => 'html',
		] );
		if ( ! $send() ) {
			\Storage::append( 'updates/last.json', "error: " . $send->getError() );
		}

	}

}
