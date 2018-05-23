<?php

namespace NickSynev\MakeObserverCommand;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeObserver extends Command
{
    const CONST_VALID_METHODS = ['creating', 'created', 'updating', 'updated', 'deleting', 'deleted'];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:observer {name} {model} {--methods=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new observer class';

    protected $methods = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $makeMethods = $this->makeMethods();

        $observerName = $this->argument('name');

        if ($makeMethods === false) {

            $this->error('Method is not allowed!');

            return false;
        }

        $observersDir = app_path('Observers');

        if (!File::exists($observersDir)) {

            File::makeDirectory($observersDir);

        }

        if (File::exists($observersDir . "/{$observerName}.php")) {

            if (!$this->confirm('Observer already exists, do you wish to override it?')) {

                return false;

            } else {

                File::delete($observersDir . '/' . $observerName . '.php');

                $this->addObserverToDirectory($this->methods);

                return false;
            }
        }

        $observerName = explode("/", $observerName);

        for ($i = 0; $i < count($observerName); $i++) {

            if ($i != count($observerName) - 1) {

                if (!file_exists($observersDir . '/' . $observerName[$i])) {

                    File::makeDirectory($observersDir . '/' . $observerName[$i]);

                }

                $observersDir = $observersDir . '/' . $observerName[$i];
            }
        }

        $this->addObserverToDirectory($this->methods);
    }

    private function makeMethods()
    {
        $methods = $this->options()['methods'] != null ? explode(',', $this->options()['methods']) : null;

        if ($methods) {

            foreach ($methods as $method) {

                if (!in_array($method, self::CONST_VALID_METHODS)) {

                    return false;

                } else {

                    array_push($this->methods, $method);
                }
            }

            return true;
        }
    }

    private function addObserverToDirectory($methods = [])
    {
        $observerDirectory = $this->argument('name');

        $observerName = explode("/", $this->argument('name'));

        if (count($observerName) > 1) {

            $observerNameForNamespace = end($observerName);

            $observerName = studly_case($observerNameForNamespace);

            $observerNamespace = str_replace("/", '\\', $observerDirectory);

            $observerNamespace = 'App\\Observers\\' . str_replace('\\' . $observerNameForNamespace, '', $observerNamespace);

        } else {
            $observerNamespace = 'App\\Observers';

            $observerName = implode("/", $observerName);
        }

        $observerModel = $this->argument('model');

        $observerModelInjection = explode("\\", $observerModel);

        $observerModelInjection = end($observerModelInjection) . " $" . camel_case(end($observerModelInjection));

        $observerStub = file_get_contents(__DIR__ . '/Stubs/Observer/' . 'observer.stub', true);

        $observerContent = '';

        $methods = $methods ?: self::CONST_VALID_METHODS;

        foreach ($methods as $method) {

            if ($method === end($methods)) {

                $observerContent .= file_get_contents(__DIR__ . '/Stubs/Observer/Methods/' . $method . '.stub', true) . "\n";

                break;
            }

            $observerContent .= file_get_contents(__DIR__ . '/Stubs/Observer/Methods/' . $method . '.stub', true) . "\n\n";
        }

        $dummyStrings = ['DummyNamespace', 'DummyClass', 'DummyContent', 'DummyModel', 'Injection'];

        $observerInputs = [$observerNamespace, $observerName, $observerContent, $observerModel, $observerModelInjection];

        $observerText = str_replace($dummyStrings, $observerInputs, $observerStub);

        if (File::put(app_path('Observers' . '/' . $observerDirectory . '.php'), $observerText)) {

            $this->info('Observer was successfully created');

        } else {

            $this->error('Observer was not created!');

        }
    }
}
