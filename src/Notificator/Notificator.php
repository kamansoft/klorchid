<?php


namespace Kamansoft\Klorchid\Notificator;

use Illuminate\Support\Facades\Log;
use Orchid\Alert\Alert;
use Orchid\Support\Facades\Alert as AlertFacade;
use Orchid\Support\Facades\Toast as ToastFacade;

class Notificator implements NotificaterInterface
{

    const DEFAULT_MODE = 'alert';

    private string $mode = self::DEFAULT_MODE;

    private array $available_modes = [
        'alert',
        'toast'
    ];


    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return Notificator
     */
    public function setMode(string $mode): Notificator
    {
        if (in_array($mode, $this->available_modes)) {
            $this->mode = $mode;
        }else{
            Log::info('Notificator mode: '.$mode.' is not a valid mode');
        }
        return $this;
    }

    private function alertWrapper($type,string $message){
        switch($this->mode){
            case 'alert':
                return AlertFacade::$type($message);
                break;
            case 'toast':
                return ToastFacade::$type($message);
        }
    }
    public function info(string $message): Alert
    {
        return $this->alertWrapper('info',$message);

    }

    public function success(string $message): Alert
    {
       return $this->alertWrapper('success',$message);

    }

    public function error(string $message): Alert
    {
        return $this->alertWrapper('error',$message);

    }

    public function warning(string $message): Alert
    {
       return $this->alertWrapper('warning',$message);
    }
}