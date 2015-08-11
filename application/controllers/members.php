<?php
class Members extends CI_Controller
{
    private $data = array();

    public function __construct() 
    {
        parent::__construct();
        $this->is_logged();
    }

    public function index() 
    {
        $this->load->model('page_model');
        
        $data['success'] = $this->session->userdata('success');
        $data['query'] = $this->page_model->get('page_headline');
        $data['main_view'] = 'members/members_area';
        
        $this->load->view('include/template', $data); 
        $this->session->unset_userdata('success');
    }    

    public function  create()
    {
        $this->load->model('page_model');
        
        $update_id = $this->uri->segment(3);
        
        $submit = $this->input->post('submit', TRUE);
        $add = $this->input->post('add', TRUE);
        $del = $this->input->post('del', TRUE);
        
        $edit = FALSE;
        $delete = FALSE;
        $this->data = $this->getDataFromPost();
        
        if ($submit == 'Submit') {
            $this->data['response'] = $this->submit();
            //TO DO show succes msg if $response is true
            if (is_numeric($update_id)) {  
                $edit = true;
                $delete = true;
            }
        } 
        else if ($add == 'More Content') {
            
            $this->page_model->moreContent($update_id); 
            redirect('members/create/'.$update_id);
        }
        else if (is_numeric($update_id)){            
            $data = $this->getDataFromDb($update_id);
            $edit = true;  
            
            if (count($data['page_content']) > 1) {
                $delete = TRUE;
            }

            if ($del == true) {
                foreach ($this->data['del'] as $k => $v) {                    
                    $this->page_model->deleteContent($k);
                    redirect('members/create/'.$update_id);
                }
            }  
        }
        
        if (!isset($data)) {
            $data = $this->getDataFromPost();
        }
        $data['delete'] = $delete;
        $data['edit'] = $edit;
        $data['update_id'] = $update_id;
        $data['main_view'] = 'webpages/create_page';
        $this->load->view('include/template', $data);  
        
    }
    
    public function view_page() 
    {
        $id = $this->uri->segment(3); 
        $this->load->model('page_model');
        $query = $this->page_model->getWhereCustom($id);
        foreach ($query->result() as $row) {
            $data['page_headline'] = $row->page_headline;
            $data['page_title'] = $row->page_title;
            $data['keywords'] = $row->keywords;
            $data['description'] = $row->description;
            $data['page_url'] = $row->page_url;
            $data['page_content'][$row->id] = $row->page_content;
        }
        
        $data['main_view'] = 'webpages/public_page';
        $this->load->view('include/template', $data);
    }
    
    public function submit() 
    {
        $this->load->model('page_model');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules(
            'page_headline',
            'Page_Headline', 
            'required|min_length[3]'
            ); 
        
        $this->form_validation->set_rules(
                'page_title',
                'Page_Title',
                'required'
            ); 
        
        $this->form_validation->set_rules(
                'keywords',
                'Keywords',
                'required'
            ); 
        
        $this->form_validation->set_rules(
                'description',
                'Description',
                'required'
            ); 
        
        foreach ($this->data['page_content'] as $key => $value) {
             $this->form_validation->set_rules(
                'page_content['.$key.']',
                'Page_Content',
                'required'
            );   
        }
        
        if ($this->form_validation->run($this) == true) {
            
            //page url
            $this->data['page_url'] = url_title($this->data['page_headline']);
            
            $update_id = $this->uri->segment(3);            
            $data1 = array(
                'page_headline' => $this->data['page_headline'],
                'page_title' => $this->data['page_title'],
                'keywords' => $this->data['keywords'],
                'description' => $this->data['description'],
                'page_url' => $this->data['page_url']
                ); 
               
            if (is_numeric($update_id)) {                 
                $this->page_model->_update($update_id, $data1);

                foreach ($this->data['page_content'] as $key => $value) {
                    $data2['page_content'] = $value;                  
                    $this->page_model->_updateContent($key, $data2);
                    $data2 = array();
                }                
            }
            else  {               
                $page_id = $this->page_model->_insert($data1);
                $data2['page_id'] = $page_id;
                $data2['page_content'] = $this->data['page_content'][0];
                $this->page_model->_insertContent($data2);         
            }
            
            $this->session->set_userdata('success', TRUE);
            redirect(base_url().'index.php/members');
        }     
    }

    public function getDataFromPost()
    {
        $data['page_headline'] = $this->input->post('page_headline', TRUE);
        $data['page_title'] = $this->input->post('page_title', TRUE);
        $data['keywords'] = $this->input->post('keywords', TRUE);
        $data['description'] = $this->input->post('description', TRUE);          
        $data['page_content'] = $this->input->post('page_content', TRUE);
        $data['del'] = $this->input->post('del', TRUE);
        return $data;
    }
    
    public function getDataFromDb($update_id) 
    {
        $this->load->model('page_model');
        $query =$this->page_model->getWhere($update_id);
        
        foreach ($query->result() as $row){
            $data['page_headline'] = $row->page_headline;
            $data['page_title'] = $row->page_title;
            $data['keywords'] = $row->keywords;
            $data['description'] = $row->description;
            $data['page_content'][$row->id] = $row->page_content ;
        }
        
        if (!isset($data)) {
            $data = '';
        }       
        
        return $data;
    }
    
    public function deletePage($id) 
    {
        $this->load->model('page_model');
        $this->page_model->deletePage($id);
        redirect(base_url().'index.php/members');
    }
    
    public function is_logged() 
    {
        $is_logged = $this->session->userdata('is_logged');
        if (!isset($is_logged) || $is_logged != TRUE) {  
            redirect(base_url().'index.php/login/logout');
            die();
        }
    }
    
    
}