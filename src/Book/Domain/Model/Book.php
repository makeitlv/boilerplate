<?php

declare(strict_types=1);

namespace App\Book\Domain\Model;

use App\Book\Domain\Model\ValueObject\Author;
use App\Book\Domain\Model\ValueObject\Description;
use App\Book\Domain\Model\ValueObject\Title;
use App\Common\Domain\Aggregate\AggregateRoot;
use App\Common\Domain\Model\ValueObject\Uuid;

final class Book extends AggregateRoot
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly Title $title,
        private readonly Description $description,
        private readonly Author $author,
    ) {}

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }
}
