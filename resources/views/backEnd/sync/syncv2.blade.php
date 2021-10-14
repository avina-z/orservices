<div class="x_content">
    <div class="form-group">
        <h5>
            You can import data from an <a href="#" style="color: #027bff;">HSDS 2.0 Airtable Template</a>  into this software by filling out the following information and clicking “Sync All”

            Find your Airtable ID and API Key by clicking the “Help” menu item in your Airtable base and selecting the “API documentation” option.

            The Base ID is in the top section entitled “introduction”.

            The API Key is accessible by clicking “show API key” on the top right of the page. The key will then be displayed on the right side in the Authentication section of the docs.
        </h5>
    </div>
    <div class="form-group" style="width:100%;float:left;">
        <label for="airtable_api_key_input_v2" class="col-md-4">Airtable API Key</label>
        <div class="col-md-6">
            <input class="form-control" type="text" name="airtable_api_key_input_v2_1" id="airtable_api_key_input_v2_1" value="{{'***********'.substr($airtablekeyinfo_v2->api_key,-4)}}" readonly />
            <input class="form-control" type="text" name="airtable_api_key_input_v2" id="airtable_api_key_input_v2" value="{{$airtablekeyinfo_v2->api_key}}" style="display: none" required />
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <button type="button" class="btn btn-success" id="airtable_key_v2">edit</button>
        </div>
    </div>
    <div class="form-group"  style="width:100%;float:left;">
        <label for="airtable_base_url_input_v2" class="col-md-4">Airtable Base ID</label>
        <div class="col-md-6">
            {{-- <input class="form-control" type="text" name="airtable_base_url_input_v2_1" id="airtable_base_url_input_v2_1" value="{{'***********'.substr($airtablekeyinfo_v2->base_url,-4)}}" readonly /> --}}
            <input class="form-control" type="text" name="airtable_base_url_input_v2" id="airtable_base_url_input_v2" value="{{$airtablekeyinfo_v2->base_url}}"  required />
        </div>
        {{-- <div class="col-md-2 col-sm-2 col-xs-12">
            <button type="button" class="btn btn-success" id="airtable_base_id_v2">edit</button>
        </div> --}}
    </div>
    <div class="form-group">
        <label for="airtable_enable_auto_sync">Enable auto-sync: </label>
        <div class="row">
            <form action="/cron_datasync" method="GET" id="cron_airtable">
                {!! Form::token() !!}
                <div class="col-sm-4">
                    {{-- @if ($autosync->option == 'no')
                    <input class="form-control" type="checkbox" name="airtable_enable_auto_sync" id="airtable_enable_auto_sync" onclick="airtable_enable_autosync_Function()" >
                    @endif
                    @if ($autosync->option == 'yes')
                    <input class="form-control" type="checkbox" name="airtable_enable_auto_sync" id="airtable_enable_auto_sync" onclick="airtable_enable_autosync_Function()" checked>
                    @endif --}}
                    <label>Off&nbsp;&nbsp;
                        <input type="checkbox" class="js-switch form-control" value="checked" name="airtable_enable_auto_sync"  @if($autosync->option == 'yes') checked @endif/>&nbsp;&nbsp;On
                      </label>
                </div>
                <div class="col-sm-4">
                    @if ($autosync->option == 'yes')
                    <div class="form-group" id="auto_sync_div">
                        <label for="airtable_auto_sync_period">Sync every</label>
                        <input class="form-control" type="text" name="airtable_auto_sync_period" id="airtable_auto_sync_period" value="{{$autosync->days}}" style="width: 75px;" required />
                        <label for="airtable_auto_sync_period">number of hours</label>
                    </div>
                    @endif
                </div>
                <div class="col-sm-2">
                    {{-- @if ($autosync->option == 'yes')
                        @if ($autosync->working_status == 'no')
                        <button type="submit" name="btn_submit" class="btn btn-primary btn-start autosyncbtn" value="autosyncbtn-start" id="autosyncbtn-start">Start</button>
                        @endif
                        @if ($autosync->working_status == 'yes')
                        <button type="submit" name="btn_submit" class="btn btn-warning btn-stop autosyncbtn" value="autosyncbtn-stop" id="autosyncbtn-stop">Stop</button>
                        @endif
                    @endif --}}
                    <button type="submit" name="btn_submit" class="btn btn-primary btn-start autosyncbtn" value="autosyncbtn-start" id="autosyncbtn-start">Save</button>
                </div>
                <div class="col-sm-2">
                    <div class="clearfix text-right"><button class="btn btn-primary btn-sm sync_all_v2" id="sync_1_v2" type="button">SYNC ALL</button>  </div>
                </div>
            </form>
        </div>
    </div>

    <div class="alert alert-danger alert-dismissible field-invalid">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{-- <strong>Either of these infos is invalid or empty. Retype valid Airtable Key and Airtable Base Url.</strong> --}}
    </div>

    <table class="table table-striped jambo_table bulk_action" id="tblUsers">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Table Name</th>
                {{-- <th class="text-center">Table Source</th> --}}
                <th class="text-center">Total Records</th>
                <th class="text-center">Last Synced</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
          @foreach($airtables_v2 as $key => $airtable)
            <tr>
              <td class="text-center">{{$key+1}}</td>
              <td class="text-center">{{$airtable->name}}</td>
              {{-- <td class="text-center">ORnycServices(ATv1.1)</td> --}}
              <td class="text-center">{{$airtable->records}}</td>
              <td class="text-center">{{$airtable->syncdate}}</td>
              <td class="text-center">
                <button class="badge sync_now_v2" name="{{$airtable->name}}" style="background: #00a65a;">Sync Now</button>
                <button class="badge" style="background: #f39c12;"><a href="tb_{!! strtolower($airtable->name) !!}" style="color: white;">View Table</a></button>
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
</div>
