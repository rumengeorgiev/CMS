<style type="text/css">
    fieldset {
        width: 1200px;
        height: 600px;
        margin: 0 auto;
        padding: 0 50px;
        border: 1px;
        background-color: #eee;
    }    
</style>

<p> <h1>Content Management System</h1> <?=anchor('login/logout', 'Exit');?> </p>

<form>
    <fieldset>
    <?php    
    echo anchor('members/create', '<p>Create new page</p>');
    ?>
        <table width="600" cellspacing="0" cellspadding="8" border="1">
        <tr style="background-color: navy; color: white;">
            <th>Page Headline</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        
        <?= $success ? 'Success' : '' ?>  
            
        <?php    
            foreach ($query->result() as $row) {                
                $edit_url = base_url().'index.php/members/create/'.$row->id;
                $delete_url = base_url().'index.php/members/deletePage/'.$row->id;
                $page_headline = $row->page_headline;
         ?>
        <tr><td><?='<a href="members/view_page/'.$row->page_url.'">'.$page_headline.'</a>';?></td>
            <td><?=anchor($edit_url, 'Edit');?></td>
            <td><?=anchor($delete_url, 'Delete');?></td></tr>   
        <?php } ?>  
             
        </table>
    </fieldset>    
</form>


