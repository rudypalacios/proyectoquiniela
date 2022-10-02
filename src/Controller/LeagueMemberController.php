<?php

namespace App\Controller;

use App\Entity\LeagueMember;
use App\Form\LeagueMemberType;
use App\Repository\LeagueMemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/league/member")
 */
class LeagueMemberController extends AbstractController
{
    /**
     * @Route("/", name="app_league_member_index", methods={"GET"})
     */
    public function index(LeagueMemberRepository $leagueMemberRepository): Response
    {
        return $this->render('league_member/index.html.twig', [
            'league_members' => $leagueMemberRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_league_member_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LeagueMemberRepository $leagueMemberRepository): Response
    {
        $leagueMember = new LeagueMember();
        $form = $this->createForm(LeagueMemberType::class, $leagueMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leagueMemberRepository->add($leagueMember, true);

            return $this->redirectToRoute('app_league_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('league_member/new.html.twig', [
            'league_member' => $leagueMember,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_league_member_show", methods={"GET"})
     */
    public function show(LeagueMember $leagueMember): Response
    {
        return $this->render('league_member/show.html.twig', [
            'league_member' => $leagueMember,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_league_member_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LeagueMember $leagueMember, LeagueMemberRepository $leagueMemberRepository): Response
    {
        $form = $this->createForm(LeagueMemberType::class, $leagueMember);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leagueMemberRepository->add($leagueMember, true);

            return $this->redirectToRoute('app_league_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('league_member/edit.html.twig', [
            'league_member' => $leagueMember,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_league_member_delete", methods={"POST"})
     */
    public function delete(Request $request, LeagueMember $leagueMember, LeagueMemberRepository $leagueMemberRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leagueMember->getId(), $request->request->get('_token'))) {
            $leagueMemberRepository->remove($leagueMember, true);
        }

        return $this->redirectToRoute('app_league_member_index', [], Response::HTTP_SEE_OTHER);
    }
}
