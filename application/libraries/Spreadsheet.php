<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet as PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
require_once 'vendor/autoload.php';
class Spreadsheet
{
    public function __construct()
    {
    }

    public function load($filePath)
    {
        return IOFactory::load($filePath);
    }
}
