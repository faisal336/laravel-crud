<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    /**
     * retrieved,
     * creating,
     * created,
     * updating,
     * updated,
     * saving,
     * saved,
     * deleting,
     * deleted,
     * restoring,
     * restored,
     * replicating
     ** /

    /**
     * Handle the Model "creating" event.
     *
     * @param Model $model
     * @return void
     */
    public function creating(Model $model): void
    {
        $model->created_by = auth()->id();
    }

    /**
     * Handle the Model "updating" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function updating(Model $model): void
    {
        $model->updated_by = auth()->id();
    }

    /**
     * Handle the Model "deleting" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleting(Model $model): void
    {
        $model->deleted_by = auth()->id();
    }
}
