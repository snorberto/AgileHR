<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\candidates;
use App\Models\contact_information;
use App\Models\contact_information_types;
use App\Models\labels;
use App\Models\label_types;
use Illuminate\Support\Facades\Storage;

class CandidatesController extends Controller
{
    public function AddNewCandidate(Request $req){
        
        
        $this->validate($req,[
            'can_Name' => 'required'
        ]);

        /*$attachment="";
        $new_name="";
        $maxID = 0;
        $maxID = candidates::max('ID');

        if(is_null($maxID)){
            $maxID = 0;
        }

        if(!is_null($req->can_attachment)){
            $this->validate($req,[
                'can_attachment'=>'mimes:pdf,docx'                
            ]);
            $attachment = $req->can_attachment;
            $new_name = "can_".(string)$maxID + 1 . '.'.$attachment->getClientOriginalExtension();
            $attachment->move(public_path('\attachments\candidate_cvs'), $new_name);
        }*/

        /*if($attachment!=""){
            $msg = new candidates;
            $msg->Name= $req->can_Name;
            $msg->Description = $req->can_description;
            $msg->Attachments = $new_name;
            $msg->Link = $req->can_Link;
            $msg->save();
        }else{*/
            $msg = new candidates;
            $msg->Name= $req->can_Name;
            $msg->Description = $req->can_description;
            $msg->Link = $req->can_Link;
            $msg->save();
        //}
        
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
                
        

        return view('subPages.manageCandidate_subs.editCandidate', compact('can_details', 'can_contact_info', 'can_labels', 'label_types', 'contact_info_types'));

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
}
