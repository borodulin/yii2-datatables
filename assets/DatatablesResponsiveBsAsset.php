<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesResponsiveBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesResponsiveBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-responsive-bs';
    
    public $css = [
        'css/responsive.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesResponsiveAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}