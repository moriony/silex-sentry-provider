<?php
namespace Moriony\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class SentryServiceProvider implements ServiceProviderInterface
{
    const SENTRY = 'sentry';
    const SENTRY_OPTIONS = 'sentry.options';
    const SENTRY_ERROR_HANDLER = 'sentry.error_handler';

    const OPT_DSN = 'dsn';
    const OPT_SEND_ERRORS_LAST = 'send_errors_last';

    protected static $defaultOptions = array(
        self::OPT_DSN => null,
        self::OPT_SEND_ERRORS_LAST => false,
    );

    /**
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $defaultOptions = self::$defaultOptions;

        $app[self::SENTRY] = $app->share(function () use($app, $defaultOptions) {
            $options = array_merge($defaultOptions, $app[SentryServiceProvider::SENTRY_OPTIONS]);
            return new \Raven_Client($options[SentryServiceProvider::OPT_DSN], $options);
        });

        $app[self::SENTRY_ERROR_HANDLER] = $app->share(function() use($app, $defaultOptions) {
            $options = array_merge($defaultOptions, $app[SentryServiceProvider::SENTRY_OPTIONS]);
            return new \Raven_ErrorHandler($app[SentryServiceProvider::SENTRY],
                                           $options[SentryServiceProvider::OPT_SEND_ERRORS_LAST]);
        });
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {}
}
