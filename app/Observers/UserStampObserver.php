<?php

namespace App\Observers;

use Carbon\Carbon;

class UserStampObserver
{
    protected $userId = 0;

    public function __construct()
    {
        $user = auth()->user();
        if ($user) {
            $this->userId = $user->id;
        }
    }
    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function creating($model)
    {
        $model->created_by = $this->userId;
        $model->updated_by = $this->userId;
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updating($model)
    {
        // $model->updated_at = Carbon::now();
        $model->updated_by = $this->userId;
    }

    // public function updated($model)
    // {
    //     $model->updated_by = $this->userId;
    // }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    // public function deleting($model)
    // {
    //     $model->deleted_by = $this->userId;
    //     $model->restored_by = 0;
    //     return true;
    // }

    public function deleted($model)
    {
        if ($model->isForceDeleting()) {
            $model->forceDelete();
        } else {
            $model->deleted_by = $this->userId;
            $model->save();
        }
    }

    public function restoring($model)
    {
        $model->restored_by = $this->userId;
        $model->restored_at = Carbon::now();
        $model->deleted_by = "";
        $model->deleted_at = "";
        return true;
    }
}
