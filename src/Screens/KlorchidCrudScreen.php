<?php


namespace Kamansoft\Klorchid\Screens;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Kamansoft\Klorchid\Repositories\KlorchidRepositoryInterface;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Support\Facades\Dashboard;

abstract class KlorchidCrudScreen extends \Orchid\Screen\Screen
{

    public KlorchidRepositoryInterface $repository;


    private string $screen_mode;

    /**
     *
     * All of the valid klorchid screen modes,
     * array order matters in therms of hierarchy, the higher the
     * mode index is in the array, the lower the order it has
     *
     * @var string[]
     */
    private $klorchid_screen_modes = [
        'edit',
        'create',
        'view',
        'limited_view'
    ];

    public function pushScreenMode(string  $mode){
        if (!empty($mode) && ! in_array($mode)){
            array_push($mode,$this->klorchid_screen_modes);
        }
        return $this;
    }


    private $klorchid_screen_modes_perms = [

        'view' => '',
        'edit' => '',
        'create' => ''
    ];


    public function isValidMode(string $mode): bool
    {
        return in_array($mode, $this->klorchid_screen_modes);
    }

    public function isValidPerm(string $perm): bool
    {
        return  Dashboard::getAllowAllPermission()->get($perm) ? true : false;
    }

    public function getModePerm(string $mode): string
    {
        return $this->klorchid_screen_modes_perms[$mode];
    }

    public function setScreenModePerm($mode, $perm): self
    {

        if ($mode !== 'limited_view' && $this->isValidMode($mode)) {
            if ($this->isValidPerm($perm)) {
                $this->klorchid_screen_modes_perms[$mode] = $perm;

            } else {
                throw  new \Exception(self::class . ' Can not set: "' . $perm . '" permission to  "' . $mode . '" mode. Due to "' . $perm . '" is not a system wide valid permission, or "' . $perm . '" is not inside the screen permission attribute array.');
            }
        } else {
            throw  new \Exception(self::class . ' Can not set: "' . $perm . '" permission to  "' . $mode . '" mode. Due to "' . $mode . '" is not a valid mode to set with a permission');
        }
        return $this;
    }

    private function setScreenModePerms(): self
    {
        foreach ($this->screenModePerms() as $mode => $perm) {
            if ( ! (empty($mode) && empty($perm) ) ){
                $this->setScreenModePerm($mode, $perm);
            }

            if (  ! in_array($perm)  ){
                array_push($perm,$this->permission);
            }

        }
        return $this;
    }

    abstract public function screenModePerms(): array;


    public function __construct()
    {

        $this->setScreenModePerms($this->screenModePerms());

    }


    public function hasPermission(string $perm)
    {
        return Auth::user()->hasAccess($perm);
    }


    public function detectScreenMode(): string
    {
        $mode_to_return = 'limited_view';


        if ($this->repository->getModel()->exists) {
            //if $this->hasPermission('')
        } else {

        }

        return "";
    }


}