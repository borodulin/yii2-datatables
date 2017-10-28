<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesFixedColumnsBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesFixedColumnsBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-fixedcolumns-bs';
    
    public $css = [
        'css/fixedColumns.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesFixedColumnsAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}