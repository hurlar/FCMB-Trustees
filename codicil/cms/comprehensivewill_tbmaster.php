<?php

// willtype
// fullname
// email
// phoneno
// aphoneno
// gender
// dob
// state
// nationality
// lga
// employmentstatus
// employerphone
// maritalstatus
// spname
// spemail
// spphone
// sdob
// spcity
// spstate
// marriagetype
// marriageyear
// marriagecert
// marriagecity
// marriagecountry
// divorce
// divorceyear
// addinfo
// datecreated

?>
<?php if ($comprehensivewill_tb->Visible) { ?>
<table cellspacing="0" id="t_comprehensivewill_tb" class="ewGrid"><tr><td>
<table id="tbl_comprehensivewill_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
		<tr id="r_willtype">
			<td><?php echo $comprehensivewill_tb->willtype->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->willtype->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_willtype" class="control-group">
<span<?php echo $comprehensivewill_tb->willtype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->willtype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $comprehensivewill_tb->fullname->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->fullname->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_fullname" class="control-group">
<span<?php echo $comprehensivewill_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($comprehensivewill_tb->fullname->ListViewValue()) && $comprehensivewill_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $comprehensivewill_tb->fullname->LinkAttributes() ?>><?php echo $comprehensivewill_tb->fullname->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $comprehensivewill_tb->fullname->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $comprehensivewill_tb->_email->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->_email->CellAttributes() ?>>
<span id="el_comprehensivewill_tb__email" class="control-group">
<span<?php echo $comprehensivewill_tb->_email->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
		<tr id="r_phoneno">
			<td><?php echo $comprehensivewill_tb->phoneno->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->phoneno->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_phoneno" class="control-group">
<span<?php echo $comprehensivewill_tb->phoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
		<tr id="r_aphoneno">
			<td><?php echo $comprehensivewill_tb->aphoneno->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->aphoneno->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_aphoneno" class="control-group">
<span<?php echo $comprehensivewill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->aphoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $comprehensivewill_tb->gender->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->gender->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_gender" class="control-group">
<span<?php echo $comprehensivewill_tb->gender->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
		<tr id="r_dob">
			<td><?php echo $comprehensivewill_tb->dob->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->dob->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_dob" class="control-group">
<span<?php echo $comprehensivewill_tb->dob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->dob->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
		<tr id="r_state">
			<td><?php echo $comprehensivewill_tb->state->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->state->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_state" class="control-group">
<span<?php echo $comprehensivewill_tb->state->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->state->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
		<tr id="r_nationality">
			<td><?php echo $comprehensivewill_tb->nationality->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->nationality->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_nationality" class="control-group">
<span<?php echo $comprehensivewill_tb->nationality->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->nationality->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
		<tr id="r_lga">
			<td><?php echo $comprehensivewill_tb->lga->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->lga->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_lga" class="control-group">
<span<?php echo $comprehensivewill_tb->lga->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->lga->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
		<tr id="r_employmentstatus">
			<td><?php echo $comprehensivewill_tb->employmentstatus->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employmentstatus" class="control-group">
<span<?php echo $comprehensivewill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employmentstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
		<tr id="r_employerphone">
			<td><?php echo $comprehensivewill_tb->employerphone->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->employerphone->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_employerphone" class="control-group">
<span<?php echo $comprehensivewill_tb->employerphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employerphone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
		<tr id="r_maritalstatus">
			<td><?php echo $comprehensivewill_tb->maritalstatus->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_maritalstatus" class="control-group">
<span<?php echo $comprehensivewill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->maritalstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
		<tr id="r_spname">
			<td><?php echo $comprehensivewill_tb->spname->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->spname->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spname" class="control-group">
<span<?php echo $comprehensivewill_tb->spname->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
		<tr id="r_spemail">
			<td><?php echo $comprehensivewill_tb->spemail->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->spemail->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spemail" class="control-group">
<span<?php echo $comprehensivewill_tb->spemail->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spemail->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
		<tr id="r_spphone">
			<td><?php echo $comprehensivewill_tb->spphone->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->spphone->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spphone" class="control-group">
<span<?php echo $comprehensivewill_tb->spphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spphone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
		<tr id="r_sdob">
			<td><?php echo $comprehensivewill_tb->sdob->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->sdob->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_sdob" class="control-group">
<span<?php echo $comprehensivewill_tb->sdob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->sdob->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
		<tr id="r_spcity">
			<td><?php echo $comprehensivewill_tb->spcity->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->spcity->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spcity" class="control-group">
<span<?php echo $comprehensivewill_tb->spcity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spcity->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
		<tr id="r_spstate">
			<td><?php echo $comprehensivewill_tb->spstate->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->spstate->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_spstate" class="control-group">
<span<?php echo $comprehensivewill_tb->spstate->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spstate->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
		<tr id="r_marriagetype">
			<td><?php echo $comprehensivewill_tb->marriagetype->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->marriagetype->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagetype" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagetype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagetype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
		<tr id="r_marriageyear">
			<td><?php echo $comprehensivewill_tb->marriageyear->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->marriageyear->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriageyear" class="control-group">
<span<?php echo $comprehensivewill_tb->marriageyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriageyear->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
		<tr id="r_marriagecert">
			<td><?php echo $comprehensivewill_tb->marriagecert->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->marriagecert->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecert" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagecert->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecert->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
		<tr id="r_marriagecity">
			<td><?php echo $comprehensivewill_tb->marriagecity->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->marriagecity->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecity" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagecity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecity->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
		<tr id="r_marriagecountry">
			<td><?php echo $comprehensivewill_tb->marriagecountry->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->marriagecountry->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_marriagecountry" class="control-group">
<span<?php echo $comprehensivewill_tb->marriagecountry->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecountry->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
		<tr id="r_divorce">
			<td><?php echo $comprehensivewill_tb->divorce->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->divorce->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_divorce" class="control-group">
<span<?php echo $comprehensivewill_tb->divorce->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorce->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
		<tr id="r_divorceyear">
			<td><?php echo $comprehensivewill_tb->divorceyear->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->divorceyear->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_divorceyear" class="control-group">
<span<?php echo $comprehensivewill_tb->divorceyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorceyear->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
		<tr id="r_addinfo">
			<td><?php echo $comprehensivewill_tb->addinfo->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->addinfo->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_addinfo" class="control-group">
<span<?php echo $comprehensivewill_tb->addinfo->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->addinfo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $comprehensivewill_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $comprehensivewill_tb->datecreated->CellAttributes() ?>>
<span id="el_comprehensivewill_tb_datecreated" class="control-group">
<span<?php echo $comprehensivewill_tb->datecreated->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
