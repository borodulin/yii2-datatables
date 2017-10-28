<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesButtonsBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesButtonsBsAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-buttons-bs';
    
    public $css = [
        'css/buttons.bootstrap.min.css',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesButtonsAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}