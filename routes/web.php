<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index']);

Route::controller(\App\Http\Controllers\Frontend\HomeController::class)->group(function (){
    Route::post('free-fitness-assessment', 'free_fitness_assessment')->name('free_fitness_assessment');
    Route::post('register', 'register')->name('register');
    Route::match(['get', 'post'], 'login', 'login')->name('login');
    Route::match(['get', 'post'], 'forgot-password', 'forgot_password')->name('forgot_password');
    Route::match(['get', 'post'], 'reset-password/{opt}', 'reset_password')->name('reset_password');
    Route::post('user/logout', 'logout')->name('user.logout')->middleware('auth');
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function (){
    Route::controller(\App\Http\Controllers\Frontend\UserController::class)->group(function (){
        Route::match(['get', 'post'], '/set-new-password/{user_id}/{password}', 'set_new_password')->name('set_new_password');

        Route::middleware('auth')->group(function (){
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/complete-information', 'complete_info')->name('complete_info');
            Route::post('complete-survey', 'complete_survey')->name('complete_survey');

            Route::get('/my-orders', 'my_orders')->name('my_orders');
            Route::get('/order-details/{id}', 'order_details')->name('order_details');

            Route::match(['get', 'post'], '/add-event/{order_id}', 'add_calender_event')->name('add_calender_event');

            Route::match(['get', 'post'], 'profile', 'profile')->name('profile');
            Route::match(['get', 'post'], 'change-password', 'change_password')->name('change_password');

        });

    });
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){

    //auth routes
    Route::controller(\App\Http\Controllers\Backend\AuthController::class)->group(function (){
        Route::match(['get', 'post'], '/', 'admin_login')->name('login');

        Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware('admin');
        Route::post('/logout', 'logout')->name('logout')->middleware('admin');

        Route::match(['get', 'post'], 'profile', 'profile')->name('profile')->middleware('admin');
        Route::match(['get', 'post'], 'change-password', 'change_password')->name('change_password')->middleware('admin');
    });

    Route::middleware('admin')->group(function (){

        //plan routes
        Route::resource('plans', \App\Http\Controllers\Backend\PlanController::class);

        //user routes
        Route::controller(\App\Http\Controllers\Backend\UserController::class)->group(function (){
           Route::get('/users', 'index')->name('users.index');
           Route::match(['get', 'post'],'users/complete-profile/{user_id}', 'complete_profile')->name('users.complete_profile');
           Route::match(['get', 'post'],'users/add-new-survey/{user_id}', 'add_new_survey')->name('users.add_new_survey');
           Route::get('/users/assign-plan/{user_id}', 'assign_plan')->name('users.assign_plan');
           Route::post('/users/assign-plan-store/{user_id}', 'assign_plan_store')->name('users.assign_plan_store');

           //orders
            Route::get('orders', 'order_index')->name('orders');
            Route::get('orders/details/{order_id}', 'order_details')->name('orders.details');
            Route::get('orders/update_payment_status', 'update_payment_status')->name('orders.update_payment_status');

            //diet plan
            Route::get('orders/add-diet-plan/{order_id}', 'add_diet_plan')->name('orders.add_diet_plan');
            Route::get('/search-food', 'search_food')->name('search_food');
            Route::get('/food-details/{id}', 'food_details')->name('food_details');
            Route::post('orders/store-diet-plan/{order_id}', 'store_diet_plan')->name('orders.store_diet_plan');
            Route::get('orders/edit-diet-plan/{id}', 'edit_diet_plan')->name('orders.edit_diet_plan');
            Route::post('orders/update-diet-plan/{id}', 'update_diet_plan')->name('orders.update_diet_plan');
            Route::get('orders/destroy-diet-plan/{id}', 'destroy_diet_plan')->name('orders.destroy_diet_plan');

            //workout plan
            Route::match(['get', 'post'],'orders/add-workout-plan/{order_id}', 'add_workout_plan')->name('orders.add_workout_plan');
            Route::post('orders/update-workout-plan/{id}', 'update_workout_plan')->name('orders.update_workout_plan');
            Route::get('orders/destroy-workout-plan/{id}', 'destroy_workout_plan')->name('orders.destroy_workout_plan');

            //guidelines
            Route::post('orders/update-guideline/{order_id}', 'update_guideline')->name('orders.update_guideline');
            Route::post('orders/update-motivational-boost/{order_id}', 'update_motivational_boost')->name('orders.update_motivational_boost');
            Route::post('orders/update-today-win/{order_id}', 'update_today_win')->name('orders.update_today_win');
            Route::post('orders/update-focus-area/{order_id}', 'update_focus_area')->name('orders.update_focus_area');


            Route::post('orders/update-status/{order_id}', 'update_order_status')->name('orders.update_status');

        });

        //why choose
        Route::resource('why-choose', \App\Http\Controllers\Backend\WhyChooseController::class);

        //settings
        Route::match(['get', 'post'], 'settings', [\App\Http\Controllers\Backend\SettingController::class, 'settings'])->name('settings');

    });


});
