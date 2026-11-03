# DataTables widget for Yii2 framework

[![Latest Version](https://img.shields.io/packagist/v/conquer/datatables.svg)](https://packagist.org/packages/conquer/datatables)
[![Total Downloads](https://img.shields.io/packagist/dt/conquer/datatables.svg)](https://packagist.org/packages/conquer/datatables)
[![License](https://img.shields.io/packagist/l/conquer/datatables.svg)](LICENSE)

## Description

Yii2 integration of [DataTables](https://datatables.net) 1.10 with Bootstrap styling:

- `DatatablesWidget` renders a table and initializes DataTables, registering only the extensions you use
  (AutoFill, Buttons, ColReorder, FixedColumns, FixedHeader, KeyTable, Responsive, RowGroup, RowReorder, Scroller, Select);
- `DatatablesAction` implements the DataTables [server-side processing](https://datatables.net/manual/server-side) protocol
  on top of a Yii `Query` / `ActiveQuery`, including paging, ordering and global/per-column search.

The interface language is taken from `Yii::$app->language` automatically.

## Requirements

- PHP 7.4 or 8.x
- Yii 2.0.6 or newer (2.0.x)
- [asset-packagist](https://asset-packagist.org) repository configured in your application's `composer.json` (standard for Yii2 app templates)

## Installation

Install the extension via [Composer](https://getcomposer.org):

```bash
composer require conquer/datatables:^1.1
```

## Usage

### Server-side processing

Controller:

```php
use conquer\datatables\DatatablesAction;

class UserController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'datatables' => [
                'class' => DatatablesAction::class,
                'query' => User::find(),
                // only these fields are sent to the browser
                'attributes' => ['id', 'username', 'email'],
                // maximum rows per request (client "length", including -1, is capped)
                'maxLength' => 500,
            ],
        ];
    }
}
```

For an `ActiveQuery`, searching and ordering are applied automatically to the columns that exist
in the table schema (`LIKE` for strings, `=` for numbers and booleans). For any other query,
or to customize the behavior, provide callbacks:

```php
'filterCallback' => function ($query, $columns, $search) { /* ... */ },
'orderCallback' => function ($query, $columns, $order) { /* ... */ },
```

`query` can also be a callable returning the query.

> **Security:** without `attributes` every column selected by the query is returned to the client
> (for `User::find()` that includes password hashes and tokens). Always set `attributes` or restrict `select()`.

View:

```php
use conquer\datatables\DatatablesWidget;

echo DatatablesWidget::widget([
    'ajax' => ['user/datatables'],
    'columns' => [
        'id' => 'ID',
        'username' => 'Username',
        'email' => 'Email',
    ],
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'responsive' => true,
    'stateSave' => true,
]);
```

Keys of `columns` are the data fields, values are the column titles.
When `ajax` is set, `serverSide` is enabled by default.

### Client-side data

```php
echo DatatablesWidget::widget([
    'columns' => ['name' => 'Name', 'price' => 'Price'],
    'data' => [
        ['name' => 'Apple', 'price' => 1.2],
        ['name' => 'Orange', 'price' => 0.9],
    ],
]);
```

### Options

Common DataTables options are available as widget properties: `autoWidth`, `deferRender`, `info`,
`lengthChange`, `ordering`, `paging`, `processing`, `scrollX`, `scrollY`, `searching`, `stateSave`.
Extension options (`autoFill`, `buttons`, `colReorder`, `fixedColumns`, `fixedHeader`, `keys`,
`responsive`, `rowGroup`, `rowReorder`, `scroller`, `select`) also register the corresponding assets.
Any other [DataTables option](https://datatables.net/reference/option/) can be passed via `options`.

## License

**conquer/datatables** is released under the MIT License. See the bundled [`LICENSE`](LICENSE) for details.
