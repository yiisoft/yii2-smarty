インストール
============

インストールは二つの部分から成ります。
すなわち、composer パッケージの取得と、アプリケーションの構成です。 

## エクステンションをインストールする

このエクステンションをインストールするのに推奨される方法は [composer](http://getcomposer.org/download/) によるものです。

下記のコマンドを実行してください。

```
php composer.phar require --prefer-dist yiisoft/yii2-smarty
```

または、あなたの `composer.json` ファイルの `require` セクションに、下記を追加してください。

```
"yiisoft/yii2-smarty": "~2.0.0"
```

smarty の composer パッケージは subversion を使って配布されていますので、subversion をインストールする必要があることに注意してください。

## アプリケーションを構成する

このエクステンションを使用するためには、アプリケーションの構成情報に下記のコードを追加することが必要なだけです。

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

構成が終った後、拡張子 `.tpl` を持つファイルにテンプレートを作成しなければなりません。
(別のファイル拡張子を使う場合は、それに応じてコンポーネントの構成を修正してください。)
通常のビューファイルとは異なって、Smarty を使用する場合は、コントローラで `$this->render()` や `$this->renderPartial()` を呼ぶときにファイル拡張子を含めなければなりません。

```php
return $this->render('renderer.tpl', ['username' => 'Alex']);
```
