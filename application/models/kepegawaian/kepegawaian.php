<?php
class kepegawaian extends CI_Model
{

	function __construct()
	{
        parent::__construct();
		$this->load->database();
    }

	#----- GETTING DATA FROM DATABASE -----#
	function get_data_lama ()
	{
		$this->db->select('*');
		$query = $this->db->get('pegawai');
		return $query->result_array();
	}
	
	function get_data_outsource ()
	{
		$this->db->select('*');
		$query = $this->db->get('outsource');
		return $query->result_array();
	}
	
	function get_data_pegawai($num, $offset)
	{
		$this->db->select('*');
		$query = $this->db->get('v3_pegawai', $num, $offset);
		return $query->result_array();
	}
	
	function get_data_pegawai_pensiun($num, $offset, $tahun, $type, $limit)
	{
		$query = ('
			SELECT * FROM v3_pegawai AS peg 
			LEFT JOIN (SELECT p_jbt_nipp, p_jbt_jabatan FROM v3_peg_jabatan) AS peg_jbt 
			ON peg.peg_nipp = peg_jbt.p_jbt_nipp 
			LEFT JOIN (SELECT p_tmt_nipp, p_tmt_tmt, p_tmt_end FROM v3_peg_tmt) AS peg_tmt 
			ON peg.peg_nipp = peg_tmt.p_tmt_nipp 
			WHERE \''.$tahun.'\' - YEAR(peg.peg_tgl_lahir) > \''.$type.'\'
			AND \''.$tahun.'\' - YEAR(peg.peg_tgl_lahir) < \''.$limit.'\'
			AND peg_tmt.p_tmt_end = \'0000-00-00\'
			ORDER BY peg.peg_tgl_lahir DESC
			LIMIT '.$offset.' , '.$num.'
		');
		$query = $this->db->query($query); 
		return $query->result_array();
	}
	
	function get_data_jenis_pegawai($num, $offset, $type)
	{
		$query = ('
			SELECT * FROM v3_pegawai AS peg
			LEFT JOIN (SELECT * FROM v3_peg_tmt) AS peg_tmt
			ON peg.peg_nipp = peg_tmt.p_tmt_nipp
			WHERE peg_tmt.p_tmt_status = \'' . $type . '\' AND peg_tmt.p_tmt_end = 0000-00-00
			LIMIT '.$offset.' , '.$num.'
		');
		$query = $this->db->query($query); 
		return $query->result_array();
	}
	
	function get_data_unit_pegawai($num, $offset, $unit)
	{
		$query = ('
			SELECT * FROM v3_pegawai AS peg
			LEFT JOIN (SELECT * FROM v3_peg_unit) AS peg_unt
			ON peg.peg_nipp = peg_unt.p_unt_nipp
			WHERE peg_unt.p_unt_kode_unit = \'' . $unit . '\'
			LIMIT '.$offset.' , '.$num.'
		');
		$query = $this->db->query($query); 
		return $query->result_array();
	}
	
	function search_data_pegawai($num, $offset, $search)
	{
		$this->db->select('*');
		$this->db->like('peg_nipp', $search);
		$this->db->or_like('peg_nama', $search);
		$query = $this->db->get('v3_pegawai', $num, $offset);
		return $query->result_array();
	}
	
	function get_data_pegawai_by_nipp($nipp)
	{
		$this->db->select('*');
		$this->db->where('peg_nipp',$nipp);
		$query = $this->db->get('v3_pegawai');
		return $query->result_array();
	}
	
	function get_detail_pegawai_agama($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_ag_nipp',$nipp);
		$query = $this->db->get('v3_peg_agama');
		return $query->result_array();
	}
	
	function get_detail_pegawai_alamat($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_al_nipp',$nipp);
		$query = $this->db->get('v3_peg_alamat');
		return $query->result_array();
	}
	
	function get_detail_pegawai_ayah($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_ay_nipp',$nipp);
		$query = $this->db->get('v3_peg_ayah');
		return $query->result_array();
	}
	
	function get_detail_pegawai_bahasa($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_bhs_nipp',$nipp);
		$query = $this->db->get('v3_peg_bahasa');
		return $query->result_array();
	}
	
	function get_detail_pegawai_fisik($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_fs_nipp',$nipp);
		$query = $this->db->get('v3_peg_fisik');
		return $query->result_array();
	}
	
	function get_detail_pegawai_ibu($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_ibu_nipp',$nipp);
		$query = $this->db->get('v3_peg_ibu');
		return $query->result_array();
	}
	
	function get_detail_pegawai_jabatan($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_jbt_nipp',$nipp);
		$query = $this->db->get('v3_peg_jabatan');
		return $query->result_array();
	}
	
	function get_detail_pegawai_jabatan_tmt($nipp)
	{
		$query = ('
		SELECT * FROM v3_peg_jabatan AS peg_jbt
		LEFT JOIN (SELECT * FROM v3_peg_tmt) AS peg_tmt
		ON peg_jbt.p_jbt_nipp = peg_tmt.p_tmt_nipp
		WHERE peg_jbt.p_jbt_nipp = \'' . $nipp . '\'
		ORDER BY peg_tmt.id_peg_tmt DESC LIMIT 1
		');
		$query = $this->db->query($query); 
		return $query->result_array();
	}
	
	function get_detail_pegawai_mert_ayah($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_may_nipp',$nipp);
		$query = $this->db->get('v3_peg_mert_ayah');
		return $query->result_array();
	}
	
	function get_detail_pegawai_mert_ibu($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_mib_nipp',$nipp);
		$query = $this->db->get('v3_peg_mert_ibu');
		return $query->result_array();
	}
	
	function get_detail_pegawai_pasangan($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_ps_nipp',$nipp);
		$query = $this->db->get('v3_peg_pasangan');
		return $query->result_array();
	}
	
	function get_detail_pegawai_pendidikan($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_pdd_nipp',$nipp);
		$query = $this->db->get('v3_peg_pendidikan');
		return $query->result_array();
	}
	
	function get_detail_pegawai_status_keluarga($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_stk_nipp',$nipp);
		$query = $this->db->get('v3_peg_status_keluarga');
		return $query->result_array();
	}
	
	function get_detail_pegawai_tmt($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_tmt_nipp',$nipp);
		$this->db->order_by('p_tmt_nipp','DESC');
		$this->db->limit(1);
		$query = $this->db->get('v3_peg_tmt');
		return $query->result_array();
	}
	
	function get_detail_pegawai_unit($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_unt_nipp',$nipp);
		$query = $this->db->get('v3_peg_unit');
		return $query->result_array();
	}
	
	function get_detail_pegawai_grade($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_grd_nipp',$nipp);
		$query = $this->db->get('v3_peg_grade');
		return $query->result_array();
	}
	
	function get_detail_pegawai_stkp($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_stkp_nipp',$nipp);
		$query = $this->db->get('v3_peg_stkp');
		return $query->result_array();
	}
	
	function get_detail_pegawai_anak($nipp)
	{
		$this->db->select('*');
		$this->db->where('peg_ank_nipp',$nipp);
		$query = $this->db->get('v3_peg_anak');
		return $query->result_array();
	}
	
	function get_list_unit()
	{
		$query = $this->db->get('unit');
		return $query->result_array();
	}
	
	function get_list_jabatan()
	{
		$query = $this->db->get('v3_peg_tab_jabatan');
		return $query->result_array();
	}
	
	function get_supervisor($num, $offset)
	{
		$supervisor = '%Supervisor%';
		$query = ('SELECT peg_nipp, peg_nama, peg_jns_kelamin, peg_tgl_lahir, p_jbt_jabatan, p_unt_kode_unit, p_tmt_tmt, p_grd_grade FROM v3_pegawai AS peg
			LEFT JOIN (SELECT p_jbt_nipp, p_jbt_jabatan FROM v3_peg_jabatan) AS peg_jbt
			ON peg.peg_nipp = peg_jbt.p_jbt_nipp 
			LEFT JOIN (SELECT p_unt_nipp, p_unt_kode_unit FROM v3_peg_unit) AS peg_unt
			ON peg.peg_nipp = peg_unt.p_unt_nipp 
			LEFT JOIN (SELECT p_tmt_nipp, p_tmt_end, p_tmt_tmt FROM v3_peg_tmt) AS peg_tmt
			ON peg.peg_nipp = peg_tmt.p_tmt_nipp 
			LEFT JOIN (SELECT p_grd_nipp, p_grd_grade FROM v3_peg_grade) AS peg_grd
			ON peg.peg_nipp = peg_grd.p_grd_nipp 
			WHERE peg_jbt.p_jbt_jabatan LIKE \''.$supervisor.'\'
			AND peg_tmt.p_tmt_end = \'0000-00-00\'
			ORDER BY peg_unt.p_unt_kode_unit
			LIMIT '.$offset.' , '.$num.'');
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	#----- COUNT DATA -------#
	function countPegawai()
	{
		return $this->db->count_all_results('v3_pegawai');
	}
	
	function countPegawaiPensiun($tahun, $type, $limit)
	{
		$query = ('
			SELECT * FROM v3_pegawai AS peg
			WHERE \''.$tahun.'\' - YEAR(peg.peg_tgl_lahir) > \''.$type.'\'
			AND \''.$tahun.'\' - YEAR(peg.peg_tgl_lahir) < \''.$limit.'\'
		');
		$query = $this->db->query($query); 
		return $query->num_rows();
	}
	
	function count_jenis_Pegawai($type)
	{
		$search = array('p_tmt_status'=>$type, 'p_tmt_end'=>'0000-00-00');
		$this->db->where($search);
		return $this->db->count_all_results('v3_peg_tmt');
	}
	
	function count_unit_Pegawai($unit)
	{
		$this->db->where('p_unt_kode_unit',$unit);
		return $this->db->count_all_results('v3_peg_unit');
	}
	
	function count_result_bahasa($nipp)
	{
		$this->db->select('*');
		$this->db->where('p_bhs_nipp',$nipp);
		$this->db->from('v3_peg_bahasa');
		return $this->db->count_all_results();
	}
	
	function count_search_pegawai($search)
	{
		$this->db->select('*');
		$this->db->like('peg_nipp', $search);
		$this->db->or_like('peg_nama', $search);
		$this->db->from('v3_pegawai');
		return $this->db->count_all_results();
	}
	
	function count_supervisor()
	{
		$supervisor = '%Supervisor%';
		$query = ('SELECT peg_nipp, peg_nama, peg_jns_kelamin, peg_tgl_lahir, p_jbt_jabatan, p_unt_kode_unit, p_tmt_tmt, p_grd_grade FROM v3_pegawai AS peg
			LEFT JOIN (SELECT p_jbt_nipp, p_jbt_jabatan FROM v3_peg_jabatan) AS peg_jbt
			ON peg.peg_nipp = peg_jbt.p_jbt_nipp 
			LEFT JOIN (SELECT p_unt_nipp, p_unt_kode_unit FROM v3_peg_unit) AS peg_unt
			ON peg.peg_nipp = peg_unt.p_unt_nipp 
			LEFT JOIN (SELECT p_tmt_nipp, p_tmt_end, p_tmt_tmt FROM v3_peg_tmt) AS peg_tmt
			ON peg.peg_nipp = peg_tmt.p_tmt_nipp 
			LEFT JOIN (SELECT p_grd_nipp, p_grd_grade FROM v3_peg_grade) AS peg_grd
			ON peg.peg_nipp = peg_grd.p_grd_nipp 
			WHERE peg_jbt.p_jbt_jabatan LIKE \''.$supervisor.'\'
			AND peg_tmt.p_tmt_end = \'0000-00-00\'
			ORDER BY peg_unt.p_unt_kode_unit');
		
		$query = $this->db->query($query); 
		return $query->num_rows();
	}
	
	#----- INSERTING DATA TO DATABASE -----#
	function insert_data_pegawai($data_pegawai)
	{
		$this->db->insert('v3_pegawai',$data_pegawai);
	}
	
	function insert_data_pegawai_agama($data_agama)
	{
		$this->db->insert('v3_peg_agama',$data_agama);
	}
	
	function insert_data_pegawai_alamat($data_alamat)
	{
		$this->db->insert('v3_peg_alamat',$data_alamat);
	}
	
	function insert_data_pegawai_ayah($data_ayah)
	{
		$this->db->insert('v3_peg_ayah',$data_ayah);
	}
	
	function insert_data_pegawai_bahasa($data_bahasa)
	{
		$this->db->insert('v3_peg_bahasa',$data_bahasa);
	}
	
	function insert_data_pegawai_fisik($data_fisik)
	{
		$this->db->insert('v3_peg_fisik',$data_fisik);
	}
	
	function insert_data_pegawai_ibu($data_ibu)
	{
		$this->db->insert('v3_peg_ibu',$data_ibu);
	}
	
	function insert_data_pegawai_jabatan($data_jabatan)
	{
		$this->db->insert('v3_peg_jabatan',$data_jabatan);
	}
	
	function insert_data_pegawai_mert_ayah($data_mert_ayah)
	{
		$this->db->insert('v3_peg_mert_ayah',$data_mert_ayah);
	}
	
	function insert_data_pegawai_mert_ibu($data_mert_ibu)
	{
		$this->db->insert('v3_peg_mert_ibu',$data_mert_ibu);
	}
	
	function insert_data_pegawai_pasangan($data_pasangan)
	{
		$this->db->insert('v3_peg_pasangan',$data_pasangan);
	}
	
	function insert_data_pegawai_pendidikan($data_pendidikan)
	{
		$this->db->insert('v3_peg_pendidikan',$data_pendidikan);
	}
	
	function insert_data_pegawai_status_keluarga($data_status_keluarga)
	{
		$this->db->insert('v3_peg_status_keluarga',$data_status_keluarga);
	}
	
	function insert_data_pegawai_tmt($data_tmt)
	{
		$this->db->insert('v3_peg_tmt',$data_tmt);
	}
	
	function insert_data_pegawai_unit($data_unit)
	{
		$this->db->insert('v3_peg_unit',$data_unit);
	}
	
	function insert_data_pegawai_anak($data_anak)
	{
		$this->db->insert('v3_peg_anak',$data_anak);
	}
	
	function insert_data_pegawai_grade($data_grade)
	{
		$this->db->insert('v3_peg_grade',$data_grade);
	}
	
//-------- update data pegawai --------------//
	
	function update_data_pegawai($data_pegawai)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('peg_nipp', $nipp);
		$this->db->update('v3_pegawai',$data_pegawai);
	}
	
	function update_data_telp($data_telp)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_al_nipp', $nipp);
		$this->db->update('v3_peg_alamat',$data_telp);
	}
	
	function update_data_alamat($data_alamat)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_al_nipp', $nipp);
		$this->db->update('v3_peg_alamat',$data_alamat);
	}
	
	function update_data_pasangan($data_pasangan)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_ps_nipp', $nipp);
		$this->db->update('v3_peg_pasangan',$data_pasangan);
	}
	
	function update_data_ayah($data_ayah)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_ay_nipp', $nipp);
		$this->db->update('v3_peg_ayah',$data_ayah);
	}
	
	function update_data_ibu($data_ibu)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_ibu_nipp', $nipp);
		$this->db->update('v3_peg_ibu',$data_ibu);
	}
	
	function update_data_mert_ayah($data_mert_ayah)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_may_nipp', $nipp);
		$this->db->update('v3_peg_mert_ayah',$data_mert_ayah);
	}
	
	function update_data_mert_ibu($data_mert_ibu)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_mib_nipp', $nipp);
		$this->db->update('v3_peg_mert_ibu',$data_mert_ibu);
	}
	
