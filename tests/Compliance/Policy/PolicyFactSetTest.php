<?php

/**
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */
declare(strict_types=1);

namespace App\Complying\Tests\Compliance\Policy;

use App\Complying\DTO\PolicyFactSet;
use PHPUnit\Framework\TestCase;

final class PolicyFactSetTest extends TestCase
{
    public function testFromEvent(): void
    {
        $fs = PolicyFactSet::fromEvent('order.created', ['object_id' => 'o1']);
        $this->assertSame('order.created', $fs->action);
        $this->assertSame('o1', $fs->resource);
    }
}
