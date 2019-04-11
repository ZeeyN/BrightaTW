<?php 

class User extends DbObject 
{

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image', 'created_at');

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $created_at;
    public $image_placeholder = "http://placehold.it/400x400&text=image";
    protected $user_image;
    protected $tmp_path;



    public static function verifyUser($username, $password)
    {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
        $sql.= "username = '{$username}' ";
        $sql.= "LIMIT 1";
        $result_array = self::findByQuery($sql);        
        if(!empty($result_array))
        {
           $user = array_shift($result_array);
           if(password_verify($password, $user->password))
           {
            return $user;
           }
        } else {
            return false;
        }
    }


    public function imagePathOrPlaceholder()
    {
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }


    public function set_file($file)
    {
        if (empty($file) or !$file or !is_array($file)) 
        {
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif($file['error'] != 0) {
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else {
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];

        }
    }


    public function uploadPhoto()
    {
        if(!empty($this->errors))
        {
            return false;
        }
        if(empty($this->user_image) or empty($this->tmp_path))
        {
            $this->errors[] = "The file was not available";
            return false;
        }

        $target_path = SITE_ROOT . DS . $this->upload_directory . DS . $this->user_image;

        if(file_exists($target_path))
        {
            $this->errors[] = "The file {$this->user_image} alredy exists";
            return false;
        }
        if(move_uploaded_file($this->tmp_path, $target_path))
        {
            unset($this->tmp_path);
            return true;
        } else {
            $this->errors[] = "The folder probably does not have permition";//-------------For OS that didin't give permitions to folder automaticly (Linux, etc.) perfectly you'll never see this.
            return false;
        }
    }

}//END
