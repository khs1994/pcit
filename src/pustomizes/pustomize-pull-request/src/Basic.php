<?php

declare(strict_types=1);

namespace PCIT\Pustomize\PullRequest;

use App\GetAccessToken;
use PCIT\GitHub\Webhooks\Parser\PullRequestContext;
use PCIT\PCIT;
use PCIT\Pustomize\Interfaces\PullRequest\BasicInterface;

class Basic implements BasicInterface
{
    /** @var PullRequestContext */
    public $context;

    public function handle(PullRequestContext $context): void
    {
        $this->context = $context;

        if ('opened' !== $context->action) {
            return;
        }

        $comment_body = <<<'EOF'
Repo administrator can comment `/LGTM` or `/LGTM <type>`, I will merge this Pull_request.

> /LGTM
> /LGTM rebase
> /LGTM squash

---

This Comment has been generated by [PCIT Bot](https://github.com/pcit-ce/pcit).

EOF;

        $this->sendComment($comment_body);
    }

    private function sendComment(string $comment_body): void
    {
        (new PCIT(['github_access_token' => GetAccessToken::getGitHubAppAccessToken($this->context->rid)]))
            ->issue_comments
            ->create(
                $this->context->repo_full_name,
                (int) $this->context->pull_request_number,
                $comment_body
            );
    }
}
