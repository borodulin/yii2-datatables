<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\extensions;

use conquer\helpers\Json;
use conquer\datatables\GridView;

/**
 * @author Andrey Borodulin
 */
abstract class BaseExtension extends \yii\web\AssetBundle
{
    public $depends = [
        'conquer\datatables\DatatablesAsset',
    ];

    protected $constructor;
    /**
     * 
     * @var GridView
     */
    protected $gridView;
    
    /**
     * 
     * @param \yii\web\View $view
     * @param GridView $gridView
     * @param array $options
     * @return string
     */
    public static function registerConstructor($view, $gridView, $options)
    {
        static::register($view)->gridView = $gridView;
        if (is_array($options)) {
            return "new $.fn.dataTable.{$this->constructor}({$gridView->options['id']}, ".Json::encode($options).");\n";
        } else {
            return "new $.fn.dataTable.{$this->constructor}($gridView->options['id']);\n";
        }
    }
}