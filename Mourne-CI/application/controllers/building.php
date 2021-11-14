<?php

class Building extends MO_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($id)
    {
        $this->load->helper('url');
        redirect('building/stats/' .$id);
    }

    public function stats($slotid = 0)
    {
        if (!$slotid) {
            $this->load->helper($url);
            redirect('village/selected');
        }

        $this->headers('do', $slotid);

        if ($this->building['id'] == 1) {
            $this->load->helper('url');
            redirect('building/build');
        }

        if ($this->building['id'] == 2) {
            //build_in_progress

            $this->headers('build_in_progress');

            $event = $this->_filter_events('type', 'slotid', $slotid, 0, true);

            $data['event'] = $event;
            $data['building'] = $this->building_model->get_building($event['data1']);
      
            $this->load->view('building/header', $data);
            $this->load->view('building/spacer');
            $this->load->view('building/next_event', $data);
            $this->load->view('building/stats', $data);
    
            $this->footer();
    
            return;
        }

        $this->headers('building', $slotid);

        $data['slotid'] = $slotid;

        $this->load->view('building/stats', $data);

        $this->footer();
    }

    public function upgrade($slotid = 0)
    {
        if (!$slotid) {
            $this->load->helper('url');
            redirect('village/selected');
        }

        $this->headers('building', $slotid);

        $event = $this->_filter_events('type', 'slot', $slotid, 1);

        $up['slotid'] = $slotid;

        if ($this->building['next_rank']) {
            $up['slotid'] = $slotid;

            $up['nextrank'] = $this->building_model->get_building(
                $this->building['next_rank']
            );

            $up['upgrade'] = $this->building_model->can_be_upgraded(
                $event,
                $this->resources,
                $up['nextrank'],
                $this->villageid
            );
        }

        $this->load->view('building/upgrade', $up);
        $this->footer();
    }

    public function create($slotid = 0)
    {
        if (!$slotid) {
            $this->load->helper($url);
            redirect('village/selected');
        }

        $this->headers('building', $slotid);

        //can create something
        if ($this->building['creates']) {
            $events = $this->_filter_events('type', 'all', $slotid, 2);

            $this->load->model('unit_model');

            $data['unit'] = $this->unit_model->get_unit($this->building['creates']);

            if ($data['unit']['cost_unit']) {
                $data['costu'] = $this->unit_model->get_unit(
                    $data['unit']['cost_unit']
                );
            } else {
                $data['costu'] = false;
            }

            $this->load->model('resource_model');
            
            //This should be one function
            $data['maxunit'] = $this->resource_model->calc_max_unit(
                $data['unit'],
                $this->building['num_creates'],
                $this->resources
            );

            $data['maxunit'] = $this->unit_model->calc_max_unit_ev(
                $this->building['num_creates'],
                $data['maxunit'],
                $events
            );

            if ($events) {
                $d['event'] = $events;
                $this->load->view('building/events', $d);
            }
        }

        $data['building'] = $this->building;
        $this->load->view('building/building_create', $data);

        $this->footer();
    }

    public function assign($slotid)
    {
        if (!$slotid) {
            $this->load->helper($url);
            redirect('village/selected');
        }

        $this->headers('building', $slotid);

        //have assignments
        $this->load->model('assignment_model');

        $assign = $this->assignment_model->get_assignments(
            $slotid,
            $this->villageid,
            $this->userid
        );

        $assign['slotid'] = $slotid;

        $this->load->view('building/assignments', $assign);

        $this->footer();
    }

    public function spells($slotid)
    {
        if (!$slotid) {
            $this->load->helper($url);
            redirect('village/selected');
        }

        $this->headers('building', $slotid);

        $this->load->model('spell_model');

        $spell['spells'] = $this->spell_model->get_spells(
            $slotid,
            $this->villageid
        );
            
        $spell['slotid'] = $slotid;

        $this->load->view('building/spells', $spell);
        $this->footer();
    }

    public function events($slotid = 0)
    {
        if (!$slotid) {
            $this->load->helper($url);
            redirect('village/selected');
        }

        $this->headers('building', $slotid);

        //$this->load->model('event_model');
        //$data['event'] = $this->event_model->get_events($slotid,
        //						    $this->villageid);

        $data['event'] = $this->_filter_events('all', 'slot', $slotid);

        $this->load->view('building/events', $data);

        $this->footer();
    }

    public function research($slotid = 0)
    {
        if (!$slotid) {
            $this->load->helper('url');
            redirect('village/selected');
        }

        $this->headers('building', $slotid);

        $events = $this->_filter_events('type', 'slot', $slotid, 4);

        if (!$events) {
            $this->load->model('technology_model');

            $data = $this->technology_model->get_researchable(
                $slotid,
                $this->villageid
            );

            $data['slotid'] = $slotid;


            $this->load->view('building/research', $data);
        } else {
            $this->load->model('technology_model');

            $data['technology'] = $this->technology_model->get_technology($events[0]['data1']);

            $this->load->view('building/al_research', $data);
        }

        $this->footer();
    }

    public function build($slotid = 0)
    {
        if (!$slotid) {
            $this->load->helper('url');
            redirect('village/selected');
        }

        $this->load->model('building_model');

        $this->_get_slot_building($slotid);

        $this->headers('build');

        if ($this->building['id'] == 1) {
            //empty space

            $data['buildings'] = $this->building_model->building_list(
                $this->villageid
            );

            $data['slotid'] = $slotid;
            $this->load->view('building/list', $data);
        } else {
            //slot has some building
            $this->load->helper('url');
            redirect('building/stats/' . $slotid);
        }

        $this->footer();
    }

    public function dobuild()
    {
        $this->load->helper('url');

        $slotid = $this->input->post('slotid');
        $buildingid = $this->input->post('id');

        if (!$slotid || !$buildingid) {
            redirect('village/selected');
        }

        $this->headers('do');

        $this->load->model('building_model');
        //$this->load->model('event_model');
        $this->load->model('resource_model');

        //check if building exists
        if (!$this->building_model->is_valid_slot($slotid, $this->villageid)) {
            //display error page
            echo "is_valid_slot returned FALSE";
            return;
        }

        $building = $this->building_model->get_building($buildingid);

        if (!$this->building_model->check_resources($this->resources, $building)) {
            //display error page
            echo "You don't have enough resources";
            return;
        }

        /*
            //do this matters? maybe it should be removed.
            if ($this->event_model->has_event($slotid, $this->villageid))
            {
              //display error page
              echo "has_event returned TRUE";
              return;
            }
        */
        /* this probably aren't needed
            if (!$this->building_model->can_build($this->villageid, $buildingid))
            {
              //display an error page
              echo "can_build returned FALSE";
              return;
            }
        */

        //can be built
        if (!$this->building_model->has_req_tech($building['req_tech'], $this->villageid)) {
            echo "Technology requirements not met.";
            return;
        }

        //add_event
        $this->load->helper('event');

        $ev['type'] = ev_type('build');
        $ev['villageid'] = $this->villageid;
        $ev['slotid'] = $slotid;
        $ev['time'] = $building['time_to_build'];
        $ev['data1'] = $buildingid;

        $this->event_model->add_event($ev);

        //resource substract
        $this->resource_model->set_resources($this->resources);
        $this->resource_model->substract_resources(
            $building,
            $this->villageid
        );
        $this->resource_model->write_resources();

        //change tile to build in progress
        $this->building_model->set_build_in_progress($slotid, $this->villageid);

        $url = 'building/stats/' . $slotid;
        redirect($url);
    }

    public function docreate($slotid)
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'create_num',
            'Number to create',
            'is_natural_no_zero'
        );

        $this->load->helper('url');
        $url = 'building/create/' . $slotid;

        $this->headers('do', $slotid);

        if ($this->form_validation->run()) {
            $num_create = $this->input->post('create_num');

            if (!$num_create) {
                redirect($url);
            }

            $this->load->model('building_model');

            $building = $this->building;

            $this->headers('do');

            if ($building['id'] == 1 || $building['id'] == 2) {
                //TODO show proper error
                echo "There isn't any building in that slot";
                return;
            }

            if (!$building['creates']) {
                //TODO show proper error
                echo "that building can't create units";
                return;
            }

            $event = $this->_filter_events('type', 'slot', $slotid, 2);

            $this->load->model('resource_model');
            $res = $this->resources;

            $this->load->model('unit_model');
            $unit = $this->unit_model->get_unit($building['creates']);

            $max = $this->resource_model->calc_max_unit(
                $unit,
                $building['num_creates'],
                $res
            );

            $max = $this->unit_model->calc_max_unit_ev(
                $building['num_creates'],
                $max,
                $event
            );

            if (!$max) {
                //TODO proper error
                echo "You can't make any";
                return;
            }

            if ($num_create > $max) {
                //TODO proper error
                echo "You can't make that many";
                return;
            }

            //add event
            $this->load->helper('event');

            $ev['type'] = ev_type('create');
            $ev['villageid'] = $this->villageid;
            $ev['slotid'] = $slotid;
            $ev['time'] = ($unit['time_to_create'] * $num_create);
            $ev['data1'] = $unit['id'];
            $ev['data2'] = $num_create;

            $this->event_model->add_event($ev);

            $this->resource_model->set_resources($this->resources);
            $this->resource_model->substract_resources(
                $unit,
                $this->villageid,
                $num_create
            );

            $this->resource_model->write_resources();

            redirect($url);
        } else {
            redirect($url);
        }
    }

    public function doupgrade()
    {
        $this->headers('do');

        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('slotid', 'Slotid', 'is_natural');

        if ($this->form_validation->run()) {
            $this->load->model('event_model');
            $this->load->model('resource_model');
            $this->load->model('building_model');

            $slotid = $this->input->post('slotid');

            $this->headers('do', $slotid);

            $building = $this->building;

            if (!$building['next_rank']) {
                echo "Building doesn't have next rank.";
                return;
            }

            $next_rank = $this->building_model->get_building($building['next_rank']);
            $res = $this->resources;


            $event = $this->_filter_events('type', 'slot', $slotid, 1);

            $can = $this->building_model->can_be_upgraded(
                $event,
                $res,
                $next_rank,
                $this->villageid
            );

            if ($can == 3) {
                //can be upgraded

                $this->load->helper('event');

                $ev['type'] = ev_type('upgrade');
                $ev['villageid'] = $this->villageid;
                $ev['slotid'] = $slotid;
                $ev['time'] = $next_rank['time_to_build'];
                $ev['data1'] = $next_rank['id'];
                $ev['data2'] = $building['id'];

                $this->event_model->add_event($ev);

                $this->resource_model->set_resources($this->resources);
                $this->resource_model->substract_resources(
                    $next_rank,
                    $this->villageid
                );

                $this->resource_model->write_resources();

                $url = 'building/upgrade/' . $slotid;
                redirect($url);
            } elseif ($can == 1) {
                echo "Village doesn't have the required technology.";
                return;
            } elseif ($can == 2) {
                //not enough resources
                echo "Not enough resources";
                return;
            } else {
                //upgrading in progress
                echo "Upgrade already in progress.";
                return;
            }
        } else {
            redirect('village/selected');
        }
    }

    public function doassign()
    {
        $this->headers('do');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('num_assign', 'Assigned number', 'is_natural');
        $this->form_validation->set_rules('slotid', 'slotid', 'required|is_natural');
        $this->form_validation->set_rules(
            'assignmentid',
            'Assignmentid',
            'required|is_natural'
        );

        if ($this->form_validation->run()) {
            $assid = $this->input->post('assignmentid');
            $slotid = $this->input->post('slotid');
            $num_assign = $this->input->post('num_assign');

            $this->load->model('assignment_model');

            $a = $this->assignment_model->assign_unit(
                $assid,
                $num_assign,
                $slotid,
                $this->resources,
                $this->villageid,
                $this->userid
            );

            //error handling with return value
            if ($a == 1) {
                //no building in that slot
                echo "No building in that slot";
                return;
            }

            if ($a == 2) {
                //no such assignmentid
                echo "No such assignmentid";
                return;
            }

            if ($a == 3) {
                //building soesn't have that assignment
                echo "Building doesn't have that assignment";
                return;
            }

            if ($a == 4) {
                echo "You don't have any units that can be assigned in that slot";
                return;
            }


            $this->load->helper('url');
            redirect('building/assign/' . $slotid);
        } else {
            $this->load->helper('url');
            redirect('village/selected');
        }
    }

    public function dospell()
    {
        $this->headers('do');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('spellid', 'spellid', 'required|is_natural');
        $this->form_validation->set_rules('slotid', 'slotid', 'required|is_natural');

        if ($this->form_validation->run()) {
            $spellid = $this->input->post('spellid');
            $slotid = $this->input->post('slotid');

            $this->load->model('spell_model');

            $a = $this->spell_model->use_spell(
                $spellid,
                $slotid,
                $this->resources,
                $this->villageid
            );

            //error handling with return value
            if ($a == 1) {
                echo "Building doesn't have that spell";
                return;
            }

            if ($a == 2) {
                echo "spell is on cooldown";
                return;
            }

            if ($a == 3) {
                echo "Not enough resources";
                return;
            }



            $this->load->helper('url');
            redirect('building/spells/' . $slotid);
        } else {
            $this->load->helper('url');
            redirect('village/selected');
        }
    }

    public function doresearch()
    {
        $this->load->helper('url');

        $slotid = $this->input->post('slotid');
        $techid = $this->input->post('id');

        if (!($slotid || $techid)) {
            redirect('village/selected');
        }

        $this->headers('do');

        $event = $this->_filter_events('type', 'slot', $slotid, 4);

        if ($event) {
            echo "Already researching.";
        }

        $this->load->model('technology_model');

        $a = $this->technology_model->do_research(
            $techid,
            $this->resources,
            $slotid,
            $this->villageid
        );

        if ($a == 1) {
            echo "Technology ID doesn't exist";
            return;
        }

        if ($a == 2) {
            echo "Not enough resources";
            return;
        }

        if ($a == 3) {
            echo "Building doesn't have that technology, or you already have it";
            return;
        }

        redirect('building/research/' . $slotid);
    }
}
//nowhitesp
