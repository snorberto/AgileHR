<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Positions;
use App\Models\User;
use App\Models\Sprints;
use App\Models\position_status;
use Illuminate\Support\Facades\Storage;

class PositionsController extends Controller
{
    public function getAllpositions(){
        $msg = Positions::join('position_statuses', 'positions.position_status', '=', 'position_statuses.ID')
        ->join('users', 'positions.opener_id', 'users.ID')
        ->select('positions.*', 'position_statuses.PositionStatus', 'users.username')
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('subPages.managePosition_subs.getAllpositions', ['positions'=>$msg]);
    }

    public function AddNewPosition(Request $req){
        //Add new user
        $maxPrioID = Positions::max('PriorityOrder');
        if(!$maxPrioID){
            $maxPrioID = 0;
        }

        $msg = new Positions;
        $msg->Title= $req->pos_Title;
        $msg->opener_id = $req->openerID;
        $msg->Description = $req->pos_description;
        $msg->story_points = $req->pos_storyPoints;
        $msg->PriorityOrder = $maxPrioID + 1;
        $msg->position_status = 1;
        $msg->save();

        
        return redirect('createPosition')->with('success', 'Position created successfully.');
    }

    public function StartSearchPosition(Request $req){
        //opener, Title, Description
        $searchByOpener = Positions::join('users', 'users.ID', 'positions.opener_id')
        ->join('position_statuses', 'position_statuses.ID', 'positions.position_status')
        ->LeftJoin('users AS users2', 'users2.ID', 'positions.assignee_id')
        ->where('users.username', 'LIKE', '%'.$req->Searchbox_pos.'%')
        ->select('positions.*', 'users.Name', 'users.username', 'users2.Name as assignee_name', 'users2.username as assignee_username', 'position_statuses.PositionStatus');

        $searchByOpenerFullName = Positions::join('users', 'users.ID', 'positions.opener_id')
        ->join('position_statuses', 'position_statuses.ID', 'positions.position_status')
        ->LeftJoin('users AS users2', 'users2.ID', 'positions.assignee_id')
        ->where('users.Name', 'LIKE', '%'.$req->Searchbox_pos.'%')
        ->select('positions.*', 'users.Name', 'users.username', 'users2.Name as assignee_name', 'users2.username as assignee_username', 'position_statuses.PositionStatus')
        ->union($searchByOpener);

        $searchByTitle = Positions::join('users', 'users.ID', 'positions.opener_id')
        ->join('position_statuses', 'position_statuses.ID', 'positions.position_status')
        ->LeftJoin('users AS users2', 'users2.ID', 'positions.assignee_id')
        ->where('positions.Title', 'LIKE', '%'.$req->Searchbox_pos.'%')
        ->select('positions.*', 'users.Name', 'users.username', 'users2.Name as assignee_name', 'users2.username as assignee_username', 'position_statuses.PositionStatus')
        ->union($searchByOpenerFullName);

        $searchByDescription = Positions::join('users', 'users.ID', 'positions.opener_id')
        ->join('position_statuses', 'position_statuses.ID', 'positions.position_status')
        ->LeftJoin('users AS users2', 'users2.ID', 'positions.assignee_id')
        ->where('positions.Description', 'LIKE', '%'.$req->Searchbox_pos.'%')
        ->select('positions.*', 'users.Name', 'users.username', 'users2.Name as assignee_name', 'users2.username as assignee_username', 'position_statuses.PositionStatus')
        ->union($searchByTitle)
        ->get();

        $positions = $searchByDescription;

        return view('subPages.managePosition_subs.SearchPositionResults', ['positions'=>$positions]);
    }

    public function deletePosition($id){
        $data = Positions::findOrFail($id);
        $data->delete();

        return redirect('managePosition')->with('success', 'Position deleted successfully.');
    }

    public function SelectPosition($id){

        $data = Positions::join('users', 'users.ID', 'positions.opener_id')
        ->join('position_statuses', 'position_statuses.ID', 'positions.position_status')
        ->LeftJoin('users as assignee', 'assignee.ID', 'positions.assignee_id')
        ->LeftJoin('sprints', 'sprints.ID', 'positions.sprint_id')
        ->select('positions.*', 'users.username', 'position_statuses.PositionStatus', 'assignee.username as assignee_username', 'sprints.sprint_name')
        ->where('positions.ID', '=', $id)
        ->first();
        

        $usernames = User::select('username', 'ID')->get();
        $sprints = Sprints::where('is_closed', '=', '0')
                    ->select('sprint_name', 'ID')
                    ->get();        
        $pos_status = position_status::select('PositionStatus', 'ID')->get();

        return view('subPages.managePosition_subs.editPositions', compact('usernames', 'sprints', 'pos_status', 'data'));
    }

    public function editSelectedPosition(Request $req, $id){

        $this->validate($req,[
            'pos_title' => 'required',
            'pos_description' => 'required'
        ]);
        $attachment="";
        $new_name="";
        if(!is_null($req->pos_attachment)){
            $this->validate($req,[
                'pos_attachment'=>'mimes:pdf,docx'                
            ]);
            $attachment = $req->pos_attachment;
            $new_name = "pos_".(string)$id . '.'.$attachment->getClientOriginalExtension();
            $attachment->move(public_path('\attachments\positions'), $new_name);
        }
        if($attachment!=""){
            $form_data = array(
                'Title' => $req->pos_title,
                'position_status' =>$req->selected_pos_status,
                'assignee_id'=>$req->selectedAssignee,
                'sprint_id'=>$req->selectedSprint,
                'story_points'=>$req->pos_storypoint,
                'Description'=>$req->pos_description,
                'attachment'=>$new_name
            );
        }else{
            $form_data = array(
                'Title' => $req->pos_title,
                'position_status' =>$req->selected_pos_status,
                'assignee_id'=>$req->selectedAssignee,
                'sprint_id'=>$req->selectedSprint,
                'story_points'=>$req->pos_storypoint,
                'Description'=>$req->pos_description                
            );
        }
        

        Positions::whereId($id)->update($form_data);
        return redirect('managePosition')->with('success', 'Position updated successfully.');
    }


}
