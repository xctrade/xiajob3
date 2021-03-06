<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controleur des pages "statiques"
 * 
 * 
 */
class Pages extends CI_Controller
{
    
    function coming_soon() {
        $data['view'] = 'common/pages/coming_soon';
        $this->load->view('common/templates/main-fixed',$data);
    }
    
    
    function cgu() {
        $data['view'] = 'common/pages/cgu';
        $this->load->view('common/templates/main-fixed',$data);
    }
    
    
    function hints() {
        $data['view'] = 'common/pages/florbooks-hints';
        $this->load->view('common/templates/main-fixed', $data);
    }
    
    function oups() {
        $data['view'] = 'common/pages/404';
        $this->load->view('common/templates/main-fixed', $data); 
    }
    
    function meet_the_gnomes() {
        $data['view'] = 'common/pages/who_we_are';
        $this->load->view('common/templates/main-fixed', $data);
    }
    
    function pitch() {
        $data['view'] = 'common/pages/pitch';
        $this->load->view('common/templates/main-fixed', $data);        
    }

    function team() {
        $data['view'] = 'common/pages/team';
        $this->load->view('common/templates/main-fixed', $data);        
    }      
    
    function participate() {
        $data['view'] = 'common/pages/participate';
        $this->load->view('common/templates/main-fixed', $data);           
    }  

    function faq() {
        $data['view'] = 'common/pages/faq';
        $this->load->view('common/templates/main-fixed', $data);           
    }  


    function privacy() {
        $data['view'] = 'common/pages/privacy';
        $this->load->view('common/templates/main-fixed', $data);
    }


    function property() {
        $data['view'] = 'common/pages/property';
        $this->load->view('common/templates/main-fixed', $data);
    }
    
    

    function legal() {
        $data['view'] = 'common/pages/legal';
        $this->load->view('common/templates/main-fixed', $data);
    }    
}