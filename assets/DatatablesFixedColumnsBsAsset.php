<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesFixedColumnsBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesFixedColumnsBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-fixedcolumns';

    public $depends = [
        'conquer\datatables\assets\DatatablesFixedColumnsAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}