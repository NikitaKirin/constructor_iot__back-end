<?php

namespace App\Jobs\Professions;

use App\Events\HeadHunterUpdatedEvent;
use App\Events\HeadHunterUpdatingEvent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class HeadHunterUpdateJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 3600;

    public $tries = 5;

    public $uniqueFor = 3600;

    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return $this->user->id;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        HeadHunterUpdatingEvent::dispatch($this->user);
        Artisan::call('headhunter:run');
        HeadHunterUpdatedEvent::dispatch($this->user);
    }
}
