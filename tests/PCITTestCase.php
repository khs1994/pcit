<?php

declare(strict_types=1);

namespace Tests;

use Dotenv\Dotenv;
use Exception;
use PCIT\Foundation\Testing\TestCase as BaseTestCase;
use PCIT\PCIT;

abstract class PCITTestCase extends BaseTestCase
{
    private static $test;

    /**
     * @param array  $config
     * @param string $git_type
     *
     * @return PCIT
     *
     * @throws Exception
     */
    public static function getTest(array $config = [], string $git_type = null)
    {
        if (!(self::$test instanceof PCIT)) {
            self::$test = new PCIT($config, $git_type ?? 'github');
        }

        return self::$test;
    }

    /**
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     *
     * @throws Exception
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        if (file_exists(base_path().'.env.testing')) {
            (Dotenv::create(base_path(), '.env.testing'))->load();
        }

        parent::__construct($name, $data, $dataName);
    }
}
