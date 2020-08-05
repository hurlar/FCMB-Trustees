<?php

// asset_type
// account_name
// bankname
// pension_admin
// datecreated

?>
<?php if ($simplewill_assets_tb->Visible) { ?>
<table cellspacing="0" id="t_simplewill_assets_tb" class="ewGrid"><tr><td>
<table id="tbl_simplewill_assets_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($simplewill_assets_tb->asset_type->Visible) { // asset_type ?>
		<tr id="r_asset_type">
			<td><?php echo $simplewill_assets_tb->asset_type->FldCaption() ?></td>
			<td<?php echo $simplewill_assets_tb->asset_type->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_asset_type" class="control-group">
<span<?php echo $simplewill_assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->asset_type->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->account_name->Visible) { // account_name ?>
		<tr id="r_account_name">
			<td><?php echo $simplewill_assets_tb->account_name->FldCaption() ?></td>
			<td<?php echo $simplewill_assets_tb->account_name->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_account_name" class="control-group">
<span<?php echo $simplewill_assets_tb->account_name->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->account_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->bankname->Visible) { // bankname ?>
		<tr id="r_bankname">
			<td><?php echo $simplewill_assets_tb->bankname->FldCaption() ?></td>
			<td<?php echo $simplewill_assets_tb->bankname->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_bankname" class="control-group">
<span<?php echo $simplewill_assets_tb->bankname->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->bankname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->pension_admin->Visible) { // pension_admin ?>
		<tr id="r_pension_admin">
			<td><?php echo $simplewill_assets_tb->pension_admin->FldCaption() ?></td>
			<td<?php echo $simplewill_assets_tb->pension_admin->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_pension_admin" class="control-group">
<span<?php echo $simplewill_assets_tb->pension_admin->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->pension_admin->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($simplewill_assets_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $simplewill_assets_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $simplewill_assets_tb->datecreated->CellAttributes() ?>>
<span id="el_simplewill_assets_tb_datecreated" class="control-group">
<span<?php echo $simplewill_assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
