<?php

namespace Bolt\Tests\Events;

use Bolt\Events\CronEvent;
use Bolt\Events\CronEvents;
use Bolt\Tests\BoltUnitTest;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class to test src/Events/CronEvent.
 *
 * @author Ross Riley <riley.ross@gmail.com>
 * @author Gawain Lynch <gawain.lynch@gmail.com>
 */
class CronEventTest extends BoltUnitTest
{
    public function testCronCalls()
    {
        $app = $this->getApp();

        $app['cache'] = $this->getMockCache();
        $app['cache']
            ->expects($this->exactly(1))
            ->method('flushAll')
        ;

        $app['logger.manager'] = $this->getMockLoggerManager();
        $app['logger.manager']
            ->expects($this->exactly(2))
            ->method('trim');

        $output = new BufferedOutput();

        $listeningEvent = new CronEvent($app, $output);

        $app['dispatcher']->dispatch(CronEvents::CRON_HOURLY, $listeningEvent);
        $app['dispatcher']->dispatch(CronEvents::CRON_DAILY, $listeningEvent);
        $app['dispatcher']->dispatch(CronEvents::CRON_WEEKLY, $listeningEvent);
        $app['dispatcher']->dispatch(CronEvents::CRON_MONTHLY, $listeningEvent);
        $app['dispatcher']->dispatch(CronEvents::CRON_YEARLY, $listeningEvent);

        // Currently only the weekly produces any output for us to call
        $out = $listeningEvent->output->fetch();
        $this->assertRegExp('/Clearing cache/', $out);
        $this->assertRegExp('/Trimming logs/', $out);
    }
}
