<?php
namespace Moriony\Silex\Provider;

use Pimple\Container;

class SentryServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new Container();
        $this->container->register(new SentryServiceProvider, array(
            SentryServiceProvider::SENTRY_OPTIONS => array(
                SentryServiceProvider::OPT_DSN => null,
            )
        ));
    }

    public function testRavenClientObtain()
    {
        $this->assertInstanceOf('Raven_Client', $this->container[SentryServiceProvider::SENTRY]);
    }

    public function testRavenErrorHandlerObtain()
    {
        $this->assertInstanceOf('Raven_ErrorHandler', $this->container[SentryServiceProvider::SENTRY_ERROR_HANDLER]);
    }
}