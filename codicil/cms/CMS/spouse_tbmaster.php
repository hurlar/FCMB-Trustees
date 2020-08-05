<?php

// title
// fullname
// email
// phoneno
// datecreated

?>
<?php if ($spouse_tb->Visible) { ?>
<table cellspacing="0" id="t_spouse_tb" class="ewGrid"><tr><td>
<table id="tbl_spouse_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($spouse_tb->title->Visible) { // title ?>
		<tr id="r_title">
			<td><?php echo $spouse_tb->title->FldCaption() ?></td>
			<td<?php echo $spouse_tb->title->CellAttributes() ?>>
<span id="el_spouse_tb_title" class="control-group">
<span<?php echo $spouse_tb->title->ViewAttributes() ?>>
<?php echo $spouse_tb->title->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
		<tr id="r_fullname">
			<td><?php echo $spouse_tb->fullname->FldCaption() ?></td>
			<td<?php echo $spouse_tb->fullname->CellAttributes() ?>>
<span id="el_spouse_tb_fullname" class="control-group">
<span<?php echo $spouse_tb->fullname->ViewAttributes() ?>>
<?php echo $spouse_tb->fullname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($spouse_tb->_email->Visible) { // email ?>
		<tr id="r__email">
			<td><?php echo $spouse_tb->_email->FldCaption() ?></td>
			<td<?php echo $spouse_tb->_email->CellAttributes() ?>>
<span id="el_spouse_tb__email" class="control-group">
<span<?php echo $spouse_tb->_email->ViewAttributes() ?>>
<?php echo $spouse_tb->_email->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
		<tr id="r_phoneno">
			<td><?php echo $spouse_tb->phoneno->FldCaption() ?></td>
			<td<?php echo $spouse_tb->phoneno->CellAttributes() ?>>
<span id="el_spouse_tb_phoneno" class="control-group">
<span<?php echo $spouse_tb->phoneno->ViewAttributes() ?>>
<?php echo $spouse_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $spouse_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $spouse_tb->datecreated->CellAttributes() ?>>
<span id="el_spouse_tb_datecreated" class="control-group">
<span<?php echo $spouse_tb->datecreated->ViewAttributes() ?>>
<?php echo $spouse_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
