<?php
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


Auth::routes(['verify' => true]);
Route::get('/product/{slug}', 'HomeController@product')->name('product');

Route::resource('books','BookController');


Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/language', 'LanguageController@changeLanguage')->name('language.change');
Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');

Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
Route::get('/users/login', 'HomeController@login')->name('user.login');
Route::get('/users/registration', 'HomeController@registration')->name('user.registration');
//Route::post('/users/login', 'HomeController@user_login')->name('user.login.submit');
Route::post('/users/login/cart', 'HomeController@cart_login')->name('cart.login.submit');

Route::post('/subcategories/get_subcategories_by_category', 'SubCategoryController@get_subcategories_by_category')->name('subcategories.get_subcategories_by_category');
Route::post('/subsubcategories/get_subsubcategories_by_subcategory', 'SubSubCategoryController@get_subsubcategories_by_subcategory')->name('subsubcategories.get_subsubcategories_by_subcategory');
Route::post('/subsubcategories/get_brands_by_subsubcategory', 'SubSubCategoryController@get_brands_by_subsubcategory')->name('subsubcategories.get_brands_by_subsubcategory');

Route::get('/', 'HomeController@index')->name('home');




Route::get('/category/{catslug}', 'HomeController@categories')->name('categories');
Route::get('/category/{catslug}/filters/{filter_slug1?}/{filter_slug2?}/{filter_slug3?}/{filter_slug4?}/{filter_slug5?}/{filter_slug6?}/{filter_slug7?}/{filter_slug8?}/{filter_slug9?}/{filter_slug10?}', 'HomeController@categories')->name('categories_with_filter');
Route::post('/filters/pull_filter_data', 'HomeController@pull_filter_data')->name('filters.pull_filter_data');
//Route::get('/category/{catslug}/filters/', 'HomeController@categories_with_filter')->name('categories_with_filter');


Route::get('/template/{tmpslug}', 'HomeController@templates')->name('templates');
Route::get('/template/{tmpslug}/filters/{filter_slug1?}/{filter_slug2?}/{filter_slug3?}/{filter_slug4?}/{filter_slug5?}/{filter_slug6?}/{filter_slug7?}/{filter_slug8?}/{filter_slug9?}/{filter_slug10?}', 'HomeController@templates')->name('templates_with_filter');
Route::get('/template/{tmpslug}/product/{prodslug}', 'HomeController@template_product')->name('template.product');
Route::post('/filters/pull_filter_data_in_templates', 'HomeController@pull_filter_data_in_templates')->name('filters.pull_filter_data_in_templates');

Route::get('/users/login', 'HomeController@login')->name('user.login');
Route::get('/users/registration', 'HomeController@registration')->name('user.registration');
//Route::post('/users/login', 'HomeController@user_login')->name('user.login.submit');
Route::post('/users/login/cart', 'HomeController@cart_login')->name('cart.login.submit');

Route::get('/sitemap.xml', function(){
	return base_path('sitemap.xml');
});
Route::get('/product/{slug}', 'HomeController@product')->name('product');
Route::get('/products', 'HomeController@listing')->name('products');
Route::get('/search?category={category_slug}', 'HomeController@search')->name('products.category');
Route::get('/search?subcategory={subcategory_slug}', 'HomeController@search')->name('products.subcategory');
Route::get('/search?subsubcategory={subsubcategory_slug}', 'HomeController@search')->name('products.subsubcategory');
Route::get('/search?brand={brand_slug}', 'HomeController@search')->name('products.brand');
Route::post('/product/variant_price', 'HomeController@variant_price')->name('products.variant_price');
Route::get('/shops/visit/{slug}', 'HomeController@shop')->name('shop.visit');
Route::get('/shops/visit/{slug}/{type}', 'HomeController@filter_shop')->name('shop.visit.type');

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/nav-cart-items', 'CartController@updateNavCart')->name('cart.nav_cart');
Route::post('/cart/show-cart-modal', 'CartController@showCartModal')->name('cart.showCartModal');
Route::post('/cart/addtocart', 'CartController@addToCart')->name('cart.addToCart');
Route::post('/cart/removeFromCart', 'CartController@removeFromCart')->name('cart.removeFromCart');
Route::post('/cart/updateQuantity', 'CartController@updateQuantity')->name('cart.updateQuantity');

Route::get('/orderstatus/{orderid}', 'CheckoutController@order_status')->name('order.status');
Route::post('/initiateTransaction', 'CheckoutController@initiateTransaction')->name('initiate.transaction');

Route::post('/checkout/payment', 'CheckoutController@checkout')->name('payment.checkout');
Route::post('/checkout/getStates', 'CheckoutController@ajaxGetStates')->name('ajax.getStates');
Route::post('/checkout/getAddresses', 'AddressController@ajaxgetAddressInfo')->name('ajax.getAddressInfo');

Route::get('/checkout', 'CheckoutController@get_shipping_info')->name('checkout.shipping_info');
Route::get('/guest_checkout', 'CheckoutController@guest_checkout')->name('checkout.guest_checkout');

