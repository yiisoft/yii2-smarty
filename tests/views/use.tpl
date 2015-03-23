{use class='yii\helpers\Html'}
{use class='yii\widgets\Menu' type='function'}
{use class='yii\widgets\ActiveForm' type='block'}

{ActiveForm id=$app->name action=$app->homeUrl
 options=['class' => 'test']}

    {Menu options=['class' => 'test2'] items=[
        ['label' => 'Home', 'url' => 'http://example.com/']
    ]}

{/ActiveForm}
