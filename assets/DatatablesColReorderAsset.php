<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesColReorderAsset
 * @package conquer\datatables\assets
 */
class DatatablesColReorderAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-colreorder';
    
    public $js = [
        'js/dataTables.colReorder.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}