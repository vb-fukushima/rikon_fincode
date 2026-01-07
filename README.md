docker利用

# 1. Appコンテナ（PHP環境）の中に入る
docker exec -it divorce_app bash

# 2. .envファイルの作成（未作成の場合）
cp .env.example .env

# 3. Composerパッケージのインストール
# ※ もしvendorディレクトリがない場合は実行してください
composer install

# 4. アプリケーションキーの生成
php artisan key:generate

# 5. データベースのマイグレーション
# ※ DBコンテナが完全に起動していることを確認してから実行してください
php artisan migrate

htttp://localhost:8547

※ codeはすべてAI作成したもの。

fincodeの管理画面でAPIキー取得後、envには以下追加。
```dotenv
FINCODE_SECRET_KEY=m_test_XXXXXXXX(自分のキーをここに記載)
FINCODE_PUBLIC_KEY=p_test_XXXXXXX(自分のキーをここに記載)
FINCODE_API_URL=https://api.test.fincode.jp

# ↓これで、3ds利用できる
FINCODE_TDS_TYPE=2
```

fincodeテスト用リソース
https://docs.fincode.jp/develop_support/test_resources
