<?php

use App\Models\AnalisisPeriode;
use App\Models\BaseModel as Model;

class Analisis_import_model extends Model
{
    public function import_excel()
    {
        $spreadsheetExcelReader = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
        $analisisPeriode        = new AnalisisPeriode();

        $sheet = 0;

        $master['nama']        = $spreadsheetExcelReader->val(1, 2, $sheet);
        $master['subjek_tipe'] = $spreadsheetExcelReader->val(2, 2, $sheet);
        $master['lock']        = $spreadsheetExcelReader->val(3, 2, $sheet);
        $master['pembagi']     = $spreadsheetExcelReader->val(4, 2, $sheet);
        $master['deskripsi']   = $spreadsheetExcelReader->val(5, 2, $sheet);

        $outp      = $this->db->insert('analisis_master', $master);
        $id_master = $this->db->insert_id();

        $periode['id_master']         = $id_master;
        $periode['nama']              = $spreadsheetExcelReader->val(6, 2, $sheet);
        $periode['tahun_pelaksanaan'] = $spreadsheetExcelReader->val(7, 2, $sheet);
        $periode['keterangan']        = $spreadsheetExcelReader->val(5, 2, $sheet);
        $periode['aktif']             = 1;

        $analisisPeriode->insert($periode);

        $sheet = 1;
        $baris = $spreadsheetExcelReader->rowcount($sheet);
        $spreadsheetExcelReader->colcount($sheet);

        for ($i = 2; $i <= $baris; $i++) {
            $sql   = 'SELECT * FROM analisis_kategori_indikator WHERE kategori=? AND id_master=?';
            $query = $this->db->query($sql, [$spreadsheetExcelReader->val($i, 3, $sheet), $id_master]);
            $cek   = $query->row_array();

            if (! $cek) {
                $kategori['id_master'] = $id_master;
                $kategori['kategori']  = $spreadsheetExcelReader->val($i, 3, $sheet);
                $this->db->insert('analisis_kategori_indikator', $kategori);
            }
        }

        for ($i = 2; $i <= $baris; $i++) {
            $indikator['id_master']  = $id_master;
            $indikator['nomor']      = $spreadsheetExcelReader->val($i, 1, $sheet);
            $indikator['pertanyaan'] = $spreadsheetExcelReader->val($i, 2, $sheet);

            $sql      = 'SELECT * FROM analisis_kategori_indikator WHERE kategori=? AND id_master=?';
            $query    = $this->db->query($sql, [$spreadsheetExcelReader->val($i, 3, $sheet), $id_master]);
            $kategori = $query->row_array();

            $indikator['id_kategori']  = $kategori['id'];
            $indikator['id_tipe']      = $spreadsheetExcelReader->val($i, 4, $sheet);
            $indikator['bobot']        = $spreadsheetExcelReader->val($i, 5, $sheet);
            $indikator['act_analisis'] = $spreadsheetExcelReader->val($i, 6, $sheet);

            $this->db->insert('analisis_indikator', $indikator);
        }

        $sheet = 2;
        $baris = $spreadsheetExcelReader->rowcount($sheet_index = $sheet);
        $spreadsheetExcelReader->colcount($sheet_index = $sheet);

        for ($i = 2; $i <= $baris; $i++) {
            $kode = explode('.', $spreadsheetExcelReader->val($i, 3, $sheet));

            $parameter['kode_jawaban'] = $spreadsheetExcelReader->val($i, 2, $sheet);
            $parameter['jawaban']      = $spreadsheetExcelReader->val($i, 3, $sheet);

            $sql       = 'SELECT id FROM analisis_indikator WHERE nomor=? AND id_master=?';
            $query     = $this->db->query($sql, [$spreadsheetExcelReader->val($i, 1, $sheet), $id_master]);
            $indikator = $query->row_array();

            $parameter['id_indikator'] = $indikator['id'];
            $parameter['nilai']        = $spreadsheetExcelReader->val($i, 4, $sheet);
            $parameter['asign']        = 1;

            $this->db->insert('analisis_parameter', $parameter);
        }

        $sheet = 3;
        $baris = $spreadsheetExcelReader->rowcount($sheet_index = $sheet);
        $spreadsheetExcelReader->colcount($sheet_index = $sheet);

        for ($i = 2; $i <= $baris; $i++) {
            $klasifikasi['id_master'] = $id_master;
            $klasifikasi['nama']      = $spreadsheetExcelReader->val($i, 1, $sheet);
            $klasifikasi['minval']    = $spreadsheetExcelReader->val($i, 2, $sheet);
            $klasifikasi['maxval']    = $spreadsheetExcelReader->val($i, 3, $sheet);

            $this->db->insert('analisis_klasifikasi', $klasifikasi);
        }

        if ($outp) {
            $_SESSION['success'] = 1;
        } else {
            $_SESSION['success'] = -1;
        }
    }
}
