<?php


namespace Kamansoft\Klorchid\Models\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface KlorchidUserBlamingModelInterface
{

    /**
     * Retrives the user to user for create or blame
     * @return string
     */
    public function getUserToBlameId(): string;

    /**
     * Do the process of setting the id of the creator in the created_at and updated_at attribute within the model
     * @return mixed
     */
    public function blameOnCreate();

    /**
     * Do the process of setting the id of the updater in the update_at attribute within the model
     * @return mixed
     */
    public function blameOnUpdate();

    public function creator(): BelongsTo;

    public function updater(): BelongsTo;


}