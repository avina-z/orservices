<?php

namespace App\Http\Controllers\frontEnd;

use App\Functions\Airtable;
use App\Http\Controllers\Controller;
use App\Imports\ScheduleImport;
use App\Model\Airtable_v2;
use App\Model\Airtablekeyinfo;
use App\Model\Airtables;
use App\Model\CSV_Source;
use App\Model\Locationschedule;
use App\Model\Schedule;
use App\Model\Serviceschedule;
use App\Model\Source_data;
use App\Services\Stringtoint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{

    public function airtable($api_key, $base_url)
    {

        $airtable_key_info = Airtablekeyinfo::find(1);
        if (!$airtable_key_info) {
            $airtable_key_info = new Airtablekeyinfo;
        }
        $airtable_key_info->api_key = $api_key;
        $airtable_key_info->base_url = $base_url;
        $airtable_key_info->save();

        Schedule::truncate();
        // $airtable = new Airtable(array(
        //     'api_key'   => env('AIRTABLE_API_KEY'),
        //     'base'      => env('AIRTABLE_BASE_URL'),
        // ));
        $airtable = new Airtable(array(
            'api_key' => $api_key,
            'base' => $base_url,
        ));

        $request = $airtable->getContent('schedule');

        do {

            $response = $request->getResponse();

            $airtable_response = json_decode($response, true);

            foreach ($airtable_response['records'] as $record) {

                $schedule = new Schedule();
                $strtointclass = new Stringtoint();

                $schedule->schedule_recordid = $strtointclass->string_to_int($record['id']);

                $schedule->schedule_id = isset($record['fields']['id']) ? $record['fields']['id'] : null;

                $schedule->schedule_services = isset($record['fields']['services']) ? implode(",", $record['fields']['services']) : null;

                if (isset($record['fields']['services'])) {
                    $i = 0;
                    foreach ($record['fields']['services'] as $value) {

                        $scheduleservice = $strtointclass->string_to_int($value);

                        if ($i != 0) {
                            $schedule->schedule_services = $schedule->schedule_services . ',' . $scheduleservice;
                        } else {
                            $schedule->schedule_services = $scheduleservice;
                        }

                        $i++;
                    }
                }

                if (isset($record['fields']['locations'])) {
                    $i = 0;
                    foreach ($record['fields']['locations'] as $value) {

                        $schedulelocation = $strtointclass->string_to_int($value);

                        if ($i != 0) {
                            $schedule->schedule_locations = $schedule->schedule_locations . ',' . $schedulelocation;
                        } else {
                            $schedule->schedule_locations = $schedulelocation;
                        }

                        $i++;
                    }
                }

                $schedule->schedule_description = isset($record['fields']['description-x']) ? $record['fields']['description-x'] : null;
                $schedule->schedule_x_phones = isset($record['fields']['phones-x']) ? implode(",", $record['fields']['phones-x']) : null;
                $schedule->schedule_days_of_week = isset($record['fields']['days_of_week']) ? $record['fields']['days_of_week'] : null;
                $schedule->opens_at = isset($record['fields']['opens_at']) ? $record['fields']['opens_at'] : null;
                $schedule->closes_at = isset($record['fields']['closes_at']) ? $record['fields']['closes_at'] : null;
                $schedule->schedule_holiday = isset($record['fields']['holiday']) ? $record['fields']['holiday'] : null;
                $schedule->schedule_start_date = isset($record['fields']['start_date']) ? $record['fields']['start_date'] : null;
                $schedule->schedule_end_date = isset($record['fields']['end_date']) ? $record['fields']['end_date'] : null;
                $schedule->schedule_closed = isset($record['fields']['closed']) ? $record['fields']['closed'] : null;
                $schedule->save();
            }
        } while ($request = $response->next());

        $date = date("Y/m/d H:i:s");
        $airtable = Airtables::where('name', '=', 'Schedule')->first();
        $airtable->records = Schedule::count();
        $airtable->syncdate = $date;
        $airtable->save();
    }
    public function airtable_v2($api_key, $base_url)
    {
        try {
            $airtable_key_info = Airtablekeyinfo::find(1);
            if (!$airtable_key_info) {
                $airtable_key_info = new Airtablekeyinfo;
            }
            $airtable_key_info->api_key = $api_key;
            $airtable_key_info->base_url = $base_url;
            $airtable_key_info->save();

            // Schedule::truncate();
            // $airtable = new Airtable(array(
            //     'api_key'   => env('AIRTABLE_API_KEY'),
            //     'base'      => env('AIRTABLE_BASE_URL'),
            // ));
            $airtable = new Airtable(array(
                'api_key' => $api_key,
                'base' => $base_url,
            ));

            $request = $airtable->getContent('schedule');

            do {

                $response = $request->getResponse();

                $airtable_response = json_decode($response, true);

                foreach ($airtable_response['records'] as $record) {
                    $strtointclass = new Stringtoint();
                    $recordId = $strtointclass->string_to_int($record['id']);
                    $old_schedule = Schedule::where('schedule_recordid', $recordId)->where('name', isset($record['fields']['name']) ? $record['fields']['name'] : null)->first();
                    if ($old_schedule == null) {
                        $schedule = new Schedule();
                        $strtointclass = new Stringtoint();

                        $schedule->schedule_recordid = $strtointclass->string_to_int($record['id']);

                        // $schedule->schedule_id = isset($record['fields']['id']) ? $record['fields']['id'] : null;
                        $schedule->name = isset($record['fields']['name']) ? $record['fields']['name'] : null;

                        // $schedule->services = isset($record['fields']['services']) ? implode(",", $record['fields']['services']) : null;

                        if (isset($record['fields']['services'])) {
                            $i = 0;
                            foreach ($record['fields']['services'] as $value) {

                                $scheduleservice = $strtointclass->string_to_int($value);

                                if ($i != 0) {
                                    $schedule->services = $schedule->services . ',' . $scheduleservice;
                                } else {
                                    $schedule->services = $scheduleservice;
                                }

                                $i++;
                            }
                        }

                        if (isset($record['fields']['locations'])) {
                            $i = 0;
                            foreach ($record['fields']['locations'] as $value) {

                                $schedulelocation = $strtointclass->string_to_int($value);

                                if ($i != 0) {
                                    $schedule->locations = $schedule->locations . ',' . $schedulelocation;
                                } else {
                                    $schedule->locations = $schedulelocation;
                                }

                                $i++;
                            }
                        }

                        $schedule->description = isset($record['fields']['description']) ? $record['fields']['description'] : null;
                        $schedule->phones = isset($record['fields']['x-phones']) ? implode(",", $record['fields']['x-phones']) : null;
                        $schedule->weekday = isset($record['fields']['y-weekday']) ? $record['fields']['y-weekday'] : null;

                        $schedule->byday = isset($record['fields']['byday']) ? (is_array($record['fields']['byday']) ? implode(',', $record['fields']['byday']) : $record['fields']['byday']) : null;
                        $schedule->opens_at = isset($record['fields']['opens_at']) ? $record['fields']['opens_at'] : null;
                        $schedule->opens = isset($record['fields']['y-opens']) ? $record['fields']['y-opens'] : null;
                        $schedule->closes_at = isset($record['fields']['closes_at']) ? $record['fields']['closes_at'] : null;
                        $schedule->closes = isset($record['fields']['y-closes']) ? $record['fields']['y-closes'] : null;
                        $schedule->dtstart = isset($record['fields']['dtstart']) ? $record['fields']['dtstart'] : null;
                        $schedule->until = isset($record['fields']['until']) ? $record['fields']['until'] : null;
                        $schedule->special = isset($record['fields']['x-special']) ? $record['fields']['x-special'] : null;
                        $schedule->closed = isset($record['fields']['x-closed']) ? $record['fields']['x-closed'] : null;
                        $schedule->service_at_location = isset($record['fields']['service_at_location']) ? $record['fields']['service_at_location'] : null;
                        $schedule->freq = isset($record['fields']['freq']) ? $record['fields']['freq'] : null;
                        $schedule->valid_from = isset($record['fields']['valid_from']) ? $record['fields']['valid_from'] : null;
                        $schedule->valid_to = isset($record['fields']['valid_to']) ? $record['fields']['valid_to'] : null;
                        $schedule->wkst = isset($record['fields']['wkst']) ? $record['fields']['wkst'] : null;
                        $schedule->interval = isset($record['fields']['interval']) ? $record['fields']['interval'] : null;
                        $schedule->count = isset($record['fields']['x-count']) ? $record['fields']['x-count'] : null;
                        $schedule->byweekno = isset($record['fields']['byweekno']) ? $record['fields']['byweekno'] : null;
                        $schedule->bymonthday = isset($record['fields']['bymonthday']) ? $record['fields']['bymonthday'] : null;
                        $schedule->byyearday = isset($record['fields']['byyearday']) ? $record['fields']['byyearday'] : null;
                        $schedule->timezone = isset($record['fields']['timezone']) ? $record['fields']['timezone'] : null;
                        $schedule->save();
                    }
                }
            } while ($request = $response->next());

            $date = date("Y/m/d H:i:s");
            $airtable = Airtable_v2::where('name', '=', 'Schedule')->first();
            $airtable->records = Schedule::count();
            $airtable->syncdate = $date;
            $airtable->save();
        } catch (\Throwable $th) {
            Log::error('Error in Schedule: ' . $th->getMessage());
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function csv(Request $request)
    {
        try {
            // $path = $request->file('csv_file')->getRealPath();

            // $data = Excel::load($path)->get();

            // $filename = $request->file('csv_file')->getClientOriginalName();
            // $request->file('csv_file')->move(public_path('/csv/'), $filename);

            // if ($filename != 'regular_schedules.csv') {
            //     $response = array(
            //         'status' => 'error',
            //         'result' => 'This CSV is not correct.',
            //     );
            //     return $response;
            // }

            // if (count($data) > 0) {
            //     $csv_header_fields = [];
            //     foreach ($data[0] as $key => $value) {
            //         $csv_header_fields[] = $key;
            //     }
            //     $csv_data = $data;
            // }

            Schedule::truncate();
            ServiceSchedule::truncate();
            LocationSchedule::truncate();

            Excel::import(new ScheduleImport, $request->file('csv_file'));

            $date = Carbon::now();
            $csv_source = CSV_Source::where('name', '=', 'Regular_schedules')->first();
            $csv_source->records = Schedule::count();
            $csv_source->syncdate = $date;
            $csv_source->save();
            $response = array(
                'status' => 'success',
                'result' => 'Schedule imported successfully',
            );
            return $response;
        } catch (\Throwable $th) {
            $response = array(
                'status' => 'false',
                'result' => $th->getMessage(),
            );
            return $response;
        }
    }

    public function index()
    {
        $schedules = Schedule::orderBy('id')->paginate(20);

        $source_data = Source_data::find(1);

        return view('backEnd.tables.tb_schedule', compact('schedules', 'source_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::find($id);
        return response()->json($schedule);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        $schedule->schedule_days_of_week = $request->schedule_days_of_week;
        $schedule->opens_at = $request->opens_at;
        $schedule->closes_at = $request->closes_at;

        $schedule->schedule_holiday = $request->schedule_holiday;
        $schedule->schedule_closed = $request->schedule_closed;

        $schedule->flag = 'modified';
        $schedule->save();

        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
