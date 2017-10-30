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
        } elseif ($this->query instanceof ActiveQuery) {
            $this->activeFilter($this->query, $columns, $search);
        }
        if (is_callable($this->orderCallback)) {
            call_user_func($this->orderCallback, $filteredQuery, $columns, $order);
        } elseif ($this->query instanceof ActiveQuery) {
            $this->activeOrder($this->query, $columns, $order);
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
            if (isset($schema[$column['data']], $column['searchable']) && $column['searchable'] === 'true') {
                if (isset($search['value'], $column['search']['value'])) {
                    $query->orFilterWhere([
                        'and',
                        ['like', $column['data'], $search['value']],
                        ['like', $column['data'], $column['search']['value']],
                    ]);
                } elseif (isset($search['value'])) {
                    $query->orFilterWhere(['like', $column['data'], $search['value']]);
                } elseif (isset($column['search']['value'])) {
                    $query->orFilterWhere(['like', $column['data'], $column['search']['value']]);
                }
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