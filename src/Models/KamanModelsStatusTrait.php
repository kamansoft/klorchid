<?php


namespace Kamansoft\Klorchid\Models;


use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait KamanModelsStatusTrait
{
    static public function statusStringValues():array
    {
        //this is odd and ugly but the best i can
        return [
            0 => __('Inactive'),
            1 => __('Active')

        ];
    }


    public function getStringStatusAttribute():string
    {
        return $this::statusToString($this->status > 0);
    }

    public static function getTableName():string
    {
        return self::getTable();
    }


    static public function statusToString(bool $status):string
    {
        $values = self::statusStringValues();
        return $values[$status];
    }

    static public function stringToStatus(string $status):string
    {
        \Debugbar::info('stringToStatus');
        $values = self::statusStringValues();
        \Debugbar::info($values);

        return array_search($status, $values);

    }


    public function getStatusSetValidationRules(Request $request): array
    {
        return [
            'element.status'=>'boolean',
            'element.cur_status_reason'=>'string',
            'element.new_status' => 'required|boolean|different:status',
            'element.new_status_reason' => 'required|min:15|different:cur_status_reasons',
        ];
    }

    public function getStatusToggleValidationRules(Request $request): array
    {
        return [
            'element.cur_status_reason'=>'string',
            'element.new_status_reason' => 'required|min:15|different:cur_status_reason',
        ];

    }






    public function statusSet(bool $status, string $reason):self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }

    public function statusToggle(string $reason):self
    {
        return $this->statusSet(!$this->status, $reason);

    }

    public function invalidate():self
    {
        $this->status = false;
        $this->save();
        return $this;
    }

}
