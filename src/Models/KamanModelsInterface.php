<?php


namespace Kamansoft\Klorchid\Models;


use Illuminate\Http\Request;

interface KamanModelsInterface
{

    static public function statusStringValues():array;
    public function getStringStatusAttribute():string;
    public static function getTableName():string;
    static public function statusToString(bool $status):string;
    static public function stringToStatus(string $status):string;
    public function getStatusSetValidationRules(Request $request): array;
    public function getStatusToggleValidationRules(Request $request): array;
    public function statusSet(bool $status, string $reason):self;
    public function statusToggle(string $reason):self;
    public function invalidate():self;
    public function getCreateValidationRules(Request $request):array ;
    public function getEditValidationRules(Request $request):array ;



}
