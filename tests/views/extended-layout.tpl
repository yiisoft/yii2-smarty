{use class='yii\widgets\Menu' type='function'}

{$this->beginContent('@yiiunit/smarty/views/layout.tpl')|void}
<div class="menu">
    {Menu options=['class' => 'test'] items=[
        ['label' => 'Home', 'url' => 'http://example.com/']
    ]}
</div>

<div class="content">
    {$content}
</div>
{$this->endContent()}
