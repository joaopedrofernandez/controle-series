<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\RetrievesAllRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiVerify;
use App\Models\Series;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $query = Series::query();

        if ($request->has('nome')):
            $query->whereNome(ucfirst($request->nome));
        endif;

        return $query->paginate(2);
    }

    public function store(ApiVerify $request)
    {
        $coverPath = "series-cover/imagemPd.png";

        RetrievesAllRequest::dispatch(
            [
                'nome' => $request->name,
                'cover' => $coverPath,
                'seasonQty' => $request->seasonQty,
                'episodePerSeason' => $request->episodePerSeason
            ]
        );

        return response()
            ->json(Series::all(), 201);
    }

    public function upload(ApiVerify $request)
    {
        if ($request->hasFile('cover')) {
            $request->file('cover')
                ->store('series-cover', 'public');
        }

        return response()
            ->json(Series::all(), 201);
    }

    public function show(int $serie)
    {
        $seriesModel = Series::with('seasons.episodes')->find($serie);
        if ($seriesModel === null) {
            return response()
                ->json(['message' => "Inteiro não existente"], 404);
        }

        return $seriesModel;
    }

    public function update(int $serie, Request $request)
    {
        Series::where("id", $serie)->update($request->all());
        return Series::whereId($serie)->first();
    }

    public function destroy(int $serie)
    {
        Series::destroy($serie);
        // no content é uma resposta vazia
        return response()->noContent();
    }
}
