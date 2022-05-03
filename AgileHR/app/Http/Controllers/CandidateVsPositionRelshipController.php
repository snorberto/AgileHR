<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidateVsPositionsRelationship;
use App\Models\candidates;
use App\Models\Positions;
use Illuminate\Support\Facades\DB;
class CandidateVsPositionRelshipController extends Controller
{
    public function AddNewEntry(Request $req, $id)
    {
        //check if candidate is not signed on another position yet:
        $has_signedAlready=CandidateVsPositionsRelationship::where('candidate_id','=', $req->relship_add_candidate_select )
                            ->where('candidate_status_id', 10)->get();
        if($has_signedAlready->count() > 0){
            return redirect("managePositions_SelectPosition/".$id."/".$req->editPos_siteName)->with('error','Candidate already signed a contract!');
        }else{
            //update position's status ID first:
            $pos_status_change = array(
                'position_status' => $req->relship_selected_pos_status
            );
            Positions::whereId($id)->update($pos_status_change);
            //get current assignee from positions table for insert preparation:
            $latest_assignee = Positions::whereId($id)->select('assignee_id')->first();
            //now insert records to the relationship table:
            $msg = new CandidateVsPositionsRelationship;
            $msg->candidate_id= $req->relship_add_candidate_select;
            $msg->position_id = $id;
            $msg->candidate_status_id = $req->relship_add_candidate_status_select;
            $msg->position_status_id = $req->relship_selected_pos_status;
            if(!is_null($latest_assignee->assignee_id)){
                $msg->assignee_id = $latest_assignee->assignee_id;
            }
            $msg->Comment = $req->relship_comment;
            $msg->save();

            return redirect("managePositions_SelectPosition/".$id."/".$req->editPos_siteName)->with('success','New relationship entry added!');
        }
    }

    public function showPositionHistory($id)
    {
        $data = CandidateVsPositionsRelationship::where('position_id', '=', $id)
                ->join('position_statuses as ps', 'ps.ID', 'candidate_positions_relationship.position_status_id')
                ->join('candidate_status as cs', 'cs.ID', 'candidate_positions_relationship.candidate_status_id')
                ->join('candidate_details as cd', 'cd.ID', 'candidate_positions_relationship.candidate_id')
                ->join('positions as p', 'p.Id', 'candidate_positions_relationship.position_id')
                ->LeftJoin('users as u', 'u.ID', 'candidate_positions_relationship.assignee_id')
                ->select(
                    'candidate_positions_relationship.updated_at',
                    'candidate_positions_relationship.created_at',
                    'candidate_positions_relationship.Comment',
                    'u.username',
                    'ps.PositionStatus',
                    'cs.CandidateStatus',
                    'cd.Name'
                )
                ->orderBy('updated_at', 'asc')
                ->get();
        return view('subPages.relshipHistory', ['history'=>$data]);
    }

    public function relship_closePosition($id, $view)
    {
        //first update the positions table status:
        $pos_status_change = array(
            'position_status' => 4
        );
        Positions::whereId($id)->update($pos_status_change);
        //next add new entry for all the candidates that applied for the position but was not selected:
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
            $msg->position_status_id = 4;
            if(!is_null($latest_assignee->assignee_id)){
                $msg->assignee_id = $latest_assignee->assignee_id;
            }
            $msg->Comment = 'Automatically closed candidate application';
            $msg->save();   
        } 
        return redirect('managePositions_SelectPosition/'.$id."/".$view)->with('success', 'Position and applications closed successfully!');
    }
}
