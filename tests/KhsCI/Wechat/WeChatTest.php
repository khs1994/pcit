<?php

declare(strict_types=1);

namespace KhsCI\Tests\Wechat;

use PHPUnit\Framework\TestCase;
use WeChat\Support\Encrypt;

class WeChatTest extends TestCase
{
    /**
     * @group DON'TTEST
     */
    public function test(): void
    {
        $a = Encrypt::get('khs1994');
    }
}
