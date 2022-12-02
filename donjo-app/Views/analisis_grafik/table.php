<div id="pageC">
    <!-- Start of Space Admin -->
    <table class="inner">
        <tr style="vertical-align:top">
            <td style="background:#fff;padding:0px;">
                <script src="<?= base_url('assets/js/highcharts/highcharts.js') ?>"></script>
                <script src="<?= base_url('assets/js/highcharts/highcharts-more.js') ?>"></script>
                <script src="<?= base_url('assets/js/highcharts/exporting.js') ?>"></script>
                <script>
                    var chart;
                    $(document).ready(function() {
                        chart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'chart',
                                border: 0,
                                defaultSeriesType: 'column'
                            },
                            title: {
                                text: 'Statistik'
                            },
                            xAxis: {
                                title: {
                                    text: ''
                                },
                                categories: [
                                    <?php $i = 0;

                                    foreach ($main as $data) {
                                        $i++; ?>
                                        <?php if ($data['jumlah'] !== '-') {
                                            echo "'{$i}',";
                                        } ?>
                                    <?php
                                    } ?>
                                ]
                            },
                            yAxis: {
                                title: {
                                    text: 'Jumlah Populasi'
                                }
                            },
                            legend: {
                                layout: 'vertical',
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    colorByPoint: true
                                },
                                column: {
                                    pointPadding: 0,
                                    borderWidth: 0
                                }
                            },
                            series: [{
                                shadow: 1,
                                border: 0,
                                data: [
                                    <?php foreach ($main as $data) { ?>
                                        <?php if ($data['nama'] !== 'TOTAL') { ?>
                                            <?php if ($data['jumlah'] !== '-') { ?>['<?= $data['nama'] ?>', <?= $data['jumlah'] ?>],
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                ]

                            }]
                        });
                    });
                </script>
                <style>
                    tr#total {
                        background: #fffdc5;
                        font-size: 12px;
                        white-space: nowrap;
                        font-weight: bold;
                    }
                </style>
                <div id="contentpane">
                    <form id="mainform" name="mainform" action="" method="post">
                        <div class="ui-layout-north panel top">
                            <div class="left">
                                <select name="dusun" onchange="formAction('mainform','<?= site_url('analisis_grafik/dusun') ?>')">
                                    <option value="">Dusun</option>
                                    <?php foreach ($list_dusun as $data) { ?>
                                        <option value="<?= $data['dusun'] ?>" <?php if ($dusun === $data['dusun']) : ?>selected<?php endif ?>><?= ununderscore(unpenetration($data['dusun'])) ?></option>
                                    <?php } ?>
                                </select>

                                <?php if ($dusun) { ?>
                                    <select name="rw" onchange="formAction('mainform','<?= site_url('analisis_grafik/rw') ?>')">
                                        <option value="">RW</option>
                                        <?php foreach ($list_rw as $data) { ?>
                                            <option value="<?= $data['rw'] ?>" <?php if ($rw === $data['rw']) : ?>selected<?php endif ?>><?= $data['rw'] ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>

                                <?php if ($rw) { ?>
                                    <select name="rt" onchange="formAction('mainform','<?= site_url('analisis_grafik/rt') ?>')">
                                        <option value="">RT</option>
                                        <?php foreach ($list_rt as $data) { ?>
                                            <option value="<?= $data['rt'] ?>" <?php if ($rt === $data['rt']) : ?>selected<?php endif ?>><?= $data['rt'] ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>

                            </div>
                        </div>
                    </form>
                    <div class="ui-layout-center" id="chart" style="padding: 5px;">

                    </div>
                    <div class="ui-layout-south panel bottom" style="max-height: 150px;overflow:auto;">
                        <table class="list">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Statistik</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($main as $data) : ?>
                                    <tr>
                                        <td align="center" width="2"><?= $data['no'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['jumlah'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="left">
                            <a href="<?= site_url('analisis_grafik/leave') ?>" class="uibutton icon prev">Kembali</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
