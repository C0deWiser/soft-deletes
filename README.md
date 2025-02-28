# Laravel Soft Deleting (Passive)

This package provides Laravel Model Soft Deleting functionality that is 
disabled by default. No models are scoped out implicitly.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codewiser\SoftDeletes\PassiveSoftDeletes;

class Flight extends Model
{
    use PassiveSoftDeletes;
}
```

Alternatively to Laravel `SoftDeletes`, `PassiveSoftDeletes` counts model as 
thrashed not only then `deleted_at` attribute is not null but `deleted_at` 
is in the past. So you may trash models in advance.

As `PassiveSoftDeletes` doesn't apply any scopes by default, 
`Route::withTrashed()` is unnecessary. You should explicitly scope queries. 

## Builder

`PassiveSoftDeletes` doesn't utilize `withTrashed` builder method. You may 
use it but it has no sense.

`withoutTrashed` and `onlyTrashed` methods influence to records trashed to 
current moment of time. You may pass the exact date.

```php

// Will exclude flights with `deleted_at` < now()

Flight::query()->withoutTrashed();

// Will return only flights with `deleted_at` in a next month

Flight::query()->onlyTrashed(now()->addMonth());
```