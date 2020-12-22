<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GameOfLifeTest extends TestCase
{
    public function testEmptyBoardReturnsEmptyBoard(): void
    {
        $gameOfLife = new GameOfLife\GameOfLife([]);

        self::assertEquals([], $gameOfLife->board());
    }

    public function testCellWithFewerThanTwoLiveNeighboursDies(): void
    {
        $gameOfLife = new GameOfLife\GameOfLife([[false, false, false], [false, true, false], [false, false, false]]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [false, false, false],
            [false, false, false],
            [false, false, false],
        ], $gameOfLife->board());

        $gameOfLife = new GameOfLife\GameOfLife([[true, false, false], [false, true, false], [false, false, false]]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [false, false, false],
            [false, false, false],
            [false, false, false],
        ], $gameOfLife->board());

        $gameOfLife = new GameOfLife\GameOfLife([
            [true, false, false],
            [false, true, false],
            [false, false, true],
        ]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [false, false, false],
            [false, true, false],
            [false, false, false],
        ], $gameOfLife->board());
    }

    public function testCellWithMoreThanThreeLiveNeighboursDies(): void
    {
        $gameOfLife = new GameOfLife\GameOfLife([
            [true, true, true],
            [false, true, false],
            [false, true, false],
        ]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [true, true, true],
            [false, false, false],
            [false, false, false],
        ], $gameOfLife->board());

        $gameOfLife = new GameOfLife\GameOfLife([
            [true, false, false],
            [false, true, false],
            [false, false, false],
        ]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [false, false, false],
            [false, false, false],
            [false, false, false],
        ], $gameOfLife->board());

        $gameOfLife = new GameOfLife\GameOfLife([
            [true, false, false],
            [false, true, false],
            [false, false, true],
        ]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [false, false, false],
            [false, true, false],
            [false, false, false],
        ], $gameOfLife->board());
    }

    public function testCellWithTwoOrThreeLiveNeighboursLives(): void
    {
        $gameOfLife = new GameOfLife\GameOfLife([
            [true, true, false],
            [false, true, false],
            [true, false, false],
        ]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [true, true, false],
            [false, true, false],
            [false, false, false],
        ], $gameOfLife->board());

        $gameOfLife->nextGen();

        self::assertEquals([
            [true, true, false],
            [true, true, false],
            [false, false, false],
        ], $gameOfLife->board());
    }

    public function testCellWithExactlyThreeLiveNeighboursBecomesLive(): void
    {
        $gameOfLife = new GameOfLife\GameOfLife([
            [true, true, false],
            [false, true, false],
            [false, false, false],
        ]);
        $gameOfLife->nextGen();

        self::assertEquals([
            [true, true, false],
            [true, true, false],
            [false, false, false],
        ], $gameOfLife->board());
    }
}