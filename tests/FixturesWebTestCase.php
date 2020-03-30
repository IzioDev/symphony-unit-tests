<?php


namespace App\Tests;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class FixturesWebTestCase extends KernelTestCase
{
    use WebTestAssertionsTrait;
    use MailerAssertionsTrait;

    protected EntityManager $em;

    protected $application = null;

    private AbstractBrowser $client;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {

        $this->client = $this->createClient();


        $this->resetDatabase();
    }

    public function createAdminClient(): AbstractBrowser {
        $client = $this->client;
        $client->setServerParameters( [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'password',
        ]);
        return $client;
    }

    public function createUserClient(): AbstractBrowser {
        $client = $this->client;
        $client->setServerParameters( [
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW' => 'password',
        ]);
        return $client;
    }

    protected function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return $this->getApplication()->run(new StringInput($command));
    }

    protected function getApplication()
    {
        if (null === $this->application) {
            $this->application = new Application($this->client->getKernel());
            $this->application->setAutoExit(false);
        }

        return $this->application;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown() : void
    {
        parent::tearDown();
        self::getClient(null);
        $this->em->close();
    }

    /**
     * @throws ToolsException
     */
    private function resetDatabase(): void
    {
        /** @var EntityManagerInterface $em */
        $this->em = self::$container->get('doctrine')->getManager();

        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
        self::runCommand('doctrine:fixtures:load');
    }

    protected function createClient(array $options = [], array $server = [])
    {
        if (static::$booted) {
            return $this->client;
        }

        $kernel = static::bootKernel($options);

        try {
            $client = $kernel->getContainer()->get('test.client');
        } catch (ServiceNotFoundException $e) {
            if (class_exists(KernelBrowser::class)) {
                throw new \LogicException('You cannot create the client used in functional tests if the "framework.test" config is not set to true.');
            }
            throw new \LogicException('You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit"');
        }

        $client->setServerParameters($server);

        return self::getClient($client);
    }
}