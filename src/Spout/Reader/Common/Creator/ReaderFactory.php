<?php

namespace WilsonGlasser\Spout\Reader\Common\Creator;

use WilsonGlasser\Spout\Common\Creator\HelperFactory;
use WilsonGlasser\Spout\Common\Exception\IOException;
use WilsonGlasser\Spout\Common\Exception\UnsupportedTypeException;
use WilsonGlasser\Spout\Common\Type;
use WilsonGlasser\Spout\Reader\CSV\Creator\InternalEntityFactory as CSVInternalEntityFactory;
use WilsonGlasser\Spout\Reader\CSV\Manager\OptionsManager as CSVOptionsManager;
use WilsonGlasser\Spout\Reader\CSV\Reader as CSVReader;
use WilsonGlasser\Spout\Reader\ODS\Creator\HelperFactory as ODSHelperFactory;
use WilsonGlasser\Spout\Reader\ODS\Creator\InternalEntityFactory as ODSInternalEntityFactory;
use WilsonGlasser\Spout\Reader\ODS\Creator\ManagerFactory as ODSManagerFactory;
use WilsonGlasser\Spout\Reader\ODS\Manager\OptionsManager as ODSOptionsManager;
use WilsonGlasser\Spout\Reader\ODS\Reader as ODSReader;
use WilsonGlasser\Spout\Reader\ReaderInterface;
use WilsonGlasser\Spout\Reader\XLSX\Creator\HelperFactory as XLSXHelperFactory;
use WilsonGlasser\Spout\Reader\XLSX\Creator\InternalEntityFactory as XLSXInternalEntityFactory;
use WilsonGlasser\Spout\Reader\XLSX\Creator\ManagerFactory as XLSXManagerFactory;
use WilsonGlasser\Spout\Reader\XLSX\Manager\OptionsManager as XLSXOptionsManager;
use WilsonGlasser\Spout\Reader\XLSX\Manager\SharedStringsCaching\CachingStrategyFactory;
use WilsonGlasser\Spout\Reader\XLSX\Reader as XLSXReader;

/**
 * Class ReaderFactory
 * This factory is used to create readers, based on the type of the file to be read.
 * It supports CSV, XLSX and ODS formats.
 */
class ReaderFactory
{
    /**
     * Map file extensions to reader types
     * @var array
     */
    private static $extensionReaderMap = [
        'csv' => Type::CSV,
        'ods' => Type::ODS,
        'xlsx' => Type::XLSX,
    ];

    /**
     * This creates an instance of the appropriate reader, given the type of the file to be read
     *
     * @param  string $readerType Type of the reader to instantiate
     * @throws \WilsonGlasser\Spout\Common\Exception\UnsupportedTypeException
     * @return ReaderInterface
     */
    public static function create($readerType)
    {
        switch ($readerType) {
            case Type::CSV: return self::getCSVReader();
            case Type::XLSX: return self::getXLSXReader();
            case Type::ODS: return self::getODSReader();
            default:
                throw new UnsupportedTypeException('No readers supporting the given type: ' . $readerType);
        }
    }

    /**
     * Creates a reader by file extension
     *
     * @param string The path to the spreadsheet file. Supported extensions are .csv,.ods and .xlsx
     * @throws \WilsonGlasser\Spout\Common\Exception\IOException
     * @throws \WilsonGlasser\Spout\Common\Exception\UnsupportedTypeException
     * @return ReaderInterface
     */
    public static function createFromFile(string $path)
    {
        if (!\is_file($path)) {
            throw new IOException(
                sprintf('Could not open "%s" for reading! File does not exist.', $path)
            );
        }

        $ext = \pathinfo($path, PATHINFO_EXTENSION);
        $ext = \strtolower($ext);
        $readerType = self::$extensionReaderMap[$ext] ?? null;
        if ($readerType === null) {
            throw new UnsupportedTypeException(
                sprintf('No readers supporting the file extension "%s".', $ext)
            );
        }

        return self::create($readerType);
    }

    /**
     * @return CSVReader
     */
    private static function getCSVReader()
    {
        $optionsManager = new CSVOptionsManager();
        $helperFactory = new HelperFactory();
        $entityFactory = new CSVInternalEntityFactory($helperFactory);
        $globalFunctionsHelper = $helperFactory->createGlobalFunctionsHelper();

        return new CSVReader($optionsManager, $globalFunctionsHelper, $entityFactory);
    }

    /**
     * @return XLSXReader
     */
    private static function getXLSXReader()
    {
        $optionsManager = new XLSXOptionsManager();
        $helperFactory = new XLSXHelperFactory();
        $managerFactory = new XLSXManagerFactory($helperFactory, new CachingStrategyFactory());
        $entityFactory = new XLSXInternalEntityFactory($managerFactory, $helperFactory);
        $globalFunctionsHelper = $helperFactory->createGlobalFunctionsHelper();

        return new XLSXReader($optionsManager, $globalFunctionsHelper, $entityFactory, $managerFactory);
    }

    /**
     * @return ODSReader
     */
    private static function getODSReader()
    {
        $optionsManager = new ODSOptionsManager();
        $helperFactory = new ODSHelperFactory();
        $managerFactory = new ODSManagerFactory();
        $entityFactory = new ODSInternalEntityFactory($helperFactory, $managerFactory);
        $globalFunctionsHelper = $helperFactory->createGlobalFunctionsHelper();

        return new ODSReader($optionsManager, $globalFunctionsHelper, $entityFactory);
    }
}
