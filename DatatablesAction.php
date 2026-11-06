<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables;

use Throwable;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\web\Request;
use yii\web\Response;

/**
 * Class DatatablesAction
 * @package conquer\datatables
 */
class DatatablesAction extends Action
{

    /**
     * @var Query
     */
    public $query;

    /**
     * Applies ordering according to params from DataTable
     * Signature is following:
     * function ($query, $columns, $order)
     * @var  callable
     */
    public $orderCallback;

    /**
     * Applies filtering according to params from DataTable
     * Signature is following:
     * function ($query, $columns, $search)
     * @var callable
     */
    public $filterCallback;

    /**
     * Maximum number of rows returned per request. The client-supplied "length" (including -1, "all rows")
     * is capped by this value.
     * @var int
     */
    public $maxLength = 1000;

    /**
     * Attributes returned to the client. When null, rows are returned as the query produces them
     * (all columns of ActiveRecord models). Set it to avoid leaking columns such as password hashes.
     * @var string[]|null
     */
    public $attributes;

    /**
     * HTML-encode string values of the returned rows. DataTables inserts cell data as HTML,
     * so unencoded user data (e.g. `<img onerror=...>`) would be executed in the browser.
     * @var bool
     */
    public $encode = true;

    /**
     * Attributes that are returned without HTML encoding, e.g. columns that intentionally contain markup
     * built by the server. Their values must be safe HTML.
     * @var string[]
     */
    public $rawAttributes = [];

    /**
     * @var Request
     */
    public $request;
    /**
     * @var Response
     */
    public $response;

    /**
     * Check if query is configured
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->query === null) {
            throw new InvalidConfigException(get_class($this) . '::$query must be set.');
        }
        if (!$this->request) {
            $this->request = Yii::$app->request;
        }
        if (!$this->response) {
            $this->response = Yii::$app->response;
        }
        $this->response->format = Response::FORMAT_JSON;
    }

    /**
     * @return array
     */
    public function run()
    {
        if (is_callable($this->query)) {
            $query = call_user_func($this->query);
        } else {
            $query = $this->query;
        }
        /** @var Query $filteredQuery */
        $filteredQuery = clone $query;
        $draw = $this->getParam('draw');
        $search = $this->getParam('search', [
            'value' => null,
            'regex' => false
        ]);
        // callbacks get the raw request parameters, as before; the built-in handlers use validated ones
        $rawColumns = $this->getParam('columns', []);
        $rawOrder = $this->getParam('order', []);
        $columns = $this->normalizeColumns($rawColumns);
        $order = $this->normalizeOrder($rawOrder, $columns);
        if (!is_array($search)) {
            $search = ['value' => null, 'regex' => false];
        }
        if (is_callable($this->filterCallback)) {
            call_user_func($this->filterCallback, $filteredQuery, $rawColumns, $search);
        } elseif ($filteredQuery instanceof ActiveQuery) {
            $this->activeFilter($filteredQuery, $columns, $search);
        }
        if (is_callable($this->orderCallback)) {
            call_user_func($this->orderCallback, $filteredQuery, $rawColumns, $rawOrder);
        } elseif ($filteredQuery instanceof ActiveQuery) {
            $this->activeOrder($filteredQuery, $columns, $order);
        }

        $length = (int)$this->getParam('length', $this->maxLength);
        if ($length <= 0 || $length > $this->maxLength) {
            $length = $this->maxLength;
        }
        try {
            $recordsTotal = (int)$query->count();
            // count before paging: with GROUP BY or DISTINCT the count query keeps LIMIT/OFFSET
            $recordsFiltered = (int)$filteredQuery->count();
            $filteredQuery->offset(max(0, (int)$this->getParam('start', 0)));
            $filteredQuery->limit($length);
            return [
                'draw' => (int)$draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $this->formatRows($filteredQuery->all()),
            ];
        } catch (Throwable $e) {
            Yii::error($e, __METHOD__);
            return ['error' => YII_DEBUG ? $e->getMessage() : 'Unable to load data.'];
        }
    }

    /**
     * Extract param from request
     * @param $name
     * @param null $defaultValue
     * @return mixed
     */
    protected function getParam($name, $defaultValue = null)
    {
        if ($this->request->isPost) {
            return $this->request->post($name, $defaultValue);
        } else {
            return $this->request->get($name, $defaultValue);
        }
    }

