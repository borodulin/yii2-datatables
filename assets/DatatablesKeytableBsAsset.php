<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesKeytableBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesKeytableBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-keytable';

    public $depends = [
        'conquer\datatables\assets\DatatablesKeytableAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}