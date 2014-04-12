<?php

namespace RidePal\RoutesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RidePalRoutesBundle extends Bundle
{
	    public function allAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/routes');

        $this->assertGreaterThan(
            0,
            $crawler->filter('contains("route")')->count()
        );
    }
}
