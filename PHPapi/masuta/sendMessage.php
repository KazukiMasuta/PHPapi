<!-- メッセージに返信するファイル -->

<?php
$json = file_get_contents("php://input"); // チャットプラスのAPIからPOSTされたデータを取得
$input_data = json_decode($json, true); // $jsonを配列に変換

// 受信データ
$to = $input_data['room']['room_id'];
$agent = $input_data['agent']['agent_id'];
$siteId = $input_data['site']['site_id'];

// ↓↓↓↓      入力してね！      ↓↓↓↓
$accessToken = '0a79f1bc6765cf1fbc2ea939ea5d15890f5098db';

// ここから下のコードを編集しよう！===========================================================================================================================

// 参考URL https://app.chatplus.jp/admin/cp/api/send

//　参考URL https://qiita.com/pophope/items/4ee4943161017f4b3c3b


$today = date('Y/m/d');
$search_url = "http://api.jugemkey.jp/api/horoscope/free/".$today;
$json = file_get_contents($search_url);
$data = json_decode($json, false);

$text = $input_data['message']['text']; // 相手の送信したメッセージ
if (strpos($text, "占") || strpos($text, "うらな") !== false){
    $text = $data->horoscope->$today[2]->content;
}else{
    $text = "占いしかできません。";
}

$messages = [
    [
        'type' => 'text',
        'text' => $text,
    ]
];

/*
テキスト以外にもいろいろな返信方法がある
参考URL https://app.chatplus.jp/admin/cp/api/send


// 複数のメッセージを送りたい場合
$messages = [
    [
        'type' => 'text',
        'text' => '1つ目のメッセージ'
    ],
    [
        'type' => 'text',
        'text' => '2つ目のメッセージ'
    ]
];

// 画像を送りたい場合

$messages = [
    [
        'type' => 'image',
        'url' => 'https://www.ec-cube.net/upload/save_image/09281534_59cc97dd5bcab.png'
    ]
];

*/

// ここから下は変更しない！=================================================================================================================================

// HTTPパラメータの設定
$data = [
    'to' => $to,
    'agent' => $agent,
    'accessToken' => $accessToken,
    'siteId' => $siteId,
    'messages' => $messages,
];
$header = [
    'Content-Type: application/json; charset=utf-8',
];
$context = [
    "http" => [
        "method"  => "POST",
        "header"  => implode(PHP_EOL, $header),
        "content" => json_encode($data) //$dataをjsonにしている
    ]
];

$url = 'https://app.chatplus.jp/api/v1/send'; // チャットプラス返信用APIのurl

// チャットボットへ返信
file_get_contents(
    $url,
    false,
    stream_context_create($context)
);
