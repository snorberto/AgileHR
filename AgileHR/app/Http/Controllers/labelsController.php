<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\label_types;

class labelsController extends Controller
{

    public function getAllLabels(){
        $msg = label_types::get();
        return view('subPages.manageCandidate_subs.getAllLabel_types', ['label_types'=>$msg]);
    }

    public function editSelectedLabel(Request $req, $id){
        $this->validate($req,[
            'edit_name_input' => 'required'
        ]);

        $form_data = array(
            'Label_value' => $req->edit_name_input            
        );

        label_types::whereId($id)->update($form_data);
        return redirect('maintainLabels')->with('success', 'Label edited successfully.');
    }

    public function deleteSelectedLabel($id){
        $data = label_types::findOrFail($id);
        $data->delete();

        return redirect('maintainLabels')->with('success', 'Label deleted successfully.');
    }

    public function AddNewLabel_type(Request $req)
    {
        $this->validate($req,[
            'add_name_input' => 'required'
        ]);

        $msg = new label_types;
        $msg->Label_value = $req->add_name_input;
        $msg->save();
        
        return redirect('maintainLabels')->with('success', 'Label added successfully.');
    }
    
}
