<?php

namespace Kamansoft\Klorchid\Database\Seeders;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class CsvSeeder extends \Illuminate\Database\Seeder
{

    static public $models_namespace = "App\Models";
    static public $csv_separator = ";";
    static public $common_extra_fields = [];

    abstract public function handleCsvRow(array $data): array;

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
        //return [static::getCsvSeedersPath($csv_file_name . ".csv")];
        return [$csv_file_name . ".csv"];
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
        return static::$models_namespace . "\\" . $class_name;
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

    public function handleFullFilePath(string $file)
    {
        if (file_exists(static::getCsvSeedersPath($file))) {
            return static::getCsvSeedersPath($file);
        }
        if (file_exists($file)) {
            return $file;
        }

        throw \Exception(static::class . " can't find the file: " . $file . " inside the csv seeders folder, or in the project folder. Make sure the file exits ");
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
                $this->populateFromCsv($this->handleFullFilePath($file));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = static::class . " cant run seeder with csv file.   Error: " . $e->getMessage();
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
        $time_start = microtime(true);
        $this->command->line("");
        $this->command->line("Attempt to seed using csv:");
        $this->command->line($file);
        $model = $this->getModelClass();
        $this->command->line("With model:");
        $this->command->line($model);
        $toral_rows = csv_count($file) - 1;

        /*
        $chunk_size = 4;
        $total_chunks = ceil($toral_rows/$chunk_size);
        $chunk_count = $total_count = 1;
        $chunk = [];
        */

        if ($toral_rows > 1) {

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
                    $data_to_store = $this->handleCsvRow($data_with_keys);
                } catch (\Exception $e) {

                    throw new  \Exception("The seeder needs the first line of the csv as header for columns. Using (" . static::$csv_separator . ") as separator. It looks like the csv header columns  doesnt match with the columns of one row of the csv. " . $e->getMessage());
                }
                /*
                $fill_chunk=$total_count<$chunk_count*$chunk_size;
                if ($fill_chunk){
                    $chunk[] = $data_to_store;
                }

                $persit_chunk=!($fill_chunk) or $total_count == $toral_rows;

                if ($persit_chunk) {
                    $chunk[] = $data_to_store;
                    $model::updateOrCreate(...$chunk);
                    $chunk = [];
                    $chunk_count++;
                }*/

                //dd($data_to_store);

                $model::updateOrCreate($data_to_store);
                //$total_count ++;
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();

            fclose($file);
            $time_elapsed_secs = microtime(true) - $time_start;
            $this->command->line("Single File Processed. (" . ($time_elapsed_secs * 1000) . 'ms)');
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runWithCsv();
    }
}
