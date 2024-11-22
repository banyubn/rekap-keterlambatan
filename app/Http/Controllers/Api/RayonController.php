<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rayon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RayonController extends Controller
{
    public function all(Request $request)
    {
        $rayon = Rayon::query();

        if ($request->rayon)
        {
            $rayon->where('rayon', $request->rayon);
        }

        if ($request->user_id)
        {
            $rayon->where('user_id', $request->user_id);
        }

        $rayon = $rayon->get();

        if ($rayon->count() == 0) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        return $this->response_json(true, null, 'Success', $rayon, null);
    }

    public function table(Request $request)
    {
        $rayon = Rayon::query();
        
        if ($request->search) {
            $rayon->where('rayon', 'like', "%{$request->search}%");
        }

        $rayon = $rayon->with('user')->orderBy('created_at', 'DESC')->paginate($request->per_page);

        return $this->response_json(true, null, 'Success', $rayon, null);
    }

   public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'rayon' => 'required|max:12|unique:rayons,rayon',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }

        $rayon = Rayon::create([
            'rayon' => $request->rayon,
            'user_id' => $request->user_id
        ]);

        return $this->response_json(true, null, 'Created Successfully!', $rayon, null);
    }

    public function show(string $id)
    {
        $rayon = Rayon::find($id);

        if (!$rayon) {
            return $this->response_json(false, null, 'Data Not Found!', null, null);
        }

        return $this->response_json(true, null, 'Show Data Successfull!', $rayon, null);
    }

   
    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'rayon' => 'required|max:12|unique:rayons,rayon,'.$id,
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }

        $rayon = Rayon::find($id);

        if (!$rayon) {
            return $this->response_json(false, null, 'Data Not Found!', null, null);
        }

        $rayon->update([
            'rayon' => $request->rayon,
            'user_id' => $request->user_id
        ]);

        return $this->response_json(true, null, 'Updated Successfully!', $rayon, null);
    }

    public function destroy(string $id)
    {
        $rayon = Rayon::find($id);

        if (!$rayon) {
            return $this->response_json(false, null, 'Data Not Found!', null, null);
        }

        $rayon->delete();

        return $this->response_json(true, null, 'Deleted Successfully!', $rayon, null);
    }

    public function response_json($success = false, $error = null, $message = '', $data = null, $filter = null)
    {
        $response = [
            'success' => $success,
            'error' => $error,
            'message' => $message,
            'data' => $data
        ];

        if ($filter) {
            $response['filter'] = $filter;
        }

        return response()->json($response);
    }
}
