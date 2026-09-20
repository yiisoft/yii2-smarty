<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

/**
 * @package yii2-smarty
 * @author Simon Karlen <simi.albi@gmail.com>
 */

namespace yiiunit\smarty\widgets;

use yii\base\Widget;

class DemoWidget extends Widget
{
    /**
     * @var bool Prevent
     */
    public $hidden = false;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if ($this->hidden) {
            $this->on(self::EVENT_BEFORE_RUN, function ($event) {
                /* @var $event \yii\base\WidgetEvent */

                $event->isValid = false;
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return 'test';
    }
}
