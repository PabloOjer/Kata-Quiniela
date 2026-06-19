<?php

declare(strict_types=1);

namespace Deg540\CleanCodeKata9;

class Quiniela
{
    private array $apuestas = [];

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

        $this->apuestas[strtolower($partes[1])] = $signo;

        return $this->formatearQuiniela();
    }

    private function formatearQuiniela(): string
    {
        $apuestasOrdenadas = $this->apuestas;
        ksort($apuestasOrdenadas);

        $entradas = [];
        foreach ($apuestasOrdenadas as $partido => $signo) {
            $entradas[] = $partido . ': ' . $signo;
        }

        return implode(', ', $entradas);
    }

    private function esSignoValido(string $signo): bool
    {
        return in_array($signo, ['1', 'X', '2']);
    }
}
