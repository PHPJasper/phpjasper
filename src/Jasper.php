<?php
namespace XiDanko\Jasper;

use XiDanko\Jasper\Exception\ErrorCommandExecutable;
use XiDanko\Jasper\Exception\InvalidCommandExecutable;
use XiDanko\Jasper\Exception\InvalidFormat;
use XiDanko\Jasper\Exception\InvalidInputFile;
use XiDanko\Jasper\Exception\InvalidResourceDirectory;

class Jasper
{
    protected string $command;
    protected string $executable;
    protected string $pathExecutable;
    protected bool $windows;
    protected array $formats = [
        'pdf',
        'rtf',
        'xls',
        'xlsx',
        'docx',
        'odt',
        'ods',
        'pptx',
        'csv',
        'html',
        'xhtml',
        'xml',
        'jrprint'
    ];

    public function __construct(string $pathExecutable = null)
    {
        $this->executable = 'jasperstarter';
        $this->pathExecutable = $pathExecutable ?? __DIR__ . '/../bin/jasperstarter/bin';
        $this->windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? true : false;
    }

    private function checkServer(): string
    {
        return $this->command = $this->windows ? $this->executable : './' . $this->executable;
    }

    public function compile(string $input, string $output = ''): Jasper
    {
        if (!is_file($input)) {
            throw new InvalidInputFile();
        }

        $this->command = $this->checkServer();
        $this->command .= ' compile ';
        $this->command .= '"' . realpath($input) . '"';

        if (!empty($output)) {
            $this->command .= ' -o ' . "\"$output\"";
        }

        return $this;
    }

    public function process(string $input, string $output, array $options = []): Jasper
    {
        $options = $this->parseProcessOptions($options);

        if (!$input) {
            throw new InvalidInputFile();
        }

        $this->validateFormat($options['format']);

        $this->command = $this->checkServer();

        if ($options['locale']) {
            $this->command .= " --locale {$options['locale']}";
        }

        $this->command .= ' process ';
        $this->command .= "\"$input\"";
        $this->command .= ' -o ' . "\"$output\"";

        $this->command .= ' -f ' . join(' ', $options['format']);

        if ($options['params']) {
            $this->command .= ' -P ';
            foreach ($options['params'] as $key => $value) {
                $this->command .= " " . $key . '="' . $value . '" ' . " ";
            }
        }

        if ($options['db_connection']) {
            $mapDbParams = [
                'driver' => '-t',
                'username' => '-u',
                'password' => '-p',
                'host' => '-H',
                'database' => '-n',
                'port' => '--db-port',
                'jdbc_driver' => '--db-driver',
                'jdbc_url' => '--db-url',
                'jdbc_dir' => '--jdbc-dir',
                'db_sid' => '--db-sid',
                'xml_xpath' => '--xml-xpath',
                'data_file' => '--data-file',
                'json_query' => '--json-query'
            ];

            foreach ($options['db_connection'] as $key => $value) {
                $this->command .= " {$mapDbParams[$key]} {$value}";
            }
        }

        if ($options['resources']) {
            $this->command .= " -r {$options['resources']}";
        }

        $this->command .= " 2>&1";

        return $this;
    }

    protected function parseProcessOptions(array $options): array
    {
        $defaultOptions = [
            'format' => ['pdf'],
            'params' => [],
            'resources' => false,
            'locale' => false,
            'db_connection' => []
        ];

        return array_merge($defaultOptions, $options);
    }

    protected function validateFormat($format): void
    {
        if (!is_array($format)) {
            $format = [$format];
        }

        foreach ($format as $value) {
            if (!in_array($value, $this->formats)) {
                throw new InvalidFormat();
            }
        }
    }

    public function listParameters(string $input): Jasper
    {
        if (!is_file($input)) {
            throw new InvalidInputFile();
        }

        $this->command = $this->checkServer();
        $this->command .= ' list_parameters ';
        $this->command .= '"' . realpath($input) . '"';

        return $this;
    }

    public function execute(bool $user = false): string
    {
        $this->validateExecute();
        $this->addUserToCommand($user);

        $output = [];
        $returnVar = 0;

        chdir($this->pathExecutable);
        exec($this->command, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new ErrorCommandExecutable(null, 0, null, $output);
        }

        return implode("\n", $output);
    }

    public function output(): string
    {
        return $this->command;
    }

    public function printOutput(): void
    {
        print $this->command . "\n";
    }

    protected function addUserToCommand($user): void
    {
        if ($user && !$this->windows) {
            $this->command = 'su -u ' . $user . " -c \"" . $this->command . "\"";
        }
    }

    protected function validateExecute(): void
    {
        if (!$this->command) {
            throw new InvalidCommandExecutable();
        }

        if (!is_dir($this->pathExecutable)) {
            throw new InvalidResourceDirectory();
        }
    }
}
