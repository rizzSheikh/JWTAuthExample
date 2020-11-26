<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserActionController extends Controller
{
    public function deleteDuplicates(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => new \stdClass(),
                'message' => $request->has('name')
            ]);
        }

        $name = $request->get('name');

        $firstRecord = DB::table('users')->where('name', $name)->first();

        $delete_duplicate_rows = DB::table('users')->where('name', $name)->where('id', '!=', $firstRecord->id)->delete();

        if ($delete_duplicate_rows) {

            return response()->json([
                'status' => true,
                'data' => new \stdClass(),
                'message' => 'Duplicate records deleted',
            ], 200);

        } else {

            return response()->json([
                'status' => true,
                'data' => new \stdClass(),
                'message' => 'No duplicates for ' . $name
            ], 200);

        }


        /*
         *
         * another method
         *
         */

//        $duplicate_data = DB::table('users')->where('name', $name);

//        if ($duplicate_data->count() > 1) {
//
//            $same_data_before = clone $duplicate_data;
//            $top = $duplicate_data->first();
//            $same_data_before->where('id', '!=', $top->id)->delete();
//
//            return response()->json([
//                'status' => true,
//                'data' => new \stdClass(),
//                'message' => $duplicate_data->count() . ' duplicate record deleted',
//            ],200);
//
//        } else {
//            return response()->json([
//            'status' => true,
//            'data' => new \stdClass(),
//            'message' => 'No duplicates for ' . $name
//        ], 200);
//
//        }


    }

    public function secondHighSalary(){
        return  response()->json([
            'message'=> 'done'
        ]);
    }
}
