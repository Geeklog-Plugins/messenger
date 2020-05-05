<?php

// +-----------------------------------------------------------------------------+
// | glMessenger Plugin 1.0 for Geeklog- The Ultimate OSS Portal                 |
// | Date: November 15, 2003                                                     |
// +-----------------------------------------------------------------------------+
// | english.php - English Language Filem                                        |
// +-----------------------------------------------------------------------------+
// | Copyright (C) 2003-2019 by the following authors:                           |
// |                                                                             |
// | glMessenger Plugin Author:                                                  |
// | Blaine Lang   -  blaine@portalparts.com                                     |
// | Kenji ITO     -  mystralkk AT gmail DOT com                                 |
// +-----------------------------------------------------------------------------+
// | Geeklog Common Code                                                         |
// | Copyright (C) 2000-2003 by the following authors:                           |
// |                                                                             |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                             |
// |          Mark Limburg      - mlimburg@users.sourceforge.net                 |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                     |
// |          Dirk Haun         - dirk@haun-online.de                            |
// +-----------------------------------------------------------------------------+
// |                                                                             |
// | This program is licensed under the terms of the GNU General Public License  |
// | as published by the Free Software Foundation; either version 2              |
// | of the License, or (at your option) any later version.                      |
// |                                                                             |
// | This program is OpenSource but not FREE. Unauthorized distribution is       |
// | illegal. Anyone caught doing so will be banished from the geeklog community |
// | You may not remove the copyright or redistribute this script in any form.   |
// |                                                                             |
// | This program is distributed in the hope that it will be useful,             |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of              |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                        |
// | See the GNU General Public License for more details.                        |
// |                                                                             |
// | You should have received a copy of the GNU General Public License           |
// | along with this program; if not, write to the Free Software Foundation,     |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             |
// |                                                                             |
// +-----------------------------------------------------------------------------+

$LANG_MSG = [
    'err01'                  => 'この機能へのアクセス権がありません',
    'err02'                  => '不正な操作を実行しようとしました',
    'err03'                  => 'エラー: メンバー名が無効です',
    'BLOCKHEADER'            => 'プライベートメッセージ',
    'RE'                     => 'Re:',
    'ERROR'                  => 'エラー!',
    'FROM'                   => '差出人',
    'TO'                     => '宛先',
    'SUBJECT'                => '件名',
    'PM'                     => 'PM',
    'NEW_PM'                 => '新しいPM',
    'NEW'                    => 'New',
    'NEWMESSAGE'             => 'メッセージ作成',
    'DATE'                   => '日付',
    'ARCHIVE'                => '&nbsp;保存&nbsp;',
    'ARCHIVEMSG'             => 'メッセージを保存',
    'REPLY'                  => '&nbsp;返信&nbsp;',
    'REPLYMSG'               => '差出人へ返信',
    'DELETE'                 => '&nbsp;削除&nbsp;',
    'DELETEMSG'              => 'メッセージを削除',
    'INBOX'                  => '受信箱',
    'OUTBOX'                 => '送信箱',
    'SENTBOX'                => '送信済み',
    'ARCHIVEBOX'             => '保存',
    'REMOVE'                 => 'このメッセージを削除する',
    'SUBMIT'                 => '送信',
    'CANCEL'                 => 'キャンセル',
    'PREVIEW'                => 'プレビュー',
    'MESSAGE'                => '内容',
    'MEMBERS'                => 'メンバー',
    'MEMBERSLIST'            => 'メンバーリスト',
    'ANONYMOUS'              => 'ゲスト',
    'BROADCAST'              => '一括送信',
    'BROADCAST_MSG'          => 'メッセージを一括送信する',
    'EXPIRE_MSG'             => 'メッセージは %s に削除されます',
    'OPTIONS'                => 'オプション',
    'DELALL'                 => 'すべて削除',
    'DELALLMSG'              => 'すべてのメッセージを削除する',
    'DELOLDER'               => '古いメッセージの削除',
    'DELOLDERMSG'            => '昨日までのすべてのメッセージを削除する',
    'VIEWORIGINAL'           => '<hr>表示&nbsp;<a href="%s">元の </a>&nbsp;メッセージ',
    'MYBUDDIES'              => 'お気に入りメンバー',
    'MSGFAVORITES'           => 'メッセンジャー',
    'ADDBUDDY'               => 'メンバーリストに追加',
    'DELBUDDY'               => 'メンバーリストから削除',
    'HOME'                   => 'ホーム',
    'SETTINGS'               => '設定',
    'prompt01'               => 'このページは自動的に更新されません。更新するには<a href=%s>ここ</a>をクリックしてください',
    'prompt02'               => '* 一括送信メッセージ。送信者か管理者しか削除できません。<br>&nbsp;削除するとコピーもすべて削除されます。',
    'prompt02b'              => '* 一括送信メッセージ。送信者か管理者しか削除できません。',
    'prompt03'               => '送信日時: ',
    'statusmsg1'             => '%s 続けるには<a href="%s">ここ</a>をクリック',
    'statusmsg2'             => 'to continue',
    'statusmsg3'             => 'このページは自動的に戻ります。すぐに戻るには<a href="%s">ここ</a>をクリックしてください。',
    'msgsent'                => 'メッセージを送信しました。',
    'msgsave'                => 'メッセージが %s へ送信されました。',
    'msgreturn'              => 'to return to your inbox.',
    'msgerror'               => 'メッセージが送信されませんでした。<a href="javascript:history.back()">ここをクリック</a>して、すべてのフィールドに入力したか確認してください。',
    'msgdelok'               => '削除しました',
    'msgdelsuccess'          => 'メッセージを削除しました。',
    'msgdelerr'              => 'メッセージを削除しませんでした。<a href=\"javascript:history.back()\">ここをクリック</a>して、メッセージを選択してください',
    'msgpriv'                => 'プライベートメッセージ',
    'msgprivnote1'           => 'You have %s private message in your %s folder.',
    'msgprivnote2'           => 'You have %s private messages in your %s folder.',
    'msgto'                  => '宛先: ',
    'msgmembers'             => 'メンバーリスト',
    'msgarchive'             => 'メッセージを保存しました。',
    'newmsghelp'             => 'メッセージの新規作成',
    'lang_broadcasts'        => 'PMの一括送信',
    'help_broadcasts'        => 'メッセンジャーの一括送信をブロック',
    'lang_notifications'     => '通知',
    'help_notifications'     => '新しいメッセージや購読しているメッセージの更新があった際にメールで通知',
    'lang_sitenotifications' => 'メッセンジャーをデフォルトにする',
    'help_sitenotifications' => 'すべての通知をプライベートメッセージの受信箱に送る',
    'outboxmsg'              => '受信者がまだ削除していないため、送信箱のメッセージを削除できません。',
    'show_smilies'           => '顔文字を表示',
    'hide_smilies'           => '顔文字を隠す',
    'usermenu'               => 'メッセンジャー',
];

