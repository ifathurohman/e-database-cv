<?php $this->load->view($css); ?>
<table style="width:100%;margin:0px;">
	<tr>
      <td align="center" style="text-align:-webkit-center;">
        <center>
        <?php if(is_file($logo)): ?>
        <div>
        <img src="<?= site_url($logo) ?>" width="70px">
        </div>
        <?php endif; ?>
        <span style="font-weight:bold;"><?= $CompanyName ?></span>
        <br/>
        </center>
      </td>
    </tr>
</table>
<hr style=" border: 0;height: 1px; background: #333;"  align="bottom">
<div class="vPeriode" align="center" style="margin-bottom:10px;text-align:-webkit-center;margin-top:10px;">
   	<?= $Name ?><br>
   	<?php
   	$StartDate  = $this->input->post('StartDate');
    $EndDate    = $this->input->post('EndDate');
    if(!$StartDate): $StartDate = '-'; endif;
    if(!$EndDate): $EndDate = '-'; endif;

    echo 'Period '.$StartDate." to ".$EndDate;
   	?>
   	</div>
<?php $this->load->view($content); ?>