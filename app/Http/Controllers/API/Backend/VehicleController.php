<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Vehicles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class VehicleController extends Controller
{
    public function index()
    {
        try {
            $limit = request('limit', 10);
            $search = request('search', "");
            $vehicles = Vehicles::with('types')
                ->when(!empty($search), function ($query) use ($search) {
                    return $query->where('regis', 'LIKE', "%$search%")
                        ->orWhere('engine_no', 'LIKE', "%$search%")
                        ->orWhere('model_no', 'LIKE', "%$search%")
                        ->orWhere('chasis_no', 'LIKE', "%$search%")
                        ->orWhere('owner_phone', 'LIKE', "%$search%")
                        ->orWhere('brand', 'LIKE', "%$search%");
                })->latest()->paginate($limit);

            // Transform the data to the desired format
            $formattedVehicles = $vehicles->toArray();
            $formattedVehicles['data'] = collect($formattedVehicles['data'])->map(function ($vehicle) {
                $vehicle['type'] = $vehicle['types']['type'];
                unset($vehicle['types'], $vehicle['type_id']);
                return $vehicle;
            })->all();

            return $this->response('success', $formattedVehicles, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function create()
    {
        try {
            $fleet = Fleet::select(['id','type'])->where('status', 1)->latest()->get();
            return $this->response('success', $fleet, 200, 'Data Get successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'regis' => 'required|unique:vehicles',
                'type' => 'required',
                'engine_no' => 'required|unique:vehicles',
                'model_no' => 'required|unique:vehicles',
                'chasis_no' => 'required|unique:vehicles',
                'owner' => 'required',
                'owner_phone' => 'required',
                'brand' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            $fleet = Vehicles::create($request->all());
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
                Vehicles::create([
                    'regis' => $row[0],
                    'type' => $row[1],
                    'engine_no' => $row[2],
                    'model_no' => $row[3],
                    'chasis_no' => $row[4],
                    'owner' => $row[5],
                    'owner_phone' => $row[6],
                    'brand' => $row[7],
                    'status' => $row[8],
                ]);
            }

            return $this->response('success', [], 200, 'Data created successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $vehicle = Vehicles::find($id);
            if (!$vehicle) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $vehicle->update(['status' => $request->status]);
            return $this->response('success', $vehicle, 200, 'Status update successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }

    public function edit($id)
    {
        try {
            $vehicle = Vehicles::find($id);
            $fleets = Fleet::where('status', 1)->get();
            if (!$vehicle) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            return $this->response('success', ['vehicle' => $vehicle, 'fleets' => $fleets], 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to retrieve data.');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'regis' => 'required|unique:vehicles,regis,' . $id,
                'type' => 'required',
                'engine_no' => 'required|unique:vehicles,engine_no,' . $id,
                'model_no' => 'required|unique:vehicles,model_no,' . $id,
                'chasis_no' => 'required|unique:vehicles,chasis_no,' . $id,
                'owner' => 'required',
                'owner_phone' => 'required',
                'brand' => 'required',
                'status' => 'required',
            ], [
                'regis.required' => 'The registration field is require'
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            $vehicle = Vehicles::find($id);
            if (!$vehicle) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $vehicle->update($request->all());
            return $this->response('success', $vehicle, 200, 'Data update successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to update data.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = explode(',', $id);
            Vehicles::whereIn('id', $data)->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }
}
