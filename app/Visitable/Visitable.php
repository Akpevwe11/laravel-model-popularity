<?php

namespace App\Visitable;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Visitable\PendingVisit;
use Illuminate\Database\Eloquent\Builder;


trait Visitable
{

    public function visit()
    {
      return  new PendingVisit($this);

    }

    public function scopeWithTotalVisitsCount(Builder $query)
    {
        $query->withCount('visits as visit_count_total');
    }


    public function visits(): MorphMany
    {
        return $this->morphMany(Visit::class, 'visitable');
    }
}
