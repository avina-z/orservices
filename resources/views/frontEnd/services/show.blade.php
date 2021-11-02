@extends('layouts.app')
@section('title')
{{$service->service_name}}
@stop
<style>
    .text_tooltips {
        position: relative;
        line-height: 20px;
        margin-top: 6px;
    }

    .text_tooltips .help-tip {
        top: 0;
        left: 0;
        width: 100%;
        border: none;
        background: none;
    }

    .text_tooltips .help-tip::before {
        display: none
    }

    .text_tooltips:hover .help-tip div {
        display: block;
        left: 0;
    }
</style>
@section('content')
@include('layouts.filter')
<div>

    <!-- Page Content Holder -->
    <div class="top_services_filter" style="display: inline-block;width: 100%;">
        <div class="container">
            @include('layouts.sidebar')
            <!-- Types Of Services -->
            {{-- <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle"  id="exampleSizingDropdown1" data-toggle="dropdown" aria-expanded="false">
                        Types Of Services
                    </button>
                    <div class="dropdown-menu bullet" aria-labelledby="exampleSizingDropdown1" role="menu">
                        <a class="dropdown-item drop-sort">Service Name</a>
                    </div>
                </div> --}}
            <!--end  Types Of Services -->

            <!-- download -->
            <div class="dropdown btn_download float-right">
                <button type="button" class="float-right btn_share_download dropdown-toggle" id=""
                    data-toggle="dropdown" aria-expanded="false">
                    <img src="/frontend/assets/images/download.png" alt="" title="" class="mr-10"> Download
                </button>
                <div class="dropdown-menu bullet" aria-labelledby="exampleBulletDropdown4" role="menu">
                    <a class="dropdown-item" href="/download_service_csv/{{$service->service_recordid}}"
                        role="menuitem">Download CSV</a>
                    <a class="dropdown-item " href="/download_service/{{$service->service_recordid}}"
                        role="menuitem">Download PDF</a>
                </div>
            </div>
            <!--end download -->

            <!-- share btn -->
            <button type="button" class="float-right btn_share_download" data-toggle="modal"
                data-target="#shareThisModal">
                <img src="/frontend/assets/images/share.png" alt="" title="" class="mr-10 share_image">
                Share
            </button>
            <!--end share btn -->
        </div>
    </div>
    <div class="inner_services">
        <div id="content" class="container">
            <!-- Example Striped Rows -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">
                                <a href="#">{{$service->service_name}}</a>
                                @if (Auth::user() && Auth::user()->roles && $organization &&
                                Auth::user()->user_organization && str_contains(Auth::user()->user_organization,
                                $service->organizations()->first()->organization_recordid) && Auth::user()->roles->name
                                == 'Organization Admin' || (Auth::user() && Auth::user()->roles &&
                                Auth::user()->roles->name == 'System Admin'))
                                <a href="/services/{{$service->service_recordid}}/edit" class="float-right">
                                    @if ($service->access_requirement == 'yes')
                                    <img src="/images/noun_Lock and Key_1043619.png" width="30px"
                                        alt="noun_Lock and Key_1043619" style="margin-right: 6px" />
                                    @endif
                                    <i class="icon md-edit mr-0"></i>
                                </a>
                                @endif
                            </h4>
                            @if(isset($service->service_alternate_name))
                            <h4>
                                <span class="subtitle"><b>Alternate Name: </b></span>
                                {{$service->service_alternate_name}}
                            </h4>
                            @endif
                            @if ($service->service_organization)
                            <h4 class="org_title"><span class="subtitle"><b>Organization:</b></span>
                                @if($service->service_organization!=0)
                                @if(isset($service->organizations))
                                <a class="panel-link" class="notranslate"
                                    href="/organizations/{{$service->organizations()->first()->organization_recordid}}">
                                    {{$service->organizations()->first()->organization_name}}</a>
                                @endif
                                @endif
                            </h4>
                            @endif
                            @if ($service->service_description)
                            <h4 class="service-description" style="line-height: inherit;"> {!!
                                nl2br($service->service_description) !!}</h4>
                            @endif
                            @if(isset($mainPhoneNumber) && count($mainPhoneNumber) > 0)
                            <h4 style="line-height: inherit;">
                                <span><i class="icon md-phone font-size-18 vertical-align-top mr-0 pr-10"></i>
                                    @foreach ($mainPhoneNumber as $key => $item)
                                    <p><a
                                        href="tel:{{$item->phone_number}}">{{ $item->phone_number}}</a>&nbsp;&nbsp;{{ $item->phone_extension ? 'ext. '. $item->phone_extension : '' }}&nbsp;{{ $item->type ? '('.$item->type->type.')' : '' }}
                                    @if ($item->phone_language)
                                    <br>
                                    {{ $item->phone_language }}
                                    @endif
                                        {{ $item->phone_description ? '- '.$item->phone_description : '' }}</p>
                                    @endforeach
                                </span>
                            </h4>
                            @endif
                            @if ($service->service_url)
                            <h4 style="line-height: inherit;">
                                <span>
                                    <i class="icon md-globe font-size-18 vertical-align-top mr-0 pr-10"></i>
                                    @if($service->service_url!=NULL)<a href="{!! $service->service_url !!}">{!!
                                        $service->service_url !!}</a> @endif
                                </span>
                            </h4>
                            @endif


                            @if($service->service_email!=NULL)
                            <h4 style="line-height: inherit;">
                                <span>
                                    <i class="icon md-email font-size-18 vertical-align-top mr-0 pr-10"></i>
                                    {{$service->service_email}}
                                </span>
                            </h4>
                            @endif

                            @if(isset($service->languages) && count($service->languages) > 0)
                            <h4 style="line-height: inherit;">
                                <span>
                                    <i class="icon fa-language  font-size-18 vertical-align-top mr-0 pr-10"></i>
                                    @foreach($service->languages as $language)
                                    @if($loop->last)
                                    {{$language->language}}
                                    @else
                                    {{$language->language}},
                                    @endif
                                    @endforeach
                                </span>
                            </h4>
                            @endif

                            @if($service->service_application_process)
                            <h4>
                                <span class="subtitle"><b>Application</b></span> {!!
                                $service->service_application_process
                                !!}
                            </h4>
                            @endif

                            @if($service->service_wait_time)
                            <h4><span class="subtitle"><b>Wait Time:</b></span> {{$service->service_wait_time}}</h4>
                            @endif

                            @if($service->service_fees)
                            <h4><span class="subtitle"><b>Fees:</b></span> {{$service->service_fees}}</h4>
                            @endif

                            @if($service->service_accreditations)
                            <h4><span class="subtitle"><b>Accreditations</b></span> {{$service->service_accreditations}}
                            </h4>
                            @endif

                            @if($service->service_licenses)
                            <h4><span class="subtitle"><b>Licenses</b></span> {{$service->service_licenses}}</h4>
                            @endif


                            @if(isset($service->schedules()->first()->byday))
                            <h4><span class="subtitle"><b>Schedules</b></span><br />
                                {{-- @foreach($service->schedules as $schedule)
                                @if($loop->last)
                                {{$schedule->byday}} {{$schedule->opens_at}}
                                {{$schedule->closes_at}}
                                @else
                                {{$schedule->byday}} {{$schedule->opens_at}}
                                {{$schedule->closes_at}},
                                @endif
                                @endforeach --}}

                            </h4>
                            @foreach($service->schedules as $key => $schedule)

                            @if ($schedule->schedule_holiday)
                            @php
                            $holidayScheduleData[] = 1;
                            @endphp
                            @endif
                            @if ($schedule->byday && ($schedule->schedule_closed == null && $schedule->opens_at) ||
                            ($schedule->schedule_closed && $schedule->schedule_holiday == null))
                            <h4
                                style="color:{{ strtolower(\Carbon\Carbon::now()->format('l')) == $schedule->byday ? 'blue' : '' }}">
                                <b style="font-weight: 600;color: #000; letter-spacing: 0.5px;">{{ ucfirst($schedule->byday) }}
                                    :</b>
                                @if ($schedule->schedule_closed == null)
                                {{ $schedule->opens_at }} - {{ $schedule->closes_at }}
                                @else
                                Closed
                                @endif
                            </h4>
                            @endif
                            @endforeach
                            @if (isset($holidayScheduleData))
                            <span
                                style="margin-bottom: 20px;display: inline-block;font-weight: 600;text-decoration: underline; color: #5051db;cursor: pointer;"
                                id="showHolidays"><a>Show holidays</a></span>
                            @endif
                            <div style="display: none;" id="holidays">
                                <span class="subtitle"><b>Holidays</b></span><br />
                                @foreach($service->schedules as $schedule)
                                @if ($schedule->schedule_holiday)

                                <h4 style="color: #000;">
                                    {{ $schedule->dtstart }} to {{ $schedule->dtstart }} :
                                    @if ($schedule->schedule_closed == null)
                                    {{ $schedule->opens_at }} - {{ $schedule->closes_at }}
                                    @else
                                    Closed
                                    @endif
                                </h4>
                                @endif
                                @endforeach
                                <span
                                    style="margin-bottom: 20px;display: inline-block;font-weight: 600;text-decoration: underline; color: #5051db;cursor: pointer;"
                                    id="hideHolidays"><a>Hide holidays</a></span> <br>
                            </div>
                            @endif
                            {{-- @if ($service->program && count($service->program) > 0)
                            <h4>
                                <span class="pl-0 category_badge subtitle"><b>Service Grouping:</b>
                                    <span class="">{!! $service->program[0]->name !!}</span>
                                </span>
                            </h4>
                            <h4>
                                <span class="pl-0 category_badge subtitle"><b>Service Grouping Description:</b>
                                    <span class="">{!! $service->program[0]->alternate_name !!}</span>
                                </span>
                            </h4>
                            @endif --}}
                            @if ($service->service_status)
                            <h4>
                                <span class="pl-0 category_badge subtitle"><b>Service Status:</b>
                                    <span class="">{!! $service->service_status !!}</span>
                                </span>
                            </h4>
                            @endif
                            @isset($service->taxonomy)
                            @if (count($service->taxonomy) > 0)
                            @php
                                $i = 0;
                                $j = 0;
                            @endphp
                            <h4>
                                <span class="pl-0 category_badge subtitle">
                                    @foreach ($service->taxonomy as $service_taxonomy_info)
                                    @if (isset($service_taxonomy_info->taxonomy_type) &&
                                    count($service_taxonomy_info->taxonomy_type) > 0 &&
                                    $service_taxonomy_info->taxonomy_type[0]->name == 'Service Category')
                                    @if($service->service_taxonomy != null)
                                    @if ($i == 0)
                                    <b>Service Category:</b>
                                    @php
                                        $i ++;
                                    @endphp
                                    @endif
                                    <a class="panel-link {{str_replace(' ', '_', $service_taxonomy_info->taxonomy_name)}}"
                                        at="child_{{$service_taxonomy_info->taxonomy_recordid}}"
                                        style="background-color: {{ $service_taxonomy_info->badge_color ? '#'.$service_taxonomy_info->badge_color : '#000' }} !important; color:#fff !important;">{{$service_taxonomy_info->taxonomy_name}}</a>
                                    @endif
                                    @endif
                                    @endforeach
                                </span>
                            </h4>

                            <h4>
                                <span class="pl-0 category_badge subtitle">
                                    @foreach ($service->taxonomy as $service_taxonomy_info)
                                    @if (isset($service_taxonomy_info->taxonomy_type) &&
                                    count($service_taxonomy_info->taxonomy_type) > 0 &&
                                    $service_taxonomy_info->taxonomy_type[0]->name == 'Service Eligibility')
                                    @if($service->service_taxonomy != null)
                                    @if ($j == 0)
                                    <b>Service Eligibility:</b>
                                    @php
                                        $j ++;
                                    @endphp
                                    @endif
                                    <a class="panel-link {{str_replace(' ', '_', $service_taxonomy_info->taxonomy_name)}}"
                                        at="child_{{$service_taxonomy_info->taxonomy_recordid}}"
                                        style="background-color: {{ $service_taxonomy_info->badge_color ? '#'.$service_taxonomy_info->badge_color : '#000' }} !important; color:#fff !important;">{{$service_taxonomy_info->taxonomy_name}}</a>
                                    @endif
                                    @endif
                                    @endforeach
                                </span>
                            </h4>
                            @endif
                            @endisset
                            @if ($service->program && count($service->program) > 0)
                            <h4>
                                <span class="pl-0 category_badge subtitle"><b>Related Program:</b></span>
                                <ul>
                                    @if (count($service->program) == 1 && isset($service->program[0]))
                                    <li class="text_tooltips">
                                        <u>{{ $service->program[0]->name }}</u>
                                        @if ($service->program[0]->alternate_name)
                                        <div class="help-tip">
                                            <div style="width: 300px;">
                                                <p>{{ $service->program[0]->alternate_name }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($service->program[0]->program_service_relationship)
                                        participation is
                                        {{ $service->program[0]->program_service_relationship == 'not_required' ? 'Not Required' : Str::ucfirst($service->program[0]->program_service_relationship) }}.
                                        @endif
                                    </li>
                                </ul>
                                @else
                                <ul>
                                    @foreach ($service->program as $key => $program)
                                    <li class="text_tooltips">
                                        {{ $program->name }}
                                        @if ($program->program_service_relationship)
                                        @if ($program->alternate_name)
                                        <div class="help-tip">
                                            <div style="width: 300px;">
                                                <p>{{ $program->alternate_name }}</p>
                                            </div>
                                        </div>
                                        @endif
                                        participation is
                                        {{ $program->program_service_relationship == 'not_required' ? 'Not Required' : Str::ucfirst($program->program_service_relationship)}}.
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </h4>
                            @endif

                            @if($service->service_details!=NULL)
                            @php
                            $show_details = [];
                            @endphp
                            @foreach($service->details->sortBy('detail_type') as $detail)
                            @php
                            for($i = 0; $i < count($show_details); $i ++){
                                if($show_details[$i]['detail_type']==$detail->
                                detail_type)
                                break;
                                }
                                if($i == count($show_details)){
                                $show_details[$i] = array('detail_type'=> $detail->detail_type, 'detail_value'=>
                                $detail->detail_value);
                                }
                                else{
                                $show_details[$i]['detail_value'] = $show_details[$i]['detail_value'].',
                                '.$detail->detail_value;
                                }
                                @endphp
                                @endforeach
                                @foreach($show_details as $detail)
                                <h4><span class="subtitle"><b>{{ $detail['detail_type'] }}:</b></span> {!!
                                    $detail['detail_value'] !!}</h4>
                                @endforeach
                                @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4 property">
                    {{-- <div class="pt-10 pb-10 pl-0 btn-download">
                        <a href="/download_service/{{$service->service_recordid}}"
                    class="btn btn-primary btn-button">Download PDF</a>
                    <button type="button" class="btn btn-primary btn-button" style="padding: 1px;">
                        <div class="sharethis-inline-share-buttons"></div>
                    </button>
                </div> --}}
                @if ((Auth::user() && Auth::user()->roles && Auth::user()->user_organization &&
                (Auth::user()->user_organization == ($service->organizations ?
                $service->organizations()->first()->organization_recordid : '')) && Auth::user()->roles->name ==
                'Organization Admin') || Auth::user() && Auth::user()->roles && Auth::user()->roles->name == 'System
                Admin')
                <div style="display: flex;" class="mb-20">
                    <div class="dropdown add_new_btn" style="width: 100%; float: right;">
                        <button class="btn btn-primary dropdown-toggle btn-block" type="button"
                            id="dropdownMenuButton-group" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fas fa-plus"></i> Add New
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-new">
                            {{-- <a href="/service_create/{{$service->service_recordid}}" id="add-new-services">Add New
                            Service</a> --}}
                            <a href="/contact_create/{{$service->service_recordid}}/service" id="add-new-services">Add
                                New Contact</a>
                            <a href="/facility_create/{{$service->service_recordid}}/service" id="add-new-services">Add
                                New Location</a>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Locations area design -->
                <div class="card">
                    <div class="card-block p-0">
                        <div id="map" style="width: 100%; height: 60vh;border-radius:0px;box-shadow: none;">
                        </div>
                        <div class="p-25">
                            @if(isset($service->locations))
                            @if($service->locations != null && count($service->locations) > 0)
                            <h4 class="card_services_title">
                                <b>Locations</b>
                                @if (Auth::user() && Auth::user()->roles && $organization &&
                                Auth::user()->user_organization &&
                                str_contains(Auth::user()->user_organization, $organization->organization_recordid) &&
                                Auth::user()->roles->name == 'Organization Admin')
                                <a href="/facilities/{{$service->service_locations}}/edit" class="float-right">
                                    <i class="icon md-edit mr-0"></i>
                                </a>
                                @endif
                            </h4>
                            @endif
                            @endif
                            <div>
                                @if(isset($service->locations))
                                @if($service->locations != null)
                                @foreach($service->locations as $location)
                                <div class="location_border">
                                    <h4>
                                        @if (Auth::user() && Auth::user()->roles && Auth::user()->roles->name == 'System
                                        Admin')
                                        <a href="/facilities/{{$location->location_recordid}}/edit" class="float-right">
                                            <i class="icon md-edit mr-0"></i>
                                        </a>
                                        @endif
                                    </h4>
                                    <div>
                                        @if($location->location_name)
                                        <h4>
                                            <span><i class="icon fas fa-building font-size-18 vertical-align-top  "></i>
                                                {{$location->location_name}}
                                                {{ $location->location_alternate_name ? '('.$location->location_alternate_name.')' : '' }}
                                            </span>
                                        </h4>
                                        @endif
                                        <h4>
                                            <span><i class="icon md-pin font-size-18 vertical-align-top "></i>
                                                @if(isset($location->address))
                                                @if($location->address != null)
                                                @foreach($location->address as $address)
                                                {{ $address->address_1 }} {{ $address->address_2 }}
                                                {{ $address->address_city }} {{ $address->address_state_province }}
                                                {{ $address->address_postal_code }}
                                                @endforeach
                                                @endif
                                                @endif
                                            </span>
                                        </h4>
                                        @if($location->location_hours)
                                        <h4>
                                            <span><i class="icon fa-clock-o font-size-18 vertical-align-top "></i>
                                                {{$location->location_hours}}
                                            </span>
                                        </h4>
                                        @endif
                                        @if($location->location_transportation)
                                        <h4>
                                            <span><i class="icon fa-truck font-size-18 vertical-align-top "></i>
                                                {{$location->location_transportation}}
                                            </span>
                                        </h4>
                                        @endif
                                        @if(isset($location->phones))
                                        @if($location->phones != null)
                                        @if(count($location->phones) > 0)
                                        <h4>
                                            <span>

                                                @php
                                                $phones = '';
                                                @endphp
                                                @foreach($location->phones as $k => $phone)
                                                @php
                                                if($phone->phone_number){
                                                if($k == 0){
                                                $phoneNo = '<a
                                                    href="tel:'.$phone->phone_number.'">'.$phone->phone_number.'</a>';
                                                }else{
                                                $phoneNo = ', '.'<a
                                                    href="tel:'.$phone->phone_number.'">'.$phone->phone_number .'</a>';
                                                }
                                                $phones .= $phoneNo;
                                                }
                                                @endphp
                                                @endforeach
                                                @if ($phones != '')
                                                <i class="icon md-phone font-size-18 vertical-align-top "></i>
                                                {!! rtrim($phones, ',') !!}
                                                @endif
                                            </span>
                                        </h4>
                                        @endif
                                        @endif
                                        @endif
                                        @if ($location->location_description)
                                        <h4>
                                            <span>
                                                {{$location->location_description}}
                                            </span>
                                        </h4>
                                        @endif
                                        @if(isset($location->accessibilities()->first()->accessibility))
                                        <h4>
                                            <span><b>Accessibility for disabilities:</b></span>
                                            <br />
                                            {{$location->accessibilities()->first()->accessibility}}
                                        </h4>
                                        @endif
                                        @if(isset($location->schedules()->first()->byday))
                                        <h4 class="panel-text">
                                            <span class="badge bg-red"><b>Schedules:</b></span>
                                            @if($location->schedules != null)
                                            @foreach($location->schedules as $schedule)
                                            @if($loop->last)
                                            {{$schedule->byday}} {{$schedule->opens_at}}
                                            {{$schedule->closes_at}}
                                            @else
                                            {{$schedule->byday}} {{$schedule->opens_at}}
                                            {{$schedule->closes_at}},
                                            @endif
                                            @endforeach
                                            @endif
                                        </h4>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- contact area design -->
                @if($contact_info_list && count($contact_info_list) > 0)
                <div class="card">
                    <div class="card-block">
                        <h4 class="card_services_title"> Contacts </h4>
                        @foreach($contact_info_list as $contact_info)
                        <div class="location_border">
                            @if (Auth::user() && Auth::user()->roles && Auth::user()->roles->name == 'System Admin')
                            <a href="/contacts/{{$contact_info->contact_recordid}}/edit" class="float-right">
                                <i class="icon md-edit mr-0"></i>
                            </a>
                            @endif
                            <table class="table ">
                                <tbody>
                                    @if($contact_info->contact_name)
                                    <tr>
                                        <td>
                                            <h4 class="m-0"><span><b>Name:</b></span> </h4>
                                        </td>
                                        <td>
                                            <h4 class="m-0"><a
                                                    href="/contacts/{{$contact_info->contact_recordid}}">{{$contact_info->contact_name}}</a>
                                            </h4>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($contact_info->contact_title)
                                    <tr>
                                        <td>
                                            <h4 class="m-0"><span><b>Title:</b></span> </h4>
                                        </td>
                                        <td>
                                            <h4 class="m-0"><span>{{$contact_info->contact_title}}</span></h4>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($contact_info->contact_department)
                                    <tr>
                                        <td>
                                            <h4 class="m-0"><span><b>Department:</b></span> </h4>
                                        </td>
                                        <td>
                                            <h4 class="m-0"><span>{{$contact_info->contact_department}}</span></h4>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($contact_info->contact_email)
                                    <tr>
                                        <td>
                                            <h4 class="m-0"><span><b>Email:</b></span> </h4>
                                        </td>
                                        <td>
                                            <h4 class="m-0"><span>{{$contact_info->contact_email}}</span></h4>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($contact_info->contact_phones)
                                    @if(isset($contact_info->phone->phone_number))
                                    <tr>
                                        <td>
                                            <h4 class="m-0"><span><b>Phones:</b></span> </h4>
                                        </td>
                                        <td>
                                            <h4 class="m-0"><span> {{$contact_info->phone->phone_number}}</span></h4>
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- contact area design -->
                @auth
                <div class="card ">
                    <div class="card-block">
                        <h4 class="card_services_title ">Change Log</h4>
                        @foreach ($serviceAudits as $item)
                        @if (count($item->new_values) != 0)
                        <div class="py-10" style="float: left; width:100%;border-bottom: 1px solid #dadada;">
                            <p class="mb-5" style="color: #000;font-size: 16px;">On
                                <a href="/viewChanges/{{ $item->id }}/{{ $service->service_recordid }}"
                                    style="font-family: Neue Haas Grotesk Display Medium; color:#5051DB; text-decoration:underline;"><b
                                        style="font-family: Neue Haas Grotesk Display Medium; color:#5051DB; text-decoration:underline;">{{ $item->created_at }}</b></a>
                                ,
                                @if ($item->user)
                                <a href="/userEdits/{{ $item->user ? $item->user->id : '' }}"
                                    style="font-family: Neue Haas Grotesk Display Medium; color:#5051DB; text-decoration:underline;">
                                    <b
                                        style="font-family: Neue Haas Grotesk Display Medium; color:#5051DB;text-decoration:underline;">{{ $item->user ? $item->user->first_name.' '.$item->user->last_name : '' }}</b>
                                </a>
                                @endif
                            </p>
                            @foreach ($item->old_values as $key => $v)
                            @php
                            $fieldNameArray = explode('_',$key);
                            $fieldName = implode(' ',$fieldNameArray);
                            $new_values = explode('| ',$item->new_values[$key]);
                            $old_values = explode('| ',$v);
                            $old_values = array_values(array_filter($old_values));
                            $new_values = array_values(array_filter($new_values));
                            @endphp
                            <ul style="padding-left: 0px;font-size: 16px;">
                                @if($v && count($old_values) > count($new_values))

                                @php
                                $diffData = array_diff($old_values,$new_values);
                                @endphp
                                <li style="color: #000;list-style: disc;list-style-position: inside;">Removed <b
                                        style="font-family: Neue Haas Grotesk Display Medium;">{{ Str::ucfirst($fieldName) }}</b>
                                    <span style="color: #FF5044">{{ implode(' | ',$diffData) }}</span>
                                </li>
                                @elseif($v && count($old_values) < count($new_values)) @php
                                    $diffData=array_diff($new_values,$old_values); @endphp <li
                                    style="color: #000;list-style: disc;list-style-position: inside;">Added <b
                                        style="font-family: Neue Haas Grotesk Display Medium;">{{ Str::ucfirst($fieldName) }}</b>
                                    <span style="color: #35AD8B">{{ implode(' | ',$diffData) }}</span>
                                    </li>
                                    @elseif($v && count($new_values) == count($old_values))
                                    @php
                                    $diffData = array_diff($new_values,$old_values);
                                    @endphp
                                    <li style="color: #000;list-style: disc;list-style-position: inside;">Added <b
                                            style="font-family: Neue Haas Grotesk Display Medium;">{{ Str::ucfirst($fieldName) }}</b>
                                        <span style="color: #35AD8B">{{ implode(' | ',$diffData) }}</span>
                                    </li>
                                    {{-- <li style="color: #000;list-style: disc;list-style-position: inside;">Changed <b style="font-family: Neue Haas Grotesk Display Medium;">{{ Str::ucfirst($fieldName) }}</b>
                                    from <span style="color: #FF5044">{{ $v }}</span> to <span
                                        style="color: #35AD8B">{{ $new_values ? $new_values : 'none' }}</span>
                                    </li> --}}
                                    @elseif($item->new_values[$key])
                                    <li style="color: #000;list-style: disc;list-style-position: inside;">Added <b
                                            style="font-family: Neue Haas Grotesk Display Medium;">{{ Str::ucfirst($fieldName) }}</b>
                                        <span style="color: #35AD8B">{{ $item->new_values[$key] }}</span>
                                    </li>
                                    @endif
                            </ul>
                            @endforeach
                            {{-- <span><a href="/viewChanges/{{ $item->id }}/{{ $service->service_recordid }}"
                            style="font-family: Neue Haas Grotesk Display Medium; color:#5051DB;
                            text-decoration:underline;">View
                            Changes</a></span> --}}
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // navigator.geolocation.getCurrentPosition(showPosition)

    setTimeout(function(){
        var locations = <?php print_r(json_encode($locations)) ?>;
        var maplocation = <?php print_r(json_encode($map)) ?>;


        var show = 1;
        if(locations.length == 0){
          show = 0;
        }

        if(maplocation.active == 1){
            avglat = maplocation.lat;
            avglng = maplocation.long;
            zoom = maplocation.zoom_profile;
        }
        else
        {
            avglat = 40.730981;
            avglng = -73.998107;
            zoom = 10
        }

        latitude = null;
        longitude = null;

        if (locations[0]) {
            latitude = locations[0].location_latitude;
            longitude = locations[0].location_longitude;
        }
        if(latitude == null){
            latitude = avglat;
            longitude = avglng;
        }

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom,
            center: {lat: parseFloat(latitude), lng: parseFloat(longitude)}
        });

        var latlongbounds = new google.maps.LatLngBounds();
        var markers = locations.map(function(location, i) {

            var position = {
                lat: location.location_latitude,
                lng: location.location_longitude
            }
            var latlong = new google.maps.LatLng(position.lat, position.lng);
            latlongbounds.extend(latlong);

            var content = '<div id="iw-container">' +
                        '<div class="iw-title"> <a href="#">' + location.service + '</a> </div>' +
                        '<div class="iw-content">' +
                            '<div class="iw-subTitle">Organization Name</div>' +
                            '<a href="/organizations/' + location.organization_recordid + '">' + location.organization_name +'</a>' ;
                            // '<a href="https://www.google.com/maps/dir/?api=1&destination=' + location.address_name + '" target="_blank">' + location.address_name +'</a>'+
                            if(location.address){
                                for(i = 0; i < location.address.length; i ++){
                                    content +=  '<div class="iw-subTitle">Address</div>'+
                                            location.address[i].address_1+ ', '+location.address[i].address_city+','+location.address[i].address_state_province+','+location.address[i].address_postal_code ;
                                    content += '<div><a href="https://www.google.com/maps/dir/?api=1&destination=' + location.address[i].address_1+ ', '+location.address[i].address_city+','+location.address[i].address_state_province+','+location.address[i].address_postal_code + '" target="_blank">View on Google Maps</a></div>';
                                }
                            }
                        content += '</div>' +
                        '<div class="iw-bottom-gradient"></div>' +
                        '</div>';

            var infowindow = new google.maps.InfoWindow({
                content: content
            });

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                title: location.location_name,
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
            return marker;
        });

        // map.fitBounds(latlongbounds);
        if (locations.length > 1) {
          map.fitBounds(latlongbounds);
      }

    }, 2000);


    $('.panel-link').on('click', function(e){
        if($(this).hasClass('target-population-link') || $(this).hasClass('target-population-child'))
            return;
        var id = $(this).attr('at');
        // console.log(id);
        // $("#category_" +  id).prop( "checked", true );
        // $("#checked_" +  id).prop( "checked", true );
        selected_taxonomy_ids = id.toString();
        $("#selected_taxonomies").val(selected_taxonomy_ids);
        $("#filter").submit();
    });

    $('.panel-link.target-population-link').on('click', function(e){
        $("#target_all").val("all");
        $("#filter").submit();
    });

    $('.panel-link.target-population-child').on('click', function(e){
        var id = $(this).attr('at');
        $("#target_multiple").val(id);
        $("#filter").submit();

    });
});
$('#showHolidays').click(function(){
    $('#holidays').show();
    $('#hideHolidays').show();
    $(this).hide()
})
$('#hideHolidays').click(function(){
    $('#holidays').hide();
    $('#showHolidays').show();
    $(this).hide()
})

</script>
@endsection
