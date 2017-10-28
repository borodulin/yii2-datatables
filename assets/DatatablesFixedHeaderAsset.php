<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesFixedHeaderAsset
 * @package conquer\datatables\assets
 */
class DatatablesFixedHeaderAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-fixedheader';
    
    public $js = [
        'js/dataTables.fixedHeader.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}