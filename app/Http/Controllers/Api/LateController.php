<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Late;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LateController extends Controller
{
    public function all(Request $request)
    {
        $late = Late::query();

        $late->with('student');

        if ($request->student_rayon_user_id)
        {
            $late->whereHas('student', function ($query) use ($request) {
                $query->whereHas('rayon', function ($query) use ($request) {
                    $query->where('user_id', $request->student_rayon_user_id);
                });
            });
        }

        $late = $late->get();
        
        if ($late->count() == 0) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        return $this->response_json(true, null, 'All Success', $late, null);
    }

    public function table(Request $request)
    {
        $late = Late::query();

        $late->with('student');
        
        if ($request->search) {
            $late->where('date_time_late', 'like', "%{$request->search}%")
            ->orWhere('information', 'like', "%{$request->search}%")
            ->orWhereHas('student', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%");
            });
        }

        if ($request->student_rayon_user_id)
        {
            $late->whereHas('student', function ($query) use ($request) {
                $query->whereHas('rayon', function ($query) use ($request) {
                    $query->where('user_id', $request->student_rayon_user_id);
                });
            });
        }

        $late = $late->orderBy('created_at', 'DESC')->paginate($request->per_page);

        return $this->response_json(true, null, 'Success', $late, null);
    }

    public function show($id)
    {
        $late = Late::find($id);
        if (!$late) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }
        return $this->response_json(true, null, 'Show Success', $late, null);
    }

    public function detail($id)
    {
        $late = Late::where('student_id', $id)->get();
        if (!$late) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }
        return $this->response_json(true, null, 'Detail Success', $late, null);
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date_time_late' => 'required|date',
            'information' => 'required|max:255',
        ]);

        // if ($validation->fails()) {
        //     return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        // }

        if ($request->hasFile('bukti')) {
            $validation['bukti'] = $request->file('bukti')->store('storage/images/bukti', 'public');
        }
        
        $late = Late::create([
            'student_id' => $request->student_id,
            'date_time_late' => $request->date_time_late,
            'information' => $request->information,
            'bukti' => $validation['bukti'] ?? null,
        ]);

        return $this->response_json(true, null, 'Success', $late, null);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'date_time_late' => 'required|date',
            'information' => 'required|max:255',
            'bukti' => 'max:2048',
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }
        
        $late = Late::find($id);

        if (!$late) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        // if ($request->hasFile('bukti')) {
        //     $filename = $request->bukti->getClientOriginalName();
        //     $request->bukti->storeAs('public/bukti', $filename);
        // }

        $late->update([
            'student_id' => $request->student_id,
            'date_time_late' => $request->date_time_late,
            'information' => $request->information,
        ]);

        return $this->response_json(true, null, 'Success', $late, null);
    }
    
    public function destroy($id)
    {
        $late = Late::find($id);
        if (!$late) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }
        $late->delete();
        return $this->response_json(true, null, 'Success', null, null);
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
