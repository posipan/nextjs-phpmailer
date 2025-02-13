## ローカル環境構築方法

### 1.リポジトリをクローンする
```bash
git clone 
```
### 2.env.exampleをコピーして.envを作成する
`/nextjs/`と`/php/mail/`にて.envを作成する。

* `/nextjs/`で実行
```bash
cp .env.example .env
```

* `/php/mail/`で実行
```bash
cp .env.example .env
```

### 3.Docker環境でのNext.js、PHP、Mailpitのセットアップ
プロジェクトのトップディレクトリにて以下のコマンドを順に実行する。

```bash
docker-compose up --build
```

### 4.URL
#### 4-1.ページ（Next.js環境）
http://localhost:12000

#### 4-2.ローカル環境のメール受信確認環境
http://localhost:8025

#### 4-3.メール送信処理（PHP環境）
http://localhost:8081


### 5.メール受信確認方法
以下のページからお問い合わせを行い、Thanksページに遷移すればメール送信処理が成功する。

http://localhost:12000

以下のページにアクセスすると、ユーザーと管理者宛の受信メールが確認できる。

http://localhost:8025

### 6.nodeパッケージを追加・削除する場合
以下コマンドにてコンテナにログイン後、
```bash
docker-compose run nextjs sh
docker-compose run php sh
```

コンテナ内で追加・削除の実施を行う。
```bash
# 例
/app # npm uninstall react-intersection-observer
```

### 7.トラブルシューディング
* ページが表示されないまたはお問い合わせできないなどが起こる場合は以下のコマンドを実行してみる。
```bash
docker-compose down --rmi all --volumes --remove-orphans && docker-compose up --build
```
