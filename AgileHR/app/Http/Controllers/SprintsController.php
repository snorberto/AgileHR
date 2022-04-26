<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprints;

class SprintsController extends Controller
{
    public function showOpenSprints()
    {

        $msg = Sprints::where('is_closed', 0)
                ->orderBy('updated_at', 'desc')
                ->get();

        return view('subPages.manageSprints_subs.getOpenSprints', ['sprints'=>$msg]);
    }
    public function showClosedSprints()
    {

        $msg = Sprints::where('is_closed', 1)
                ->orderBy('updated_at', 'desc')
                ->get();

        return view('subPages.manageSprints_subs.getClosedSprints', ['sprints'=>$msg]);
    }

    
    public function createNewSprint(Request $req)
    {

        //Add new sprint
        $msg = new Sprints;
        $msg->sprint_name= $req->sprintName;
        $msg->is_active= $req->is_activedropdown;
        $msg->save();


        $maxID = 0;
        if($req->is_activedropdown == 1){
            $maxID = Sprints::max('ID');
            
            Sprints::where('is_closed', 0)
                    ->where('ID','!=', $maxID)
                    ->update(['is_active' => 0]);
        }
        return redirect('createSprint')->with('success', 'Sprint created successfully.');
        
    }

    public function deleteSprint($id)
    {
        $data = Sprints::findOrFail($id);
        $data->delete();
        if($data->is_closed != 1){
            return redirect('getOpenSprints')->with('success', 'Data is successfully deleted');
        }
        else{
            return redirect('getClosedSprints')->with('success', 'Data is successfully deleted');
        }
    }

    public function SelectSprint($id)
    {
        $data = Sprints::findOrFail($id);
        return view('subPages.manageSprints_subs.editSprint', compact('data'));
    }

    public function editSelectedSprint(Request $req, $id){
        $this->validate($req,[
            'sprintName' => 'required',
        ]);
        
        /*
        $isActiveID = Sprints::where('is_active', 1)->first();        
        
        if(!is_null($isActiveID) && $isActiveID->ID != $id){
            Sprints::where('ID','=', $isActiveID->ID)
            ->update(['is_active' => 0]);
        }*/

        if($req->is_activedropdown == 1){
            Sprints::where('is_closed', 0)
                   ->update(['is_active' => 0]);
        }

        if($req->is_closeddropdown == 1){
            $req->is_activedropdown = 0;
        }
        $form_data = array(
            'sprint_name' => $req->sprintName,
            'is_active' => $req->is_activedropdown,
            'is_closed' => $req->is_closeddropdown
        );

        Sprints::whereId($id)->update($form_data);
        return redirect('getOpenSprints')->with('success', 'Data is successfully updated');        
    }
}
