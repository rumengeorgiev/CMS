<?php
class Users_model extends CI_Model
{
    public function validate_login() 
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            return TRUE;
        }
    }
    
    function _check_username() 
    {
        $username = $this->input->post('username');         
        $this->db->select('username');
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if ($query->num_rows() !=0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    function _check_email() 
    {
        $email = $this->input->post('email');         
        $this->db->select('email');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        
        if ($query->num_rows() !=0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    public function insert_user() 
    {
        $user_data = array(
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email'),
            'fname' => $this->input->post('fname'),
            'lname' => $this->input->post('lname')
            );
        
        $query = $this->db->insert('users', $user_data);
        
        if ($this->db->affected_rows() == 1) {
            return TRUE; 
        }
        else {
            return FALSE;
        }
    }
    
    
}
