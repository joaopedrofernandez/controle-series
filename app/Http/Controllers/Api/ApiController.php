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

    public function index()
    {
        return Series::all();
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
            ->json(Series::all(), 203);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('cover')) {
            $request->file('cover')
                ->store('series-cover', 'public');
        }

        return response()
            ->json(Series::all());
    }

    public function show(int $serie)
    {
        return Series::whereId($serie)
            ->with('seasons.episodes')
            // ->first() vai retornar somente o objeto {} e nao a collection -> []
            // para retornar o array [] ->get()
            ->first();
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
