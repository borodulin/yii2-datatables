<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesRowReorderBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesRowReorderBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-rowreorder';

    public $depends = [
        'conquer\datatables\assets\DatatablesRowReorderAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}