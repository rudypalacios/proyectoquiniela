<?php

namespace App\Controller;

use App\Entity\LeagueTeam;
use App\Form\LeagueTeamType;
use App\Repository\LeagueTeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/league/team")
 */
class LeagueTeamController extends AbstractController
{
    /**
     * @Route("/", name="app_league_team_index", methods={"GET"})
     */
    public function index(LeagueTeamRepository $leagueTeamRepository): Response
    {
        return $this->render('league_team/index.html.twig', [
            'league_teams' => $leagueTeamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_league_team_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LeagueTeamRepository $leagueTeamRepository): Response
    {
        $leagueTeam = new LeagueTeam();
        $form = $this->createForm(LeagueTeamType::class, $leagueTeam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leagueTeamRepository->add($leagueTeam, true);

            return $this->redirectToRoute('app_league_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('league_team/new.html.twig', [
            'league_team' => $leagueTeam,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_league_team_show", methods={"GET"})
     */
    public function show(LeagueTeam $leagueTeam): Response
    {
        return $this->render('league_team/show.html.twig', [
            'league_team' => $leagueTeam,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_league_team_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LeagueTeam $leagueTeam, LeagueTeamRepository $leagueTeamRepository): Response
    {
        $form = $this->createForm(LeagueTeamType::class, $leagueTeam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leagueTeamRepository->add($leagueTeam, true);

            return $this->redirectToRoute('app_league_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('league_team/edit.html.twig', [
            'league_team' => $leagueTeam,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_league_team_delete", methods={"POST"})
     */
    public function delete(Request $request, LeagueTeam $leagueTeam, LeagueTeamRepository $leagueTeamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leagueTeam->getId(), $request->request->get('_token'))) {
            $leagueTeamRepository->remove($leagueTeam, true);
        }

        return $this->redirectToRoute('app_league_team_index', [], Response::HTTP_SEE_OTHER);
    }
}
