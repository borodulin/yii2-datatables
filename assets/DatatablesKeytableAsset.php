<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use yii\web\AssetBundle;

/**
 * Class DatatablesKeytableAsset
 * @package conquer\datatables\assets
 */
class DatatablesKeytableAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables.net-keytable';
    
    public $js = [
        'js/dataTables.keytable.min.js',
    ];
    
    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}