# Nova Ajax Select

[![Latest Version on Github](https://img.shields.io/github/release/Zenosyne-Technologies/NovaAjaxSelect.svg?style=flat-square)](https://packagist.org/packages/zenosyne/nova-ajax-select)
[![Total Downloads](https://img.shields.io/packagist/dt/Zenosyne-Technologies/NovaAjaxSelect.svg?style=flat-square)](https://packagist.org/packages/zenosyne/nova-ajax-select)

Ajax populated select fields based on the values of other fields and when they change.

This is a for of [dillingham / nova-ajax-select](https://github.com/dillingham/nova-ajax-select) which enables multiple dependencies for 1 child element.

![nova-ajax-select](https://user-images.githubusercontent.com/29180903/52602810-15c53900-2e32-11e9-9ade-492bfe80b234.gif)

### Install
```
composer require dillingham/nova-ajax-select
```

### Usage

Specify a request url & optionally the `parent($attribute)` to watch & trigger the ajax select:

```php
use Zenosyne\AjaxSelect\AjaxSelect;;
```
```php
BelongsTo::make('Company'),

AjaxSelect::make('User')
    ->get('/api/company/{company}/users')
    ->parent(['company']),
```
Add the field for index & detail views display. AjaxSelect is for forms only
```php
BelongsTo::make('User')->exceptOnForms(),
```

### Request Url:

In the above example, we say `company` is the parent.

The `{company}` url parameter will equal the selected `Company` field value.

### Response Format:

The select field expects a `value` & `display`. Map your results like so:

```php
Route::get('api/company/{company}/users', function($company_id) {

    $company = \App\Company::find($company_id);

    return $company->users->map(function($user) {
        return [ 'value' => $user->id, 'display' => $user->name ];
    });
})->middleware(['nova']);
```

### Make children depend on other children

`City` makes a request based on `State`, which makes a request based on `Country`:

```php
Select::make('Country')
    ->options([]),

AjaxSelect::make('State')
    ->get('/api/country/{country}/states')
    ->parent(['country']),

AjaxSelect::make('City')
    ->get('/api/state/{state}/cities')
    ->parent(['state']),
```
### Make multiple children depend on one parent

`File` & `Comment` will both make a request based on `Project`

```php
BelongsTo::make('Project'),

AjaxSelect::make('File')
    ->get('/{project}/files')
    ->parent(['project']),

AjaxSelect::make('Comment')
    ->get('/{project}/comments')
    ->parent(['project']),
```

### Multiple parents for 1 child

```php
AjaxSelect::make('Model')
    ->optiosn([]),

AjaxSelect::make('Attribute')
    ->get('/api/{model}')
    ->parent(['Model']),

AjaxSelect::make('Values')
    ->get('/api/{model}/{attribute}')
    ->parent(['Model', 'Attribute']),
```
