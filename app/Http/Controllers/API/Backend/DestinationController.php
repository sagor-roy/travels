<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DestinationController extends Controller
{
    public function index()
    {
        try {
            $limit = request('limit', 10);
            $search = request('search', "");
            $destination = Destination::when(!empty($search), function ($query) use ($search) {
                return $query->where('destination', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%");
            })->latest()->paginate($limit);
            return $this->response('success', $destination, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|unique:destinations',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response('error', $validator->errors(), 422);
        }

        try {
            $destination = Destination::create($request->all());
            return $this->response('success', $destination, 200, 'Data created successfully!');
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
                $destinationValue = $row[0];
                if (!empty($destinationValue)) {
                    $validator = Validator::make(['destination' => $destinationValue], [
                        'destination' => [
                            'required',
                            Rule::unique('destinations', 'destination'),
                        ]
                    ]);

                    if ($validator->fails()) {
                        return $this->response('error', $validator->errors(), 422);
                    }

                    Destination::create([
                        'destination' => $destinationValue,
                        'description' => $row[1],
                        'status' => $row[2],
                    ]);
                }
            }

            return $this->response('success', [], 200, 'Data created successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }



    public function status(Request $request, $id)
    {
        try {
            $destination = Destination::find($id);
            if (!$destination) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $destination->update(['status' => $request->status]);
            return $this->response('success', $destination, 200, 'Status update successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }

    public function edit($id)
    {
        try {
            $data = Destination::find($id);
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
        $validator = Validator::make($request->all(), [
            'destination' => 'required|unique:destinations,destination,' . $id,
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response('error', $validator->errors(), 422);
        }

        try {
            $destination = Destination::find($id);
            if (!$destination) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $destination->update($request->all());
            return $this->response('success', $destination, 200, 'Data update successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to update data.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = explode(',', $id);
            Destination::whereIn('id', $data)->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }
}
