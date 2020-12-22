<?php

declare(strict_types=1);

namespace GameOfLife;

final class GameOfLife
{
    private array $board;

    public function __construct(array $board)
    {
        $this->board = $board;
    }

    public function nextGen(): void
    {
        $deadCells = [];
        $bornCells = [];

        foreach ($this->board as $j => $row) {
            foreach ($row as $i => $cell) {
                $isLiveCell     = $this->board[$j][$i];
                $liveNeighbours = $this->getCellLiveNeighbours($i, $j);

                if ($isLiveCell && ($liveNeighbours < 2 || $liveNeighbours > 3)) {
                    $deadCells[] = ['x' => $i, 'y' => $j];
                    continue;
                }

                if (!$isLiveCell && $liveNeighbours === 3) {
                    $bornCells[] = ['x' => $i, 'y' => $j];
                }
            }
        }

        $this->markCellsAsDied($deadCells);
        $this->markCellsAsLive($bornCells);
    }

    private function getCellLiveNeighbours(int $i, int $j): int
    {
        $liveNeighboursCounter = 0;

        for ($y = $j - 1; $y <= $j + 1; $y++) {
            for ($x = $i - 1; $x <= $i + 1; $x++) {
                if ($x === $i && $y === $j) {
                    continue;
                }

                if (isset($this->board[$y][$x])) {
                    $liveNeighboursCounter += (int) $this->board[$y][$x];
                }
            }
        }

        return $liveNeighboursCounter;
    }

    /**
     * @param array $deadCells
     */
    private function markCellsAsDied(array $deadCells): void
    {
        foreach ($deadCells as $cell) {
            $this->board[$cell['y']][$cell['x']] = false;
        }
    }

    /**
     * @param array $bornCells
     */
    private function markCellsAsLive(array $bornCells): void
    {
        foreach ($bornCells as $cell) {
            $this->board[$cell['y']][$cell['x']] = true;
        }
    }

    public function board(): array
    {
        return $this->board;
    }
}
