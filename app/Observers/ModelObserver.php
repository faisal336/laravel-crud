<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    public $userID;

    public function __construct($userID = null)
    {
        if (is_null($userID)) {
            $this->userID = auth()->id() ?: Auth('api')->id();
        } else {
            $this->userID = $userID;
        }
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

    /**
     * Handle the Model "deleting" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function deleting(Model $model): void
    {
        $model->deleted_by = $this->userID;
    }
}
