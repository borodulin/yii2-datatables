<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesScrollerBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesScrollerBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-scroller';

    public $depends = [
        'conquer\datatables\assets\DatatablesScrollerAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}