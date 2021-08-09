<?php

namespace Kamansoft\Klorchid\Console\Commands;


use Illuminate\Foundation\Console\RequestMakeCommand;
use Illuminate\Support\Str;


class KlorchidStorableFormRequestCommand extends RequestMakeCommand
{
    /**
     * The console command name and options.
     *
     * @var string
     */
    protected $signature = 'klorchid:make:storable-form-request
    {name : The model class to be stored, or the name of the form request class if the model option value is empty. }
    {--model= : The model class to be stored. When used the name argument value will be the form request class name.}
    {--route-param-name= : The route param name used to denote the model.}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new klorchid storable form request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'KlorchidStorableFormRequest';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../../resources/stubs/klorchid.storable_form_request.stub';
    }

    protected function getNameInput()
    {
        return $this->getClassNameHandler();
    }

    private function getClassNameHandler()
    {
        if (empty($this->input->getOption('model'))) {
            //return parent::getNameInput();
            $exploded = explode('/', parent::getNameInput());
            return end($exploded).'StorableFormRequest';

        }
        return parent::getNameInput();

    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name); // TODO: Change the autogenerated stub


        $replace = [
            $this->getModelFullClassNameHandler(),
            $this->getModelClassName(),
            $this->getRouteParamName()];
        return str_replace([
            'DummyModelFullClassName',
            'DummyModelClassName',
            'dummy_route_param_name',
        ], $replace, $stub);


    }

    private function getModelClassName()
    {
        $model_name = $this->getModelFullClassNameHandler();
        $exploded = explode('\\', $model_name);

        return end($exploded);
    }

    private function getModelFullClassNameHandler()
    {
        if (empty($this->input->getOption('model'))) {
            return $this->qualifyClass(parent::getNameInput());
        }

        return $this->qualifyClass($this->input->getOption('model'));
    }

    private function getRouteParamName()
    {
        if (empty($this->input->getOption('route-param-name'))) {
            return Str::snake($this->getModelClassName());
        }
        return $this->input->getOption('route-param-name');
    }
}