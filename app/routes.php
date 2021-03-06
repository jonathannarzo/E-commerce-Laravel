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

/* View products client side */
Route::get('/', array(
	'as' 	=> 'client-products-page',
	'uses' 	=> 'FrontEndController@viewProducts'
));

/* Cart Routes */
Route::group(array('before' => 'csrf'), function(){
	// Add Product/s to cart
	Route::post('add-to-cart', array(
		'as' 	=> 'add-cart',
		'uses'	=> 'CartController@addUpdateCart'
	));

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

	/**
	 * Authenticated group
	 */
	Route::group(array('before' => 'auth'), function(){

		/*
		 * FOR USERS
		 */
		Route::group(array('prefix' => 'users'), function(){

			// List of Users
			Route::get('list', array(
				'as' 	=> 'list-users',
				'uses'	=> 'AdminController@users'
			));

			// View Selected to edit
			Route::get('view/{id}', array(
				'as' 	=> 'user-view',
				'uses' 	=> 'AdminController@editView'
			));

			// Single Delete
			Route::get('delete-single/{id}', array(
				'as' 	=> 'delete-single-user',
				'uses'	=> 'AdminController@deleteUser1'
			));

			// cross-site request forgery (CSRF) protection group
			Route::group(array('before' => 'csrf'), function(){

				// Create New User
				Route::post('create', array(
					'as' 	=> 'account-create-post',
					'uses' 	=> 'AdminController@userCreate'
				));

				// Multi Delete
				Route::post('delete-multi', array(
					'as' 	=> 'multi-delete-user',
					'uses'	=> 'AdminController@deleteUser2'
				));
			});
		});

		/**
		 * FOR CATEGORIES
		 */
		Route::group(array('prefix' => 'categories'), function() {
			
			// List of Categories
			Route::get('/', array(
				'as' 	=> 'list-categories',
				'uses'	=> 'CategoriesController@categories'
			));

			// View selected category in modal
			Route::get('view/{id}', array(
				'as' 	=> 'cat-id',
				'uses' 	=> 'CategoriesController@viewEdit'
			));

			// Delete Category
			Route::get('delete/{id}', array(
				'as' 	=> 'delete-single',
				'uses' 	=> 'CategoriesController@deleteCategory1'
			));

			// cross-site request forgery (CSRF) protection group
			Route::group(array('before' => 'csrf'), function(){

				// Add Category
				Route::post('create', array(
					'as'	=> 'create-category',
					'uses'	=> 'CategoriesController@newCategory'
				));

				// Update Category
				Route::post('update', array(
					'as' 	=> 'update-category',
					'uses' 	=> 'CategoriesController@updateCategory'
				));

				// Multiple Delete Categories
				Route::post('multi-delete', array(
					'as' 	=> 'delete-multi',
					'uses' 	=> 'CategoriesController@deleteCategory2'
				));
			});
		});

		/**
		 * FOR BRANDS
		 */
		Route::group(array('prefix' => 'brands'), function(){
			// List of Brands
			Route::get('/', array(
				'as' 	=> 'list-brands',
				'uses'	=> 'BrandsController@brands'
			));

			// View Selected in modal
			Route::get('view/{id}', array(
				'as' 	=> 'brand-id',
				'uses'	=> 'BrandsController@viewBrand'
			));

			// Delete Brand
			Route::get('delete/{id}', array(
				'as' 	=> 'delete-single-brand',
				'uses'	=> 'BrandsController@deleteBrand1'
			));

			Route::group(array('before' => 'csrf'), function(){
				// Add Brands
				Route::post('create', array(
					'as' 	=> 'create-brand',
					'uses'	=> 'BrandsController@newBrand'
				));

				// Update Brand
				Route::post('update', array(
					'as' 	=> 'update-brand',
					'uses' 	=> 'BrandsController@updateBrand'
				));

				// Multiple Delete Brand
				Route::post('multi-delete', array(
					'as' 	=> 'multi-delete-brand',
					'uses'	=> 'BrandsController@deleteBrand2'
				));
			});
		});

		/**
		 * FOR PRODUCTS
		 */
		Route::group(array('prefix' => 'products'), function(){
			// List of Products
			Route::get('/', array(
				'as' 	=> 'list-products',
				'uses'	=> 'ProductsController@products'
			));

			// View Selected product
			Route::get('edit/{id}', array(
				'as' 	=> 'product-view',
				'uses' 	=> 'ProductsController@editView'
			));

			// Delete Product
			Route::get('delete/{id}', array(
				'as' 	=> 'delete-single-product',
				'uses' 	=> 'ProductsController@deleteProduct1'
			));

			Route::group(array('before' => 'csrf'), function(){
				// Add Product
				Route::post('create', array(
					'as' 	=> 'create-product',
					'uses' 	=> 'ProductsController@addProduct'
				));

				// Update Product
				Route::post('update', array(
					'as' 	=> 'update-product',
					'uses' 	=> 'ProductsController@updateProduct'
				));

				Route::post('change-image', array(
					'as' 	=> 'change-product-image',
					'uses' 	=> 'ProductsController@changeProductImg'
				));

				// Delete Multiple Products
				Route::post('multi-delete', array(
					'as' 	=> 'multi-delete-product',
					'uses' 	=> 'ProductsController@deleteProduct2'
				));
			});
		});

		// Dashboard
		Route::get('dashboard', array(
			'as' 	=> 'dboard',
			'uses'	=> 'AdminController@dashboard'
		));

		// Sign Out
		Route::get('sign-out', array(
			'as' 	=> 'sign-out',
			'uses' 	=> 'AdminController@userSignout'
		));

	});



}); /* <-- site-admin */