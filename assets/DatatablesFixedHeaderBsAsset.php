<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesFixedHeaderBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesFixedHeaderBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-fixedheader';

    public $depends = [
        'conquer\datatables\assets\DatatablesFixedHeaderAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}