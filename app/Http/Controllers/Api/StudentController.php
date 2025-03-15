<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function all(Request $request)
    {
        $student = Student::query();

        $student->with('rombel', 'rayon');

        if ($request->rayon_user_id) {
            $student->whereHas('rayon', function ($query) use ($request) {
                $query->where('user_id', $request->rayon_user_id);
            });
        }

        if ($request->sortBy) {
            if ($request->sortBy == 'created_at') {
                $student->orderBy('created_at', 'DESC');
            }

            if ($request->sortBy == 'name') {
                $student->orderBy('name', 'ASC');
            }
        }

        $student = $student->get();

        if ($student->count() == 0) {
            return $this->response_json(false, null, 'Data is not Available!', null, null);
        }

        return $this->response_json(true, null, 'Success', $student, null);
    }

    public function table(Request $request)
    {
        $student = Student::query();

        $student->with('rombel', 'rayon');


        if ($request->search) {
            $student->where('nis', 'like', "%{$request->search}%")
                ->orWhere('name', 'like', "%{$request->search}%")
                ->orWhereHas('rombel', function ($query) use ($request) {
                    $query->where('rombel', 'like', "%{$request->search}%");
                })
                ->orWhereHas('rayon', function ($query) use ($request) {
                    $query->where('rayon', 'like', "%{$request->search}%");
                });
        }

        if ($request->rayon_user_id) {
            $student->whereHas('rayon', function ($query) use ($request) {
                $query->where('user_id', $request->rayon_user_id);
            });
        }

        $student = $student->orderBy('created_at', 'DESC')->paginate($request->per_page);

        return $this->response_json(true, null, 'Success', $student, null);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'nis' => 'required|numeric|min:10000000|max:9999999999|unique:students,nis',
            'rombel_id' => 'required|numeric|exists:rombels,id',
            'rayon_id' => 'required|numeric|exists:rayons,id',
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }

        $student = Student::create([
            'name' => $request->name,
            'nis' => $request->nis,
            'rombel_id' => $request->rombel_id,
            'rayon_id' => $request->rayon_id,
        ]);

        return $this->response_json(true, null, 'Created Successfully!', $student, null);
    }

    public function show(string $id)
    {
        $student = Student::with('rombel', 'rayon')->find($id);

        if (!$student) {
            return $this->response_json(false, null, 'Data Not Found!', null, null);
        }

        return $this->response_json(true, null, 'Show Data Successfull!', $student, null);
    }

    public function update(Request $request, string $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'nis' => 'required|numeric|min:10000000|max:9999999999|unique:students,nis,' . $id,
            'rombel_id' => 'required|numeric|exists:rombels,id',
            'rayon_id' => 'required|numeric|exists:rayons,id',
        ]);

        if ($validation->fails()) {
            return $this->response_json(false, $validation->errors(), 'Validation failed', null, null);
        }

        $student = Student::find($id);

        if (!$student) {
            return $this->response_json(false, null, 'Data Not Found!', null, null);
        }

        $student->update([
            'name' => $request->name,
            'nis' => $request->nis,
            'rombel_id' => $request->rombel_id,
            'rayon_id' => $request->rayon_id,
        ]);

        return $this->response_json(true, null, 'Updated Successfully!', $student, null);
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return $this->response_json(false, null, 'Data Not Found!', null, null);
        }

        $student->delete();

        return $this->response_json(true, null, 'Deleted Successfully!', $student, null);
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
