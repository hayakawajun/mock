# flea-market-app (coachtechフリマ)

## 環境構築

### Dockerビルド
1. GitHubからクローン
``` bash
git clone git@github.com:hayakawajun/mock.git
```
2. DockerDesktopアプリを立ち上げる。
3. Dockerを起動。
``` bash
docker-compose up -d --build
```
※ MySQLはOSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

### Laravel環境構築
1. PHPコンテナ内に移動。
``` bash
docker-compose exec php bash
```
2. パッケージのインストール。
``` bash
composer install`
```
3. 「.env.example」ファイルから「.env」ファイルを作成。
4. 作成した「.env」ファイルに以下の環境変数を設定。

- データベースに関する設定
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
- mailhogによるメール認証テストに関する設定
``` text
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=test@example.com
MAIL_FROM_NAME="${APP_NAME}"
```
- 下記はStripeのテスト決済画面への接続に関する設定です。  
ファイル内に項目を追加の上、設定してください。
``` text
STRIPE_KEY="[あなたのテスト公開可能キーをここに記述]"
STRIPE_SECRET="[あなたのテストシークレットキーをここに記述]"
```
> *キーの値は、Stripeのテスト用サンドボックス画面に入り、[開発者]アイコンから[APIキー]押下で遷移後、テスト用のAPIキーをコピーして上記項目に貼り付けてください。*

5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. キャッシュ

8. シーディングの実行
``` bash
php artisan db:seed
```

## ER図
![alt](ER_graph.png)