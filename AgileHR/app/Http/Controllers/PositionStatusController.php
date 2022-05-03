<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\position_status;

class PositionStatusController extends Controller
{
    public function getPositionStatuses(){
        $msg = position_status::get();
        return view('subPages.managePosition_subs.getAllposition_statuses', ['pos_status'=>$msg]);

    }

    public function deleteSelectedStatus($id){
        $data = position_status::findOrFail($id);
        $data->delete();

        return redirect('maintainPositionStatus')->with('success', 'Status deleted successfully.');
    }

    public function editSelectedStatus(Request $req, $id){
        
        $this->validate($req,[
            'edit_name_input' => 'required'
        ]);

        $form_data = array(
            'PositionStatus' => $req->edit_name_input            
        );

        position_status::whereId($id)->update($form_data);
        return redirect('maintainPositionStatus')->with('success', 'Status edited successfully.');

    }

    public function addNewStatus(Request $req){
        $this->validate($req,[
            'add_name_input' => 'required'
        ]);

        $msg = new position_status;
        $msg->PositionStatus = $req->add_name_input;
        $msg->save();
        
        return redirect('maintainPositionStatus')->with('success', 'Status added successfully.');
    }
}
