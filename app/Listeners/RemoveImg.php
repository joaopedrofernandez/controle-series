<?php

namespace App\Listeners;

use App\Events\FlameCover;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class RemoveImg
{
    public function __construct()
    {
        //
    }

    public function handle(FlameCover $event): void
    {
        if (!empty($event->path)) {
            if ($event->path !== "series-cover/imagemPd.png") {
                Storage::disk('public')->delete($event->path);
            }
        }
    }
}
