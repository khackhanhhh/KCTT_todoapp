<?php

namespace App\Http\Controllers\Api\v1;

use App\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkController extends Controller
{
    public function index()
    {
        $works = auth()->user()->works;

        return response()->json([
            'stutus' => 'success',
            'works' => $works
        ], 200);
    }

    public function store(Request $request)
    {
        $work = Work::create([
            'user_id' => auth()->user()->id,
            'message' => $request->message,
            'status' => '0'
        ]);

        return response()->json([
            'work' => $work,
            'status' => 'success'
        ], 200);
    }

    public function changeStatus(Work $work)
    {
        if($work->status == '0')
        {
            $work->status = '1';
            $status = "UnDone";
        }
        else{
            $work->status = '0';
            $status = "Done";
        }
        $work->save();

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function destroy(Work $work)
    {
        $work->delete();

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
