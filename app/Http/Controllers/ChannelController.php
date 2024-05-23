<?php

namespace App\Http\Controllers;

use App\Models\Channels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class ChannelController extends Controller
{
    public function getListOfChannels(Request $request)
    {
        $channels = Channels::all();
        return view('channels.channels', compact('channels'));
    }

    public function handleForm(Request $request)
    {
        $rules = [
            'id' => 'required',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $channel = Channels::where('id', $request->id)->first();

        if(!empty($channel)){
            return redirect()->back()
                ->withErrors("Такой канал с ID $channel->id уже существует")
                ->withInput();
        }

        $channel = new Channels();
        $channel->id = $request->id;
        $channel->title = $request->title;
        $channel->description = $request->description;
        if($channel->save()){
            return back()->with('success', 'Успешно создано');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
    }

    public function edit($id)
    {
        $channel = Channels::findOrFail($id);
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, $id)
    {
        $channel = Channels::where('id', $id)->first();
        $channel->id = $request->id;
        $channel->title = $request->title;
        $channel->description = $request->description;
        if($channel->save()){
            return redirect('channel');
        } else {
            return redirect()->back()
                ->withErrors('errors', 'Ошибка при изменении')
                ->withInput();
        };
    }

    public function delete($id)
    {
        $channel = Channels::findOrFail($id);
        if ($channel->delete()) {
            return back()->with('success', 'Данные успешно удалены');
        } else {
            return redirect()->back()
                ->withErrors('errors', 'Ошибка при удалении')
                ->withInput();
        }
    }
}
