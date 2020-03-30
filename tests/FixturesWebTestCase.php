<?php


namespace App\Tests;


use App\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;

class FixturesWebTestCase extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected static $application;

    protected static $admin = null;
    protected static $client = null;
    protected static $user = null;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $this->resetDatabase();

        if (null === self::$client) {
            self::$client = static::createClient();
        }

        if (null === self::$admin) {
            self::$admin = clone self::$client;
        }

        if (null === self::$user) {
            self::$user = clone self::$client;
        }

        parent::setUp();
    }

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown() : void
    {
        parent::tearDown();
        $this->em->close();
    }

    /**
     * @throws ToolsException
     */
    private function resetDatabase(): void
    {
        /** @var EntityManagerInterface $em */
        $this->em = self::$container->get('doctrine')->getManager();

        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('doctrine:fixtures:load --purge-with-truncate');
    }
}