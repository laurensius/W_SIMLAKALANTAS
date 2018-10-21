            <div class="content-wrapper">
                <div class="container">
                    <section class="content-header">
                        <h1>
                        Detail Laporan
                        <small>Laporan dari Polsek</small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title" id="pol">Tabel</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped table-responsive">
                                    <tr>
                                        <td colspan="3">Telah diterima laporan dari masyarakat :</td>
                                    </tr>
                                    <tr>
                                        <td>Nama pelapor </td>
                                        <td>: </td>
                                        <td id="nama_pelapor"></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat pelapor</td>
                                        <td>: </td>
                                        <td id="alamat_pelapor"></td>
                                    </tr>
                                    <tr>
                                        <td>Pada tanggal </td>
                                        <td>: </td>
                                        <td id="pada"></td>
                                    </tr>
                                    <tr>
                                        <td>Lokasi  pelaporan</td>
                                        <td>: </td>
                                        <td id="lokasi"></td>
                                    </tr>
                                    <tr>
                                        <td>Dengan laporan pengaduan sbb  </td>
                                        <td>: </td>
                                        <td id="desc"></td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran Kitas  </td>
                                        <td>: </td>
                                        <td id="kitas"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                        Dari laporan yang disampaikan oleh pelapor tersebut diatas, 
                                        telah dilakukan verifikasi dan tindakan di TKP dengan hasil sbb :
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identifikasi Kronologi  </td>
                                        <td>: </td>
                                        <td id="kronologi"></td>
                                    </tr>
                                    <tr>
                                        <td>Korban  </td>
                                        <td>: </td>
                                        <td id="korban"></td>
                                    </tr>
                                    <tr>
                                        <td>Kerusakan / Kerugian  </td>
                                        <td>: </td>
                                        <td id="kerugian"></td>
                                    </tr>
                                    <tr>
                                        <td>Tindakan  </td>
                                        <td>: </td>
                                        <td id="tindakan"></td>
                                    </tr>
                                </table>
                                <div class="col-lg-12">
                                    <br>
                                    <center>
                                        <a href="<?php echo site_url('apps/laporan_polsek/').$this->uri->segment(3)."/";?>" class="btn btn-success">Kembali</a>
                                        <a href="<?php echo site_url('apps/laporan_polsek_cetak/').$this->uri->segment(3)."/".$this->uri->segment(4)."/";?>" class="btn btn-primary" target="_blank" >Cetak Laporan</a>
                                    </center>
                                </div>
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
                                if(response.data[x].id == <?php echo $this->uri->segment(3); ?>){
                                    $("#pol").html(response.data[x].nama_kantor);
                                    $("#polsek").html(response.data[x].nama_kantor);
                                }
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

            function report_detail(){
                    $.ajax({
                    url : '<?php echo site_url("api/report_select_by_station_detail/").$this->uri->segment(3)."/".$this->uri->segment(4)."/"; ?>' ,
                    type : 'GET',
                    dataType : 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success : function(response){
                        if(response.data.length > 0){
                            $("#nama_pelapor").html(response.data[0].full_name);
                            $("#alamat_pelapor").html(response.data[0].address);
                            $("#pada").html(response.data[0].received_at);
                            $("#desc").html(response.data[0].description);
                            $("#kitas").html('<img src="data:image/jpg;base64,'+response.data[0].kitas+'">');
                            $("#lokasi").html(response.data[0].latitude + " ; " + response.data[0].longitude);
                            $("#kronologi").html(response.data[0].chronology);
                            $("#korban").html(response.data[0].accident_victim);
                            $("#kerugian").html(response.data[0].damage);
                            $("#tindakan").html(response.data[0].action);
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
            station_list();
            report_detail();
        </script>
    </body>
</html>
