@extends("subPages.manageCandidate")
@section("manageCandidateSubContent")

<div class="miniheader-subContents">
    <h3>Edit selected candidate</h3>
</div>

<table class="formTable">
    <form id="updateForm" method="post" action=/{{"manageCandidate_updateSelectedCandidate_details/".$can_details['ID']}} enctype="multipart/form-data">
    @csrf
        <tr>            
            <td colspan=2><b>Name</b></td>
            <td colspan=2><input type="text" name="can_name" value="{{ $can_details->Name }}" required/></td>
        </tr>
        <tr>
            <td colspan=2><b>LinkedIn profile</b></td>
            <td colspan=2><input type="text" name="can_link" value="{{ $can_details->Link }}" /></td>
        </tr>
        <tr>
            <td colspan=4><b>Description</b></td>
        </tr>
        <tr>
            <td colspan=4><textarea name="can_details_desc" rows=12 cols=100 required>{{$can_details['Description']}}</textarea></td>
        </tr>
        <tr>
            <td colspan=2><b>Attachment</b></td>
            <td colspan=2>@if(!is_null($can_details['Attachments']))<a href="{{ URL::to('/') }}/attachments/candidate_cvs/{{ $can_details['Attachments'] }}">Attachment</a>@else No attachments found @endif</td>
        </tr>
        <tr>
            <td colspan=2><b>Update attachment(docx and pdf accepted only!)</b></td>
            <td colspan=2><input type="file" name="can_attachment"/></td>
        </tr>

        </tr>  
        <tr>
            <td colspan=4><input type="submit" name="edit" value="Edit candidate details" /></td>
        </tr>
    </form>
    <tr>
        <td colspan=4><b>Contact informations</b></td>
    </tr>
    <tr>
        @if($can_contact_info->isEmpty())
            <td colspan=4>No contact information available</td>
        @else
            <td>
                <table>
                    @foreach($can_contact_info as $can_ci)
                    <tr>
                        <td><b>{{$can_ci->ContactType}}:</b></td>
                        <td colspan=2>{{$can_ci->ContactInfo_value}}</td>
                        <td><a href=/{{"manageCandidate_deleteSelectedContactInfo/".$can_ci['ID']."&canID=".$can_details['ID']}}> <b>Remove</b> </a></td>
                        @endforeach
                    </tr>
                </table>
            </td>
        @endif
    </tr>
    <tr>
        <form method="post" action=/{{"manageCandidate_addNewContactInfo/".$can_details['ID']}} enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="can_sub_contactInfo_id" value="{{ $can_details->ID }}" />
            <td>
                <select name="select_contactInfo" >
                        @foreach($contact_info_types as $cit)
                        <option value="{{$cit['ID']}}">{{$cit['ContactType']}} </option>
                        @endforeach
                </select>
            </td>
            <td>
                <input type="text" name=can_contact_value required />
            </td>
            <td>
                <input type="submit" name="addContact_type" value="Add/Edit" />
            </td>
        </form>
    </tr>
    <tr>
        <td colspan=4><b>Labels</b></td>
    </tr>
    <tr>
        @if($can_labels->isEmpty())
            <td colspan=4>No labels available</td>
        @else
            <td>
                <table>
                    @foreach($can_labels as $can_lab)
                    <tr>
                        <td colspan=2>{{$can_lab->Label_value}}</td>
                        <td><a href=/{{"manageCandidate_deleteSelectedLabel/".$can_lab['ID']."&canID=".$can_details['ID']}}> <b>Remove</b> </a></td>
                        @endforeach
                    </tr>
                </table>
            </td>
        @endif
    </tr>
    <tr>
        <form method="post" action=/{{"manageCandidate_addNewLabel/".$can_details['ID']}} enctype="multipart/form-data">
            @csrf
            <td>
                <select name="select_labelType" >
                        @foreach($label_types as $labtype)
                        <option value="{{$labtype['ID']}}">{{$labtype['Label_value']}} </option>
                        @endforeach
                </select>
            </td>
            <td>
                <input type="submit" name="addContact_type" value="Add/Edit" />
            </td>
        </form>
    </tr>
</table>


@stop