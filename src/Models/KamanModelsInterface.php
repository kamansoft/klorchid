<?php


namespace Kamansoft\Klorchid\Models;


use Illuminate\Http\Request;

interface KamanModelsInterface
{


    public function getCreateValidationRules(Request $request):array ;
    public function getEditValidationRules(Request $request):array ;



}
