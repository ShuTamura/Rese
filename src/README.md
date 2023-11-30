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