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

This command create a html file in Project/docs, to indicate the html file path, you can use option --path

`php artisan route:docs --path=/routes/docs`

## Route description

Description are optional, but if you want to add them create a php comment over the each route in the web.php file with @description.

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

Routes params are defined with `@param name Description`

```
/**
 * @description Download photo with the photo id.
 * @param id ID of the photo in database
 */
Route::get('/photo/{id}/download', 'PhotoController@download');
```



