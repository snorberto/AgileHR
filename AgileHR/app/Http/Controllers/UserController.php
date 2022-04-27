<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\role_permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showAllUsers()
    {

        $users = User::join('role_permissions', 'users.RoleID', '=', 'role_permissions.ID')
            ->select('users.*', 'role_permissions.RoleDescription')
            ->get();

        return view('subPages.manageUser_subs.getAllUsers', ['users'=>$users]);
    }

    public function setUpCreateUser(){
        $role_permission = role_permission::select('RoleDescription', 'ID')
                            ->get();

        return view('subPages.manageUser_subs.createUser', ['roles'=>$role_permission]);
    }

    public function AddNewUser(Request $req){
        //Add new user
        $msg = new User;
        $msg->Name= $req->Name;
        $msg->username= $req->username;
        $msg->password= Hash::make($req->userPassword);
        $msg->email= $req->userEmail;
        $msg->RoleID= $req->selectedRole;
        $msg->isAdmin= $req->isAdminSelection;
        $msg->save();

        
        return redirect('createUser')->with('success', 'User created successfully.');
    }
}