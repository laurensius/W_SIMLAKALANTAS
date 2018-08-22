            <div class="content-wrapper">
                <div class="container">
                    <section class="content-header">
                        <h1>
                        Selamat datang!
                        <small></small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Satuan Lalu Lintas Polres Kuningan</h3>
                            </div>
                            <div class="box-body">
                                <center>
                                <img class="img img-responsive" src="<?php echo base_url('assets/lantas.png') ?>">
                                </center>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <footer class="main-footer">
                <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; <?php echo date("Y") ?> <a href="http://ppns.ac.id">PPNS</a>.</strong> Lutfi.
                </div>
            </footer>
        </div>

        <script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/plugins/fastclick/fastclick.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dist/js/app.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>
        <script>
            function station_list(){
                    $.ajax({
                    url : '<?php echo site_url("api/station_list/") ?>' ,
                    type : 'GET',
                    dataType : 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(response){
                        if(response.data.length > 0){
                            var str = '';
                            for(var x=0;x<response.data.length;x++){
                                console.log(response.data[x].nama_kantor);
                                str += '<li><a href="<?php echo site_url('apps/laporan_polsek/'); ?>' + response.data[x].id  + '">' + response.data[x].nama_kantor + '</a></li>'  
                            }
                            $("#dd").html(str);
                        }else{
                            
                        }
                    },
                    error : function(response){
                    console.log(response);
                        alert("error");
                    },
                });
            };
            station_list();
        </script>
    </body>
</html>
