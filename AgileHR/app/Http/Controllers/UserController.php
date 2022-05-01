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

    public function ReturnSearchUserResults(Request $req){
        

        $searchByName = User::join('role_permissions', 'users.RoleID', '=', 'role_permissions.ID')
        ->where('Name', 'LIKE', '%'.$req->Searchbox_user.'%')
        ->select('users.*', 'role_permissions.RoleDescription');

        $searchByUserName = User::join('role_permissions', 'users.RoleID', '=', 'role_permissions.ID')
        ->where('username', 'LIKE', '%'.$req->Searchbox_user.'%')
        ->select('users.*', 'role_permissions.RoleDescription')
        ->union($searchByName);

        $searchByEmail = User::join('role_permissions', 'users.RoleID', '=', 'role_permissions.ID')
        ->where('email', 'LIKE', '%'.$req->Searchbox_user.'%')
        ->select('users.*', 'role_permissions.RoleDescription')
        ->union($searchByUserName)
        ->get();


        $users = $searchByEmail;

        return view('subPages.manageUser_subs.SearchUserResults', ['users'=>$users]);

    }

    public function showAllRoles(){
        $roles = role_permission::get();
        return view('subPages.manageUser_subs.getAllRoles', ['roles'=>$roles]);
    }

    public function AddNewRole(Request $req){

        $msg = new role_permission;
        $msg->RoleDescription = $req->RoleDesc_new;
        $msg->save();

        return redirect('manageRoles')->with('success', 'Role created successfully.');
    }

    public function deleteRole($id){
        $data = role_permission::findOrFail($id);
        $data->delete();

        return redirect('manageRoles')->with('success', 'Role deleted successfully.');
    }

    public function SelectRole($id){
        $data = role_permission::findOrFail($id);
        return view('subPages.manageUser_subs.editRole', compact('data'));
    }

    public function editSelectedRole(Request $req, $id){
        $this->validate($req,[
            'RoleDesc_editRole' => 'required',
        ]);

        $form_data = array(
            'RoleDescription' => $req->RoleDesc_editRole
        );

        role_permission::whereId($id)->update($form_data);
        return redirect('manageRoles')->with('success', 'Data is successfully updated');
    }

    public function deleteUser($id){
        $data = User::findOrFail($id);
        $data->delete();

        return redirect('getAllUsers')->with('success', 'User deleted successfully.');
    }

    public function SelectUser($id){
       
        $data = User::join('role_permissions', 'users.RoleID', '=', 'role_permissions.ID')
        ->select('users.*', 'role_permissions.RoleDescription')
        ->where('users.ID', '=', $id)
        ->first();
        
        $role_permission = role_permission::select('RoleDescription', 'ID')->get();
        return view('subPages.manageUser_subs.editUser', ['data'=>$data], ['roles'=>$role_permission]);
    }

    public function editSelectedUser(Request $req, $id){
        $this->validate($req,[
            'User_name_edit' => 'required',
            'User_username_edit' => 'required',
            'User_email_edit' => 'required'
        ]);

        $form_data = array(
            'Name' => $req->User_name_edit,
            'username' => $req->User_username_edit,
            'email' => $req->User_email_edit,
            'RoleID' =>$req->selectedRole,
            'isAdmin'=>$req->isAdminSelection
        );

        User::whereId($id)->update($form_data);
        return redirect('getAllUsers')->with('success', 'Data is successfully updated');
    }
}