<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\smarty;

/**
 * Part of Smarty 2 support for SmartyViewRenderer
 * @author Anton Marin <antonaryo85@gmail.com>
 * @since 2.0
 */
class Smarty2Extension extends Extension
{
    /**
     * @inheritdoc
     */
    public function compilerUse($params, $template)
    {
        if (!is_array($params)) {
            $params = explode(' ', $params);
            $newArgs = [];
            foreach($params as $param) {
                list($key, $value) = explode('=', $param);
                $newArgs[$key] = $value;
            }
        }

        return parent::compilerUse($newArgs, $template);
    }

}