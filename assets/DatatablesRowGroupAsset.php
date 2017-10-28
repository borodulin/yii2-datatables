<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesRowGroupAsset
 * @package conquer\datatables\assets
 */
class DatatablesRowGroupAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-rowgroup';
    
    public $js = [
        'js/dataTables.rowGroup.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}