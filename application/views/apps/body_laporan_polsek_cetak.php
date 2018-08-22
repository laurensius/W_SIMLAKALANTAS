          
        <div class="container container-fluid">
        <br>
        <br>
        <table class="table table-responsive table-bordered">
            <tr>
                <td colspan="3">
                    <center>
                        <h4><b>Berita Acara Tindak Lanjut Laporan Masyarakat</b></h4>
                    </center>
                </td>
            </tr>
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
            <tr>
                <td></td>
                <td></td>
                <td>
                <br>
                <center>
                Laporan dibuat di Kuningan,<br>
                pada tanggal <?php echo date("d - m - Y"); ?>
                <br>
                <br>
                <br>
                <br>
                <b>Satlantas POLRES Kuningan</b>
                </center>
                </td>
            </tr>
        </table>
        </div>
        <script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script>
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
            report_detail();
            window.print()
        </script>
    </body>
</html>
