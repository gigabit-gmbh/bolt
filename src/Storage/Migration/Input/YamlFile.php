<?php

namespace Bolt\Storage\Migration\Input;

use Bolt\Storage\Migration\Import;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

/**
 * YAML import file.
 *
 * @author Gawain Lynch <gawain.lynch@gmail.com>
 */
class YamlFile implements InputFileInterface
{
    /** @var Import $import */
    private $import;

    /** @var \SplFileInfo $file */
    private $file;

    /** @var \Symfony\Component\Yaml\Parser */
    private $parser;

    /**
     * Constructor.
     *
     * @param Import       $import
     * @param \SplFileInfo $file
     */
    public function __construct(Import $import, \SplFileInfo $file)
    {
        $this->import = $import;
        $this->file   = $file;

        // Get a new YAML parser
        $this->parser = new Parser();
    }

    /**
     * {@inheritdoc}
     */
    public function readFile()
    {
        $filename = (string) $this->file;
        if ($this->file->isReadable()) {
            try {
                $data = $this->parser->parse(file_get_contents($filename) . "\n");
                $this->import->setData($data);

                return true;
            } catch (ParseException $e) {
                $this->import
                    ->setError(true)
                    ->setErrorMessage("File '$filename' has invalid YAML!");

                return false;
            }
        } else {
            $this->import
                ->setError(true)
                ->setErrorMessage("File '$filename' not readable!");

            return false;
        }
    }
}
