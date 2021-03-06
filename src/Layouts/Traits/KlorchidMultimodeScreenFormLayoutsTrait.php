<?php

namespace Kamansoft\Klorchid\Layouts\Traits;

trait KlorchidMultimodeScreenFormLayoutsTrait
{
    use KlorchidMultimodeScreenLayoutsTrait, KlorchidFormLayoutsTrait;

    public function fieldIsEditable(?object $element = null)
    {
        $to_return = false;
        $element = $element ?? $this->query->get(model_keyname());

        if ($this->modelIsProtected($element) == false) {

            $to_return = true;
            if (
                $this->getScreenMode() === 'create' and
                !is_null($this->getScreenModePerm('create')) and
                $this->userHasPermission($this->getScreenModePerm('create')) === false
            ) {
                $to_return = false;
            } elseif (
                $this->getScreenMode() === 'edit' and
                !is_null($this->getScreenModePerm('edit')) and
                $this->userHasPermission($this->getScreenModePerm('edit')) === false
            ) {
                $to_return = false;
            }
        }

        return $to_return;
    }


    public function klorchidFieldClass(string $extra = 'form-control ', ?object $element = null)
    {
        $element = $element ?? $this->query->get(model_keyname());

        $to_return = 'text-dark';

        $action = $this->getScreenMode();
        if ($action == 'default') {
            $to_return = 'text-muted';
        };

        if ($this->modelIsProtected($element)) {
            $to_return = 'text-danger';
        }

        $to_return = $to_return . ' ' . $extra;

        return $to_return;

    }
}