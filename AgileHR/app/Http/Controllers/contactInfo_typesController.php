<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\contact_information_types;


class contactInfo_typesController extends Controller
{
    public function getAllContactInfoTypes(){
        $msg = contact_information_types::get();
        return view('subPages.manageCandidate_subs.getAllcontactInfo_types', ['contact_type'=>$msg]);
    }

    public function editSelectedContactInfoType(Request $req, $id){
        $this->validate($req,[
            'edit_name_input' => 'required'
        ]);

        $form_data = array(
            'ContactType' => $req->edit_name_input            
        );

        contact_information_types::whereId($id)->update($form_data);
        return redirect('maintainContactInfo')->with('success', 'Contact info edited successfully.');
    }

    public function deleteSelectedContactInfoType($id){
        $data = contact_information_types::findOrFail($id);
        $data->delete();

        return redirect('maintainContactInfo')->with('success', 'Contact info deleted successfully.');
    }

    public function AddNewContactInfo_type(Request $req)
    {
        $this->validate($req,[
            'add_name_input' => 'required'
        ]);

        $msg = new contact_information_types;
        $msg->ContactType = $req->add_name_input;
        $msg->save();
        
        return redirect('maintainContactInfo')->with('success', 'Contact info added successfully.');
    }
}
