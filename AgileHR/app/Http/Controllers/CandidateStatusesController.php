<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\candidate_statuses;

class CandidateStatusesController extends Controller
{
    public function getAllCandidate_status(){
        $msg = candidate_statuses::get();
        return view('subPages.manageCandidate_subs.getAllCandidateStatuses', ['can_status'=>$msg]);
    }

    public function editSelectedCandidateStatus(Request $req, $id){
        $this->validate($req,[
            'edit_name_input' => 'required'
        ]);

        $form_data = array(
            'CandidateStatus' => $req->edit_name_input            
        );

        candidate_statuses::whereId($id)->update($form_data);
        return redirect('maintainCandidateStatus')->with('success', 'Status edited successfully.');
    }

    public function deleteSelectedCandidateStatus($id){
        $data = candidate_statuses::findOrFail($id);
        $data->delete();

        return redirect('maintainCandidateStatus')->with('success', 'Status deleted successfully.');
    }

    public function AddNewCandidateStatus(Request $req)
    {
        $this->validate($req,[
            'add_name_input' => 'required'
        ]);

        $msg = new candidate_statuses;
        $msg->CandidateStatus = $req->add_name_input;
        $msg->save();
        
        return redirect('maintainCandidateStatus')->with('success', 'Status added successfully.');
    }
}
