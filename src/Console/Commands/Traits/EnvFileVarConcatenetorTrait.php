<?php

namespace Kamansoft\Klorchid\Console\Commands\Traits;

trait EnvFileVarConcatenetorTrait
{
    private function envConstantExists(string $constant): bool
    {
        $str = $this->fileGetContent(app_path('../.env'));
        return !($str !== false && strpos($str, $constant) === false);
    }

    /**
     * @param string $constant
     * @param string $value
     * @return self
     * @throws Exception
     */
    private function setEnvValue(string $constant, string $value = 'null'): self
    {
        $this->info("Atempt to set $constant=$value to .env file");
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && strpos($str, $constant) === false) {
            file_put_contents(app_path('../.env'), $str . PHP_EOL . $constant . '=' . $value . PHP_EOL);
        } else {
            throw new Exception('Cant add ' . $constant . ' entry on the project´s .env  file you must  remove it  by hand');
        }

        $this->info("Constant successfully added to file");
        return $this;
    }

    /**
     * @param string $file
     *
     * @return false|string
     */
    private function fileGetContent(string $file)
    {
        if (!is_file($file)) {
            throw new Exception(static::class. " $file is not a file");
        }

        return file_get_contents($file);
    }
}