    /**
     * Keeps only well-formed column definitions sent by DataTables.
     * @param mixed $columns
     * @return array
     */
    protected function normalizeColumns($columns)
    {
        $result = [];
        if (!is_array($columns)) {
            return $result;
        }
        foreach ($columns as $index => $column) {
            if (!is_array($column) || !isset($column['data']) || !is_string($column['data'])) {
                continue;
            }
            $value = isset($column['search']['value']) && is_string($column['search']['value']) ? $column['search']['value'] : '';
            $result[$index] = [
                'data' => $column['data'],
                'searchable' => isset($column['searchable']) && in_array($column['searchable'], [true, 'true'], true),
                'orderable' => isset($column['orderable']) && in_array($column['orderable'], [true, 'true'], true),
                'search' => ['value' => $value],
            ];
        }
        return $result;
    }

    /**
     * Keeps only orderings that refer to existing columns.
     * @param mixed $order
     * @param array $columns normalized columns
     * @return array
     */
    protected function normalizeOrder($order, $columns)
    {
        $result = [];
        if (!is_array($order)) {
            return $result;
        }
        foreach ($order as $item) {
            if (!is_array($item) || !isset($item['column']) || !is_scalar($item['column']) || !isset($columns[$item['column']])) {
                continue;
            }
            $result[] = [
                'column' => $item['column'],
                'dir' => isset($item['dir']) && $item['dir'] === 'desc' ? 'desc' : 'asc',
            ];
        }
        return $result;
    }

    /**
     * Global search matches any searchable column, column searches must all match.
     * The conditions are added with AND, so conditions of the configured query are always kept.
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $search
     * @throws InvalidConfigException
     */
    protected function activeFilter(ActiveQuery $query, $columns, $search)
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $query->modelClass;
        $schema = $modelClass::getTableSchema()->columns;
        $globalValue = isset($search['value']) && is_string($search['value']) ? $search['value'] : '';
        $global = ['or'];
        foreach ($columns as $column) {
            $name = $column['data'];
            if (!isset($schema[$name]) || empty($column['searchable'])) {
                continue;
            }
            if ($column['search']['value'] !== '') {
                $condition = $this->columnCondition($schema[$name], $column['search']['value']);
                // a column search that cannot match the column type matches nothing
                $query->andWhere($condition !== null ? $condition : '0=1');
            }
            if ($globalValue !== '' && ($condition = $this->columnCondition($schema[$name], $globalValue)) !== null) {
                $global[] = $condition;
            }
        }
        if ($globalValue !== '') {
            $query->andWhere(count($global) > 1 ? $global : '0=1');
        }
    }

    /**
     * @param \yii\db\ColumnSchema $column
     * @param string $value
     * @return array|null condition, or null when the value cannot match the column type
     */
    protected function columnCondition($column, $value)
    {
        $name = $column->name;
        switch ($column->phpType) {
            case 'integer':
                return filter_var($value, FILTER_VALIDATE_INT) === false ? null : [$name => (int)$value];
            case 'boolean':
                $bool = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                return $bool === null ? null : [$name => $bool];
            case 'double':
                return is_numeric($value) ? [$name => $value] : null;
            case 'string':
                return ['like', $name, $value];
            default:
                return [$name => $value];
        }
    }
    /**
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $orders
     */
    protected function activeOrder(ActiveQuery $query, $columns, $orders)
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $query->modelClass;
        $schema = $modelClass::getTableSchema()->columns;
        foreach ($orders as $order) {
            $column = $columns[$order['column']];
            if (isset($schema[$column['data']]) && !empty($column['orderable'])) {
                $query->addOrderBy([
                    $column['data'] => $order['dir'] === 'desc' ? SORT_DESC : SORT_ASC
                ]);
            }
        }
    }

    /**
     * @param array $rows
     * @return array
     */
    protected function formatRows($rows)
    {
        $result = [];
        foreach ($rows as $row) {
            if ($this->attributes === null) {
                if (!$this->encode) {
                    $result[] = $row;
                    continue;
                }
                $item = ArrayHelper::toArray($row);
            } else {
                $item = [];
                foreach ($this->attributes as $attribute) {
                    $item[$attribute] = ArrayHelper::getValue($row, $attribute);
                }
            }
            if ($this->encode) {
                foreach ($item as $key => $value) {
                    if (!in_array($key, $this->rawAttributes, true)) {
                        $item[$key] = static::encodeValue($value);
                    }
                }
            }
            $result[] = $item;
        }
        return $result;
    }

    /**
     * HTML-encodes strings, recursively for arrays.
     * @param mixed $value
     * @return mixed
     */
    public static function encodeValue($value)
    {
        if (is_string($value)) {
            return Html::encode($value);
        }
        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = static::encodeValue($item);
            }
        }
        return $value;
    }
}
