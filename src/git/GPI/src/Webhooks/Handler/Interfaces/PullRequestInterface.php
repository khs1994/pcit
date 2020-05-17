<?php

declare(strict_types=1);

namespace PCIT\GPI\Webhooks\Handler;

interface PullRequestInterface
{
    public function handle(string $webhooks_content): void;
}
