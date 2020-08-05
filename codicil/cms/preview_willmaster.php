<?php

// willtype
// fullname
// email
// phoneno
// gender
// employmentstatus
// maritalstatus
// datecreated

?>
<?php if ($preview_will->Visible) { ?>
<table cellspacing="0" id="t_preview_will" class="ewGrid"><tr><td>
<table id="tbl_preview_willmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($preview_will->willtype->Visible) { // willtype ?>
		<tr id="r_willtype">
			<td><?php echo $preview_will->willtype->FldCaption() ?></td>
			<td<?php echo $preview_will->willtype->CellAttributes() ?>>
<span id="el_preview_will_willtype" class="control-group">
<span<?php echo $preview_will->willtype->ViewAttributes() ?>>
<?php echo $preview_will->willtype->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $preview_will->fullname->FldCaption() ?></td>
			<td<?php echo $preview_will->fullname->CellAttributes() ?>>
<span id="el_preview_will_fullname" class="control-group">
<span<?php echo $preview_will->fullname->ViewAttributes() ?>>
<?php echo $preview_will->fullname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $preview_will->_email->FldCaption() ?></td>
			<td<?php echo $preview_will->_email->CellAttributes() ?>>
<span id="el_preview_will__email" class="control-group">
<span<?php echo $preview_will->_email->ViewAttributes() ?>>
<?php echo $preview_will->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->phoneno->Visible) { // phoneno ?>
		<tr id="r_phoneno">
			<td><?php echo $preview_will->phoneno->FldCaption() ?></td>
			<td<?php echo $preview_will->phoneno->CellAttributes() ?>>
<span id="el_preview_will_phoneno" class="control-group">
<span<?php echo $preview_will->phoneno->ViewAttributes() ?>>
<?php echo $preview_will->phoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $preview_will->gender->FldCaption() ?></td>
			<td<?php echo $preview_will->gender->CellAttributes() ?>>
<span id="el_preview_will_gender" class="control-group">
<span<?php echo $preview_will->gender->ViewAttributes() ?>>
<?php echo $preview_will->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->employmentstatus->Visible) { // employmentstatus ?>
		<tr id="r_employmentstatus">
			<td><?php echo $preview_will->employmentstatus->FldCaption() ?></td>
			<td<?php echo $preview_will->employmentstatus->CellAttributes() ?>>
<span id="el_preview_will_employmentstatus" class="control-group">
<span<?php echo $preview_will->employmentstatus->ViewAttributes() ?>>
<?php echo $preview_will->employmentstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->maritalstatus->Visible) { // maritalstatus ?>
		<tr id="r_maritalstatus">
			<td><?php echo $preview_will->maritalstatus->FldCaption() ?></td>
			<td<?php echo $preview_will->maritalstatus->CellAttributes() ?>>
<span id="el_preview_will_maritalstatus" class="control-group">
<span<?php echo $preview_will->maritalstatus->ViewAttributes() ?>>
<?php echo $preview_will->maritalstatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($preview_will->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $preview_will->datecreated->FldCaption() ?></td>
			<td<?php echo $preview_will->datecreated->CellAttributes() ?>>
<span id="el_preview_will_datecreated" class="control-group">
<span<?php echo $preview_will->datecreated->ViewAttributes() ?>>
<?php echo $preview_will->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
