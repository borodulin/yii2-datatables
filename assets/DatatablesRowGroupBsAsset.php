<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesRowGroupBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesRowGroupBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-rowgroup-bs';
    
    public $css = [
        'css/rowGroup.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesRowGroupAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}