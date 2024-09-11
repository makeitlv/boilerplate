<?php

declare(strict_types=1);

namespace App\Book\Presentation\Controller;

use App\Book\Application\UseCase\Query\List\ListBookQuery;
use App\Book\Domain\ReadModel\BookRead;
use App\Common\Application\Bus\Query\QueryBusInterface;
use App\Common\Domain\ReadModel\PaginationData;
use App\Common\Domain\ReadModel\ValueObject\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final readonly class ListBookAction
{
    public function __construct(
        private Environment $twigEnvironment,
        private QueryBusInterface $queryBus,
    ) {}

    #[Route('/', name: 'book.list')]
    public function __invoke(Request $request): Response
    {
        $currentPage = (int) $request->query->get('page', '1');

        /** @var PaginationData<BookRead> $paginationData */
        $paginationData = $this->queryBus->ask(
            new ListBookQuery(new Page($currentPage)),
        );

        $content = $this->twigEnvironment->render(
            'book/books.html.twig',
            [
                'paginationData' => $paginationData,
            ],
        );

        return new Response($content);
    }
}
