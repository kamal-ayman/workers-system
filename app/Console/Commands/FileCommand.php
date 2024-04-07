<?php
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
abstract class FileCommand extends Command
{
    protected $file, $stub_name, $folder_path, $suffix_name;
    public function __construct($stub_name, $folder_path, $suffix_name) {
        parent::__construct();
        $this->file = new Filesystem();
        $this->stub_name = $stub_name;
        $this->folder_path = $folder_path;
        $this->suffix_name = $suffix_name;
    }
    public function makeDir($filePath) {
        $dirPath = dirname($filePath);
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777);
        }
    }
    public function className() {
        $class_name = $this->argument('CLASS_NAME') . $this->suffix_name;
        return ucwords(Pluralizer::singular($class_name));
    }
    public function stubVars() {
        $proccessName = $this->className();
        return [
            'CLASS_NAME'=> $proccessName,
            'NAME_SPACE'=> 'App\\'. $this->folder_path,
        ];
    }
    public function stubContent() {
        $stubPath = __DIR__ .'/../../../stubs/'. $this->stub_name .'.stub';
        $content = file_get_contents($stubPath);
        $stubVars = $this->stubVars();
        foreach ($stubVars as $key => $value) {
            $content = str_replace($key, $value, $content);
        }
        return $content;
    }
    public function getFilePath() {
        return base_path('App\\'. $this->folder_path .'\\') . $this->className() . '.php';
    }    public function generateFile($filePath) {
        $content = $this->stubContent();
        $this->file->put($filePath, $content);
        $this->info('this file has been created');
    }
    public function createFile($filePath) {
        $force = $this->option()['force']??false;
        $isExsits = $this->file->exists($filePath);
        if (!$isExsits) {
            $this->generateFile($filePath);
        } else if ($force) {
            $this->file->delete($filePath);
            $this->generateFile($filePath);
        } else {
            $this->info('file is alreay exists!!');
        }
    }
    public function handle()
    {
        $filePath = $this->getFilePath();
        $this->makeDir($filePath);
        $this->createFile($filePath);
    }
}

