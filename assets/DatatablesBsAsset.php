<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;


/**
 * Class DatatablesBsAsset
 * @package conquer\datatables\assets
 */
class DatatablesBsAsset extends DatatablesStyleAsset
{
    public $package = 'datatables.net';


    public $depends = [
        'conquer\datatables\assets\DatatablesAsset',
    ];
}