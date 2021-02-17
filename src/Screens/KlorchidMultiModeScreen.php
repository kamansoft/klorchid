<?php
declare(strict_types=1);

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kamansoft\Klorchid\KlorchidPermissionTrait;
use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

abstract class KlorchidMultiModeScreen extends Screen
{

    use KlorchidPermissionTrait;

    private $klorchid_repository;
    private Collection $available_screen_modes;
    private Collection $available_repository_actions;
    private Collection $repository_action_validation_rules_methods;
    private Collection $automatic_repository_action_validation_rules_methods;
    private string $current_screen_mode;
    private Collection $klorchid_screen_modes_perms;

    public function __construct(?KlorchidRepositoryInterface $repository = null)
    {

        $this->current_screen_mode = 'default';
        $this->setModes()->setModePerms();
        if (!is_null($repository)) {
            $this->setRepository($repository)->setRepositoryActions()->setRepositoryActionValidations()->setRepositoryActionValidations();
        }

    }

    /**
     * Get the array from $this->modePermissions and store it in the klorchid_screen_modes_perms collection
     * @return $this
     */
    private function setModePerms(): self
    {

        $mode_perms = collect($this->modePermissions())->mapWithKeys(function ($perm, $mode) {
            if (!$this->modeExists($mode)) {
                throw new \Exception(self::class
                    . " instance has not an asociated method for \"$mode\" mode",
                    1
                );
            }
            if (!$this->permissionExists($perm)) {
                throw new \Exception(self::class . ":  \"$perm\" is not a valid permission key.", 1);
            }
            return [$mode => $perm];
        })->reject(function ($perm, $mode) {
            return (!$this->permissionExists($perm) and !$this->modeExists($mode));
        });

        $this->klorchid_screen_modes_perms = $mode_perms;
        return $this;
    }

    abstract public function modePermissions(): array;

    /**
     * check if a mode as a string at $mode is in the available_screen_modes attribute
     * @param string $mode
     * @return bool
     */
    public function modeExists(string $mode): bool
    {
        //return $this->available_screen_modes->get($mode) ? true : false;
        return $this->getModes()->contains($mode);
    }

    /**
     * Retrive the private available_screen_modes attribute of this instance
     * @return Collection
     */
    public function getModes(): Collection
    {
        return $this->available_screen_modes;
    }

    /**
     * Store the retun value of getModesByLayoutMethods to available_screen_modes attribute
     * @return $this
     * @throws \ReflectionException
     */
    public function setModes(): self
    {
        //dd($this->getModesByLayoutMethods()->toArray());
        $this->available_screen_modes = $this->getModesByLayoutMethods();
        return $this;
    }

