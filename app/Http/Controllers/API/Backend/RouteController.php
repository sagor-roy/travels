<?php

namespace App\Http\Controllers\API\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Routee;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class RouteController extends Controller
{
    public function index()
    {
        try {
            $limit = request('limit', 10);
            $search = request('search', "");

            $routes = Routee::with(['froms', 'too'])
                ->when(!empty($search), function ($query) use ($search) {
                    return $query->where('name', 'LIKE', "%$search%");
                })
                ->latest()
                ->paginate($limit);

            // Transform the data to the desired format
            $formattedRoutes = $routes->toArray();
            $formattedRoutes['data'] = collect($formattedRoutes['data'])->map(function ($route) {
                return [
                    'id' => $route['id'],
                    'name' => $route['name'],
                    'from' => $route['froms']['destination'] ?? null,
                    'to' => $route['too']['destination'] ?? null,
                    'distance' => $route['distance'],
                    'duration' => $route['duration'],
                    'map' => $route['map'],
                    'status' => $route['status'],
                ];
            })->all();

            return $this->response('success', $formattedRoutes, 200, 'Data retrieved successfully!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function create()
    {
        try {
            $destination = Destination::latest()->get();
            return $this->response('success', $destination, 200, 'Data Get successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:routees',
                'from' => 'required',
                'to' => 'required',
                'distance' => 'required',
                'duration' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            if ($request->from !== $request->to) {
                $route = Routee::create($request->all());
                return $this->response('success', $route, 200, 'Data created successfully!');
            }
            return $this->response('warning', [], 200, 'Don\'t same the route location!!');
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
                $name = $row[0];
                if (!empty($name)) {
                    $validator = Validator::make(['name' => $name], [
                        'name' => [
                            'required',
                            Rule::unique('routees', 'name'),
                        ]
                    ]);

                    if ($validator->fails()) {
                        return $this->response('error', $validator->errors(), 422);
                    }

                    Routee::create([
                        'name' => $row[0],
                        'from' => $row[1],
                        'to' => $row[2],
                        'distance' => $row[3],
                        'duration' => $row[4],
                        'status' => $row[5],
                        'map' => $row[6],
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
            $route = Routee::find($id);
            if (!$route) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            $route->update(['status' => $request->status]);
            return $this->response('success', $route, 200, 'Status update successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }

    public function edit($id)
    {
        try {
            $route = Routee::find($id);
            if (!$route) {
                return $this->response('fail', [], 404, 'Data not found.');
            }
            return $this->response('success', $route, 200, 'Status update successful!');
        } catch (Exception $error) {
            return $this->response('fail', $error->getMessage(), 500, 'Failed to update status.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:routees,name,' . $id,
                'from' => 'required',
                'to' => 'required',
                'distance' => 'required',
                'duration' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->response('error', $validator->errors(), 422);
            }

            if ($request->from != $request->to) {
                $route = Routee::find($id);
                if (!$route) {
                    return $this->response('fail', [], 404, 'Data not found.');
                }
                $route->update($request->all());
                return $this->response('success', $route, 200, 'Data update successful!');
            }
            return $this->response('warning', [], 200, 'Don\'t same the route location!!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Something went wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            $data = explode(',', $id);
            Routee::whereIn('id', $data)->delete();
            return $this->response('success', [], 200, 'Data delete successful!');
        } catch (Exception $error) {
            return $this->response('fail', [], 500, 'Failed to delete data.');
        }
    }
}
