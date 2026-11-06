<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesColReorderBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesColReorderBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-colreorder';

    public $depends = [
        'conquer\datatables\assets\DatatablesColReorderAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}