<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index(Request $request)
    {
        $series = Series::all();
        $mensagem = $request->session()->get('mensagem.sucesso');

        return view('series.index', compact(['series', 'mensagem']));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $coverPath = "series-cover/imagemPd.png";
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')
                ->store('series-cover', 'public');
        }

        \App\Events\RetrievesAllRequest::dispatch(
            [
                'nome' => $request->nome,
                'cover' => $coverPath,
                'seasonQty' => $request->seasonQty,
                'episodePerSeason' => $request->episodePerSeason
            ]
        );

        \App\Events\SeriesCreated::dispatch(
            $request->nome,
            $request->seasonQty,
            $request->episodePerSeason,
            (int)Series::max('id')
        );

        $request->session()->flash('mensagem.sucesso', "Série '{$request->nome}' criada com sucesso!");

        return redirect()->route('series.index');
    }

    public function destroy(Series $series)
    {
        $series->delete();
        \App\Events\FlameCover::dispatch($series->cover);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso!");
    }

    public function edit(Series $series)
    {
        return view('series.edit')
            ->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso!");
    }
}