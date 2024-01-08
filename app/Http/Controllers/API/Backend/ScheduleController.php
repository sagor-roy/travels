<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    public function index()
    {
        try {
            $limit = request('limit', 10);
            $search = request('search', "");
            $schedules = Schedule::when(!empty($search), function ($query) use ($search) {
                return $query->where('start', 'LIKE', "%$search%")
                    ->orWhere('end', 'LIKE', "%$search%");
            })->latest()->paginate($limit);
            return $this->response('success', $schedules, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start' => 'required',
                'end' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            $schedules = Schedule::create($request->all());
            return $this->response('success', $schedules, 200, 'Data created successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function excel_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx',
        ]);

        if ($validator->fails()) {
            return $this->response('error', $validator->errors(), 422);
        }

        try {
            $file = $request->file('file');
            $data = Excel::toArray([], $file);
            foreach (array_slice($data[0], 1) as $row) {
                Schedule::create([
                    'start' => $row[0],
                    'end' => $row[1],
                ]);
            }

            return $this->response('success', [], 200, 'Data created successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function edit($id)
    {
        try {
            $schedule = Schedule::find($id);
            if (!$schedule) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            return $this->response('success', $schedule, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to retrieve data.');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start' => 'required',
                'end' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            $schedule = Schedule::find($id);
            if (!$schedule) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $schedule->update($request->all());
            return $this->response('success', $schedule, 200, 'Data update successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to update data.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = explode(',', $id);
            Schedule::whereIn('id', $data)->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }
}
