<?php

namespace App\Test\Controller;

use App\Entity\LeagueTeam;
use App\Repository\LeagueTeamRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeagueTeamControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LeagueTeamRepository $repository;
    private string $path = '/league/team/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(LeagueTeam::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LeagueTeam index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'league_team[league]' => 'Testing',
            'league_team[team_1]' => 'Testing',
            'league_team[team_2]' => 'Testing',
        ]);

        self::assertResponseRedirects('/league/team/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeagueTeam();
        $fixture->setLeague('My Title');
        $fixture->setTeam_1('My Title');
        $fixture->setTeam_2('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LeagueTeam');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeagueTeam();
        $fixture->setLeague('My Title');
        $fixture->setTeam_1('My Title');
        $fixture->setTeam_2('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'league_team[league]' => 'Something New',
            'league_team[team_1]' => 'Something New',
            'league_team[team_2]' => 'Something New',
        ]);

        self::assertResponseRedirects('/league/team/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLeague());
        self::assertSame('Something New', $fixture[0]->getTeam_1());
        self::assertSame('Something New', $fixture[0]->getTeam_2());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new LeagueTeam();
        $fixture->setLeague('My Title');
        $fixture->setTeam_1('My Title');
        $fixture->setTeam_2('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/league/team/');
    }
}
