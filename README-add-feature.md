# Add Feature


## DBマイグレーション

```
docker exec -it app bin/cake bake migration CreateTasks
```

```
docker exec -it app bin/cake migrations migrate
```


## モデルの作成

```
docker exec -it app bin/cake bake model Tasks
```


## コントローラーの作成

```
docker exec -it app bin/cake bake controller Task --prefix Api
```


## ルーティング

./config/routes.php 実装
