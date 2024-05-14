Provides a trait to allow adding reaction (like) of any Eloquent models within your app 
#### note : this trait for toggle like (click on button to add like and click on the same button to remove like (Similar to the like button on Instagram)) 

## Installation
You can install the package via composer:

```bash
composer require ayham/like
```
You can publish the migrations with:

```bash
php artisan vendor:publish --provider="Ayham\Like\Provider\LikeServiceProvider" --tag="migrations"
```
After that run the migrations:

```bash
php artisan migrate
```


As with most Laravel packages, if you're using Laravel 5.5 or later, the package will be auto-discovered ([learn more if this is new to you](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518)).

If you're using a version of Laravel before 5.5, you'll need to register the Rateable *service provider*. In your `config/app.php` add `    Ayham\Like\Provider\LikeServiceProvider::class` to the end of the `$providers` array.

````php
'providers' => [

    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    ...
    Ayham\Like\Provider\LikeServiceProvider::class,

],
````

## Usage

If I want to give the user the ability to add a reaction "like" to liking a  model , import the `Likeable` trait in the model.

```php
<?php

namespace App\Models;

use Ayham\Like\Trait\Likeable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Likeable;
    //...
}

```

in user model i have  to add a hasMany relationship to give the user the right to add likes to more than one model

```php
namespace App\Models;

use Ayham\Like\Model\Like;
//...

class User extends Authenticatable
{
    //...
    protected $fillable = [
      //...
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
```

Now, your model has access to a few additional methods.

Now to add like  when click on like button on a post, for example we use `toggleLike()` . Note that the user must be added as a parameter:

```php
$post = Post::first();
$user = Auth::user();
$post->toggleLike($user);
```

Then to display the number of visitors we use `likesCount()`

```php
$post->likesCount();
dd($post->likesCount());
```

if you are using resources (Laravel API Resources) to customize the return value

```php
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // ...
            'likes_count'  => $this->likesCount(),
        ];
    }
}
```
