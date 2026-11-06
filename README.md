# DataTables widget for Yii2 framework

[![Latest Version](https://img.shields.io/packagist/v/conquer/datatables.svg)](https://packagist.org/packages/conquer/datatables)
[![Total Downloads](https://img.shields.io/packagist/dt/conquer/datatables.svg)](https://packagist.org/packages/conquer/datatables)
[![License](https://img.shields.io/packagist/l/conquer/datatables.svg)](LICENSE)

## Description

Yii2 integration of [DataTables](https://datatables.net) 1.x with Bootstrap 3, 4 or 5 styling:

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
composer require conquer/datatables:^2.1
```

### Bootstrap version

The styling follows the installed Yii Bootstrap extension (`yiisoft/yii2-bootstrap` → 3, `yii2-bootstrap4` → 4,
`yii2-bootstrap5` → 5); set `'bsVersion' => 5` on the widget to choose it explicitly.
Bootstrap 3 styling is installed with this extension. For Bootstrap 4 and 5 install the DataTables styling packages
of the core and of the extensions you use, for example:

```bash
# Bootstrap 4
composer require bower-asset/datatables.net-bs4:^1.10.16 bower-asset/datatables.net-buttons-bs4:^1.1
# Bootstrap 5
composer require npm-asset/datatables.net-bs5:^1.13 npm-asset/datatables.net-buttons-bs5:^1.7
```

| Extension | Bootstrap 4 | Bootstrap 5 |
|---|---|---|
| core | `bower-asset/datatables.net-bs4:^1.10.16` | `npm-asset/datatables.net-bs5:^1.13` |
| AutoFill | `bower-asset/datatables.net-autofill-bs4:^2.2` | `npm-asset/datatables.net-autofill-bs5:^2.3` |
| Buttons | `bower-asset/datatables.net-buttons-bs4:^1.1` | `npm-asset/datatables.net-buttons-bs5:^1.7` |
| ColReorder | `bower-asset/datatables.net-colreorder-bs4:^1.4` | `npm-asset/datatables.net-colreorder-bs5:^1.5` |
| FixedColumns | `bower-asset/datatables.net-fixedcolumns-bs4:^3.2` | `npm-asset/datatables.net-fixedcolumns-bs5:^3.3` |
| FixedHeader | `bower-asset/datatables.net-fixedheader-bs4:^3.1` | `npm-asset/datatables.net-fixedheader-bs5:^3.1` |
| KeyTable | `bower-asset/datatables.net-keytable-bs4:^2.3` | `npm-asset/datatables.net-keytable-bs5:^2.6` |
| Responsive | `bower-asset/datatables.net-responsive-bs4:^2.2` | `npm-asset/datatables.net-responsive-bs5:^2.2` |
| RowGroup | `bower-asset/datatables.net-rowgroup-bs4:^1.0` | `npm-asset/datatables.net-rowgroup-bs5:^1.1` |
| RowReorder | `bower-asset/datatables.net-rowreorder-bs4:^1.2` | `npm-asset/datatables.net-rowreorder-bs5:^1.2` |
| Scroller | `bower-asset/datatables.net-scroller-bs4:^1.4` | `npm-asset/datatables.net-scroller-bs5:^2.0` |
| Select | `bower-asset/datatables.net-select-bs4:^1.2` | `npm-asset/datatables.net-select-bs5:^1.3` |

A missing styling package is reported with an `InvalidConfigException` naming the package to install.
Bootstrap itself (CSS and JavaScript) is included by your layout, as usual.

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

Search conditions are added to the query with `AND`, so conditions of the configured query
(for example `->where(['tenant_id' => $tenantId])`) always apply. The global search matches any searchable column,
column searches must all match.

DataTables inserts cell data as HTML, so string values are HTML-encoded by default.
List attributes that intentionally contain markup built by the server in `rawAttributes`
(`'encode' => false` disables encoding completely):

```php
'rawAttributes' => ['actions'],
```

The widget encodes client-side `data` the same way (`encodeData`, `rawAttributes`).

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

## Upgrading to 2.0

- String values returned by `DatatablesAction` and client-side `data` of the widget are HTML-encoded.
  If a column intentionally contains HTML built on the server, add it to `rawAttributes`
  (or set `'encode' => false` / `'encodeData' => false` to restore the 1.x behaviour).
- A column search with a value that cannot match the column type (for example text in an integer column)
  now returns no rows instead of being ignored.

## License

**conquer/datatables** is released under the MIT License. See the bundled [`LICENSE`](LICENSE) for details.
