<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    // #[Route('/hello/{name}', name: 'homepage')]
    // public function index(): Response
    // public function index(Request $request): Response
    // public function index(string $name = ''): Response
    public function index(Environment $twig, ConferenceRepository $conferenceRepository): Response
    {
        // return $this->render('conference/index.html.twig', [
        //     'controller_name' => 'ConferenceController',
        // ]);

        // $greet = '';
        // if ($name = $request->query->get('hello')) {
        // if ($name) {
        //     $greet = sprintf('<h1>Hello %s!</h1>', htmlspecialchars($name));
        // }

//         return new Response(<<<EOF
// <html>
//     <body>
//         $greet
//         <img src="/images/under-construction.gif" />
//     </body>
// </html>
// EOF
//         );

        return new Response($twig->render('conference/index.html.twig', [
                'conferences' => $conferenceRepository->findAll(),
        ]));
    }

    #[Route('/conference/{id}', name: 'conference')]
    public function show(Environment $twig, Conference $conference, CommentRepository $commentRepository): Response
    {
        return new Response($twig->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $commentRepository->findBy(['conference' => $conference], ['createdAt' => 'DESC']),
        ]));
    }

}
