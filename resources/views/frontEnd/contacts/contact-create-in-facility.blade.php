@extends('layouts.app')
@section('title')
Contact Create
@stop
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style type="text/css">
    button[data-id="contact_service"] {
        height: 100%;
        border: 1px solid #ddd;
    }
</style>

@section('content')
<div class="top_header_blank"></div>
<div class="inner_services">
    <div id="contacts-content" class="container">
        <div class="row">
            <!-- <div class="col-md-12">
                <input type="hidden" id="checked_terms" name="checked_terms">
            </div> -->
            <div class="col-md-12">
                <h4 class="card-title title_edit mb-30">
                    Create New Contact
                </h4>
                <form action="/add_new_contact_in_facility" method="GET">
                    <div class="card all_form_field">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact Name: </label>
                                        <input class="form-control selectpicker" type="text" id="contact_name"
                                            name="contact_name" value="">
                                            @error('contact_name')
                                            <span class="error-message"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" id="contact_facility_recordid" name="contact_facility_recordid" value="{{$facility->location_recordid}}">
                                <input type="hidden" id="contact_organization" name="contact_organization" value="{{$facility->location_organization}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service: </label>
                                        <select class="form-control selectpicker" multiple data-live-search="true" id="contact_service"
                                            name="contact_service[]" data-size="8">
                                            @foreach($service_info_list as $key => $service_info)
                                            <option value="{{$service_info->service_recordid}}">{{$service_info->service_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Title: </label>
                                        <input class="form-control selectpicker" type="text" id="contact_title"
                                            name="contact_title" value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Department: </label>
                                        <input class="form-control selectpicker" type="text" id="contact_department" name="contact_department"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Contact Email: </label>
                                        <input class="form-control selectpicker" type="text" id="contact_email"
                                            name="contact_email" value="">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Phones: <a id="add-phone-input"><i class="fas fa-plus btn-success btn float-right mb-5"></i></a></label>
                                        <ol id="phones-ul" class="row p-0 m-0" style="list-style: none;">
                                            <li class="contact-phones-li mb-2 col-md-4">
                                                <input class="form-control selectpicker contact_phones"  type="text" name="contact_phones[]" value="">
                                            </li>
                                        </ol>
                                    </div>
                                </div>  --}}
                            </div>
                        </div>
                    </div>
                    <div class="card all_form_field">
                        <div class="card-block">
                            <h4 class="title_edit text-left mb-25 mt-10">
                                Phones
                                <div class="d-inline float-right">
                                    <a href="javascript:void(0)" class="phoneModalOpenButton plus_delteicon bg-primary-color">
                                        <img src="/frontend/assets/images/plus.png" alt="" title="">
                                    </a>
                                </div>
                            </h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="">
                                            <table class="table table_border_none" id="PhoneTable">
                                                <thead>
                                                    <th>Number</th>
                                                    <th>extension</th>
                                                    <th style="width:200px;position:relative;">Type
                                                        <div class="help-tip" style="top:8px;">
                                                            <div><p>Select “Main” if this is the organization's primary phone number (or leave blank)
                                                            </p></div>
                                                        </div>
                                                    </th>
                                                    <th style="width:200px;">Language(s)</th>
                                                    <th style="width:200px;position:relative;">Description
                                                        <div class="help-tip" style="top:8px;">
                                                            <div><p>A description providing extra information about the phone service (e.g. any special arrangements for accessing, or details of availability at particular times).
                                                            </p></div>
                                                        </div>
                                                    </th>
                                                    <th>Main</th>
                                                    <th style="width:140px">&nbsp;</th>
                                                </thead>
                                                <tbody id="phonesTable">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="phone_language_data" id="phone_language_data" value="{{ $phone_language_data }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="button"  class="btn btn-raised btn-lg btn_darkblack waves-effect waves-classic waves-effect waves-classic yellow_btn" id="back-contact-btn"> Back</button>
                        <button type="submit" class="btn btn-primary btn-lg btn_padding waves-effect waves-classic waves-effect waves-classic green_btn" id="save-contact-btn"> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- phone modal --}}
@include('frontEnd.contacts.contactPhone')
{{-- phone modala close --}}

<script>
    $('#back-contact-btn').click(function() {
        history.go(-1);
        return false;
    });
    $(document).ready(function() {
        $('select#contact_service').val([]).change();
    });
    // let phone_language_data = []
    // $(document).on('change','div > .phone_language',function () {
    //     let value = $(this).val()
    //     let id = $(this).attr('id')
    //     let idsArray = id ? id.split('_') : []
    //     let index = idsArray.length > 0 ? idsArray[2] : ''
    //     phone_language_data[index] = value
    //     $('#phone_language_data').val(JSON.stringify(phone_language_data))
    // })
    // pt = 1
    // $('#addPhoneTr').click(function(){
    //     $('#PhoneTable tr:last').before('<tr><td><input type="text" class="form-control" name="contact_phones[]" id=""></td><td><input type="text" class="form-control" name="phone_extension[]" id=""></td><td>{!! Form::select("phone_type[]",$phone_type,[],["class" => "form-control selectpicker","data-live-search" => "true","id" => "phone_type","data-size" => 5,"placeholder" => "select phone type"])!!}</td><td><select name="phone_language[]" id="phone_language_'+pt+'" class="form-control selectpicker phone_language" data-size="5" data-live-search="true" multiple> @foreach ($phone_languages as $key=>$value)<option value="{{ $key }}">{{ $value }}</option> @endforeach </select></td><td><input type="text" class="form-control" name="phone_description[]" id=""></td><td style="vertical-align:middle;"><a href="javascript:void(0)" class="plus_delteicon btn-button removePhoneData"><img src="/frontend/assets/images/delete.png" alt="" title=""></a></td></tr>');
    //     $('.selectpicker').selectpicker();
    //     pt++;
    // })
    $(document).on('click', '.removePhoneData', function(){
        $(this).closest('tr').remove()
    });
    $("#add-phone-input").click(function(){
        $("ol#phones-ul").append(
            "<li class='service-phones-li mb-2 col-md-4'>"
          + "<input class='form-control selectpicker contact_phones'  type='text' name='contact_phones[]'>"
          + "</li>" );
    });

</script>
@endsection
