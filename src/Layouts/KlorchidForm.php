<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

abstract class KlorchidForm extends Rows
{

	public bool $blaming_fields = false;
	public bool $status_fields = false;

    public function statusClass (bool $status):string{
        return $status ? 'text-success' : 'text-danger';
    }


    public function fields():array{
    	return 
    }

    abstract public function formFields ():array;



}
