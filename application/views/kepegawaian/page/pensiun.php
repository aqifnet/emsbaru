<div class="widget">
<?php echo form_open('pekerja/sort_tahun_pensiun/') ?>
<fieldset class="step" id="w2first">
<table><tr>
<td width="340"><div class="formBaru"><label>Tahun: &nbsp </label>
<?php $tahun = array(
		'2005' => '2005',
		'2006' => '2006',
		'2007' => '2007',
		'2008' => '2008',
		'2009' => '2009',
		'2010' => '2010',
		'2011' => '2011',
		'2012' => '2012',
		'2013' => '2013',
		'2014' => '2014',
		'2015' => '2015',
		);
	echo form_input('tahun',$tanggal);?></form>&nbsp
	</form> </div></td><td width="340px">
<div class="formBaru"><label>Jenis: &nbsp </label>
<?php $jenis = array(
		'ALL'     => 'ALL',
		'MPP'     => 'Masa Persiapan Pensiun',
		'Pensiun' => 'Pensiun',
		'PPB'     => 'Pelatihan Purna Bakti',
		);
	echo form_dropdown('jenis',$jenis, $type); ?></div></td><td width="100"><div class="formBaru">&nbsp 
	<?php $submit = array(
		'class' => 'blueB m110',
		'id'	=> 'next2',
		'value'	=> 'Sort',
		); 
	echo form_submit($submit)?></form></div></td>
	<!--<td width="440px"><div class="searchWidget"><?php echo form_open('pekerja/search_pegawai');?>
                        <input type="text" name="search"  placeholder="Enter search text..." />
                        <input type="submit" name="find" value="" class="blueB m110"/></div>
                    </form></td> --></tr>

</div></div></table></fieldset>
</div>
<div class="oneTwo"> 
<div class="searchWidget">
                    
                </div><br/>
</div>
<div class="widget">  
		  <div class="title"><img src="<?php echo base_url()?>images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Data Pegawai</h6></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>NIPP</td>
                        <td>Nama</td>
                        <td>Tempat Lahir</td>
                        <td>Tanggal Lahir</td>
                        <td>Jenis Kelamin</td>
                        <td>Jabatan</td>
                        <td>T.M.T Pensiun</td>
                    </tr>
                </thead>
				<tfoot>
					<tr><td colspan=8><center><div class="pagination"><?php echo $this->pagination->create_links();?></div></center></td></td></tr>
				</tfoot>
				<tbody>
				<?php 
				if ($this->uri->segment(3)== NULL)
				{
					$number = 1;
				} else {
					$number = $this->uri->segment(3)+1;
				}
				foreach ($pegawai as $row_pegawai) :
				{ 
					if ($row_pegawai['peg_jns_kelamin'] == 'P')
					{
						$kelamin = 'Perempuan';
					}
					else
					{
						$kelamin = 'Laki Laki';
					}
					$datestring = "%d-%m-%Y" ;
					$tgl_lahir = mdate($datestring,strtotime($row_pegawai['peg_tgl_lahir']));
					$detail = anchor('pekerja/get_pegawai/'.$row_pegawai['peg_nipp'],'Detail'); ?>
					<tr>
                        <td><center><?php echo $number; ?></center></td>
						<td><center><?php echo $row_pegawai['peg_nipp']; ?></center></td>
						<td><?php echo $row_pegawai['peg_nama']; ?></td>
						<td><?php echo $row_pegawai['peg_tmpt_lahir']; ?></td>
						<td><center><?php echo $tgl_lahir; ?></center></td>
						<td><center><?php echo $kelamin; ?></center></td>
						<td><center><?php echo $row_pegawai['p_jbt_jabatan']; ?></center></td>
						<td><center><?php echo $detail ?></center></td>
                    </tr> <?php
					$number++;
				}endforeach; 
				?>
                </tbody>
            </table>
			
        </div>