<?php

declare(strict_types=1);

/*
 * This file is part of the Jira SDK Laravel project.
 *
 * (c) Nick Haynes (https://github.com/nhaynes)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aws\Laravel\Test;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use JiraSdk\Api\Model\User;
use JiraSdk\Client;
use JiraSdk\Laravel\Jira;
use JiraSdk\Laravel\JiraServiceProvider;
use PHPUnit\Framework\TestCase;

class JiraServiceProviderTest extends TestCase
{
    protected Application $app;

    protected JiraServiceProvider $provider;

    protected function setUp(): void
    {
        if (!class_exists(Application::class)) {
            $this->markTestSkipped();
        }

        parent::setUp();

        $this->app = new Application();
        $this->app->setBasePath(sys_get_temp_dir());
        $this->app->instance('config', new Repository());

        $this->provider = new JiraServiceProvider($this->app);
        $this->app->register($this->provider);
        $this->provider->boot();
    }

    /**
     * @covers \JiraSdk\Laravel\JiraServiceProvider::register
     */
    public function testFacadeWorksAsClient()
    {
        Jira::setFacadeApplication($this->app);

        $user = Jira::getCurrentUser();

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @covers \JiraSdk\Laravel\JiraServiceProvider::register
     */
    public function testJiraResolvesAsClient()
    {
        $this->assertInstanceOf(Client::class, $this->app->make('jira'));
    }

    /**
     * @covers \JiraSdk\Laravel\JiraServiceProvider::register
     */
    public function testClientResolvesAsClient()
    {
        $this->assertInstanceOf(Client::class, $this->app->make(Client::class));
    }
}
