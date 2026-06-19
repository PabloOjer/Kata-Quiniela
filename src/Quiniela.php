<?php

declare(strict_types=1);

namespace Deg540\CleanCodeKata9;

class Quiniela
{
    public function __construct(private Resultados $marcador)
    {
    }

    public function ejecutar(string $instruccion): string
    {
        if (str_starts_with($instruccion, 'apostar')) {
            $partes = explode(' ', $instruccion);
            return $partes[1] . ': ' . $partes[2];
        }

        return '';
    }
}
