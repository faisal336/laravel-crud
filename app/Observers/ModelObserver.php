<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    public $userID;

    public function __construct($userID = null)
    {
        $this->userID = $userID ?? Auth()->id();
    }

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
        $model->created_by = $this->userID;
    }

    /**
     * Handle the Model "updating" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function updating(Model $model): void
    {
        $model->updated_by = $this->userID;
    }
}