// Language used for Notification Feature
$LANG_MSG01 = [
    'HELLO'     => "Hello",
    'ADMIN'     => "Site Administrator",
    'SUBJECT'   => "- New Private Message Notifiction",
    'BROADCAST' => "- Broadcast Message Notifiction",
    'LINE1'     => "You have a new Private message from fellow site member: %s\nSubject:%s",
    'LINE1B'    => "There is a new broadcast message waiting in your private message area from: %s\nSubject: %s",
    'LINE2'     => "\n \nYou are receiving this because you requested to be notified of any new Private Messages.\n\n",
    'LINE3'     => "Have a great day!\n",
];

// Language used for Admin screens
$LANG_MSG02 = [
    'BLOCKHEADER' => 'スマイリー管理',
    'IMAGE'       => '画像',
    'CODE'        => '絵文字',
    'DESCRIPTION' => '説明',
    'ADDSMILIE'   => 'スマイリーを追加',
    'EDIT'        => '編集',
    'DELETE'      => '削除',
    'ADDPROMPT'   => '新しいスマイリーを追加',
    'ADDSUBMIT'   => '新しいスマイリーを追加',
    'EDITPROMPT'  => 'スマイリーの編集',
    'EDITSUBMIT'  => 'スマイリーの更新',
    'FILENAME'    => '画像ファイル名',
    'HELPMSG1'    => 'この画面でスマイリーの追加・編集・削除を行います。同じスマイリーの画像に対して複数の顔文字を設定することができます。スマイリーを追加するには、画像ファイルをサーバーのスマイリーを保存しているディレクトリにアップロードしてから「スマイリーを追加」をクリックしてください。顔文字や割り当てる画像を変更するには「編集」をクリックしてください。',
];

// Language used for Sortby Filter in main message view
$LANG_MSG03 = [
    'BUDDYADMIN' => 'メンバー管理',
    'SORTBY'     => 'ソート基準',
    'OLDFIRST'   => '古い順',
    'NEWFIRST'   => '新しい順',
    'MEMBER'     => 'メンバー名',
];

// Language used in the Buddy Admin screen
$LANG_MSG04 = [
    'MAINHEADER' => 'メンバー管理',
    'HEADER1'    => '追加可能なメンバー',
    'HEADER2'    => 'メンバーリスト',
    'ADD'        => '追加',
    'REMOVE'     => '削除',
    'CANCEL'     => 'キャンセル',
    'SAVE'       => '保存',
];

// Language used to send message to new members - intro message
$LANG_MSG05 = [
    'subject' => 'Welcome to my site!',
    'message' => 'Thank you for joining portalparts.com. I hope that you enjoy being a member :) If you have any questions, please search the FAQ or forum first.<p />Regards,<br><i>Site Administrator</i>',
];

// Localization of the Admin Configuration UI
$LANG_configsections['messenger'] = [
    'label' => 'メッセンジャー',
    'title' => 'メッセンジャー',
];

$LANG_confignames['messenger'] = [
    'debug'                 => 'リクエスト変数をデバッグする',
    'smiliesEnabled'        => 'スマイリーを表示する',
    'RestrictedAccess'      => 'messenger.userアクセス権を持つユーザーだけを許可する',
    'messagedelay'          => 'メッセージ表示時の待ち時間(ミリ秒)',
    'automsg'               => 'メッセージを自動的に表示する',
    'notification'          => 'サイトにプライベートメッセージを通知する',
    'mailoff'               => 'メールによる通知を無効にする',
    'RootBdcastNotificaton' => '一斉送信の際にも通知する',
    'newmember'             => '新規メンバーログイン時にプライベートメッセージを送信する',
    'USER_PMBLOCK'          => 'プラグイン規定値: ユーザーは一斉送信されるメッセージの受信を拒否する',
    'USER_NOTIFY'           => 'プラグイン規定値: ユーザーは新規メッセージの通知をメールで受け取る',
    'USER_INBOX'            => 'プラグイン規定値: すべてのシステムとプラグインの通知を受信箱に送る',
];

$LANG_configsubgroups['messenger'] = [
    'sg_main' => '主要設定',
];

$LANG_tab['messenger'] = [
    'tab_main' => '主要設定',
];

$LANG_fs['messenger'] = [
    'fs_main' => '主要設定',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['messenger'] = [
    0 => ['はい' => 1, 'いいえ' => 0],
    1 => ['はい' => true, 'いいえ' => false],
];
