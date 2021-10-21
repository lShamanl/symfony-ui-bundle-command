<?php

declare(strict_types=1);

namespace SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Sync;

use SymfonyBundle\UIBundle\Foundation\Core\Components\AbstractContext;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\CommandInterface;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\HandlerInterface;
use SymfonyBundle\UIBundle\Foundation\Core\Dto\Locale;
use SymfonyBundle\UIBundle\Foundation\Core\Dto\TranslationDto;

class Context extends AbstractContext
{
    protected HandlerInterface $handler;
    protected CommandInterface $command;
    protected array $translations;
    protected ?Locale $locale;
    protected string $outputFormat;

    public function __construct(
        HandlerInterface $handler,
        CommandInterface $command,
        string $outputFormat,
        array $translations = [],
        ?Locale $locale = null,
    ) {
        $this->command = $command;
        $this->handler = $handler;
        $this->outputFormat = $outputFormat;
        $this->translations = $translations;
        $this->locale = $locale;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    public function setOutputFormat(string $outputFormat): self
    {
        $this->outputFormat = $outputFormat;
        return $this;
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function setTranslations(TranslationDto $translations): self
    {
        $this->translations = $translations->getRules();
        return $this;
    }

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(Locale $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    public function hasLocale(): bool
    {
        return $this->locale !== null;
    }

    public function getHandler(): HandlerInterface
    {
        return $this->handler;
    }

    public function setHandler(HandlerInterface $handler): self
    {
        $this->handler = $handler;
        return $this;
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
}
