<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($simplewill_assets_tb_grid)) $simplewill_assets_tb_grid = new csimplewill_assets_tb_grid();

// Page init
$simplewill_assets_tb_grid->Page_Init();

// Page main
$simplewill_assets_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$simplewill_assets_tb_grid->Page_Render();
?>
<?php if ($simplewill_assets_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var simplewill_assets_tb_grid = new ew_Page("simplewill_assets_tb_grid");
simplewill_assets_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = simplewill_assets_tb_grid.PageID; // For backward compatibility

// Form object
var fsimplewill_assets_tbgrid = new ew_Form("fsimplewill_assets_tbgrid");
fsimplewill_assets_tbgrid.FormKeyCountName = '<?php echo $simplewill_assets_tb_grid->FormKeyCountName ?>';

// Validate form
fsimplewill_assets_tbgrid.Validate = function() {
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
fsimplewill_assets_tbgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "asset_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "account_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bankname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pension_admin", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fsimplewill_assets_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsimplewill_assets_tbgrid.ValidateRequired = true;
<?php } else { ?>
fsimplewill_assets_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($simplewill_assets_tb->getCurrentMasterTable() == "" && $simplewill_assets_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $simplewill_assets_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($simplewill_assets_tb->CurrentAction == "gridadd") {
	if ($simplewill_assets_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$simplewill_assets_tb_grid->TotalRecs = $simplewill_assets_tb->SelectRecordCount();
			$simplewill_assets_tb_grid->Recordset = $simplewill_assets_tb_grid->LoadRecordset($simplewill_assets_tb_grid->StartRec-1, $simplewill_assets_tb_grid->DisplayRecs);
		} else {
			if ($simplewill_assets_tb_grid->Recordset = $simplewill_assets_tb_grid->LoadRecordset())
				$simplewill_assets_tb_grid->TotalRecs = $simplewill_assets_tb_grid->Recordset->RecordCount();
		}
		$simplewill_assets_tb_grid->StartRec = 1;
		$simplewill_assets_tb_grid->DisplayRecs = $simplewill_assets_tb_grid->TotalRecs;
	} else {
		$simplewill_assets_tb->CurrentFilter = "0=1";
		$simplewill_assets_tb_grid->StartRec = 1;
		$simplewill_assets_tb_grid->DisplayRecs = $simplewill_assets_tb->GridAddRowCount;
	}
	$simplewill_assets_tb_grid->TotalRecs = $simplewill_assets_tb_grid->DisplayRecs;
	$simplewill_assets_tb_grid->StopRec = $simplewill_assets_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$simplewill_assets_tb_grid->TotalRecs = $simplewill_assets_tb->SelectRecordCount();
	} else {
		if ($simplewill_assets_tb_grid->Recordset = $simplewill_assets_tb_grid->LoadRecordset())
			$simplewill_assets_tb_grid->TotalRecs = $simplewill_assets_tb_grid->Recordset->RecordCount();
	}
	$simplewill_assets_tb_grid->StartRec = 1;
	$simplewill_assets_tb_grid->DisplayRecs = $simplewill_assets_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$simplewill_assets_tb_grid->Recordset = $simplewill_assets_tb_grid->LoadRecordset($simplewill_assets_tb_grid->StartRec-1, $simplewill_assets_tb_grid->DisplayRecs);
}
$simplewill_assets_tb_grid->RenderOtherOptions();
?>
<?php $simplewill_assets_tb_grid->ShowPageHeader(); ?>
<?php
$simplewill_assets_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fsimplewill_assets_tbgrid" class="ewForm form-horizontal">
<div id="gmp_simplewill_assets_tb" class="ewGridMiddlePanel">
<table id="tbl_simplewill_assets_tbgrid" class="ewTable ewTableSeparate">
<?php echo $simplewill_assets_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$simplewill_assets_tb_grid->RenderListOptions();

// Render list options (header, left)
$simplewill_assets_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($simplewill_assets_tb->asset_type->Visible) { // asset_type ?>
	<?php if ($simplewill_assets_tb->SortUrl($simplewill_assets_tb->asset_type) == "") { ?>
		<td><div id="elh_simplewill_assets_tb_asset_type" class="simplewill_assets_tb_asset_type"><div class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->asset_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_assets_tb_asset_type" class="simplewill_assets_tb_asset_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->asset_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_assets_tb->asset_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_assets_tb->asset_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_assets_tb->account_name->Visible) { // account_name ?>
	<?php if ($simplewill_assets_tb->SortUrl($simplewill_assets_tb->account_name) == "") { ?>
		<td><div id="elh_simplewill_assets_tb_account_name" class="simplewill_assets_tb_account_name"><div class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->account_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_assets_tb_account_name" class="simplewill_assets_tb_account_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->account_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_assets_tb->account_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_assets_tb->account_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_assets_tb->bankname->Visible) { // bankname ?>
	<?php if ($simplewill_assets_tb->SortUrl($simplewill_assets_tb->bankname) == "") { ?>
		<td><div id="elh_simplewill_assets_tb_bankname" class="simplewill_assets_tb_bankname"><div class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->bankname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_assets_tb_bankname" class="simplewill_assets_tb_bankname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->bankname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_assets_tb->bankname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_assets_tb->bankname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_assets_tb->pension_admin->Visible) { // pension_admin ?>
	<?php if ($simplewill_assets_tb->SortUrl($simplewill_assets_tb->pension_admin) == "") { ?>
		<td><div id="elh_simplewill_assets_tb_pension_admin" class="simplewill_assets_tb_pension_admin"><div class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->pension_admin->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_assets_tb_pension_admin" class="simplewill_assets_tb_pension_admin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->pension_admin->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_assets_tb->pension_admin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_assets_tb->pension_admin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_assets_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($simplewill_assets_tb->SortUrl($simplewill_assets_tb->datecreated) == "") { ?>
		<td><div id="elh_simplewill_assets_tb_datecreated" class="simplewill_assets_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_assets_tb_datecreated" class="simplewill_assets_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_assets_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_assets_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_assets_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$simplewill_assets_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$simplewill_assets_tb_grid->StartRec = 1;
$simplewill_assets_tb_grid->StopRec = $simplewill_assets_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($simplewill_assets_tb_grid->FormKeyCountName) && ($simplewill_assets_tb->CurrentAction == "gridadd" || $simplewill_assets_tb->CurrentAction == "gridedit" || $simplewill_assets_tb->CurrentAction == "F")) {
		$simplewill_assets_tb_grid->KeyCount = $objForm->GetValue($simplewill_assets_tb_grid->FormKeyCountName);
		$simplewill_assets_tb_grid->StopRec = $simplewill_assets_tb_grid->StartRec + $simplewill_assets_tb_grid->KeyCount - 1;
	}
}
$simplewill_assets_tb_grid->RecCnt = $simplewill_assets_tb_grid->StartRec - 1;
if ($simplewill_assets_tb_grid->Recordset && !$simplewill_assets_tb_grid->Recordset->EOF) {
	$simplewill_assets_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $simplewill_assets_tb_grid->StartRec > 1)
		$simplewill_assets_tb_grid->Recordset->Move($simplewill_assets_tb_grid->StartRec - 1);
} elseif (!$simplewill_assets_tb->AllowAddDeleteRow && $simplewill_assets_tb_grid->StopRec == 0) {
	$simplewill_assets_tb_grid->StopRec = $simplewill_assets_tb->GridAddRowCount;
}

// Initialize aggregate
$simplewill_assets_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$simplewill_assets_tb->ResetAttrs();
$simplewill_assets_tb_grid->RenderRow();
if ($simplewill_assets_tb->CurrentAction == "gridadd")
	$simplewill_assets_tb_grid->RowIndex = 0;
if ($simplewill_assets_tb->CurrentAction == "gridedit")
	$simplewill_assets_tb_grid->RowIndex = 0;
while ($simplewill_assets_tb_grid->RecCnt < $simplewill_assets_tb_grid->StopRec) {
	$simplewill_assets_tb_grid->RecCnt++;
	if (intval($simplewill_assets_tb_grid->RecCnt) >= intval($simplewill_assets_tb_grid->StartRec)) {
		$simplewill_assets_tb_grid->RowCnt++;
		if ($simplewill_assets_tb->CurrentAction == "gridadd" || $simplewill_assets_tb->CurrentAction == "gridedit" || $simplewill_assets_tb->CurrentAction == "F") {
			$simplewill_assets_tb_grid->RowIndex++;
			$objForm->Index = $simplewill_assets_tb_grid->RowIndex;
			if ($objForm->HasValue($simplewill_assets_tb_grid->FormActionName))
				$simplewill_assets_tb_grid->RowAction = strval($objForm->GetValue($simplewill_assets_tb_grid->FormActionName));
			elseif ($simplewill_assets_tb->CurrentAction == "gridadd")
				$simplewill_assets_tb_grid->RowAction = "insert";
			else
				$simplewill_assets_tb_grid->RowAction = "";
		}

		// Set up key count
		$simplewill_assets_tb_grid->KeyCount = $simplewill_assets_tb_grid->RowIndex;

		// Init row class and style
		$simplewill_assets_tb->ResetAttrs();
		$simplewill_assets_tb->CssClass = "";
		if ($simplewill_assets_tb->CurrentAction == "gridadd") {
			if ($simplewill_assets_tb->CurrentMode == "copy") {
				$simplewill_assets_tb_grid->LoadRowValues($simplewill_assets_tb_grid->Recordset); // Load row values
				$simplewill_assets_tb_grid->SetRecordKey($simplewill_assets_tb_grid->RowOldKey, $simplewill_assets_tb_grid->Recordset); // Set old record key
			} else {
				$simplewill_assets_tb_grid->LoadDefaultValues(); // Load default values
				$simplewill_assets_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$simplewill_assets_tb_grid->LoadRowValues($simplewill_assets_tb_grid->Recordset); // Load row values
		}
		$simplewill_assets_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($simplewill_assets_tb->CurrentAction == "gridadd") // Grid add
			$simplewill_assets_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($simplewill_assets_tb->CurrentAction == "gridadd" && $simplewill_assets_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$simplewill_assets_tb_grid->RestoreCurrentRowFormValues($simplewill_assets_tb_grid->RowIndex); // Restore form values
		if ($simplewill_assets_tb->CurrentAction == "gridedit") { // Grid edit
			if ($simplewill_assets_tb->EventCancelled) {
				$simplewill_assets_tb_grid->RestoreCurrentRowFormValues($simplewill_assets_tb_grid->RowIndex); // Restore form values
			}
			if ($simplewill_assets_tb_grid->RowAction == "insert")
				$simplewill_assets_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$simplewill_assets_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($simplewill_assets_tb->CurrentAction == "gridedit" && ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT || $simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) && $simplewill_assets_tb->EventCancelled) // Update failed
			$simplewill_assets_tb_grid->RestoreCurrentRowFormValues($simplewill_assets_tb_grid->RowIndex); // Restore form values
		if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$simplewill_assets_tb_grid->EditRowCnt++;
		if ($simplewill_assets_tb->CurrentAction == "F") // Confirm row
			$simplewill_assets_tb_grid->RestoreCurrentRowFormValues($simplewill_assets_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$simplewill_assets_tb->RowAttrs = array_merge($simplewill_assets_tb->RowAttrs, array('data-rowindex'=>$simplewill_assets_tb_grid->RowCnt, 'id'=>'r' . $simplewill_assets_tb_grid->RowCnt . '_simplewill_assets_tb', 'data-rowtype'=>$simplewill_assets_tb->RowType));

		// Render row
		$simplewill_assets_tb_grid->RenderRow();

		// Render list options
		$simplewill_assets_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($simplewill_assets_tb_grid->RowAction <> "delete" && $simplewill_assets_tb_grid->RowAction <> "insertdelete" && !($simplewill_assets_tb_grid->RowAction == "insert" && $simplewill_assets_tb->CurrentAction == "F" && $simplewill_assets_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $simplewill_assets_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$simplewill_assets_tb_grid->ListOptions->Render("body", "left", $simplewill_assets_tb_grid->RowCnt);
?>
	<?php if ($simplewill_assets_tb->asset_type->Visible) { // asset_type ?>
		<td<?php echo $simplewill_assets_tb->asset_type->CellAttributes() ?>>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_asset_type" class="control-group simplewill_assets_tb_asset_type">
<textarea data-field="x_asset_type" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->asset_type->PlaceHolder ?>"<?php echo $simplewill_assets_tb->asset_type->EditAttributes() ?>><?php echo $simplewill_assets_tb->asset_type->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_asset_type" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->asset_type->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_asset_type" class="control-group simplewill_assets_tb_asset_type">
<textarea data-field="x_asset_type" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->asset_type->PlaceHolder ?>"<?php echo $simplewill_assets_tb->asset_type->EditAttributes() ?>><?php echo $simplewill_assets_tb->asset_type->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->asset_type->ListViewValue() ?></span>
<input type="hidden" data-field="x_asset_type" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->asset_type->FormValue) ?>">
<input type="hidden" data-field="x_asset_type" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->asset_type->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_assets_tb_grid->PageObjName . "_row_" . $simplewill_assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_id" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_id" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT || $simplewill_assets_tb->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_id" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($simplewill_assets_tb->account_name->Visible) { // account_name ?>
		<td<?php echo $simplewill_assets_tb->account_name->CellAttributes() ?>>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_account_name" class="control-group simplewill_assets_tb_account_name">
<textarea data-field="x_account_name" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->account_name->PlaceHolder ?>"<?php echo $simplewill_assets_tb->account_name->EditAttributes() ?>><?php echo $simplewill_assets_tb->account_name->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_account_name" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->account_name->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_account_name" class="control-group simplewill_assets_tb_account_name">
<textarea data-field="x_account_name" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->account_name->PlaceHolder ?>"<?php echo $simplewill_assets_tb->account_name->EditAttributes() ?>><?php echo $simplewill_assets_tb->account_name->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_assets_tb->account_name->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->account_name->ListViewValue() ?></span>
<input type="hidden" data-field="x_account_name" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->account_name->FormValue) ?>">
<input type="hidden" data-field="x_account_name" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->account_name->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_assets_tb_grid->PageObjName . "_row_" . $simplewill_assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->bankname->Visible) { // bankname ?>
		<td<?php echo $simplewill_assets_tb->bankname->CellAttributes() ?>>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_bankname" class="control-group simplewill_assets_tb_bankname">
<textarea data-field="x_bankname" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->bankname->PlaceHolder ?>"<?php echo $simplewill_assets_tb->bankname->EditAttributes() ?>><?php echo $simplewill_assets_tb->bankname->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_bankname" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->bankname->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_bankname" class="control-group simplewill_assets_tb_bankname">
<textarea data-field="x_bankname" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->bankname->PlaceHolder ?>"<?php echo $simplewill_assets_tb->bankname->EditAttributes() ?>><?php echo $simplewill_assets_tb->bankname->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_assets_tb->bankname->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->bankname->ListViewValue() ?></span>
<input type="hidden" data-field="x_bankname" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->bankname->FormValue) ?>">
<input type="hidden" data-field="x_bankname" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->bankname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_assets_tb_grid->PageObjName . "_row_" . $simplewill_assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->pension_admin->Visible) { // pension_admin ?>
		<td<?php echo $simplewill_assets_tb->pension_admin->CellAttributes() ?>>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_pension_admin" class="control-group simplewill_assets_tb_pension_admin">
<textarea data-field="x_pension_admin" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->pension_admin->PlaceHolder ?>"<?php echo $simplewill_assets_tb->pension_admin->EditAttributes() ?>><?php echo $simplewill_assets_tb->pension_admin->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_pension_admin" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->pension_admin->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_pension_admin" class="control-group simplewill_assets_tb_pension_admin">
<textarea data-field="x_pension_admin" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->pension_admin->PlaceHolder ?>"<?php echo $simplewill_assets_tb->pension_admin->EditAttributes() ?>><?php echo $simplewill_assets_tb->pension_admin->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_assets_tb->pension_admin->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->pension_admin->ListViewValue() ?></span>
<input type="hidden" data-field="x_pension_admin" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->pension_admin->FormValue) ?>">
<input type="hidden" data-field="x_pension_admin" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->pension_admin->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_assets_tb_grid->PageObjName . "_row_" . $simplewill_assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $simplewill_assets_tb->datecreated->CellAttributes() ?>>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_datecreated" class="control-group simplewill_assets_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $simplewill_assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_assets_tb->datecreated->EditValue ?>"<?php echo $simplewill_assets_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_assets_tb_grid->RowCnt ?>_simplewill_assets_tb_datecreated" class="control-group simplewill_assets_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $simplewill_assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_assets_tb->datecreated->EditValue ?>"<?php echo $simplewill_assets_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_assets_tb_grid->PageObjName . "_row_" . $simplewill_assets_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$simplewill_assets_tb_grid->ListOptions->Render("body", "right", $simplewill_assets_tb_grid->RowCnt);
?>
	</tr>
<?php if ($simplewill_assets_tb->RowType == EW_ROWTYPE_ADD || $simplewill_assets_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsimplewill_assets_tbgrid.UpdateOpts(<?php echo $simplewill_assets_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($simplewill_assets_tb->CurrentAction <> "gridadd" || $simplewill_assets_tb->CurrentMode == "copy")
		if (!$simplewill_assets_tb_grid->Recordset->EOF) $simplewill_assets_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($simplewill_assets_tb->CurrentMode == "add" || $simplewill_assets_tb->CurrentMode == "copy" || $simplewill_assets_tb->CurrentMode == "edit") {
		$simplewill_assets_tb_grid->RowIndex = '$rowindex$';
		$simplewill_assets_tb_grid->LoadDefaultValues();

		// Set row properties
		$simplewill_assets_tb->ResetAttrs();
		$simplewill_assets_tb->RowAttrs = array_merge($simplewill_assets_tb->RowAttrs, array('data-rowindex'=>$simplewill_assets_tb_grid->RowIndex, 'id'=>'r0_simplewill_assets_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($simplewill_assets_tb->RowAttrs["class"], "ewTemplate");
		$simplewill_assets_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$simplewill_assets_tb_grid->RenderRow();

		// Render list options
		$simplewill_assets_tb_grid->RenderListOptions();
		$simplewill_assets_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $simplewill_assets_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$simplewill_assets_tb_grid->ListOptions->Render("body", "left", $simplewill_assets_tb_grid->RowIndex);
?>
	<?php if ($simplewill_assets_tb->asset_type->Visible) { // asset_type ?>
		<td>
<?php if ($simplewill_assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_assets_tb_asset_type" class="control-group simplewill_assets_tb_asset_type">
<textarea data-field="x_asset_type" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->asset_type->PlaceHolder ?>"<?php echo $simplewill_assets_tb->asset_type->EditAttributes() ?>><?php echo $simplewill_assets_tb->asset_type->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_assets_tb_asset_type" class="control-group simplewill_assets_tb_asset_type">
<span<?php echo $simplewill_assets_tb->asset_type->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->asset_type->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_asset_type" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->asset_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_asset_type" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_asset_type" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->asset_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->account_name->Visible) { // account_name ?>
		<td>
<?php if ($simplewill_assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_assets_tb_account_name" class="control-group simplewill_assets_tb_account_name">
<textarea data-field="x_account_name" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->account_name->PlaceHolder ?>"<?php echo $simplewill_assets_tb->account_name->EditAttributes() ?>><?php echo $simplewill_assets_tb->account_name->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_assets_tb_account_name" class="control-group simplewill_assets_tb_account_name">
<span<?php echo $simplewill_assets_tb->account_name->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->account_name->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_account_name" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->account_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_account_name" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_account_name" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->account_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->bankname->Visible) { // bankname ?>
		<td>
<?php if ($simplewill_assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_assets_tb_bankname" class="control-group simplewill_assets_tb_bankname">
<textarea data-field="x_bankname" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->bankname->PlaceHolder ?>"<?php echo $simplewill_assets_tb->bankname->EditAttributes() ?>><?php echo $simplewill_assets_tb->bankname->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_assets_tb_bankname" class="control-group simplewill_assets_tb_bankname">
<span<?php echo $simplewill_assets_tb->bankname->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->bankname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_bankname" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->bankname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_bankname" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_bankname" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->bankname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->pension_admin->Visible) { // pension_admin ?>
		<td>
<?php if ($simplewill_assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_assets_tb_pension_admin" class="control-group simplewill_assets_tb_pension_admin">
<textarea data-field="x_pension_admin" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" cols="35" rows="4" placeholder="<?php echo $simplewill_assets_tb->pension_admin->PlaceHolder ?>"<?php echo $simplewill_assets_tb->pension_admin->EditAttributes() ?>><?php echo $simplewill_assets_tb->pension_admin->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_assets_tb_pension_admin" class="control-group simplewill_assets_tb_pension_admin">
<span<?php echo $simplewill_assets_tb->pension_admin->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->pension_admin->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_pension_admin" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->pension_admin->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_pension_admin" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_pension_admin" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->pension_admin->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_assets_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($simplewill_assets_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_assets_tb_datecreated" class="control-group simplewill_assets_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $simplewill_assets_tb->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_assets_tb->datecreated->EditValue ?>"<?php echo $simplewill_assets_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_assets_tb_datecreated" class="control-group simplewill_assets_tb_datecreated">
<span<?php echo $simplewill_assets_tb->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_assets_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $simplewill_assets_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_assets_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$simplewill_assets_tb_grid->ListOptions->Render("body", "right", $simplewill_assets_tb_grid->RowCnt);
?>
<script type="text/javascript">
fsimplewill_assets_tbgrid.UpdateOpts(<?php echo $simplewill_assets_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($simplewill_assets_tb->CurrentMode == "add" || $simplewill_assets_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $simplewill_assets_tb_grid->FormKeyCountName ?>" id="<?php echo $simplewill_assets_tb_grid->FormKeyCountName ?>" value="<?php echo $simplewill_assets_tb_grid->KeyCount ?>">
<?php echo $simplewill_assets_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($simplewill_assets_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $simplewill_assets_tb_grid->FormKeyCountName ?>" id="<?php echo $simplewill_assets_tb_grid->FormKeyCountName ?>" value="<?php echo $simplewill_assets_tb_grid->KeyCount ?>">
<?php echo $simplewill_assets_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($simplewill_assets_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsimplewill_assets_tbgrid">
</div>
<?php

// Close recordset
if ($simplewill_assets_tb_grid->Recordset)
	$simplewill_assets_tb_grid->Recordset->Close();
?>
<?php if ($simplewill_assets_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($simplewill_assets_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($simplewill_assets_tb->Export == "") { ?>
<script type="text/javascript">
fsimplewill_assets_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$simplewill_assets_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$simplewill_assets_tb_grid->Page_Terminate();
?>
