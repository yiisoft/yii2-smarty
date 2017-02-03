<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\smarty;

use Smarty;

/**
 * Smarty 2 support for SmartyViewRenderer
 * @author Anton Marin <antonaryo85@gmail.com>
 * @since 2.0
 */
class Smarty2Adapter
{
    /** @var Smarty */
    protected $smarty;

    /**
     * @param Smarty $smarty
     */
    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
        $this->smarty->_plugins['classes'] = [];
    }

    public function setCompileDir($path)
    {
        $this->smarty->compile_dir = $path;
    }

    public function setCacheDir($path)
    {
        $this->smarty->cache_dir = $path;
    }

    public function setTemplateDir($path)
    {
        $this->smarty->template_dir = $path;
    }

    public function addPluginsDir($path)
    {
        $this->smarty->plugins_dir = array_merge($this->smarty->plugins_dir, (array)$path);
    }

    /**
     * @todo implement
     * @param string $classAlias
     * @param string $className
     *
     * @return static
     */
    public function registerClass($classAlias, $className)
    {
        return $this;
    }

    /**
     * @param string $type type of plugin function|block|compiler|modifier
     * @param string $tag tag name
     * @param string|array $plugin callable
     *
     * @return static
     */
    public function registerPlugin($type, $tag, $plugin)
    {
        switch ($type) {
            case 'function':
                $this->smarty->register_function($tag, $plugin);
                break;
            case 'block':
                $this->smarty->register_block($tag, $plugin);
                break;
            case 'compiler':
                $this->smarty->register_compiler_function($tag, $plugin);
                break;
            case 'modifier':
                $this->smarty->register_modifier($tag, $plugin);
                break;
            default:
                break;
        }

        return $this;
    }

    public function createTemplate($file, $cacheId, $compileId, $params, $display)
    {
        if (!file_exists($this->smarty->compile_dir)) {
            mkdir($this->smarty->compile_dir, 0777, true);
        }
        $template = new Smarty2AdapterTemplate($this->smarty, $file, $cacheId, $compileId, $display);
        if (!$params) {
            return $template;
        }
        foreach ($params as $var => $value) {
            $template->assign($var, $value);
        }

        return $template;
    }
}
