<?php
class Page_model extends CI_Model 
{
    function get_table() 
    {
        $table = "webpages";
        return $table;
    }
    
    function get_table2() 
    {
        $table = "content";
        return $table;
    }
    
    function getWhere($id) 
    {
        $this->db->select('*');
        $this->db->from('webpages');
        $this->db->join('content', 'content.page_id = webpages.id');
        $this->db->where('content.page_id',$id);
        $query = $this->db->get();
        return $query;
    }
    
    function get($order_by) 
    {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }   
    
    function getWhereCustom($value)
    {
        $this->db->select('*');
        $this->db->from('webpages');
        $this->db->join('content', 'content.page_id = webpages.id');
        $this->db->where('webpages.page_url', $value);
        $query = $this->db->get();
        return $query;
    }
    
    function _insert($data) 
    {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
    function _insertContent($data) 
    {
        $table = $this->get_table2();
        $this->db->insert($table, $data);
    }

    function _update($id, $data) 
    {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }
    function _updateContent($id, $data) 
    {
        $table = $this->get_table2();
        $this->db->where('id', $id);
        $this->db->update($table, $data);
    }
    
    function deletePage($id) 
    {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->delete($table);
        $this->db->where('page_id', $id);
        $this->db->delete('content');
    } 
    
    public function deleteContent($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('content');
       
    } 
    
    public function moreContent($page_id) 
    {
        $data['page_id'] = $page_id; 
        $table = $this->get_table2();
        $this->db->insert($table, $data);        
    }
    
           
}


 