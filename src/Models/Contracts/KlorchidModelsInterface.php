<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface KlorchidModelsInterface
{
    /**
     * used to map the the statues values by a string
     * @return array the statusvalue => permission value pair array
     */
    static public function statusStringValues(): array;

    static public function statusToString($status): string;

    static public function userModelClass(): string;

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

    /**
     *
     * should retrive the
     *
     * @return mixed
     */
    public function creator();

    public function updater();

    public function getCreatorNameAttribute();

    public function getUpdaterNameAttribute();

    public function getStringStatusAttribute(): string;


}