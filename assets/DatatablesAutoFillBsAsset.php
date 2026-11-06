<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesAutoFillBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesAutoFillBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-autofill';

    public $depends = [
        'conquer\datatables\assets\DatatablesAutoFillAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}