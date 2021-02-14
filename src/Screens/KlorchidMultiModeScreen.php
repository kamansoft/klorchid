<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;


abstract class KlorchidMultiModeScreen extends Screen
{


    private $klorchid_repository;

    private Collection $available_screen_modes;


    private Collection $available_repository_actions;

    private Collection $repository_action_validation_rules_methods;

    private Collection $automatic_repository_action_validation_rules_methods;


    private string $current_screen_mode;

    public function __construct(?KlorchidRepositoryInterface $repository = null)
    {

        $this->current_screen_mode = 'default';
        $this->setModes();


        if (!is_null($repository)) {
            $this->setRepository($repository)->setRepositoryActions()->setRepositoryActionValidations()->setRepositoryActionValidations();
        }

        //$this->setScreenModePerms($this->screenModePerms());

    }

    public function setModes(): self
    {
        //dd($this->getModesByLayoutMethods()->toArray());
        $this->available_screen_modes = $this->getModesByLayoutMethods();
        return $this;
    }

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
                return !$this->isValidRepositoryAction($action_name);
            });

        //dd($this->getRepositoryActions(),$this->repository_action_validation_rules_methods,$this->automatic_repository_action_validation_rules_methods);
        return $this;

    }

    public function isValidRepositoryAction(string $action): bool
    {
        return $this->getRepositoryActions()->get($action) ? true : false;
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

    public function actionHasAutoValidation(string $action): bool
    {
        return $this->automatic_repository_action_validation_rules_methods->get($action) ? true : false;
    }

    public function setMode(string $mode)
    {
        if ($this->getModes()->get($mode)) {
            $this->current_screen_mode = $mode;
        } else {
            throw new \Exception(self::class . ' Can\'t set "' . $mode . '" as current screen mode, due to "' . $mode . '" is not an available screen mode. ');
        }
        return $this;
    }

    public function getModes(): Collection
    {
        return $this->available_screen_modes;

    }

    public function isValidMode(string $mode): bool
    {
        return $this->available_screen_modes->get($mode) ? true : false;
    }


    //related to the current mode

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

    public function getMode()
    {
        return $this->current_screen_mode;
    }

    //\related to the current mode

    public function runRepositoryAction(string $repository_action, Request $request, bool $run_validation = true)
    {
        //check for a valid repository action
        if ($this->isValidRepositoryAction($repository_action)) {

            //determinate if validation will run
            if ($run_validation and $this->getValidationRuleMethod($repository_action)) {
                $validated_data = $this->validateWith($this->getValidationRules($repository_action));
                Log::info(self::class . ' Validation executed for ' . $this->getRepositoryActionMethod($repository_action) . " method");
            } else {
                $validated_data = $request->get(data_keyname_prefix());
                Log::warning(self::class . "No validation was executed for " . $this->getRepositoryActionMethod($repository_action) . ' method');
            }

            $executions_status = $this->getRepository()->{$this->getRepositoryActionMethod($repository_action)}($validated_data);
            if ($executions_status) {
                Alert::success(__("Successfully executed action: :action", ["action" => __($repository_action)]));
                Log::info(self::class . ' repository "' . $this->getRepositoryActionMethod($repository_action) . '" method successfully executed');
            } else {
                Alert::error(__("Not executed action: :action", ["action" => __($repository_action)]));
                Log::warning(self::class . ' repository "' . $this->getRepositoryActionMethod($repository_action) . '"  method was not successfully executed');
            }
        } else {
            throw new \Exception(self::class . ' "' . $repository_action . '" action name has not a related repository action method', 1);
        };


    }

    public function getValidationRuleMethod(string $action)
    {
        return $this->repository_action_validation_rules_methods->get($action);
    }


    /*
    public function isValidAction(string $action):bool
    {
    	return $this->available_repository_actions()->get($action);
    }*/

    public function getValidationRules(string $action): array
    {

        $repository_validation_rule_method = $this->getValidationRuleMethod($action);
        if ($repository_validation_rule_method) {

            return $this->getRepository()->{$repository_validation_rule_method}();
        } else {
            return [];
        }


    }


    //abstract function multiModeLayout(): array;

    public function getRepository()
    {
        return $this->klorchid_repository;
    }

    public function getRepositoryActionMethod(string $action)
    {
        return $this->available_repository_actions->get($action);

    }

    /**
     * Will run the repository save method passing the post request data to the repository save method
     * This method will try to perform a validation only if it can find a validationRules method on the repository
     * that match with the running screen mode
     * @param Request $request
     */
    public function save(Request $request, bool $run_validation = true)
    {

        $repository_action = $this->getMode();
        if ($run_validation and $this->getValidationRuleMethod($repository_action)) {
            $validated_data = $this->validateWith($this->getValidationRules($repository_action));
            Log::info(self::class . ' '.$this->getValidationRuleMethod($repository_action).' '.Validation executed for method");
        } else {
            $validated_data = $request->get(data_keyname_prefix());
            Log::warning(self::class . "No validation was executed for " . $this->getRepositoryActionMethod($repository_action) . ' method');
        }


        $execution_status = $this->getRepository()->save($request->get(data_keyname_prefix()));
        if ($execution_status) {
            Alert::success(__("Saved"));
            Log::info(self::class . " Repository save method returned true on executed");
        } else {
            Alert::error(__("Error on save"));
            Log::warning(self::class . " Repository save method returned false on executed");
        }

    }

    abstract public function defaultModeLayout(): array;


}
