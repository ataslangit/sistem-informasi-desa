<!-- Start of Space Admin -->
<table class="inner">
    <tr style="vertical-align:top">
        <td style="background:#fff;padding:0px;">
            <script type="text/javascript" src="<?= base_url() ?>assets/js/highcharts/highcharts.js"></script>
            <script type="text/javascript">
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'chart',
                            defaultSeriesType: 'column'
                        },
                        title: {
                            text: 'Statistik Kelas Sosial & Memperoleh Jamkesmas'
                        },
                        xAxis: {
                            title: {
                                text: 'Kelas Sosial'
                            },
                            categories: [
                                <?php $i = 0;

                                foreach ($main as $data) {
                                    $i++; ?>
                                    <?= "'{$data['nama']}',"; ?>
                                <?php
                                } ?>
                            ]
                        },
                        yAxis: {
                            title: {
                                text: 'Populasi'
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
                            name: 'Populasi',
                            data: [
                                <?php foreach ($main as $data) { ?>
                                    <?= $data['jumlah'] . ','; ?>
                                <?php } ?>
                            ]

                        }, {
                            name: 'Memperoleh Raskin',
                            colorByPoint: false,
                            color: '#5B2D1D',
                            data: [
                                <?php foreach ($main as $data) { ?>
                                    <?= $data['jamkesmas'] . ','; ?>
                                <?php } ?>
                            ]

                        }]
                    });


                });
            </script>
            <div class="content-header">
                <h3>Data Keluarga</h3>
            </div>
            <div id="contentpane">
                <form id="mainform" name="mainform" action="" method="post">
                    <div class="ui-layout-north panel">
                        <div class="left">
                            <div class="uibutton-group">
                                <select name="dusun" onchange="formAction('mainform','<?= site_url('keluarga/dusun/2') ?>')">
                                    <option value="">Dusun</option>
                                    <?php foreach ($list_dusun as $data) { ?>
                                        <option value="<?= $data['dusun'] ?>" <?php if ($dusun === $data['dusun']) : ?>selected<?php endif ?>><?= $data['dusun'] ?></option>
                                    <?php } ?>
                                </select>

                                <?php if ($dusun) { ?>
                                    <select name="rw" onchange="formAction('mainform','<?= site_url('keluarga/rw/2') ?>')">
                                        <option value="">RW</option>
                                        <?php foreach ($list_rw as $data) { ?>
                                            <option value="<?= $data['rw'] ?>" <?php if ($rw === $data['rw']) : ?>selected<?php endif ?>><?= $data['rw'] ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>

                                <?php if ($rw) { ?>
                                    <select name="rt" onchange="formAction('mainform','<?= site_url('keluarga/rt/2') ?>')">
                                        <option value="">RT</option>
                                        <?php foreach ($list_rt as $data) { ?>
                                            <option value="<?= $data['rt'] ?>" <?php if ($rt === $data['rt']) : ?>selected<?php endif ?>><?= $data['rt'] ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="right">
                            <div class="uibutton-group">
                                <a href="<?= site_url() ?>keluarga/clear" class="uibutton icon prev">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <div class="ui-layout-center" id="chart" style="padding: 5px;">

                    </div>
                    <div class="ui-layout-south panel bottom" style="max-height: 150px;overflow:auto;">
                        <table class="list">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Statistik</th>
                                    <th>Populasi</th>
                                    <th>Memperoleh Jamkesmas</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($main as $data) : ?>
                                    <tr>
                                        <td align="center" width="2"><?= $data['id'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['jumlah'] ?></td>
                                        <td><?= $data['jamkesmas'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </td>
    </tr>
</table>
</div>
