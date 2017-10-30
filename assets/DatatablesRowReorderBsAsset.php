<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesRowReorderBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesRowReorderBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-rowreorder-bs';
    
    public $css = [
        'css/rowReorder.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesRowReorderAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}