Installation
============

Installation consists of two parts: getting composer package and configuring an application. 

## Installing an extension

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisoft/yii2-smarty
```

or add

```json
"yiisoft/yii2-smarty": "~2.0.0"
```

to the require section of your composer.json.

Note that the smarty composer package is distributed using subversion so you may need to install subversion.

## Configuring application

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        'view' => [
            'renderers' => [
                'tpl' => [
                    'class' => 'yii\smarty\ViewRenderer',
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],
    ],
];
```

After configuration is done, you need to create templates in files that have the `.tpl` extension (or use another file
extension but configure the component accordingly). Unlike standard view files, when using Smarty you must include
the extension in your `$this->render()` or `$this->renderPartial()` controller calls:

```php
return $this->render('renderer.tpl', ['username' => 'Alex']);
```
