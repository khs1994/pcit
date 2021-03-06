<?php

declare(strict_types=1);

namespace PCIT\Gitee\Service\Webhooks;

use PCIT\GPI\Service\Webhooks\ServerAbstract;

class Server extends ServerAbstract
{
    protected $git_type = 'gitee';

    public function server()
    {
        $this->verify('X-Gitee-Token');

        $event_type = $this->getEventType('X-Gitee-Event');

        return $this->storeAfterVerify($event_type);
    }

    public function verify(string $signature_header): void
    {
        if (config('git.webhooks.token') === \Request::headers()->get($signature_header)) {
            return;
        }

        throw new \Exception('', 402);
    }
}
