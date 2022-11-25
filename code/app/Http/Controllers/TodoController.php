<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Services\TodoService;

class TodoController extends Controller
{
    /**
     * @var TodoService
     */
    private $todoService;

    /**
     * @param TodoService $todoService
     */
    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $todos = Auth::user()->todos;

        return response()->json([
            "status" => "success", 
            "count"  => count($todos), 
            "data"   => $todos
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreTodoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTodoRequest $request): JsonResponse
    {
        try {
            $todo = $this->todoService->store($request);

            return response()->json([
                "status"  => "success", 
                "message" => "Task created.",
                "data" => $todo
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                "status" => "failed", 
                "error"  => $exception->getMessage()
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $todo = Auth::user()->todos->find($id);

        if($todo) {
            return response()->json([
                "status" => "success", 
                "data"   => $todo
            ], 200);
        }

        return response()->json([
            "status"  => "failed", 
            "message" => "Task not found."
        ], 404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $todo = Auth::user()->todos->find($id);

        if($todo) {
            $todoUpdate = $this->todoService->update($request, $id);

            return response()->json([
                "status"  => "success",
                "message" => "Task updated.",
                "data" => $todoUpdate
            ], 201);
        }

        return response()->json([
            "status"  => "failed", 
            "message" => "Task not found."
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $todo = Auth::user()->todos->find($id);

        if($todo) {
            $todo->delete();

            return response()->json([
                "status"  => "success",
                "message" => "Task deleted."
            ], 200);
        }

        return response()->json([
            "status"  => "failed", 
            "message" => "Task not found."
        ], 404);
    }
}