<?php

namespace App\Http\Controllers;

use App\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WorkController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $works = auth()->user()->works;

            return view('client.home',\compact('works'));
        }
        return view('client.welcome');
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
            'status' => 'Done'
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
            'status' => $status
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
