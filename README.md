# Documentation of Laravel Routes

This project generates a documentation for your routes of a laravel project, generates a html file with the description for each route, description include:

* Method
* Uri
* Name
* Controller
* Middleware

All this with a simple artisan command.

## Installation

This package can be installed with composer with the next command:

`composer require gussrw/laravel-routes`

## Generate HTML file

You can generate the html file from console with the next artisan command.

`php artisan route:docs`

This command create a html file in Project/docs.

## Route description

Description are optional, but if you want to add them create a php comment over the each route in the web.php file with `@description`.

```
/**
 * @description Show the home page of the site
 */
Route::get('/home', 'HomeController@index') -> name('home.index');
```

### Resources routes

The descriptions in the resource type routes are identified by their method in the controller.

```
/**
 * @index Show the main view
 * @create Show the view to create a photo
 * @store Save a photo in database
 * @edit Show the view to edit a photo
 * @update Update photo data in database
 * @destroy Delete a photo in database
 */
Route::resource('photos', 'PhotoController');
```

## Params

Routes params are defined with `@param name Description`, you can use  @param in resource type routes.

```
/**
 * @description Download photo with the photo id.
 * @param id ID of the photo in database
 */
Route::get('/photo/{id}/download', 'PhotoController@download');
```

## Options

#### Lang

To show the documentation in another language, you can use option `--lang`  , default is `en`

`php artisan route:docs --lang=es`

Languages ​​currently available:

* en     set to english
* es     set to spanish

#### Path

To indicate the html file path, you can use option `--path`  , default is `/docs`

`php artisan route:docs --path=/routes/docs`

#### Commented

To show only the routes that have a comment, you can use the option `--commented`  , default is `false`

`php artisan route:docs --commented=true`

#### Sort By

To sort the routes by some property, you can use the option `--sortby`  ,default is `uri`

`php artisan route:docs --sortby=name`

Properties available to order:

* method
* uri
* name
* action
* middleware
* comment



