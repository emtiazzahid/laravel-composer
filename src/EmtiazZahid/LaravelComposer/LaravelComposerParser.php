<?php

namespace EmtiazZahid\LaravelComposer;

use http\Client;
use Symfony\Component\Process\Process;

class LaravelComposerParser
{
    public $perPage = 100; //TODO:: NEED DYNAMIC PAGINATION

    public function installedPackages()
    {
        $result = $this->processRun(['composer', 'show','-l','--direct','--format=json']);

        $packagesArray = json_decode($result, true);

        return $packagesArray['installed'];
    }

    public function packageList($vendor, $type)
    {
        $client = new \GuzzleHttp\Client();
        $result = $client->get('https://packagist.org/packages/list.json?vendor='.$vendor.'&type='.$type.'&per_page='.$this->perPage);


        $body = json_decode($result->getBody(), true);

        return $body['packageNames'];
    }

    public function searchPackage($query, $tags, $type)
    {
        $client = new \GuzzleHttp\Client();

        $result = $client->get('https://packagist.org/search.json?q='.$query.'&tags='.$tags.'&type='.$type.'&per_page='.$this->perPage);


        $output = json_decode($result->getBody(), true);

        return $output;
    }

    public function processRun($commands)
    {
        $process = new Process($commands, null, ['COMPOSER_HOME' => '$HOME/.config/composer']);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(120);
        $process->run();



        if (!$process->isSuccessful()) {
            throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
