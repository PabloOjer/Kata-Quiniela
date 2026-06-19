<?php

declare(strict_types=1);

namespace Deg540\CleanCodeKata9\Test;

use Deg540\CleanCodeKata9\Quiniela;
use Deg540\CleanCodeKata9\Resultados;
use PHPUnit\Framework\TestCase;

class QuinielaTest extends TestCase
{
    /** @test */
    public function cualquierInstruccionDesconocidaDevuelveStringVacio(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('cualquier instrucción');

        // Assert
        $this->assertEquals('', $resultado);
    }
}
