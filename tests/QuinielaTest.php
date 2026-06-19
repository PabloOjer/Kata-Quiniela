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

    /** @test */
    public function reconocerComandoApostarDevuelveStringNoVacio(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('apostar españa-brasil 1');

        // Assert
        $this->assertNotEmpty($resultado);
    }

    /** @test */
    public function apostarUnPartidoDevuelveElNombreDelPartido(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('apostar españa-brasil 1');

        // Assert
        $this->assertStringContainsString('españa-brasil', $resultado);
    }

    /** @test */
    public function apostarUnPartidoDevuelveElPartidoConElSignoFormateado(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('apostar españa-brasil 1');

        // Assert
        $this->assertEquals('españa-brasil: 1', $resultado);
    }

    /** @test */
    public function apostarConSignoEnMinusculaLoDevuelveEnMayuscula(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('apostar francia-alemania x');

        // Assert
        $this->assertEquals('francia-alemania: X', $resultado);
    }
}
