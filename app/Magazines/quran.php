<?php

namespace App\Magazines;

use XB\theory\Magazine;
use XB\telegramMethods\sendMessage;
use XB\telegramMethods\editMessageText;
use XB\telegramMethods\editMessageReplyMarkup;
use App\Page;

class quran extends Magazine {

	public function show( $u ) {
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
		if ( ! $send() ) {
			\Storage::append( 'logs/last.json', "error: " . $send->getError() );

			return;
		}

	}

	public function goto( $u, $s ) {
		$page = Page::find( $s );

		$keys = [ ];
		if ( $s + 1 <= 604 ) {
			$keys[0][] = [ 'text' => 'صفحه بعد ◀', 'callback_data' => 'page/' . ( $page->id + 1 ) ];
		}
		if ( $s - 1 > 0 ) {
			$keys[0][] = [ 'text' => '▶ صفحه قبل', 'callback_data' => 'page/' . ( $page->id - 1 ) ];
		}
		if ( $s + 10 <= 604 ) {
			$keys[1][] = [ 'text' => '10 صفحه بعد ⏪', 'callback_data' => 'page/' . ( $page->id + 10 ) ];
		}
		if ( $s - 10 > 0 ) {
			$keys[1][] = [ 'text' => '⏩ 10 صفحه قبل', 'callback_data' => 'page/' . ( $page->id - 10 ) ];
		}
		if ( $s + 100 <= 604 ) {
			$keys[2][] = [ 'text' => '100 صفحه بعد ⏮', 'callback_data' => 'page/' . ( $page->id + 100 ) ];
		}
		if ( $s - 100 > 0 ) {
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
		if ( ! $edit() ) {
			\Storage::append( 'logs/last.json', "error: " . $edit->getError() );

			return;
		}

	}

	public function msgText( $page ) {
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
}