Advanced Usage
==============

## Custom column value

Because of Smarty's syntax restrictions, there is not possible to pass custom closures, like in this PHP example of custom column value.

**PHP Way**

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

But it can be done another way!

**Smarty Way**

Create a helper class with static function defining your value formatting logic.

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

And pass that static callback to `GridView`'s column value as array.

```smarty
{use class='yii\grid\GridView' type='function'}
{GridView columns=[
    [
        'class' => 'yii\grid\DataColumn',
        'value' => ['app\helpers\GridHelper', 'yourGridColumnTitleValue']
    ]
]}
```

## Custom urlCreator

Because of Smarty's syntax restrictions, there is not possible to pass custom closures, like in this PHP example of custom `ActionColumn`'s `urlCreator`.

**PHP Way**

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

**Smarty Way**

Create a helper class with static function returning closure.

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

Load `GridHelper` with `{use class='app\helpers\GridHelper'}` and set `urlCreator` by calling your static function from `GridHelper`.

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
