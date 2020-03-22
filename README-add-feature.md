# Add Feature


## DBマイグレーション

```
docker exec -it app bin/cake bake migration CreateTasks
```

YYYYMMDDHHMISS_CreateTasks.php 実装

```
docker exec -it app bin/cake migrations migrate
```


## モデルの作成

```
docker exec -it app bin/cake bake model tasks
```


## ルーティング

./config/routes.php 実装
ルーティングは手間でもすべて書くことにしている。


## コントローラーの作成

./src/Controller/Api/TasksController 実装
