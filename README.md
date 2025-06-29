# PHP Conference Japan 2025 "PostgreSQLのRow Level SecurityをPHPのORMで扱う Eloquent vs Doctrine" サンプルコード

[PostgreSQLのRow Level SecurityをPHPのORMで扱う Eloquent vs Doctrine](https://fortee.jp/phpcon-2025/proposal/80764564-29d0-4cf1-a126-7662c2ad6cac)  
スライドはこちら https://speakerdeck.com/77web/postgresqlnorow-level-securitywophpnoormdexi-u-eloquent-vs-doctrine-number-phpcon-number-track2

## 使い方

- 見たいパターン（laravel-eloquent, laravel-doctrine, symfony-doctrine）のディレクトリに入りdocker compose up
- docker compose exec app bashでコンテナ内に入り、vendor/bin/phpunit を実行して動いているところを観察してください

## 高度な使い方（？）

それぞれの得意なフレームワーク・ORMのアプリケーション内を探索し、どのようなSQLでRLSの設定をしているか学習することができます

