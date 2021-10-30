<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//means set_selected
if (!function_exists('ss'))
{
  function ss($d1, $d2, $o1, $o2)
  {
    if ($o1 == $d1 && $o2 == $d2)
    {
      if ($d1 == 'eq')
	return 'equipment_entry_selected';
      else
	return 'inventory_entry_selected';
    }
  }
}

//quality_(in)inventory
if (!function_exists('qi'))
{
  function qi($row)
  {
    if ($row)
    {
      switch ($row['quality'])
      {
        case (0):
          return 'iv_quality_really_poor';
        case (1):
          return 'iv_quality_poor';
        case (2):
          return 'iv_quality_good';
        case (3):
          return 'iv_quality_great';
        case (4):
          return 'iv_quality_epic';
        case (5):
          return 'iv_quality_legendary';
        case (6):
          return 'iv_quality_omg';
      }
    }
  }
}

//quality_(in)character('s view)
if (!function_exists('qc'))
{
  function qc($equipment, $id)
  {
    if ($equipment[$id])
    {
      switch ($equipment[$id]['quality'])
      {
        case (0):
          return 'eq_quality_really_poor';
        case (1):
          return 'eq_quality_poor';
        case (2):
          return 'eq_quality_good';
        case (3):
          return 'eq_quality_great';
        case (4):
          return 'eq_quality_epic';
        case (5):
          return 'eq_quality_legendary';
        case (6):
          return 'eq_quality_omg';
      }
    }
  }
}

if (!function_exists('can_be_equipped'))
{
  function can_be_equipped($item, $hero)
  {
    if (!$item)
      return FALSE;

    $data['can'] = FALSE;
    $data['message'] = '';
    $data['allowed_slot1'] = FALSE;
    $data['allowed_slot2'] = FALSE;
    $data['two_handed'] = FALSE;

    if ($item['type'] != 1)
    {
      $data['message'] = 'That item cannot be equipped.';
      return $data;
    }

    if ($item['req_class'] != 0 && $item['req_class'] != $hero['class'])
    {
      $data['message'] = 'You can never use that item.';
      return $data;
    }

    if ($item['req_level'] > $hero['level'])
    {
      $data['message'] = 'Your level is too low to use that item.';
      return $data;
    }

    if ($item['subtype'] == 6)
    {
      $data['can'] = TRUE;
      $data['allowed_slot1'] = 6;
      return $data;
    }
    elseif ($item['subtype'] == 12)
    {
      $data['can'] = TRUE;
      $data['allowed_slot1'] = 12;
      $data['allowed_slot2'] = 13;
      return $data;
    }
    elseif ($item['subtype'] == 14)
    {
      $data['can'] = TRUE;
      $data['allowed_slot1'] = 14;
      $data['allowed_slot2'] = 15;
      return $data;
    }
    elseif ($item['subtype'] == 19)
    {
      if ($hero['class'] == 2)
      {
	$data['can'] = TRUE;
	$data['allowed_slot1'] = 19;
	return $data;
      }
    }

    $datatype = array(
      //warrior
      '1' => array(0, 1, 2, 3, 4),
      //rogue
      '2' => array(0, 1, 2, FALSE, FALSE),
      //archer
      '3' => array(0, 1, 2, 3, FALSE));    

    $dataeqslots = array(
      //head
      '0' => array(0, FALSE),
      //neck
      '1' => array(1, FALSE),
      //shoulder
      '2' => array(2, FALSE),
      //back
      '3' => array(3, FALSE),
      //chest
      '4' => array(4, FALSE),
      //shirt
      '5' => array(5, FALSE),
      //bracer
      '7' => array(7, FALSE),
      //gloves
      '8' => array(8, FALSE),
      //belt
      '9' => array(9, FALSE),
      //legs
      '10' => array(10, FALSE),
      //foots
      '11' => array(11, FALSE),
      );

    //this means every item, whose subsubtype means the type (like cloth)
    if ($item['subtype'] >= 0 && $item['subtype'] < 6 || $item['subtype'] > 6 && $item['subtype'] < 12)
    {
      if ($datatype[$hero['class']][$item['subsubtype']] !== FALSE)
      {
	$data['can'] = TRUE;
	$data['allowed_slot1'] = $dataeqslots[$item['subtype']][0];
	$data['allowed_slot2'] = $dataeqslots[$item['subtype']][1];
	return $data;
      }
      else
      {
	$data['can'] = FALSE;
	$data['message'] = "You don't have the required proficiency to use that item.";
	return $data;
      }
    }
    
    $dataclasswep = array(
      //warrior
      '1' => array(FALSE, FALSE, FALSE, FALSE, 5, 6, 7, 8, 9, 10, 
		   11, 12, 13, 14, 15, 16, FALSE, FALSE, FALSE, 20, FALSE),
      //rogue
      '2' => array(FALSE, 2, 3, 4, 5, 6, 7, FALSE, 9, 10, 
		   11, FALSE, 13, 14, 15, FALSE, FALSE, FALSE, FALSE, FALSE, 21),
      //archer
      '3' => array(FALSE, 2, 3, 4, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, 
		   FALSE, FALSE, 13, 14, 15, 16, 17, 18, 19, FALSE, FALSE)
      );

    //array(first slot, second slot, two Handed)
    $datawep = array(
      //staff
      '1' => array(16, FALSE, TRUE),
      //dagger one, main, off
      '2' => array(16, 17, FALSE),
      '3' => array(16, FALSE, FALSE),
      '4' => array(17, FALSE, FALSE),
      //mace one main, off, 2h
      '5' => array(16, 17, FALSE),
      '6' => array(16, FALSE, FALSE),
      '7' => array(17, FALSE, FALSE),
      '8' => array(16, FALSE, TRUE),
      //axe one, main, off, 2h
      '9' => array(16, 17, FALSE),
      '10' => array(16, FALSE, FALSE),
      '11' => array(17, FALSE, FALSE),
      '12' => array(16, FALSE, TRUE),
      //sword one, main, off, 2h
      '13' => array(16, 17, FALSE),
      '14' => array(16, FALSE, FALSE),
      '15' => array(17, FALSE, FALSE),
      '16' => array(16, FALSE, TRUE),
      //bow, crossbow, gun
      '17' => array(18, 17, FALSE),
      '18' => array(18, FALSE, FALSE),
      '19' => array(18, FALSE, FALSE),
      //?? warri, rogue ranged
      '20' => array(18, FALSE, FALSE),
      '21' => array(18, FALSE, FALSE)
      );

    if ($item['subtype'] == 16)
    {
      if ($dataclasswep[$hero['class']][$item['subsubtype']] !== FALSE)
      {
	$data['can'] = TRUE;
	$data['allowed_slot1'] = $datawep[$item['subsubtype']][0];
	$data['allowed_slot2'] = $datawep[$item['subsubtype']][1];
	$data['two_handed'] = $datawep[$item['subsubtype']][2];
	return $data;
      }
    }

    $data['can'] = FALSE;
    $data['message'] = 'You cannot use that item.';
    return $data;
  }
}