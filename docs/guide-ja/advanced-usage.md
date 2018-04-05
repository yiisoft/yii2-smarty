高度な用法
==========

この節では、Smarty の高度な用法をいくつか示します。

## GridView のカラムの値としてコールバックを使う

Smarty の文法の制約によって、次の PHP の例のように、無名関数を値として渡すことは出来ません。

```php
echo GridView::widget([
    'columns' => [
        [
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->name;
            },
        ],
    ],
]);
```

しかし、目的を達する方法はあります。
まず、値をフォーマットするロジックを定義するスタティックな関数を持つ、ヘルパ・クラスを作ります。

```php
<?php
namespace app\helpers;

class GridHelper
{
    public static function yourGridColumnTitleValue($data)
    {
        return strtoupper($data->title);
    }
}
```

そして、そのスタティックなコールバックを配列にして `GridView` のカラムの値として渡します。

```smarty
{use class='yii\grid\GridView' type='function'}
{GridView columns=[
    [
        'class' => 'yii\grid\DataColumn',
        'value' => ['app\helpers\GridHelper', 'yourGridColumnTitleValue']
    ]
]}
```

## ActionColumn のカスタマイズした urlCreator

ここでも、次の例のように、カスタマイズした無名関数を渡すことは不可能です。

```php
echo GridView::widget([
    'columns' => [
        [
            'class' => 'yii\grid\ActionColumn',
            'urlCreator' => function($action, $model, $key, $index) {
                return Url::to(['custom/url', 'key' => $key]);
            },
        ],
    ],
]);
```

Smarty を使う場合は、クロージャを返すスタティックな関数を持つ、ヘルパ・クラスを作らなければなりません。

```php
<?php
namespace app\helpers;

class GridHelper
{
    public static function yourGridColumnUrlCreator()
    {
        return function($action, $model, $key, $index) {
            return Url::to(['custom/url', 'key' => $key]);
        };
    }
}
```

そして、`{use class='app\helpers\GridHelper'}` によって `GridHelper` をロードし、`GridHelper` に属するスタティックな関数を呼ぶように `urlCreator` を設定します。

```smarty
{use class='app\helpers\GridHelper'}
{use class='yii\grid\GridView' type='function'}

{GridView columns=[
    [
        'class' => 'yii\grid\ActionColumn',
        'urlCreator' => GridHelper::yourGridColumnUrlCreator()
    ]
]}
```
