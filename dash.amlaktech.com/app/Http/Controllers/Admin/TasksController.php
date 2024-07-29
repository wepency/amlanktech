<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::query();

        if (!is_admin()) {
            $tasks->where('association_id', getAssociationId());
        }

        return view('Admin.Tasks.index', [
            'page_title' => 'المهام',
            'singleModel' => 'task',
            'pluralModel' => 'tasks',
            'finished_count' => (clone $tasks)->where('finished', 1)->count(),
            'unfinished_count' => (clone $tasks)->where('finished', '!=', 1)->count(),
            'tasks' => $tasks->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Task $task)
    {
        $associationMembers = Admin::managers()->with('association');

        if (!is_admin()) {
            $associationMembers = $associationMembers->where('association_id', getAssociationId());
        }

        return response()->json([
            'data' => view('Admin.Tasks.create', [
                'page_title' => 'اضافة مهمة',
                'task' => $task,
                'url' => dashboard_route('tasks.store'),
                'associationMembers' => $associationMembers->get()
            ])->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        return $this->redirectBack(self::updateOrCreate($request, $task));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $associationMembers = Admin::managers()->with('association');

        if (!is_admin()) {
            $associationMembers = $associationMembers->where('association_id', getAssociationId());
        }

        return response()->json([
            'data' => view('Admin.Tasks.create', [
                'page_title' => 'تعديل المهمة',
                'task' => $task,
                'url' => dashboard_route('tasks.update', $task->id),
                'associationMembers' => $associationMembers->get()
            ])->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        return $this->redirectBack(self::updateOrCreate($request, $task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function makeAsFinished(Request $request, Task $task)
    {
        return $this->redirectBack($task->update(['finished' => 1]));
    }

    private static function updateOrCreate(Request $request, Task $task)
    {
        return $task->updateOrCreate([
            'association_id' => $task->association_id,
        ], [
            'title' => $request->title,
            'description' => $request->description,
            'association_id' => $request->association_id ?? getAssociationId(),
            'assigned_to' => $request->assigned_to,
            'start_date' => self::convertToDateFormat($request->start_date),
            'end_date' => self::convertToDateFormat($request->end_date),
            'target_date' => self::convertToDateFormat($request->target_date),
            'finished' => $request->finished == 'on'
        ]);
    }

    private static function convertToDateFormat($date = null)
    {
        if (!$date)
            return null;

        return Carbon::parse($date)->format('Y-m-d');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        return $this->redirectBack($task->delete());
    }
}
