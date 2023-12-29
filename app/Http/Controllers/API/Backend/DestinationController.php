<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
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

    public function status(Request $request, $id)
    {
        try {
            $destination = Destination::find($id);

            if (!$destination) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $destination->update(['status' => $request->input('status')]);
            return $this->response('success', [], 200, 'Status update successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to update status.');
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
            return $this->response('fail', [], 422, $validator->errors());
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

    public function destroy($id)
    {
        try {
            $destination = Destination::find($id);
            if (!$destination) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $destination->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }

    public function multi_destroy(Request $request)
    {
        try {
            $data = $request->json('selectedRows');
            Destination::whereIn('id', $data)->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }
}
