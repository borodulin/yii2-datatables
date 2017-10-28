<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesAutoFillAsset
 * @package conquer\datatables\assets
 */
class DatatablesAutoFillAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-autofill';
    
    public $js = [
        'js/dataTables.autoFill.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}