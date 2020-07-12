<?php


//Route::get('/admin','BookController@admin');

//Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::prefix('/admin')->group(function () {

	Route::get('/products/admin','ProductController@admin_products')->name('products.admin');
	Route::get('/template-products/admin','ProductController@admin_template_products')->name('template_products.admin');
    Route::get('/products/create','ProductController@create')->name('products.create');

    Route::post('/products/store/','ProductController@store')->name('products.store');

    Route::post('/products/slug_check', 'ProductController@slug_check')->name('products.slug_check');

    Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
	Route::post('/subcategories/get_subcategories_by_category', 'SubCategoryController@get_subcategories_by_category')->name('subcategories.get_subcategories_by_category');

		Route::get('/products/admin/{id}/edit','ProductController@admin_product_edit')->name('products.admin.edit');
		Route::post('/products/update/{id}','ProductController@update')->name('products.update');

		Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');

		Route::post('/products/more_options_edit', 'ProductController@more_options_edit')->name('products.more_options_edit');

		Route::post('/products/more_options', 'ProductController@more_options')->name('products.more_options');

		Route::post('/products/update/{id}','ProductController@update')->name('products.update');


		Route::get('/menu/admin','MenuController@admin_products')->name('menu.admin');
		Route::post('/menu/update/{id}','MenuController@update')->name('menu.update');

    Route::post('/subsubcategories/get_subsubcategories_by_subcategory', 'SubSubCategoryController@get_subsubcategories_by_subcategory')->name('subsubcategories.get_subsubcategories_by_subcategory');
    
	Route::post('/subsubcategories/get_brands_by_subsubcategory', 'SubSubCategoryController@get_brands_by_subsubcategory')->name('subsubcategories.get_brands_by_subsubcategory');


	Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
	Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');

	Route::post('/related_product_IDS/ajax','ProductController@related_product_IDS')->name('ajax.relatedprodids');

	Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');

	Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
	Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');


	Route::get('/products/import','ExcelImportController@index')->name('products.import');

	Route::post('/products/importexcel', 'ExcelImportController@store')->name('products.importexcel');

	

	Route::get('/templates/import','TemplatesImportController@index')->name('templates.import');

	Route::post('/templates/importexcel', 'TemplatesImportController@store')->name('templates.importexcel');


	//Templates Routes
	Route::get('/templates/admin','TemplateController@admin_templates')->name('templates.admin');
    Route::get('/templates/create','TemplateController@create')->name('templates.create');

    Route::post('/templates/store/','TemplateController@store')->name('templates.store');

    Route::post('/templates/more_options_edit', 'TemplateController@more_options_edit')->name('templates.more_options_edit');

	Route::post('/templates/more_options', 'TemplateController@more_options')->name('templates.more_options');

	Route::get('/templates/admin/{id}/edit','TemplateController@admin_template_edit')->name('templates.admin.edit');

	Route::post('/templates/todays_deal', 'TemplateController@updateTodaysDeal')->name('templates.todays_deal');

	Route::post('/templates/featured', 'TemplateController@updateFeatured')->name('templates.featured');
	Route::post('/templates/published', 'TemplateController@updatePublished')->name('templates.published');


	Route::post('/templates/sku_combination_edit', 'TemplateController@sku_combination_edit')->name('templates.sku_combination_edit');
	Route::post('/templates/slug_check', 'TemplateController@slug_check')->name('templates.slug_check');

		Route::post('/templates/more_options_edit', 'TemplateController@more_options_edit')->name('templates.more_options_edit');

		Route::post('/templates/more_options', 'TemplateController@more_options')->name('templates.more_options');


	Route::post('/templates/update/{id}','TemplateController@update')->name('templates.update');


	Route::get('/templates/destroy/{id}', 'TemplateController@destroy')->name('templates.destroy');

	Route::post('/template_categories/ajax','TemplateCategoryController@ajax_getCategories')->name('ajax.templatecategories');
	Route::post('/template_categories_menu/ajax','TemplateCategoryController@ajax_getCategories_formenu')->name('ajax.categories.menu');
	Route::post('/templates_for_menu/ajax','TemplateCategoryController@ajax_getTemplates_formenu')->name('ajax.templates.menu');

	//Template Categories
	Route::get('/template_categories/admin','TemplateCategoryController@admin_templates')->name('templatecategories.admin');
    Route::get('/template_categories/create','TemplateCategoryController@create')->name('templatecategories.create');

    Route::post('/template_categories/slug_check', 'TemplateCategoryController@slug_check')->name('template_categories.slug_check');

    Route::get('/template_categories/admin/{id}/edit','TemplateCategoryController@admin_templatecategories_edit')->name('templatecategories.admin.edit');

    Route::post('/template_categories/todays_deal', 'TemplateCategoryController@updateTodaysDeal')->name('templatecategories.todays_deal');

    Route::post('/template_categories/store/','TemplateCategoryController@store')->name('templatecategories.store');
    Route::post('/template_categories/update/{id}','TemplateCategoryController@update')->name('templatecategories.update');


    //Filter Groups
	Route::get('/filter_groups/admin','FilterGroupController@admin_templates')->name('filtergroups.admin');
    Route::get('/filter_groups/create','FilterGroupController@create')->name('filtergroups.create');

    Route::post('/filter_groups/slug_check', 'FilterGroupController@slug_check')->name('filter_groups.slug_check');

    Route::get('/filter_groups/admin/{id}/edit','FilterGroupController@admin_filtergroups_edit')->name('filtergroups.admin.edit');

    Route::post('/filter_groups/todays_deal', 'FilterGroupController@updateTodaysDeal')->name('filtergroups.todays_deal');

    Route::post('/filter_groups/store/','FilterGroupController@store')->name('filtergroups.store');
    Route::post('/filter_groups/update/{id}','FilterGroupController@update')->name('filtergroups.update');

    Route::post('/filter_groups/ajax','FilterGroupController@ajax_getFilterNames')->name('ajax.filtergroups');



    //Coupons
	Route::resource('coupon','CouponController');
	Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
	Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
	Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');


	//Shipping Methods
	Route::get('/shipping_method/admin','ShippingMethodController@admin_templates')->name('shippingmethod.admin');
    Route::get('/shipping_method/create','ShippingMethodController@create')->name('shippingmethod.create');

    Route::get('/shipping_method/admin/{id}/edit','ShippingMethodController@admin_shippingmethod_edit')->name('shippingmethod.admin.edit');

    Route::post('/shipping_method/store/','ShippingMethodController@store')->name('shippingmethod.store');
    Route::post('/shipping_method/update/{id}','ShippingMethodController@update')->name('shippingmethod.update');

    //SEO ROUTING
    Route::resource('shippingsetting','ShippingSettingsController');


    //Shipping Charges
	Route::resource('shipping_charge','ShippingChargeController');
	Route::post('/shipping_charge/get_form', 'ShippingChargeController@get_shipping_charge_form')->name('shipping_charge.get_shipping_charge_form');
	Route::post('/shipping_charge/get_form_edit', 'ShippingChargeController@get_shipping_charge_form_edit')->name('shipping_charge.get_shipping_charge_form_edit');
	Route::get('/shipping_charge/destroy/{id}', 'ShippingChargeController@destroy')->name('shipping_charge.destroy');

	Route::post('/shipping_charge/sendShipCharges', 'ShippingChargeController@sendShipCharges')->name('shipping_charge.sendShipCharges');

	Route::post('/shipping_charge/saveShippingcharges', 'ShippingChargeController@saveShippingcharges')->name('shipping_charge.saveShippingcharges');



	 //Local Pickup Location Address
	Route::resource('local_pickup','LocalPickUpController');

	//Status codes for order statuses
	Route::resource('status_code','OrderStatusController');

	//Payment types for order payments
	Route::resource('payment_type','PaymentTypeController');

	//Orders
	Route::resource('orders','AdminOrderController');
	Route::get('/orders/order-details/{orderid}', 'AdminOrderController@order_details')->name('orders.order_details.orderid');
	Route::post('/orders/postAdminComments', 'AdminOrderController@postAdminComments')->name('admin.orders.postAdminComments');
	Route::post('/orders/getStates', 'AdminOrderController@ajaxGetStates')->name('ajax.orders.getStates');
	Route::post('/orders/updateShippingInfo', 'AdminOrderController@updateShippingInfo')->name('ajax.orders.updateShippingInfo');



	//CRICKET
	Route::resource('teams','TeamsController');
	Route::resource('players','PlayerController');





});


