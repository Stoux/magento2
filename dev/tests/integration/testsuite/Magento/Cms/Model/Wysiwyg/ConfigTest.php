<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Cms\Model\Wysiwyg;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestModuleWysiwygConfig\Model\Config as TestModuleWysiwygConfig;

/**
 * @magentoAppArea adminhtml
 */
class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    private $model;

    protected function setUp()
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->model = $objectManager->create(\Magento\Cms\Model\Wysiwyg\Config::class);
    }

    /**
     * Tests that config returns valid config array in it
     */
    public function testGetConfig()
    {
        $config = $this->model->getConfig();
        $this->assertInstanceOf(\Magento\Framework\DataObject::class, $config);
    }

    /**
     * Tests that config returns right urls going to the published library path
     */
    public function testGetConfigCssUrls()
    {
        $config = $this->model->getConfig();
        $publicPathPattern = 'http://localhost/pub/static/%s/adminhtml/Magento/backend/en_US/mage/%s';
        $tinyMce4Config = $config->getData('tinymce4');
        $this->assertStringMatchesFormat($publicPathPattern, $tinyMce4Config['content_css']);
    }

    /**
     * Test enabled module is able to modify WYSIWYG config
     * @return void
     *
     * @magentoConfigFixture default/cms/wysiwyg/editor testAdapter
     */
    public function testEnabledModuleIsAbleToModifyConfig()
    {
        $config = $this->model->getConfig();
        $this->assertEquals(TestModuleWysiwygConfig::CONFIG_HEIGHT, $config['height']);
        $this->assertEquals(TestModuleWysiwygConfig::CONFIG_CONTENT_CSS, $config['content_css']);
    }
}