	function update_data_anak($data_anak)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('peg_ank_nipp', $nipp);
		$this->db->update('v3_peg_anak',$data_anak);
	}
	
	function update_data_pendidikan($data_pendidikan)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_pdd_nipp', $nipp);
		$this->db->update('v3_peg_pendidikan',$data_pendidikan);
	}
	
	function update_data_tmt($tanggal)
	{
		$nipp = $this->uri->segment(3);
		$this->db->where('p_tmt_nipp', $nipp);
		$this->db->update('v3_peg_tmt',$tanggal);
	}
	
	function update_data_bahasa($data_bahasa, $id_bahasa)
	{
		$this->db->where('id_peg_bahasa', $id_bahasa);
		$this->db->update('v3_peg_bahasa',$data_bahasa);
	}
	
	function delete_pegawai($nipp)
	{
		$this->db->where('peg_nipp', $nipp);
		$this->db->delete('v3_pegawai'); 
		$this->db->where('p_ag_nipp', $nipp);
		$this->db->delete('v3_peg_agama'); 
		$this->db->where('p_al_nipp', $nipp);
		$this->db->delete('v3_peg_alamat'); 
		$this->db->where('p_ay_nipp', $nipp);
		$this->db->delete('v3_peg_ayah'); 
		$this->db->where('p_bhs_nipp', $nipp);
		$this->db->delete('v3_peg_bahasa'); 
		$this->db->where('p_fs_nipp', $nipp);
		$this->db->delete('v3_peg_fisik'); 
		$this->db->where('p_ibu_nipp', $nipp);
		$this->db->delete('v3_peg_ibu'); 
		$this->db->where('p_jbt_nipp', $nipp);
		$this->db->delete('v3_peg_jabatan'); 
		$this->db->where('p_may_nipp', $nipp);
		$this->db->delete('v3_peg_mert_ayah'); 
		$this->db->where('p_mib_nipp', $nipp);
		$this->db->delete('v3_peg_mert_ibu'); 
		$this->db->where('p_ps_nipp', $nipp);
		$this->db->delete('v3_peg_pasangan');
		$this->db->where('p_pdd_nipp', $nipp);
		$this->db->delete('v3_peg_pendidikan');
		$this->db->where('p_stk_nipp', $nipp);
		$this->db->delete('v3_peg_status_keluarga');
		$this->db->where('p_tmt_nipp', $nipp);
		$this->db->delete('v3_peg_tmt');
		$this->db->where('p_unt_nipp', $nipp);
		$this->db->delete('v3_peg_unit');
	}

}
/* End of file myfile.php */
/* Location: ./system/modules/mymodule/myfile.php */