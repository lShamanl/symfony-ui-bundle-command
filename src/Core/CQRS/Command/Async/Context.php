<?php

declare(strict_types=1);

namespace SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Async;

use SymfonyBundle\UIBundle\Foundation\Core\Components\AbstractContext;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\CommandInterface;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\HandlerInterface;

class Context extends AbstractContext
{
    protected ?HandlerInterface $handler;
    protected CommandInterface $command;
    private string $outputFormat;

    public function __construct(
        CommandInterface $command,
        string $outputFormat,
        HandlerInterface $handler = null,
    ) {
        $this->handler = $handler;
        $this->command = $command;
        $this->outputFormat = $outputFormat;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    public function getCommand(): CommandInterface
    {
        return $this->command;
    }

    public function setCommand(CommandInterface $command): self
    {
        $this->command = $command;
        return $this;
    }

    public function getHandler(): ?HandlerInterface
    {
        return $this->handler;
    }

    public function setHandler(?HandlerInterface $handler): self
    {
        $this->handler = $handler;
        return $this;
    }
}
