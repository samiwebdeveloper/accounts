<?php

class Cal extends CI_Controller {
    
	function __construct() {
    parent::__construct();
    date_default_timezone_set('Asia/Karachi');
    $this->load->model('Commonmodel');
    //$this->load->model('Agentmodel');
    }


	public function index($customer_id){
    $sz_return_formula  ="";
    $dz_return_formula  ="";
    $sc_return_formula  ="";
    $sc_return_rate     =0;
    $sz_return_rate     =0;
    $dz_return_rate     =0;
    $order_pre          =0;
	//1=============Get Return Rate From Saimtech_rate By Customer ID
	$returndetail=$this->Commonmodel->Get_record_by_double_condition_array('saimtech_rate', 'customer_id', $customer_id, 'is_enable', 1);
	if(!empty($returndetail)){
	$sz_return_formula  =$returndetail[0]['sz_return_formula'];
    $dz_return_formula  =$returndetail[0]['dz_return_formula'];
    $sc_return_formula  =$returndetail[0]['sc_return_formula'];
    $sc_return_rate     =$returndetail[0]['sc_return_rate'];
    $sz_return_rate     =$returndetail[0]['sz_return_rate'];
    $dz_return_rate     =$returndetail[0]['dz_return_rate'];    
	//End===========Get Return Rate From Saimtech_rate By Customer ID
    $orders=$this->Commonmodel->Get_Sc_By_Customer_RTS($customer_id);
    if(!empty($orders)){
    foreach($orders as $rows){    
    echo $order_type     = $rows->order_rate_type;
    echo $order_id       = $rows->order_id;
    echo $order_sc       = $rows->order_sc;
    echo $order_pre_total= $rows->order_total_amount;
    echo "<br>";
    //-----SameZone---------------------
    if($order_type=='SZ'){
     if($sz_return_formula=='PER'){
     $order_pre=0;
     $order_pre=(($order_sc * $sz_return_rate)/100);
      $data=array('order_return_sc'  => $order_pre);
         
     } else if($sz_return_formula=='FIX'){   
     $order_pre= $sz_return_rate;
      $data=array('order_return_sc'  => $order_pre);
    //End--SameZone---------------------        
    //-----SameCity---------------------
    } else if($order_type=='WC'){
        if($sc_return_formula=='PER'){
        $order_pre=0;
        $order_pre=(($order_sc * $sc_return_rate)/100);    
         $data=array('order_return_sc'  => $order_pre);
    
        } else if($sc_return_formula=='FIX'){   
        $order_pre=$sc_return_rate;
         $data=array('order_return_sc'  => $order_pre);
     }  
    //End--SameCity---------------------
    //-----Different Zone---------------------
    } else if($order_type=='DZ'){
         if($dz_return_formula=='PER'){
         $order_pre=0;
         $order_pre=(($order_sc * $dz_return_rate)/100);
          $data=array('order_return_sc'  => $order_pre);
     } else if($dz_return_formula=='FIX'){   
     $order_pre=$dz_return_rate;
      $data=array('order_return_sc'  => $order_pre);
     }  
    }
    $this->Commonmodel->Update_Triple_record('saimtech_order', 'customer_id', $customer_id, 'order_status', 'RTS', 'is_invoice','0',$data);
    
    //End--Different Zone---------------------
    
    }
    }
    //2=============Get Order Sc From Saimtech_order By Customer ID AND RTS
    //Loop
    //2.1=============Update Order Return Sc INTO Saimtech_order By ORDER ID 
    //END=============Update Order Return Sc INTO Saimtech_order By ORDER ID
    //ENDLoop
	//End===========Get Order Sc From Saimtech_order By Customer ID AND RTS
	}
	}
	
}

}
