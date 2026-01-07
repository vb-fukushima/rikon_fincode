docker利用。

$ docker-compose up
したあと、
localhost:8547
で確認可能。

codeはすべてAI作成したもの。

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
