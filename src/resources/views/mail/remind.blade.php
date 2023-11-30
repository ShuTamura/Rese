<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>リマインド</title>
</head>
<body>
    <p>お知らせ</p>
    ーーーー
	<p>件名：Rese：リマインダー<br></p>
    <p>本日、以下の内容で予約が入っています</p>
    <p>店舗：{{ $contents['shop'] }}</p>
    <p>時間：{{ $contents['time'] }}</p>
    <p>人数：{{ $contents['number'] }}名</p>
    ーーーー
    <p>ご来店をお待ちしております</p>
</body>
</html>