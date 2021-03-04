<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait KlorchidModelsStatusTrait
{

    public function statusSet($status, string $reason):self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }



    public function invalidate():self
    {
        $this->status = false;
        $this->save();
        return $this;
    }



}
