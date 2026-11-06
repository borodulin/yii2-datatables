<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesSelectBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesSelectBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-select';

    public $depends = [
        'conquer\datatables\assets\DatatablesSelectAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}