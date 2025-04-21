<?php

namespace App\Visitable;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Visit;
use SetsPeindingIntervals;

class PendingVisit
{
    use SetsPeindingIntervals;

    protected $attributes = [];

    protected $interval;


    public function __construct(protected Model $model)
    {
        $this->dailyInterval();
    }

    public function withIp($ip = null)
    {
        $this->attributes['ip'] = $ip ?? request()->ip();

        return $this;

    }

    public function withUser(?User $user = null)
    {

        $this->attributes['user_id'] = $user?->id ?? auth()->user()->id;

        return $this;
    }

    public function withData($data)
    {
        $this->attributes = array_merge($this->attributes, $data);

        return $this;
    }

    protected function buildJsonColumns()
    {
        return collect($this->attributes)

            ->mapWithKeys(function ($value, $index) {

                return ['data->' . $index => $value];
            })
            ->toArray();
    }

    public function shouldBeLoggedAgain(Visit $visit)
    {
        return !$visit->wasRecentlyCreated && $visit->created_at->lt($this->interval);
    }


    public function __destruct()
    {
        // dd($this->attributes);

       $visit = $this->model->visits()->latest()->firstOrCreate($this->buildJsonColumns(), [

           'data' => $this->attributes

        ]);

        $visit->when($this->shouldBeLoggedAgain($visit), function () use ($visit) {

            $visit->replicate()->save();

        });


    }


}
