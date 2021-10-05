<?php

namespace Kamansoft\Klorchid\Database\Seeders;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class CsvSeeder extends \Illuminate\Database\Seeder
{

    static public $models_namespace="App\Models";
    static public $csv_separator = ";";
    static public $common_extra_fields= [];


    /**
     *
     * @return array|string[]
     */
    public function getCsvFilePaths(): array
    {
        if (isset($this->files) and !empty($this->files)) {
            if (is_string($this->files)) {
                return [$this->files];
            }
            if (is_array($this->files)) {
                return $this->files;
            }
            $message = static::class . ' the "file" attribute does not have a valid type. valid types are string or array';
            Log::error($message);
            throw \Exception($message);
        }
        $class_name_segments = explode('\\', static::class);
        $csv_file_name = Str::snake(Str::plural(str_replace("Seeder", "", end($class_name_segments))));
        return [static::getCsvSeedersPath($csv_file_name . ".csv")];
    }


    /**
     * A helper method to get the name of the class related to this seeder class
     * @return string
     */
    public function getModelClass()
    {
        if (isset($this->model) and !empty($this->model)) {
            return $this->model;
        }
        $class_name_segments = explode('\\', static::class);
        $class_name = str_replace("Seeder", "", end($class_name_segments));
        return static::$models_namespace."\\".$class_name;
    }

    /**
     * A helper method to retrive a  string using the name of the seeder class
     * @return string
     */
    public static function getCsvSeedersPath(string $filename): string
    {
        $relative_file_path = implode(DIRECTORY_SEPARATOR, [
            "database",
            "seeders",
            "csv",
            $filename,
        ]);
        return base_path($relative_file_path);
    }

    /**
     * fire the seeding pross from an files array
     * @throws \Exception
     */
    public function runWithCsv()
    {


        DB::beginTransaction();
        try {
            foreach ($this->getCsvFilePaths() as $file) {
                $this->populateFromCsv($file);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = static::class." cant run seeder with csv file.   Error: ".$e->getMessage();
            Log::error($message);
            throw new \Exception($message);

        }

    }

    /**
     * @param string $file the full path to csv
     * @return void
     */
    private function populateFromCsv(string $file)
    {

        $this->command->line("");
        $this->command->line("Attempt to seed using csv:");
        $this->command->line($file);
        $model = $this->getModelClass();
        $this->command->line("With model:");
        $this->command->line($model);
        $toral_rows = csv_count($file);
        $file = fopen($file, "r");
        $this->command->getOutput()->progressStart($toral_rows);
        $firstline = true;
        $columns = [];
        while (($data = fgetcsv($file, 2000, static::$csv_separator)) !== FALSE) {
            if ($firstline) {
                $columns = $data;
                $firstline = false;
                continue;
            }
            try {
                $data_with_keys = array_combine($columns, $data);
            }
            catch (\Exception $e){

                throw new  \Exception("The seeder needs the first line of the csv as header for columns. Using (".static::$csv_separator.") as separator. It looks like the csv header columns  doesnt match with the columns of one row of the csv. ".$e->getMessage() );
            }

            $model::updateOrCreate(array_merge($data_with_keys,static::$common_extra_fields));
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        fclose($file);


    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->runWithCsv();
    }

}
