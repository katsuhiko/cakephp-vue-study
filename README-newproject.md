# New Project

## CakePHP プロジェクトの作成

```
cd .
docker run --rm -it -v "$(pwd):/home/app" -w /home/app katsuhikonagashima/php-fpm-base:7.4-buster /bin/bash
```

```
apt-get install -y curl
curl -sS https://getcomposer.org/installer | php

php composer.phar create-project --prefer-dist cakephp/app:4.* cakephp-vue-study

cp composer.phar ./cakephp-vue-study/
exit
```

```
cd cakephp-vue-study/
git init
git add --all
git commit -m "create cakephp project."
git remote add origin https://github.com/katsuhiko/cakephp-vue-study.git
git push -u origin master
```


## Docker の準備

docker-compose を動かすためのファイルを用意

- ./docker-compose.yml の作成
- ./docker/local/ 配下の各種ファイルの作成
- ./config/app_local.php のDB接続情報を変更
