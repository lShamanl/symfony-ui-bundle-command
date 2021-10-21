<?php

declare(strict_types=1);

namespace SymfonyBundle\UIBundle\Command\Core\Service;

use Symfony\Component\Serializer\SerializerInterface;
use SymfonyBundle\UIBundle\Foundation\Core\Components\Exception\DomainException;
use SymfonyBundle\UIBundle\Foundation\Core\Contract\InputContractInterface;

class InputContractResolver
{
    private ValidatorService $validator;
    private SerializerInterface $serializer;

    public function __construct(
        ValidatorService $validator,
        SerializerInterface $serializer
    ) {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param class-string<InputContractInterface> $contractClass
     * @param array<string, string> $payload
     * @return InputContractInterface
     */
    public function resolve(string $contractClass, array $payload): InputContractInterface
    {
        if (!is_subclass_of($contractClass, InputContractInterface::class)) {
            throw new DomainException("{$contractClass} not is subclass of " . InputContractInterface::class);
        }

        $inputContractDto = $this->serializer->deserialize(
            json_encode($payload),
            $contractClass,
            'json'
        );

        $this->validator->validate($inputContractDto);

        return $inputContractDto;
    }
}
