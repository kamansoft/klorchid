<?php

namespace Kamansoft\Klorchid\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kamansoft\Klorchid\Contracts\KlorchidModelRelationLoadbleInterface;
use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Traits\KlorchidModelRelationLoadbleTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;

abstract class KlorchidMultimodeFormRequest extends EntityDependantFormRequest
    implements KlorchidPermissionsInterface, KlorchidMultimodeInterface, KlorchidModelRelationLoadbleInterface
{
    use KlorchidMultiModeTrait;
    use KlorchidPermissionsTrait;
    use KlorchidModelRelationLoadbleTrait;


    const MODES_METHODS_NAME_SUFFIX = 'ModeAutorize';
    const MODE_VALIDATION_METHODS_SUFIX = 'ModeValidation';

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->initAvailableModes(self::MODES_METHODS_NAME_SUFFIX);

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);




    }

    abstract public function modeDetect(): string;

    //todo: this method  should be in a klorchid base method
    public function rules(): array
    {

        return empty($this->all()) ? [] : $this->validationRules();
    }

    public function validationRules(): array
    {
        $mode=$this->getMode();
        $mode_valaidation_method_name=Str::camel($mode.static::MODE_VALIDATION_METHODS_SUFIX);
        if (!method_exists($this, $mode_valaidation_method_name)){
            throw new \Exception('Can\'t run validation for "'.$mode.'"  mode. You must implement "'.$mode_valaidation_method_name.'()" method at  ' . static::class .' in order to run validation rules on current mode');

        }

        //dd($mode_valaidation_method_name);
        return $this->$mode_valaidation_method_name();
    }

    /**
     * Maps thorough thereflectionClass object of an instance of this class,
     * get all the methods which name's ends with the value at $needle
     * and returns a collection with all of those methods
     * @param string $needle
     * @return Collection
     * @throws \ReflectionException
     */
    private function getModesByMethodsName(string $needle = 'Mode'): Collection
    {
        return getObjectMethodsThatEndsWith($this, $needle);
    }


    public function authorize()
    {

        $detected_mode = $this->modeDetect();
        $this->setMode($detected_mode);
        $method_mode_authorize_name=$this->getModeMethod($this->getMode());
        return $this->$method_mode_authorize_name();
        //return true;
    }

    abstract public function defaultModeAutorize():array;
}