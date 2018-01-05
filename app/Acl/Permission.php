<?php

namespace App\Acl;

use Sentinel;

class Permission
{

    /**
     * Check user has permissions
     * @param  [type]  $permissions [description]
     * @return boolean              [description]
     */
    public static function has($permissions)
    {
        $user = Sentinel::check();
        if ($user && ($user->inRole('root') || Sentinel::hasAccess($permissions))):
            return true;
        endif;
        return false;
    }

}
