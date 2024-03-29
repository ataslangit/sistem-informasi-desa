<script src="<?php echo base_url('assets/js/highcharts/highcharts.js') ?>"></script>
<script>
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                defaultSeriesType: 'column'
            },
            title: {
                text: 'Diagram Batang Jumlah Penduduk Penerima Jamkesmas'
            },
            xAxis: {
                title: {
                    text: 'Kelompok Penerima Jamkesmas'
                },
                categories: [
                    <?php $i=0;foreach($main as $data){$i++;?>
                    <?php echo "'$data[nama]',";?>
                    <?php }?>
                ]
            },
            yAxis: {
                title: {
                    text: 'Jumlah Penduduk'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                shadow: true,
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return '' +
                        this.x + ': ' + this.y + '';
                }
            },
            plotOptions: {
                series: {
                    colorByPoint: true
                },
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Jumlah Penduduk',
                data: [
                    <?php foreach($main as $data){?>
                    <?php echo $data['jumlah'].",";?>
                    <?php }?>
                ]

            }, {
                name: 'Penerima Jamkesmas',
                colorByPoint: false,
                color: '#5B2D1D',
                data: [
                    <?php foreach($main as $data){?>
                    <?php echo $data['jamkesmas'].",";?>
                    <?php }?>
                ]

            }]
        });


    });

</script>
<?php
	echo "
	<div class=\"box box-danger\">
		<div class=\"box-header with-border\">
			<h3 class=\"box-title\">Statistik Kependudukan berdasarkan Penerimaan Jamkesmas</h3>
		</div>
		<div class=\"box-body\">
			<div id=\"container\"></div>
			<div id=\"contentpane\">
				<div class=\"ui-layout-north panel top\"></div>
				<div class=\"ui-layout-center\" id=\"chart\" style=\"padding: 5px;\"></div>
			</div>
		</div>
	</div>
	<div class=\"box box-danger\">
		<div class=\"box-header with-border\">
			<h3 class=\"box-title\">Tabel Statistik Kependudukan berdasarkan Penerimaan Jamkesmas</h3>
		</div>
		<div class=\"box-body\">
			<table class=\"table table-striped\">
				<thead>
				<tr>
					<th>#</th>
					<th>Kelompok</th>
					<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>";

				$i=0;$j=0;

				foreach($main as $data){
					echo "<tr>
						<td class=\"angka\">".$data['id']."</td>
						<td>".$data['nama']."</td>
						<td class=\"angka\">".$data['jumlah']."</td>
					</tr>";
					$i=$i+$data['jumlah'];
					$j=$j+$data['jamkesmas'];
				}
				echo "
				</tbody>
				<tfooter><tr><th colspan=\"2\" class=\"angka\">JUMLAH</th><th>".$i."</th></tr></tfooter>
			</table>";

		echo "
		</div>
	</div>";
?>
