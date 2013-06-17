<?php
namespace Moriony\Silex\Provider;

use Silex\Application;
use Moriony\Silex\Provider\SentryServiceProvider;

class SentryServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    protected $app;

    public function setUp()
    {
        $this->app = new Application();
        $this->app->register(new SentryServiceProvider, array(
            SentryServiceProvider::SENTRY_OPTIONS => array(
                SentryServiceProvider::OPT_DSN => null,
            )
        ));
        $this->app->boot();
    }

    public function testRavenClientObtain()
    {
        $this->assertInstanceOf('Raven_Client', $this->app[SentryServiceProvider::SENTRY]);
    }

    public function testRavenErrorHandlerObtain()
    {
        $this->assertInstanceOf('Raven_ErrorHandler', $this->app[SentryServiceProvider::SENTRY_ERROR_HANDLER]);
    }
}