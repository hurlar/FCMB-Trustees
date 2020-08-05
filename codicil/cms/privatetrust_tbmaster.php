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
// employmentstatus
// maritalstatus
// datecreated

?>
<?php if ($privatetrust_tb->Visible) { ?>
<table cellspacing="0" id="t_privatetrust_tb" class="ewGrid"><tr><td>
<table id="tbl_privatetrust_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($privatetrust_tb->willtype->Visible) { // willtype ?>
		<tr id="r_willtype">
			<td><?php echo $privatetrust_tb->willtype->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->willtype->CellAttributes() ?>>
<span id="el_privatetrust_tb_willtype" class="control-group">
<span<?php echo $privatetrust_tb->willtype->ViewAttributes() ?>>
<?php echo $privatetrust_tb->willtype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $privatetrust_tb->fullname->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->fullname->CellAttributes() ?>>
<span id="el_privatetrust_tb_fullname" class="control-group">
<span<?php echo $privatetrust_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($privatetrust_tb->fullname->ListViewValue()) && $privatetrust_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $privatetrust_tb->fullname->LinkAttributes() ?>><?php echo $privatetrust_tb->fullname->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $privatetrust_tb->fullname->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $privatetrust_tb->_email->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->_email->CellAttributes() ?>>
<span id="el_privatetrust_tb__email" class="control-group">
<span<?php echo $privatetrust_tb->_email->ViewAttributes() ?>>
<?php echo $privatetrust_tb->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->phoneno->Visible) { // phoneno ?>
		<tr id="r_phoneno">
			<td><?php echo $privatetrust_tb->phoneno->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->phoneno->CellAttributes() ?>>
<span id="el_privatetrust_tb_phoneno" class="control-group">
<span<?php echo $privatetrust_tb->phoneno->ViewAttributes() ?>>
<?php echo $privatetrust_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->aphoneno->Visible) { // aphoneno ?>
		<tr id="r_aphoneno">
			<td><?php echo $privatetrust_tb->aphoneno->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->aphoneno->CellAttributes() ?>>
<span id="el_privatetrust_tb_aphoneno" class="control-group">
<span<?php echo $privatetrust_tb->aphoneno->ViewAttributes() ?>>
<?php echo $privatetrust_tb->aphoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $privatetrust_tb->gender->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->gender->CellAttributes() ?>>
<span id="el_privatetrust_tb_gender" class="control-group">
<span<?php echo $privatetrust_tb->gender->ViewAttributes() ?>>
<?php echo $privatetrust_tb->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->dob->Visible) { // dob ?>
		<tr id="r_dob">
			<td><?php echo $privatetrust_tb->dob->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->dob->CellAttributes() ?>>
<span id="el_privatetrust_tb_dob" class="control-group">
<span<?php echo $privatetrust_tb->dob->ViewAttributes() ?>>
<?php echo $privatetrust_tb->dob->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->state->Visible) { // state ?>
		<tr id="r_state">
			<td><?php echo $privatetrust_tb->state->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->state->CellAttributes() ?>>
<span id="el_privatetrust_tb_state" class="control-group">
<span<?php echo $privatetrust_tb->state->ViewAttributes() ?>>
<?php echo $privatetrust_tb->state->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->nationality->Visible) { // nationality ?>
		<tr id="r_nationality">
			<td><?php echo $privatetrust_tb->nationality->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->nationality->CellAttributes() ?>>
<span id="el_privatetrust_tb_nationality" class="control-group">
<span<?php echo $privatetrust_tb->nationality->ViewAttributes() ?>>
<?php echo $privatetrust_tb->nationality->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->employmentstatus->Visible) { // employmentstatus ?>
		<tr id="r_employmentstatus">
			<td><?php echo $privatetrust_tb->employmentstatus->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->employmentstatus->CellAttributes() ?>>
<span id="el_privatetrust_tb_employmentstatus" class="control-group">
<span<?php echo $privatetrust_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $privatetrust_tb->employmentstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->maritalstatus->Visible) { // maritalstatus ?>
		<tr id="r_maritalstatus">
			<td><?php echo $privatetrust_tb->maritalstatus->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->maritalstatus->CellAttributes() ?>>
<span id="el_privatetrust_tb_maritalstatus" class="control-group">
<span<?php echo $privatetrust_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $privatetrust_tb->maritalstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($privatetrust_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $privatetrust_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $privatetrust_tb->datecreated->CellAttributes() ?>>
<span id="el_privatetrust_tb_datecreated" class="control-group">
<span<?php echo $privatetrust_tb->datecreated->ViewAttributes() ?>>
<?php echo $privatetrust_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
