<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Positions;
use App\Models\User;
use App\Models\CandidateVsPositionsRelationship;
use App\Models\Sprints;

class activeSprintController extends Controller
{
    public function Return_activeSprint()
    {
        $positions = Sprints::where('sprints.is_active', '=', 1)
                        ->where('sprints.is_closed', '=', 0)
                        ->join('positions as p', 'p.sprint_id', 'sprints.ID')
                        ->join('position_statuses as ps', 'ps.ID', 'p.position_status')
                        ->LeftJoin('users as u', 'u.ID', 'p.assignee_id')
                        ->select('sprints.ID', 'sprints.sprint_name', 'p.ID as posID', 'p.assignee_id', 'p.Title', 'ps.PositionStatus', 'u.username')
                        ->get();

        $sprints = Sprints::where('sprints.is_active', '=', 1)
                   ->where('sprints.is_closed', '=', 0)
                   ->first();
        
        return view('subPages.ActiveSprintView', compact('positions', 'sprints'));
    }


}
