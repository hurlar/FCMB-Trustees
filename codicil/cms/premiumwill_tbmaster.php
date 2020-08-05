<?php

// willtype
// fullname
// email
// phoneno
// aphoneno
// gender
// dob
// state
// employmentstatus
// maritalstatus
// datecreated

?>
<?php if ($premiumwill_tb->Visible) { ?>
<table cellspacing="0" id="t_premiumwill_tb" class="ewGrid"><tr><td>
<table id="tbl_premiumwill_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($premiumwill_tb->willtype->Visible) { // willtype ?>
		<tr id="r_willtype">
			<td><?php echo $premiumwill_tb->willtype->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->willtype->CellAttributes() ?>>
<span id="el_premiumwill_tb_willtype" class="control-group">
<span<?php echo $premiumwill_tb->willtype->ViewAttributes() ?>>
<?php echo $premiumwill_tb->willtype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $premiumwill_tb->fullname->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->fullname->CellAttributes() ?>>
<span id="el_premiumwill_tb_fullname" class="control-group">
<span<?php echo $premiumwill_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($premiumwill_tb->fullname->ListViewValue()) && $premiumwill_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $premiumwill_tb->fullname->LinkAttributes() ?>><?php echo $premiumwill_tb->fullname->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $premiumwill_tb->fullname->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $premiumwill_tb->_email->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->_email->CellAttributes() ?>>
<span id="el_premiumwill_tb__email" class="control-group">
<span<?php echo $premiumwill_tb->_email->ViewAttributes() ?>>
<?php echo $premiumwill_tb->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->phoneno->Visible) { // phoneno ?>
		<tr id="r_phoneno">
			<td><?php echo $premiumwill_tb->phoneno->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->phoneno->CellAttributes() ?>>
<span id="el_premiumwill_tb_phoneno" class="control-group">
<span<?php echo $premiumwill_tb->phoneno->ViewAttributes() ?>>
<?php echo $premiumwill_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->aphoneno->Visible) { // aphoneno ?>
		<tr id="r_aphoneno">
			<td><?php echo $premiumwill_tb->aphoneno->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->aphoneno->CellAttributes() ?>>
<span id="el_premiumwill_tb_aphoneno" class="control-group">
<span<?php echo $premiumwill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $premiumwill_tb->aphoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $premiumwill_tb->gender->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->gender->CellAttributes() ?>>
<span id="el_premiumwill_tb_gender" class="control-group">
<span<?php echo $premiumwill_tb->gender->ViewAttributes() ?>>
<?php echo $premiumwill_tb->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->dob->Visible) { // dob ?>
		<tr id="r_dob">
			<td><?php echo $premiumwill_tb->dob->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->dob->CellAttributes() ?>>
<span id="el_premiumwill_tb_dob" class="control-group">
<span<?php echo $premiumwill_tb->dob->ViewAttributes() ?>>
<?php echo $premiumwill_tb->dob->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->state->Visible) { // state ?>
		<tr id="r_state">
			<td><?php echo $premiumwill_tb->state->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->state->CellAttributes() ?>>
<span id="el_premiumwill_tb_state" class="control-group">
<span<?php echo $premiumwill_tb->state->ViewAttributes() ?>>
<?php echo $premiumwill_tb->state->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->employmentstatus->Visible) { // employmentstatus ?>
		<tr id="r_employmentstatus">
			<td><?php echo $premiumwill_tb->employmentstatus->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->employmentstatus->CellAttributes() ?>>
<span id="el_premiumwill_tb_employmentstatus" class="control-group">
<span<?php echo $premiumwill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $premiumwill_tb->employmentstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->maritalstatus->Visible) { // maritalstatus ?>
		<tr id="r_maritalstatus">
			<td><?php echo $premiumwill_tb->maritalstatus->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->maritalstatus->CellAttributes() ?>>
<span id="el_premiumwill_tb_maritalstatus" class="control-group">
<span<?php echo $premiumwill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $premiumwill_tb->maritalstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($premiumwill_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $premiumwill_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $premiumwill_tb->datecreated->CellAttributes() ?>>
<span id="el_premiumwill_tb_datecreated" class="control-group">
<span<?php echo $premiumwill_tb->datecreated->ViewAttributes() ?>>
<?php echo $premiumwill_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
