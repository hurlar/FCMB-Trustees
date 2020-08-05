<?php

// asset_type
// property_location
// property_type
// shares_company
// insurance_company
// insurance_type
// account_name
// bankname
// pension_name
// pension_owner
// datecreated

?>
<?php if ($assets_tb->Visible) { ?>
<table cellspacing="0" id="t_assets_tb" class="ewGrid"><tr><td>
<table id="tbl_assets_tbmaster" class="table table-bordered table-striped">
	<tbody>
<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
		<tr id="r_asset_type">
			<td><?php echo $assets_tb->asset_type->FldCaption() ?></td>
			<td<?php echo $assets_tb->asset_type->CellAttributes() ?>>
<span id="el_assets_tb_asset_type" class="control-group">
<span<?php echo $assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $assets_tb->asset_type->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->property_location->Visible) { // property_location ?>
		<tr id="r_property_location">
			<td><?php echo $assets_tb->property_location->FldCaption() ?></td>
			<td<?php echo $assets_tb->property_location->CellAttributes() ?>>
<span id="el_assets_tb_property_location" class="control-group">
<span<?php echo $assets_tb->property_location->ViewAttributes() ?>>
<?php echo $assets_tb->property_location->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->property_type->Visible) { // property_type ?>
		<tr id="r_property_type">
			<td><?php echo $assets_tb->property_type->FldCaption() ?></td>
			<td<?php echo $assets_tb->property_type->CellAttributes() ?>>
<span id="el_assets_tb_property_type" class="control-group">
<span<?php echo $assets_tb->property_type->ViewAttributes() ?>>
<?php echo $assets_tb->property_type->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
		<tr id="r_shares_company">
			<td><?php echo $assets_tb->shares_company->FldCaption() ?></td>
			<td<?php echo $assets_tb->shares_company->CellAttributes() ?>>
<span id="el_assets_tb_shares_company" class="control-group">
<span<?php echo $assets_tb->shares_company->ViewAttributes() ?>>
<?php echo $assets_tb->shares_company->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
		<tr id="r_insurance_company">
			<td><?php echo $assets_tb->insurance_company->FldCaption() ?></td>
			<td<?php echo $assets_tb->insurance_company->CellAttributes() ?>>
<span id="el_assets_tb_insurance_company" class="control-group">
<span<?php echo $assets_tb->insurance_company->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_company->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
		<tr id="r_insurance_type">
			<td><?php echo $assets_tb->insurance_type->FldCaption() ?></td>
			<td<?php echo $assets_tb->insurance_type->CellAttributes() ?>>
<span id="el_assets_tb_insurance_type" class="control-group">
<span<?php echo $assets_tb->insurance_type->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_type->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->account_name->Visible) { // account_name ?>
		<tr id="r_account_name">
			<td><?php echo $assets_tb->account_name->FldCaption() ?></td>
			<td<?php echo $assets_tb->account_name->CellAttributes() ?>>
<span id="el_assets_tb_account_name" class="control-group">
<span<?php echo $assets_tb->account_name->ViewAttributes() ?>>
<?php echo $assets_tb->account_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->bankname->Visible) { // bankname ?>
		<tr id="r_bankname">
			<td><?php echo $assets_tb->bankname->FldCaption() ?></td>
			<td<?php echo $assets_tb->bankname->CellAttributes() ?>>
<span id="el_assets_tb_bankname" class="control-group">
<span<?php echo $assets_tb->bankname->ViewAttributes() ?>>
<?php echo $assets_tb->bankname->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
		<tr id="r_pension_name">
			<td><?php echo $assets_tb->pension_name->FldCaption() ?></td>
			<td<?php echo $assets_tb->pension_name->CellAttributes() ?>>
<span id="el_assets_tb_pension_name" class="control-group">
<span<?php echo $assets_tb->pension_name->ViewAttributes() ?>>
<?php echo $assets_tb->pension_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
		<tr id="r_pension_owner">
			<td><?php echo $assets_tb->pension_owner->FldCaption() ?></td>
			<td<?php echo $assets_tb->pension_owner->CellAttributes() ?>>
<span id="el_assets_tb_pension_owner" class="control-group">
<span<?php echo $assets_tb->pension_owner->ViewAttributes() ?>>
<?php echo $assets_tb->pension_owner->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
		<tr id="r_datecreated">
			<td><?php echo $assets_tb->datecreated->FldCaption() ?></td>
			<td<?php echo $assets_tb->datecreated->CellAttributes() ?>>
<span id="el_assets_tb_datecreated" class="control-group">
<span<?php echo $assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $assets_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</td></tr></table>
<?php } ?>
