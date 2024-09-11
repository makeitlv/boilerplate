<?php

declare(strict_types=1);

namespace App\Common\Domain\ReadModel;

/**
 * @template T
 */
final readonly class PaginationData
{
    public int $previousPage;

    public int $nextPage;

    /**
     * @param array<T> $items
     */
    public function __construct(public array $items, public int $currentPage, public int $totalPages)
    {
        $this->previousPage = $this->currentPage > 1 ? $this->currentPage - 1 : 1;
        $this->nextPage = $this->currentPage < $this->totalPages ? $this->currentPage + 1 : $this->totalPages;
    }
}
