<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($assets_tb_grid)) $assets_tb_grid = new cassets_tb_grid();

// Page init
$assets_tb_grid->Page_Init();

// Page main
$assets_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$assets_tb_grid->Page_Render();
?>
<?php if ($assets_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var assets_tb_grid = new ew_Page("assets_tb_grid");
assets_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = assets_tb_grid.PageID; // For backward compatibility

// Form object
var fassets_tbgrid = new ew_Form("fassets_tbgrid");
fassets_tbgrid.FormKeyCountName = '<?php echo $assets_tb_grid->FormKeyCountName ?>';

// Validate form
fassets_tbgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fassets_tbgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "asset_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "property_location", false)) return false;
	if (ew_ValueChanged(fobj, infix, "property_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "shares_company", false)) return false;
	if (ew_ValueChanged(fobj, infix, "insurance_company", false)) return false;
	if (ew_ValueChanged(fobj, infix, "insurance_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "account_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bankname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pension_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pension_owner", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fassets_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fassets_tbgrid.ValidateRequired = true;
<?php } else { ?>
fassets_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($assets_tb->getCurrentMasterTable() == "" && $assets_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $assets_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($assets_tb->CurrentAction == "gridadd") {
	if ($assets_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$assets_tb_grid->TotalRecs = $assets_tb->SelectRecordCount();
			$assets_tb_grid->Recordset = $assets_tb_grid->LoadRecordset($assets_tb_grid->StartRec-1, $assets_tb_grid->DisplayRecs);
		} else {
			if ($assets_tb_grid->Recordset = $assets_tb_grid->LoadRecordset())
				$assets_tb_grid->TotalRecs = $assets_tb_grid->Recordset->RecordCount();
		}
		$assets_tb_grid->StartRec = 1;
		$assets_tb_grid->DisplayRecs = $assets_tb_grid->TotalRecs;
	} else {
		$assets_tb->CurrentFilter = "0=1";
		$assets_tb_grid->StartRec = 1;
		$assets_tb_grid->DisplayRecs = $assets_tb->GridAddRowCount;
	}
	$assets_tb_grid->TotalRecs = $assets_tb_grid->DisplayRecs;
	$assets_tb_grid->StopRec = $assets_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$assets_tb_grid->TotalRecs = $assets_tb->SelectRecordCount();
	} else {
		if ($assets_tb_grid->Recordset = $assets_tb_grid->LoadRecordset())
			$assets_tb_grid->TotalRecs = $assets_tb_grid->Recordset->RecordCount();
	}
	$assets_tb_grid->StartRec = 1;
	$assets_tb_grid->DisplayRecs = $assets_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$assets_tb_grid->Recordset = $assets_tb_grid->LoadRecordset($assets_tb_grid->StartRec-1, $assets_tb_grid->DisplayRecs);
}
$assets_tb_grid->RenderOtherOptions();
?>
<?php $assets_tb_grid->ShowPageHeader(); ?>
<?php
$assets_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fassets_tbgrid" class="ewForm form-horizontal">
<div id="gmp_assets_tb" class="ewGridMiddlePanel">
<table id="tbl_assets_tbgrid" class="ewTable ewTableSeparate">
<?php echo $assets_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$assets_tb_grid->RenderListOptions();

// Render list options (header, left)
$assets_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
	<?php if ($assets_tb->SortUrl($assets_tb->asset_type) == "") { ?>
		<td><div id="elh_assets_tb_asset_type" class="assets_tb_asset_type"><div class="ewTableHeaderCaption"><?php echo $assets_tb->asset_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_asset_type" class="assets_tb_asset_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->asset_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->asset_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->asset_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->property_location->Visible) { // property_location ?>
	<?php if ($assets_tb->SortUrl($assets_tb->property_location) == "") { ?>
		<td><div id="elh_assets_tb_property_location" class="assets_tb_property_location"><div class="ewTableHeaderCaption"><?php echo $assets_tb->property_location->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_property_location" class="assets_tb_property_location">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->property_location->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->property_location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->property_location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->property_type->Visible) { // property_type ?>
	<?php if ($assets_tb->SortUrl($assets_tb->property_type) == "") { ?>
		<td><div id="elh_assets_tb_property_type" class="assets_tb_property_type"><div class="ewTableHeaderCaption"><?php echo $assets_tb->property_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_property_type" class="assets_tb_property_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->property_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->property_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->property_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
	<?php if ($assets_tb->SortUrl($assets_tb->shares_company) == "") { ?>
		<td><div id="elh_assets_tb_shares_company" class="assets_tb_shares_company"><div class="ewTableHeaderCaption"><?php echo $assets_tb->shares_company->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_shares_company" class="assets_tb_shares_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->shares_company->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->shares_company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->shares_company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
	<?php if ($assets_tb->SortUrl($assets_tb->insurance_company) == "") { ?>
		<td><div id="elh_assets_tb_insurance_company" class="assets_tb_insurance_company"><div class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_company->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_insurance_company" class="assets_tb_insurance_company">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_company->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->insurance_company->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->insurance_company->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
	<?php if ($assets_tb->SortUrl($assets_tb->insurance_type) == "") { ?>
		<td><div id="elh_assets_tb_insurance_type" class="assets_tb_insurance_type"><div class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_insurance_type" class="assets_tb_insurance_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->insurance_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->insurance_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->insurance_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->account_name->Visible) { // account_name ?>
	<?php if ($assets_tb->SortUrl($assets_tb->account_name) == "") { ?>
		<td><div id="elh_assets_tb_account_name" class="assets_tb_account_name"><div class="ewTableHeaderCaption"><?php echo $assets_tb->account_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_account_name" class="assets_tb_account_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->account_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->account_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->account_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->bankname->Visible) { // bankname ?>
	<?php if ($assets_tb->SortUrl($assets_tb->bankname) == "") { ?>
		<td><div id="elh_assets_tb_bankname" class="assets_tb_bankname"><div class="ewTableHeaderCaption"><?php echo $assets_tb->bankname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_bankname" class="assets_tb_bankname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->bankname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->bankname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->bankname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
	<?php if ($assets_tb->SortUrl($assets_tb->pension_name) == "") { ?>
		<td><div id="elh_assets_tb_pension_name" class="assets_tb_pension_name"><div class="ewTableHeaderCaption"><?php echo $assets_tb->pension_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_pension_name" class="assets_tb_pension_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->pension_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->pension_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->pension_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
	<?php if ($assets_tb->SortUrl($assets_tb->pension_owner) == "") { ?>
		<td><div id="elh_assets_tb_pension_owner" class="assets_tb_pension_owner"><div class="ewTableHeaderCaption"><?php echo $assets_tb->pension_owner->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_pension_owner" class="assets_tb_pension_owner">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->pension_owner->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->pension_owner->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->pension_owner->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($assets_tb->SortUrl($assets_tb->datecreated) == "") { ?>
		<td><div id="elh_assets_tb_datecreated" class="assets_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $assets_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_assets_tb_datecreated" class="assets_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $assets_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($assets_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($assets_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$assets_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$assets_tb_grid->StartRec = 1;
$assets_tb_grid->StopRec = $assets_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($assets_tb_grid->FormKeyCountName) && ($assets_tb->CurrentAction == "gridadd" || $assets_tb->CurrentAction == "gridedit" || $assets_tb->CurrentAction == "F")) {
		$assets_tb_grid->KeyCount = $objForm->GetValue($assets_tb_grid->FormKeyCountName);
		$assets_tb_grid->StopRec = $assets_tb_grid->StartRec + $assets_tb_grid->KeyCount - 1;
	}
}
$assets_tb_grid->RecCnt = $assets_tb_grid->StartRec - 1;
if ($assets_tb_grid->Recordset && !$assets_tb_grid->Recordset->EOF) {
	$assets_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $assets_tb_grid->StartRec > 1)
		$assets_tb_grid->Recordset->Move($assets_tb_grid->StartRec - 1);
} elseif (!$assets_tb->AllowAddDeleteRow && $assets_tb_grid->StopRec == 0) {
	$assets_tb_grid->StopRec = $assets_tb->GridAddRowCount;
}

// Initialize aggregate
$assets_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$assets_tb->ResetAttrs();
$assets_tb_grid->RenderRow();
if ($assets_tb->CurrentAction == "gridadd")
	$assets_tb_grid->RowIndex = 0;
if ($assets_tb->CurrentAction == "gridedit")
	$assets_tb_grid->RowIndex = 0;
while ($assets_tb_grid->RecCnt < $assets_tb_grid->StopRec) {
	$assets_tb_grid->RecCnt++;
	if (intval($assets_tb_grid->RecCnt) >= intval($assets_tb_grid->StartRec)) {
		$assets_tb_grid->RowCnt++;
		if ($assets_tb->CurrentAction == "gridadd" || $assets_tb->CurrentAction == "gridedit" || $assets_tb->CurrentAction == "F") {
			$assets_tb_grid->RowIndex++;
			$objForm->Index = $assets_tb_grid->RowIndex;
			if ($objForm->HasValue($assets_tb_grid->FormActionName))
				$assets_tb_grid->RowAction = strval($objForm->GetValue($assets_tb_grid->FormActionName));
			elseif ($assets_tb->CurrentAction == "gridadd")
				$assets_tb_grid->RowAction = "insert";
			else
				$assets_tb_grid->RowAction = "";
		}

		// Set up key count
		$assets_tb_grid->KeyCount = $assets_tb_grid->RowIndex;

		// Init row class and style
		$assets_tb->ResetAttrs();
		$assets_tb->CssClass = "";
		if ($assets_tb->CurrentAction == "gridadd") {
			if ($assets_tb->CurrentMode == "copy") {
				$assets_tb_grid->LoadRowValues($assets_tb_grid->Recordset); // Load row values
				$assets_tb_grid->SetRecordKey($assets_tb_grid->RowOldKey, $assets_tb_grid->Recordset); // Set old record key
			} else {
				$assets_tb_grid->LoadDefaultValues(); // Load default values
				$assets_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$assets_tb_grid->LoadRowValues($assets_tb_grid->Recordset); // Load row values
		}
		$assets_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($assets_tb->CurrentAction == "gridadd") // Grid add
			$assets_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($assets_tb->CurrentAction == "gridadd" && $assets_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$assets_tb_grid->RestoreCurrentRowFormValues($assets_tb_grid->RowIndex); // Restore form values
		if ($assets_tb->CurrentAction == "gridedit") { // Grid edit
			if ($assets_tb->EventCancelled) {
				$assets_tb_grid->RestoreCurrentRowFormValues($assets_tb_grid->RowIndex); // Restore form values
			}
			if ($assets_tb_grid->RowAction == "insert")
				$assets_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$assets_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($assets_tb->CurrentAction == "gridedit" && ($assets_tb->RowType == EW_ROWTYPE_EDIT || $assets_tb->RowType == EW_ROWTYPE_ADD) && $assets_tb->EventCancelled) // Update failed
			$assets_tb_grid->RestoreCurrentRowFormValues($assets_tb_grid->RowIndex); // Restore form values
		if ($assets_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$assets_tb_grid->EditRowCnt++;
		if ($assets_tb->CurrentAction == "F") // Confirm row
			$assets_tb_grid->RestoreCurrentRowFormValues($assets_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$assets_tb->RowAttrs = array_merge($assets_tb->RowAttrs, array('data-rowindex'=>$assets_tb_grid->RowCnt, 'id'=>'r' . $assets_tb_grid->RowCnt . '_assets_tb', 'data-rowtype'=>$assets_tb->RowType));

		// Render row
		$assets_tb_grid->RenderRow();

		// Render list options
		$assets_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($assets_tb_grid->RowAction <> "delete" && $assets_tb_grid->RowAction <> "insertdelete" && !($assets_tb_grid->RowAction == "insert" && $assets_tb->CurrentAction == "F" && $assets_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $assets_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$assets_tb_grid->ListOptions->Render("body", "left", $assets_tb_grid->RowCnt);
?>
	<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
		<td<?php echo $assets_tb->asset_type->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_asset_type" class="control-group assets_tb_asset_type">
<textarea data-field="x_asset_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->asset_type->PlaceHolder ?>"<?php echo $assets_tb->asset_type->EditAttributes() ?>><?php echo $assets_tb->asset_type->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_asset_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($assets_tb->asset_type->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_asset_type" class="control-group assets_tb_asset_type">
<textarea data-field="x_asset_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->asset_type->PlaceHolder ?>"<?php echo $assets_tb->asset_type->EditAttributes() ?>><?php echo $assets_tb->asset_type->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $assets_tb->asset_type->ListViewValue() ?></span>
<input type="hidden" data-field="x_asset_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($assets_tb->asset_type->FormValue) ?>">
<input type="hidden" data-field="x_asset_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($assets_tb->asset_type->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $assets_tb_grid->RowIndex ?>_id" id="x<?php echo $assets_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($assets_tb->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $assets_tb_grid->RowIndex ?>_id" id="o<?php echo $assets_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($assets_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT || $assets_tb->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $assets_tb_grid->RowIndex ?>_id" id="x<?php echo $assets_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($assets_tb->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($assets_tb->property_location->Visible) { // property_location ?>
		<td<?php echo $assets_tb->property_location->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_property_location" class="control-group assets_tb_property_location">
<textarea data-field="x_property_location" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_location->PlaceHolder ?>"<?php echo $assets_tb->property_location->EditAttributes() ?>><?php echo $assets_tb->property_location->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_property_location" name="o<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="o<?php echo $assets_tb_grid->RowIndex ?>_property_location" value="<?php echo ew_HtmlEncode($assets_tb->property_location->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_property_location" class="control-group assets_tb_property_location">
<textarea data-field="x_property_location" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_location->PlaceHolder ?>"<?php echo $assets_tb->property_location->EditAttributes() ?>><?php echo $assets_tb->property_location->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->property_location->ViewAttributes() ?>>
<?php echo $assets_tb->property_location->ListViewValue() ?></span>
<input type="hidden" data-field="x_property_location" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" value="<?php echo ew_HtmlEncode($assets_tb->property_location->FormValue) ?>">
<input type="hidden" data-field="x_property_location" name="o<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="o<?php echo $assets_tb_grid->RowIndex ?>_property_location" value="<?php echo ew_HtmlEncode($assets_tb->property_location->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->property_type->Visible) { // property_type ?>
		<td<?php echo $assets_tb->property_type->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_property_type" class="control-group assets_tb_property_type">
<textarea data-field="x_property_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_type->PlaceHolder ?>"<?php echo $assets_tb->property_type->EditAttributes() ?>><?php echo $assets_tb->property_type->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_property_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($assets_tb->property_type->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_property_type" class="control-group assets_tb_property_type">
<textarea data-field="x_property_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_type->PlaceHolder ?>"<?php echo $assets_tb->property_type->EditAttributes() ?>><?php echo $assets_tb->property_type->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->property_type->ViewAttributes() ?>>
<?php echo $assets_tb->property_type->ListViewValue() ?></span>
<input type="hidden" data-field="x_property_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($assets_tb->property_type->FormValue) ?>">
<input type="hidden" data-field="x_property_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($assets_tb->property_type->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
		<td<?php echo $assets_tb->shares_company->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_shares_company" class="control-group assets_tb_shares_company">
<textarea data-field="x_shares_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_company->PlaceHolder ?>"<?php echo $assets_tb->shares_company->EditAttributes() ?>><?php echo $assets_tb->shares_company->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_shares_company" name="o<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="o<?php echo $assets_tb_grid->RowIndex ?>_shares_company" value="<?php echo ew_HtmlEncode($assets_tb->shares_company->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_shares_company" class="control-group assets_tb_shares_company">
<textarea data-field="x_shares_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_company->PlaceHolder ?>"<?php echo $assets_tb->shares_company->EditAttributes() ?>><?php echo $assets_tb->shares_company->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->shares_company->ViewAttributes() ?>>
<?php echo $assets_tb->shares_company->ListViewValue() ?></span>
<input type="hidden" data-field="x_shares_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" value="<?php echo ew_HtmlEncode($assets_tb->shares_company->FormValue) ?>">
<input type="hidden" data-field="x_shares_company" name="o<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="o<?php echo $assets_tb_grid->RowIndex ?>_shares_company" value="<?php echo ew_HtmlEncode($assets_tb->shares_company->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
		<td<?php echo $assets_tb->insurance_company->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_insurance_company" class="control-group assets_tb_insurance_company">
<textarea data-field="x_insurance_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_company->PlaceHolder ?>"<?php echo $assets_tb->insurance_company->EditAttributes() ?>><?php echo $assets_tb->insurance_company->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_insurance_company" name="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" value="<?php echo ew_HtmlEncode($assets_tb->insurance_company->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_insurance_company" class="control-group assets_tb_insurance_company">
<textarea data-field="x_insurance_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_company->PlaceHolder ?>"<?php echo $assets_tb->insurance_company->EditAttributes() ?>><?php echo $assets_tb->insurance_company->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->insurance_company->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_company->ListViewValue() ?></span>
<input type="hidden" data-field="x_insurance_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" value="<?php echo ew_HtmlEncode($assets_tb->insurance_company->FormValue) ?>">
<input type="hidden" data-field="x_insurance_company" name="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" value="<?php echo ew_HtmlEncode($assets_tb->insurance_company->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
		<td<?php echo $assets_tb->insurance_type->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_insurance_type" class="control-group assets_tb_insurance_type">
<textarea data-field="x_insurance_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_type->PlaceHolder ?>"<?php echo $assets_tb->insurance_type->EditAttributes() ?>><?php echo $assets_tb->insurance_type->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_insurance_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" value="<?php echo ew_HtmlEncode($assets_tb->insurance_type->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_insurance_type" class="control-group assets_tb_insurance_type">
<textarea data-field="x_insurance_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_type->PlaceHolder ?>"<?php echo $assets_tb->insurance_type->EditAttributes() ?>><?php echo $assets_tb->insurance_type->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->insurance_type->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_type->ListViewValue() ?></span>
<input type="hidden" data-field="x_insurance_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" value="<?php echo ew_HtmlEncode($assets_tb->insurance_type->FormValue) ?>">
<input type="hidden" data-field="x_insurance_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" value="<?php echo ew_HtmlEncode($assets_tb->insurance_type->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->account_name->Visible) { // account_name ?>
		<td<?php echo $assets_tb->account_name->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_account_name" class="control-group assets_tb_account_name">
<textarea data-field="x_account_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->account_name->PlaceHolder ?>"<?php echo $assets_tb->account_name->EditAttributes() ?>><?php echo $assets_tb->account_name->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_account_name" name="o<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="o<?php echo $assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($assets_tb->account_name->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_account_name" class="control-group assets_tb_account_name">
<textarea data-field="x_account_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->account_name->PlaceHolder ?>"<?php echo $assets_tb->account_name->EditAttributes() ?>><?php echo $assets_tb->account_name->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->account_name->ViewAttributes() ?>>
<?php echo $assets_tb->account_name->ListViewValue() ?></span>
<input type="hidden" data-field="x_account_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($assets_tb->account_name->FormValue) ?>">
<input type="hidden" data-field="x_account_name" name="o<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="o<?php echo $assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($assets_tb->account_name->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->bankname->Visible) { // bankname ?>
		<td<?php echo $assets_tb->bankname->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_bankname" class="control-group assets_tb_bankname">
<textarea data-field="x_bankname" name="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" cols="35" rows="4" placeholder="<?php echo $assets_tb->bankname->PlaceHolder ?>"<?php echo $assets_tb->bankname->EditAttributes() ?>><?php echo $assets_tb->bankname->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_bankname" name="o<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="o<?php echo $assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($assets_tb->bankname->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_bankname" class="control-group assets_tb_bankname">
<textarea data-field="x_bankname" name="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" cols="35" rows="4" placeholder="<?php echo $assets_tb->bankname->PlaceHolder ?>"<?php echo $assets_tb->bankname->EditAttributes() ?>><?php echo $assets_tb->bankname->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->bankname->ViewAttributes() ?>>
<?php echo $assets_tb->bankname->ListViewValue() ?></span>
<input type="hidden" data-field="x_bankname" name="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($assets_tb->bankname->FormValue) ?>">
<input type="hidden" data-field="x_bankname" name="o<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="o<?php echo $assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($assets_tb->bankname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
		<td<?php echo $assets_tb->pension_name->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_pension_name" class="control-group assets_tb_pension_name">
<textarea data-field="x_pension_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_name->PlaceHolder ?>"<?php echo $assets_tb->pension_name->EditAttributes() ?>><?php echo $assets_tb->pension_name->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_pension_name" name="o<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="o<?php echo $assets_tb_grid->RowIndex ?>_pension_name" value="<?php echo ew_HtmlEncode($assets_tb->pension_name->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_pension_name" class="control-group assets_tb_pension_name">
<textarea data-field="x_pension_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_name->PlaceHolder ?>"<?php echo $assets_tb->pension_name->EditAttributes() ?>><?php echo $assets_tb->pension_name->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->pension_name->ViewAttributes() ?>>
<?php echo $assets_tb->pension_name->ListViewValue() ?></span>
<input type="hidden" data-field="x_pension_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" value="<?php echo ew_HtmlEncode($assets_tb->pension_name->FormValue) ?>">
<input type="hidden" data-field="x_pension_name" name="o<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="o<?php echo $assets_tb_grid->RowIndex ?>_pension_name" value="<?php echo ew_HtmlEncode($assets_tb->pension_name->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
		<td<?php echo $assets_tb->pension_owner->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_pension_owner" class="control-group assets_tb_pension_owner">
<textarea data-field="x_pension_owner" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_owner->PlaceHolder ?>"<?php echo $assets_tb->pension_owner->EditAttributes() ?>><?php echo $assets_tb->pension_owner->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_pension_owner" name="o<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="o<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" value="<?php echo ew_HtmlEncode($assets_tb->pension_owner->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_pension_owner" class="control-group assets_tb_pension_owner">
<textarea data-field="x_pension_owner" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_owner->PlaceHolder ?>"<?php echo $assets_tb->pension_owner->EditAttributes() ?>><?php echo $assets_tb->pension_owner->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->pension_owner->ViewAttributes() ?>>
<?php echo $assets_tb->pension_owner->ListViewValue() ?></span>
<input type="hidden" data-field="x_pension_owner" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" value="<?php echo ew_HtmlEncode($assets_tb->pension_owner->FormValue) ?>">
<input type="hidden" data-field="x_pension_owner" name="o<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="o<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" value="<?php echo ew_HtmlEncode($assets_tb->pension_owner->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $assets_tb->datecreated->CellAttributes() ?>>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_datecreated" class="control-group assets_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $assets_tb->datecreated->EditValue ?>"<?php echo $assets_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($assets_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $assets_tb_grid->RowCnt ?>_assets_tb_datecreated" class="control-group assets_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $assets_tb->datecreated->EditValue ?>"<?php echo $assets_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $assets_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($assets_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($assets_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $assets_tb_grid->PageObjName . "_row_" . $assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$assets_tb_grid->ListOptions->Render("body", "right", $assets_tb_grid->RowCnt);
?>
	</tr>
<?php if ($assets_tb->RowType == EW_ROWTYPE_ADD || $assets_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fassets_tbgrid.UpdateOpts(<?php echo $assets_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($assets_tb->CurrentAction <> "gridadd" || $assets_tb->CurrentMode == "copy")
		if (!$assets_tb_grid->Recordset->EOF) $assets_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($assets_tb->CurrentMode == "add" || $assets_tb->CurrentMode == "copy" || $assets_tb->CurrentMode == "edit") {
		$assets_tb_grid->RowIndex = '$rowindex$';
		$assets_tb_grid->LoadDefaultValues();

		// Set row properties
		$assets_tb->ResetAttrs();
		$assets_tb->RowAttrs = array_merge($assets_tb->RowAttrs, array('data-rowindex'=>$assets_tb_grid->RowIndex, 'id'=>'r0_assets_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($assets_tb->RowAttrs["class"], "ewTemplate");
		$assets_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$assets_tb_grid->RenderRow();

		// Render list options
		$assets_tb_grid->RenderListOptions();
		$assets_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $assets_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$assets_tb_grid->ListOptions->Render("body", "left", $assets_tb_grid->RowIndex);
?>
	<?php if ($assets_tb->asset_type->Visible) { // asset_type ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_asset_type" class="control-group assets_tb_asset_type">
<textarea data-field="x_asset_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->asset_type->PlaceHolder ?>"<?php echo $assets_tb->asset_type->EditAttributes() ?>><?php echo $assets_tb->asset_type->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_asset_type" class="control-group assets_tb_asset_type">
<span<?php echo $assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $assets_tb->asset_type->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_asset_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($assets_tb->asset_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_asset_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_asset_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($assets_tb->asset_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->property_location->Visible) { // property_location ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_property_location" class="control-group assets_tb_property_location">
<textarea data-field="x_property_location" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_location->PlaceHolder ?>"<?php echo $assets_tb->property_location->EditAttributes() ?>><?php echo $assets_tb->property_location->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_property_location" class="control-group assets_tb_property_location">
<span<?php echo $assets_tb->property_location->ViewAttributes() ?>>
<?php echo $assets_tb->property_location->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_property_location" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_location" value="<?php echo ew_HtmlEncode($assets_tb->property_location->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_property_location" name="o<?php echo $assets_tb_grid->RowIndex ?>_property_location" id="o<?php echo $assets_tb_grid->RowIndex ?>_property_location" value="<?php echo ew_HtmlEncode($assets_tb->property_location->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->property_type->Visible) { // property_type ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_property_type" class="control-group assets_tb_property_type">
<textarea data-field="x_property_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->property_type->PlaceHolder ?>"<?php echo $assets_tb->property_type->EditAttributes() ?>><?php echo $assets_tb->property_type->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_property_type" class="control-group assets_tb_property_type">
<span<?php echo $assets_tb->property_type->ViewAttributes() ?>>
<?php echo $assets_tb->property_type->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_property_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($assets_tb->property_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_property_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_property_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($assets_tb->property_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->shares_company->Visible) { // shares_company ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_shares_company" class="control-group assets_tb_shares_company">
<textarea data-field="x_shares_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->shares_company->PlaceHolder ?>"<?php echo $assets_tb->shares_company->EditAttributes() ?>><?php echo $assets_tb->shares_company->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_shares_company" class="control-group assets_tb_shares_company">
<span<?php echo $assets_tb->shares_company->ViewAttributes() ?>>
<?php echo $assets_tb->shares_company->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_shares_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_shares_company" value="<?php echo ew_HtmlEncode($assets_tb->shares_company->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_shares_company" name="o<?php echo $assets_tb_grid->RowIndex ?>_shares_company" id="o<?php echo $assets_tb_grid->RowIndex ?>_shares_company" value="<?php echo ew_HtmlEncode($assets_tb->shares_company->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->insurance_company->Visible) { // insurance_company ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_insurance_company" class="control-group assets_tb_insurance_company">
<textarea data-field="x_insurance_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_company->PlaceHolder ?>"<?php echo $assets_tb->insurance_company->EditAttributes() ?>><?php echo $assets_tb->insurance_company->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_insurance_company" class="control-group assets_tb_insurance_company">
<span<?php echo $assets_tb->insurance_company->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_company->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_insurance_company" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" value="<?php echo ew_HtmlEncode($assets_tb->insurance_company->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_insurance_company" name="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" id="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_company" value="<?php echo ew_HtmlEncode($assets_tb->insurance_company->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->insurance_type->Visible) { // insurance_type ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_insurance_type" class="control-group assets_tb_insurance_type">
<textarea data-field="x_insurance_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" cols="35" rows="4" placeholder="<?php echo $assets_tb->insurance_type->PlaceHolder ?>"<?php echo $assets_tb->insurance_type->EditAttributes() ?>><?php echo $assets_tb->insurance_type->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_insurance_type" class="control-group assets_tb_insurance_type">
<span<?php echo $assets_tb->insurance_type->ViewAttributes() ?>>
<?php echo $assets_tb->insurance_type->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_insurance_type" name="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="x<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" value="<?php echo ew_HtmlEncode($assets_tb->insurance_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_insurance_type" name="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" id="o<?php echo $assets_tb_grid->RowIndex ?>_insurance_type" value="<?php echo ew_HtmlEncode($assets_tb->insurance_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->account_name->Visible) { // account_name ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_account_name" class="control-group assets_tb_account_name">
<textarea data-field="x_account_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->account_name->PlaceHolder ?>"<?php echo $assets_tb->account_name->EditAttributes() ?>><?php echo $assets_tb->account_name->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_account_name" class="control-group assets_tb_account_name">
<span<?php echo $assets_tb->account_name->ViewAttributes() ?>>
<?php echo $assets_tb->account_name->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_account_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($assets_tb->account_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_account_name" name="o<?php echo $assets_tb_grid->RowIndex ?>_account_name" id="o<?php echo $assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($assets_tb->account_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->bankname->Visible) { // bankname ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_bankname" class="control-group assets_tb_bankname">
<textarea data-field="x_bankname" name="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" cols="35" rows="4" placeholder="<?php echo $assets_tb->bankname->PlaceHolder ?>"<?php echo $assets_tb->bankname->EditAttributes() ?>><?php echo $assets_tb->bankname->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_bankname" class="control-group assets_tb_bankname">
<span<?php echo $assets_tb->bankname->ViewAttributes() ?>>
<?php echo $assets_tb->bankname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_bankname" name="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($assets_tb->bankname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_bankname" name="o<?php echo $assets_tb_grid->RowIndex ?>_bankname" id="o<?php echo $assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($assets_tb->bankname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->pension_name->Visible) { // pension_name ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_pension_name" class="control-group assets_tb_pension_name">
<textarea data-field="x_pension_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_name->PlaceHolder ?>"<?php echo $assets_tb->pension_name->EditAttributes() ?>><?php echo $assets_tb->pension_name->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_pension_name" class="control-group assets_tb_pension_name">
<span<?php echo $assets_tb->pension_name->ViewAttributes() ?>>
<?php echo $assets_tb->pension_name->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_pension_name" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_name" value="<?php echo ew_HtmlEncode($assets_tb->pension_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_pension_name" name="o<?php echo $assets_tb_grid->RowIndex ?>_pension_name" id="o<?php echo $assets_tb_grid->RowIndex ?>_pension_name" value="<?php echo ew_HtmlEncode($assets_tb->pension_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->pension_owner->Visible) { // pension_owner ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_pension_owner" class="control-group assets_tb_pension_owner">
<textarea data-field="x_pension_owner" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" cols="35" rows="4" placeholder="<?php echo $assets_tb->pension_owner->PlaceHolder ?>"<?php echo $assets_tb->pension_owner->EditAttributes() ?>><?php echo $assets_tb->pension_owner->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_pension_owner" class="control-group assets_tb_pension_owner">
<span<?php echo $assets_tb->pension_owner->ViewAttributes() ?>>
<?php echo $assets_tb->pension_owner->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_pension_owner" name="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="x<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" value="<?php echo ew_HtmlEncode($assets_tb->pension_owner->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_pension_owner" name="o<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" id="o<?php echo $assets_tb_grid->RowIndex ?>_pension_owner" value="<?php echo ew_HtmlEncode($assets_tb->pension_owner->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($assets_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_assets_tb_datecreated" class="control-group assets_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $assets_tb->datecreated->EditValue ?>"<?php echo $assets_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_assets_tb_datecreated" class="control-group assets_tb_datecreated">
<span<?php echo $assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $assets_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($assets_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $assets_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($assets_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$assets_tb_grid->ListOptions->Render("body", "right", $assets_tb_grid->RowCnt);
?>
<script type="text/javascript">
fassets_tbgrid.UpdateOpts(<?php echo $assets_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($assets_tb->CurrentMode == "add" || $assets_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $assets_tb_grid->FormKeyCountName ?>" id="<?php echo $assets_tb_grid->FormKeyCountName ?>" value="<?php echo $assets_tb_grid->KeyCount ?>">
<?php echo $assets_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($assets_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $assets_tb_grid->FormKeyCountName ?>" id="<?php echo $assets_tb_grid->FormKeyCountName ?>" value="<?php echo $assets_tb_grid->KeyCount ?>">
<?php echo $assets_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($assets_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fassets_tbgrid">
</div>
<?php

// Close recordset
if ($assets_tb_grid->Recordset)
	$assets_tb_grid->Recordset->Close();
?>
<?php if ($assets_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($assets_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($assets_tb->Export == "") { ?>
<script type="text/javascript">
fassets_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$assets_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$assets_tb_grid->Page_Terminate();
?>
