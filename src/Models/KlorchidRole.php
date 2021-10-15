<?php

namespace Kamansoft\Klorchid\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsExtraCastTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidMultiStatusModelTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Models\Role;


class KlorchidRole extends Role implements KlorchidModelsInterface,
    KlorchidMultiStatusModelInterface, BooleanStatusModelInterface
{

    //klorchid related
    use KlorchidModelsExtraCastTrait;
    use KlorchidUserBlamingModelsTrait;
    use KlorchidMultiStatusModelTrait;
    use BooleanStatusModelTrait;

    protected $casts = [
        'permissions' => 'array',
        'status' => 'boolean',
        'cur_status_reason' => 'string',
        'updated_at' => 'datetime:d/m/Y h:m:s a',
        'created_at' => 'datetime:d/m/Y h:m:s a',
    ];









}
