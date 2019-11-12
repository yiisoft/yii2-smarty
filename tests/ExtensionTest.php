<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
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

    public function testFunctionJs()
    {
        $renderer = new TestViewRenderer();
        $smarty = $renderer->getSmartyInstance();
        $this->assertArrayHasKey('js', $smarty->registered_plugins['function']);
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
