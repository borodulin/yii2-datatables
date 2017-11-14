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
use conquer\datatables\assets\DatatablesRowReorderBsAsset;
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
     * ["name" => "title"]
     * @var array
     */
    public $columns;

    /**
     * Html options
     * @var array
     */
    public $tableOptions = [];

    /**
     * Datatables options
     * @var array
     */
    public $options;

    /**
     * i18n
     * @var string
     */
    public $language;

    /**
     * @see Url::to()
     * @var string|array
     * @link https://datatables.net/reference/option/ajax
     */
    public $ajax;

    /**
     * Data to use as the display data for the table
     * @var array
     * @link https://datatables.net/reference/option/data
     */
    public $data;

    /**
     * AutoFill adds an Excel like data fill option to DataTables,
     * allowing click and drag over cells,
     * filling in information and incrementing numbers as needed.
     * @var boolean|array
     * @link https://datatables.net/extensions/autofill/
     */
    public $autoFill;

    /**
     * The Buttons extension for DataTables provides a common set of options,
     * API methods and styling to display buttons on a page that will interact with a DataTable.
     * Modules are also provided for data export, printing and column visibility control.
     * buttons: [
     *    'copy', 'excel', 'pdf'
     * ]
     * @var array
     * @link https://datatables.net/extensions/buttons/
     */
    public $buttons;

    /**
     * ColReorder allows the end user to modify the column order of a table through drop-and-drag of column headers.
     * @var boolean|array
     * @link https://datatables.net/extensions/colreorder/
     */
    public $colReorder;

    /**
     * FixedColumns "freezes" in place the left most columns in a scrolling DataTable,
     * to provide a guide to the end user (for example an index column).
     * @var boolean|array
     * @link https://datatables.net/extensions/fixedcolumns/
     */
    public $fixedColumns;

    /**
     * The FixedHeader plug-in will freeze in place the header,
     * footer and left and/or right most columns in a DataTable,
     * ensuring that title information will remain always visible.
     * @var boolean|array
     * @link https://datatables.net/extensions/fixedheader/
     */
    public $fixedHeader;

    /**
     * KeyTable provides Excel like cell navigation on any table.
     * Events (focus, blur, action etc) can be assigned to individual cells, columns, rows or all cells.
     * @var boolean|array
     * @link https://datatables.net/extensions/keytable/
     */
    public $keys;

    /**
     * Responsive will automatically optimise the table's layout for different screen sizes through
     * the dynamic column visibility control, making your tables useful on desktop and mobile screens.
     * @var boolean|array
     * @link https://datatables.net/extensions/responsive/
     */
    public $responsive;

    /**
     * RowGroup provides a simple API to visually grouped sets of data in a DataTable.
     * This grouping, which can be dynamically controlled with the API,
     * can be used to provide customised aggregation of data,
     * letting users quickly view a summary of like data.
     * @var boolean|array
     * @link https://datatables.net/extensions/rowgroup/
     */
    public $rowGroup;

    /**
     * RowReorder adds the ability for rows in a DataTable to be reordered through user interaction
     * with the table (click and drag / touch and drag).
     * Integration with Editor's multi-row editing feature is also available to update rows immediately.
     * @var boolean|array
     * @link https://datatables.net/extensions/rowreorder/
     */
    public $rowReorder;

    /**
     * A virtual renderer for DataTables, allowing the table to look like it scrolls for the full data set,
     * but actually only drawing the rows required for the current display, for fast operation.
     * @var boolean|array
     * @link https://datatables.net/extensions/scroller/
     */
    public $scroller;

    /**
     * Select adds item selection capabilities to a DataTable.
     * Items can be rows, columns or cells, which can be selected independently, or together.
     * Item selection can be particularly useful in interactive tables where users
     * can perform some action on the table such as editing.
     * @var boolean|array
     * @link https://datatables.net/extensions/select/
     */
    public $select;

    /**
     * Feature control DataTables' smart column width handling
     * @var boolean
     */
    public $autoWidth;

    /**
     * Feature control deferred rendering for additional speed of initialisation.
     * @var boolean
     */
    public $deferRender;

    /**
     * Feature control table information display field
     * @var boolean
     */
    public $info;

    /**
     * Feature control the end user's ability to change the paging display length of the table.
     * @var boolean
     */
    public $lengthChange;

    /**
     * Feature control ordering (sorting) abilities in DataTables.
     * @var boolean
     */
    public $ordering;

    /**
     * Enable or disable table pagination.
     * @var boolean
     */
    public $paging;

    /**
     * Feature control the processing indicator.
     * @var boolean
     */
    public $processing;

    /**
     * Horizontal scrolling
     * @var boolean
     */
    public $scrollX;

    /**
     * Vertical scrolling
     * @var string
     */
    public $scrollY;

    /**
     * Feature control search (filtering) abilities
     * @var boolean
     */
    public $searching;

    /**
     * State saving - restore table state on page reload
     * @var boolean
     */
    public $stateSave;

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
        foreach ((array)$this->columns as $column) {
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
        if ($this->ajax !== null) {
            $options['ajax'] = $this->ajax;
            if (!isset($options['serverSide'])) {
                $options['serverSide'] = true;
            }
        }
        if ($this->data !== null) {
            $options['data'] = $this->data;
        }
        if ($this->autoFill !== null) {
            $options['autoFill'] = $this->autoFill;
            DatatablesAutoFillBsAsset::register($view);
        }
        if ($this->buttons !== null) {
            $options['buttons'] = $this->buttons;
            DatatablesButtonsBsAsset::register($view);
        }
        if ($this->colReorder !== null) {
            $options['colReoreder'] = $this->colReorder;
            DatatablesColReorderBsAsset::register($view);
        }
        if ($this->fixedColumns !== null) {
            $options['fixedColumns'] = $this->fixedColumns;
            DatatablesFixedColumnsBsAsset::register($view);
        }
        if ($this->fixedHeader !== null) {
            $options['fixedHeader'] = $this->fixedHeader;
            DatatablesFixedHeaderBsAsset::register($view);
        }
        if ($this->keys !== null) {
            $options['keys'] = $this->keys;
            DatatablesKeytableBsAsset::register($view);
        }
        if ($this->responsive !== null) {
            $options['responsive'] = $this->responsive;
            DatatablesResponsiveBsAsset::register($view);
        }
        if ($this->rowGroup !== null) {
            $options['rowGroup'] = $this->rowGroup;
            DatatablesRowGroupBsAsset::register($view);
        }
        if ($this->rowReorder !== null) {
            $options['rowReorder'] = $this->rowReorder;
            DatatablesRowReorderBsAsset::register($view);
        }
        if ($this->scroller !== null) {
            $options['scroller'] = $this->scroller;
            DatatablesScrollerBsAsset::register($view);
        }
        if ($this->select !== null) {
            $options['select'] = $this->select;
            DatatablesSelectBsAsset::register($view);
        }
        if ($this->autoWidth !== null) {
            $options['autoWidth'] = $this->autoWidth;
        }
        if ($this->deferRender !== null) {
            $options['deferRender'] = $this->deferRender;
        }
        if ($this->info !== null) {
            $options['info'] = $this->info;
        }
        if ($this->lengthChange !== null) {
            $options['lengthChange'] = $this->lengthChange;
        }
        if ($this->ordering !== null) {
            $options['ordering'] = $this->ordering;
        }
        if ($this->paging !== null) {
            $options['paging'] = $this->paging;
        }
        if ($this->processing !== null) {
            $options['processing'] = $this->processing;
        }
        if ($this->scrollX !== null) {
            $options['scrollX'] = $this->scrollX;
        }
        if ($this->scrollY !== null) {
            $options['scrollY'] = $this->scrollY;
        }
        if ($this->searching !== null) {
            $options['searching'] = $this->searching;
        }
        if ($this->stateSave !== null) {
            $options['stateSave'] = $this->stateSave;
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

    /**
     * @param $language
     * @return string|null
     */
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