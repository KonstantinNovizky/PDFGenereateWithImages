<?php

if(!isset($_SESSION)) {
    // session isn't started
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 


$offSetNumber = 0;

if(isset($_SESSION['offSetNumber']))
{
    $offSetNumber = $_SESSION['offSetNumber'];
}


$sql = "SELECT * FROM cma_props WHERE propid='214' LIMIT 7 OFFSET " . $offSetNumber ;
$result = $conn->query($sql);

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Generate PDF</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="public/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="public/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="public/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="public/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="public/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="public/css/myadmin.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="public/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="public/css/fonts.css" rel="stylesheet">

    <link rel="stylesheet" href="public/css/custome.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <aside class="main-sidebar">
        <!-- Brand Logo -->
        <a href="javascript:void(0);" class="brand-link">
            <img src="public/images/Vieva Logo pro.png" alt="Vieva Logo" class="brand-image img-circle elevation-3">
            <span class="">Dashboard</span>
        </a>

    </aside>
    <div class="content-wrapper tab-content" id="custom-content-below-tabContent">

        <section class="content tab-pane fade show active" role="tabpanel"
                 aria-labelledby="custom-content-below-general-tab">

            <h4 class="pt-pb">Generate PDF</h4>
            <button class="btn btn-info btn-generate-pdf" onclick="generatePDF(this, 'generate_pdf')"> Generate PDF</button>
            <div class="container-fluid general_tab_view chart_view mt-5" id="generate_pdf" style="width: 80%;padding: auto">

                <?php
                    if ($result->num_rows > 0) {

                        $displayHtml = "";
                        while($row = $result->fetch_assoc()) {
                            $displayHtml .= '<div>';
                            $displayHtml .= '<div class="card-header">';
                            $displayHtml .= '<h3>Delivery Line: ' . $row["deliveryLine"] . '</h3>';
                            $displayHtml .= '<h3>City: ' . $row["city"] . ', Zip: ' . $row["zip"] . '</h3>';
                            $displayHtml .= '<h5>Street: ' . $row["street"] . ' (Latitude: ' . $row["latitude"] . ', Longitude: ' . $row["longitude"] . ')</h5>';
                            $displayHtml .= '</div>';
                            $displayHtml .= '<div class="card-body">';
                            $displayHtml .= '<p>Sale Price: ' . $row["salePrice"] . ', Sale Date: ' . $row["saleDate"] . '</p>';

                            $record = json_decode($row["prop_json"]);

                            try {
                                if(count($record->result->listings) > 0) {
                                    $images = $record->result->listings["0"]->images;

                                    if(is_array($images)) {
                                        $displayHtml .= '<div class="row">';
                                        for($i = 0;$i<count($images);$i++) {

                                            $displayHtml .= '<div class="col-sm-1">';
                                            $displayHtml .= '<img class="img-thumbnail" src="' . $images[$i] . '" crossOrigin="Anonymous">';
                                            $displayHtml .= '</div>';
                                        }
                                        $displayHtml .= '</div>';
                                    }

                                }

                            } catch (Exception $e) {

                            }


                            $displayHtml .= '</div>';
                            $displayHtml .= '</div>';
                        }
                        echo $displayHtml;
                    } else {
                        echo '<h1>Empty Records</h1>';
                    }
                ?>
            </div>

        </section>
        <!--Per client -->

    </div>
</div>

<div class="pdf-generating">
    <p>Please wait some seconds while generating a pdf . . .</p>
</div>
</body>
<!-- jQuery -->
<script src="public/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="public/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)

</script>
<!-- Bootstrap 4 -->
<script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="public/plugins/chart.js/Chart.min.js"></script>
<script src="public/plugins/chart.js/utils.js"></script>
<!-- Sparkline -->
<script src="public/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="public/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="public/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="public/plugins/moment/moment.min.js"></script>
<script src="public/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="public/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="public/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="public/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- Select2 -->
<script src="public/plugins/select2/js/select2.full.min.js"></script>
<!-- date-range-picker -->
<script src="public/plugins/daterangepicker/daterangepicker.js"></script>
<script src="public/dist/js/demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="public/js/analytic.js"></script>
<script src="public/js/analytics_e.js"></script>
<script src="public/js/response.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();
        $('.reservation').daterangepicker()
    });

</script>

</html>
