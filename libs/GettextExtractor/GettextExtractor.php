<?php

if (version_compare(PHP_VERSION, '5.2.2', '<'))
    exit('GettextExtractor needs PHP 5.2.2 or newer');

class GettextExtractor
{
    const LOG_FILE = '/extractor.log';
    public $logHandler;
    
    public $outputFile;
    public $inputFiles = array();
    
    public $filters = array(
        'php' => array('PHP'),
        'phtml'	=> array('PHP', 'NetteCurlyBrackets')
    );
    
    public $pluralMatchRegexp = '#\%([0-9]+\$)*d#';
    
    public $data = array();
    
    protected $filterStore = array();
    
    /* ----------- Mandatory functions ---------- */
    
    public function __construct()
    {
        $this->logHandler = fopen(dirname(__FILE__) . self::LOG_FILE, "w");
    }
    
    public function __destruct()
    {
        if (is_resource($this->logHandler)) fclose($this->logHandler);
    }
    
    public function log($message)
    {
        if (is_resource($this->logHandler)) {
            fwrite($this->logHandler, $message . "\n");
        }
    }
    
    protected function throwException()
    {
        $message = 'Something unexpected occured. See GettextExtractor log for details';
        echo $message;
        throw new Exception($message);
    }
    
    /* ------------ Extractor functions ----------- */
    
    public function extract($inputFiles)
    {
        foreach ($inputFiles as $inputFile)
        {
            if (!file_exists($inputFile)) {
                $this->log('ERROR: Invalid input file specified: ' . $inputFile);
                $this->throwException();
            }
            if (!is_readable($inputFile)) {
                $this->log('ERROR: Input file is not readable: ' . $inputFile);
                $this->throwException();
            }
            
            $this->log('Extracting data from file ' . $inputFile);
            foreach ($this->filters as $extension => $filters)
            {
                // Check file extension
                if (substr($inputFile, strlen($inputFile) - strlen($extension)) != $extension) continue;
                
                $this->log('Processing file ' . $inputFile);
                
                foreach ($filters as $filterName)
                {
                    $filter = $this->getFilter($filterName);
                    $filterData = $filter->extract($inputFile);
                    $this->log('  Filter ' . $filterName . ' applied');
                    $this->data = array_merge_recursive($this->data, $filterData);
                }
            }
        }
        
        $this->log('Data exported successfully');
        
        return $this->data;
    }
    
    public function getFilter($filter)
    {
        $filter = $filter . 'Filter';
        
        if (isset($this->filterStore[$filter])) return $this->filterStore[$filter];
        
        if (!class_exists($filter)) {
            $filter_file = dirname(__FILE__) . '/Filters/' . $filter . ".php";
            if (!file_exists($filter_file)) {
                $this->log('ERROR: Filter file ' . $filter_file . ' not found');
                $this->throwException();
            }
            require_once $filter_file;
            if (!class_exists($filter)) {
                $this->log('ERROR: Class ' . $filter . ' not found');
                $this->throwException();
            }
        }
        
        $this->filterStore[$filter] = new $filter;
        $this->log('Filter ' . $filter . ' loaded');
        return $this->filterStore[$filter];
    }
    
    public function write($outputFile, $data = null) {
        $data = $data ? $data : $this->data;
        
        // Output file permission check
        if (file_exists($outputFile) && !is_writable($outputFile)) {
            $this->log('ERROR: Output file is not writable!');
            $this->throwException();
        }
        
        $handle = fopen($outputFile, "w");
        
        fwrite($handle, $this->formatData($data));
        
        fclose($handle);
        
        $this->log('Data written successfully');
        
        
    }
    
    protected function formatData($data)
    {
        $output = array();
        $output[] = '# Gettext keys exported by GettextExtractor';
        $output[] = 'msgid ""';
        $output[] = 'msgstr ""';
        $output[] = '"Content-Type: text/plain; charset=UTF-8\n"';
        $output[] = '"Plural-Forms: nplurals=2; plural=(n != 1);\n"';
        $output[] = '';
        
        ksort($data);
        
        foreach ($data as $key => $files)
        {
            ksort($files);
            foreach ($files as $file)
                $output[] = '# ' . $file;
            $output[] = 'msgid "' . addslashes($key) . '"';
            if (preg_match($this->pluralMatchRegexp, $key, $matches)) {
                $output[] = 'msgid_plural "' . addslashes($key) . '"';
                //$output[] = 'msgid_plural ""';
                $output[] = 'msgstr[0] "' . addslashes($key) . '"';
                $output[] = 'msgstr[1] "' . addslashes($key) . '"';
            } else {
                $output[] = 'msgstr "' . addslashes($key) . '"'; 
            }
            $output[] = '';
        }
        
        return join("\n", $output);
    }
}