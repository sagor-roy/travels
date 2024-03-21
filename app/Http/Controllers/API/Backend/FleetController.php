<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class FleetController extends Controller
{
    public function index()
    {
        try {
            $limit = request('limit', 10);
            $search = request('search', "");
            $fleet = Fleet::when(!empty($search), function ($query) use ($search) {
                return $query->where('type', 'LIKE', "%$search%")
                    ->orWhere('layout', 'LIKE', "%$search%")
                    ->orWhere('seat', 'LIKE', "%$search%")
                    ->orWhere('total', 'LIKE', "%$search%");
            })->latest()->paginate($limit);
            return $this->response('success', $fleet, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|unique:fleets',
                'layout' => 'required',
                'seat' => 'required',
                'total' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            $fleet = Fleet::create($request->all());
            return $this->response('success', $fleet, 200, 'Data created successfully!');
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
                Fleet::create(
                    [
                        'type' => $row[0],
                        'layout' => $row[1],
                        'seat' => $row[2],
                        'total' => $row[3],
                        'status' => $row[4],
                    ]
                );
            }

            return $this->response('success', [], 200, 'Data created successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $fleet = Fleet::find($id);
            if (!$fleet) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $fleet->update(['status' => $request->status]);
            return $this->response('success', $fleet, 200, 'Status update successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }

    public function edit($id)
    {
        try {
            $data = Fleet::find($id);
            if (!$data) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            return $this->response('success', $data, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to retrieve data.');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|unique:fleets,type,' . $id,
                'layout' => 'required',
                'seat' => 'required',
                'total' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            $fleet = Fleet::find($id);
            if (!$fleet) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $fleet->update($request->all());
            return $this->response('success', $fleet, 200, 'Data update successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to update data.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = explode(',', $id);
            Fleet::whereIn('id', $data)->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }
}
