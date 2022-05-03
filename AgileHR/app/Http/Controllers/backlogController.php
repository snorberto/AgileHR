<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Positions;
use App\Models\User;
use App\Models\CandidateVsPositionsRelationship;
use App\Models\Sprints;

class backlogController extends Controller
{
    public function Return_backlogview()
    {
        $sprints_active = Sprints::where('is_closed', '=',0)
                                    ->where('is_active','=', 1)->first();

        $sprints_other = Sprints::where('is_closed', '=', 0)
                            ->where('is_active','=',0)
                            ->get();
        $positions_assigned = Positions::whereNotIn('position_status',[4,5])
                                ->join('sprints as s', 's.ID', 'positions.sprint_id')
                                ->LeftJoin('position_statuses as ps', 'ps.ID', 'positions.position_status')
                                ->select('positions.Title', 'positions.ID', 's.ID as sprintID', 's.sprint_name', 'ps.PositionStatus')
                                ->get();

        $positions_backlog = Positions::whereNull('sprint_id')
                                        ->LeftJoin('position_statuses as ps', 'ps.ID', 'positions.position_status')
                                        ->select('positions.*', 'ps.PositionStatus')
                                        ->get();

        $all_open_sprints = Sprints::where('is_closed', '=',0)->get();

        return view('subPages.backlogView', compact('sprints_active', 'sprints_other','positions_assigned', 'positions_backlog', 'all_open_sprints'));
    }

    public function AssignSelectedToNewSprint(Request $req, $id)
    {
        if($req->backlog_selectedSprint == ""){
            $req->backlog_selectedSprint = null;
        }

        $form_data = array(
            'sprint_id' => $req->backlog_selectedSprint    
        );    

        Positions::whereId($id)->update($form_data);
        return redirect('backLogView')->with('success', 'Assigned position to new sprint!');
    }
}
