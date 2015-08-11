<h2>New page</h2>

<?=  validation_errors('<p style="color: red;">','</p>'); ?>
<?=  anchor(base_url().'index.php/members', 'Back'); ?>
<?= form_open() ;?>
<table width="900" cellpadding="8" cellspacing="0" border="1">
    <tr>
        <td>Page Headline:
        <?php
        $data = array(
            'name' => 'page_headline',            
            'value' => $page_headline,
            'maxlength' => '230',
            'size' => '40',
            'style' => 'width:280px' 
        );
        echo form_input($data);
        ?>
        </td>
        
        <td>Page Title:
        <?php
        $data = array(
            'name' => 'page_title',            
            'value' => $page_title,
            'maxlength' => '230',
            'size' => '50',
            'style' => 'width:320px' 
        );
        echo form_input($data);
        ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">Keywords:
        <?php
        $data = array(
            'name' => 'keywords',           
            'value' => $keywords,
            'maxlength' => '230',
            'size' => '50',
            'style' => 'width:765px' 
        );
        echo form_input($data);
        ?>        
        </td>
    </tr>
    
    <tr>
        <td colspan="2">Page Description:
        <?php
        $data = array(
            'name' => 'description',            
            'value' => $description,
            'maxlength' => '230',
            'size' => '50',
            'style' => 'width:710px' 
        );
        echo form_input($data);
        ?>               
        </td>
    </tr>
    
    <tr>
        <td colspan="2">Page Content: <br>
        <?php 
        if ($edit) {
            if (is_array($page_content) || is_object($page_content)) {
                foreach ($page_content as $key =>$value) {
                    $data = array(
                        'name' => 'page_content['.$key.']',           
                        'value' => $value,
                        'rows' => '15',
                        'cols' => '100',
                        'style' => 'width:550px' 
                    );          
                    echo form_textarea($data); 
                    echo '<script>
                            CKEDITOR.replace("page_content['.$key.']");
                          </script>';
                    
                    if ($delete) {
                        echo form_submit('del['.$key.']', 'Delete Content');
                    }
                }
            }    
        } else {
            $data = array(
                        'name' => 'page_content[0]',           
                        'value' => '',
                        'rows' => '20',
                        'cols' => '100',
                        'style' => 'width:200px' 
                    );          
                    echo form_textarea($data);
                    echo '<script>
                            CKEDITOR.replace("page_content[0]");
                          </script>';
        }
        ?>
        </td>
    </tr>
    
    <?php if ($edit) { ?>
    <tr><td colspan="2" align="center"><?=form_submit('add', 'More Content');?></td></tr>
    <?php } ?>
        
    <tr><td colspan="2" align="center"><?=form_submit('submit', 'Submit');?></td></tr>
    
</table>
<?= form_close(); ?>