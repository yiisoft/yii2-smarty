<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\smarty;

use Smarty;

/**
 * Part of Smarty 2 support for SmartyViewRenderer
 * @author Anton Marin <antonaryo85@gmail.com>
 * @since 2.0
 */
class Smarty2AdapterTemplate
{
    /** @var Smarty */
    protected $smarty;
    /** @var string template filename */
    protected $resourceName;
    protected $cacheId;
    protected $compileId;
    /** @var bool */
    protected $display;

    public function __construct(Smarty $smarty, $resourceName, $cacheId, $compileId, $display)
    {
        $this->smarty = $smarty;
        $this->resourceName = $resourceName;
        $this->cacheId = $cacheId;
        $this->compileId = $compileId;
        $this->display = $display;
    }

    public function assign($var, $value)
    {
        $this->smarty->assign($var, $value);
    }

    public function fetch()
    {
        return $this->smarty->fetch($this->resourceName, $this->cacheId, $this->compileId, $this->display);
    }
}
