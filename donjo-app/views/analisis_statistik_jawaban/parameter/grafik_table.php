<div id="pageD" style="height:90%">
    <div class="middin-north" style="padding-left: 10px;">
    </div>
    <div class="middin-west" style="padding: 5px;">

        <h4><?= $analisis_statistik_jawaban['pertanyaan'] ?></h4>
        <div class="top">
            <?= form_open('', ['id' => 'mainform', 'name' => 'mainform']) ?>
                <div class="left">
                    <select name="dusun" onchange="formAction('mainform','<?= site_url("analisis_statistik_jawaban/dusun3/{$analisis_statistik_jawaban['id']}") ?>')">
                        <option value="">Dusun</option>
                        <?php foreach ($list_dusun as $data) { ?>
                            <option value="<?= $data['dusun'] ?>" <?php if ($dusun === $data['dusun']) : ?>selected<?php endif ?>><?= ununderscore(unpenetration($data['dusun'])) ?></option>
                        <?php } ?>
                    </select>

                    <?php if ($dusun) { ?>
                        <select name="rw" onchange="formAction('mainform','<?= site_url("analisis_statistik_jawaban/rw3/{$analisis_statistik_jawaban['id']}") ?>')">
                            <option value="">RW</option>
                            <?php foreach ($list_rw as $data) { ?>
                                <option value="<?= $data['rw'] ?>" <?php if ($rw === $data['rw']) : ?>selected<?php endif ?>><?= $data['rw'] ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>

                    <?php if ($rw) { ?>
                        <select name="rt" onchange="formAction('mainform','<?= site_url("analisis_statistik_jawaban/rt3/{$analisis_statistik_jawaban['id']}") ?>')">
                            <option value="">RT</option>
                            <?php foreach ($list_rt as $data) { ?>
                                <option value="<?= $data['rt'] ?>" <?php if ($rt === $data['rt']) : ?>selected<?php endif ?>><?= $data['rt'] ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
            <?= form_close() ?>
        </div>
        <table class="list">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jawaban</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($main as $data) : ?>
                    <tr>
                        <td align="center" width="2"><?= $data['no'] ?></td>
                        <td><?= $data['jawaban'] ?></td>
                        <td><?= $data['nilai'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="position:absolute; bottom:40px;">
            <div class="left">
                <a href="<?= site_url() ?>analisis_statistik_jawaban" class="uibutton icon prev">Kembali</a>
            </div>
        </div>
    </div>
    <div class="middin-center" style="padding: 5px;">

        <script src="<?= base_url() ?>assets/js/highcharts/highcharts.js"></script>
        <script src="<?= base_url() ?>assets/js/highcharts/highcharts-more.js"></script>
        <script src="<?= base_url() ?>assets/js/highcharts/exporting.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                hiRes();
            });
            var chart;

            function hiRes() {
                chart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart',
                        border: 0,
                        defaultSeriesType: 'column'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        title: {
                            text: ''
                        },
                        categories: [
                            <?php $i = 0;

        foreach ($main as $data) {
            $i++; ?>
                                <?php if ($data['nilai'] !== '-') {
                                    echo "'{$data['jawaban']}',";
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
                                <?php if ($data['jawaban'] !== 'TOTAL') { ?>
                                    <?php if ($data['nilai'] !== '-') { ?>
                                        <?= $data['nilai'] ?>,
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        ]

                    }]
                });
            };
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
            <div class="ui-layout-center" id="chart" style="padding: 5px;"></div>
        </div>
    </div>
</div>
