<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (! function_exists('ev_type')) {
    function ev_type($ev)
    {
        if ($ev == 'build') {
            return 0;
        }

        if ($ev == 'upgrade') {
            return 1;
        }

        if ($ev == 'create') {
            return 2;
        }
    }
}
