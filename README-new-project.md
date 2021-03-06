# New Project

## CakePHP プロジェクトの作成

```
cd .
docker run --rm -it -v "$(pwd):/home/app" -w /home/app katsuhikonagashima/php-fpm-base:7.4-buster /bin/bash
```

```
curl -sS https://getcomposer.org/installer | php

php composer.phar create-project --prefer-dist cakephp/app:4.* cakephp-vue-study
cp composer.phar ./cakephp-vue-study/
exit
```

```
cd cakephp-vue-study/
git init
git add --all
git commit -m "create cakephp4 project."
git remote add origin https://github.com/katsuhiko/cakephp-vue-study.git
git push -u origin master
```


## Security Salt の生成

```
docker run --rm -it debian:10 sh -c "cat /dev/urandom | LC_CTYPE=C tr -dc '[:alnum:]' | head -c 64; echo ''; sleep 1"
```

./config/.env.example の SECURITY_SALT へセットする


## Laravel Mix のインストール

```
cd ..
docker run --rm -it -v "$(pwd):/home/app" -w /home/app katsuhikonagashima/php-fpm-base:7.4-buster /bin/bash
```

```
curl -sS https://getcomposer.org/installer | php

php composer.phar create-project --prefer-dist laravel/laravel laravel-template
cd laravel-template
php ../composer.phar require laravel/ui
php artisan ui vue
exit
```

```
cd ./cakephp-vue-study/

cp ../laravel-template/package.json ./
cp ../laravel-template/webpack.mix.js ./

mkdir -p ./assets
cp -r ../laravel-template/resources/js ./assets/js
cp -r ../laravel-template/resources/sass ./assets/sass

docker run --rm -it -v "$(pwd):/home/app" -w /home/app node:12 npm install
docker run --rm -it -v "$(pwd):/home/app" -w /home/app node:12 npm install --save-dev vue-router
```

./webpack.mix.js 変更 - CakePHP の形に合わせる

```
mix.setPublicPath('webroot')
    .js('assets/js/app.js', 'assets/js')
    .sass('assets/sass/app.scss', 'assets/css')
    .sourceMaps().webpackConfig({devtool: 'source-map'});;
```

./.gitignore 追加 - 余計なファイルをリポジトリにあげないようにする

```
# Laravel Mix specific files #
##############################
/node_modules
/webroot/assets
/webroot/mix-manifest.json
```


## Docker の準備

docker-compose を動かすためのファイルを用意

- ./docker-compose.yml の作成
- ./docker/local/ 配下の各種ファイルの作成
- ./config/app_local.php のDB接続情報を変更


## phpstan の導入

```
docker exec -it app php composer.phar require --dev phpstan/phpstan
```

./phpstan.neon の作成

```
parameters:
    level: 8
    excludes_analyse:
        - src/Console/Installer.php
        - src/Controller/PagesController.php
```

./composer.json の script で、 check 実行時に phpstan も動くようにする。


## Fabricate の導入

https://github.com/sizuhiko/cakephp-fabricate-adaptor/tree/cakephp4

```
docker exec -it app php composer.phar require --dev sizuhiko/cake_fabricate:dev-cakephp4
```


## Swagger-PHP の導入

https://qiita.com/horikeso/items/34ad3c91a6864e868d34

```
docker exec -it app php composer.phar require --dev zircote/swagger-php
```

composer.json へ scripts を追加
.gitignore へ追加


## cakephp/authentication の導入

- https://book.cakephp.org/4/en/tutorials-and-examples/cms/authentication.html
- https://book.cakephp.org/authentication/2/en/index.html

```
docker exec -it app php composer.phar require cakephp/authentication:^2.0
```


## 利用している主要プロダクトのリリース情報

- https://github.com/cakephp/cakephp/releases
- https://github.com/vuejs/vue/releases
- https://github.com/JeffreyWay/laravel-mix/releases
