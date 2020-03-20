# CakePHP Vue Template


## インストール

```
git clone https://github.com/katsuhiko/cakephp-vue-study.git
cd cakephp-vue-study

cp ./config/.env.example ./config/.env
cp ./config/app_local.example.php ./config/app_local.php

docker run --rm -it -v "$(pwd):/home/app" -w /home/app node:12 npm install

docker-compose up -d
docker exec -it app php composer.phar install
```
