<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesResponsiveAsset
 * @package conquer\datatables\assets
 */
class DatatablesResponsiveAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-responsive';
    
    public $js = [
        'js/dataTables.responsive.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}