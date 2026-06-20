<?php

declare(strict_types=1);

namespace Deg540\CleanCodeKata9;

class Quiniela
{
    private const QUINIELA_VACIA = 'La quiniela está vacía';

    private array $apuestas = [];

    public function __construct(private Resultados $marcador)
    {
    }

    public function ejecutar(string $instruccion): string
    {
        $instruccionNormalizada = strtolower($instruccion);

        if (str_starts_with($instruccionNormalizada, 'apostar')) {
            return $this->apostar($instruccionNormalizada);
        }

        if ($instruccionNormalizada === 'aciertos') {
            return $this->aciertos();
        }

        if (str_starts_with($instruccionNormalizada, 'quitar')) {
            return $this->quitar($instruccionNormalizada);
        }

        if ($instruccionNormalizada === 'vaciar') {
            return $this->vaciar();
        }

        return '';
    }

    private function apostar(string $instruccion): string
    {
        $partes = explode(' ', $instruccion);
        $partido = $partes[1];
        $signo = strtoupper($partes[2]);

        if (!$this->esSignoValido($signo)) {
            return 'Signo no válido';
        }

        $this->apuestas[$partido] = $signo;

        return $this->formatearQuiniela();
    }

    private function aciertos(): string
    {
        $aciertos = 0;
        foreach ($this->apuestas as $partido => $signo) {
            if ($this->marcador->getResultado($partido) === $signo) {
                $aciertos++;
            }
        }

        return 'Aciertos: ' . $aciertos;
    }

    private function quitar(string $instruccion): string
    {
        $partes = explode(' ', $instruccion);
        $partido = $partes[1];

        if (!isset($this->apuestas[$partido])) {
            return 'La apuesta seleccionada no existe';
        }

        unset($this->apuestas[$partido]);

        if (empty($this->apuestas)) {
            return self::QUINIELA_VACIA;
        }

        return $this->formatearQuiniela();
    }

    private function vaciar(): string
    {
        $this->apuestas = [];

        return self::QUINIELA_VACIA;
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
