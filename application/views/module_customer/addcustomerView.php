<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
  $(document).ready(function() {
    //$('#data_panel').saimtech();
    //$('#pending_panel').saimtech();
    $('#pay_mode').select2();
    $('#service_type').select2({
      placeholder: "Select Service",
      tags: true,
      tokenSeparators: [',', ' ']
    });
    $('#reference_by').select2();
    $('#secondary_reference_by').select2();
    $('#operating_type').select2();
    $('#calculation_type').select2();
    $('#brand_city').select2();
    $('#bunits').select2();
    $('#Country').select2();
    $('#bank_name').select2();
    $('#gst_type').select2();
    $('#data_panel').saimtech();
    $('#pending_panel').saimtech();
  });
</script>
<!-- START PAGE CONTENT WRAPPER -->
<div class="page-content-wrapper">
  <!-- START PAGE CONTENT -->
  <div class="content">
    <!-- START JUMBOTRON -->
    <div class="jumbotron" data-pages="parallax">
      <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
        <div class="inner">
          <!-- START BREADCRUMB -->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Manage</li>
            <li class="breadcrumb-item">Customer</li>
            <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
          </ol>
          <!-- END BREADCRUMB -->
        </div>
      </div>
    </div>
    <!-- END JUMBOTRON -->
    <!-- START CONTAINER FLUID -->
    <div class="container-fluid container-fixed-lg">
      <!-- BEGIN PlACE PAGE CONTENT HERE -->
      <div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <!-- START card -->
          <div class=" container-fluid   container-fixed-lg bg-gray">
            <div class="row">
              <div class="col-md-12">
                <div class="card m-t-10">
                  <div class="card-header  separator">
                    <div class="card-title">Add Customer View</div>
                    <div class="card-controls">
                      <ul>
                      </ul>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class=" container-fluid   container-fixed-lg">
                      <div class="row row-same-height">
                        <div class="col-md-12">
                          <div class="padding-30 sm-padding-5">
                            <form role="form" method="post" action="<?php echo base_url(); ?>Customer/add_customer">
                              <p>Brand Details</p>
                              <div class="form-group-attached">
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Name</label>
                                      <input type="text" placeholder="Enter Brand Name" class="form-control" id="brand_name" name="brand_name" required="" tabindex=1>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>CNIC</label>
                                      <input type="text" class="form-control" placeholder="Enter CNIC" class="form-control" id="brand_cnic" name="brand_cnic" tabindex=2>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Payment Mode</label>
                                      <select class="form-control" required="" id="pay_mode" name="pay_mode" tabindex=3>
                                        <option value=''>Select Payment Mode</option>
                                        <option value='1'>Account</option>
                                        <option value='2'>FOD</option>
                                        <option value='3'>Account & FOD</option>
                                        <option value='4'>Cash</option>
                                        <option value='5'>FOC</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Operating type</label>
                                      <select class="form-control" required="" id="operating_type" name="operating_type" tabindex=4>
                                        <option value=''>Select Type</option>
                                        <option value='LW'>Same City</option>
                                        <option value='NW'>Different City</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Company URL</label>
                                      <input type="text" class="form-control" placeholder="Enter website URL" name="brand_url" id="brand_url" tabindex=7>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Service Type</label>
                                      <input type="hidden" name="services_type" id="services_type">
                                      <select class='form-control' required="" name="serivce_type" id="service_type" multiple="multiple" onchange="services()" tabindex=6>
                                        <option value='0'>Select Service</option>
                                        <option value='1'>Over Night</option>
                                        <option value='2'>Over Land</option>
                                        <option value='3'>Detain</option>
                                        <option value='4'>Air Frieght</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                      <label>NTN</label>
                                      <input type="text" class="form-control" placeholder="Enter NTN" name="brand_ntn" id="brand_ntn" tabindex=8>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Product Type</label>
                                      <input type="text" class="form-control" required="" id="brand_product" name="brand_product" tabindex=9>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Select Calculation Type</label>
                                      <select class='form-control' required="" name="calculation_type" id="calculation_type" tabindex=10>
                                        <option value="">Select Calculation</option>
                                        <option value="Addition">Addition</option>
                                        <option value="Multiplication">Multiplication</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group form-group-default required">
                                  <label>Slip Name</label>
                                  <input type="text" class="form-control" required="" id="brand_note" name="brand_note" tabindex=11>
                                </div>
                              </div>
                              <br>
                              <p>Company Address Detail</p>
                              <div class="form-group-attached">
                                <div class="form-group form-group-default required">
                                  <label>Address</label>
                                  <input type="text" class="form-control" id="brand_address" name="brand_address" placeholder="Current address" required="" tabindex=12>
                                </div>
                                <div class="form-group-attached">
                                  <div class="form-group form-group-default required">
                                    <label>Contact Person Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Contact Person" name="pickup_points" id="pickup_points" tabindex=13 required="">
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>City</label>
                                      <select class="form-control" name='brand_city' id='brand_city' required tabindex=14>
                                        <option value=''>Select City</option>
                                        <?php
                                        if (!empty($cities_data)) {
                                          foreach ($cities_data as $rows) {
                                            echo ("<option value='" . $rows->city_id . "'>" . $rows->city_full_name . "</option>");
                                          }
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Country</label>
                                      <select class="form-control" name='Country' id='Country'>
                                        <option value=''>Pakistan</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Email</label>
                                      <input type='email' class="form-control" name='brand_email' id='brand_email' placeholder="Enter Email" tabindex=15>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Phone</label>
                                      <input type='text' class="form-control" name='brand_phone' id='brand_phone' placeholder="Enter Phone" tabindex=16>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <p>Bank Detail</p>
                              <div class="form-group-attached">
                                <div class="form-group form-group-default">
                                  <label>Name</label>
                                  <select class="form-control" id="bank_name" name="bank_name" tabindex=17>
                                    <option value="">Select Bank</option>
                                    <option>ADVANCE MICROFINANCE</option>
                                    <option>AL BARAKA BANK LIMITED</option>
                                    <option>ALLIED BANK LIMITED</option>
                                    <option>APNA MICROFINANCE BANK</option>
                                    <option>ASKARI BANK LIMITED</option>
                                    <option>BANK AL HABIB LTD</option>
                                    <option>BANK ALFALAH LIMITED</option>
                                    <option>BANK OF PUNJAB</option>
                                    <option>BANKISLAMI BANK</option>
                                    <option>BURJ BANK LIMITED</option>
                                    <option>CITIBANK</option>
                                    <option>DUBAI ISLAMIC BANK</option>
                                    <option>FAYSAL BANK LIMITED</option>
                                    <option>FINCA MICRO FINANCE BANK LTD</option>
                                    <option>FIRST WOMEN BANK</option>
                                    <option>HABIB BANK LIMITED</option>
                                    <option>HABIB METROPOLITAN BANK LIMITED</option>
                                    <option>INDUSTRIAL COMMERCIAL BANK OF CHINA</option>
                                    <option>JS BANK LIMITED</option>
                                    <option>KASB BANK LIMITED</option>
                                    <option>MCB ISLAMIC BANK LIMITED</option>
                                    <option>MEEZAN BANK LIMITED</option>
                                    <option>MOBILINK MICROFINANCE</option>
                                    <option>MUSLIM COMMERCIAL BANK</option>
                                    <option>NATIONAL BANK OF PAKISTAN</option>
                                    <option>NATIONAL RURAL SUPPORT PROGRAMME</option>
                                    <option>NIB BANK LIMITED</option>
                                    <option>SAMBA</option>
                                    <option>SILK BANK</option>
                                    <option>SINDH BANK</option>
                                    <option>SONERI BANK LIMITED</option>
                                    <option>STANDARD CHARTERED BANK PAKISTAN LTD</option>
                                    <option>SUMMIT BANK</option>
                                    <option>TELENOR MICROFINANCE BANK LTD</option>
                                    <option>U MICROFINANCE</option>
                                    <option>UNITED BANK LIMITED</option>
                                  </select>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Account Title</label>
                                      <input type="text" class="form-control" id='account_title' name='account_title' placeholder="Enter Bank Account Title" tabindex=18>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Account Number</label>
                                      <input type="text" class="form-control" id='account_no' name='account_no' placeholder="Enter Bank Account Number" tabindex=19>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-group form-group-default">
                                  <label>IBAN</label>
                                  <input type="text" class="form-control" id='account_iban' name='account_iban' placeholder="Enter IBAN" tabindex=20>
                                </div>
                              </div>
                              <br>
                              <p>Surcharges</p>
                              <div class="form-group-attached">
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default" id="gst_div">
                                      <label>G.S.T</label>
                                      <input type="number" class="form-control" id='gst' name='gst' placeholder="Enter G.S.T like 16.00" tabindex=15>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default" id="fuel_div">
                                      <label>Fuel Surcharge</label>
                                      <input type="number" class="form-control" id='fuel' name='fuel' placeholder="Enter Fuel Surcharge like 5.00" tabindex=16>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-12">
                                    <div class="form-group form-group-default" id="others_div">
                                      <label>Others</label>
                                      <input type="number" class="form-control" id='others' name='others' placeholder="Enter G.S.T like 16.00" tabindex=17>
                                    </div>
                                  </div>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-4">
                                    <div class="form-group form-group-default" id="faf_div">
                                      <label>Percentage</label>
                                      <input type="number" class="form-control" id='faf' name='faf' placeholder="Enter F.A.F like 10.00" tabindex=1>
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-group form-group-default" id="faf_start_div">
                                      <label>Start Date</label>
                                      <input type="date" class="form-control" id='faf_start_date' name='faf_start_date' placeholder="Pick a date" tabindex=2 min="<?php echo date('Y-m-d', strtotime($min_date . ' + 1 days')); ?>" value="<?php echo date('Y-m-d', strtotime($min_date . ' + 1 days')); ?>">
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-group form-group-default" id="faf_end_div">
                                      <label>End Date</label>
                                      <input type="date" class="form-control" id='faf_end_date' name='faf_end_date' placeholder="Pick a date" tabindex=3 min="<?php echo date('Y-m-d', strtotime($min_date . ' + 2 days')); ?>" value="<?php echo date('Y-m-d', strtotime($min_date . ' + 8 days')); ?>">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <p>Units</p>
                              <div class="row clearfix">
                                <div class="col-sm-12">
                                  <div class="form-group form-group-default required" id="bunit_div">
                                    <label>Billable Units</label>
                                    <select class='form-control' required="" name="bunits" id="bunits" tabindex=20>
                                      <option value='W'>Weight</option>
                                      <option value='P'>Piece</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <p>Login Detail</p>
                              <div class="form-group-attached">
                                <div class="form-group form-group-default required">
                                  <label>Display Name</label>
                                  <input type="text" class="form-control" name="display_name" id="display_name" placeholder="Account Display Name" required="" tabindex=21>
                                </div>
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required" id="user_name_div">
                                      <label>Username</label></label>
                                      <input type="text" class="form-control" name="user_name" id="user_name" onblur="check_username()" placeholder="Account User Name" required="" tabindex=22>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required">
                                      <label>Password</label>
                                      <input type="text" class="form-control" name="user_password" id="user_password" placeholder="Account User Password" required="" tabindex=23>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <p>Reference Detail</p>
                              <div class="form-group-attached">
                                <div class="row clearfix">
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default required" id="user_name_div">
                                      <label>Reference By</label></label>
                                      <select class="form-control" name='reference_by' id='reference_by' required="" tabindex=24>
                                        <option value=''>Select Reference</option>
                                        <?php
                                        if (!empty($reference_data)) {
                                          foreach ($reference_data as $rows) {
                                            echo ("<option value='" . $rows->reference_id . "'>" . $rows->reference_name . "</option>");
                                          }
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="form-group form-group-default">
                                      <label>Freelancer Reference By</label>
                                      <select class="form-control" name='secondary_reference_by' id='secondary_reference_by' tabindex=25>
                                        <option value=''>Select Freelancer Reference</option>
                                        <?php
                                        if (!empty($freelancer_data)) {
                                          foreach ($freelancer_data as $rows) {
                                            echo ("<option value='" . $rows->reference_id . "'>" . $rows->reference_name . "</option>");
                                          }
                                        }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <br>
                              <button type="submuit" class='btn btn-primary pull-right' tabindex=26>Open Customer Account</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END card -->
            </div>
          </div>
          <!-- END PLACE PAGE CONTENT HERE -->
        </div>
        <!-- END CONTAINER FLUID -->
      </div>
      <!-- END PAGE CONTENT -->
      <script>
        function check_username() {
          var username = $("#user_name").val();
          var mydata = {
            username: username
          };
          $.ajax({
            url: "<?php echo base_url(); ?>Customer/check_username",
            type: "POST",
            data: mydata,
            success: function(data) {
              if (data == 0) {
                $("#user_name_div").css("border-color", "green");
              } else if (data != 0) {
                $("#user_name_div").css("border-color", "red");
                $("#user_name").focus();
              }
            }
          });
        }

        function services() {
          var st = $("#service_type").val();
          if (st.length > 1) {
            for (var i = 0; i < st.length; i++) {
              if (st[i] === '0') {
                st.splice(i, 1);
              }
            }
          }
          $("input[name=services_type]:hidden").val(st.join(","));
        }
      </script>
    </div>
  </div>
  <?php
  $this->load->view('inc/footer');
  ?>