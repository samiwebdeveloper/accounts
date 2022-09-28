<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
  tr.group,
  tr.group:hover {
    background-color: #ddd !important;
    font-weight: 600;
  }

  .form-control[disabled],
  .form-control[readonly],
  fieldset[disabled] .form-control {
    color: black;
  }
</style>
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
            <li class="breadcrumb-item">Accounts</li>
            <li class="breadcrumb-item">Over Night Manifested Report</li>
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
                <div class="card ">
                  <div class="card-header  separator">
                    <div class="form-group-attached">
                      <form action="<?php echo base_url(); ?>report/overnight_manifested" method="post">
                        <div class="row clearfix">
                          <div class="col-sm-4">
                            <div class="form-group form-group-default required" id="user_name_div">
                              <label>Start Date</label>
                              <?php if ($startdate != "") {
                                $startdate;
                                $enddate;
                              }  ?>
                              <input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php echo  $startdate; ?>">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group form-group-default required">
                              <label>End Date</label>
                              <input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php echo $enddate; ?>">
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary" style="height:100%">GO</button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive m-t-10">
                    <table class="table table-bordered compact nowrap" id='myTable' widht="100%" style="border-top:1px solid black ;">
                      <thead>
                        <tr>
                          <th>Sr#</th>
                          <th>order code</th>
                          <th>manual cn</th>
                          <th>order date</th>
                          <th>arrival date</th>
                          <th>transit data</th>
                          <th>transit code</th>
                          <th>customer </th>
                          <th>service </th>
                          <th>order status</th>
                          <th> invoice</th>
                          <th>shipper</th>
                          <th>consignee</th>
                          <th>origin</th>
                          <th>destination</th>
                          <th>pieces</th>
                          <th>weight</th>
                          <th>total amount</th>

                          <th>rate</th>
                        </tr>
                      </thead>
                      <tbody id="tableload">
                        <?php if (!empty($detail)) {
                          $i = 1;
                          foreach ($detail as $rows) {
                            echo ("<tr>");
                            echo ("<td>" . $i . "</td>");
                            echo ("<td>" . $rows->order_code . "</td>");
                            echo ("<td>" . $rows->manual_cn . "</td>");
                            echo ("<td>" . $rows->order_date . "</td>");
                            echo ("<td>" . $rows->arrival_date . "</td>");
                            echo ("<td>" . $rows->transit_date . "</td>");
                            echo ("<td>" . $rows->transit_code . "</td>");
                            echo ("<td>" . $rows->customer_name . "</td>");
                            echo ("<td>" . $rows->service_name . "</td>");
                            echo ("<td>" . $rows->order_status . "</td>");
                            if ($rows->is_invoice) {
                              echo ("<td><span style='font-weight:500 ;padding:2px ;border-radius: 5px;' class='bg-success text-white'> Completed</span></td>");
                            } else {
                              echo ("<td><span style='font-weight:500 ;padding:2px ;border-radius: 5px;' class='bg-danger text-white '> Pending </span></td>");
                            }
                            echo ("<td>" . $rows->shipper_name . "</td>");
                            echo ("<td>" . $rows->consignee_name . "</td>");
                            echo ("<td>" . $rows->origin_city_name . "</td>");
                            echo ("<td>" . $rows->destination_city_name . "</td>");
                            echo ("<td>" . number_format($rows->pieces) . "</td>");
                            echo ("<td>" . number_format($rows->weight) . "</td>");
                            echo ("<td>" . number_format($rows->order_total_amount) . "</td>");

                            echo ("<td>" . $rows->add_rate . "</td>");
                            echo ("</tr>");
                            $i++;
                          }
                        } ?>
                      </tbody>
                    </table>
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
  </div>
</div>
<?php
$this->load->view('inc/footer');
?>
<script>
  $(document).ready(function() {
    data_array()
  })

  function data_array() {
    var table = $('#myTable').DataTable({
      "lengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      "fixedHeader": true,
      "searching": true,
      "paging": true,
      "ordering": true,
      "bInfo": true,
      dom: 'Blfrtip',
      buttons: [
        'colvis',
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'A3',
          footer: 'true',
          title: "Invoices List",
          text: "<i class='fs-14 pg-download'></i> PDF",
          titleAttr: 'PDF',
          message: "T.M. Cargo\n  Powered By IT Department \n Date:<?php echo '' . date('Y-m-d'); ?> \n Over night manifested  Report \n "
        },
        {
          extend: 'excelHtml5',
          text: "<i class='fs-14 pg-form'></i> Excel",
          titleAttr: 'Excel',
          sheetName: 'Over night manifested  Report',
          exportOptions: {
            modifier: {
              page: 'current'
            }
          }
        },
        {
          extend: 'copyHtml5',
          footer: 'true',
          text: "<i class='fs-14 pg-note'></i> Copy",
          titleAttr: 'Copy'
        },
        {
          extend: 'print',
          text: "<i class='fs-14 pg-ui'></i> Print",
          titleAttr: 'Print',
          footer: 'true',
          title: "Booking Reconcile List",
          message: "T.M. Cargo<br>Date:<?php echo '' . date('Y-m-d'); ?> <br>  <br>Over night manifested  Report<br>"
        }
      ],
      displayLength: 25,
    });
  }
</script>