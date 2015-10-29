Advanced Usage
==============

In this guide we'll show how to use Smarty in advanced cases.

## Using callback as GridView column value

Because of Smarty's syntax restrictions, it is not possible to pass anonymous function as value like in the following
PHP example:

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

Still it could be achieved. First create a helper class with static function defining your value formatting logic:

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

Then pass that static callback to `GridView`'s column value as array:

```smarty
{use class='yii\grid\GridView' type='function'}
{GridView columns=[
    [
        'class' => 'yii\grid\DataColumn',
        'value' => ['app\helpers\GridHelper', 'yourGridColumnTitleValue']
    ]
]}
```

## Custom ActionColumn urlCreator

Again, it's not possible to pass custom anonymous function like in the following example:

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

When using Smarty you need to create a helper class with static function returning closure:

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

Then load `GridHelper` with `{use class='app\helpers\GridHelper'}` and set `urlCreator` by calling your static function
from `GridHelper`:

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
