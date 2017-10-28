<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesKeytableBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesKeytableBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-keytable-bs';
    
    public $css = [
        'css/keytable.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesKeytableAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}