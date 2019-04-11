<?php 

class DbObject

{
    public $upload_directory = "images";
    public $errors = array();
    public  $upload_errors_array = array(

        UPLOAD_ERR_OK           => "There is no error",
        UPLOAD_ERR_INI_SIZE     => "The upload file exceeds the UPLOAD_MAX_FILESIZE directive.",
        UPLOAD_ERR_FORM_SIZE    => "The upload file exceeds the MAX_FILE_SIZE directive.",
        UPLOAD_ERR_PARTIAL      => "The upload file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE      => "No file was uploaded.", 
        UPLOAD_ERR_NO_TMP_DIR   => "Missing temporary folder.",
        UPLOAD_ERR_CANT_WRITE   => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION    => "A PHP extension stopped the file upload.",

    );




    
    public static function findAll()
    {
        return static::findByQuery("SELECT * FROM " . static::$db_table);
    }

    
    public static function findById($id)
    {
        $result_array = static::findByQuery("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }


    public static function findByQuery($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while($row = mysqli_fetch_array($result_set))
        {
            $object_array[] = static::instantiation($row);
        }
        return $object_array;
    }


    public static function instantiation($record)
    {
        $calling_class = get_called_class();
        $object = new $calling_class;
        foreach($record as $attribute => $value)
        {
            if($object->hasAttribute($attribute))
            {
                $object->$attribute = $value;
            }
        }
        return $object;
    }


    private function hasAttribute($attribute)
    {
        $object_props = get_object_vars($this);
        return array_key_exists($attribute, $object_props);
    }


    public function create () 
    {
        global $database;

        $properties = $this->cleanProps();

        $sql = "INSERT INTO " . static::$db_table . "(" . join(",", array_keys($properties)) . ")";
        $sql.= " VALUES('" . join("','", array_values($properties)) .  "')";

        if($database->query($sql))
        {
            $this->id = $database->insertId();
            return true;
        } else {
            return false;
        }
    }


    protected function cleanProps()
    {
        global $database;

        $clean_properties = array();
        foreach($this->properties() as $key => $value)
        {
            $clean_properties[$key] = $database->escapeString($value);
        }
        return $clean_properties;
    }


    protected function properties()
    {
        $properties = array();
        foreach(static::$db_table_fields as $db_field)
        {
            if(property_exists($this, $db_field))
            {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }
}//END
