<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($beneficiary_dump_grid)) $beneficiary_dump_grid = new cbeneficiary_dump_grid();

// Page init
$beneficiary_dump_grid->Page_Init();

// Page main
$beneficiary_dump_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$beneficiary_dump_grid->Page_Render();
?>
<?php if ($beneficiary_dump->Export == "") { ?>
<script type="text/javascript">

// Page object
var beneficiary_dump_grid = new ew_Page("beneficiary_dump_grid");
beneficiary_dump_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = beneficiary_dump_grid.PageID; // For backward compatibility

// Form object
var fbeneficiary_dumpgrid = new ew_Form("fbeneficiary_dumpgrid");
fbeneficiary_dumpgrid.FormKeyCountName = '<?php echo $beneficiary_dump_grid->FormKeyCountName ?>';

// Validate form
fbeneficiary_dumpgrid.Validate = function() {
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
fbeneficiary_dumpgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fullname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rtionship", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "city", false)) return false;
	if (ew_ValueChanged(fobj, infix, "state", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fbeneficiary_dumpgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbeneficiary_dumpgrid.ValidateRequired = true;
<?php } else { ?>
fbeneficiary_dumpgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($beneficiary_dump->getCurrentMasterTable() == "" && $beneficiary_dump_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $beneficiary_dump_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($beneficiary_dump->CurrentAction == "gridadd") {
	if ($beneficiary_dump->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$beneficiary_dump_grid->TotalRecs = $beneficiary_dump->SelectRecordCount();
			$beneficiary_dump_grid->Recordset = $beneficiary_dump_grid->LoadRecordset($beneficiary_dump_grid->StartRec-1, $beneficiary_dump_grid->DisplayRecs);
		} else {
			if ($beneficiary_dump_grid->Recordset = $beneficiary_dump_grid->LoadRecordset())
				$beneficiary_dump_grid->TotalRecs = $beneficiary_dump_grid->Recordset->RecordCount();
		}
		$beneficiary_dump_grid->StartRec = 1;
		$beneficiary_dump_grid->DisplayRecs = $beneficiary_dump_grid->TotalRecs;
	} else {
		$beneficiary_dump->CurrentFilter = "0=1";
		$beneficiary_dump_grid->StartRec = 1;
		$beneficiary_dump_grid->DisplayRecs = $beneficiary_dump->GridAddRowCount;
	}
	$beneficiary_dump_grid->TotalRecs = $beneficiary_dump_grid->DisplayRecs;
	$beneficiary_dump_grid->StopRec = $beneficiary_dump_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$beneficiary_dump_grid->TotalRecs = $beneficiary_dump->SelectRecordCount();
	} else {
		if ($beneficiary_dump_grid->Recordset = $beneficiary_dump_grid->LoadRecordset())
			$beneficiary_dump_grid->TotalRecs = $beneficiary_dump_grid->Recordset->RecordCount();
	}
	$beneficiary_dump_grid->StartRec = 1;
	$beneficiary_dump_grid->DisplayRecs = $beneficiary_dump_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$beneficiary_dump_grid->Recordset = $beneficiary_dump_grid->LoadRecordset($beneficiary_dump_grid->StartRec-1, $beneficiary_dump_grid->DisplayRecs);
}
$beneficiary_dump_grid->RenderOtherOptions();
?>
<?php $beneficiary_dump_grid->ShowPageHeader(); ?>
<?php
$beneficiary_dump_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fbeneficiary_dumpgrid" class="ewForm form-horizontal">
<div id="gmp_beneficiary_dump" class="ewGridMiddlePanel">
<table id="tbl_beneficiary_dumpgrid" class="ewTable ewTableSeparate">
<?php echo $beneficiary_dump->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$beneficiary_dump_grid->RenderListOptions();

// Render list options (header, left)
$beneficiary_dump_grid->ListOptions->Render("header", "left");
?>
<?php if ($beneficiary_dump->title->Visible) { // title ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->title) == "") { ?>
		<td><div id="elh_beneficiary_dump_title" class="beneficiary_dump_title"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_title" class="beneficiary_dump_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->fullname->Visible) { // fullname ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->fullname) == "") { ?>
		<td><div id="elh_beneficiary_dump_fullname" class="beneficiary_dump_fullname"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_fullname" class="beneficiary_dump_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->rtionship->Visible) { // rtionship ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->rtionship) == "") { ?>
		<td><div id="elh_beneficiary_dump_rtionship" class="beneficiary_dump_rtionship"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->rtionship->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_rtionship" class="beneficiary_dump_rtionship">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->rtionship->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->rtionship->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->rtionship->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->_email->Visible) { // email ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->_email) == "") { ?>
		<td><div id="elh_beneficiary_dump__email" class="beneficiary_dump__email"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump__email" class="beneficiary_dump__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->phone->Visible) { // phone ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->phone) == "") { ?>
		<td><div id="elh_beneficiary_dump_phone" class="beneficiary_dump_phone"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_phone" class="beneficiary_dump_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->city->Visible) { // city ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->city) == "") { ?>
		<td><div id="elh_beneficiary_dump_city" class="beneficiary_dump_city"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->city->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_city" class="beneficiary_dump_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->city->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->city->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->city->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->state->Visible) { // state ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->state) == "") { ?>
		<td><div id="elh_beneficiary_dump_state" class="beneficiary_dump_state"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->state->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_state" class="beneficiary_dump_state">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->state->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->state->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->state->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($beneficiary_dump->datecreated->Visible) { // datecreated ?>
	<?php if ($beneficiary_dump->SortUrl($beneficiary_dump->datecreated) == "") { ?>
		<td><div id="elh_beneficiary_dump_datecreated" class="beneficiary_dump_datecreated"><div class="ewTableHeaderCaption"><?php echo $beneficiary_dump->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_beneficiary_dump_datecreated" class="beneficiary_dump_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $beneficiary_dump->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($beneficiary_dump->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($beneficiary_dump->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$beneficiary_dump_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$beneficiary_dump_grid->StartRec = 1;
$beneficiary_dump_grid->StopRec = $beneficiary_dump_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($beneficiary_dump_grid->FormKeyCountName) && ($beneficiary_dump->CurrentAction == "gridadd" || $beneficiary_dump->CurrentAction == "gridedit" || $beneficiary_dump->CurrentAction == "F")) {
		$beneficiary_dump_grid->KeyCount = $objForm->GetValue($beneficiary_dump_grid->FormKeyCountName);
		$beneficiary_dump_grid->StopRec = $beneficiary_dump_grid->StartRec + $beneficiary_dump_grid->KeyCount - 1;
	}
}
$beneficiary_dump_grid->RecCnt = $beneficiary_dump_grid->StartRec - 1;
if ($beneficiary_dump_grid->Recordset && !$beneficiary_dump_grid->Recordset->EOF) {
	$beneficiary_dump_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $beneficiary_dump_grid->StartRec > 1)
		$beneficiary_dump_grid->Recordset->Move($beneficiary_dump_grid->StartRec - 1);
} elseif (!$beneficiary_dump->AllowAddDeleteRow && $beneficiary_dump_grid->StopRec == 0) {
	$beneficiary_dump_grid->StopRec = $beneficiary_dump->GridAddRowCount;
}

// Initialize aggregate
$beneficiary_dump->RowType = EW_ROWTYPE_AGGREGATEINIT;
$beneficiary_dump->ResetAttrs();
$beneficiary_dump_grid->RenderRow();
if ($beneficiary_dump->CurrentAction == "gridadd")
	$beneficiary_dump_grid->RowIndex = 0;
if ($beneficiary_dump->CurrentAction == "gridedit")
	$beneficiary_dump_grid->RowIndex = 0;
while ($beneficiary_dump_grid->RecCnt < $beneficiary_dump_grid->StopRec) {
	$beneficiary_dump_grid->RecCnt++;
	if (intval($beneficiary_dump_grid->RecCnt) >= intval($beneficiary_dump_grid->StartRec)) {
		$beneficiary_dump_grid->RowCnt++;
		if ($beneficiary_dump->CurrentAction == "gridadd" || $beneficiary_dump->CurrentAction == "gridedit" || $beneficiary_dump->CurrentAction == "F") {
			$beneficiary_dump_grid->RowIndex++;
			$objForm->Index = $beneficiary_dump_grid->RowIndex;
			if ($objForm->HasValue($beneficiary_dump_grid->FormActionName))
				$beneficiary_dump_grid->RowAction = strval($objForm->GetValue($beneficiary_dump_grid->FormActionName));
			elseif ($beneficiary_dump->CurrentAction == "gridadd")
				$beneficiary_dump_grid->RowAction = "insert";
			else
				$beneficiary_dump_grid->RowAction = "";
		}

		// Set up key count
		$beneficiary_dump_grid->KeyCount = $beneficiary_dump_grid->RowIndex;

		// Init row class and style
		$beneficiary_dump->ResetAttrs();
		$beneficiary_dump->CssClass = "";
		if ($beneficiary_dump->CurrentAction == "gridadd") {
			if ($beneficiary_dump->CurrentMode == "copy") {
				$beneficiary_dump_grid->LoadRowValues($beneficiary_dump_grid->Recordset); // Load row values
				$beneficiary_dump_grid->SetRecordKey($beneficiary_dump_grid->RowOldKey, $beneficiary_dump_grid->Recordset); // Set old record key
			} else {
				$beneficiary_dump_grid->LoadDefaultValues(); // Load default values
				$beneficiary_dump_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$beneficiary_dump_grid->LoadRowValues($beneficiary_dump_grid->Recordset); // Load row values
		}
		$beneficiary_dump->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($beneficiary_dump->CurrentAction == "gridadd") // Grid add
			$beneficiary_dump->RowType = EW_ROWTYPE_ADD; // Render add
		if ($beneficiary_dump->CurrentAction == "gridadd" && $beneficiary_dump->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$beneficiary_dump_grid->RestoreCurrentRowFormValues($beneficiary_dump_grid->RowIndex); // Restore form values
		if ($beneficiary_dump->CurrentAction == "gridedit") { // Grid edit
			if ($beneficiary_dump->EventCancelled) {
				$beneficiary_dump_grid->RestoreCurrentRowFormValues($beneficiary_dump_grid->RowIndex); // Restore form values
			}
			if ($beneficiary_dump_grid->RowAction == "insert")
				$beneficiary_dump->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$beneficiary_dump->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($beneficiary_dump->CurrentAction == "gridedit" && ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT || $beneficiary_dump->RowType == EW_ROWTYPE_ADD) && $beneficiary_dump->EventCancelled) // Update failed
			$beneficiary_dump_grid->RestoreCurrentRowFormValues($beneficiary_dump_grid->RowIndex); // Restore form values
		if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) // Edit row
			$beneficiary_dump_grid->EditRowCnt++;
		if ($beneficiary_dump->CurrentAction == "F") // Confirm row
			$beneficiary_dump_grid->RestoreCurrentRowFormValues($beneficiary_dump_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$beneficiary_dump->RowAttrs = array_merge($beneficiary_dump->RowAttrs, array('data-rowindex'=>$beneficiary_dump_grid->RowCnt, 'id'=>'r' . $beneficiary_dump_grid->RowCnt . '_beneficiary_dump', 'data-rowtype'=>$beneficiary_dump->RowType));

		// Render row
		$beneficiary_dump_grid->RenderRow();

		// Render list options
		$beneficiary_dump_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($beneficiary_dump_grid->RowAction <> "delete" && $beneficiary_dump_grid->RowAction <> "insertdelete" && !($beneficiary_dump_grid->RowAction == "insert" && $beneficiary_dump->CurrentAction == "F" && $beneficiary_dump_grid->EmptyRow())) {
?>
	<tr<?php echo $beneficiary_dump->RowAttributes() ?>>
<?php

// Render list options (body, left)
$beneficiary_dump_grid->ListOptions->Render("body", "left", $beneficiary_dump_grid->RowCnt);
?>
	<?php if ($beneficiary_dump->title->Visible) { // title ?>
		<td<?php echo $beneficiary_dump->title->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_title" class="control-group beneficiary_dump_title">
<input type="text" data-field="x_title" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->title->PlaceHolder ?>" value="<?php echo $beneficiary_dump->title->EditValue ?>"<?php echo $beneficiary_dump->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($beneficiary_dump->title->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_title" class="control-group beneficiary_dump_title">
<input type="text" data-field="x_title" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->title->PlaceHolder ?>" value="<?php echo $beneficiary_dump->title->EditValue ?>"<?php echo $beneficiary_dump->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->title->ViewAttributes() ?>>
<?php echo $beneficiary_dump->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($beneficiary_dump->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($beneficiary_dump->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_id" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($beneficiary_dump->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_id" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($beneficiary_dump->id->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT || $beneficiary_dump->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_id" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($beneficiary_dump->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($beneficiary_dump->fullname->Visible) { // fullname ?>
		<td<?php echo $beneficiary_dump->fullname->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_fullname" class="control-group beneficiary_dump_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->fullname->PlaceHolder ?>" value="<?php echo $beneficiary_dump->fullname->EditValue ?>"<?php echo $beneficiary_dump->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($beneficiary_dump->fullname->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_fullname" class="control-group beneficiary_dump_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->fullname->PlaceHolder ?>" value="<?php echo $beneficiary_dump->fullname->EditValue ?>"<?php echo $beneficiary_dump->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->fullname->ViewAttributes() ?>>
<?php echo $beneficiary_dump->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($beneficiary_dump->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($beneficiary_dump->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($beneficiary_dump->rtionship->Visible) { // rtionship ?>
		<td<?php echo $beneficiary_dump->rtionship->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_rtionship" class="control-group beneficiary_dump_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->rtionship->PlaceHolder ?>" value="<?php echo $beneficiary_dump->rtionship->EditValue ?>"<?php echo $beneficiary_dump->rtionship->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($beneficiary_dump->rtionship->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_rtionship" class="control-group beneficiary_dump_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->rtionship->PlaceHolder ?>" value="<?php echo $beneficiary_dump->rtionship->EditValue ?>"<?php echo $beneficiary_dump->rtionship->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->rtionship->ViewAttributes() ?>>
<?php echo $beneficiary_dump->rtionship->ListViewValue() ?></span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($beneficiary_dump->rtionship->FormValue) ?>">
<input type="hidden" data-field="x_rtionship" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($beneficiary_dump->rtionship->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($beneficiary_dump->_email->Visible) { // email ?>
		<td<?php echo $beneficiary_dump->_email->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump__email" class="control-group beneficiary_dump__email">
<input type="text" data-field="x__email" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->_email->PlaceHolder ?>" value="<?php echo $beneficiary_dump->_email->EditValue ?>"<?php echo $beneficiary_dump->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($beneficiary_dump->_email->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump__email" class="control-group beneficiary_dump__email">
<input type="text" data-field="x__email" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->_email->PlaceHolder ?>" value="<?php echo $beneficiary_dump->_email->EditValue ?>"<?php echo $beneficiary_dump->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->_email->ViewAttributes() ?>>
<?php echo $beneficiary_dump->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($beneficiary_dump->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($beneficiary_dump->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($beneficiary_dump->phone->Visible) { // phone ?>
		<td<?php echo $beneficiary_dump->phone->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_phone" class="control-group beneficiary_dump_phone">
<input type="text" data-field="x_phone" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->phone->PlaceHolder ?>" value="<?php echo $beneficiary_dump->phone->EditValue ?>"<?php echo $beneficiary_dump->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($beneficiary_dump->phone->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_phone" class="control-group beneficiary_dump_phone">
<input type="text" data-field="x_phone" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->phone->PlaceHolder ?>" value="<?php echo $beneficiary_dump->phone->EditValue ?>"<?php echo $beneficiary_dump->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->phone->ViewAttributes() ?>>
<?php echo $beneficiary_dump->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($beneficiary_dump->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($beneficiary_dump->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($beneficiary_dump->city->Visible) { // city ?>
		<td<?php echo $beneficiary_dump->city->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_city" class="control-group beneficiary_dump_city">
<input type="text" data-field="x_city" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->city->PlaceHolder ?>" value="<?php echo $beneficiary_dump->city->EditValue ?>"<?php echo $beneficiary_dump->city->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_city" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($beneficiary_dump->city->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_city" class="control-group beneficiary_dump_city">
<input type="text" data-field="x_city" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->city->PlaceHolder ?>" value="<?php echo $beneficiary_dump->city->EditValue ?>"<?php echo $beneficiary_dump->city->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->city->ViewAttributes() ?>>
<?php echo $beneficiary_dump->city->ListViewValue() ?></span>
<input type="hidden" data-field="x_city" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($beneficiary_dump->city->FormValue) ?>">
<input type="hidden" data-field="x_city" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($beneficiary_dump->city->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($beneficiary_dump->state->Visible) { // state ?>
		<td<?php echo $beneficiary_dump->state->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_state" class="control-group beneficiary_dump_state">
<input type="text" data-field="x_state" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->state->PlaceHolder ?>" value="<?php echo $beneficiary_dump->state->EditValue ?>"<?php echo $beneficiary_dump->state->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_state" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($beneficiary_dump->state->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_state" class="control-group beneficiary_dump_state">
<input type="text" data-field="x_state" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->state->PlaceHolder ?>" value="<?php echo $beneficiary_dump->state->EditValue ?>"<?php echo $beneficiary_dump->state->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->state->ViewAttributes() ?>>
<?php echo $beneficiary_dump->state->ListViewValue() ?></span>
<input type="hidden" data-field="x_state" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($beneficiary_dump->state->FormValue) ?>">
<input type="hidden" data-field="x_state" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($beneficiary_dump->state->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($beneficiary_dump->datecreated->Visible) { // datecreated ?>
		<td<?php echo $beneficiary_dump->datecreated->CellAttributes() ?>>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_datecreated" class="control-group beneficiary_dump_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" placeholder="<?php echo $beneficiary_dump->datecreated->PlaceHolder ?>" value="<?php echo $beneficiary_dump->datecreated->EditValue ?>"<?php echo $beneficiary_dump->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($beneficiary_dump->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $beneficiary_dump_grid->RowCnt ?>_beneficiary_dump_datecreated" class="control-group beneficiary_dump_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" placeholder="<?php echo $beneficiary_dump->datecreated->PlaceHolder ?>" value="<?php echo $beneficiary_dump->datecreated->EditValue ?>"<?php echo $beneficiary_dump->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $beneficiary_dump->datecreated->ViewAttributes() ?>>
<?php echo $beneficiary_dump->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($beneficiary_dump->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($beneficiary_dump->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $beneficiary_dump_grid->PageObjName . "_row_" . $beneficiary_dump_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$beneficiary_dump_grid->ListOptions->Render("body", "right", $beneficiary_dump_grid->RowCnt);
?>
	</tr>
<?php if ($beneficiary_dump->RowType == EW_ROWTYPE_ADD || $beneficiary_dump->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fbeneficiary_dumpgrid.UpdateOpts(<?php echo $beneficiary_dump_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($beneficiary_dump->CurrentAction <> "gridadd" || $beneficiary_dump->CurrentMode == "copy")
		if (!$beneficiary_dump_grid->Recordset->EOF) $beneficiary_dump_grid->Recordset->MoveNext();
}
?>
<?php
	if ($beneficiary_dump->CurrentMode == "add" || $beneficiary_dump->CurrentMode == "copy" || $beneficiary_dump->CurrentMode == "edit") {
		$beneficiary_dump_grid->RowIndex = '$rowindex$';
		$beneficiary_dump_grid->LoadDefaultValues();

		// Set row properties
		$beneficiary_dump->ResetAttrs();
		$beneficiary_dump->RowAttrs = array_merge($beneficiary_dump->RowAttrs, array('data-rowindex'=>$beneficiary_dump_grid->RowIndex, 'id'=>'r0_beneficiary_dump', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($beneficiary_dump->RowAttrs["class"], "ewTemplate");
		$beneficiary_dump->RowType = EW_ROWTYPE_ADD;

		// Render row
		$beneficiary_dump_grid->RenderRow();

		// Render list options
		$beneficiary_dump_grid->RenderListOptions();
		$beneficiary_dump_grid->StartRowCnt = 0;
?>
	<tr<?php echo $beneficiary_dump->RowAttributes() ?>>
<?php

// Render list options (body, left)
$beneficiary_dump_grid->ListOptions->Render("body", "left", $beneficiary_dump_grid->RowIndex);
?>
	<?php if ($beneficiary_dump->title->Visible) { // title ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_title" class="control-group beneficiary_dump_title">
<input type="text" data-field="x_title" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->title->PlaceHolder ?>" value="<?php echo $beneficiary_dump->title->EditValue ?>"<?php echo $beneficiary_dump->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_title" class="control-group beneficiary_dump_title">
<span<?php echo $beneficiary_dump->title->ViewAttributes() ?>>
<?php echo $beneficiary_dump->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($beneficiary_dump->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_title" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($beneficiary_dump->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->fullname->Visible) { // fullname ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_fullname" class="control-group beneficiary_dump_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->fullname->PlaceHolder ?>" value="<?php echo $beneficiary_dump->fullname->EditValue ?>"<?php echo $beneficiary_dump->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_fullname" class="control-group beneficiary_dump_fullname">
<span<?php echo $beneficiary_dump->fullname->ViewAttributes() ?>>
<?php echo $beneficiary_dump->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($beneficiary_dump->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($beneficiary_dump->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->rtionship->Visible) { // rtionship ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_rtionship" class="control-group beneficiary_dump_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->rtionship->PlaceHolder ?>" value="<?php echo $beneficiary_dump->rtionship->EditValue ?>"<?php echo $beneficiary_dump->rtionship->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_rtionship" class="control-group beneficiary_dump_rtionship">
<span<?php echo $beneficiary_dump->rtionship->ViewAttributes() ?>>
<?php echo $beneficiary_dump->rtionship->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($beneficiary_dump->rtionship->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($beneficiary_dump->rtionship->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->_email->Visible) { // email ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump__email" class="control-group beneficiary_dump__email">
<input type="text" data-field="x__email" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $beneficiary_dump->_email->PlaceHolder ?>" value="<?php echo $beneficiary_dump->_email->EditValue ?>"<?php echo $beneficiary_dump->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump__email" class="control-group beneficiary_dump__email">
<span<?php echo $beneficiary_dump->_email->ViewAttributes() ?>>
<?php echo $beneficiary_dump->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($beneficiary_dump->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>__email" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($beneficiary_dump->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->phone->Visible) { // phone ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_phone" class="control-group beneficiary_dump_phone">
<input type="text" data-field="x_phone" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->phone->PlaceHolder ?>" value="<?php echo $beneficiary_dump->phone->EditValue ?>"<?php echo $beneficiary_dump->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_phone" class="control-group beneficiary_dump_phone">
<span<?php echo $beneficiary_dump->phone->ViewAttributes() ?>>
<?php echo $beneficiary_dump->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($beneficiary_dump->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($beneficiary_dump->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->city->Visible) { // city ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_city" class="control-group beneficiary_dump_city">
<input type="text" data-field="x_city" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->city->PlaceHolder ?>" value="<?php echo $beneficiary_dump->city->EditValue ?>"<?php echo $beneficiary_dump->city->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_city" class="control-group beneficiary_dump_city">
<span<?php echo $beneficiary_dump->city->ViewAttributes() ?>>
<?php echo $beneficiary_dump->city->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_city" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($beneficiary_dump->city->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_city" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_city" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($beneficiary_dump->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->state->Visible) { // state ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_state" class="control-group beneficiary_dump_state">
<input type="text" data-field="x_state" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $beneficiary_dump->state->PlaceHolder ?>" value="<?php echo $beneficiary_dump->state->EditValue ?>"<?php echo $beneficiary_dump->state->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_state" class="control-group beneficiary_dump_state">
<span<?php echo $beneficiary_dump->state->ViewAttributes() ?>>
<?php echo $beneficiary_dump->state->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_state" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($beneficiary_dump->state->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_state" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_state" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($beneficiary_dump->state->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($beneficiary_dump->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($beneficiary_dump->CurrentAction <> "F") { ?>
<span id="el$rowindex$_beneficiary_dump_datecreated" class="control-group beneficiary_dump_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" placeholder="<?php echo $beneficiary_dump->datecreated->PlaceHolder ?>" value="<?php echo $beneficiary_dump->datecreated->EditValue ?>"<?php echo $beneficiary_dump->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_beneficiary_dump_datecreated" class="control-group beneficiary_dump_datecreated">
<span<?php echo $beneficiary_dump->datecreated->ViewAttributes() ?>>
<?php echo $beneficiary_dump->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="x<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($beneficiary_dump->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" id="o<?php echo $beneficiary_dump_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($beneficiary_dump->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$beneficiary_dump_grid->ListOptions->Render("body", "right", $beneficiary_dump_grid->RowCnt);
?>
<script type="text/javascript">
fbeneficiary_dumpgrid.UpdateOpts(<?php echo $beneficiary_dump_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($beneficiary_dump->CurrentMode == "add" || $beneficiary_dump->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $beneficiary_dump_grid->FormKeyCountName ?>" id="<?php echo $beneficiary_dump_grid->FormKeyCountName ?>" value="<?php echo $beneficiary_dump_grid->KeyCount ?>">
<?php echo $beneficiary_dump_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($beneficiary_dump->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $beneficiary_dump_grid->FormKeyCountName ?>" id="<?php echo $beneficiary_dump_grid->FormKeyCountName ?>" value="<?php echo $beneficiary_dump_grid->KeyCount ?>">
<?php echo $beneficiary_dump_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($beneficiary_dump->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbeneficiary_dumpgrid">
</div>
<?php

// Close recordset
if ($beneficiary_dump_grid->Recordset)
	$beneficiary_dump_grid->Recordset->Close();
?>
<?php if ($beneficiary_dump_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($beneficiary_dump_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($beneficiary_dump->Export == "") { ?>
<script type="text/javascript">
fbeneficiary_dumpgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$beneficiary_dump_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$beneficiary_dump_grid->Page_Terminate();
?>
