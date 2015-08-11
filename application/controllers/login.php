<?php
class Login extends CI_Controller
{
    public function index() 
    {
        $data['success'] = $this->session->userdata('success');
        $data['main_view'] = 'login/login_form';
        $this->load->view('include/template', $data); 
        $this->session->unset_userdata('success');
    }

    public function validate() 
    {
        $this->load->library('form_validation');
        $val = $this->form_validation;

        $val->set_rules(
                'username',
                'Name',
                'trim|required|min_length[3]'
                );
        
        $val->set_rules(
                'password',
                'Pass',
                'trim|required|min_length[6]'
                );

        if ($val->run()) {
            //query
            $this->load->model('users_model');
            
            if ($this->users_model->validate_login()) {
                $data = array(
                    'is_logged' => TRUE,
                    'username' => $this->input->post('username')
                    );        

                $this->session->set_userdata($data);
                redirect('members');
            }
             else {
                $this->session->set_flashdata(
                    'errmsg', 
                    'The Name or Password not exist'
                    );
                redirect('login/index', 'refresh');
            }
        }
        else {
            $this->index();
        }
    }
    
    public function register()
    {
        $data['main_view'] = 'login/register_form';
        $this->load->view('include/template', $data);  
    }
    
    public function validate_register() 
    {
        $this->load->library('form_validation');
        $val = $this->form_validation;
        
        $val->set_rules(
            'username',
            'Username',
            'trim|required|alpha_numeric|min_length[3]|max_length[30]|is_unique[users.username]'
            );
        
        $val->set_rules(
            'password',
            'Password',
            'trim|required|min_length[6]|max_length[30]'
            );
        
        $val->set_rules(
            'password2',
            'Confirm Password',
            'trim|required|min_length[6]|max_length[30]|matches[password]'
            );
        
        $val->set_rules(
            'email',
            'Email Address',
            'trim|required|vali_email|max_length[50]|is_unique[users.email]'
            );
        
        $val->set_rules(
            'fname',
            'First Name',
            'trim|required|alpha_numeric|min_length[3]|max_length[30]'
            );
        
        $val->set_rules(
            'lname',
            'Last Name',
            'trim|required|alpha_numeric|min_length[3]|max_length[30]'
            );
        
        $val->set_error_delimiters('<p class="validation_err">','</p>');
        
        if ($val->run()) {
            $this->load->model('users_model');
            
            if ($this->users_model->insert_user()) {
                $this->index();
            }
            $this->session->set_userdata('success', TRUE);
        }        
        else {
            $this->register();
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}