<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use App\Models\Genre;
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
            'description' => 'required|max:500',
            'picture' => 'required|max:255',
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
        $match->picture = $request->picture;
        $match->channel = $request->channel_id;
        $match->genre = $request->genre;
        $match->hash_id = Uuid::uuid4()->toString();
        $match->date_start = $request->date_start;
        $match->date_end = $request->date_end;
        if($match->save()){
            return redirect()->route('list')->with('success', 'Успешно, создано событие');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
    }

    public function create() {
        $channels = Channels::all();
        $genres = Genre::all();
        return view('lists.form', compact('channels', 'genres'));
    }

    public function edit($id)
    {
        $match = Matches::findOrFail($id);
        $channels = Channels::all();
        $genres = Genre::all();
        return view('lists.edit', compact('match', 'channels', 'genres' ));
    }

    public function update(Request $request, $id)
    {
        $match = Matches::findOrFail($id);
        $match->title = $request->title;
        $match->description = $request->description;
        $match->picture = $request->picture;
        if(!empty($request->channel_id)){
            $match->channel = $request->channel_id;
        }
        $match->genre = $request->genre;
        $match->date_start = $request->date_start;
        $match->date_end = $request->date_end;
        if($match->save()){
            return redirect()->route('list')->with('success', 'Успешно, изменено событие');
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
