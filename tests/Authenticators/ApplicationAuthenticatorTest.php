<?php

/*
 * This file is part of Laravel GitHub.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\GitHub\Authenticators;

use GrahamCampbell\GitHub\Authenticators\ApplicationAuthenticator;
use GrahamCampbell\Tests\GitHub\AbstractTestCase;
use Mockery;

/**
 * This is the application authenticator test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ApplicationAuthenticatorTest extends AbstractTestCase
{
    public function testMakeStandardWithMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');
        $client->shouldReceive('authenticate')->once()
            ->with('your-client-id', 'your-client-secret', 'url_client_id');

        $return = $authenticator->with($client)->authenticate([
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
            'method'       => 'application',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    public function testMakeWithoutMethod()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');
        $client->shouldReceive('authenticate')->once()
            ->with('your-client-id', 'your-client-secret', 'url_client_id');

        $return = $authenticator->with($client)->authenticate([
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The application authenticator requires a client id and secret.
     */
    public function testMakeWithoutClientId()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');

        $return = $authenticator->with($client)->authenticate([
            'clientSecret' => 'your-client-secret',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The application authenticator requires a client id and secret.
     */
    public function testMakeWithoutClientSecret()
    {
        $authenticator = $this->getAuthenticator();

        $client = Mockery::mock('Github\Client');

        $return = $authenticator->with($client)->authenticate([
            'clientId'     => 'your-client-id',
        ]);

        $this->assertInstanceOf('Github\Client', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The client instance was not given to the application authenticator.
     */
    public function testMakeWithoutSettingClient()
    {
        $authenticator = $this->getAuthenticator();

        $return = $authenticator->authenticate([
            'clientId'     => 'your-client-id',
            'clientSecret' => 'your-client-secret',
            'method'       => 'application',
        ]);
    }

    protected function getAuthenticator()
    {
        return new ApplicationAuthenticator();
    }
}
