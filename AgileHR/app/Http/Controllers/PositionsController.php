<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Positions;
use App\Models\User;
use App\Models\Sprints;
use App\Models\position_status;
use App\Models\candidate_statuses;
use App\Models\CandidateVsPositionsRelationship;
use App\Models\candidates;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        //Add new position
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

    public function SelectPosition($id, $viewName){

        $data = Positions::join('users', 'users.ID', 'positions.opener_id')
        ->join('position_statuses', 'position_statuses.ID', 'positions.position_status')
        ->LeftJoin('users as assignee', 'assignee.ID', 'positions.assignee_id')
        ->LeftJoin('sprints', 'sprints.ID', 'positions.sprint_id')
        ->select('positions.*', 'users.username', 'position_statuses.PositionStatus', 'assignee.username as assignee_username', 'sprints.sprint_name')
        ->where('positions.ID', '=', $id)
        ->first();
        
        $relship = Positions::join('candidate_positions_relationship as cpr', 'cpr.position_id', 'positions.ID')
                              ->whereIn('cpr.candidate_status_id', [7,10,11,12])
                              ->where('cpr.position_id', '=', $id)
                              ->select('cpr.ID', 'cpr.candidate_id')
                              ->OrderBy('cpr.updated_at', 'desc')
                              ->first();

        $usernames = User::select('username', 'ID')->get();
        $sprints = Sprints::where('is_closed', '=', '0')
                    ->select('sprint_name', 'ID')
                    ->get();        
        $pos_status = position_status::select('PositionStatus', 'ID')->get();
        $view  = (string)$viewName;

        $maxDatesperEntry = DB::table('candidate_positions_relationship')
        ->select('candidate_id','position_id', DB::raw('MAX(updated_at) as maxDate'))
        ->where('position_id', '=', $id)
        ->groupBy('candidate_id', 'position_id');

        $latestEntries = DB::table('candidate_positions_relationship as cpr')
        ->joinSub($maxDatesperEntry, 'latest_entry', function ($join) {
            $join->on('cpr.position_id', '=', 'latest_entry.position_id')
                ->on('cpr.candidate_id', '=', 'latest_entry.candidate_id')
                ->on('cpr.updated_at', '=', 'latest_entry.maxDate');
        })->join('position_statuses as ps', 'ps.ID', 'cpr.position_status_id')
        ->join('candidate_status as cs', 'cs.ID', 'cpr.candidate_status_id')
        ->join('candidate_details as cd', 'cd.ID', 'cpr.candidate_id')
        ->Leftjoin('users as u', 'u.ID', 'cpr.assignee_id')
        ->select('cpr.Comment', 'u.ID as userID'
            , 'u.username', 'ps.ID as posstatusID', 'ps.PositionStatus'
            , 'cs.ID as canstatusID', 'cs.CandidateStatus'
            , 'cd.ID as canID', 'cd.Name'
            , 'cpr.updated_at'
            , 'cpr.created_at')
        ->get();

        $can_status = candidate_statuses::all();
        $candidate_list = candidates::all();
        return view('subPages.managePosition_subs.editPositions', compact('usernames', 'sprints', 'pos_status', 'data', 'view', 'relship', 'latestEntries', 'can_status', 'candidate_list'));
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

        //if position's status is cancelled:
            if($req->selected_pos_status == 5){

                $latest_assignee = Positions::whereId($id)->select('assignee_id')->first();

                $maxDatesperEntry = DB::table('candidate_positions_relationship')
                ->select('candidate_id','position_id', DB::raw('MAX(updated_at) as maxDate'))
                ->where('position_id', '=', $id)
                ->groupBy('candidate_id', 'position_id');
        
                $latestEntries = DB::table('candidate_positions_relationship as cpr')
                ->joinSub($maxDatesperEntry, 'latest_entry', function ($join) {
                    $join->on('cpr.position_id', '=', 'latest_entry.position_id')
                        ->on('cpr.candidate_id', '=', 'latest_entry.candidate_id')
                        ->on('cpr.updated_at', '=', 'latest_entry.maxDate');
                })->select('cpr.*')
                ->whereNotIn('cpr.candidate_status_id', [7,10,11])
                ->get();
        
                //now insert records to the relationship table:
                foreach($latestEntries as $le){
                    $msg = new CandidateVsPositionsRelationship;
                    $msg->candidate_id= $le->candidate_id;
                    $msg->position_id = $id;
                    $msg->candidate_status_id = 12;
                    $msg->position_status_id = 5;
                    if(!is_null($latest_assignee->assignee_id)){
                        $msg->assignee_id = $latest_assignee->assignee_id;
                    }
                    $msg->Comment = 'Automatically closed candidate application, reason: position cancelled';
                    $msg->save();   
                } 
            }

        if($req->editPos_siteName == "ActiveSprint"){
            if($req->selected_pos_status == 5){
                return redirect('activeSprintView')->with('success', 'Position updated and applications cancelled.');
            }
            else{
                return redirect('activeSprintView')->with('success', 'Position updated successfully.');
            }
            
        }
        else if($req->editPos_siteName == "backlogView"){
            if($req->selected_pos_status == 5){
                return redirect('backLogView')->with('success', 'Position updated and applications cancelled.');
            }
            else{
                return redirect('backLogView')->with('success', 'Position updated successfully.');
            }
        }
        else{
            if($req->selected_pos_status == 5){
                return redirect('managePosition')->with('success', 'Position updated and applications cancelled.');
            }
            else{
                return redirect('managePosition')->with('success', 'Position updated successfully.');
            }
        }
    }


}
