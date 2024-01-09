Синтаксис шаблонизатора
=======================

Лучшим ресурсом для изучения основ шаблонизатора Smarty является официальная документация, которую можно найти тут - 
[www.smarty.net](https://www.smarty.net/docs/en/). Ниже описаны синтаксические расширения, специфичные для Yii:

## Установка свойств объекта

Специальная функция `set` позволяет устанавливать основные свойства представления и контроллера. На данный момент доступны 
свойства `title`, `theme` и `layout`:

```smarty
{set title="My Page"}
{set theme="frontend"}
{set layout="main.tpl"}
```

Для заголовка можно использовать отдельный блок:

```smarty
{title}My Page{/title}
```

## Установка мета-тегов

Мета-теги могут быть объявлены следующим образом:

```smarty
{meta keywords="Yii,PHP,Smarty,framework"}
```

Также можно использовать отдельный блок:

```smarty
{description}This is my page about Smarty extension{/description}
```

## Импортирование статических классов, использование виджетов в виде функций и блоков

Вы можете импортировать дополнительные статические классы прямо в шаблоне:

```smarty
{use class="yii\helpers\Html"}
{Html::mailto('eugenia@example.com')}
```

Если хотите, можете указывать псевдонимы:

```smarty
{use class="yii\helpers\Html" as="Markup"}
{Markup::mailto('eugenia@example.com')}
```

Расширение позволяет использовать виджеты в удобной форме, конвертируя их синтаксис в вызовы функций или блоки. Для
обычных виджетов можно использовать функцию следующим образом:

```smarty
{use class='@yii\grid\GridView' type='function'}
{GridView dataProvider=$provider}
```

Для виджетов с методами `begin` и `end`, таких как ActiveForm, лучше использовать блоки:

```smarty
{use class='yii\widgets\ActiveForm' type='block'}
{ActiveForm assign='form' id='login-form' action='/form-handler' options=['class' => 'form-horizontal']}
    {$form->field($model, 'firstName')}
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <input type="submit" value="Login" class="btn btn-primary" />
        </div>
    </div>
{/ActiveForm}
```

Если какой-либо виджет используется практически везде, то лучше объявить его в конфиге приложения и убрать из шаблонов 
вызовы `{use class`:

```php
'components' => [
    'view' => [
        // ...
        'renderers' => [
            'tpl' => [
                'class' => 'yii\smarty\ViewRenderer',
                'widgets' => [
                    'blocks' => [
                        'ActiveForm' => '\yii\widgets\ActiveForm',
                    ],
                ],
            ],
        ],
    ],
],
```

## Интеграция шаблонов

Интегрировать другие шаблоны в текущий шаблон можно с помощью двух операторов `include` и `extends`:

```smarty
{include 'comment.tpl'}
{extends 'post.tpl'}

{include '@app/views/snippets/avatar.tpl'}
{extends '@app/views/layouts/2columns.tpl'}
```

В первом случае файл вида будет искаться относительно текущего пути. Это значит что файлы `comment.tpl` и `post.tpl` 
будут искаться в той же директории, что и текущий отображаемый шаблон.

Во втором случае мы используем псевдонимы путей. Все псевдонимы Yii, такие как @app, доступны по умолчанию.

## CSS, JavaScript и ассеты

Для регистрации внешних файлов JavaScript и CSS используйте следующий синтаксис:

```smarty
{registerJsFile url='https://maps.google.com/maps/api/js?sensor=false' position='POS_END'}
{registerCssFile url='@assets/css/normalizer.css'}
```

Для использования JavaScript и CSS прямо в шаблоне, есть удобные блоки:

```smarty
{registerJs key='show' position='POS_LOAD'}
    $("span.show").replaceWith('<div class="show">');
{/registerJs}

{registerCss}
div.header {
    background-color: #3366bd;
    color: white;
}
{/registerCss}
```

Ассеты регистрируются следующим образом:

```smarty
{use class="yii\web\JqueryAsset"}
{JqueryAsset::register($this)|void}
```

Здесь используется модификатор `void`, потому что не нужно сохранять результат вызова метода.

## URLs

Для построения URL-ов вы можете использовать следующие функции:

```smarty
<a href="{path route='blog/view' alias=$post.alias}">{$post.title}</a>
<a href="{url route='blog/view' alias=$post.alias}">{$post.title}</a>
```

Функция `path` генерирует относительный URL, `url` - абсолютный. Внутри себя обе функции используют [[\yii\helpers\Url]].

## Дополнительные переменные

Следующие переменные всегда определены в шаблонах Smarty:

- `app`, которая соответствует `\Yii::$app`
- `this`, которая соответствует текущему объекту `View`

## Доступ к параметрам конфигурации

Параметры Yii, доступные в коде приложения через `Yii::$app->params->something`, можно использовать так: 

```smarty
{#something#}
```
