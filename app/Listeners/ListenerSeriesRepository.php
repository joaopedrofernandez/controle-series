<?php

namespace App\Listeners;

use App\Events\RetrievesAllRequest;
use App\Repositories\SeriesRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenerSeriesRepository
{
    public function __construct(
        private SeriesRepository $repository
    ) {}

    public function handle(RetrievesAllRequest $event): void
    {
        $this->repository->add($event->all);
    }
}