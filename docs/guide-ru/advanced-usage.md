Продвинутое использование
=========================

В этом разделе руководства объясняется, как использовать шаблонизатор Smarty в более сложных ситуациях.

## Использование callback-функции как значения колонки в GridView

Из-за ограничений синтаксиса Smarty, невозможно передать анонимную функцию в качестве значения, как в следующем 
примере на PHP:

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

Тем не менее это можно реализовать. Создайте класс-хелпер со статической функцией, определяющий логику 
форматирования данных:

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

Затем передайте вызов статического метода в значение столбца `GridView` в виде массива:

```smarty
{use class='yii\grid\GridView' type='function'}
{GridView columns=[
    [
        'class' => 'yii\grid\DataColumn',
        'value' => ['app\helpers\GridHelper', 'yourGridColumnTitleValue']
    ]
]}
```

## Произвольный ActionColumn urlCreator

Опять же, невозможно передать произвольную анонимную функцию, как в следующем примере:

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

Поэтому если используете Smarty, необходимо создать класс-хелпер со статическим методом, возвращающим анонимную функцию:

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

Далее в шаблон подключается `GridHelper` с помощью `{use class='app\helpers\GridHelper'}` и вызовом статического метода
из `GridHelper` определяется `urlCreator`:

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
