<?php


namespace DummyNamespace;


use App\Http\Requests\KlorchidTestStatusChangeRequest;
use App\Http\Requests\KlorchidTestStorableFormRequest;
use App\Klorchid\Layouts\KlorchidTestCrudFormLayout;
use DummyModelFullClassName;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreen;


class DummyClass extends KlorchidCrudScreen

{

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'DummyClass';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'DummyClass';

    /**
     * @var string
     */
    public $permission = [];


    public function permissionsGroupName(): string
    {
        return '';
    }

    public function collectionQuery()
    {
        return $this->collectionQuery(
            KlorchidTest::with('klorchidTestType')
                ->select('id', 'name', 'klorchid_test_type_id')
        );
    }

    public function query(KlorchidTest $klorchidTest)
    {

        $this->setModel($klorchidTest);
        $this->setMode('edit');




        $data = $this->getMode() === 'list' ?
            ["collection" =>$this->collectionQuery()->filters()->defaultSort()  ] :
            [self::$screen_query_model_keyname => $this->getModel()];

        return array_merge([self::$screen_query_mode_keyname => $this->getMode()],$data);
    }


    public function editModeLayout(): array
    {
        return [
            KlorchidTestCrudFormLayout::class
        ];
    }

    public function listModeLayout(): array
    {
        return [

        ];
    }

    public function store(KlorchidTest $klorchidtest, KlorchidTestStorableFormRequest $request)
    {
        $request->store($klorchidtest);
    }

    public function statusChange(KlorchidTest $klorchidtest, KlorchidTestStatusChangeRequest $request)
    {
        $request->statusChange($klorchidtest);
    }

}
