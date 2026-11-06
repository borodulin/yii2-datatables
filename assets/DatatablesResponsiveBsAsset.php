<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesResponsiveBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesResponsiveBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-responsive';

    public $depends = [
        'conquer\datatables\assets\DatatablesResponsiveAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}