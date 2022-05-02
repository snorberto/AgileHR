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



Route::get('/', function () {
    return view('mainSite.index');
});

Route::get('/dashboard', function () {
    return view('mainSite.index');
})->middleware(['auth'])->name('mainSite.index');

require __DIR__.'/auth.php';

Route::get('logout', "App\Http\Controllers\Auth\AuthenticatedSessionController@destroy");

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

Route::get('managePosition', function () {
    return view('subPages.managePosition');
});


Route::get('createPosition', function() {
    return view('subPages.managePosition_subs.getAllpositions');
});

Route::get('createPosition', function() {
    return view('subPages.managePosition_subs.CreatePosition');
});

Route::get('searchPosition', function () {
    return view('subPages.managePosition_subs.searchPosition');
});

Route::get('manageCandidate', function () {
    return view('subPages.manageCandidate');
});

Route::get('createCandidate', function() {
    return view('subPages.manageCandidate_subs.CreateCandidate');
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

//manage Positions:
Route::resource('Position',"App\Http\Controllers\PositionsController");
Route::get('getAllpositions',"App\Http\Controllers\PositionsController@getAllpositions");
Route::post('AddNewPosition',"App\Http\Controllers\PositionsController@AddNewPosition");
Route::post('StartSearchPosition',"App\Http\Controllers\PositionsController@StartSearchPosition");
Route::get("managePositions_deleteSelectedPosition/{id}", "App\Http\Controllers\PositionsController@deletePosition");
Route::get("managePositions_SelectPosition/{id}", "App\Http\Controllers\PositionsController@SelectPosition");
Route::post("managePosition_updateSelectedPosition/{id}", "App\Http\Controllers\PositionsController@editSelectedPosition");

//manage Candidates:
Route::resource('Candidate',"App\Http\Controllers\CandidatesController");
Route::post('AddNewCandidate',"App\Http\Controllers\CandidatesController@AddNewCandidate");
Route::get('getAllCandidates',"App\Http\Controllers\CandidatesController@getAllCandidates");
Route::get("manageCandidate_deleteSelectedCandidate/{id}", "App\Http\Controllers\CandidatesController@deleteCandidate");
Route::get("manageCandidate_SelectCandidate/{id}", "App\Http\Controllers\CandidatesController@SelectCandidate");
Route::post('manageCandidate_addNewContactInfo/{id}',"App\Http\Controllers\CandidatesController@AddNewContactInfo");
Route::post('manageCandidate_updateSelectedCandidate_details/{id}',"App\Http\Controllers\CandidatesController@UpdateSelectedCandidate");
Route::get("manageCandidate_deleteSelectedContactInfo/{id}{canID}", "App\Http\Controllers\CandidatesController@DeleteSelectedContactInfo");
Route::post('manageCandidate_addNewLabel/{id}',"App\Http\Controllers\CandidatesController@AddNewLabel");
Route::get("manageCandidate_deleteSelectedLabel/{id}{canID}", "App\Http\Controllers\CandidatesController@DeleteSelectedLabel");










