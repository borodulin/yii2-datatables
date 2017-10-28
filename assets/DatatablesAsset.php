<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesAsset
 * @package conquer\datatables\assets
 */
class DatatablesAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net';

    public $js = [
        'js/jquery.dataTables.min.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}