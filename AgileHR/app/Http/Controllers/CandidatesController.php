<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\candidates;
use App\Models\contact_information;
use App\Models\contact_information_types;
use App\Models\labels;
use App\Models\label_types;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class CandidatesController extends Controller
{
    public function AddNewCandidate(Request $req){       
        
        $this->validate($req,[
            'can_Name' => 'required'
        ]);
        
        $msg = new candidates;
        $msg->Name= $req->can_Name;
        $msg->Description = $req->can_description;
        $msg->Link = $req->can_Link;
        $msg->save();
        
         //update candidate names if there's multiple of the same:
            $NameCounts = DB::table('candidate_details')
            ->select('Name', DB::raw('COUNT(Name) as total_no'))
            ->where('Name', '=', $req->can_Name)
            ->groupBy('Name')
            ->havingRaw('COUNT(Name) > ?', [1])->get();
            if($NameCounts->count() > 0){
                foreach($NameCounts as $nc){
                    $names_and_ids = candidates::where('Name', '=', $nc->Name)->select('ID', 'Name')->get();
                    foreach($names_and_ids as $nad){
                        $form_data = array(
                            'Name' => $nad->Name."-".$nad->ID
                        );
                        candidates::whereId($nad->ID)->update($form_data);
                    }                
                }            
            }
        
        return redirect('createCandidate')->with('success', 'Candidate profile created successfully.');
    }

    public function getAllCandidates(){

        $msg = candidates::orderBy('updated_at', 'desc')
        ->get();

        return view('subPages.manageCandidate_subs.getAllcandidates', ['candidates'=>$msg]);
    }

    public function deleteCandidate($id){
        $data = candidates::findOrFail($id);
        $data->delete();

        return redirect('manageCandidate')->with('success', 'Candidate entry deleted successfully.');
    }

    public function SelectCandidate($id){


        $can_details = candidates::where('ID', $id)
                       ->select('candidate_details.*') 
                       ->first();
        $can_contact_info = contact_information::join('contact_information_types', 'contact_information_types.ID', 'contact_information.contact_type_id')
                            ->where('contact_information.candidate_id', $id)
                            ->select('contact_information.*', 'contact_information_types.ContactType')
                            ->get();

        $can_labels = labels::join('label_types', 'label_types.ID', 'labels.label_type_id')
                        ->where('labels.candidate_id', $id)
                        ->select('labels.*', 'label_types.Label_value')
                        ->get();

        $label_types = label_types::select('ID','Label_value')->get();
        $contact_info_types = contact_information_types::select('ID', 'ContactType')->get();
                
        $maxDatesperEntry = DB::table('candidate_positions_relationship')
        ->select('candidate_id','position_id', DB::raw('MAX(updated_at) as maxDate'))
        ->where('candidate_id', '=', $id)
        ->groupBy('candidate_id', 'position_id');

        $latestEntries = DB::table('candidate_positions_relationship as cpr')
        ->joinSub($maxDatesperEntry, 'latest_entry', function ($join) {
            $join->on('cpr.position_id', '=', 'latest_entry.position_id')
                ->on('cpr.candidate_id', '=', 'latest_entry.candidate_id')
                ->on('cpr.updated_at', '=', 'latest_entry.maxDate');
        })->join('position_statuses as ps', 'ps.ID', 'cpr.position_status_id')
        ->join('candidate_status as cs', 'cs.ID', 'cpr.candidate_status_id')
        ->join('candidate_details as cd', 'cd.ID', 'cpr.candidate_id')
        ->join('positions as p', 'p.ID', 'cpr.position_id')
        ->Leftjoin('users as u', 'u.ID', 'cpr.assignee_id')
        ->select('cpr.Comment', 'u.ID as userID'
            , 'u.username', 'ps.ID as posstatusID', 'ps.PositionStatus'
            , 'cs.ID as canstatusID', 'cs.CandidateStatus'
            , 'cd.ID as canID', 'cd.Name'
            , 'cpr.updated_at'
            , 'cpr.created_at'
            , 'p.Title')
        ->get();

        return view('subPages.manageCandidate_subs.editCandidate', compact('can_details', 'can_contact_info', 'can_labels', 'label_types', 'contact_info_types', 'latestEntries'));

    }

    public function AddNewContactInfo(Request $req, $id){
        
        $this->validate($req,[
            'can_contact_value' => 'required'
        ]);

        $contactInfo_isLive = contact_information::where('candidate_id', $id)->where('contact_type_id',$req->select_contactInfo)->first();

        if(empty($contactInfo_isLive)){
            $msg = new contact_information;
            $msg->candidate_id= $req->can_sub_contactInfo_id;
            $msg->contact_type_id = $req->select_contactInfo;
            $msg->ContactInfo_value = $req->can_contact_value;
            $msg->save();
            return redirect('manageCandidate_SelectCandidate/'.$id)->with('success', 'New contact information successfully.');

        }else{
            $form_data = array(
                'ContactInfo_value' => $req->can_contact_value
            );
            contact_information::where('candidate_id', $id)->where('contact_type_id',$req->select_contactInfo)->update($form_data);
            return redirect('manageCandidate_SelectCandidate/'.$id)->with('success', 'Contact information updated.');

        }
    }
    public function UpdateSelectedCandidate(Request $req, $id){
        $attachment="";
        $new_name="";

        $this->validate($req,[
            'can_name' => 'required',
            'can_details_desc' => 'required'
        ]);

        if(!is_null($req->can_attachment)){
            $this->validate($req,[
                'can_attachment'=>'mimes:pdf,docx'                
            ]);
            $attachment = $req->can_attachment;
            $new_name = "can_".(string)$id . '.'.$attachment->getClientOriginalExtension();
            $attachment->move(public_path('\attachments\candidate_cvs'), $new_name);
        }

        if($attachment!=""){
            $form_data = array(
                'Name' => $req->can_name,
                'Description' =>$req->can_details_desc,
                'Link'=>$req->can_link,
                'Attachments'=>$new_name
            );
        }else{
            $form_data = array(
                'Name' => $req->can_name,
                'Description' =>$req->can_details_desc,
                'Link'=>$req->can_link             
            );
        }
        candidates::whereId($id)->update($form_data);
        return redirect('manageCandidate_SelectCandidate/'.$id)->with('success', 'Candidate details updated.');

    }

    public function DeleteSelectedContactInfo($id, $canID){
        $data = contact_information::findOrFail($id);
        $data->delete();
        return redirect('manageCandidate_SelectCandidate/'.$canID)->with('success', 'Contact information removed.');
    }

    public function AddNewLabel(Request $req, $id){

        $label_isLive = labels::where('candidate_id', $id)->where('label_type_id',$req->select_labelType)->first();

        if(empty($label_isLive)){
            $msg = new labels;
            $msg->candidate_id= $id;
            $msg->label_type_id = $req->select_labelType;
            $msg->save();
            return redirect('manageCandidate_SelectCandidate/'.$id)->with('success', 'New label added successfully.');

        }else{
            $form_data = array(
                'label_type_id' => $req->select_labelType
            );
            labels::where('candidate_id', $id)->where('label_type_id',$req->select_labelType)->update($form_data);
            return redirect('manageCandidate_SelectCandidate/'.$id)->with('success', 'Label updated.');

        }
    }

    public function DeleteSelectedLabel($id, $canID){
        $data = labels::findOrFail($id);
        $data->delete();
        return redirect('manageCandidate_SelectCandidate/'.$canID)->with('success', 'Label removed.');
    }

    public function ReturnSearchCandidateResults(Request $req)
    {
        $searchByName = candidates::where('Name', 'LIKE', '%'.$req->Searchbox_candidate.'%')
        ->select('candidate_details.*');

        $searchByDescription = candidates::where('Description', 'LIKE', '%'.$req->Searchbox_candidate.'%')
        ->select('candidate_details.*')
        ->union($searchByName)->get();

        $candidates = $searchByDescription;

        return view('subPages.manageCandidate_subs.SearchCandidateResults', ['candidates'=>$candidates]);
    }

    public function setUpSearchCandidate()
    {
        $msg = label_types::get();
        return view('subPages.manageCandidate_subs.searchCandidate', ['label_types'=>$msg]);
    }

    public function ReturnSearchCandidateResultsByLabel(Request $req)
    {
        $this->validate($req,[
            'selectedLabel' => 'required'
        ]);

        $candidates = labels::join('candidate_details as c', 'c.ID', 'labels.candidate_id')
                          ->where('labels.label_type_id', '=', $req->selectedLabel)
                          ->select('c.*')
                          ->get();

        return view('subPages.manageCandidate_subs.SearchCandidateResults', ['candidates'=>$candidates]);
    }
}
