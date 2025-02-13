## ローカル環境構築方法

### 前提条件
* Dockerアプリがインストールされていること
* Node.jsがインストールされていること

### 1.リポジトリをクローンする
```bash
git clone https://github.com/posipan/nextjs-phpmailer.git
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
プロジェクトのトップディレクトリにて下記コマンドを実行する。

```bash
docker-compose up
```

### 4.npm install
`/nextjs/`ディレクトリから下記コマンドを実行し、ホスト側にパッケージを反映させる。
```bash
npm install
```
※実行せずともアプリは動作しますが、.tsxファイルなどにパッケージ読み込みエラーが出力されてしまいます。

### 5.URL
#### 5-1.ページ（Next.js環境）
http://localhost:12000

#### 5-2.ローカル環境のメール受信確認環境
http://localhost:8025

#### 5-3.メール送信処理（PHP環境）
http://localhost:8081
