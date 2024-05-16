<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Validator;

class FormController extends Controller
{
    public function handleForm(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'channel_id' => 'required|max:255',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $match = new Matches();
        $match->title = $request->title;
        $match->description = $request->description;
        $match->channel = $request->channel_id;
        $match->hash_id = Uuid::uuid4()->toString();
        $match->date_start = $request->date_start;
        $match->date_end = $request->date_end;
        if($match->save()){
            return back()->with('success', 'Успешно создано');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
    }

    public function edit($id)
    {
        $match = Matches::findOrFail($id);
        return view('lists.edit', compact('match'));
    }

    public function update(Request $request, $id)
    {
        $match = Matches::findOrFail($id);
        $match->title = $request->title;
        $match->description = $request->description;
        $match->channel = $request->channel_id;
        $match->date_start = $request->date_start;
        $match->date_end = $request->date_end;
        if($match->save()){
            return back()->with('success', 'Данные успешно изменены');
        } else {
            return redirect()->back()
                ->withErrors('errors', 'Ошибка при изменении')
                ->withInput();
        };
    }

    public function delete($id)
    {
        $match = Matches::findOrFail($id);
        if ($match->delete()) {
            return back()->with('success', 'Данные успешно удалены');
        } else {
            return redirect()->back()
                ->withErrors('errors', 'Ошибка при удалении')
                ->withInput();
        }
    }
}
