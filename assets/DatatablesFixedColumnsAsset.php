<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesFixedColumnsAsset
 * @package conquer\datatables\assets
 */
class DatatablesFixedColumnsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-fixedcolumns';
    
    public $js = [
        'js/dataTables.fixedColumns.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}