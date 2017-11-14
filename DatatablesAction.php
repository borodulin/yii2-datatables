<?php
/**
 * @link https://github.com/borodulin/yii2-datatables
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-datatables/blob/master/LICENSE
 */

namespace conquer\datatables;

use Throwable;
use Yii;
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
        $columns = $this->getParam('columns', []);
        $order = $this->getParam('order', []);
        if (is_callable($this->filterCallback)) {
            call_user_func($this->filterCallback, $filteredQuery, $columns, $search);
        } elseif ($filteredQuery instanceof ActiveQuery) {
            $this->activeFilter($filteredQuery, $columns, $search);
        }
        if (is_callable($this->orderCallback)) {
            call_user_func($this->orderCallback, $filteredQuery, $columns, $order);
        } elseif ($filteredQuery instanceof ActiveQuery) {
            $this->activeOrder($filteredQuery, $columns, $order);
        }

        $filteredQuery->offset($this->getParam('start', 0));
        $filteredQuery->limit($this->getParam('length', -1));
        try {
            return [
                'draw' => (int)$draw,
                'recordsTotal' => (int)$query->count(),
                'recordsFiltered' => (int)$filteredQuery->count(),
                'data' => $filteredQuery->all(),
            ];
        } catch (Throwable $e) {
            return ['error' => $e->getMessage()];
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
        foreach ($columns as $column) {
            $name = $column['data'];
            if (isset($schema[$name], $column['searchable']) && $column['searchable'] === 'true') {
                if (!empty($column['search']['value'])) {
                    $searchValue = $column['search']['value'];
                } elseif (!empty($search['value'])) {
                    $searchValue = $search['value'];
                } else {
                    continue;
                }
                $type = $schema[$name]->phpType;
                if ($type === 'integer' && !is_int($searchValue)) {
                    continue;
                }
                if ($type === 'boolean') {
                    $searchValue = filter_var($searchValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                    if ($searchValue === null) {
                        continue;
                    }
                }
                if ($type === 'double' && !is_numeric($searchValue)) {
                    continue;
                }
                $operator = ($type === 'string') ? 'like' : '=';
                $query->orFilterWhere([$operator, $name, $searchValue]);
            }
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
            if (isset($schema[$column['data']], $column['orderable']) && $column['orderable'] === 'true') {
                $query->addOrderBy([
                    $column['data'] => $order['dir'] === 'desc' ? SORT_DESC : SORT_ASC
                ]);
            }
        }
    }
}