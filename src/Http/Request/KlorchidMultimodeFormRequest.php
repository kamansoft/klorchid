<?php

namespace Kamansoft\Klorchid\Http\Request;

use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Contracts\KlorchidModelRelationLoadbleInterface;
use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Traits\KlorchidModelRelationLoadbleTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;

abstract class KlorchidMultimodeFormRequest   extends EntityDependantFormRequest
    implements KlorchidPermissionsInterface, KlorchidMultimodeInterface, KlorchidModelRelationLoadbleInterface
{
    use KlorchidMultiModeTrait;
    use KlorchidPermissionsTrait;
    use KlorchidModelRelationLoadbleTrait;


    const MODES_METHODS_NAME_SUFFIX = 'authorizeModeOn';

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->initAvailableModes(self::MODES_METHODS_NAME_SUFFIX);
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }
  /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //dd($this->detectMode());
        $this->setMode($this->detectMode());
        $mode_method_name = $this->getModeMethod($this->getMode());
        return $this->$mode_method_name();
    }

      public function rules(): array
    {
        return empty($this->all()) ? [] : $this->validationRules();
    }

    //abstract public function validationRules(Model $model): array;

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
        return getObjectMethodsThatStartsWith($this, $needle);
    }

}