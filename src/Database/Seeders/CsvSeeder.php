<?php

namespace Kamansoft\Klorchid\src\Database\Seeders;

use Illuminate\Support\Facades\Log;

abstract class CsvSeeder extends \Illuminate\Database\Seeder
{

    /**
     *
     * @return array|string[]
     */
    public function getCsvFilePaths(): array
    {
        if (isset($this->file) and !empty($this->file)) {
            if (is_string($this->file)) {
                return [$this->file];
            }
            if (is_array($this->file)) {
                return $this->file;
            }
            $message = static::class . ' the "file" attribute does not have a valid type. valid types are string or array';
            Log::error($message);
            throw \Exception($message);
        }
        $class_name_segments = explode('\\', static::class);
        $class_name = Str::snake(Str::plural(str_replace("Seeder", "", end($class_name_segments))));
        return [static::getCsvSeedersPath($class_name . ".csv")];
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
        return 'App\Models\\' . $class_name;
    }

    /**
     * A helper method to retrive a  string using the name of the seeder class
     * @return string
     */
    public static function getCsvSeedersPath(): string
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
            $message = static::class." cant run seeder with csv file ".$e->getMessage();
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
        while (($data = fgetcsv($file, 2000, ";")) !== FALSE) {
            if ($firstline) {
                $columns = $data;
                $firstline = false;
                continue;
            }
            $data = collect($data)->mapWithKeys(function ($value, $index) use ($columns) {
                return [$columns[$index] => $value];
            })->toArray();
            $model::updateOrCreate($data);
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
