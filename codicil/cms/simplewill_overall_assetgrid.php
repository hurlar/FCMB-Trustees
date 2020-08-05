<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($simplewill_overall_asset_grid)) $simplewill_overall_asset_grid = new csimplewill_overall_asset_grid();

// Page init
$simplewill_overall_asset_grid->Page_Init();

// Page main
$simplewill_overall_asset_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$simplewill_overall_asset_grid->Page_Render();
?>
<?php if ($simplewill_overall_asset->Export == "") { ?>
<script type="text/javascript">

// Page object
var simplewill_overall_asset_grid = new ew_Page("simplewill_overall_asset_grid");
simplewill_overall_asset_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = simplewill_overall_asset_grid.PageID; // For backward compatibility

// Form object
var fsimplewill_overall_assetgrid = new ew_Form("fsimplewill_overall_assetgrid");
fsimplewill_overall_assetgrid.FormKeyCountName = '<?php echo $simplewill_overall_asset_grid->FormKeyCountName ?>';

// Validate form
fsimplewill_overall_assetgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_beneficiaryid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($simplewill_overall_asset->beneficiaryid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_propertyid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($simplewill_overall_asset->propertyid->FldErrMsg()) ?>");

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
fsimplewill_overall_assetgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "beneficiaryid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "propertyid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "property_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "percentage", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fsimplewill_overall_assetgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsimplewill_overall_assetgrid.ValidateRequired = true;
<?php } else { ?>
fsimplewill_overall_assetgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($simplewill_overall_asset->getCurrentMasterTable() == "" && $simplewill_overall_asset_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $simplewill_overall_asset_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($simplewill_overall_asset->CurrentAction == "gridadd") {
	if ($simplewill_overall_asset->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$simplewill_overall_asset_grid->TotalRecs = $simplewill_overall_asset->SelectRecordCount();
			$simplewill_overall_asset_grid->Recordset = $simplewill_overall_asset_grid->LoadRecordset($simplewill_overall_asset_grid->StartRec-1, $simplewill_overall_asset_grid->DisplayRecs);
		} else {
			if ($simplewill_overall_asset_grid->Recordset = $simplewill_overall_asset_grid->LoadRecordset())
				$simplewill_overall_asset_grid->TotalRecs = $simplewill_overall_asset_grid->Recordset->RecordCount();
		}
		$simplewill_overall_asset_grid->StartRec = 1;
		$simplewill_overall_asset_grid->DisplayRecs = $simplewill_overall_asset_grid->TotalRecs;
	} else {
		$simplewill_overall_asset->CurrentFilter = "0=1";
		$simplewill_overall_asset_grid->StartRec = 1;
		$simplewill_overall_asset_grid->DisplayRecs = $simplewill_overall_asset->GridAddRowCount;
	}
	$simplewill_overall_asset_grid->TotalRecs = $simplewill_overall_asset_grid->DisplayRecs;
	$simplewill_overall_asset_grid->StopRec = $simplewill_overall_asset_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$simplewill_overall_asset_grid->TotalRecs = $simplewill_overall_asset->SelectRecordCount();
	} else {
		if ($simplewill_overall_asset_grid->Recordset = $simplewill_overall_asset_grid->LoadRecordset())
			$simplewill_overall_asset_grid->TotalRecs = $simplewill_overall_asset_grid->Recordset->RecordCount();
	}
	$simplewill_overall_asset_grid->StartRec = 1;
	$simplewill_overall_asset_grid->DisplayRecs = $simplewill_overall_asset_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$simplewill_overall_asset_grid->Recordset = $simplewill_overall_asset_grid->LoadRecordset($simplewill_overall_asset_grid->StartRec-1, $simplewill_overall_asset_grid->DisplayRecs);
}
$simplewill_overall_asset_grid->RenderOtherOptions();
?>
<?php $simplewill_overall_asset_grid->ShowPageHeader(); ?>
<?php
$simplewill_overall_asset_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fsimplewill_overall_assetgrid" class="ewForm form-horizontal">
<div id="gmp_simplewill_overall_asset" class="ewGridMiddlePanel">
<table id="tbl_simplewill_overall_assetgrid" class="ewTable ewTableSeparate">
<?php echo $simplewill_overall_asset->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$simplewill_overall_asset_grid->RenderListOptions();

// Render list options (header, left)
$simplewill_overall_asset_grid->ListOptions->Render("header", "left");
?>
<?php if ($simplewill_overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
	<?php if ($simplewill_overall_asset->SortUrl($simplewill_overall_asset->beneficiaryid) == "") { ?>
		<td><div id="elh_simplewill_overall_asset_beneficiaryid" class="simplewill_overall_asset_beneficiaryid"><div class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->beneficiaryid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_overall_asset_beneficiaryid" class="simplewill_overall_asset_beneficiaryid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->beneficiaryid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_overall_asset->beneficiaryid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_overall_asset->beneficiaryid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_overall_asset->propertyid->Visible) { // propertyid ?>
	<?php if ($simplewill_overall_asset->SortUrl($simplewill_overall_asset->propertyid) == "") { ?>
		<td><div id="elh_simplewill_overall_asset_propertyid" class="simplewill_overall_asset_propertyid"><div class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->propertyid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_overall_asset_propertyid" class="simplewill_overall_asset_propertyid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->propertyid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_overall_asset->propertyid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_overall_asset->propertyid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_overall_asset->property_type->Visible) { // property_type ?>
	<?php if ($simplewill_overall_asset->SortUrl($simplewill_overall_asset->property_type) == "") { ?>
		<td><div id="elh_simplewill_overall_asset_property_type" class="simplewill_overall_asset_property_type"><div class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->property_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_overall_asset_property_type" class="simplewill_overall_asset_property_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->property_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_overall_asset->property_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_overall_asset->property_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_overall_asset->percentage->Visible) { // percentage ?>
	<?php if ($simplewill_overall_asset->SortUrl($simplewill_overall_asset->percentage) == "") { ?>
		<td><div id="elh_simplewill_overall_asset_percentage" class="simplewill_overall_asset_percentage"><div class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->percentage->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_overall_asset_percentage" class="simplewill_overall_asset_percentage">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->percentage->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_overall_asset->percentage->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_overall_asset->percentage->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($simplewill_overall_asset->datecreated->Visible) { // datecreated ?>
	<?php if ($simplewill_overall_asset->SortUrl($simplewill_overall_asset->datecreated) == "") { ?>
		<td><div id="elh_simplewill_overall_asset_datecreated" class="simplewill_overall_asset_datecreated"><div class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_simplewill_overall_asset_datecreated" class="simplewill_overall_asset_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $simplewill_overall_asset->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($simplewill_overall_asset->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($simplewill_overall_asset->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$simplewill_overall_asset_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$simplewill_overall_asset_grid->StartRec = 1;
$simplewill_overall_asset_grid->StopRec = $simplewill_overall_asset_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($simplewill_overall_asset_grid->FormKeyCountName) && ($simplewill_overall_asset->CurrentAction == "gridadd" || $simplewill_overall_asset->CurrentAction == "gridedit" || $simplewill_overall_asset->CurrentAction == "F")) {
		$simplewill_overall_asset_grid->KeyCount = $objForm->GetValue($simplewill_overall_asset_grid->FormKeyCountName);
		$simplewill_overall_asset_grid->StopRec = $simplewill_overall_asset_grid->StartRec + $simplewill_overall_asset_grid->KeyCount - 1;
	}
}
$simplewill_overall_asset_grid->RecCnt = $simplewill_overall_asset_grid->StartRec - 1;
if ($simplewill_overall_asset_grid->Recordset && !$simplewill_overall_asset_grid->Recordset->EOF) {
	$simplewill_overall_asset_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $simplewill_overall_asset_grid->StartRec > 1)
		$simplewill_overall_asset_grid->Recordset->Move($simplewill_overall_asset_grid->StartRec - 1);
} elseif (!$simplewill_overall_asset->AllowAddDeleteRow && $simplewill_overall_asset_grid->StopRec == 0) {
	$simplewill_overall_asset_grid->StopRec = $simplewill_overall_asset->GridAddRowCount;
}

// Initialize aggregate
$simplewill_overall_asset->RowType = EW_ROWTYPE_AGGREGATEINIT;
$simplewill_overall_asset->ResetAttrs();
$simplewill_overall_asset_grid->RenderRow();
if ($simplewill_overall_asset->CurrentAction == "gridadd")
	$simplewill_overall_asset_grid->RowIndex = 0;
if ($simplewill_overall_asset->CurrentAction == "gridedit")
	$simplewill_overall_asset_grid->RowIndex = 0;
while ($simplewill_overall_asset_grid->RecCnt < $simplewill_overall_asset_grid->StopRec) {
	$simplewill_overall_asset_grid->RecCnt++;
	if (intval($simplewill_overall_asset_grid->RecCnt) >= intval($simplewill_overall_asset_grid->StartRec)) {
		$simplewill_overall_asset_grid->RowCnt++;
		if ($simplewill_overall_asset->CurrentAction == "gridadd" || $simplewill_overall_asset->CurrentAction == "gridedit" || $simplewill_overall_asset->CurrentAction == "F") {
			$simplewill_overall_asset_grid->RowIndex++;
			$objForm->Index = $simplewill_overall_asset_grid->RowIndex;
			if ($objForm->HasValue($simplewill_overall_asset_grid->FormActionName))
				$simplewill_overall_asset_grid->RowAction = strval($objForm->GetValue($simplewill_overall_asset_grid->FormActionName));
			elseif ($simplewill_overall_asset->CurrentAction == "gridadd")
				$simplewill_overall_asset_grid->RowAction = "insert";
			else
				$simplewill_overall_asset_grid->RowAction = "";
		}

		// Set up key count
		$simplewill_overall_asset_grid->KeyCount = $simplewill_overall_asset_grid->RowIndex;

		// Init row class and style
		$simplewill_overall_asset->ResetAttrs();
		$simplewill_overall_asset->CssClass = "";
		if ($simplewill_overall_asset->CurrentAction == "gridadd") {
			if ($simplewill_overall_asset->CurrentMode == "copy") {
				$simplewill_overall_asset_grid->LoadRowValues($simplewill_overall_asset_grid->Recordset); // Load row values
				$simplewill_overall_asset_grid->SetRecordKey($simplewill_overall_asset_grid->RowOldKey, $simplewill_overall_asset_grid->Recordset); // Set old record key
			} else {
				$simplewill_overall_asset_grid->LoadDefaultValues(); // Load default values
				$simplewill_overall_asset_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$simplewill_overall_asset_grid->LoadRowValues($simplewill_overall_asset_grid->Recordset); // Load row values
		}
		$simplewill_overall_asset->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($simplewill_overall_asset->CurrentAction == "gridadd") // Grid add
			$simplewill_overall_asset->RowType = EW_ROWTYPE_ADD; // Render add
		if ($simplewill_overall_asset->CurrentAction == "gridadd" && $simplewill_overall_asset->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$simplewill_overall_asset_grid->RestoreCurrentRowFormValues($simplewill_overall_asset_grid->RowIndex); // Restore form values
		if ($simplewill_overall_asset->CurrentAction == "gridedit") { // Grid edit
			if ($simplewill_overall_asset->EventCancelled) {
				$simplewill_overall_asset_grid->RestoreCurrentRowFormValues($simplewill_overall_asset_grid->RowIndex); // Restore form values
			}
			if ($simplewill_overall_asset_grid->RowAction == "insert")
				$simplewill_overall_asset->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$simplewill_overall_asset->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($simplewill_overall_asset->CurrentAction == "gridedit" && ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT || $simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) && $simplewill_overall_asset->EventCancelled) // Update failed
			$simplewill_overall_asset_grid->RestoreCurrentRowFormValues($simplewill_overall_asset_grid->RowIndex); // Restore form values
		if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) // Edit row
			$simplewill_overall_asset_grid->EditRowCnt++;
		if ($simplewill_overall_asset->CurrentAction == "F") // Confirm row
			$simplewill_overall_asset_grid->RestoreCurrentRowFormValues($simplewill_overall_asset_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$simplewill_overall_asset->RowAttrs = array_merge($simplewill_overall_asset->RowAttrs, array('data-rowindex'=>$simplewill_overall_asset_grid->RowCnt, 'id'=>'r' . $simplewill_overall_asset_grid->RowCnt . '_simplewill_overall_asset', 'data-rowtype'=>$simplewill_overall_asset->RowType));

		// Render row
		$simplewill_overall_asset_grid->RenderRow();

		// Render list options
		$simplewill_overall_asset_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($simplewill_overall_asset_grid->RowAction <> "delete" && $simplewill_overall_asset_grid->RowAction <> "insertdelete" && !($simplewill_overall_asset_grid->RowAction == "insert" && $simplewill_overall_asset->CurrentAction == "F" && $simplewill_overall_asset_grid->EmptyRow())) {
?>
	<tr<?php echo $simplewill_overall_asset->RowAttributes() ?>>
<?php

// Render list options (body, left)
$simplewill_overall_asset_grid->ListOptions->Render("body", "left", $simplewill_overall_asset_grid->RowCnt);
?>
	<?php if ($simplewill_overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
		<td<?php echo $simplewill_overall_asset->beneficiaryid->CellAttributes() ?>>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_beneficiaryid" class="control-group simplewill_overall_asset_beneficiaryid">
<input type="text" data-field="x_beneficiaryid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" size="30" placeholder="<?php echo $simplewill_overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->beneficiaryid->EditValue ?>"<?php echo $simplewill_overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_beneficiaryid" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->beneficiaryid->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_beneficiaryid" class="control-group simplewill_overall_asset_beneficiaryid">
<input type="text" data-field="x_beneficiaryid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" size="30" placeholder="<?php echo $simplewill_overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->beneficiaryid->EditValue ?>"<?php echo $simplewill_overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_overall_asset->beneficiaryid->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->beneficiaryid->ListViewValue() ?></span>
<input type="hidden" data-field="x_beneficiaryid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->beneficiaryid->FormValue) ?>">
<input type="hidden" data-field="x_beneficiaryid" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->beneficiaryid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_overall_asset_grid->PageObjName . "_row_" . $simplewill_overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_id" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_id" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->id->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT || $simplewill_overall_asset->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_id" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($simplewill_overall_asset->propertyid->Visible) { // propertyid ?>
		<td<?php echo $simplewill_overall_asset->propertyid->CellAttributes() ?>>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_propertyid" class="control-group simplewill_overall_asset_propertyid">
<input type="text" data-field="x_propertyid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" size="30" placeholder="<?php echo $simplewill_overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->propertyid->EditValue ?>"<?php echo $simplewill_overall_asset->propertyid->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_propertyid" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->propertyid->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_propertyid" class="control-group simplewill_overall_asset_propertyid">
<input type="text" data-field="x_propertyid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" size="30" placeholder="<?php echo $simplewill_overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->propertyid->EditValue ?>"<?php echo $simplewill_overall_asset->propertyid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_overall_asset->propertyid->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->propertyid->ListViewValue() ?></span>
<input type="hidden" data-field="x_propertyid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->propertyid->FormValue) ?>">
<input type="hidden" data-field="x_propertyid" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->propertyid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_overall_asset_grid->PageObjName . "_row_" . $simplewill_overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->property_type->Visible) { // property_type ?>
		<td<?php echo $simplewill_overall_asset->property_type->CellAttributes() ?>>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_property_type" class="control-group simplewill_overall_asset_property_type">
<input type="text" data-field="x_property_type" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" size="30" maxlength="50" placeholder="<?php echo $simplewill_overall_asset->property_type->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->property_type->EditValue ?>"<?php echo $simplewill_overall_asset->property_type->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_property_type" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->property_type->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_property_type" class="control-group simplewill_overall_asset_property_type">
<input type="text" data-field="x_property_type" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" size="30" maxlength="50" placeholder="<?php echo $simplewill_overall_asset->property_type->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->property_type->EditValue ?>"<?php echo $simplewill_overall_asset->property_type->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_overall_asset->property_type->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->property_type->ListViewValue() ?></span>
<input type="hidden" data-field="x_property_type" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->property_type->FormValue) ?>">
<input type="hidden" data-field="x_property_type" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->property_type->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_overall_asset_grid->PageObjName . "_row_" . $simplewill_overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->percentage->Visible) { // percentage ?>
		<td<?php echo $simplewill_overall_asset->percentage->CellAttributes() ?>>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_percentage" class="control-group simplewill_overall_asset_percentage">
<input type="text" data-field="x_percentage" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" size="30" maxlength="5" placeholder="<?php echo $simplewill_overall_asset->percentage->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->percentage->EditValue ?>"<?php echo $simplewill_overall_asset->percentage->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_percentage" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->percentage->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_percentage" class="control-group simplewill_overall_asset_percentage">
<input type="text" data-field="x_percentage" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" size="30" maxlength="5" placeholder="<?php echo $simplewill_overall_asset->percentage->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->percentage->EditValue ?>"<?php echo $simplewill_overall_asset->percentage->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_overall_asset->percentage->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->percentage->ListViewValue() ?></span>
<input type="hidden" data-field="x_percentage" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->percentage->FormValue) ?>">
<input type="hidden" data-field="x_percentage" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->percentage->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_overall_asset_grid->PageObjName . "_row_" . $simplewill_overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->datecreated->Visible) { // datecreated ?>
		<td<?php echo $simplewill_overall_asset->datecreated->CellAttributes() ?>>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_datecreated" class="control-group simplewill_overall_asset_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" placeholder="<?php echo $simplewill_overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->datecreated->EditValue ?>"<?php echo $simplewill_overall_asset->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $simplewill_overall_asset_grid->RowCnt ?>_simplewill_overall_asset_datecreated" class="control-group simplewill_overall_asset_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" placeholder="<?php echo $simplewill_overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->datecreated->EditValue ?>"<?php echo $simplewill_overall_asset->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $simplewill_overall_asset->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $simplewill_overall_asset_grid->PageObjName . "_row_" . $simplewill_overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$simplewill_overall_asset_grid->ListOptions->Render("body", "right", $simplewill_overall_asset_grid->RowCnt);
?>
	</tr>
<?php if ($simplewill_overall_asset->RowType == EW_ROWTYPE_ADD || $simplewill_overall_asset->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsimplewill_overall_assetgrid.UpdateOpts(<?php echo $simplewill_overall_asset_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($simplewill_overall_asset->CurrentAction <> "gridadd" || $simplewill_overall_asset->CurrentMode == "copy")
		if (!$simplewill_overall_asset_grid->Recordset->EOF) $simplewill_overall_asset_grid->Recordset->MoveNext();
}
?>
<?php
	if ($simplewill_overall_asset->CurrentMode == "add" || $simplewill_overall_asset->CurrentMode == "copy" || $simplewill_overall_asset->CurrentMode == "edit") {
		$simplewill_overall_asset_grid->RowIndex = '$rowindex$';
		$simplewill_overall_asset_grid->LoadDefaultValues();

		// Set row properties
		$simplewill_overall_asset->ResetAttrs();
		$simplewill_overall_asset->RowAttrs = array_merge($simplewill_overall_asset->RowAttrs, array('data-rowindex'=>$simplewill_overall_asset_grid->RowIndex, 'id'=>'r0_simplewill_overall_asset', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($simplewill_overall_asset->RowAttrs["class"], "ewTemplate");
		$simplewill_overall_asset->RowType = EW_ROWTYPE_ADD;

		// Render row
		$simplewill_overall_asset_grid->RenderRow();

		// Render list options
		$simplewill_overall_asset_grid->RenderListOptions();
		$simplewill_overall_asset_grid->StartRowCnt = 0;
?>
	<tr<?php echo $simplewill_overall_asset->RowAttributes() ?>>
<?php

// Render list options (body, left)
$simplewill_overall_asset_grid->ListOptions->Render("body", "left", $simplewill_overall_asset_grid->RowIndex);
?>
	<?php if ($simplewill_overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
		<td>
<?php if ($simplewill_overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_overall_asset_beneficiaryid" class="control-group simplewill_overall_asset_beneficiaryid">
<input type="text" data-field="x_beneficiaryid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" size="30" placeholder="<?php echo $simplewill_overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->beneficiaryid->EditValue ?>"<?php echo $simplewill_overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_overall_asset_beneficiaryid" class="control-group simplewill_overall_asset_beneficiaryid">
<span<?php echo $simplewill_overall_asset->beneficiaryid->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->beneficiaryid->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_beneficiaryid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->beneficiaryid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_beneficiaryid" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->beneficiaryid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->propertyid->Visible) { // propertyid ?>
		<td>
<?php if ($simplewill_overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_overall_asset_propertyid" class="control-group simplewill_overall_asset_propertyid">
<input type="text" data-field="x_propertyid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" size="30" placeholder="<?php echo $simplewill_overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->propertyid->EditValue ?>"<?php echo $simplewill_overall_asset->propertyid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_overall_asset_propertyid" class="control-group simplewill_overall_asset_propertyid">
<span<?php echo $simplewill_overall_asset->propertyid->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->propertyid->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_propertyid" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->propertyid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_propertyid" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->propertyid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->property_type->Visible) { // property_type ?>
		<td>
<?php if ($simplewill_overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_overall_asset_property_type" class="control-group simplewill_overall_asset_property_type">
<input type="text" data-field="x_property_type" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" size="30" maxlength="50" placeholder="<?php echo $simplewill_overall_asset->property_type->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->property_type->EditValue ?>"<?php echo $simplewill_overall_asset->property_type->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_overall_asset_property_type" class="control-group simplewill_overall_asset_property_type">
<span<?php echo $simplewill_overall_asset->property_type->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->property_type->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_property_type" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->property_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_property_type" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->property_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->percentage->Visible) { // percentage ?>
		<td>
<?php if ($simplewill_overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_overall_asset_percentage" class="control-group simplewill_overall_asset_percentage">
<input type="text" data-field="x_percentage" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" size="30" maxlength="5" placeholder="<?php echo $simplewill_overall_asset->percentage->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->percentage->EditValue ?>"<?php echo $simplewill_overall_asset->percentage->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_overall_asset_percentage" class="control-group simplewill_overall_asset_percentage">
<span<?php echo $simplewill_overall_asset->percentage->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->percentage->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_percentage" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->percentage->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_percentage" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->percentage->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($simplewill_overall_asset->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($simplewill_overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_simplewill_overall_asset_datecreated" class="control-group simplewill_overall_asset_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" placeholder="<?php echo $simplewill_overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $simplewill_overall_asset->datecreated->EditValue ?>"<?php echo $simplewill_overall_asset->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_simplewill_overall_asset_datecreated" class="control-group simplewill_overall_asset_datecreated">
<span<?php echo $simplewill_overall_asset->datecreated->ViewAttributes() ?>>
<?php echo $simplewill_overall_asset->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" id="o<?php echo $simplewill_overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($simplewill_overall_asset->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$simplewill_overall_asset_grid->ListOptions->Render("body", "right", $simplewill_overall_asset_grid->RowCnt);
?>
<script type="text/javascript">
fsimplewill_overall_assetgrid.UpdateOpts(<?php echo $simplewill_overall_asset_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($simplewill_overall_asset->CurrentMode == "add" || $simplewill_overall_asset->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $simplewill_overall_asset_grid->FormKeyCountName ?>" id="<?php echo $simplewill_overall_asset_grid->FormKeyCountName ?>" value="<?php echo $simplewill_overall_asset_grid->KeyCount ?>">
<?php echo $simplewill_overall_asset_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($simplewill_overall_asset->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $simplewill_overall_asset_grid->FormKeyCountName ?>" id="<?php echo $simplewill_overall_asset_grid->FormKeyCountName ?>" value="<?php echo $simplewill_overall_asset_grid->KeyCount ?>">
<?php echo $simplewill_overall_asset_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($simplewill_overall_asset->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsimplewill_overall_assetgrid">
</div>
<?php

// Close recordset
if ($simplewill_overall_asset_grid->Recordset)
	$simplewill_overall_asset_grid->Recordset->Close();
?>
<?php if ($simplewill_overall_asset_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($simplewill_overall_asset_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($simplewill_overall_asset->Export == "") { ?>
<script type="text/javascript">
fsimplewill_overall_assetgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$simplewill_overall_asset_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$simplewill_overall_asset_grid->Page_Terminate();
?>
