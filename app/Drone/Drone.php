<?php

namespace App\Drone;

use Illuminate\Support\Facades\Http;

class Drone
{
    /**
     * repos
     * This function gets a list of repos,
     * @param  mixed $latest - Boolean value. Default true, will give you the latest build
     * @return void
     */

    public static function repos($latest = true)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/user/repos?latest=$latest");
    }

    /**
     * repo
     * Find a certain repo based on the user and the name
     * @param  string $namespace - The name of the user
     * @param  string $name - The name of the repo
     * @return void
     */
    public static function repo(string $namespace, string $name)
    {
        return Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/user/repos/$namespace/$name");
    }




    /**
     * enableRepo
     * Submits a request to enable the repository inside of drone ci
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function enableRepo(string $namespace, string $name)
    {
        return Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/user/repos/$namespace/$name");
    }


    /**
     * deleteRepo
     * Submits a request to disable the repository
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function deleteRepo(string $namespace, string $name)
    {
        return Http::withToken(config('services.drone.token'))
            ->delete(config('services.drone.server') . "/user/repos/$namespace/$name");
    }



    /**
     * chownRepo
     * Submits a request to change the repository ownership
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function chownRepo(string $namespace, string $name)
    {
        return Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/user/repos/$namespace/$name/chown");
    }


    /**
     * repairRepo
     * Submits a request to repair the repository
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function repairRepo(string $namespace, string $name)
    {
        return Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/user/repos/$namespace/$name/repair");
    }

    /**
     * updateRepo
     * updates the repository and dispatches an event
     * to purge the object from the store.
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $repo
     * @return void
     */
    public static function updateRepo(string $namespace, string $name, array $repo)
    {
        return Http::withToken(config('services.drone.token'))
            ->patch(config('services.drone.server') . "/user/repos/$namespace/$name", $repo);
    }
}
