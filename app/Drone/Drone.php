<?php

namespace App\Drone;

use Illuminate\Support\Facades\Http;
use App\Drone\Api\Repo;

class Drone
{

    /**
     * =====
     * = REPOS
     * =====
     */

    /**
     * repos
     * This function gets a list of repos,
     * @param  mixed $latest - Boolean value. Default true, will give you the latest build
     * @return void
     */

    public static function repos($latest = true)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos?latest=$latest");
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
            ->get(config('services.drone.server') . "/repos/$namespace/$name");
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
            ->post(config('services.drone.server') . "/repos/$namespace/$name");
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
            ->delete(config('services.drone.server') . "/repos/$namespace/$name");
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
            ->post(config('services.drone.server') . "/repos/$namespace/$name/chown");
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
            ->post(config('services.drone.server') . "/repos/$namespace/$name/repair");
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
            ->patch(config('services.drone.server') . "/repos/$namespace/$name", $repo);
    }



    /**
     * =====
     * = BUILDS
     * =====
     */

    /**
     * builds
     *  fetches the build list
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $page
     * @return void
     */
    public static function builds($namespace, $name, $page = 1)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/builds?page=$page");
    }

    /**
     * branches
     * List of branches per repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function branchesBuild($namespace, $name)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/builds/branches");
    }


    /**
     * deployments
     * Fetch a list of deployments per repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function deployments($namespace, $name)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/builds/deployments");
    }

    /**
     * build
     * Fetch a certain build based on the id
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @return void
     */
    public static function build($namespace, $name, $build)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/builds/$build");
    }

    /**
     * cancelBuild
     * Cancel a build
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @return void
     */
    public static function cancelBuild(string $namespace, string $name, $build)
    {
        return  Http::withToken(config('services.drone.token'))
            ->delete(config('services.drone.server') . "/repos/$namespace/$name/builds/$build");
    }

    /**
     * createBuild
     * Creates a build based on the latest commit
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @return void
     */
    public static function createBuild(string $namespace, string $name, $build)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/builds/$build");
    }

    /**
     * createDeployment
     * Create a deployment and spawn a new build from an existing entry
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @param  mixed $target
     * @param  mixed $action
     * @param  mixed $params
     * @return void
     */
    public static function createDeployment(string $namespace, string $name, $build, $target, $action, $params)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/builds/$build/$action?target=$target");
    }


    /**
     * approveBuild
     * Approve a build/stage and have it continue
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @param  mixed $stage
     * @return void
     */
    public static function approveBuild(string $namespace, string $name, $build, $stage)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/builds/$build/approve/$stage");
    }

    /**
     * declineBuild
     * Decline a build and cancel it
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @param  mixed $stage
     * @return void
     */
    public static function declineBuild(string $namespace, string $name, $build, $stage)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/builds/$build/decline/$stage");
    }

    public static function buildsFeed()
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/user/builds/recent");
    }


    /**
     * =====
     * = Cron jobs
     * =====
     */


    /**
     * crons
     * Fetch a cron list
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function crons(string $namespace, string $name)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/cron");
    }

    /**
     * cron
     * Fetch a certain cron
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $cron
     * @return void
     */
    public static function cron(string $namespace, string $name, $cron)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/cron/$cron");
    }

    /**
     * deleteCron
     * Delete a cron
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $cron
     * @return void
     */
    public static function deleteCron(string $namespace, string $name, $cron)
    {
        return  Http::withToken(config('services.drone.token'))
            ->delete(config('services.drone.server') . "/repos/$namespace/$name/cron/$cron");
    }

    /**
     * createCron
     * Create a cron for the repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $cron
     * @return void
     */
    public static function createCron(string $namespace, string $name, array $cron)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/cron", $cron);
    }


    /**
     * updateCron
     * Update cron information
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $cron_name
     * @param  mixed $cron
     * @return void
     */
    public static function updateCron(string $namespace, string $name, $cron_name, array $cron)
    {
        return  Http::withToken(config('services.drone.token'))
            ->patch(config('services.drone.server') . "/repos/$namespace/$name/cron/$cron_name", $cron);
    }

    /**
     * =====
     * = Logs
     * =====
     */

    /**
     * logs
     * Fetch logs for a build
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $build
     * @param  mixed $stage
     * @param  mixed $step
     * @return void
     */
    public static function logs(string $namespace, string $name, $build,  $stage, $step)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/builds/$build/logs/$stage/$step");
    }


    /**
     * =====
     * = Members
     * =====
     */

    /**
     * members
     * Fetches the list of members inside of the repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function members(string $namespace, string $name)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/collaborators");
    }

    public static function deleteMember(string $namespace, string $name, string $username)
    {
        return  Http::withToken(config('services.drone.token'))
            ->delete(config('services.drone.server') . "/repos/$namespace/$name/collaborators/$username");
    }


    /**
     * =====
     * = Secrets
     * =====
     */

    /**
     * secrets
     * Fetch a list of secrets for the repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @return void
     */
    public static function secrets(string $namespace, string $name)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/secrets");
    }

    /**
     * secret
     * Fetch one secret based on the id
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $secret
     * @return void
     */
    public static function secret(string $namespace, string $name, $secret)
    {
        return  Http::withToken(config('services.drone.token'))
            ->get(config('services.drone.server') . "/repos/$namespace/$name/secrets/$secret");
    }

    /**
     * deleteSecret
     * Delete a secret from the repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $secret_name = SECRET NAMe
     * @return void
     */
    public static function deleteSecret(string $namespace, string $name, $secret_name)
    {
        return  Http::withToken(config('services.drone.token'))
            ->delete(config('services.drone.server') . "/repos/$namespace/$name/secrets/$secret_name");
    }

    /**
     * createSecret
     * Create a secret in the repo
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $secret
     * @return void
     */
    public static function createSecret(string $namespace, string $name, array $secret)
    {
        return  Http::withToken(config('services.drone.token'))
            ->post(config('services.drone.server') . "/repos/$namespace/$name/secrets", $secret);
    }

    /**
     * updateSecret
     * Update a secret information
     * @param  mixed $namespace
     * @param  mixed $name
     * @param  mixed $secret_name
     * @param  mixed $secret
     * @return void
     */
    public static function updateSecret(string $namespace, string $name, $secret_name, array $secret)
    {
        return  Http::withToken(config('services.drone.token'))
            ->patch(config('services.drone.server') . "/repos/$namespace/$name/secrets/$secret_name", $secret);
    }
}
