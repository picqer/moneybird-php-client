<?php
declare(strict_types=1);

namespace Picqer\Financials\Moneybird\Connection;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class ConnectionUtil
{

    /**
     * @param callable[] $middleWares
     *
     * @return \GuzzleHttp\Client
     */
    public static function createClient(array $middleWares = []): Client {

        $handlerStack = HandlerStack::create();

        foreach ($middleWares as $middleWare) {
            $handlerStack->push($middleWare);
        }

        return new Client([
            'http_errors' => true,
            'handler' => $handlerStack,
        ]);
    }

}
