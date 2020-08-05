<?php

// salutation
// fname
// mname
// lname
// phone
// aphone
// rstate
// gender
// datecreated

?>
<?php if ($personal_info->Visible) { ?>
<table cellspacing="0" id="t_personal_info" class="ewGrid"><tr><td>
<table id="tbl_personal_infomaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
		<tr id="r_salutation">
			<td><?php echo $personal_info->salutation->FldCaption() ?></td>
			<td<?php echo $personal_info->salutation->CellAttributes() ?>>
<span id="el_personal_info_salutation" class="control-group">
<span<?php echo $personal_info->salutation->ViewAttributes() ?>>
<?php echo $personal_info->salutation->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->fname->Visible) { // fname ?>
		<tr id="r_fname">
			<td><?php echo $personal_info->fname->FldCaption() ?></td>
			<td<?php echo $personal_info->fname->CellAttributes() ?>>
<span id="el_personal_info_fname" class="control-group">
<span<?php echo $personal_info->fname->ViewAttributes() ?>>
<?php echo $personal_info->fname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->mname->Visible) { // mname ?>
		<tr id="r_mname">
			<td><?php echo $personal_info->mname->FldCaption() ?></td>
			<td<?php echo $personal_info->mname->CellAttributes() ?>>
<span id="el_personal_info_mname" class="control-group">
<span<?php echo $personal_info->mname->ViewAttributes() ?>>
<?php echo $personal_info->mname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->lname->Visible) { // lname ?>
		<tr id="r_lname">
			<td><?php echo $personal_info->lname->FldCaption() ?></td>
			<td<?php echo $personal_info->lname->CellAttributes() ?>>
<span id="el_personal_info_lname" class="control-group">
<span<?php echo $personal_info->lname->ViewAttributes() ?>>
<?php echo $personal_info->lname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->phone->Visible) { // phone ?>
		<tr id="r_phone">
			<td><?php echo $personal_info->phone->FldCaption() ?></td>
			<td<?php echo $personal_info->phone->CellAttributes() ?>>
<span id="el_personal_info_phone" class="control-group">
<span<?php echo $personal_info->phone->ViewAttributes() ?>>
<?php echo $personal_info->phone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->aphone->Visible) { // aphone ?>
		<tr id="r_aphone">
			<td><?php echo $personal_info->aphone->FldCaption() ?></td>
			<td<?php echo $personal_info->aphone->CellAttributes() ?>>
<span id="el_personal_info_aphone" class="control-group">
<span<?php echo $personal_info->aphone->ViewAttributes() ?>>
<?php echo $personal_info->aphone->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->rstate->Visible) { // rstate ?>
		<tr id="r_rstate">
			<td><?php echo $personal_info->rstate->FldCaption() ?></td>
			<td<?php echo $personal_info->rstate->CellAttributes() ?>>
<span id="el_personal_info_rstate" class="control-group">
<span<?php echo $personal_info->rstate->ViewAttributes() ?>>
<?php echo $personal_info->rstate->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->gender->Visible) { // gender ?>
		<tr id="r_gender">
			<td><?php echo $personal_info->gender->FldCaption() ?></td>
			<td<?php echo $personal_info->gender->CellAttributes() ?>>
<span id="el_personal_info_gender" class="control-group">
<span<?php echo $personal_info->gender->ViewAttributes() ?>>
<?php echo $personal_info->gender->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $personal_info->datecreated->FldCaption() ?></td>
			<td<?php echo $personal_info->datecreated->CellAttributes() ?>>
<span id="el_personal_info_datecreated" class="control-group">
<span<?php echo $personal_info->datecreated->ViewAttributes() ?>>
<?php echo $personal_info->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
