<?php $this->load->helper('asset'); ?>
<div class="widget">
          <div class="title"><img src="<?php echo base_url()?>images/icons/dark/frames.png" alt="" class="titleIcon" />
          <h6>DATA ABSENSI&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;UNIT <?php echo $unitshow?></h6></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
                    	<td rowspan="2">NO</td>
                        <td rowspan="2">NIPP </td>
                        <td colspan="5"><?php echo $bulantahun; ?></td>
                    </tr>
                    <tr>
                    	<td>Telat HK / menit</td>
                        <td>Lembur HK / menit</td>
                        <td>Lembur HL / menit</td>
                        <td>Exvo</td>
                        <td>Action</td>
                    </tr>
                 <?php $numbering=1; foreach($showdata as $sd) { ?>
				<tr>
                	<td><?php echo $numbering++; ?></td>
                    <td><?php echo $sd['peg_nipp'];?></td>
                    <?php 
					$telathk = 0; $lemburhk = 0; $lemburhl = 0; $exvo = 0;
					$tgl = createDateRangeArray($startdate, $enddate); 
						for($i=0;$i<=$jmlhari;$i++)
						{
							$data = ambil_jam_absensi($sd['fschpeg_id'], $tgl[$i], $year);
							//print_r($data);
							$hitung = hit_telat_dan_lembur($data[0], $data[1], $data[2], $data[3], $data[4]);
							$telathk  = $telathk  + $hitung[0];
							$lemburhk = $lemburhk + $hitung[1];
							$lemburhl = $lemburhl + $hitung[2];
							$exvo = $exvo + $hitung[3];
						}
					?>
                    <td><?php echo $telathk; ?> </td>
                    <td><?php echo $lemburhk; ?></td>
                    <td><?php echo $lemburhl; ?></td>
                    <td><?php echo $exvo; ?></td>
                    <td><?php echo anchor('c_absensi/view_detail_absensi/'.$sd['fschpeg_id'].'/'.$month.'/'.$year.'', 
					img(array('src'=>'images/icons/control/16/project.png','border'=>'0','alt'=>'Detail')) , 'title="Detail"' ); ?>
        				</td>
                </tr>
                <?php } ?>
                </thead>
            </table>
			
        </div>