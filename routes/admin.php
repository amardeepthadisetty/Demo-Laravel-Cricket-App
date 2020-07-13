<?php


//Route::get('/admin','BookController@admin');

//Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::prefix('/admin')->group(function () {

	Route::get('/products/admin','ProductController@admin_products')->name('products.admin');




	//CRICKET
	Route::resource('teams','TeamsController');
	Route::get('/teams/team-info/{teamid}', 'TeamsController@getTeamInfo')->name('teams.team_info.teamid');
	Route::resource('players','PlayerController');
	Route::resource('fixtures','FixtureController');
	Route::resource('points','PointsController');





});


