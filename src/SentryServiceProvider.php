<?php
namespace Moriony\Silex\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

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
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $defaultOptions = self::$defaultOptions;

        $pimple[self::SENTRY] = function () use ($pimple, $defaultOptions) {
            $options = array_merge($defaultOptions, $pimple[SentryServiceProvider::SENTRY_OPTIONS]);
            return new \Raven_Client($options[SentryServiceProvider::OPT_DSN], $options);
        };

        $pimple[self::SENTRY_ERROR_HANDLER] = function() use ($pimple, $defaultOptions) {
            $options = array_merge($defaultOptions, $pimple[SentryServiceProvider::SENTRY_OPTIONS]);
            return new \Raven_ErrorHandler($pimple[SentryServiceProvider::SENTRY],
                                           $options[SentryServiceProvider::OPT_SEND_ERRORS_LAST]);
        };
    }
}