Route::any('/checkout/guestcheckout_info', 'CheckoutController@store_guestcheckout_info')->name('checkout.store_guestcheckout_infostore');


Route::any('/checkout/delivery_info_store', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');
Route::get('/delivery_method', 'CheckoutController@delivery_method_view')->name('checkout.delivery_method_view');
Route::get('/delivery_info', 'CheckoutController@delivery_info_view')->name('checkout.delivery_info_view');


Route::post('/checkout/delivery_method_confirm', 'CheckoutController@store_delivery_method_info')->name('checkout.store_delivery_method_info');

Route::post('/checkout/order_confirm_store', 'CheckoutController@store_delivery_info')->name('checkout.store_delivery_info');
Route::get('/order_confirm', 'CheckoutController@order_confirm_view')->name('checkout.order_confirm_view');

Route::post('/checkout/order_submit', 'CheckoutController@order_submit')->name('checkout.order_submit');



//Fill Later routes
Route::post('/fill_later/fill_later_continue', 'FillLaterController@fill_later_store')->name('fill_later.fill_later_continue');

Route::get('/fill_later/shipping_info', 'FillLaterController@get_shipping_info')->name('fill_later.shipping_info');

Route::any('/fill_later/delivery_info_store', 'FillLaterController@store_shipping_info')->name('fill_later.store_shipping_infostore');

Route::get('/fill_later/delivery_method', 'FillLaterController@delivery_method_view')->name('fill_later.delivery_method_view');

Route::post('/fill_later/delivery_method_confirm', 'FillLaterController@store_delivery_method_info')->name('fill_later.store_delivery_method_info');

Route::get('/fill_later/delivery_info', 'FillLaterController@delivery_info_view')->name('fill_later.delivery_info_view');

Route::post('/fill_later/order_confirm_store', 'FillLaterController@store_delivery_info')->name('fill_later.store_delivery_info');



Route::post('/get_pick_ip_points', 'HomeController@get_pick_ip_points')->name('shipping_info.get_pick_ip_points');
//Route::get('/checkout/payment_select', 'CheckoutController@get_payment_info')->name('checkout.payment_info');
Route::post('/checkout/apply_coupon_code', 'CheckoutController@apply_coupon_code')->name('checkout.apply_coupon_code');
Route::post('/checkout/remove_coupon_code', 'CheckoutController@remove_coupon_code')->name('checkout.remove_coupon_code');


//CashFree START
//Route::get('/cashfree/payment/done', 'CashFreeController@getDone')->name('payment.done');
Route::post('/cashfree/payment/done', 'CashFreeController@getDone')->name('payment.done');
Route::post('/cashfree/ship_cost/payment/done', 'CashFreeController@ship_cost_getDone')->name('payment.ship_cost.done');
Route::post('/cashfree/payment/cancel', 'CashFreeController@getCancel')->name('payment.cancel');
//CashFree END


//PAYTM ROUTES
Route::post('/paytm-callback', 'PaytmController@paytmCallback')->name('payment.done');
//PAYTM ROUTES END


//Paypal START
/* Route::get('/paypal/payment/done', 'PaypalController@getDone')->name('payment.done');
Route::get('/paypal/payment/cancel', 'PaypalController@getCancel')->name('payment.cancel'); */
//Paypal END

// SSLCOMMERZ Start
Route::get('/sslcommerz/pay', 'PublicSslCommerzPaymentController@index');
Route::POST('/sslcommerz/success', 'PublicSslCommerzPaymentController@success');
Route::POST('/sslcommerz/fail', 'PublicSslCommerzPaymentController@fail');
Route::POST('/sslcommerz/cancel', 'PublicSslCommerzPaymentController@cancel');
Route::POST('/sslcommerz/ipn', 'PublicSslCommerzPaymentController@ipn');
//SSLCOMMERZ END

//Stipe Start
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
//Stripe END

Route::get('/compare', 'CompareController@index')->name('compare');
Route::get('/compare/reset', 'CompareController@reset')->name('compare.reset');
Route::post('/compare/addToCompare', 'CompareController@addToCompare')->name('compare.addToCompare');

Route::resource('subscribers','SubscriberController');

Route::get('/brands', 'HomeController@all_brands')->name('brands.all');
Route::get('/categories', 'HomeController@all_categories')->name('categories.all');

Route::get('/search', 'HomeController@search')->name('search');
Route::post('/search_post', 'HomeController@search_post')->name('search_post');
Route::get('/search/{q}', 'HomeController@search')->name('suggestion.search');

Route::get('/search/{q}/filters/{filter_slug1?}/{filter_slug2?}/{filter_slug3?}/{filter_slug4?}/{filter_slug5?}/{filter_slug6?}/{filter_slug7?}/{filter_slug8?}/{filter_slug9?}/{filter_slug10?}', 'HomeController@search')->name('templates_with_filter.search');
Route::post('/filters/pull_search_filter_data', 'HomeController@pull_search_filter_data')->name('filters.pull_search_filter_data');


Route::post('/ajax-search', 'HomeController@ajax_search')->name('search.ajax');
Route::post('/file-upload', 'HomeController@file_upload')->name('upload.user_upload_file');
Route::post('/config_content', 'HomeController@product_content')->name('configs.update_status');

Route::get('/sellerpolicy', 'HomeController@sellerpolicy')->name('sellerpolicy');
Route::get('/returnpolicy', 'HomeController@returnpolicy')->name('returnpolicy');
Route::get('/supportpolicy', 'HomeController@supportpolicy')->name('supportpolicy');
Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');


Route::post('/checkout/getStatesFromCountryId', 'AddressController@ajaxGetStates')->name('ajax.getStates.from.countryid');

Route::group(['middleware' => ['user', 'verified']], function(){
	Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::get('/address', 'AddressController@address')->name('address');
	Route::get('address-info/{id}', 'AddressController@edit')->name('address.info');
	Route::get('address-delete/{id}', 'AddressController@delete')->name('address.delete');
	Route::post('/customer/address-update', 'AddressController@address_update')->name('customer.address.update');

	Route::get('address-new/', 'AddressController@new')->name('address.new');
	Route::post('address-add/', 'AddressController@store')->name('address.add');


	Route::post('/customer/update-profile', 'HomeController@customer_update_profile')->name('customer.profile.update');
	Route::post('/seller/update-profile', 'HomeController@seller_update_profile')->name('seller.profile.update');

	Route::resource('purchase_history','PurchaseHistoryController');
	Route::post('/purchase_history/details', 'PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');

	Route::post('/purchase_history/post_comment', 'PurchaseHistoryController@post_comment')->name('purchase_history.post_comment');


	Route::get('/purchase_history/order-details/{orderid}', 'PurchaseHistoryController@order_details')->name('purchase_history.order_details.orderid');
	Route::get('/purchase_history/destroy/{id}', 'PurchaseHistoryController@destroy')->name('purchase_history.destroy');

	Route::resource('wishlists','WishlistController');
	Route::post('/wishlists/remove', 'WishlistController@remove')->name('wishlists.remove');

	Route::get('/wallet', 'WalletController@index')->name('wallet.index');
	Route::post('/recharge', 'WalletController@recharge')->name('wallet.recharge');

	Route::resource('support_ticket','SupportTicketController');
	Route::post('support_ticket/reply','SupportTicketController@seller_store')->name('support_ticket.seller_store');
});

Route::group(['prefix' =>'seller', 'middleware' => ['seller', 'verified']], function(){
	Route::get('/products', 'HomeController@seller_product_list')->name('seller.products');
	Route::get('/product/upload', 'HomeController@show_product_upload_form')->name('seller.products.upload');
	Route::get('/product/{id}/edit', 'HomeController@show_product_edit_form')->name('seller.products.edit');
	Route::resource('payments','PaymentController');

	Route::get('/shop/apply_for_verification', 'ShopController@verify_form')->name('shop.verify');
	Route::post('/shop/apply_for_verification', 'ShopController@verify_form_store')->name('shop.verify.store');

	Route::get('/reviews', 'ReviewController@seller_reviews')->name('reviews.seller');
});

Route::group(['middleware' => ['auth']], function(){
	Route::post('/products/store/','ProductController@store')->name('products.store');
	Route::post('/products/update/{id}','ProductController@update')->name('products.update');
	Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
	Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');
	Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
	Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
	Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
	Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');

	Route::get('invoice/customer/{order_id}', 'InvoiceController@customer_invoice_download')->name('customer.invoice.download');
	Route::get('invoice/seller/{order_id}', 'InvoiceController@seller_invoice_download')->name('seller.invoice.download');

	Route::resource('orders','OrderController');
	Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
	Route::post('/orders/details', 'OrderController@order_details')->name('orders.details');
	Route::post('/orders/update_delivery_status', 'OrderController@update_delivery_status')->name('orders.update_delivery_status');
	Route::post('/orders/update_payment_status', 'OrderController@update_payment_status')->name('orders.update_payment_status');

	Route::resource('/reviews', 'ReviewController');

	Route::resource('/withdraw_requests', 'SellerWithdrawRequestController');
	Route::get('/withdraw_requests_all', 'SellerWithdrawRequestController@request_index')->name('withdraw_requests_all');
	Route::post('/withdraw_request/payment_modal', 'SellerWithdrawRequestController@payment_modal')->name('withdraw_request.payment_modal');
	Route::post('/withdraw_request/message_modal', 'SellerWithdrawRequestController@message_modal')->name('withdraw_request.message_modal');
});

Route::resource('shops', 'ShopController');
Route::get('/track_your_order', 'HomeController@trackOrder')->name('orders.track');

Route::get('/instamojo/payment/pay-success', 'InstamojoController@success')->name('instamojo.success');

Route::post('rozer/payment/pay-success', 'RazorpayController@payment')->name('payment.rozer');

Route::get('/paystack/payment/callback', 'PaystackController@handleGatewayCallback');


Route::get('/vogue-pay', 'VoguePayController@showForm');
Route::get('/vogue-pay/success/{id}', 'VoguePayController@paymentSuccess');
Route::get('/vogue-pay/failure/{id}', 'VoguePayController@paymentFailure');
