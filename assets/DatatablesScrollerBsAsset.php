<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesScrollerBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesScrollerBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-scroller-bs';
    
    public $css = [
        'css/scroller.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesSelectAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}