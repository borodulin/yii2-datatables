<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesRowReorderAsset
 * @package conquer\datatables\assets
 */
class DatatablesRowReorderAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-rowreorder';
    
    public $js = [
        'js/dataTables.rowReorder.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}