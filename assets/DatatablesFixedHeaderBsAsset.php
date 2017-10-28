<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesFixedHeaderBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesFixedHeaderBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-fixedheader-bs';
    
    public $css = [
        'css/fixedHeader.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesFixedHeaderAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}