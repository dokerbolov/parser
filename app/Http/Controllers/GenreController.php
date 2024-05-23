<?php


namespace App\Http\Controllers;


use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Validator;

class GenreController extends Controller
{
    public function getListOfGenres(Request $request)
    {
        $genres = Genre::all();
        return view('genres.genres', compact('genres'));
    }

    public function handleForm(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $genre = new Genre();
        $genre->title = $request->title;
        if($genre->save()){
            return back()->with('success', 'Успешно создано');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        };
    }

    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('genres.edit', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::where('id', $id)->first();
        $genre->title = $request->title;
        if($genre->save()){
            return redirect('genre');
        } else {
            return redirect()->back()
                ->withErrors('errors', 'Ошибка при изменении')
                ->withInput();
        };
    }

    public function delete($id)
    {
        $genre = Genre::findOrFail($id);
        if ($genre->delete()) {
            return back()->with('success', 'Данные успешно удалены');
        } else {
            return redirect()->back()
                ->withErrors('errors', 'Ошибка при удалении')
                ->withInput();
        }
    }
}