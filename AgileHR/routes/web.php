<?php

use Illuminate\Support\Facades\Route;

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

//simple get views:
Route::get('/', function () {
    return view('mainSite.index');
});

Route::get('activeSprintView', function () {
    return view('subPages.ActiveSprintview');
});

Route::get('manageSprints', function () {
    return view('subPages.manageSprints');
});

Route::get('getOpenSprints', function () {
    return view('subPages.manageSprints_subs.getOpenSprints');
});

Route::get('createSprint', function () {
    return view('subPages.manageSprints_subs.createSprint');
});


Route::get('manageUsers', function () {
    return view('subPages.manageUsers');
});

Route::get('searchUser', function () {
    return view('subPages.manageUser_subs.searchUser');
});


//Methods per subpages:
//manageSprints:
Route::resource('Sprints',"App\Http\Controllers\SprintsController");
Route::get('getOpenSprints',"App\Http\Controllers\SprintsController@showOpenSprints");
Route::get('getClosedSprints',"App\Http\Controllers\SprintsController@showClosedSprints");
Route::post('createNewSprint', 'App\Http\Controllers\SprintsController@createNewSprint');
Route::get("manageSprint_deleteSelectedSprint/{id}", "App\Http\Controllers\SprintsController@deleteSprint");
Route::get("manageSprint_SelectSprint/{id}", "App\Http\Controllers\SprintsController@SelectSprint");
Route::post("manageSprint_updateSelectedSprint/{id}", "App\Http\Controllers\SprintsController@editSelectedSprint");

//manageUsers:
Route::resource('User',"App\Http\Controllers\UserController");
Route::get('getAllUsers',"App\Http\Controllers\UserController@showAllUsers");
Route::get('createUser',"App\Http\Controllers\UserController@setUpCreateUser");
Route::post('AddNewUser',"App\Http\Controllers\UserController@AddNewUser");
Route::post('StartSearchUser',"App\Http\Controllers\UserController@ReturnSearchUserResults");
Route::get('manageRoles',"App\Http\Controllers\UserController@showAllRoles");
Route::post('AddNewRole',"App\Http\Controllers\UserController@AddNewRole");
Route::get("manageRole_deleteSelectedRole/{id}", "App\Http\Controllers\UserController@deleteRole");
Route::get("manageRole_SelectRole/{id}", "App\Http\Controllers\UserController@SelectRole");
Route::post("manageRole_updateSelectedRole/{id}", "App\Http\Controllers\UserController@editSelectedRole");
Route::get("manageUser_deleteSelectedUser/{id}", "App\Http\Controllers\UserController@deleteUser");
Route::get("manageUser_SelectUser/{id}", "App\Http\Controllers\UserController@SelectUser");
Route::post("manageUser_updateSelectedUser/{id}", "App\Http\Controllers\UserController@editSelectedUser");








