<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collaborators;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Symfony\Component\Console\Input\Input;
use Validator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $listTasks = Tasks::all();
        $input = $request->all();

        $validator = Validator::make($input, [
            'sorted_by' => ''
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if (!empty($input)) {

            // filters
            $tasks = Tasks::where('deleted_at', null)
                ->where('collaborator_id', $input['collaborator'])
                ->where('state', $input['state'])
                ->where('priority', $input['priority'])
                ->orderBy('startDate', 'asc')
                ->limit(1000)
                ->get();
            $collection = collect();
            $tasks->load(['collaborator'])->each(function ($item, $key) use ($collection, $input) {

                // m/d/y
                // $startDateSource = Carbon::createFromFormat('Y/m/d', $item['startDate'] )->format('Y-m-d');
                $startDateSource = Carbon::parse($item['startDate']);
                $endDateSource = Carbon::parse($item['endDate']);
                $startDateTarget = Carbon::parse($input['startDate']);
                $endDateTarget = Carbon::parse($input['endDate']);

                if ($startDateTarget->gte($startDateSource)) {
                    if ($startDateSource->lte($endDateTarget)) {
                        $collection->push($item);
                    }
                }
            });

            return response()->json(['data' => $collection->all()], 200);
        } else {
            return response()->json(['data' => $listTasks->load(['collaborator'])], 200);
        }
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'description' => 'required|string',
            'collaborator_id' => 'integer',
            'state' => 'required|in:PENDIENTE,PROCESO,FINALIZADA',
            'priority' => 'required|in:ALTA,MEDIA,BAJA',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Tasks::create($input);

        return response()->json(['data' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Tasks::findOrFail(intval($id))->load('collaborator');

        return response()->json(['data' => $task], 200);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'description' => 'required|string',
            'collaborator_id' => 'required|integer|exists:collaborators,id',
            'state' => 'required|in:PENDIENTE,PROCESO,FINALIZADA',
            'priority' => 'required|in:ALTA,MEDIA,BAJA',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Tasks::updateOrCreate([
            'id' => intVal($id)
        ], [
            'description' => $input['description'],
            'collaborator_id' => $input['collaborator_id'],
            'state' => $input['state'],
            'priority' => $input['priority'],
            'startDate' => $input['startDate'],
            'endDate' => $input['endDate'],
            'notes' => !isset($input['notes']) ? null : $input['notes']
        ]);

        return response()->json(['data' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Tasks::findOrFail($id)
            ->delete();

        $foundTask = Tasks::withTrashed()->findOrFail($id);
        return response()->json(['data' => $foundTask], 200);
    }
}
