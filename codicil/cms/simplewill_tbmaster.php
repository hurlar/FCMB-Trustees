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
// identificationtype
// employmentstatus
// maritalstatus
// datecreated

?>
<?php if ($simplewill_tb->Visible) { ?>
<table cellspacing="0" id="t_simplewill_tb" class="ewGrid"><tr><td>
<table id="tbl_simplewill_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($simplewill_tb->willtype->Visible) { // willtype ?>
		<tr id="r_willtype">
			<td><?php echo $simplewill_tb->willtype->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->willtype->CellAttributes() ?>>
<span id="el_simplewill_tb_willtype" class="control-group">
<span<?php echo $simplewill_tb->willtype->ViewAttributes() ?>>
<?php echo $simplewill_tb->willtype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $simplewill_tb->fullname->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->fullname->CellAttributes() ?>>
<span id="el_simplewill_tb_fullname" class="control-group">
<span<?php echo $simplewill_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($simplewill_tb->fullname->ListViewValue()) && $simplewill_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $simplewill_tb->fullname->LinkAttributes() ?>><?php echo $simplewill_tb->fullname->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $simplewill_tb->fullname->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $simplewill_tb->_email->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->_email->CellAttributes() ?>>
<span id="el_simplewill_tb__email" class="control-group">
<span<?php echo $simplewill_tb->_email->ViewAttributes() ?>>
<?php echo $simplewill_tb->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->phoneno->Visible) { // phoneno ?>
		<tr id="r_phoneno">
			<td><?php echo $simplewill_tb->phoneno->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->phoneno->CellAttributes() ?>>
<span id="el_simplewill_tb_phoneno" class="control-group">
<span<?php echo $simplewill_tb->phoneno->ViewAttributes() ?>>
<?php echo $simplewill_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->aphoneno->Visible) { // aphoneno ?>
		<tr id="r_aphoneno">
			<td><?php echo $simplewill_tb->aphoneno->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->aphoneno->CellAttributes() ?>>
<span id="el_simplewill_tb_aphoneno" class="control-group">
<span<?php echo $simplewill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $simplewill_tb->aphoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $simplewill_tb->gender->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->gender->CellAttributes() ?>>
<span id="el_simplewill_tb_gender" class="control-group">
<span<?php echo $simplewill_tb->gender->ViewAttributes() ?>>
<?php echo $simplewill_tb->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->dob->Visible) { // dob ?>
		<tr id="r_dob">
			<td><?php echo $simplewill_tb->dob->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->dob->CellAttributes() ?>>
<span id="el_simplewill_tb_dob" class="control-group">
<span<?php echo $simplewill_tb->dob->ViewAttributes() ?>>
<?php echo $simplewill_tb->dob->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->state->Visible) { // state ?>
		<tr id="r_state">
			<td><?php echo $simplewill_tb->state->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->state->CellAttributes() ?>>
<span id="el_simplewill_tb_state" class="control-group">
<span<?php echo $simplewill_tb->state->ViewAttributes() ?>>
<?php echo $simplewill_tb->state->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->nationality->Visible) { // nationality ?>
		<tr id="r_nationality">
			<td><?php echo $simplewill_tb->nationality->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->nationality->CellAttributes() ?>>
<span id="el_simplewill_tb_nationality" class="control-group">
<span<?php echo $simplewill_tb->nationality->ViewAttributes() ?>>
<?php echo $simplewill_tb->nationality->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->identificationtype->Visible) { // identificationtype ?>
		<tr id="r_identificationtype">
			<td><?php echo $simplewill_tb->identificationtype->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->identificationtype->CellAttributes() ?>>
<span id="el_simplewill_tb_identificationtype" class="control-group">
<span<?php echo $simplewill_tb->identificationtype->ViewAttributes() ?>>
<?php echo $simplewill_tb->identificationtype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->employmentstatus->Visible) { // employmentstatus ?>
		<tr id="r_employmentstatus">
			<td><?php echo $simplewill_tb->employmentstatus->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_simplewill_tb_employmentstatus" class="control-group">
<span<?php echo $simplewill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $simplewill_tb->employmentstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->maritalstatus->Visible) { // maritalstatus ?>
		<tr id="r_maritalstatus">
			<td><?php echo $simplewill_tb->maritalstatus->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_simplewill_tb_maritalstatus" class="control-group">
<span<?php echo $simplewill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $simplewill_tb->maritalstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $simplewill_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $simplewill_tb->datecreated->CellAttributes() ?>>
<span id="el_simplewill_tb_datecreated" class="control-group">
<span<?php echo $simplewill_tb->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
