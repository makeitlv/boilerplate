<?php

declare(strict_types=1);

namespace App\Book\Presentation\Controller;

use App\Book\Application\UseCase\Query\List\ListBookQuery;
use App\Common\Application\Bus\Query\QueryBusInterface;
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
    public function __invoke(): Response
    {
        $books = $this->queryBus->ask(new ListBookQuery());

        $content = $this->twigEnvironment->render(
            'book/books.html.twig',
            ['books' => $books],
        );

        return new Response($content);
    }
}
