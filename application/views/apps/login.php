
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SIMLAKALANTAS</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="
        background-color : #226699;
        background-image : url(' <?php echo base_url("assets/bg.jpg"); ?>');
        background-repeat: no-repeat;
        background-position: 0 0;
        background-size: cover;">
        <div class="container container-fluid">
            <div class="row" style="margin-top : 90px">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel panel-header">
                            <div class="panel panel-title">
                            <center>
                             <h1>Admin POLRES</h1>
                             </center>
                             </div>
                        </div>
                        <div class="panel panel-body">
                            <form id="sign_in" method="POST">
                                <div id="msg" class="msg"></div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="u" name="username" placeholder="Username" required autofocus>
                                    </div>
                                </div>
                                <br>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                    </span>
                                    <div class="form-line">
                                        <input type="password" class="form-control" id="p" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-8 p-t-5">
                                    </div>
                                    <div class="col-xs-4">
                                        <button class="btn btn-block bg-blue waves-effect" type="submit">SIGN IN</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>

             
        </div>
        <script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/fastclick/fastclick.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dist/js/app.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>
        <script>
        var pesan = '<?php echo $message; ?>';
        var severity = '<?php echo $severity; ?>';
        var alert = '';
        alert += '<div class="alert alert-'+ severity +' alert-dismissable">';
        alert += pesan;
        alert += '</div>';
        $("#msg").html(alert);

        $("form#sign_in").submit(function(e) {
            var notif = '';
            notif += '<div class="alert alert-primary alert-dismissable">';
            notif += 'Loading . . .';
            notif += '</div>';
            $("#msg").html(notif);
            e.preventDefault();    
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo site_url(); ?>/api/verifikasi_web/",
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                    notif = '';
                    if(response.response.code === "MATCH"){
                    location.reload(); 
                    }else{
                        notif = '';
                        notif += '<div class="alert alert-'+response.response.severity +' alert-dismissable">';
                        notif += response.response.message;
                        notif += '</div>';
                        $("#msg").html(notif);
                    }
                },
                error: function(response){
                    notif = '';
                    notif += '<div class="alert alert-warning alert-dismissable">';
                    notif += 'Login gagal, terjadi gangguan saat terhubung ke server';
                    notif += '</div>';
                    $("#msg").html(notif);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        </script>
    </body>
</html>

