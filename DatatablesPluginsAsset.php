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
class DatatablesPluginsAsset extends \yii\web\AssetBundle
{
	// The files are not web directory accessible, therefore we need
	// to specify the sourcePath property. Notice the @bower alias used.
	public $sourcePath = '@bower/datatables-plugins';
	
	/**
	 * Plugins configuration
	 * @example $plugins = [
	 * 		'bootstrap' => [
	 * 			'css' => 'integration/bootstrap/3/dataTables.bootstrap.css',
	 *    		'js' => 'integration/bootstrap/3/dataTables.bootstrap.min.js',
	 * 		],
	 * 		'indextovisible' => [
	 * 			'js' => 'api/fnColumnIndexToVisible.js',
	 * 		],
	 * ];
	 * @var array
	 */
	public $plugins;
	
	public function registerAssetFiles($view)
	{
		array_walk_recursive($this->plugins, function($value, $key, $u){
			if($key==='css'){
				if(is_string($value))
					$u[0][]=$value;
				elseif(is_array($value)){
					foreach ($value as $css){
						if(is_string($css))
							$u[0][]=$css;
					}
				}
			}elseif($key==='js'){
				if(is_string($value))
					$u[1][]=$value;
				elseif(is_array($value)){
					foreach ($value as $js){
						if(is_string($js))
							$u[1][]=$css;
					}
				}
			}
		}, [&$this->css, &$this->js]);
		parent::registerAssetFiles($view);
	}

	public $depends = [
		'conquer\datatables\DatatablesAsset',
	];
}