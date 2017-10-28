<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesSelectAsset
 * @package conquer\datatables\assets
 */
class DatatablesSelectAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-select';
    
    public $js = [
        'js/dataTables.select.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}