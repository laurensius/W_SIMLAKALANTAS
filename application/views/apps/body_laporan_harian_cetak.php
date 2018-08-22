          
        <div class="container container-fluid">
        <br>
        <br>
        <center>
            <h4><b>Rekap Kejadian Harian Tanggal <?php echo $this->uri->segment(3); ?></b></h4>
        </center>
        <table class="table table-responsive table-bordered">
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
            <tr>
                <td colspan="4">
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
                            window.print();
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
            report_list(<?php echo $this->uri->segment(3); ?>);
        </script>
    </body>
</html>
