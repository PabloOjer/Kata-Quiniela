<?php

declare(strict_types=1);

namespace Deg540\CleanCodeKata9;

interface Resultados
{
    public function getResultado(string $partido): ?string;
}
