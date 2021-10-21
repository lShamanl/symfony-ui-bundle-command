<?php

declare(strict_types=1);

namespace SymfonyBundle\UIBundle\Command\Core\CQRS\Command\Async;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use SymfonyBundle\UIBundle\Foundation\Core\Components\AbstractContext;
use SymfonyBundle\UIBundle\Foundation\Core\Components\AbstractProcessor;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\ApiFormatter;

class Processor extends AbstractProcessor
{
    protected EventDispatcherInterface $dispatcher;
    protected SerializerInterface $serializer;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        SerializerInterface $serializer
    ) {
        $this->dispatcher = $dispatcher;
        $this->serializer = $serializer;
    }

    public function process(AbstractContext $actionContext): void
    {
        /** @var Context $actionContext */
        $this->dispatcher->dispatch($actionContext->getCommand());

        $this->responseContent = $this->serializer->serialize(
            ApiFormatter::prepare(['ok' => true]),
            $actionContext->getOutputFormat()
        );

        $this->responseHeaders = [
            ['Content-Type' => "application/" . $actionContext->getOutputFormat()]
        ];
    }
}