    /**
     * Maps thorug the reflectionClass object of an instance of this class, and returns all the methods
     * which name's ends with "ModeLyout". and returns a collection with all of those methods
     * @return Collection
     * @throws \ReflectionException
     */
    private function getModesByLayoutMethods(): Collection
    {
        $reflection = new \ReflectionClass($this);

        return collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
            return [Str::snake(strstr($method->name, 'ModeLayout', true)) => $method->name];
        })->reject(function ($pair) {
            return !strstr($pair, 'ModeLayout', true);
        });

    }

    private function setRepositoryActionValidations(): self
    {

        $reflection = new \ReflectionClass($this->klorchid_repository);
        $this->repository_action_validation_rules_methods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
            return [Str::snake(strstr($method->name, 'ValidationRules', true)) => $method->name];
        })->reject(function ($pair) {

            return !strstr($pair, 'ValidationRules', true);
        });

        $this->automatic_repository_action_validation_rules_methods = $this->repository_action_validation_rules_methods
            ->mapWithKeys(function ($method_name, $action_name) {
                return [$action_name => $method_name];
            })->reject(function ($method_name, $action_name) {
                return !$this->repositoryActionExists($action_name);
            });

        //dd($this->getRepositoryActions(),$this->repository_action_validation_rules_methods,$this->automatic_repository_action_validation_rules_methods);
        return $this;

    }

    public function repositoryActionExists(string $action): bool
    {
        //return $this->getRepositoryActions()->get($action) ? true : false;
        return $this->getRepositoryActions()->contains($action);
    }

    public function getRepositoryActions(): Collection
    {
        return $this->available_repository_actions;
    }

    private function setRepositoryActions(): self
    {

        $reflection = new \ReflectionClass($this->klorchid_repository);
        $this->available_repository_actions = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
            return [Str::snake(strstr($method->name, 'Action', true)) => $method->name];
        })->reject(function ($pair) {
            return !strstr($pair, 'Action', true);
        });

        return $this;

    }

    public function setRepository($repository): self
    {
        $this->klorchid_repository = $repository;
        //$this->setActions();
        return $this;
    }

    /**
     * Set the value of curent_screen_mode attribute with the string value passed on $mode attribute,
     * But this method checks if that  $mode is a valid one and will throw an exeption if it is not
     * @param string $mode
     * @return $this
     * @throws \Exception
     */
    public function setMode(string $mode): self
    {
        if ($this->modeExists($mode)) {
            $this->current_screen_mode = $mode;
        } else {
            throw new \Exception(self::class
                . ' Can\'t set "'
                . $mode
                . '" as current screen mode, due to "'
                . $mode
                . '" is not an available screen mode. '
            );
        }
        return $this;
    }

    public function userHasScreenModePermission(string $mode): bool
    {
        return $this->userHasPermission($this->getScreenModePerm($mode));
    }

    public function getScreenModePerm(string $mode): string
    {
        return $this->getScreenModePerms()->get($mode);
    }

    public function getScreenModePerms(): Collection
    {
        return $this->klorchid_screen_modes_perms;
    }

    public function setAutomaticActionValidation(bool $value = true): self
    {
        $this->run_atutomatic_validation = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function layout(): array
    {

        $current_mode = $this->getMode();
        $method = $this->getModes()->get($current_mode);

        //dd($this->getModes()[$this->getMode()]);
        $mode_layout_array = $this->$method();
        \Debugbar::info('layout() method, current mode: *' . $current_mode);
        return $mode_layout_array;//array_merge($this->multiModeLayout(), $mode_layout_array);
    }




    //related to the current mode

    /**
     * Retrive the current_screen_mode attribute value of the instance of this class
     * @return string
     */
    public function getMode(): string
    {
        return $this->current_screen_mode;
    }

    //\related to the current mode

    public function runRepositoryAction(string $repository_action, Request $request, bool $run_validation = false): void
    {

        //check if the action match the mode and if it does check for permission
        $mode_perm = $this->getScreenModePerm($repository_action);
        if ($mode_perm) {
            Log::warning(
                self::class
                . ' user: '
                . Auth::user()->id
                . ' tryed to run screen runRepositoryAction method with  "'
                . $repository_action
                . '" repository action , without "'
                . $mode_perm
                . '" permission'
            );
            $this->userHasPermissionOrFail($mode_perm);
        }

        //check for a valid repository action
        if ($this->repositoryActionExists($repository_action)) {

            //determinate if validation will run
            if ($run_validation) {


                //check for validation rules as they are mandatory within this scope
                if (is_null($this->getActionValidationRulesMethod($repository_action))) {
                    throw new \Exception(self::class . ' runRepositoryAction called with $run_validation set to true, but a "' . $repository_action . '" validation rules method was not found on repository');
                }

                $validated_data = $this->validateWith($this->getActionValidationRules($repository_action));
                Log::info(self::class . ' Validation executed for ' . $this->getRepositoryActionMethod($repository_action) . " method");
            } else {
                $validated_data = $request->get(data_keyname_prefix());
                Log::warning(self::class . "No validation was executed for " . $this->getRepositoryActionMethod($repository_action) . ' method');
            }


            //if ($this->userHasPermission())

            $executions_status = $this->getRepository()->{$this->getRepositoryActionMethod($repository_action)}($validated_data);
            if ($executions_status) {
                Alert::success(__("Successfully executed action: :action", ["action" => __($repository_action)]));
                Log::info(self::class . ' repository "' . $this->getRepositoryActionMethod($repository_action) . '" method successfully executed');
            } else {
                Alert::error(__("Not executed action: :action", ["action" => __($repository_action)]));
                Log::warning(self::class . ' repository "' . $this->getRepositoryActionMethod($repository_action) . '"  method was not successfully executed');
            }


        } else {
            throw new \Exception(self::class . ' "' . $repository_action . '" action name has not a related repository method', 1);
        };


    }

    public function getActionValidationRulesMethod(string $action): string
    {
        return $this->getActionValidationRulesMethods()->get($action);
    }

    public function getActionValidationRulesMethods(): Collection
    {
        return $this->repository_action_validation_rules_methods;
    }

    public function getActionValidationRules(string $action): array
    {
        return $this->getRepository()->{$repository_validation_rule_method}();
    }

    public function getRepository()
    {
        return $this->klorchid_repository;
    }

    public function getRepositoryActionMethod(string $action): string
    {
        return $this->available_repository_actions->get($action);

    }

    public function actionValidationRulesExists(string $action): bool
    {
        return $this->actionValidationRulesMethodExists($action);
    }

    public function actionValidationRulesMethodExists(string $action): bool
    {
        return $this->getActionValidationRulesMethods()->contains($action);

    }



    // TODO: notify on orchid github issues that if you set the first param as Request type object the, then a null is passesd to the rest of the params

    /**
     * Will run the repository save method passing the  data  from http post, it will try to run a validation if
     * a validation if the name the current screen mode match the validation rule method name
     *
     * @param string|null $screen_mode
     * @param Request $request
     */
    public function save(?string $screen_mode, Request $request)//,?string $screen_mode)
    {


        $screen_mode = $screen_mode ?? $this->getMode();
        $mode_perm = $this->getScreenModePerm($screen_mode);
        if ($mode_perm
            and $this->screenModePermExists($screen_mode)
            and !$this->userHasPermission($this->getScreenModePerm())) {
            Log::warning(
                self::class
                . ' user: '
                . Auth::user()->id
                . ' tryed to run screen save method on  "'
                . $screen_mode
                . '" screen mode, without "'
                . $mode_perm
                . '" permission'
            );
            $this->userHasPermissionOrFail($mode_perm);
        } else {
            Log::warning(
                self::class
                . ' user: '
                . Auth::user()->id
                . ' runed screen save method on  "'
                . $screen_mode
                . '" Permission not found on screen list'
            );
        }

        $validation_rules_method = $this->getActionValidationRulesMethod($screen_mode) ?? false;

        if ($validation_rules_method) {
            $validated_data = $this->validateWith($this->getActionValidationRules($screen_mode));
            Log::info(
                self::class
                . ' validation performed from repository rules using  "'
                . $this->getActionValidationRulesMethod($screen_mode)
                . '" save method executed with screen validation '
            );

        } else {
            $validated_data = $request->get(data_keyname_prefix());
            Log::warning(
                self::class
                . "Validation rule for $screen_mode not found. save method executed without screen validation "
            );
        }

        //dd($screen_mode, $screen_mode, $validation_rules_method, $validated_data,$request);


        $execution_status = $this->getRepository()->save($request->get(data_keyname_prefix()));
        if ($execution_status) {
            Alert::success(__("Saved"));
            Log::info(self::class . " Repository save method returned true on executed");
        } else {
            Alert::error(__("Error on save"));
            Log::warning(self::class . " Repository save method returned false on executed");
        }

    }

    public function screenModePermExists(string $mode): bool
    {
        return $this->getScreenModePerms()->contains($mode);
    }

    abstract public function defaultModeLayout(): array;


}
