<?php  if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (! function_exists('gender')) {
    function gender($gender = '')
    {
        if ($gender == 1) {
            return 'Male';
        } else {
            return 'Female';
        }
    }
}

if (! function_exists('class_name')) {
    function class_name($id = 0)
    {
        switch ($id) {
      case 1:
    return 'Warrior';
      case 2:
    return 'Rogue';
      case 3:
    return 'Archer';
      default:
    return 'Error';
    }
    }
}
