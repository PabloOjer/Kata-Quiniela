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
            return $this->apostar($instruccion);
        }

        return '';
    }

    private function apostar(string $instruccion): string
    {
        $partes = explode(' ', $instruccion);
        $signo = strtoupper($partes[2]);

        if (!$this->esSignoValido($signo)) {
            return 'Signo no válido';
        }

        return $partes[1] . ': ' . $signo;
    }

    private function esSignoValido(string $signo): bool
    {
        return in_array($signo, ['1', 'X', '2']);
    }
}
