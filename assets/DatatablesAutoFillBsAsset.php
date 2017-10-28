<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesAutoFillBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesAutoFillBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-autofill-bs';
    
    public $css = [
        'css/autoFill.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAutoFillAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}