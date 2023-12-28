<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SubmittedTaskProof;
use App\Models\TextProof;
use App\Models\ImageProof;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReviewTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($taskId)
    {
        // $task = Task::findOrFail($taskId);
        // $submittedProofs = SubmittedTaskProof::where('task_id' , $taskId)->get();

        return view('advertiser.review_tasks', ['taskId' => $taskId]);
    }


    public function approve(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
