<?php
	//WC=With in City
	//SZ=Same in Zone
	//DZ=Different in Zone
	//UK=Unknown
	//PSB=Portal Single Booking
	//PIB=Portal Import Booking
	//WAB=Web Api Booking
	
	class Tracking extends CI_Controller {
		
		function __construct() {
			parent::__construct();
			$this->load->model('Commonmodel');
			$this->load->model('Trackingmodel');
		}
		
		
		public function index($cn=0)
		{
			$data['Shipment_id']=$cn;	
			$this->load->view('module_tracking/HomeView',$data); 	
		}
		
		public function Search($cn){
			$lenght=strlen($cn);
			//------Get Shipment Information
			$shipments_data=$this->Trackingmodel->Get_Shipment_Date_By_Cn($cn);
			$shipmenta_data=$this->Trackingmodel->Get_Shipment_Date_By_Cn_Archive($cn);
			$shipment_data=array_merge($shipments_data,$shipmenta_data);
			//------
			//------Check Array-----Start---
			if(!empty($shipment_data)){
				//----Get Values----------
				$id 			 	= $shipment_data[0]['order_id'];	
				$cn 			 	= $shipment_data[0]['order_code'];
				$manul_cn 			 = $shipment_data[0]['manual_cn'];
				$status 			 = $shipment_data[0]['order_status'];
				$customer_name 			= $shipment_data[0]['customer_name'];
				$shipper_name 			= $shipment_data[0]['shipper_name'];
				$shipper_mobile 		= $shipment_data[0]['shipper_phone'];
				$shipper_address 		= $shipment_data[0]['shipper_address'];
				$reference_no			= $shipment_data[0]['customer_reference_no']; 
				$order_date 	 	= $shipment_data[0]['order_date'];
				$booking_date 	 	= $shipment_data[0]['order_booking_date'];
				$arrival_date 		 	= $shipment_data[0]['order_arrival_date'];
				$deliver_date 		 	= $shipment_data[0]['order_deliver_date'];
				$order_status 		 	= $shipment_data[0]['order_status'];
				$destination			= $shipment_data[0]['destination_city_name'];
				$origin 		 		= $shipment_data[0]['origin_city_name'];
				$weight 				= $shipment_data[0]['weight'];
				$pieces 				= $shipment_data[0]['pieces'];
				$order_pay_mode 		= $shipment_data[0]['order_pay_mode'];
				$cod_amount 			= $shipment_data[0]['cod_amount'];
				$consignee_name 		= $shipment_data[0]['consignee_name'];
				$consignee_email 		= $shipment_data[0]['consignee_email'];
				$consignee_address 		= $shipment_data[0]['consignee_address'];
				$consignee_mobile 		= $shipment_data[0]['consignee_mobile'];
				$order_remark 			= $shipment_data[0]['order_remark'];
				$product_detail 		= $shipment_data[0]['product_detail'];
				$order_receive_from		= $shipment_data[0]['order_receive_from'];
				$receive_by   = $shipment_data[0]['shipment_received_by'];
				$paymode = $shipment_data[0]['order_pay_mode'];
				//----Get Values-------End--
				echo ("<a href='https://tmdelex.com/cargo/ops_tm/home' target='_blank' id='fixedbutton' class='btn'>Home</a>");
				echo ("<a href='https://cargo.tmcargoexpress.com/ops_tm/Booking/Booking/print_address_label1/".$id ."' target='_blank' id='fixedbutton' class='btn'>Address Label</a>");
				
				//-------Load TabMenu----End--
				echo "<br><div class='table-responsive-md'><table class='table table-striped table-hover'>";
				//-2-----Line one status & ids------
				$this->LineOne($status,$manul_cn,$pieces,$weight);
				//-------Line one status & ids----End--
				//-3------Line Two------
				$this->LineTwo($shipper_name,$origin,$destination,$consignee_name);
				//-------Line Two----End--
				//-4-----Line Three------
				$this->LineThree($shipper_mobile,$shipper_address,$consignee_mobile,$consignee_address);
				//-------Line Three----End--
				//-5-----Line Four------
				$this->LineFour($cn,$product_detail,$cod_amount,$customer_name,$order_pay_mode);
				//-------Line Four----End--
				//-7-----Line Six------
				$this->LineSix($order_date,$arrival_date,$deliver_date,$receive_by,$paymode);
				//------Line Six----End--
				
				echo "</table></div>";
				//-8-----Iframe-------------
				echo ("<div class='col'> <iframe width='100%' height='700px' name='lact' frameborder='0' style='background-color:#fff' scrolling='no' src='".base_url()."Tracking/ShowLact/".$id."' id='iframe' onload='javascript:resizeIframe(this);'></iframe></div>");
				//-------Iframe---------End--
				//------Check Array-----Else PART---	
				} else {
				echo "<div>";	
				echo "<p class='alert alert-danger'>No Shipment Found :(</p></div>";	
			}			
			//------Check Array-----END--			
		}		
		
		public function ShowLact($id){
			if($id > 0){
				$data['tracking_data']=$this->Trackingmodel->Get_Shipment_detail_by_orderID($id);
				if(sizeof($data['tracking_data'])> 0){
					$this->load->view('module_tracking/ShowLactView',$data); 	
				}
				} else {
				echo "<p>Further details are not available here yet.</p>";
			}
		}
		
		public function LineOne($status,$manul_cn,$pieces,$weight){
			echo "<tr>";
			echo "<th>Status</th>";
			//-------------------------------------
			echo "<td>".$status."</td>";
			//---------------------------------------
			echo "<th>Manual CN</th>";
			echo "<td>".$manul_cn."</td>";
			echo "<th>Pieces</th>";
			//--------------------------------------
			echo "<td>".$pieces."</td>";
			//--------------------------------------
			echo "<th>Weight</th>";
			echo "<td>".$weight."</td>";
			echo "</tr>";	
		}
		
		public function LineTwo($shipper_name,$origin,$destination,$consignee_name){
			echo "<tr>";
			echo "<th>Shipper Name</th>";
			echo "<td>".$shipper_name."</td>";
			echo "<th>Origin</th>";
			echo "<td>".$origin."</td>";
			
			echo "<th>Destination</th>";
			echo "<td>".$destination."</td>";
			echo "<th>Consignee Name</th>";
			echo "<td>".$consignee_name."</td>";
			echo "</tr>";
		}	
		
		public function LineThree($shipper_mobile,$shipper_address,$consignee_mobile,$consignee_address){
			
			echo "<tr>";
			echo "<th>Shipper Phone</th>";
			echo "<td>".$shipper_mobile."</td>";
			echo "<th>Shipper Address</th>";
			echo "<td>".$shipper_address."</td>";
			echo "<th>Consignee Phone</th>";
			echo "<td>".$consignee_mobile."</td>";
			echo "<th>Consignee Address</th>";
			echo "<td>".$consignee_address."</td>";
			echo "</tr>";
		}
		
		public function LineFour($cn,$product_detail,$cod_amount,$customer_name,$order_pay_mode){
			echo "<tr>";
			echo "<th>Electron ID</th>";
			echo "<td>".$cn."</td>";
			echo "<th>Comodity</th>";
			echo "<td>".$product_detail."</td>";
			if($order_pay_mode=="Cash"){
				echo "<th>Cash</th>";	
				} else if($order_pay_mode=="Account"){
				echo "<th>Account</th>";	
			}
			else {
				echo "<th>COD</th>";	
			}
			if($order_pay_mode=="Account" ){
				echo "<td>---</td>";	
				} else {
				echo "<td>".$cod_amount."</td>";	
			}
			//echo "<td width=12% bgcolor=#009a66 style='color:white;'>COD/Cash</td>";
			//echo "<td><code style='color:#009a66'>".$cod_amount."</td>";
			
			echo "<th>Customer Account</th>";
			echo "<td>".$customer_name."</td>";
		}		
		
		public function LineSix($order_date,$arrival_date,$deliver_date,$receive_by,$paymode){
			echo "<tr>";
			echo "<th>Booking Date</th>";
			echo "<td>".$order_date."</td>";
			echo "<th>Arrival</th>";
			if($arrival_date!="0000-00-00 00:00:00"){
				echo "<td><code'>".$arrival_date."</td>";	
				} else {
				echo "<td>---</td>";	
			}
			echo "<th>Deliver</th>";
			if($deliver_date!="0000-00-00 00:00:00"){
				echo "<td>".$deliver_date."</td>";	
				} else {
				echo "<td>---</td>";	
			}
			echo "<th>Receiver Name</th>";
			echo "<td>".$receive_by."</td>";
			echo "</tr>";
			
			if($_SESSION['user_id'] == '90' || $_SESSION['user_id'] == '98'){
				echo "<tr><th>Payment Mode</th><td colspan='7'>".$paymode."</td></tr>";
			}				
		}
		
	}
