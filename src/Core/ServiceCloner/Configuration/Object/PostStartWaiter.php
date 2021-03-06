<?php

declare(strict_types=1);

namespace App\Core\ServiceCloner\Configuration\Object;

final class PostStartWaiter
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $expression;

    /**
     * @var int
     */
    private $timeout;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function setExpression(string $expression): void
    {
        $this->expression = $expression;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }
}
