<?php

namespace App\Http\Controllers;

use App\Imports\LecturerImport;
use App\Models\Lecturer;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturers = Lecturer::orderBy('name', 'ASC')->get();
        $data = [];
        foreach ($lecturers as $index => $lecturer) {
            $fields = [];
            foreach ($lecturer->fields as $index1 => $field) {
                $fields[$index1] = [
                    'name' => $field->name,
                    'status' => $field->pivot->status
                ];
            }
            $status_fields = array_column($fields, 'status');
            array_multisort($status_fields, SORT_DESC, $fields);

            $data[$index] = [
                'id' => $lecturer->id,
                'name' => $lecturer->name,
                'nip' => $lecturer->nip,
                'major' => $lecturer->major,
                'fields' => $fields
            ];
        }

        $response = [
            'code'=> '200',
            'status'=> 'OK',
            'data'=> $data
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function import(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'file' => 'required',
       ]);

       $file = $request->file('file');

       if($validator->fails()) {
           return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
       }

       try {
           Excel::import(new LecturerImport, $file);

           $response = [
               'code'=> '200',
               'status'=> 'OK'
           ];

           return response()->json($response, Response::HTTP_CREATED);
       } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
           $failures = $e->failures();
           return response()->json($failures, Response::HTTP_UNPROCESSABLE_ENTITY);
       }
   }

   /**
    * Display the specified resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function get_lecturers_by_field(Request $request)
   {
       $data = [];
       if ($request->id) {
           $field = Field::find($request->id);
           foreach ($field->lecturers->where('status', 'Aktif') as $index => $lecturer) {
               $data[$index] = [
                   'id' => $lecturer->id,
                   'name' => $lecturer->name,

               ];
           }
           $name_data = array_column($data, 'name');
           array_multisort($name_data, SORT_ASC, $data);
       }

       $response = [
           'code'=> '200',
           'status'=> 'OK',
           'data'=> $data
       ];

       return response()->json($response, Response::HTTP_OK);
   }
}
