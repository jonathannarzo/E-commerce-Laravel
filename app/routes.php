<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'site-admin'), function(){

	/**
	 * Sign in page
	 */
	Route::get('/', array(
		'as'	=> 'admin-login',
		'uses'	=> 'LoginController@loginPage'
	));

	/**
	 * Authenticated group
	 */
	Route::group(array('before' => 'auth'), function(){

		// cross-site request forgery (CSRF) protection group
		Route::group(array('before' => 'csrf'), function(){

			// Create New User (POST)
			Route::post('add-users/create', array(
				'as' 	=> 'account-create-post',
				'uses' 	=> 'AdminController@userCreate'
			));
		});
		
		// Dashboard
		Route::get('dashboard', array(
			'as' 	=> 'dboard',
			'uses'	=> 'AdminController@dashboard'
		));

		// Create new User Page
		Route::get('add-users', array(
			'as' 	=> 'add-users',
			'uses'	=> 'AdminController@addUsers'
		));

		// List of Users
		Route::get('users', array(
			'as' 	=> 'list-users',
			'uses'	=> 'AdminController@users'
		));

		// List of Products
		Route::get('products', array(
			'as' 	=> 'list-products',
			'uses'	=> 'AdminController@products'
		));

		// List of Categories
		Route::get('categories', array(
			'as' 	=> 'list-categories',
			'uses'	=> 'AdminController@categories'
		));

		// List of Brands
		Route::get('brands', array(
			'as' 	=> 'list-brands',
			'uses'	=> 'AdminController@brands'
		));

		// Sign Out
		Route::get('sign-out', array(
			'as' 	=> 'sign-out',
			'uses' 	=> 'AdminController@userSignout'
		));

	});

	/**
	 * Unauthenticated group
	 */
	Route::group(array('before' => 'guest'), function(){

		// cross-site request forgery (CSRF) protection group
		Route::group(array('before' => 'csrf'), function(){

			//Sign in (POST)
			Route::post('sign-in', array(
				'as' 	=> 'user-sign-in',
				'uses'	=> 'LoginController@userSignin'
			));

		});

	});

}); /* <-- site-admin */