テンプレート構文
================

Smarty のテンプレートの構文を学ぶための最善のリソースは、[www.smarty.net](http://www.smarty.net/docs/ja/) にある公式ドキュメントです。
それに追加して、下記に説明する Yii 固有の拡張構文があります。

## オブジェクトのプロパティを設定する

`set` と呼ばれる特別な関数を使って、ビューとコントローラの一般的なプロパティを設定することが出来ます。
現在サポートされているプロパティは、`title`、`theme` および `layout` です。

```
{set title="My Page"}
{set theme="frontend"}
{set layout="main.tpl"}
```

タイトルについては、専用のブロックもあります。

```
{title}My Page{/title}
```

## メタタグを設定する

メタタグは次のようにして設定することが出来ます。

```
{meta keywords="Yii,PHP,Smarty,framework"}
```

`description` のためには専用のブロックもあります。

```
{description}Smarty エクステンションについて説明するページです{/description}
```

## オブジェクトのメソッドを呼び出す

場合によっては、オブジェクトのメソッドを呼び出す必要があるでしょう。

## スタティックなクラスをインポートし、ウィジェットを関数およびブロックとして使用する

追加のスタティックなクラスをテンプレートの中でインポートすることが出来ます。

```
{use class="yii\helpers\Html"}
{Html::mailto('eugenia@example.com')}
```

必要であれば、カスタムエイリアスを設定することも出来ます。

```
{use class="yii\helpers\Html" as="Markup"}
{Markup::mailto('eugenia@example.com')}
```

このエクステンションは、ウィジェットを簡単に使えるように、ウィジェットの構文を関数呼び出しまたはブロックに変換します。
通常のウィジェットについては、次のように関数を使うことが出来ます。

```
{use class='@yii\grid\GridView' type='function'}
{GridView dataProvider=$provider}
```

ActiveForm のように `begin` および `end` メソッドを持つウィジェットについては、ブロックを使うほうが良いでしょう。

```
{use class='yii\widgets\ActiveForm' type='block'}
{ActiveForm assign='form' id='login-form' action='/form-handler' options=['class' => 'form-horizontal']}
    {$form->field($model, 'firstName')}
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <input type="submit" value="ログイン" class="btn btn-primary" />
        </div>
    </div>
{/ActiveForm}
```

特定のウィジェットを多用する場合は、それをアプリケーション構成の中で宣言して、テンプレートから `{use class` の呼び出しを削除するのが良いアイデアです。

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

## 他のテンプレートを参照する

`include` と `extends` 文によるテンプレートの参照には、主として二つの方法があります。


```
{include 'comment.tpl'}
{extends 'post.tpl'}

{include '@app/views/snippets/avatar.tpl'}
{extends '@app/views/layouts/2columns.tpl'}
```

最初の場合では、現在のテンプレートのパスからの相対的なパスでビューを探します。
`comment.tpl` と `post.tpl` は、現在レンダリングされているテンプレートと同じディレクトリで探されます。

第二の場合では、パスエイリアスを使います。
`@app` のような全ての Yii のエイリアスがデフォルトで利用できます。

## CSS、JavaScript およびアセットバンドル

JavaScript と CSS のファイルを登録するためには、次の構文を使うことが出来ます。

```
{registerJsFile url='http://maps.google.com/maps/api/js?sensor=false' position='POS_END'}
{registerCssFile url='@assets/css/normalizer.css'}
```

JavaScript と CSS をテンプレートに直接書きたい場合は、便利なブロックがあります。
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

アセットバンドルは次のようにして登録することが出来ます。

```
{use class="yii\web\JqueryAsset"}
{JqueryAsset::register($this)|void}
```

ここではメソッド呼び出しの結果が必要ないので `void` 修飾子を使っています。

## URL

URL を構築するのに使える二つの関数があります。

```php
<a href="{path route='blog/view' alias=$post.alias}">{$post.title}</a>
<a href="{url route='blog/view' alias=$post.alias}">{$post.title}</a>
```

`path` は相対的な URL を生成し、`url` は絶対的な URL を生成します。
内部的には、両者とも、[[\yii\helpers\Url]] を使っています。

## 追加の変数

Smarty のテンプレート内では、次の変数が常に定義されています。

- `app` - `\Yii::$app` オブジェクト
- `this` - 現在の `View` オブジェクト

## 構成情報のパラメータにアクセスする

アプリケーションにおいて `Yii::$app->params->something` によって取得できるパラメータは、次のようにして使用することが出来ます。

```
`{#something#}`
```
