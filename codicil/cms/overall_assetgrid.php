<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($overall_asset_grid)) $overall_asset_grid = new coverall_asset_grid();

// Page init
$overall_asset_grid->Page_Init();

// Page main
$overall_asset_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$overall_asset_grid->Page_Render();
?>
<?php if ($overall_asset->Export == "") { ?>
<script type="text/javascript">

// Page object
var overall_asset_grid = new ew_Page("overall_asset_grid");
overall_asset_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = overall_asset_grid.PageID; // For backward compatibility

// Form object
var foverall_assetgrid = new ew_Form("foverall_assetgrid");
foverall_assetgrid.FormKeyCountName = '<?php echo $overall_asset_grid->FormKeyCountName ?>';

// Validate form
foverall_assetgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($overall_asset->beneficiaryid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_propertyid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($overall_asset->propertyid->FldErrMsg()) ?>");

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
foverall_assetgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "beneficiaryid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "propertyid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "property_type", false)) return false;
	if (ew_ValueChanged(fobj, infix, "percentage", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
foverall_assetgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
foverall_assetgrid.ValidateRequired = true;
<?php } else { ?>
foverall_assetgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($overall_asset->getCurrentMasterTable() == "" && $overall_asset_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $overall_asset_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($overall_asset->CurrentAction == "gridadd") {
	if ($overall_asset->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$overall_asset_grid->TotalRecs = $overall_asset->SelectRecordCount();
			$overall_asset_grid->Recordset = $overall_asset_grid->LoadRecordset($overall_asset_grid->StartRec-1, $overall_asset_grid->DisplayRecs);
		} else {
			if ($overall_asset_grid->Recordset = $overall_asset_grid->LoadRecordset())
				$overall_asset_grid->TotalRecs = $overall_asset_grid->Recordset->RecordCount();
		}
		$overall_asset_grid->StartRec = 1;
		$overall_asset_grid->DisplayRecs = $overall_asset_grid->TotalRecs;
	} else {
		$overall_asset->CurrentFilter = "0=1";
		$overall_asset_grid->StartRec = 1;
		$overall_asset_grid->DisplayRecs = $overall_asset->GridAddRowCount;
	}
	$overall_asset_grid->TotalRecs = $overall_asset_grid->DisplayRecs;
	$overall_asset_grid->StopRec = $overall_asset_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$overall_asset_grid->TotalRecs = $overall_asset->SelectRecordCount();
	} else {
		if ($overall_asset_grid->Recordset = $overall_asset_grid->LoadRecordset())
			$overall_asset_grid->TotalRecs = $overall_asset_grid->Recordset->RecordCount();
	}
	$overall_asset_grid->StartRec = 1;
	$overall_asset_grid->DisplayRecs = $overall_asset_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$overall_asset_grid->Recordset = $overall_asset_grid->LoadRecordset($overall_asset_grid->StartRec-1, $overall_asset_grid->DisplayRecs);
}
$overall_asset_grid->RenderOtherOptions();
?>
<?php $overall_asset_grid->ShowPageHeader(); ?>
<?php
$overall_asset_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="foverall_assetgrid" class="ewForm form-horizontal">
<div id="gmp_overall_asset" class="ewGridMiddlePanel">
<table id="tbl_overall_assetgrid" class="ewTable ewTableSeparate">
<?php echo $overall_asset->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$overall_asset_grid->RenderListOptions();

// Render list options (header, left)
$overall_asset_grid->ListOptions->Render("header", "left");
?>
<?php if ($overall_asset->id->Visible) { // id ?>
	<?php if ($overall_asset->SortUrl($overall_asset->id) == "") { ?>
		<td><div id="elh_overall_asset_id" class="overall_asset_id"><div class="ewTableHeaderCaption"><?php echo $overall_asset->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_overall_asset_id" class="overall_asset_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $overall_asset->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($overall_asset->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($overall_asset->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
	<?php if ($overall_asset->SortUrl($overall_asset->beneficiaryid) == "") { ?>
		<td><div id="elh_overall_asset_beneficiaryid" class="overall_asset_beneficiaryid"><div class="ewTableHeaderCaption"><?php echo $overall_asset->beneficiaryid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_overall_asset_beneficiaryid" class="overall_asset_beneficiaryid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $overall_asset->beneficiaryid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($overall_asset->beneficiaryid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($overall_asset->beneficiaryid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($overall_asset->propertyid->Visible) { // propertyid ?>
	<?php if ($overall_asset->SortUrl($overall_asset->propertyid) == "") { ?>
		<td><div id="elh_overall_asset_propertyid" class="overall_asset_propertyid"><div class="ewTableHeaderCaption"><?php echo $overall_asset->propertyid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_overall_asset_propertyid" class="overall_asset_propertyid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $overall_asset->propertyid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($overall_asset->propertyid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($overall_asset->propertyid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($overall_asset->property_type->Visible) { // property_type ?>
	<?php if ($overall_asset->SortUrl($overall_asset->property_type) == "") { ?>
		<td><div id="elh_overall_asset_property_type" class="overall_asset_property_type"><div class="ewTableHeaderCaption"><?php echo $overall_asset->property_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_overall_asset_property_type" class="overall_asset_property_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $overall_asset->property_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($overall_asset->property_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($overall_asset->property_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($overall_asset->percentage->Visible) { // percentage ?>
	<?php if ($overall_asset->SortUrl($overall_asset->percentage) == "") { ?>
		<td><div id="elh_overall_asset_percentage" class="overall_asset_percentage"><div class="ewTableHeaderCaption"><?php echo $overall_asset->percentage->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_overall_asset_percentage" class="overall_asset_percentage">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $overall_asset->percentage->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($overall_asset->percentage->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($overall_asset->percentage->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($overall_asset->datecreated->Visible) { // datecreated ?>
	<?php if ($overall_asset->SortUrl($overall_asset->datecreated) == "") { ?>
		<td><div id="elh_overall_asset_datecreated" class="overall_asset_datecreated"><div class="ewTableHeaderCaption"><?php echo $overall_asset->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_overall_asset_datecreated" class="overall_asset_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $overall_asset->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($overall_asset->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($overall_asset->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$overall_asset_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$overall_asset_grid->StartRec = 1;
$overall_asset_grid->StopRec = $overall_asset_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($overall_asset_grid->FormKeyCountName) && ($overall_asset->CurrentAction == "gridadd" || $overall_asset->CurrentAction == "gridedit" || $overall_asset->CurrentAction == "F")) {
		$overall_asset_grid->KeyCount = $objForm->GetValue($overall_asset_grid->FormKeyCountName);
		$overall_asset_grid->StopRec = $overall_asset_grid->StartRec + $overall_asset_grid->KeyCount - 1;
	}
}
$overall_asset_grid->RecCnt = $overall_asset_grid->StartRec - 1;
if ($overall_asset_grid->Recordset && !$overall_asset_grid->Recordset->EOF) {
	$overall_asset_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $overall_asset_grid->StartRec > 1)
		$overall_asset_grid->Recordset->Move($overall_asset_grid->StartRec - 1);
} elseif (!$overall_asset->AllowAddDeleteRow && $overall_asset_grid->StopRec == 0) {
	$overall_asset_grid->StopRec = $overall_asset->GridAddRowCount;
}

// Initialize aggregate
$overall_asset->RowType = EW_ROWTYPE_AGGREGATEINIT;
$overall_asset->ResetAttrs();
$overall_asset_grid->RenderRow();
if ($overall_asset->CurrentAction == "gridadd")
	$overall_asset_grid->RowIndex = 0;
if ($overall_asset->CurrentAction == "gridedit")
	$overall_asset_grid->RowIndex = 0;
while ($overall_asset_grid->RecCnt < $overall_asset_grid->StopRec) {
	$overall_asset_grid->RecCnt++;
	if (intval($overall_asset_grid->RecCnt) >= intval($overall_asset_grid->StartRec)) {
		$overall_asset_grid->RowCnt++;
		if ($overall_asset->CurrentAction == "gridadd" || $overall_asset->CurrentAction == "gridedit" || $overall_asset->CurrentAction == "F") {
			$overall_asset_grid->RowIndex++;
			$objForm->Index = $overall_asset_grid->RowIndex;
			if ($objForm->HasValue($overall_asset_grid->FormActionName))
				$overall_asset_grid->RowAction = strval($objForm->GetValue($overall_asset_grid->FormActionName));
			elseif ($overall_asset->CurrentAction == "gridadd")
				$overall_asset_grid->RowAction = "insert";
			else
				$overall_asset_grid->RowAction = "";
		}

		// Set up key count
		$overall_asset_grid->KeyCount = $overall_asset_grid->RowIndex;

		// Init row class and style
		$overall_asset->ResetAttrs();
		$overall_asset->CssClass = "";
		if ($overall_asset->CurrentAction == "gridadd") {
			if ($overall_asset->CurrentMode == "copy") {
				$overall_asset_grid->LoadRowValues($overall_asset_grid->Recordset); // Load row values
				$overall_asset_grid->SetRecordKey($overall_asset_grid->RowOldKey, $overall_asset_grid->Recordset); // Set old record key
			} else {
				$overall_asset_grid->LoadDefaultValues(); // Load default values
				$overall_asset_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$overall_asset_grid->LoadRowValues($overall_asset_grid->Recordset); // Load row values
		}
		$overall_asset->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($overall_asset->CurrentAction == "gridadd") // Grid add
			$overall_asset->RowType = EW_ROWTYPE_ADD; // Render add
		if ($overall_asset->CurrentAction == "gridadd" && $overall_asset->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$overall_asset_grid->RestoreCurrentRowFormValues($overall_asset_grid->RowIndex); // Restore form values
		if ($overall_asset->CurrentAction == "gridedit") { // Grid edit
			if ($overall_asset->EventCancelled) {
				$overall_asset_grid->RestoreCurrentRowFormValues($overall_asset_grid->RowIndex); // Restore form values
			}
			if ($overall_asset_grid->RowAction == "insert")
				$overall_asset->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$overall_asset->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($overall_asset->CurrentAction == "gridedit" && ($overall_asset->RowType == EW_ROWTYPE_EDIT || $overall_asset->RowType == EW_ROWTYPE_ADD) && $overall_asset->EventCancelled) // Update failed
			$overall_asset_grid->RestoreCurrentRowFormValues($overall_asset_grid->RowIndex); // Restore form values
		if ($overall_asset->RowType == EW_ROWTYPE_EDIT) // Edit row
			$overall_asset_grid->EditRowCnt++;
		if ($overall_asset->CurrentAction == "F") // Confirm row
			$overall_asset_grid->RestoreCurrentRowFormValues($overall_asset_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$overall_asset->RowAttrs = array_merge($overall_asset->RowAttrs, array('data-rowindex'=>$overall_asset_grid->RowCnt, 'id'=>'r' . $overall_asset_grid->RowCnt . '_overall_asset', 'data-rowtype'=>$overall_asset->RowType));

		// Render row
		$overall_asset_grid->RenderRow();

		// Render list options
		$overall_asset_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($overall_asset_grid->RowAction <> "delete" && $overall_asset_grid->RowAction <> "insertdelete" && !($overall_asset_grid->RowAction == "insert" && $overall_asset->CurrentAction == "F" && $overall_asset_grid->EmptyRow())) {
?>
	<tr<?php echo $overall_asset->RowAttributes() ?>>
<?php

// Render list options (body, left)
$overall_asset_grid->ListOptions->Render("body", "left", $overall_asset_grid->RowCnt);
?>
	<?php if ($overall_asset->id->Visible) { // id ?>
		<td<?php echo $overall_asset->id->CellAttributes() ?>>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $overall_asset_grid->RowIndex ?>_id" id="o<?php echo $overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($overall_asset->id->OldValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_id" class="control-group overall_asset_id">
<span<?php echo $overall_asset->id->ViewAttributes() ?>>
<?php echo $overall_asset->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $overall_asset_grid->RowIndex ?>_id" id="x<?php echo $overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($overall_asset->id->CurrentValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $overall_asset->id->ViewAttributes() ?>>
<?php echo $overall_asset->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $overall_asset_grid->RowIndex ?>_id" id="x<?php echo $overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($overall_asset->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $overall_asset_grid->RowIndex ?>_id" id="o<?php echo $overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($overall_asset->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $overall_asset_grid->PageObjName . "_row_" . $overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
		<td<?php echo $overall_asset->beneficiaryid->CellAttributes() ?>>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_beneficiaryid" class="control-group overall_asset_beneficiaryid">
<input type="text" data-field="x_beneficiaryid" name="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" size="30" placeholder="<?php echo $overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $overall_asset->beneficiaryid->EditValue ?>"<?php echo $overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_beneficiaryid" name="o<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="o<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($overall_asset->beneficiaryid->OldValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_beneficiaryid" class="control-group overall_asset_beneficiaryid">
<input type="text" data-field="x_beneficiaryid" name="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" size="30" placeholder="<?php echo $overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $overall_asset->beneficiaryid->EditValue ?>"<?php echo $overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $overall_asset->beneficiaryid->ViewAttributes() ?>>
<?php echo $overall_asset->beneficiaryid->ListViewValue() ?></span>
<input type="hidden" data-field="x_beneficiaryid" name="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($overall_asset->beneficiaryid->FormValue) ?>">
<input type="hidden" data-field="x_beneficiaryid" name="o<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="o<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($overall_asset->beneficiaryid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $overall_asset_grid->PageObjName . "_row_" . $overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($overall_asset->propertyid->Visible) { // propertyid ?>
		<td<?php echo $overall_asset->propertyid->CellAttributes() ?>>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_propertyid" class="control-group overall_asset_propertyid">
<input type="text" data-field="x_propertyid" name="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" size="30" placeholder="<?php echo $overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $overall_asset->propertyid->EditValue ?>"<?php echo $overall_asset->propertyid->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_propertyid" name="o<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="o<?php echo $overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($overall_asset->propertyid->OldValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_propertyid" class="control-group overall_asset_propertyid">
<input type="text" data-field="x_propertyid" name="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" size="30" placeholder="<?php echo $overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $overall_asset->propertyid->EditValue ?>"<?php echo $overall_asset->propertyid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $overall_asset->propertyid->ViewAttributes() ?>>
<?php echo $overall_asset->propertyid->ListViewValue() ?></span>
<input type="hidden" data-field="x_propertyid" name="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($overall_asset->propertyid->FormValue) ?>">
<input type="hidden" data-field="x_propertyid" name="o<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="o<?php echo $overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($overall_asset->propertyid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $overall_asset_grid->PageObjName . "_row_" . $overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($overall_asset->property_type->Visible) { // property_type ?>
		<td<?php echo $overall_asset->property_type->CellAttributes() ?>>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_property_type" class="control-group overall_asset_property_type">
<input type="text" data-field="x_property_type" name="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" size="30" maxlength="50" placeholder="<?php echo $overall_asset->property_type->PlaceHolder ?>" value="<?php echo $overall_asset->property_type->EditValue ?>"<?php echo $overall_asset->property_type->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_property_type" name="o<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="o<?php echo $overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($overall_asset->property_type->OldValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_property_type" class="control-group overall_asset_property_type">
<input type="text" data-field="x_property_type" name="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" size="30" maxlength="50" placeholder="<?php echo $overall_asset->property_type->PlaceHolder ?>" value="<?php echo $overall_asset->property_type->EditValue ?>"<?php echo $overall_asset->property_type->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $overall_asset->property_type->ViewAttributes() ?>>
<?php echo $overall_asset->property_type->ListViewValue() ?></span>
<input type="hidden" data-field="x_property_type" name="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($overall_asset->property_type->FormValue) ?>">
<input type="hidden" data-field="x_property_type" name="o<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="o<?php echo $overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($overall_asset->property_type->OldValue) ?>">
<?php } ?>
<a id="<?php echo $overall_asset_grid->PageObjName . "_row_" . $overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($overall_asset->percentage->Visible) { // percentage ?>
		<td<?php echo $overall_asset->percentage->CellAttributes() ?>>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_percentage" class="control-group overall_asset_percentage">
<input type="text" data-field="x_percentage" name="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" size="30" maxlength="5" placeholder="<?php echo $overall_asset->percentage->PlaceHolder ?>" value="<?php echo $overall_asset->percentage->EditValue ?>"<?php echo $overall_asset->percentage->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_percentage" name="o<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="o<?php echo $overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($overall_asset->percentage->OldValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_percentage" class="control-group overall_asset_percentage">
<input type="text" data-field="x_percentage" name="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" size="30" maxlength="5" placeholder="<?php echo $overall_asset->percentage->PlaceHolder ?>" value="<?php echo $overall_asset->percentage->EditValue ?>"<?php echo $overall_asset->percentage->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $overall_asset->percentage->ViewAttributes() ?>>
<?php echo $overall_asset->percentage->ListViewValue() ?></span>
<input type="hidden" data-field="x_percentage" name="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($overall_asset->percentage->FormValue) ?>">
<input type="hidden" data-field="x_percentage" name="o<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="o<?php echo $overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($overall_asset->percentage->OldValue) ?>">
<?php } ?>
<a id="<?php echo $overall_asset_grid->PageObjName . "_row_" . $overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($overall_asset->datecreated->Visible) { // datecreated ?>
		<td<?php echo $overall_asset->datecreated->CellAttributes() ?>>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_datecreated" class="control-group overall_asset_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" placeholder="<?php echo $overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $overall_asset->datecreated->EditValue ?>"<?php echo $overall_asset->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="o<?php echo $overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($overall_asset->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $overall_asset_grid->RowCnt ?>_overall_asset_datecreated" class="control-group overall_asset_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" placeholder="<?php echo $overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $overall_asset->datecreated->EditValue ?>"<?php echo $overall_asset->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($overall_asset->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $overall_asset->datecreated->ViewAttributes() ?>>
<?php echo $overall_asset->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($overall_asset->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="o<?php echo $overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($overall_asset->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $overall_asset_grid->PageObjName . "_row_" . $overall_asset_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$overall_asset_grid->ListOptions->Render("body", "right", $overall_asset_grid->RowCnt);
?>
	</tr>
<?php if ($overall_asset->RowType == EW_ROWTYPE_ADD || $overall_asset->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
foverall_assetgrid.UpdateOpts(<?php echo $overall_asset_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($overall_asset->CurrentAction <> "gridadd" || $overall_asset->CurrentMode == "copy")
		if (!$overall_asset_grid->Recordset->EOF) $overall_asset_grid->Recordset->MoveNext();
}
?>
<?php
	if ($overall_asset->CurrentMode == "add" || $overall_asset->CurrentMode == "copy" || $overall_asset->CurrentMode == "edit") {
		$overall_asset_grid->RowIndex = '$rowindex$';
		$overall_asset_grid->LoadDefaultValues();

		// Set row properties
		$overall_asset->ResetAttrs();
		$overall_asset->RowAttrs = array_merge($overall_asset->RowAttrs, array('data-rowindex'=>$overall_asset_grid->RowIndex, 'id'=>'r0_overall_asset', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($overall_asset->RowAttrs["class"], "ewTemplate");
		$overall_asset->RowType = EW_ROWTYPE_ADD;

		// Render row
		$overall_asset_grid->RenderRow();

		// Render list options
		$overall_asset_grid->RenderListOptions();
		$overall_asset_grid->StartRowCnt = 0;
?>
	<tr<?php echo $overall_asset->RowAttributes() ?>>
<?php

// Render list options (body, left)
$overall_asset_grid->ListOptions->Render("body", "left", $overall_asset_grid->RowIndex);
?>
	<?php if ($overall_asset->id->Visible) { // id ?>
		<td>
<?php if ($overall_asset->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_overall_asset_id" class="control-group overall_asset_id">
<span<?php echo $overall_asset->id->ViewAttributes() ?>>
<?php echo $overall_asset->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $overall_asset_grid->RowIndex ?>_id" id="x<?php echo $overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($overall_asset->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $overall_asset_grid->RowIndex ?>_id" id="o<?php echo $overall_asset_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($overall_asset->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($overall_asset->beneficiaryid->Visible) { // beneficiaryid ?>
		<td>
<?php if ($overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_overall_asset_beneficiaryid" class="control-group overall_asset_beneficiaryid">
<input type="text" data-field="x_beneficiaryid" name="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" size="30" placeholder="<?php echo $overall_asset->beneficiaryid->PlaceHolder ?>" value="<?php echo $overall_asset->beneficiaryid->EditValue ?>"<?php echo $overall_asset->beneficiaryid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_overall_asset_beneficiaryid" class="control-group overall_asset_beneficiaryid">
<span<?php echo $overall_asset->beneficiaryid->ViewAttributes() ?>>
<?php echo $overall_asset->beneficiaryid->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_beneficiaryid" name="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="x<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($overall_asset->beneficiaryid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_beneficiaryid" name="o<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" id="o<?php echo $overall_asset_grid->RowIndex ?>_beneficiaryid" value="<?php echo ew_HtmlEncode($overall_asset->beneficiaryid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($overall_asset->propertyid->Visible) { // propertyid ?>
		<td>
<?php if ($overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_overall_asset_propertyid" class="control-group overall_asset_propertyid">
<input type="text" data-field="x_propertyid" name="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" size="30" placeholder="<?php echo $overall_asset->propertyid->PlaceHolder ?>" value="<?php echo $overall_asset->propertyid->EditValue ?>"<?php echo $overall_asset->propertyid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_overall_asset_propertyid" class="control-group overall_asset_propertyid">
<span<?php echo $overall_asset->propertyid->ViewAttributes() ?>>
<?php echo $overall_asset->propertyid->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_propertyid" name="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="x<?php echo $overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($overall_asset->propertyid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_propertyid" name="o<?php echo $overall_asset_grid->RowIndex ?>_propertyid" id="o<?php echo $overall_asset_grid->RowIndex ?>_propertyid" value="<?php echo ew_HtmlEncode($overall_asset->propertyid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($overall_asset->property_type->Visible) { // property_type ?>
		<td>
<?php if ($overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_overall_asset_property_type" class="control-group overall_asset_property_type">
<input type="text" data-field="x_property_type" name="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" size="30" maxlength="50" placeholder="<?php echo $overall_asset->property_type->PlaceHolder ?>" value="<?php echo $overall_asset->property_type->EditValue ?>"<?php echo $overall_asset->property_type->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_overall_asset_property_type" class="control-group overall_asset_property_type">
<span<?php echo $overall_asset->property_type->ViewAttributes() ?>>
<?php echo $overall_asset->property_type->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_property_type" name="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="x<?php echo $overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($overall_asset->property_type->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_property_type" name="o<?php echo $overall_asset_grid->RowIndex ?>_property_type" id="o<?php echo $overall_asset_grid->RowIndex ?>_property_type" value="<?php echo ew_HtmlEncode($overall_asset->property_type->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($overall_asset->percentage->Visible) { // percentage ?>
		<td>
<?php if ($overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_overall_asset_percentage" class="control-group overall_asset_percentage">
<input type="text" data-field="x_percentage" name="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" size="30" maxlength="5" placeholder="<?php echo $overall_asset->percentage->PlaceHolder ?>" value="<?php echo $overall_asset->percentage->EditValue ?>"<?php echo $overall_asset->percentage->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_overall_asset_percentage" class="control-group overall_asset_percentage">
<span<?php echo $overall_asset->percentage->ViewAttributes() ?>>
<?php echo $overall_asset->percentage->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_percentage" name="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="x<?php echo $overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($overall_asset->percentage->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_percentage" name="o<?php echo $overall_asset_grid->RowIndex ?>_percentage" id="o<?php echo $overall_asset_grid->RowIndex ?>_percentage" value="<?php echo ew_HtmlEncode($overall_asset->percentage->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($overall_asset->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($overall_asset->CurrentAction <> "F") { ?>
<span id="el$rowindex$_overall_asset_datecreated" class="control-group overall_asset_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" placeholder="<?php echo $overall_asset->datecreated->PlaceHolder ?>" value="<?php echo $overall_asset->datecreated->EditValue ?>"<?php echo $overall_asset->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_overall_asset_datecreated" class="control-group overall_asset_datecreated">
<span<?php echo $overall_asset->datecreated->ViewAttributes() ?>>
<?php echo $overall_asset->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="x<?php echo $overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($overall_asset->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $overall_asset_grid->RowIndex ?>_datecreated" id="o<?php echo $overall_asset_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($overall_asset->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$overall_asset_grid->ListOptions->Render("body", "right", $overall_asset_grid->RowCnt);
?>
<script type="text/javascript">
foverall_assetgrid.UpdateOpts(<?php echo $overall_asset_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($overall_asset->CurrentMode == "add" || $overall_asset->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $overall_asset_grid->FormKeyCountName ?>" id="<?php echo $overall_asset_grid->FormKeyCountName ?>" value="<?php echo $overall_asset_grid->KeyCount ?>">
<?php echo $overall_asset_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($overall_asset->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $overall_asset_grid->FormKeyCountName ?>" id="<?php echo $overall_asset_grid->FormKeyCountName ?>" value="<?php echo $overall_asset_grid->KeyCount ?>">
<?php echo $overall_asset_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($overall_asset->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="foverall_assetgrid">
</div>
<?php

// Close recordset
if ($overall_asset_grid->Recordset)
	$overall_asset_grid->Recordset->Close();
?>
<?php if ($overall_asset_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($overall_asset_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($overall_asset->Export == "") { ?>
<script type="text/javascript">
foverall_assetgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$overall_asset_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$overall_asset_grid->Page_Terminate();
?>
