<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RombelController extends Controller
{
    public function all()
    {
        $rombel = Rombel::all();

        if ($rombel->count() == 0) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }  

        return $this->response_json(true, null, 'Success', $rombel, null);
    }

    public function table(Request $request)
    {
        $rombel = Rombel::query();
        
        if ($request->search) {
            $rombel->where('rombel', 'like', "%{$request->search}%");
        }

        $rombel = $rombel->orderBy('created_at', 'DESC')->paginate($request->per_page);

        return $this->response_json(true, null, 'Success', $rombel, null);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'rombel' => 'required|max:12|unique:rombels,rombel',
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }

        $rombel = Rombel::create([
            'rombel' => $request->rombel,
        ]);

        return $this->response_json(true, null, 'Created Successfully!', $rombel, null);
    }

    public function show(string $id)
    {
        $rombel = Rombel::find($id);

        if (!$rombel) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        return $this->response_json(true, null, 'Success', $rombel, null);
    }

    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'rombel' => 'required|max:12|unique:rombels,rombel,' . $id,
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }

        $rombel = Rombel::find($id);

        if (!$rombel) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        $rombel->update([
            'rombel' => $request->rombel,
        ]);

        return $this->response_json(true, null, 'Updated Successfully!', $rombel, null);
    }

    public function destroy(string $id)
    {
        $rombel = Rombel::find($id);

        if (!$rombel) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        $rombel->delete();

        return $this->response_json(true, null, 'Deleted Successfully!', null, null);
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
