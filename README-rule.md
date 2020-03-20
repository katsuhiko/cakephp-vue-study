# Rule

## Commit時のコメントルール

Angular のコメントルールを参考。

- https://github.com/angular/angular.js/blob/master/DEVELOPERS.md#type

```
feat        : 新機能
fix         : バグ修正
docs        : ドキュメントのみの変更
style       : コードの意味に影響を与えない変更（空白、フォーマット、セミコロンの欠落など）
refactor    : バグを修正も機能も追加しないコード変更
perf        : パフォーマンスを向上させるコード変更
test        : 欠けているテストや既存のテストの修正
chore       : ビルドプロセスの変更、あるいは文書生成などの補助ツールやライブラリーの変更
```


## Commit＆Push 前にすること

```
docker exec -it app php composer.phar check
```


## DBマイグレーション

```
docker exec -it app bin/cake bake migration CreateTasks
docker exec -it app bin/cake migrations migrate
docker exec -it app bin/cake migrations rollback
```

- マイグレーションファイル名のパターン
    - https://book.cakephp.org/migrations/3/en/index.html#migrations-file-name

| パターン | 説明 | 例 |
| --- | --- | --- |
| (/^(Create)(.*)/)           | テーブル作成 | CreateTasks                |
| (/^(Drop)(.*)/)             | テーブル削除 | DropTasks                  |
| (/^(Add).*(?:To)(.*)/)      | カラム追加   | AddDescriptionToTasks      |
| (/^(Remove).*(?:From)(.*)/) | カラム削除   | RemoveDescriptionFromTasks |
| (/^(Alter)(.*)/)            | テーブル変更 | AlterTasks                 |
| (/^(Alter).*(?:On)(.*)/)    | カラム変更   | AlterDescriptionOnTasks    |

- change メソッドで使えるコマンド
    - https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method

```
createTable
renameTable
addColumn
renameColumn
addIndex
addForeignKey
```
