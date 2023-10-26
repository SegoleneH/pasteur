<?php

namespace App\Controller;

use App\Entity\Praticien;
use App\Form\PraticienType;
use App\Repository\PraticienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/praticien")
 * @ParamConverter("praticien")
 */
#[Route('/praticien')]
class PraticienController extends AbstractController
{
    #[Route('/', name: 'app_praticien_index', methods: ['GET'])]
    public function index(PraticienRepository $praticienRepository): Response
    {
        return $this->render('praticien/index.html.twig', [
            'praticiens' => $praticienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_praticien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $praticien = new Praticien();
        $form = $this->createForm(PraticienType::class, $praticien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($praticien);
            $entityManager->flush();

            return $this->redirectToRoute('app_praticien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('praticien/new.html.twig', [
            'praticien' => $praticien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_praticien_show', methods: ['GET'])]
    public function show(Praticien $praticien): Response
    {
        return $this->render('praticien/show.html.twig', [
            'praticien' => $praticien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_praticien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Praticien $praticien, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PraticienType::class, $praticien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_praticien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('praticien/edit.html.twig', [
            'praticien' => $praticien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_praticien_delete', methods: ['POST'])]
    public function delete(Request $request, Praticien $praticien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$praticien->getId(), $request->request->get('_token'))) {
            $entityManager->remove($praticien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_praticien_index', [], Response::HTTP_SEE_OTHER);
    }
}
