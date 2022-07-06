<?php
class Ccommonmodel extends CI_Model {


    function __construct(){
    parent::__construct();
    //load our second db and put in $db2
    $this->db2 = $this->load->database('delex', TRUE);
    }

	//======================================================================
	//START--------------Generic Function For Model-------------------------
	//======================================================================
	
	public function Delete_record($tablename, $columnname, $conditionvalue){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->delete($tablename);	
	}	

	public function Delete_record_double_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);
	$this->db2->delete($tablename);	
	}	
	
	
    public function Duplicate_check($tablename, $columnname, $conditionvalue){
    $this->db2->where($columnname, $conditionvalue);	
    $query = $this->db2->get($tablename);  
    return $query->num_rows();	
    }

    public function Duplicate_double_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
    $this->db2->where($columnname, $conditionvalue);	
    $this->db2->where($columnname1, $conditionvalue1);	
    $query = $this->db2->get($tablename);  
    return $query->num_rows();	
    }
    
    public function Duplicate_triple_check($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $columnname2, $conditionvalue2){
    $this->db2->where($columnname, $conditionvalue);	
    $this->db2->where($columnname1, $conditionvalue1);
    $this->db2->where($columnname2, $conditionvalue2);
    $query = $this->db2->get($tablename);  
    return $query->num_rows();	
    }

    public function rows_number($tablename){
    $query = $this->db2->get($tablename);  
    return $query->num_rows();	
    }

   
    public function Update_record($tablename, $columnname, $conditionvalue, $data){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->update($tablename, $data); 
	return $this->db2->affected_rows();      
	}

	public function Update_double_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1, $data){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);
	$this->db2->update($tablename, $data); 
	return $this->db2->affected_rows();      
	}
	
	
	public function Update_Triple_record($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,  $columnname2, $conditionvalue2, $data){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);
	$this->db2->where($columnname2, $conditionvalue2);
	$this->db2->update($tablename, $data); 
	return $this->db2->affected_rows();      
	}

    public function Insert_record($tablename, $data){
   	$this->db2->insert($tablename, $data);  
	return $this->db2->insert_id();      
    }

    public function Get_all_record($tablename){
    $query = $this->db2->get($tablename);  
    return $query->result();
    }

	public function Get_record_by_condition($tablename, $columnname, $conditionvalue){
	$this->db2->where($columnname, $conditionvalue);	
    $query = $this->db2->get($tablename);  
    return $query->result();
    }


	public function Get_record_by_condition_array($tablename, $columnname, $conditionvalue){
	$this->db2->where($columnname, $conditionvalue);	
    $query = $this->db2->get($tablename);  
    return $query->result_array();
    }

    public function Get_record_by_double_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);	
    $query = $this->db2->get($tablename);  
    return $query->result();
    }
    
    
    public function Get_record_by_double_condition_array($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);	
    $query = $this->db2->get($tablename);  
    return $query->result_array();
    }

    public function Get_record_by_triple_condition($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,$columnname2, $conditionvalue2){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);	
   	$this->db2->where($columnname2, $conditionvalue2);	
    $query = $this->db2->get($tablename);  
    return $query->result_array();
    }
    
    public function Get_record_by_triple_condition_non($tablename, $columnname, $conditionvalue, $columnname1, $conditionvalue1,$columnname2, $conditionvalue2){
	$this->db2->where($columnname, $conditionvalue);
	$this->db2->where($columnname1, $conditionvalue1);	
   	$this->db2->where($columnname2, $conditionvalue2);	
    $query = $this->db2->get($tablename);  
    return $query->result();
    }

    public function Get_record_by_join_and_condition($tablename, $columnname, $conditionvalue, $jointablename, $jointablecolumnname, $basecolumnname){
    $this->db2->select('*');
	$this->db2->from($tablename);
	$this->db2->join($jointablename, $jointablename.$jointablecolumnname = $tablename.$basecolumnname);
	$this->db2->where($columnname, $conditionvalue);	
	$query = $this->db2->get();
	return $query->result();
	}

	
}
