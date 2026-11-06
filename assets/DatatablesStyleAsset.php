<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables\assets;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

/**
 * Bootstrap styling of DataTables or one of its extensions.
 *
 * The files are taken from the styling package of the selected Bootstrap version:
 * - Bootstrap 3: `@bower/<package>-bs` (required by this extension)
 * - Bootstrap 4: `@bower/<package>-bs4`
 * - Bootstrap 5: `@npm/<package>-bs5`
 *
 * @package conquer\datatables\assets
 */
abstract class DatatablesStyleAsset extends AssetBundle
{
    /**
     * Bootstrap version used by all styling bundles: 3, 4 or 5. Set by DatatablesWidget.
     * @var int
     */
    public static $bsVersion = 3;

    /**
     * DataTables package the styling belongs to, e.g. "datatables.net-buttons".
     * @var string
     */
    public $package;

    public function init()
    {
        $version = (int)self::$bsVersion;
        if (!in_array($version, [3, 4, 5], true)) {
            throw new InvalidConfigException('Unsupported Bootstrap version: ' . self::$bsVersion);
        }
        $suffix = $version === 3 ? '' : (string)$version;
        if ($version === 5) {
            $package = "npm-asset/{$this->package}-bs5";
            $this->sourcePath = "@npm/{$this->package}-bs5";
        } else {
            $package = "bower-asset/{$this->package}-bs{$suffix}";
            $this->sourcePath = "@bower/{$this->package}-bs{$suffix}";
        }
        $path = Yii::getAlias($this->sourcePath, false);
        if (!$path || !is_dir($path)) {
            throw new InvalidConfigException("DataTables styling for Bootstrap $version is not installed. Run: composer require $package");
        }
        $this->css = $this->find($path, "css/*.bootstrap{$suffix}.min.css");
        $this->js = $this->find($path, "js/*.bootstrap{$suffix}.min.js");
        parent::init();
    }

    /**
     * @param string $path
     * @param string $pattern
     * @return string[] paths relative to $path
     */
    private function find($path, $pattern)
    {
        $files = [];
        foreach (glob($path . '/' . $pattern) ?: [] as $file) {
            $files[] = substr($file, strlen($path) + 1);
        }
        sort($files);
        return $files;
    }
}
