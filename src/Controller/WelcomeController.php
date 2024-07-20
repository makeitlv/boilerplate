<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WelcomeController extends AbstractController
{
    #[Route('/', name: 'app_welcome')]
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig');
    }
}
