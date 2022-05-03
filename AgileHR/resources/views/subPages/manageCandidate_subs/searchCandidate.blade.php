@extends("subPages.manageCandidate")
@section("manageCandidateSubContent")

<div class="miniheader-subContents">
    <h3>Search candidates</h3>
</div>
<div>
    <div class="miniheader-subContents">
        <h5>Search by Name, description: </h5>
    </div>
    <table class="formTable">        

        <form method="post" action="StartSearchCandidate" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf
            <tr> 
                <td><input type="text" name="Searchbox_candidate" class="" required placeholder="Search..."/></td>
                <td><input type="submit" name="searchcandidate_searchbtn" class="" value="Search" /></td>        
            </tr>
        </form>
    </table>
</div>

<div>
    <div class="miniheader-subContents">
        <h5>Search by label: </h5>
    </div>
    <table class="formTable">        

    <form method="post" action="StartSearchCandidatebyLabel" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @csrf
        <tr> 
        
            <td>
                <select name="selectedLabel">
                        <option value="">-</option>
                        @foreach($label_types as $l)
                        <option value="{{$l['ID']}}">{{$l['Label_value']}} </option>
                        @endforeach
                </select>
            </td>
            <td><input type="submit" name="searchcandidate_searchbtn" class="" value="Search" /></td>        
        </tr>
    </form>
    </table>
</div>

@stop