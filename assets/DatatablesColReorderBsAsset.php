<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesColReorderBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesColReorderBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-colreorder-bs';
    
    public $css = [
        'css/colReorder.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesColReorderAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}