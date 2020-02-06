<?php

namespace EmtiazZahid\LaravelComposer;

class LaravelComposerParser
{
    public function installedPackages($packages)
    {
        $packagesArray = json_decode($packages, true);

        return $packagesArray['installed'];
    }
}
