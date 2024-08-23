# Rese
飲食店予約サービス
自社製の予約サービス
# 機能一覧
## 飲食店予約
- マイページまたは、飲食店詳細ページより予約可能
## 口コミ評価機能
- 来店済みのお店を評価
## 管理権限
- 一般ユーザー
- 各飲食店代表者
- サイト管理者
## QRコード
## 予約リマインダー
## お知らせメール
# 店舗情報の追加
csvファイルをインポートすることにより店舗情報をまとめて登録可能。以下csvファイル記入方法
## csvファイル記入例
| 1 |name| area |genre|detail|image|
| :---- | :---- | :---- | :---- | :---- | :---- |
| 2 | 店舗名    | 店舗地域 | ジャンル | 店の概要、詳細 | 画像URL |
| 3 | 店舗名    | 店舗地域 | ジャンル | 店の概要、詳細 | 画像URL |
| 4 | 店舗名    | 店舗地域 | ジャンル | 店の概要、詳細 | 画像URL |
| 5 | 店舗名    | 店舗地域 | ジャンル | 店の概要、詳細 | 画像URL |
.
.
.
### 記入制約
- 店舗名：50文字以内
- 地域：「東京都」「大阪府」「福岡県」のいずれか
- ジャンル：「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれか
- 店舗概要：400文字以内
- 画像URL：jpeg、pngのみアップロード可能。非対応の拡張子はエラーメッセージを表示する
# 環境構築
```
$ cd "laravelプロジェクトを入れる任意のディレクトリ"
$ git clone https://github.com/ShuTamura/Atte-app.git
$ sudo chmod -R 777 *
$ docker-compose up -d --build
```
laravelのパッケージインストール
```
$ docker-compose exec php bash //phpコンテナにログイン
$ composer install
```
.envファイルの編集
```
## mysqlと接続
DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
+ DB_HOST=mysql
DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=root
- DB_PASSWORD=
+ DB_DATABASE="データベース名"          //
+ DB_USERNAME="データベースユーザー名"   //docker-compose.ymlのmysqlをもとに編集
+ DB_PASSWORD="データベースパスワード"   //
+STRIPE_KEY=pk_test_51OHxjRD2FLMWAcqM5xedZntiyRytChUAzIQ1vTGqH4gy7qgDibaY52ntXc6yEnMH0LPaGflm1au5AfC2dJxSQ7n100cqs6Drsj
+STRIPE_SECRET=sk_test_51OHxjRD2FLMWAcqMcVjQiJ00KBWd4O20ujxiBkAotNCYfk6MmRaG3wpMYmjsdbGPSzPLYjpbYfcRqj01ROekHOSl00Y83AJJB8 //stripeによる決済機能実装

```
```
## phpコンテナ内
$ php artisan key:generate //アプリケーションキー生成
$ php artisan migrate
$ php artisan db:seed //ダミーデータ作成。id=1のユーザーに管理者権限付与
```
