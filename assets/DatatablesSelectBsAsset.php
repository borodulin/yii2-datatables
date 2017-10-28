<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesSelectBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesSelectBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-select-bs';
    
    public $css = [
        'css/select.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesSelectAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}