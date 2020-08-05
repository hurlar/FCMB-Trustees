<?php

// name
// gender
// dob
// age
// title
// guardianname
// rtionship
// email
// phone
// datecreated

?>
<?php if ($children_details->Visible) { ?>
<table cellspacing="0" id="t_children_details" class="ewGrid"><tr><td>
<table id="tbl_children_detailsmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($children_details->name->Visible) { // name ?>
		<tr id="r_name">
			<td><?php echo $children_details->name->FldCaption() ?></td>
			<td<?php echo $children_details->name->CellAttributes() ?>>
<span id="el_children_details_name" class="control-group">
<span<?php echo $children_details->name->ViewAttributes() ?>>
<?php echo $children_details->name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $children_details->gender->FldCaption() ?></td>
			<td<?php echo $children_details->gender->CellAttributes() ?>>
<span id="el_children_details_gender" class="control-group">
<span<?php echo $children_details->gender->ViewAttributes() ?>>
<?php echo $children_details->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->dob->Visible) { // dob ?>
		<tr id="r_dob">
			<td><?php echo $children_details->dob->FldCaption() ?></td>
			<td<?php echo $children_details->dob->CellAttributes() ?>>
<span id="el_children_details_dob" class="control-group">
<span<?php echo $children_details->dob->ViewAttributes() ?>>
<?php echo $children_details->dob->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->age->Visible) { // age ?>
		<tr id="r_age">
			<td><?php echo $children_details->age->FldCaption() ?></td>
			<td<?php echo $children_details->age->CellAttributes() ?>>
<span id="el_children_details_age" class="control-group">
<span<?php echo $children_details->age->ViewAttributes() ?>>
<?php echo $children_details->age->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->title->Visible) { // title ?>
		<tr id="r_title">
			<td><?php echo $children_details->title->FldCaption() ?></td>
			<td<?php echo $children_details->title->CellAttributes() ?>>
<span id="el_children_details_title" class="control-group">
<span<?php echo $children_details->title->ViewAttributes() ?>>
<?php echo $children_details->title->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->guardianname->Visible) { // guardianname ?>
		<tr id="r_guardianname">
			<td><?php echo $children_details->guardianname->FldCaption() ?></td>
			<td<?php echo $children_details->guardianname->CellAttributes() ?>>
<span id="el_children_details_guardianname" class="control-group">
<span<?php echo $children_details->guardianname->ViewAttributes() ?>>
<?php echo $children_details->guardianname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->rtionship->Visible) { // rtionship ?>
		<tr id="r_rtionship">
			<td><?php echo $children_details->rtionship->FldCaption() ?></td>
			<td<?php echo $children_details->rtionship->CellAttributes() ?>>
<span id="el_children_details_rtionship" class="control-group">
<span<?php echo $children_details->rtionship->ViewAttributes() ?>>
<?php echo $children_details->rtionship->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $children_details->_email->FldCaption() ?></td>
			<td<?php echo $children_details->_email->CellAttributes() ?>>
<span id="el_children_details__email" class="control-group">
<span<?php echo $children_details->_email->ViewAttributes() ?>>
<?php echo $children_details->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->phone->Visible) { // phone ?>
		<tr id="r_phone">
			<td><?php echo $children_details->phone->FldCaption() ?></td>
			<td<?php echo $children_details->phone->CellAttributes() ?>>
<span id="el_children_details_phone" class="control-group">
<span<?php echo $children_details->phone->ViewAttributes() ?>>
<?php echo $children_details->phone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($children_details->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $children_details->datecreated->FldCaption() ?></td>
			<td<?php echo $children_details->datecreated->CellAttributes() ?>>
<span id="el_children_details_datecreated" class="control-group">
<span<?php echo $children_details->datecreated->ViewAttributes() ?>>
<?php echo $children_details->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
