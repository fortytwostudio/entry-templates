<?php
namespace fortytwostudio\entrytemplates\assetbundles;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use craft\web\assets\vue\VueAsset;

class ModalAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    public function init()
    {
        $this->sourcePath = "@fortytwostudio/entrytemplates/resources";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

		$this->css = [
            'css/dist/index.min.css',
        ];

        $this->js = [
            'js/modal.js',
        ];

        parent::init();
    }
}
