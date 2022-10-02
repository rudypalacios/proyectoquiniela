<?php

namespace App\Test\Controller;

use App\Entity\League;
use App\Repository\LeagueRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeagueControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LeagueRepository $repository;
    private string $path = '/league/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(League::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('League index');

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
            'league[name]' => 'Testing',
            'league[description]' => 'Testing',
            'league[pool]' => 'Testing',
            'league[create_at]' => 'Testing',
            'league[updated_at]' => 'Testing',
            'league[expiration_date]' => 'Testing',
            'league[owner]' => 'Testing',
        ]);

        self::assertResponseRedirects('/league/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new League();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPool('My Title');
        $fixture->setCreate_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setExpiration_date('My Title');
        $fixture->setOwner('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('League');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new League();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPool('My Title');
        $fixture->setCreate_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setExpiration_date('My Title');
        $fixture->setOwner('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'league[name]' => 'Something New',
            'league[description]' => 'Something New',
            'league[pool]' => 'Something New',
            'league[create_at]' => 'Something New',
            'league[updated_at]' => 'Something New',
            'league[expiration_date]' => 'Something New',
            'league[owner]' => 'Something New',
        ]);

        self::assertResponseRedirects('/league/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPool());
        self::assertSame('Something New', $fixture[0]->getCreate_at());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
        self::assertSame('Something New', $fixture[0]->getExpiration_date());
        self::assertSame('Something New', $fixture[0]->getOwner());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new League();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPool('My Title');
        $fixture->setCreate_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setExpiration_date('My Title');
        $fixture->setOwner('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/league/');
    }
}
