<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Screen\Fields;

use Orchid\Screen\Fields\Relation;

/**
 * Class KlorchidRelation.
 *
 * @method KlorchidRelation accesskey($value = true)
 * @method KlorchidRelation autofocus($value = true)
 * @method KlorchidRelation disabled($value = true)
 * @method KlorchidRelation form($value = true)
 * @method KlorchidRelation name(string $value = null)
 * @method KlorchidRelation required(bool $value = true)
 * @method KlorchidRelation size($value = true)
 * @method KlorchidRelation tabindex($value = true)
 * @method KlorchidRelation help(string $value = null)
 * @method KlorchidRelation placeholder(string $placeholder = null)
 * @method KlorchidRelation popover(string $value = null)
 * @method KlorchidRelation title(string $value = null)
 */
class KlorchidRelation extends Relation
{

    /**
     * @var string
     */
    protected $view = 'klorchid::fields.klorchid_relation';


    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class' => 'form-control',
        'value' => [],
        'relationScope' => null,
        'relationAppend' => null,
        'relationSearchColumns' => null,
        'relationViewRouteName' => null,
        'relationEditRouteName' => null,
        'relationCreateRouteName' => null,
        'chunk' => 10,
    ];

    /**
     * Sets the edit route name
     *
     * @param int $value
     *
     * @return $this
     */
    public function editRouteName(string $value)
    {

        return $this->set('relationEditRouteName', $value);
    }


    public function viewRouteName(string $value)
    {
        return $this->set('relationViewRouteName', $value);
    }

    public function addRouteName(string $value)
    {
        return $this->set('relationAddRouteName', $value);
    }

}
