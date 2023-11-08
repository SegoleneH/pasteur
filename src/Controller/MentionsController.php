<?php

namespace App\Controller;

use App\Entity\Mentions;
use App\Form\MentionsType;
use App\Repository\MentionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mentions')]
class MentionsController extends AbstractController
{
    #[Route('/', name: 'app_mentions_index', methods: ['GET'])]
    public function index(MentionsRepository $mentionsRepository): Response
    {
        return $this->render('mentions/index.html.twig', [
            'mentions' => $mentionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mentions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mention = new Mentions();
        $form = $this->createForm(MentionsType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mention);
            $entityManager->flush();

            return $this->redirectToRoute('app_mentions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mentions/new.html.twig', [
            'mention' => $mention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mentions_show', methods: ['GET'])]
    public function show(Mentions $mention): Response
    {
        return $this->render('mentions/show.html.twig', [
            'mention' => $mention,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mentions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mentions $mention, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MentionsType::class, $mention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mentions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mentions/edit.html.twig', [
            'mention' => $mention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mentions_delete', methods: ['POST'])]
    public function delete(Request $request, Mentions $mention, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mention->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mentions_index', [], Response::HTTP_SEE_OTHER);
    }
}
