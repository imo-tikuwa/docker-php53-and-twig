# docker-php53-and-twig

## このリポジトリについて
以下のDocker環境を構築します。
 - CentOS6.10
 - httpd 2.2.15
 - php 5.3.3
 - twig 1.36.0

レガシーなシステムにtwigを導入することになった際の勉強用リポジトリです。

## 使い方
```cmd
git clone https://github.com/imo-tikuwa/docker-php53-and-twig.git
cd docker-php53-and-twig
docker-compose up -d --build
```
実行後、http://localhost/ にアクセス

## 問題点
webrootにサブディレクトリを作成、その中から拙作のTwigHelperを呼ぶとtwigテンプレートディレクトリのパスが解決できないという問題を含んでます。  
コンストラクタで明示的に指定するかTwigHelperのコンストラクタを呼び出すphpファイルはwebrootにまとめておく必要があります。

## その他
php5.3.3に対応したtwigのバージョンを探すのはPackagistのページを参考とした。  
https://packagist.org/packages/twig/twig#v1.36.0

また、Twig1.36.0はサンドボックスモードに不具合を含んでいるとのこと。  
https://symfony.com/blog/twig-sandbox-information-disclosure
