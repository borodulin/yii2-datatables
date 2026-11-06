<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesButtonsBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesButtonsBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net-buttons';

    public $depends = [
        'conquer\datatables\assets\DatatablesButtonsAsset',
        'conquer\datatables\assets\DatatablesBsAsset',
    ];
}