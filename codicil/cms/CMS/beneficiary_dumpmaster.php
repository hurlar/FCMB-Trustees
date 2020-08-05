<?php

// title
// fullname
// rtionship
// email
// phone
// city
// state
// datecreated

?>
<?php if ($beneficiary_dump->Visible) { ?>
<table cellspacing="0" id="t_beneficiary_dump" class="ewGrid"><tr><td>
<table id="tbl_beneficiary_dumpmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($beneficiary_dump->title->Visible) { // title ?>
		<tr id="r_title">
			<td><?php echo $beneficiary_dump->title->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->title->CellAttributes() ?>>
<span id="el_beneficiary_dump_title" class="control-group">
<span<?php echo $beneficiary_dump->title->ViewAttributes() ?>>
<?php echo $beneficiary_dump->title->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $beneficiary_dump->fullname->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->fullname->CellAttributes() ?>>
<span id="el_beneficiary_dump_fullname" class="control-group">
<span<?php echo $beneficiary_dump->fullname->ViewAttributes() ?>>
<?php echo $beneficiary_dump->fullname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->rtionship->Visible) { // rtionship ?>
		<tr id="r_rtionship">
			<td><?php echo $beneficiary_dump->rtionship->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->rtionship->CellAttributes() ?>>
<span id="el_beneficiary_dump_rtionship" class="control-group">
<span<?php echo $beneficiary_dump->rtionship->ViewAttributes() ?>>
<?php echo $beneficiary_dump->rtionship->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $beneficiary_dump->_email->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->_email->CellAttributes() ?>>
<span id="el_beneficiary_dump__email" class="control-group">
<span<?php echo $beneficiary_dump->_email->ViewAttributes() ?>>
<?php echo $beneficiary_dump->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->phone->Visible) { // phone ?>
		<tr id="r_phone">
			<td><?php echo $beneficiary_dump->phone->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->phone->CellAttributes() ?>>
<span id="el_beneficiary_dump_phone" class="control-group">
<span<?php echo $beneficiary_dump->phone->ViewAttributes() ?>>
<?php echo $beneficiary_dump->phone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->city->Visible) { // city ?>
		<tr id="r_city">
			<td><?php echo $beneficiary_dump->city->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->city->CellAttributes() ?>>
<span id="el_beneficiary_dump_city" class="control-group">
<span<?php echo $beneficiary_dump->city->ViewAttributes() ?>>
<?php echo $beneficiary_dump->city->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->state->Visible) { // state ?>
		<tr id="r_state">
			<td><?php echo $beneficiary_dump->state->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->state->CellAttributes() ?>>
<span id="el_beneficiary_dump_state" class="control-group">
<span<?php echo $beneficiary_dump->state->ViewAttributes() ?>>
<?php echo $beneficiary_dump->state->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($beneficiary_dump->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $beneficiary_dump->datecreated->FldCaption() ?></td>
			<td<?php echo $beneficiary_dump->datecreated->CellAttributes() ?>>
<span id="el_beneficiary_dump_datecreated" class="control-group">
<span<?php echo $beneficiary_dump->datecreated->ViewAttributes() ?>>
<?php echo $beneficiary_dump->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
