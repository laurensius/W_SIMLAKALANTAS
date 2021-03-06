            <div class="content-wrapper">
                <div class="container">
                    <section class="content-header">
                        <h1>
                        Laporan Harian
                        <small>Laporan kejadian harian dari Polsek</small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title" id="pol">
                                    Rekap Harian Jumlah Insiden
                                </h3>
                            </div>
                            <div class="box-body">
                                <form>
                                    <label> Tanggal : </label>
                                    <input type="date" name="in_tgl" id="in_tgl">
                                </form>
                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Polsek</th>
                                            <th>Alamat</th>
                                            <th>Jumlah Insiden</th>
                                            <!-- <th>Opsi</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="tb">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" id="btn"></td>
                                        </tr>
                                    <tfoot>
                                </table>
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
                <strong>Copyright &copy; <?php echo date("Y") ?> <a href="http://laurensius-dede-suhardiman.com" target="_blank">RCM</a> - </strong> Renzcybermedia
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

            function report_list(tgl){
                    $.ajax({
                    url : '<?php echo site_url("api/report_count_by_day/"); ?>' + tgl + '/' ,
                    type : 'GET',
                    dataType : 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(response){
                        if(response.data.length > 0){
                            var str = '';
                            var ctr = 1;
                            for(var x=0;x<response.data.length;x++){
                                str += '<tr>';
                                str += '<td>' + ctr + '</td>';
                                str += '<td>' + response.data[x].nama_kantor + '</td>';
                                str += '<td>' + response.data[x].address + '</td>';
                                str += '<td>' + response.data[x].jumlah + ' </td>';
                                // ACTION / OPTION
                                //str += '<td>';
                                // str += '<a href="<?php echo site_url('apps/laporan_polsek_detail/').$this->uri->segment(3)."/";?>' + response.data[x].incident + '/" class="btn btn-success" style="margin-left:5px"> <span class="glyphicon glyphicon-paste"> </span></a>'
                                //str += '<a href="<?php echo site_url('apps/laporan_polsek_cetak/').$this->uri->segment(3)."/";?>' + response.data[x].incident + '/" class="btn btn-primary" alt="cetak laporan akhir" style="margin-left:5px"> <span class="glyphicon glyphicon-print"> </span></a>'
                                //str += '<td>';
                                str += '</tr>'; 
                                ctr++; 
                            }
                            $("#tb").html(str);
                            $("#btn").html(
                                '<center><a href="<?php echo site_url('apps/laporan_harian_cetak/');?>' + tgl + '" class="btn btn-primary" target="_blank" >Cetak Laporan</a></center>'
                            );
                        }else{
                            $("#tb").html('<td colspan="5">Tidak ada data</td>');
                        }
                    },
                    error : function(response){
                    console.log(response);
                        alert("error");
                    },
                });
            };

            var tanggal = document.getElementById('in_tgl');
            
            tanggal.onchange = function(){
                report_list(this.value);
            }
            station_list();
            //
        </script>
    </body>
</html>
