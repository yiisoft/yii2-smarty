Template Syntax
===============

The best resource to learn Smarty template syntax is its official documentation you can find at
[www.smarty.net](http://www.smarty.net/docs/en/). Additionally there are Yii-specific syntax extensions
described below.

## Setting object properties

There's a special function called `set` that allows you to set common properties of the view and controller. Currently
available properties are `title`, `theme` and `layout`:

```
{set title="My Page"}
{set theme="frontend"}
{set layout="main.tpl"}
```

For title there's dedicated block as well:

```
{title}My Page{/title}
```

## Setting meta tags

Meta tags could be set like to following:

```
{meta keywords="Yii,PHP,Smarty,framework"}
```

There's also dedicated block for description:

```
{description}This is my page about Smarty extension{/description}
```

## Calling object methods

Sometimes you need calling

## Importing static classes, using widgets as functions and blocks

You can import additional static classes right in the template:

```
{use class="yii\helpers\Html"}
{Html::mailto('eugenia@example.com')}
```

If you want you can set custom alias:

```
{use class="yii\helpers\Html" as="Markup"}
{Markup::mailto('eugenia@example.com')}
```

Extension helps using widgets in convenient way converting their syntax to function calls or blocks. For regular widgets
function could be used like the following:

```
{use class='@yii\grid\GridView' type='function'}
{GridView dataProvider=$provider}
```

For widgets with `begin` and `end` methods such as ActiveForm it's better to use block:

```
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

If you're using particular widget a lot, it is a good idea to declare it in application config and remove `{use class`
call from templates:

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

## Referencing other templates

There are two main ways of referencing templates in `include` and `extends` statements:

```
{include 'comment.tpl'}
{extends 'post.tpl'}

{include '@app/views/snippets/avatar.tpl'}
{extends '@app/views/layouts/2columns.tpl'}
```

In the first case the view will be searched relatively to the current template path. For `comment.tpl` and `post.tpl`
that means these will be searched in the same directory as the currently rendered template.

In the second case we're using path aliases. All the Yii aliases such as `@app` are available by default.

## CSS, JavaScript and asset bundles

In order to register JavaScript and CSS files the following syntax could be used:

```
{registerJsFile url='http://maps.google.com/maps/api/js?sensor=false' position='POS_END'}
{registerCssFile url='@assets/css/normalizer.css'}
```

If you need JavaScript and CSS directly in the template there are convenient blocks:

```
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

Asset bundles could be registered the following way:

```
{use class="yii\web\JqueryAsset"}
{JqueryAsset::register($this)|void}
```

Here we're using `void` modifier because we don't need method call result.

## URLs

There are two functions you can use for building URLs:

```php
<a href="{path route='blog/view' alias=$post.alias}">{$post.title}</a>
<a href="{url route='blog/view' alias=$post.alias}">{$post.title}</a>
```

`path` generates relative URL while `url` generates absolute one. Internally both are using [[\yii\helpers\Url]].

## Additional variables

Within Smarty templates the following variables are always defined:

- `$app`, which equates to `\Yii::$app`
- `$this`, which equates to the current `View` object

## Accessing config params

Yii parameters that are available in your application through `Yii::$app->params->something` could be used the following
way:

```
`{#something#}`
```