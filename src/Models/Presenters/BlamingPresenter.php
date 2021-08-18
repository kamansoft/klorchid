<?php

namespace Kamansoft\Klorchid\Models\Presenters;

use Orchid\Screen\Actions\Link;
class BlamingPresenter extends \Orchid\Support\Presenter
{


    private function linkToUser($user_id,$user_name) {
        return Link::make($user_name)->route(
            'platform.systems.users.edit',
            $user_id
        );
    }


    public function creatorLink(){
        return $this->linkToUser($this->created_by,$this->entity->creator->name,);
    }

    public function updaterLink(){
        return $this->linkToUser($this->updated_by,$this->entity->updater->name);
    }

}