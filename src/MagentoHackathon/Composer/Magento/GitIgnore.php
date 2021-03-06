<?php

namespace MagentoHackathon\Composer\Magento;

/**
 * Class GitIgnore
 * @package MagentoHackathon\Composer\Magento
 * @author  Aydin Hassan <aydin@hotmail.co.uk>
 */
class GitIgnore
{
    /**
     * @var array
     */
    protected $lines = array();

    /**
     * @var string|null
     */
    protected $gitIgnoreLocation;

    /**
     * @var bool
     */
    protected $hasChanges = false;

    /**
     * @param string $fileLocation
     */
    public function __construct($fileLocation)
    {
        $this->gitIgnoreLocation = $fileLocation;
        if (file_exists($fileLocation)) {
            $this->lines = array_flip(file($fileLocation, FILE_IGNORE_NEW_LINES));
        }
    }

    /**
     * @param string $file
     */
    public function addEntry($file)
    {
        if (!isset($this->lines[$file])) {
            $this->lines[$file] = $file;
        }
        $this->hasChanges = true;
    }

    /**
     * @param array $files
     */
    public function addMultipleEntries(array $files)
    {
        foreach ($files as $file) {
            $this->addEntry($file);
        }
    }

    /**
     * @param string $file
     */
    public function removeEntry($file)
    {
        if (isset($this->lines[$file])) {
            unset($this->lines[$file]);
            $this->hasChanges = true;
        }
    }

    /**
     * @param array $files
     */
    public function removeMultipleEntries(array $files)
    {
        foreach ($files as $file) {
            $this->removeEntry($file);
        }
    }

    /**
     * @return array
     */
    public function getEntries()
    {
        return array_values(array_flip($this->lines));
    }

    /**
     * Write the file
     */
    public function write()
    {
        if ($this->hasChanges) {
            file_put_contents($this->gitIgnoreLocation, implode("\n", array_flip($this->lines)));
        }
    }
}
