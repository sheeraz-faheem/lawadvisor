<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoService
{
    /**
	 * @var Todo
	 */
	private $todo;

    /**
	 * @param Todo $todo
	 */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  object $data
     * @return object
     */
    public function store(object $data): object
    {
        $end = Auth::user()->todos->max('sort');

        $todo = $this->todo->create([
            "title"       => $data->title,
            "description" => $data->description,
            "user_id"     => Auth::user()->id,
            "sort"        => $end ? $end + 1 : 1
        ]);

        return $todo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  object $data
     * @param  int  $id
     * @return array
     */
    public function update(object $data, int $id): object
    {
        $todo = Auth::user()->todos->find($id);

        if ($data->sort) {
            $usertoDos = Auth::user()->todos;
            
            if ($data->sort > $todo->sort ) {
                $records = $usertoDos->whereBetween('sort', [$todo->sort+1, $data->sort]);

                $records->each(function($t) {
                    $t->decrement('sort');
                });

            } else {
                $records = $usertoDos->whereBetween('sort', [$data->sort, $todo->sort-1]);

                $records->each(function($t) {
                    $t->increment('sort');
                });
            }

            $todo['sort'] = $data->sort;
        }

        $todo->update($data->input());

        return $todo;
    }
}