<?php

namespace App\Http\Controllers;

use App\ToDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    /**
     * Returns all ToDo items ordered by index
     * @return Array App\ToDo
     */
    public function index()
    {
        return ToDo::orderBy('index')->get();
    }

    /**
     * Creates a new ToDo item
     * @return Array App\ToDo
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string|max:255'
        ]);

        ToDo::create([
            'text' => $data['text'],
            'index' => ToDo::count()
        ]);

        return ToDo::orderBy('index')->get();
    }

    /**
     * Deletes a ToDo item by id
     * @return Array App\ToDo
     */
    public function delete(Request $request, $id)
    {
        $todo = ToDo::find($id);
        ToDo::where('index', '>', $todo->index)->decrement('index');
        $todo->delete();
        return ToDo::orderBy('index')->get();
    }

    /**
     * Updates a ToDo item by id
     * @param  Illuminate\Http\Request  $request
     * @param  $id
     * @return Array App\ToDo
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'text' => 'string|max:255',
            'index' => 'integer|min:0|max:' . ToDo::max('index'),
            'done' => 'boolean'
        ]);

        $todo = ToDo::findOrFail($id);

        if (isset($data['text'])) $todo->text = $data['text'];

        if (isset($data['done'])) $todo->done = $data['done'];

        if (isset($data['index'])) {

            if ($data['index'] < $todo->index)
                ToDo::whereBetween('index', [$data['index'], $todo->index])->increment('index');

            else if ($data['index'] > $todo->index)
                ToDo::whereBetween('index', [$todo->index, $data['index']])->decrement('index');

            $todo->index = $data['index'];
        }

        $todo->save();

        return ToDo::orderBy('index')->get();
    }
}
