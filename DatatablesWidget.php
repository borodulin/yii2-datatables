<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables;

use conquer\datatables\assets\DatatablesAutoFillBsAsset;
use conquer\datatables\assets\DatatablesBsAsset;
use conquer\datatables\assets\DatatablesButtonsBsAsset;
use conquer\datatables\assets\DatatablesColReorderBsAsset;
use conquer\datatables\assets\DatatablesFixedColumnsBsAsset;
use conquer\datatables\assets\DatatablesFixedHeaderBsAsset;
use conquer\datatables\assets\DatatablesKeytableBsAsset;
use conquer\datatables\assets\DatatablesPluginsAsset;
use conquer\datatables\assets\DatatablesResponsiveBsAsset;
use conquer\datatables\assets\DatatablesRowGroupBsAsset;
use conquer\datatables\assets\DatatablesScrollerBsAsset;
use conquer\datatables\assets\DatatablesSelectBsAsset;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class DatatablesWidget
 * @package conquer\datatables
 */
class DatatablesWidget extends Widget
{
    /**
     * @var
     */
    public $columns;

    public $tableOptions = [];

    /**
     * @var
     */
    public $options;

    /**
     * @var
     */
    public $language;

    /**
     * @var
     */
    public $ajax;

    /**
     * @var
     */
    public $data;

    /**
     * @var boolean|array
     */
    public $autoFill;

    /**
     * buttons: [
     *    'copy', 'excel', 'pdf'
     * ]
     * @var array
     */
    public $buttons;

    /**
     * @var boolean|array
     */
    public $colReorder;

    /**
     * @var boolean|array
     */
    public $fixedColumns;

    /**
     * @var boolean|array
     */
    public $fixedHeader;

    /**
     * @var boolean|array
     */
    public $keys;

    /**
     * @var boolean|array
     */
    public $responsive;

    /**
     * @var boolean|array
     */
    public $rowGroup;

    /**
     * @var boolean|array
     */
    public $scroller;

    /**
     * @var boolean|array
     */
    public $select;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if ($this->ajax) {
            $this->ajax = Url::to($this->ajax);
        }
        if ($this->language === null) {
            $this->language = substr(Yii::$app->language, '0', 2);
        }
    }

    public function run()
    {
        $tableOptions = $this->tableOptions;
        $tableOptions['id'] = $this->options['id'];
        echo Html::beginTag('table', $tableOptions);
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
        foreach ($this->columns as $column) {
            echo Html::tag('th', $column);
        }
        echo Html::endTag('tr');
        echo Html::endTag('thead');
        echo Html::endTag('table');
        $this->registerAssets();
    }

    public function registerAssets()
    {
        $view = $this->getView();
        $options = $this->options;
        DatatablesBsAsset::register($view);
        if ($this->ajax) {
            $options['ajax'] = $this->ajax;
        }
        if ($this->data) {
            $options['data'] = $this->data;
        }
        if ($this->autoFill) {
            $options['autoFill'] = $this->autoFill;
            DatatablesAutoFillBsAsset::register($view);
        }
        if ($this->buttons) {
            $options['buttons'] = $this->buttons;
            DatatablesButtonsBsAsset::register($view);
        }
        if ($this->colReorder) {
            $options['colReoreder'] = $this->colReorder;
            DatatablesColReorderBsAsset::register($view);
        }
        if ($this->fixedColumns) {
            $options['fixedColumns'] = $this->fixedColumns;
            DatatablesFixedColumnsBsAsset::register($view);
        }
        if ($this->fixedHeader) {
            $options['fixedHeader'] = $this->fixedHeader;
            DatatablesFixedHeaderBsAsset::register($view);
        }
        if ($this->keys) {
            $options['keys'] = $this->keys;
            DatatablesKeytableBsAsset::register($view);
        }
        if ($this->responsive) {
            $options['responsive'] = $this->responsive;
            DatatablesResponsiveBsAsset::register($view);
        }
        if ($this->rowGroup) {
            $options['rowGroup'] = $this->rowGroup;
            DatatablesRowGroupBsAsset::register($view);
        }
        if ($this->scroller) {
            $options['scroller'] = $this->scroller;
            DatatablesScrollerBsAsset::register($view);
        }
        if ($this->select) {
            $options['select'] = $this->select;
            DatatablesSelectBsAsset::register($view);
        }
        if ($this->language) {
            if (strlen($this->language) === 2) {
                if ($lang = $this->i18n($this->language)) {
                    $asset = DatatablesPluginsAsset::register($view);
                    $options['language'] = [
                        'url' => $asset->baseUrl . "/i18n/$lang.lang"
                    ];
                }
            } else {
                $options['language'] = $this->language;
            }
        }
        $id = $options['id'];
        unset($options['id']);

        $columns = [];
        foreach ($this->columns as $key => $column) {
            if (is_string($key)) {
                $columns[] = [
                    'mDataProp' => $key
                ];
            }
        }
        if ($columns) {
            $options['aoColumns'] = $columns;
        }
        $options = Json::encode($options);
        $view->registerJs("$('#$id').DataTable($options);");
    }

    protected function i18n($language)
    {
        $isoCodes = [
            'af' => 'Afrikaans',
            'sq' => 'Albanian',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'hy' => 'Armenian',
            'az' => 'Azerbaijan',
            'bn' => 'Bangla',
            'eu' => 'Basque',
            'be' => 'Belarusian',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            'zh' => 'Chinese',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'et' => 'Estonian',
            'fi' => 'Finnish',
            'fr' => 'French',
            'gl' => 'Galician',
            'ka' => 'Georgian',
            'de' => 'German',
            'el' => 'Greek',
            'gu' => 'Gujarati',
            'he' => 'Hebrew',
            'hi' => 'Hindi',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'id' => 'Indonesian',
            'ga' => 'Irish',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'kk' => 'Kazakh',
            'ko' => 'Korean',
            'ky' => 'Kyrgyz',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'mk' => 'Macedonian',
            'ms' => 'Malay',
            'mn' => 'Mongolian',
            'ne' => 'Nepali',
            'nb' => 'Norwegian-Bokmal',
            'nn' => 'Norwegian-Nynorsk',
            'ps' => 'Pashto',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sr' => 'Serbian',
            'si' => 'Sinhala',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'es' => 'Spanish',
            'sw' => 'Swahili',
            'sv' => 'Swedish',
            'ta' => 'Tamil',
            'te' => 'telugu',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'cy' => 'Welsh',
        ];
        return isset($isoCodes[$language]) ? $isoCodes[$language] : null;
    }
}