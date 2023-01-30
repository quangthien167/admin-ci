<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="<?php echo base_url('public/vendors/jquery-2.2.4.min.js'); ?>"></script>
<script src="<?php echo base_url('public/vendors/jquery.validate.min.js'); ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('public/vendors/bootstrap-4.6.1/css/bootstrap.min.css'); ?>" />
<script src="<?php echo base_url('public/vendors/bootstrap-4.6.1/js/bootstrap.min.js'); ?>"></script>

<!--semantic-ui-->
<!--<link rel="stylesheet" href="<?php // echo base_url('public/vendors/semantic-ui/semantic.min.css'); ?>" />-->
<!--<script src="<?php // echo base_url('public/vendors/semantic-ui/semantic.min.js'); ?>"></script>-->

<!-- Font icon -->
<link href="<?php echo base_url('public/vendors/font-awesome-4.7.0/css/font-awesome.min.css') ?>" rel="stylesheet">

<!--Select 2-->
<link href="<?php echo base_url('public/vendors/select2-v2.4/css/select2.min.css') ?>" rel="stylesheet" />
<script src="<?php echo base_url('public/vendors/select2-v2.4/js/select2.min.js') ?>"></script>

<!--bootstrap-datepicker-->
<link href="<?php echo base_url('public/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet" />
<script src="<?php echo base_url('public/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>

<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<!--datatables-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.2/css/fixedColumns.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/4.0.2/js/dataTables.fixedColumns.min.js"></script>

<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    *{
        margin: 0;
        padding: 0
    }
    body{
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
    }
    .dropdown-item{
        font-size: 14px;
    }

    /*Fotmat datatables*/
    .my_dataTable.table.dataTable th,
    .my_dataTable.table.dataTable td {
        white-space: nowrap;
        vertical-align: middle !important;
    }

    .error {
        color: red
    }

    /**Select2 */
    .select2 .select2-selection--single{
        min-height: 34px;
    }
    /* .select2 .select2-selection__rendered{
        line-height: 34px;
    } */
</style>