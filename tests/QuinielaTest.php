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

    /** @test */
    public function apostarConSignoInvalidoDevuelveSignoNoValido(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('apostar italia-portugal 9');

        // Assert
        $this->assertEquals('Signo no válido', $resultado);
    }

    /** @test */
    public function apostarDosPartidosDevuelveAmbosSeparadosPorComaYEspacio(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);
        $quiniela->ejecutar('apostar españa-brasil 1');

        // Act
        $resultado = $quiniela->ejecutar('apostar francia-alemania X');

        // Assert
        $this->assertEquals('españa-brasil: 1, francia-alemania: X', $resultado);
    }

    /** @test */
    public function lasApuestasSeDevuelvenOrdenadasAlfabeticamente(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);
        $quiniela->ejecutar('apostar francia-alemania X');

        // Act
        $resultado = $quiniela->ejecutar('apostar españa-brasil 1');

        // Assert
        $this->assertEquals('españa-brasil: 1, francia-alemania: X', $resultado);
    }

    /** @test */
    public function apostarConNombreDePartidoEnMayusculasLoNormalizaAMinusculas(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('apostar España-Brasil 1');

        // Assert
        $this->assertEquals('españa-brasil: 1', $resultado);
    }

    /** @test */
    public function elComandoApostarEsCaseInsensitive(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('Apostar españa-brasil 1');

        // Assert
        $this->assertEquals('españa-brasil: 1', $resultado);
    }

    /** @test */
    public function reconocerComandoAciertosDevuelveStringNoVacio(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('aciertos');

        // Assert
        $this->assertNotEmpty($resultado);
    }

    /** @test */
    public function aciertosConQuinielaVaciaDevuelveAciertosCero(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('aciertos');

        // Assert
        $this->assertEquals('Aciertos: 0', $resultado);
    }

    /** @test */
    public function aciertosDevuelveUnoSiLaApuestaCoincideConElResultadoReal(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $marcador->method('getResultado')->with('españa-brasil')->willReturn('1');
        $quiniela = new Quiniela($marcador);
        $quiniela->ejecutar('apostar españa-brasil 1');

        // Act
        $resultado = $quiniela->ejecutar('aciertos');

        // Assert
        $this->assertEquals('Aciertos: 1', $resultado);
    }

    /** @test */
    public function reconocerComandoQuitarDevuelveStringNoVacio(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);
        $quiniela->ejecutar('apostar españa-brasil 1');

        // Act
        $resultado = $quiniela->ejecutar('quitar españa-brasil');

        // Assert
        $this->assertNotEmpty($resultado);
    }

    /** @test */
    public function quitarUnPartidoDevuelveLaQuinielaRestante(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);
        $quiniela->ejecutar('apostar españa-brasil 1');
        $quiniela->ejecutar('apostar francia-alemania X');

        // Act
        $resultado = $quiniela->ejecutar('quitar españa-brasil');

        // Assert
        $this->assertEquals('francia-alemania: X', $resultado);
    }

    /** @test */
    public function quitarUnPartidoInexistenteDevuelveLaApuestaSeleccionadaNoExiste(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('quitar italia-portugal');

        // Assert
        $this->assertEquals('La apuesta seleccionada no existe', $resultado);
    }

    /** @test */
    public function reconocerComandoVaciarDevuelveStringNoVacio(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('vaciar');

        // Assert
        $this->assertNotEmpty($resultado);
    }

    /** @test */
    public function vaciarDevuelveLaQuinielaEstaVacia(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);

        // Act
        $resultado = $quiniela->ejecutar('vaciar');

        // Assert
        $this->assertEquals('La quiniela está vacía', $resultado);
    }

    /** @test */
    public function vaciarElimnaTodasLasApuestasDelEstado(): void
    {
        // Arrange
        $marcador = $this->createMock(Resultados::class);
        $quiniela = new Quiniela($marcador);
        $quiniela->ejecutar('apostar españa-brasil 1');
        $quiniela->ejecutar('apostar francia-alemania X');
        $quiniela->ejecutar('vaciar');

        // Act
        $resultado = $quiniela->ejecutar('apostar italia-portugal 2');

        // Assert
        $this->assertEquals('italia-portugal: 2', $resultado);
    }
}
