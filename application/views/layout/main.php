<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý công việc</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="overlay"></div>
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo site_url('congviec'); ?>">Công việc</a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo site_url('loaicongviec'); ?>">Loại công việc</a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo site_url('phong'); ?>">Phòng</a>
                </li>
                <li>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo site_url('truong'); ?>">Trường học</a>
                </li>
            </ul>
        </nav>
        <div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
            <?php $this->load->view($content_view); ?>
        </div>
    </div>
</body>
<?php $CI = &get_instance(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    var base_url = "<?php echo base_url(); ?>";
    var csrf_name = '<?php echo $CI->security->get_csrf_token_name(); ?>';
    var csrf_hash = '<?php echo $CI->security->get_csrf_hash(); ?>';
    <?php if ($this->session->flashdata('success')) : ?>
        toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    <?php endif; 
     if ($this->session->flashdata('error')): ?>
            toastr.error("<?php echo $this->session->flashdata('error'); ?>");
        <?php endif; ?>
</script>
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
</html>