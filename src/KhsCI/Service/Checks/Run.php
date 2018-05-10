<?php

declare(strict_types=1);

namespace KhsCI\Service\Checks;

use Curl\Curl;

class Run
{
    protected static $curl;

    private static $api_url;

    public function __construct(Curl $curl)
    {
        static::$curl = $curl;

        static::$api_url = 'https://api.github.com';
    }

    public function create(string $repo_full_name): void
    {
        $url = static::$api_url.'/repos/'.$repo_full_name.'/check-runs';
    }

    public function update(): void
    {
    }

    /**
     * List check runs for a specific ref.
     */
    public function listSpecificRef(): void
    {
    }

    /**
     * List check runs in a check suite.
     */
    public function listCheckSuite(): void
    {
    }

    /**
     * Get a single check run.
     */
    public function getSingle(): void
    {
    }

    /**
     * List annotations for a check run.
     */
    public function listAnnotations(): void
    {
    }
}