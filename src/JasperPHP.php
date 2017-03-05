<?php
namespace JasperPHP;

/**
 * Class JasperPHP
 *
 * @package JasperPHP
 */
class JasperPHP
{

    /**
     * @var string
     */
    protected $executable;

    /**
     * @var string
     */
    protected $path_executable;

    /**
     * @var bool
     */
    protected $windows;

    protected $the_command;

    protected $formats = ['pdf', 'rtf', 'xls', 'xlsx', 'docx', 'odt', 'ods', 'pptx', 'csv', 'html', 'xhtml', 'xml', 'jrprint'];

    /**
     * JasperPHP constructor
     */
    public function __construct()
    {
        $this->executable = 'jasperstarter';
        $this->path_executable = __DIR__ . '/../bin/jasperstarter/bin';
        $this->windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? true : false;
    }

    public static function __callStatic($method, $parameters)
    {
        // Create a new instance of the called class, in this case it is Post
        $model = get_called_class();

        // Call the requested method on the newly created object
        return call_user_func_array(array(new $model, $method), $parameters);
    }

    /**
     * @param $input_file
     * @param bool $output_file
     * @return $this
     * @throws Exception\InvalidInputFile
     */
    public function compile($input_file, $output_file = false)
    {
        if (!$input_file) {
            throw new \JasperPHP\Exception\InvalidInputFile();
        }

        $this->the_command = $this->windows ? $this->executable : './' . $this->executable;
        $this->the_command .= ' compile ';
        $this->the_command .= "\"$input_file\"";

        if ($output_file !== false) {
            $this->the_command .= ' -o ' . "\"$output_file\"";
        }

        return $this;
    }

    public function process($input_file, $output_file = false, $format = ['pdf'], $parameters = [], $db_connection = [], $locale = false)
    {
        if (is_null($input_file) || empty($input_file)) {
            throw new \Exception('No input file', 1);
        }

        if (is_array($format)) {
            foreach ($format as $key) {
                if (!in_array($key, $this->formats)) {
                    throw new \Exception('Invalid format!', 1);
                }
            }
        } else {
            if (!in_array($format, $this->formats)) {
                throw new \Exception('Invalid format!', 1);
            }
        }

        $command = ($this->windows) ? $this->executable : './' . $this->executable;

        $command .= ($locale) ? " --locale $locale" : '';

        $command .= ' process ';

        $command .= "\"$input_file\"";

        if ($output_file !== false) {
            $command .= ' -o ' . "\"$output_file\"";
        }

        if (is_array($format)) {
            $command .= ' -f ' . join(' ', $format);
        } else {
            $command .= ' -f ' . $format;
        }

        if (count($parameters) > 0) {
            $command .= ' -P ';

            foreach ($parameters as $key => $value) {
                $param = $key . '="' . $value . '" ';
                $command .= " " . $param . " ";
            }

        }

        if (count($db_connection) > 0) {
            $command .= ' -t ' . $db_connection['driver'];

            if (isset($db_connection['username'])) {
                $command .= " -u " . $db_connection['username'];
            }

            if (isset($db_connection['password']) && !empty($db_connection['password'])) {
                $command .= ' -p ' . $db_connection['password'];
            }

            if (isset($db_connection['host']) && !empty($db_connection['host'])) {
                $command .= ' -H ' . $db_connection['host'];
            }

            if (isset($db_connection['database']) && !empty($db_connection['database'])) {
                $command .= ' -n ' . $db_connection['database'];
            }

            if (isset($db_connection['port']) && !empty($db_connection['port'])) {
                $command .= ' --db-port ' . $db_connection['port'];
            }

            if (isset($db_connection['jdbc_driver']) && !empty($db_connection['jdbc_driver'])) {
                $command .= ' --db-driver ' . $db_connection['jdbc_driver'];
            }

            if (isset($db_connection['jdbc_url']) && !empty($db_connection['jdbc_url'])) {
                $command .= ' --db-url ' . $db_connection['jdbc_url'];
            }

            if (isset($db_connection['jdbc_dir']) && !empty($db_connection['jdbc_dir'])) {
                $command .= ' --jdbc-dir ' . $db_connection['jdbc_dir'];
            }

            if (isset($db_connection['db_sid']) && !empty($db_connection['db_sid'])) {
                $command .= ' --db-sid ' . $db_connection['db_sid'];
            }

            if (isset($db_connection['xml_xpath'])) {
                $command .= ' --xml-xpath ' . $db_connection['xml_xpath'];
            }

            if (isset($db_connection['data_file'])) {
                $command .= ' --data-file ' . $db_connection['data_file'];
            }

            if (isset($db_connection['json_query'])) {
                $command .= ' --json-query ' . $db_connection['json_query'];
            }
        }

        $this->the_command = $command;

        return $this;
    }

    public function list_parameters($input_file)
    {
        if (is_null($input_file) || empty($input_file)) {
            throw new \Exception('No input file', 1);
        }

        $command = ($this->windows) ? $this->executable : './' . $this->executable;

        $command .= ' list_parameters ';

        $command .= "\"$input_file\"";

        $this->the_command = $command;

        return $this;
    }

    public function output()
    {
        return $this->the_command;
    }

    /**
     * @param bool $user
     * @return mixed
     * @throws Exception\InvalidCommandExecutable
     * @throws Exception\InvalidResourceDirectory
     * @throws Exception\ErrorCommandExecutable
     */
    public function execute($user = false)
    {
        $this->validateExecute();
        $this->addUserToCommand($user);

        $command = $this->the_command;
        $output = [];
        $return_var = 0;

        chdir($this->path_executable);
        exec($command, $output, $return_var);
        if ($return_var !== 0) {
            throw new \JasperPHP\Exception\ErrorCommandExecutable();
        }

        return $output;
    }

    /**
     * @param $user
     */
    protected function addUserToCommand($user)
    {
        if ($user && !$this->windows) {
            $this->the_command = 'su -u ' . $user . " -c \"" . $this->the_command . "\"";
        }
    }

    /**
     * @throws Exception\InvalidCommandExecutable
     * @throws Exception\InvalidResourceDirectory
     */
    protected function validateExecute()
    {
        if (!$this->the_command) {
            throw new \JasperPHP\Exception\InvalidCommandExecutable();
        }
        if (!is_dir ($this->path_executable)) {
            throw new \JasperPHP\Exception\InvalidResourceDirectory();
        }

    }

}