<?php


class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Commonmodel');
		$this->load->model('Loginmodel');
		$this->load->library('session');
	}

	public function index()
	{
		// $useragent = $_SERVER['HTTP_USER_AGENT'];
		// if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
		// 	$root = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
		// 	if ($root == "https") {
		// 		$data['error'] = "N";
		// 		$this->load->view('loginView', $data);
		// 	} else if ($root == "http") {
		// 		header('Location: https://' . $_SERVER['HTTP_HOST'] . '/accounts/');
		// 	}
		// } else {
		// 	$this->load->view('loginView', $data);
		// 	echo "<center><h1>System is not accesible on this device.</h1></center>";
		// }
		$this->load->view('loginView');

	}

	public function process_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if ($email != "" && $password != "") {
			$user_data = $this->Loginmodel->Get_User_Detail_By_Username($email);
			if (!empty($user_data)) {
				foreach ($user_data as $rows) {
					$userpassword = $rows->oper_user_password;
					if ($userpassword == md5($password)) {
						$_SESSION['user_id']			= $rows->oper_user_id;
						$_SESSION['user_name']			= $rows->oper_user_name;
						$_SESSION['account_no']			= $rows->oper_account_no;
						$_SESSION['origin_id']			= $rows->oper_user_city_id;
						$_SESSION['city_code']			= $rows->city_code;
						$_SESSION['origin_name']		= $rows->city_name;
						$_SESSION['reporting_orign_id']	= $rows->reporting_city;
						$_SESSION['user_power']			= $rows->oper_user_power;
						$_SESSION['reproting_station']	= $rows->oper_reporting_station;
						$_SESSION['thrid_party_id'] 	= $rows->thrid_party_id;
						$_SESSION['portal'] 	        = $rows->oper_user_portal;
						$_SESSION['is_supervisor'] 	    = $rows->is_supervisor;
						$_SESSION['user_mixture']		= $rows->mixtures;
						$this->Loginmodel->Update_Login_Date($_SESSION['user_id']);
						redirect('Home');
					} else {
						$data['error'] = "YN";
						$this->load->view('loginView', $data);
					}
				}
			} else {
				$data['error'] = "Y";
				$this->load->view('loginView', $data);
			}
		} else {
			$data['error'] = "Y";
			$this->load->view('loginView', $data);
		}
	}

	public function logout()
	{
		$this->Loginmodel->Update_Logout_Date($_SESSION['user_id']);
		$data['error'] = "N";
		session_destroy();
		$this->load->view('loginView', $data);
	}
}
