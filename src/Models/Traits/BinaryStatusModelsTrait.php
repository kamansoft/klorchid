<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait BinaryStatusModelsTrait
{
    use KlorchidModelWithStatusTrait;
    use KlorchidUserBlamingModelsTrait;
    use KlorchidEloquentModelsTrait;
    use KlorchidModelsStatusValuesTrait;

    static public function stringToStatus(string $status): bool
    {
        $values = self::statusStringValues();
        return boolval(intval($values[$status]));
    }

    static public function statusStringValues(): array
    {
        return [
            'Inactive' => '0',
            'Active' => '1'

        ];
    }

    public function statusToggle(string $reason): self
    {
        $this->reason = $reason;
        $this->status = !$this->status;
        return $this;
    }

}