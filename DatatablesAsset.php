<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables;

/**
 * @author Andrey Borodulin
 */
class DatatablesAsset extends \yii\web\AssetBundle
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables';
	
	public $js = [
		'media/js/jquery.dataTables.min.js',
	];

	public $depends = [
		'yii\bootstrap\BootstrapPluginAsset'
	];
	/**
	 * Points to use bootstrap css
	 * @var boolean
	 */
	public $registerCss;
	
	public function registerAssetFiles($view)
	{
		if($this->registerCss){
			$this->css = [
				'media/css/jquery.dataTables.min.css',
			];
		}
		parent::registerAssetFiles($view);
	}
	
}