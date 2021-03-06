<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controleur des books
 * 
 * 
 */
class Social extends CI_Controller
{
    function add_fav($book_id = null) {
        
        if(!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        
        if($this->input->post('book_id')) {

            $data['book_id'] = $this->input->post('book_id');
            $data['user_id'] = $this->session->userdata('user_id');
            $this->load->model('social_model');
            
            $result = $this->social_model->add_fav($data);
            
            switch($result) {
                
                case '1' :
                    $msg = "Ce book a bien été ajouté à vos favoris";
                    break;
                    
                case '2' : 
                    $msg = "Ce book est déjà dans vos favoris";
                    break;
                    
                case '3' :
                    $msg = "Error";
                    break;
            } 
            
            echo($msg);  
            
        } else {
            if(isset($book_id)) {
                $data['book_id'] = $book_id;
                $data['user_id'] = $this->session->userdata('user_id');
                $this->load->model('social_model');
                $result = $this->social_model->add_fav($data);    
                
                redirect('book/show/'.$book_id);
                            
            }
        }
        
    }

    function favorites() {
        
        if(!$this->session->userdata('user_id')) {
            redirect('main');
        }
        
        $this->load->model('social_model');
        
        $favs = $this->social_model->get_user_favs($this->session->userdata('user_id'));
        
        $this->load->model('books');
        
        $params = array(
        'with_pictures' => true,
        'with_fav_count' => true,
        );
        
        foreach ($favs as $key => $book) {
            
            $books[] = $this->books->get_book($book->book_id, $params);
        }
        
        $data['books'] = $books;
        $data['view'] = 'candidat/favorites';
        
        $this->load->view('common/templates/main-fixed', $data);
    }
    
    
    
    function del_fav($book_id, $origin = null) {
        
        $this->load->model('social_model');
        
        $data['book_id'] = $book_id;
        $data['user_id'] = $this->session->userdata('user_id');
        
        $this->social_model->del_fav($data);
        
        if(isset($origin)) {
            switch($origin) {
                case 'book' :
                    redirect('book/show/'.$book_id);
                    break;
            }
        } else {
            redirect('social/favorites');
        }
    }
    
    
    /**
     * Page de contact par mail
     */
    function contact() {

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('subject', 'Le sujet du mail', 'required');
        $this->form_validation->set_rules('message', 'Le message', 'required');
        $this->form_validation->set_rules('email', 'Indiquer votre adresse email', 'required|valid_email'); 
        $this->form_validation->set_rules('motive', 'Indiquer la raison de votre message', 'required');
        
        $this->form_validation->set_message('required', '%s est obligatoire.');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');       
        
        // validation
        if ($this->form_validation->run())
        {
            // le formulaire est envoyé
            $this->load->library('email');
            
            $this->email->from($this->input->post('email'));
            $this->email->to('florbooks@gmail.com'); 
            $this->email->cc($this->input->post('email')); 
            
            $this->email->subject('[florBooks] '.$this->input->post('subject'));
            $this->email->message($this->input->post('message'));  
            
            if($this->email->send()) {
                // message de réussite
                $data['view'] = 'common/contact-form-submitted';
                $this->load->view('common/templates/main-fixed',$data);
            } else {
                $data['view'] = 'common/contact-form-problem';
                $this->load->view('common/templates/main-fixed', $data);
            }
        } else {

            if($this->session->userdata('user_id')) {
                $this->load->model('user');
                $data['user'] = $this->user->get_user();            
            }

            // affichage du formulaire
            $data['view'] = 'common/contact-form';
            $this->load->view('common/templates/main-fixed',$data);                
            
        }
    }


    /**
     * Informations pour le partage facebook
     */
    function share_book($book_id) {
        
        $params = array();
        
        $this->load->model('books');
        $data = $this->books->get_book($book_id,$params);
        
        // cover url
        if(isset($data->cover->pic_url)) : 
            $data->cover_url = $data->cover->th_url;
        else :
            $data->cover_url = $data->pictures[0]->th_url;
        endif;
        
        $this->config->load('facebook'); 
        $data->app_id = $this->config->item('facebook_appId');
        
        $this->load->view('social/share_book',$data);
    }

    /**
     * Page dédiée au partage facebook
     */
    function share_pic($pic_id) {
        $this->load->model('picture_model', 'picture');
        $this->picture->get_pic($pic_id);
        $data = new stdClass();
        
        // données sur l'image
        $data->picture = $this->picture->get_pic($pic_id)->picture; 
        
        // url bitly      
        $data->pic_url = $this->picture->get_pic_view_url($data->picture->book_id, $pic_id);
        
        // appId Facebook
        $this->config->load('facebook'); 
        $data->app_id = $this->config->item('facebook_appId');        
        
        $this->load->view('social/share_pic',$data);
    }
    
    
    /**
     * Affiche la vue de partage en fonction du type d'élément
     * 
     */
    function share($type, $id) {
        
        switch($type) {
            case 'book' :
                $this->load->model('books');
                $data = new stdClass();
                $data->book = $this->books->get_book($id);
                $data->view = 'social/share_book_options';
                $this->load->view('common/templates/main-fixed', $data);
                break;
                
            case 'picture' :
                $this->load->model('picture_model', 'picture');
                $data = new stdClass();
                $data->picture = $this->picture->get_pic($id)->picture;
                $data->pic_url = $this->picture->get_pic_view_url($data->picture->book_id, $id);
                $data->view = 'social/share_pic_options';
                $this->load->view('common/templates/main-fixed', $data);
                break;
        }
        
        
        
        
    }


    
    
}