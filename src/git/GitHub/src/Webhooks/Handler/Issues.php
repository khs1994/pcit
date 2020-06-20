<?php

declare(strict_types=1);

namespace PCIT\GitHub\Webhooks\Handler;

use PCIT\GPI\Webhooks\Handler\Abstracts\IssuesAbstract;

class Issues extends IssuesAbstract
{
    public $git_type = 'github';

    public function handle(string $webhooks_content): void
    {
        $issuesContext = \PCIT\GitHub\Webhooks\Parser\Issues::handle($webhooks_content);

        $this->handleIssues($issuesContext, $this->git_type);
    }

    public function comment(string $webhooks_content): void
    {
        $context = \PCIT\GitHub\Webhooks\Parser\Issues::comment($webhooks_content);

        $this->handleComment($context, $this->git_type);
    }
}
