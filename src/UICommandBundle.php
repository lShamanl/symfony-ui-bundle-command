<?php

declare(strict_types=1);

namespace SymfonyBundle\UIBundle\Command;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyBundle\UIBundle\Foundation\UIFoundationBundle;
use SymfonyBundles\BundleDependency\BundleDependency;

class UICommandBundle extends Bundle
{
    use BundleDependency;

    public function getBundleDependencies(): array
    {
        return [
            UIFoundationBundle::class
        ];
    }
}
