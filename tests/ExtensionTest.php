<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace yiiunit\smarty;

use Yii;
use yii\helpers\FileHelper;
use yii\web\View;

/**
 * @group smarty
 */
class ExtensionTest extends TestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
        FileHelper::createDirectory(Yii::getAlias('@runtime/Smarty'));
    }

    protected function tearDown()
    {
        parent::tearDown();
        FileHelper::removeDirectory(Yii::getAlias('@runtime/Smarty'));
    }

    public function testFunctions()
    {
        $functions = [
            'path' => 'functionPath',
            'url' => 'functionUrl',
            'set' => 'functionSet',
            'meta'=> 'functionMeta',
            'js' => 'functionJs',
            'registerJsFile' => 'functionRegisterJsFile',
            'registerCssFile' => 'functionRegisterCssFile'
        ];

        $renderer = new TestViewRenderer();
        $smarty = $renderer->getSmartyInstance();

        foreach ($functions as $name => $func) {
            $function = $smarty->registered_plugins['function'];
            $this->assertArrayHasKey($name, $function);
            $this->assertEquals($func, $function[$name][0][1]);
        }
    }
}

class TestViewRenderer extends \yii\smarty\ViewRenderer {

    /**
     * @return \Smarty
     */
    public function getSmartyInstance()
    {
        return $this->smarty;
    }
}
