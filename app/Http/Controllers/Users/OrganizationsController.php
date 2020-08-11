<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\User;

class OrganizationsController
{
    /**
     * Returns a list of organizations the current user is a member of.
     *
     * @throws \Exception
     */
    @@\Route('get', 'api/orgs')
    public function __invoke()
    {
        return User::getOrgByAdmin(...JWTController::getUser(false));
    }

    /**
     * Returns an individual organization.
     *
     * /org/{git_type}/{organization_name}
     *
     * @throws \Exception
     *
     * @return mixed
     */
    @@\Route('get', 'api/org/{git_type}/{organization_name}')
    public function find(string $git_type, string $org_name)
    {
        return User::getUserInfo($org_name, null, $git_type)[0] ?? [];
    }
}
