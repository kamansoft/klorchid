<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

trait LayoutTrait
{

    public function getIdField(?Model $model = null): Field
    {
        $model = is_null($model) ? $this->query->get('element') : $model;
        return Input::make('element.id')
            ->type('text')
            ->max(255)
            ->title(__('Id'))
            ->class('form-control ' . $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($this->getAction() !== 'create');
    }

    public function getStatusField(?Model $model = null): Field
    {
        $model = is_null($model) ? $this->query->get('element') : $model;
        return Input::make('element.stringStatus')
            ->class('form-control ' . $this->getFieldCssClass($model))
            ->type('text')
            ->title(__('Current Status') . ':')
            ->disabled(true);

    }


    public function getBlamingFields(?Model $model = null): array
    {
        $model = is_null($model) ? $this->query->get('element') : $model;
        $field_class  = $this->getFieldCssClass($model);
        return [
            Input::make('element.creatorName')
                ->class('form-control ' . $field_class )
                ->type('text')
                ->title(__('Created by') . ':')
                ->disabled(true),
            Input::make('element.created_at')
                ->class('form-control ' . $field_class)
                ->type('text')
                ->title(__('Creation date') . ':')
                ->disabled(true),
            Input::make('element.updaterName')
                ->class('form-control ' . $field_class)
                ->type('text')
                ->title(__('Updated by') . ':')
                ->disabled(true),
            Input::make('element.updated_at')
                ->class('form-control ' . $field_class)
                ->type('text')
                ->title(__('Update date') . ':')
                ->disabled(true)

        ];
    }

    public function mergeWithBlammingFields(array $fields){
        $fields_to_return  = $fields;
        if ($this->getAction() == "edit") {
            array_push($fields_to_return, ... $this->getBlamingFields());
        }
        return $fields_to_return;
    }

    public function getFieldCssClass(Model $model)
    {

        $to_return = 'text-dark';

        $action = $this->getAction();
        if ($action == 'simple') {
            $to_return = 'text-muted';
        };
        if ($this->isDissabled($model)) {
            $to_return = 'text-danger';
        }


        return $to_return;
    }


    public function isEditable($model)
    {
        $to_return = false;

        $action = $this->query->get('form_action');
        $to_return = ($action == 'create' or $action == 'edit');

        if ($this->isDissabled($model)) {
            $to_return = false;
        }

        return $to_return;

    }

    public function isDissabled(Model $model)
    {

        $to_return = false;
        //check if the element is disabled in data
        if (array_key_exists('status', $model->getAttributes())) {

            $to_return = !$model->status;
        }
        return $to_return;
    }

    /**
     * hasPermission
     *
     * will check if the logged user has $permission
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        if (!Auth::user()->hasAccess($permission)) {

            return false;
        } else {
            return true;
        }

        return false;
    }

    public function getAction()
    {
        return $this->query->get('form_action');

    }

    public function getElement()
    {
        return $this->query->get('element');
    }
}
