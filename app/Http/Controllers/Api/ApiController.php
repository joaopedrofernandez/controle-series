<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(
        private SeriesRepository $repository
    ) {}

    public function index()
    {
        return Series::all();
    }

    public function store(SeriesFormRequest $request)
    {
        return response()
            ->json(Series::create($request->all()), 201);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')
                ->store('series-cover', 'public');
        }

        return response()
            ->json(Series::all());
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
