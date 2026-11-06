<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesRowGroupBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesRowGroupBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-rowgroup';

    public $depends = [
        'conquer\datatables\assets\DatatablesRowGroupAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}