<?php


namespace Kamansoft\Klorchid\Models\Contracts;


use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;

interface KlorchidMultiStatusModelInterface
{


    public static function getStatusName($status);

    public function getStatusColorClass(?string $status_name = null): string;

    public function statusSet($status, string $reason): bool;

    public function getStatusNameAttribute(): string;

    public function isLockedByStatus($status_value = null): bool;

    public function statusPresenter(): MultiStatusModelPresenter;
}
