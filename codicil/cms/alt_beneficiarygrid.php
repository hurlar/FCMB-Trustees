<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($alt_beneficiary_grid)) $alt_beneficiary_grid = new calt_beneficiary_grid();

// Page init
$alt_beneficiary_grid->Page_Init();

// Page main
$alt_beneficiary_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$alt_beneficiary_grid->Page_Render();
?>
<?php if ($alt_beneficiary->Export == "") { ?>
<script type="text/javascript">

// Page object
var alt_beneficiary_grid = new ew_Page("alt_beneficiary_grid");
alt_beneficiary_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = alt_beneficiary_grid.PageID; // For backward compatibility

// Form object
var falt_beneficiarygrid = new ew_Form("falt_beneficiarygrid");
falt_beneficiarygrid.FormKeyCountName = '<?php echo $alt_beneficiary_grid->FormKeyCountName ?>';

// Validate form
falt_beneficiarygrid.Validate = function() {
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
falt_beneficiarygrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "childid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fullname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "city", false)) return false;
	if (ew_ValueChanged(fobj, infix, "state", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
falt_beneficiarygrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
falt_beneficiarygrid.ValidateRequired = true;
<?php } else { ?>
falt_beneficiarygrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($alt_beneficiary->getCurrentMasterTable() == "" && $alt_beneficiary_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $alt_beneficiary_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($alt_beneficiary->CurrentAction == "gridadd") {
	if ($alt_beneficiary->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$alt_beneficiary_grid->TotalRecs = $alt_beneficiary->SelectRecordCount();
			$alt_beneficiary_grid->Recordset = $alt_beneficiary_grid->LoadRecordset($alt_beneficiary_grid->StartRec-1, $alt_beneficiary_grid->DisplayRecs);
		} else {
			if ($alt_beneficiary_grid->Recordset = $alt_beneficiary_grid->LoadRecordset())
				$alt_beneficiary_grid->TotalRecs = $alt_beneficiary_grid->Recordset->RecordCount();
		}
		$alt_beneficiary_grid->StartRec = 1;
		$alt_beneficiary_grid->DisplayRecs = $alt_beneficiary_grid->TotalRecs;
	} else {
		$alt_beneficiary->CurrentFilter = "0=1";
		$alt_beneficiary_grid->StartRec = 1;
		$alt_beneficiary_grid->DisplayRecs = $alt_beneficiary->GridAddRowCount;
	}
	$alt_beneficiary_grid->TotalRecs = $alt_beneficiary_grid->DisplayRecs;
	$alt_beneficiary_grid->StopRec = $alt_beneficiary_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$alt_beneficiary_grid->TotalRecs = $alt_beneficiary->SelectRecordCount();
	} else {
		if ($alt_beneficiary_grid->Recordset = $alt_beneficiary_grid->LoadRecordset())
			$alt_beneficiary_grid->TotalRecs = $alt_beneficiary_grid->Recordset->RecordCount();
	}
	$alt_beneficiary_grid->StartRec = 1;
	$alt_beneficiary_grid->DisplayRecs = $alt_beneficiary_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$alt_beneficiary_grid->Recordset = $alt_beneficiary_grid->LoadRecordset($alt_beneficiary_grid->StartRec-1, $alt_beneficiary_grid->DisplayRecs);
}
$alt_beneficiary_grid->RenderOtherOptions();
?>
<?php $alt_beneficiary_grid->ShowPageHeader(); ?>
<?php
$alt_beneficiary_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="falt_beneficiarygrid" class="ewForm form-horizontal">
<div id="gmp_alt_beneficiary" class="ewGridMiddlePanel">
<table id="tbl_alt_beneficiarygrid" class="ewTable ewTableSeparate">
<?php echo $alt_beneficiary->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$alt_beneficiary_grid->RenderListOptions();

// Render list options (header, left)
$alt_beneficiary_grid->ListOptions->Render("header", "left");
?>
<?php if ($alt_beneficiary->id->Visible) { // id ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->id) == "") { ?>
		<td><div id="elh_alt_beneficiary_id" class="alt_beneficiary_id"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_id" class="alt_beneficiary_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->childid->Visible) { // childid ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->childid) == "") { ?>
		<td><div id="elh_alt_beneficiary_childid" class="alt_beneficiary_childid"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->childid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_childid" class="alt_beneficiary_childid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->childid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->childid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->childid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->title->Visible) { // title ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->title) == "") { ?>
		<td><div id="elh_alt_beneficiary_title" class="alt_beneficiary_title"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_title" class="alt_beneficiary_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->fullname->Visible) { // fullname ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->fullname) == "") { ?>
		<td><div id="elh_alt_beneficiary_fullname" class="alt_beneficiary_fullname"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_fullname" class="alt_beneficiary_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->status->Visible) { // status ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->status) == "") { ?>
		<td><div id="elh_alt_beneficiary_status" class="alt_beneficiary_status"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->status->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_status" class="alt_beneficiary_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->_email->Visible) { // email ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->_email) == "") { ?>
		<td><div id="elh_alt_beneficiary__email" class="alt_beneficiary__email"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary__email" class="alt_beneficiary__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->phone->Visible) { // phone ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->phone) == "") { ?>
		<td><div id="elh_alt_beneficiary_phone" class="alt_beneficiary_phone"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_phone" class="alt_beneficiary_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->city->Visible) { // city ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->city) == "") { ?>
		<td><div id="elh_alt_beneficiary_city" class="alt_beneficiary_city"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->city->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_city" class="alt_beneficiary_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->city->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->city->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->city->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->state->Visible) { // state ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->state) == "") { ?>
		<td><div id="elh_alt_beneficiary_state" class="alt_beneficiary_state"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->state->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_state" class="alt_beneficiary_state">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->state->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->state->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->state->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($alt_beneficiary->datecreated->Visible) { // datecreated ?>
	<?php if ($alt_beneficiary->SortUrl($alt_beneficiary->datecreated) == "") { ?>
		<td><div id="elh_alt_beneficiary_datecreated" class="alt_beneficiary_datecreated"><div class="ewTableHeaderCaption"><?php echo $alt_beneficiary->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_alt_beneficiary_datecreated" class="alt_beneficiary_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $alt_beneficiary->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($alt_beneficiary->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($alt_beneficiary->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$alt_beneficiary_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$alt_beneficiary_grid->StartRec = 1;
$alt_beneficiary_grid->StopRec = $alt_beneficiary_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($alt_beneficiary_grid->FormKeyCountName) && ($alt_beneficiary->CurrentAction == "gridadd" || $alt_beneficiary->CurrentAction == "gridedit" || $alt_beneficiary->CurrentAction == "F")) {
		$alt_beneficiary_grid->KeyCount = $objForm->GetValue($alt_beneficiary_grid->FormKeyCountName);
		$alt_beneficiary_grid->StopRec = $alt_beneficiary_grid->StartRec + $alt_beneficiary_grid->KeyCount - 1;
	}
}
$alt_beneficiary_grid->RecCnt = $alt_beneficiary_grid->StartRec - 1;
if ($alt_beneficiary_grid->Recordset && !$alt_beneficiary_grid->Recordset->EOF) {
	$alt_beneficiary_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $alt_beneficiary_grid->StartRec > 1)
		$alt_beneficiary_grid->Recordset->Move($alt_beneficiary_grid->StartRec - 1);
} elseif (!$alt_beneficiary->AllowAddDeleteRow && $alt_beneficiary_grid->StopRec == 0) {
	$alt_beneficiary_grid->StopRec = $alt_beneficiary->GridAddRowCount;
}

// Initialize aggregate
$alt_beneficiary->RowType = EW_ROWTYPE_AGGREGATEINIT;
$alt_beneficiary->ResetAttrs();
$alt_beneficiary_grid->RenderRow();
if ($alt_beneficiary->CurrentAction == "gridadd")
	$alt_beneficiary_grid->RowIndex = 0;
if ($alt_beneficiary->CurrentAction == "gridedit")
	$alt_beneficiary_grid->RowIndex = 0;
while ($alt_beneficiary_grid->RecCnt < $alt_beneficiary_grid->StopRec) {
	$alt_beneficiary_grid->RecCnt++;
	if (intval($alt_beneficiary_grid->RecCnt) >= intval($alt_beneficiary_grid->StartRec)) {
		$alt_beneficiary_grid->RowCnt++;
		if ($alt_beneficiary->CurrentAction == "gridadd" || $alt_beneficiary->CurrentAction == "gridedit" || $alt_beneficiary->CurrentAction == "F") {
			$alt_beneficiary_grid->RowIndex++;
			$objForm->Index = $alt_beneficiary_grid->RowIndex;
			if ($objForm->HasValue($alt_beneficiary_grid->FormActionName))
				$alt_beneficiary_grid->RowAction = strval($objForm->GetValue($alt_beneficiary_grid->FormActionName));
			elseif ($alt_beneficiary->CurrentAction == "gridadd")
				$alt_beneficiary_grid->RowAction = "insert";
			else
				$alt_beneficiary_grid->RowAction = "";
		}

		// Set up key count
		$alt_beneficiary_grid->KeyCount = $alt_beneficiary_grid->RowIndex;

		// Init row class and style
		$alt_beneficiary->ResetAttrs();
		$alt_beneficiary->CssClass = "";
		if ($alt_beneficiary->CurrentAction == "gridadd") {
			if ($alt_beneficiary->CurrentMode == "copy") {
				$alt_beneficiary_grid->LoadRowValues($alt_beneficiary_grid->Recordset); // Load row values
				$alt_beneficiary_grid->SetRecordKey($alt_beneficiary_grid->RowOldKey, $alt_beneficiary_grid->Recordset); // Set old record key
			} else {
				$alt_beneficiary_grid->LoadDefaultValues(); // Load default values
				$alt_beneficiary_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$alt_beneficiary_grid->LoadRowValues($alt_beneficiary_grid->Recordset); // Load row values
		}
		$alt_beneficiary->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($alt_beneficiary->CurrentAction == "gridadd") // Grid add
			$alt_beneficiary->RowType = EW_ROWTYPE_ADD; // Render add
		if ($alt_beneficiary->CurrentAction == "gridadd" && $alt_beneficiary->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$alt_beneficiary_grid->RestoreCurrentRowFormValues($alt_beneficiary_grid->RowIndex); // Restore form values
		if ($alt_beneficiary->CurrentAction == "gridedit") { // Grid edit
			if ($alt_beneficiary->EventCancelled) {
				$alt_beneficiary_grid->RestoreCurrentRowFormValues($alt_beneficiary_grid->RowIndex); // Restore form values
			}
			if ($alt_beneficiary_grid->RowAction == "insert")
				$alt_beneficiary->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$alt_beneficiary->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($alt_beneficiary->CurrentAction == "gridedit" && ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT || $alt_beneficiary->RowType == EW_ROWTYPE_ADD) && $alt_beneficiary->EventCancelled) // Update failed
			$alt_beneficiary_grid->RestoreCurrentRowFormValues($alt_beneficiary_grid->RowIndex); // Restore form values
		if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) // Edit row
			$alt_beneficiary_grid->EditRowCnt++;
		if ($alt_beneficiary->CurrentAction == "F") // Confirm row
			$alt_beneficiary_grid->RestoreCurrentRowFormValues($alt_beneficiary_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$alt_beneficiary->RowAttrs = array_merge($alt_beneficiary->RowAttrs, array('data-rowindex'=>$alt_beneficiary_grid->RowCnt, 'id'=>'r' . $alt_beneficiary_grid->RowCnt . '_alt_beneficiary', 'data-rowtype'=>$alt_beneficiary->RowType));

		// Render row
		$alt_beneficiary_grid->RenderRow();

		// Render list options
		$alt_beneficiary_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($alt_beneficiary_grid->RowAction <> "delete" && $alt_beneficiary_grid->RowAction <> "insertdelete" && !($alt_beneficiary_grid->RowAction == "insert" && $alt_beneficiary->CurrentAction == "F" && $alt_beneficiary_grid->EmptyRow())) {
?>
	<tr<?php echo $alt_beneficiary->RowAttributes() ?>>
<?php

// Render list options (body, left)
$alt_beneficiary_grid->ListOptions->Render("body", "left", $alt_beneficiary_grid->RowCnt);
?>
	<?php if ($alt_beneficiary->id->Visible) { // id ?>
		<td<?php echo $alt_beneficiary->id->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_id" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($alt_beneficiary->id->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_id" class="control-group alt_beneficiary_id">
<span<?php echo $alt_beneficiary->id->ViewAttributes() ?>>
<?php echo $alt_beneficiary->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_id" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($alt_beneficiary->id->CurrentValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->id->ViewAttributes() ?>>
<?php echo $alt_beneficiary->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_id" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($alt_beneficiary->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_id" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($alt_beneficiary->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->childid->Visible) { // childid ?>
		<td<?php echo $alt_beneficiary->childid->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($alt_beneficiary->childid->getSessionValue() <> "") { ?>
<span<?php echo $alt_beneficiary->childid->ViewAttributes() ?>>
<?php echo $alt_beneficiary->childid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" size="30" maxlength="10" placeholder="<?php echo $alt_beneficiary->childid->PlaceHolder ?>" value="<?php echo $alt_beneficiary->childid->EditValue ?>"<?php echo $alt_beneficiary->childid->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_childid" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($alt_beneficiary->childid->getSessionValue() <> "") { ?>
<span<?php echo $alt_beneficiary->childid->ViewAttributes() ?>>
<?php echo $alt_beneficiary->childid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" size="30" maxlength="10" placeholder="<?php echo $alt_beneficiary->childid->PlaceHolder ?>" value="<?php echo $alt_beneficiary->childid->EditValue ?>"<?php echo $alt_beneficiary->childid->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->childid->ViewAttributes() ?>>
<?php echo $alt_beneficiary->childid->ListViewValue() ?></span>
<input type="hidden" data-field="x_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->FormValue) ?>">
<input type="hidden" data-field="x_childid" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->title->Visible) { // title ?>
		<td<?php echo $alt_beneficiary->title->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_title" class="control-group alt_beneficiary_title">
<input type="text" data-field="x_title" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->title->PlaceHolder ?>" value="<?php echo $alt_beneficiary->title->EditValue ?>"<?php echo $alt_beneficiary->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($alt_beneficiary->title->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_title" class="control-group alt_beneficiary_title">
<input type="text" data-field="x_title" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->title->PlaceHolder ?>" value="<?php echo $alt_beneficiary->title->EditValue ?>"<?php echo $alt_beneficiary->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->title->ViewAttributes() ?>>
<?php echo $alt_beneficiary->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($alt_beneficiary->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($alt_beneficiary->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->fullname->Visible) { // fullname ?>
		<td<?php echo $alt_beneficiary->fullname->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_fullname" class="control-group alt_beneficiary_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $alt_beneficiary->fullname->PlaceHolder ?>" value="<?php echo $alt_beneficiary->fullname->EditValue ?>"<?php echo $alt_beneficiary->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($alt_beneficiary->fullname->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_fullname" class="control-group alt_beneficiary_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $alt_beneficiary->fullname->PlaceHolder ?>" value="<?php echo $alt_beneficiary->fullname->EditValue ?>"<?php echo $alt_beneficiary->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->fullname->ViewAttributes() ?>>
<?php echo $alt_beneficiary->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($alt_beneficiary->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($alt_beneficiary->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->status->Visible) { // status ?>
		<td<?php echo $alt_beneficiary->status->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_status" class="control-group alt_beneficiary_status">
<input type="text" data-field="x_status" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->status->PlaceHolder ?>" value="<?php echo $alt_beneficiary->status->EditValue ?>"<?php echo $alt_beneficiary->status->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_status" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($alt_beneficiary->status->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_status" class="control-group alt_beneficiary_status">
<input type="text" data-field="x_status" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->status->PlaceHolder ?>" value="<?php echo $alt_beneficiary->status->EditValue ?>"<?php echo $alt_beneficiary->status->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->status->ViewAttributes() ?>>
<?php echo $alt_beneficiary->status->ListViewValue() ?></span>
<input type="hidden" data-field="x_status" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($alt_beneficiary->status->FormValue) ?>">
<input type="hidden" data-field="x_status" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($alt_beneficiary->status->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->_email->Visible) { // email ?>
		<td<?php echo $alt_beneficiary->_email->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary__email" class="control-group alt_beneficiary__email">
<input type="text" data-field="x__email" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $alt_beneficiary->_email->PlaceHolder ?>" value="<?php echo $alt_beneficiary->_email->EditValue ?>"<?php echo $alt_beneficiary->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($alt_beneficiary->_email->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary__email" class="control-group alt_beneficiary__email">
<input type="text" data-field="x__email" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $alt_beneficiary->_email->PlaceHolder ?>" value="<?php echo $alt_beneficiary->_email->EditValue ?>"<?php echo $alt_beneficiary->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->_email->ViewAttributes() ?>>
<?php echo $alt_beneficiary->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($alt_beneficiary->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($alt_beneficiary->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->phone->Visible) { // phone ?>
		<td<?php echo $alt_beneficiary->phone->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_phone" class="control-group alt_beneficiary_phone">
<input type="text" data-field="x_phone" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->phone->PlaceHolder ?>" value="<?php echo $alt_beneficiary->phone->EditValue ?>"<?php echo $alt_beneficiary->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($alt_beneficiary->phone->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_phone" class="control-group alt_beneficiary_phone">
<input type="text" data-field="x_phone" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->phone->PlaceHolder ?>" value="<?php echo $alt_beneficiary->phone->EditValue ?>"<?php echo $alt_beneficiary->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->phone->ViewAttributes() ?>>
<?php echo $alt_beneficiary->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($alt_beneficiary->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($alt_beneficiary->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->city->Visible) { // city ?>
		<td<?php echo $alt_beneficiary->city->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_city" class="control-group alt_beneficiary_city">
<input type="text" data-field="x_city" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->city->PlaceHolder ?>" value="<?php echo $alt_beneficiary->city->EditValue ?>"<?php echo $alt_beneficiary->city->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_city" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($alt_beneficiary->city->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_city" class="control-group alt_beneficiary_city">
<input type="text" data-field="x_city" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->city->PlaceHolder ?>" value="<?php echo $alt_beneficiary->city->EditValue ?>"<?php echo $alt_beneficiary->city->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->city->ViewAttributes() ?>>
<?php echo $alt_beneficiary->city->ListViewValue() ?></span>
<input type="hidden" data-field="x_city" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($alt_beneficiary->city->FormValue) ?>">
<input type="hidden" data-field="x_city" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($alt_beneficiary->city->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->state->Visible) { // state ?>
		<td<?php echo $alt_beneficiary->state->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_state" class="control-group alt_beneficiary_state">
<input type="text" data-field="x_state" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->state->PlaceHolder ?>" value="<?php echo $alt_beneficiary->state->EditValue ?>"<?php echo $alt_beneficiary->state->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_state" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($alt_beneficiary->state->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_state" class="control-group alt_beneficiary_state">
<input type="text" data-field="x_state" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->state->PlaceHolder ?>" value="<?php echo $alt_beneficiary->state->EditValue ?>"<?php echo $alt_beneficiary->state->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->state->ViewAttributes() ?>>
<?php echo $alt_beneficiary->state->ListViewValue() ?></span>
<input type="hidden" data-field="x_state" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($alt_beneficiary->state->FormValue) ?>">
<input type="hidden" data-field="x_state" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($alt_beneficiary->state->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($alt_beneficiary->datecreated->Visible) { // datecreated ?>
		<td<?php echo $alt_beneficiary->datecreated->CellAttributes() ?>>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_datecreated" class="control-group alt_beneficiary_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" placeholder="<?php echo $alt_beneficiary->datecreated->PlaceHolder ?>" value="<?php echo $alt_beneficiary->datecreated->EditValue ?>"<?php echo $alt_beneficiary->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($alt_beneficiary->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $alt_beneficiary_grid->RowCnt ?>_alt_beneficiary_datecreated" class="control-group alt_beneficiary_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" placeholder="<?php echo $alt_beneficiary->datecreated->PlaceHolder ?>" value="<?php echo $alt_beneficiary->datecreated->EditValue ?>"<?php echo $alt_beneficiary->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $alt_beneficiary->datecreated->ViewAttributes() ?>>
<?php echo $alt_beneficiary->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($alt_beneficiary->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($alt_beneficiary->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $alt_beneficiary_grid->PageObjName . "_row_" . $alt_beneficiary_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$alt_beneficiary_grid->ListOptions->Render("body", "right", $alt_beneficiary_grid->RowCnt);
?>
	</tr>
<?php if ($alt_beneficiary->RowType == EW_ROWTYPE_ADD || $alt_beneficiary->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
falt_beneficiarygrid.UpdateOpts(<?php echo $alt_beneficiary_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($alt_beneficiary->CurrentAction <> "gridadd" || $alt_beneficiary->CurrentMode == "copy")
		if (!$alt_beneficiary_grid->Recordset->EOF) $alt_beneficiary_grid->Recordset->MoveNext();
}
?>
<?php
	if ($alt_beneficiary->CurrentMode == "add" || $alt_beneficiary->CurrentMode == "copy" || $alt_beneficiary->CurrentMode == "edit") {
		$alt_beneficiary_grid->RowIndex = '$rowindex$';
		$alt_beneficiary_grid->LoadDefaultValues();

		// Set row properties
		$alt_beneficiary->ResetAttrs();
		$alt_beneficiary->RowAttrs = array_merge($alt_beneficiary->RowAttrs, array('data-rowindex'=>$alt_beneficiary_grid->RowIndex, 'id'=>'r0_alt_beneficiary', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($alt_beneficiary->RowAttrs["class"], "ewTemplate");
		$alt_beneficiary->RowType = EW_ROWTYPE_ADD;

		// Render row
		$alt_beneficiary_grid->RenderRow();

		// Render list options
		$alt_beneficiary_grid->RenderListOptions();
		$alt_beneficiary_grid->StartRowCnt = 0;
?>
	<tr<?php echo $alt_beneficiary->RowAttributes() ?>>
<?php

// Render list options (body, left)
$alt_beneficiary_grid->ListOptions->Render("body", "left", $alt_beneficiary_grid->RowIndex);
?>
	<?php if ($alt_beneficiary->id->Visible) { // id ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_id" class="control-group alt_beneficiary_id">
<span<?php echo $alt_beneficiary->id->ViewAttributes() ?>>
<?php echo $alt_beneficiary->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_id" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($alt_beneficiary->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_id" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($alt_beneficiary->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->childid->Visible) { // childid ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<?php if ($alt_beneficiary->childid->getSessionValue() <> "") { ?>
<span<?php echo $alt_beneficiary->childid->ViewAttributes() ?>>
<?php echo $alt_beneficiary->childid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" size="30" maxlength="10" placeholder="<?php echo $alt_beneficiary->childid->PlaceHolder ?>" value="<?php echo $alt_beneficiary->childid->EditValue ?>"<?php echo $alt_beneficiary->childid->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $alt_beneficiary->childid->ViewAttributes() ?>>
<?php echo $alt_beneficiary->childid->ViewValue ?></span>
<input type="hidden" data-field="x_childid" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_childid" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_childid" value="<?php echo ew_HtmlEncode($alt_beneficiary->childid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->title->Visible) { // title ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_title" class="control-group alt_beneficiary_title">
<input type="text" data-field="x_title" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->title->PlaceHolder ?>" value="<?php echo $alt_beneficiary->title->EditValue ?>"<?php echo $alt_beneficiary->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_title" class="control-group alt_beneficiary_title">
<span<?php echo $alt_beneficiary->title->ViewAttributes() ?>>
<?php echo $alt_beneficiary->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($alt_beneficiary->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_title" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($alt_beneficiary->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->fullname->Visible) { // fullname ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_fullname" class="control-group alt_beneficiary_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $alt_beneficiary->fullname->PlaceHolder ?>" value="<?php echo $alt_beneficiary->fullname->EditValue ?>"<?php echo $alt_beneficiary->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_fullname" class="control-group alt_beneficiary_fullname">
<span<?php echo $alt_beneficiary->fullname->ViewAttributes() ?>>
<?php echo $alt_beneficiary->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($alt_beneficiary->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($alt_beneficiary->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->status->Visible) { // status ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_status" class="control-group alt_beneficiary_status">
<input type="text" data-field="x_status" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->status->PlaceHolder ?>" value="<?php echo $alt_beneficiary->status->EditValue ?>"<?php echo $alt_beneficiary->status->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_status" class="control-group alt_beneficiary_status">
<span<?php echo $alt_beneficiary->status->ViewAttributes() ?>>
<?php echo $alt_beneficiary->status->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_status" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($alt_beneficiary->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_status" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_status" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($alt_beneficiary->status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->_email->Visible) { // email ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary__email" class="control-group alt_beneficiary__email">
<input type="text" data-field="x__email" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $alt_beneficiary->_email->PlaceHolder ?>" value="<?php echo $alt_beneficiary->_email->EditValue ?>"<?php echo $alt_beneficiary->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary__email" class="control-group alt_beneficiary__email">
<span<?php echo $alt_beneficiary->_email->ViewAttributes() ?>>
<?php echo $alt_beneficiary->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($alt_beneficiary->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>__email" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($alt_beneficiary->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->phone->Visible) { // phone ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_phone" class="control-group alt_beneficiary_phone">
<input type="text" data-field="x_phone" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->phone->PlaceHolder ?>" value="<?php echo $alt_beneficiary->phone->EditValue ?>"<?php echo $alt_beneficiary->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_phone" class="control-group alt_beneficiary_phone">
<span<?php echo $alt_beneficiary->phone->ViewAttributes() ?>>
<?php echo $alt_beneficiary->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($alt_beneficiary->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($alt_beneficiary->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->city->Visible) { // city ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_city" class="control-group alt_beneficiary_city">
<input type="text" data-field="x_city" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->city->PlaceHolder ?>" value="<?php echo $alt_beneficiary->city->EditValue ?>"<?php echo $alt_beneficiary->city->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_city" class="control-group alt_beneficiary_city">
<span<?php echo $alt_beneficiary->city->ViewAttributes() ?>>
<?php echo $alt_beneficiary->city->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_city" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($alt_beneficiary->city->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_city" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_city" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($alt_beneficiary->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->state->Visible) { // state ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_state" class="control-group alt_beneficiary_state">
<input type="text" data-field="x_state" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $alt_beneficiary->state->PlaceHolder ?>" value="<?php echo $alt_beneficiary->state->EditValue ?>"<?php echo $alt_beneficiary->state->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_state" class="control-group alt_beneficiary_state">
<span<?php echo $alt_beneficiary->state->ViewAttributes() ?>>
<?php echo $alt_beneficiary->state->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_state" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($alt_beneficiary->state->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_state" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_state" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($alt_beneficiary->state->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($alt_beneficiary->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($alt_beneficiary->CurrentAction <> "F") { ?>
<span id="el$rowindex$_alt_beneficiary_datecreated" class="control-group alt_beneficiary_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" placeholder="<?php echo $alt_beneficiary->datecreated->PlaceHolder ?>" value="<?php echo $alt_beneficiary->datecreated->EditValue ?>"<?php echo $alt_beneficiary->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_alt_beneficiary_datecreated" class="control-group alt_beneficiary_datecreated">
<span<?php echo $alt_beneficiary->datecreated->ViewAttributes() ?>>
<?php echo $alt_beneficiary->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="x<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($alt_beneficiary->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" id="o<?php echo $alt_beneficiary_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($alt_beneficiary->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$alt_beneficiary_grid->ListOptions->Render("body", "right", $alt_beneficiary_grid->RowCnt);
?>
<script type="text/javascript">
falt_beneficiarygrid.UpdateOpts(<?php echo $alt_beneficiary_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($alt_beneficiary->CurrentMode == "add" || $alt_beneficiary->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $alt_beneficiary_grid->FormKeyCountName ?>" id="<?php echo $alt_beneficiary_grid->FormKeyCountName ?>" value="<?php echo $alt_beneficiary_grid->KeyCount ?>">
<?php echo $alt_beneficiary_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($alt_beneficiary->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $alt_beneficiary_grid->FormKeyCountName ?>" id="<?php echo $alt_beneficiary_grid->FormKeyCountName ?>" value="<?php echo $alt_beneficiary_grid->KeyCount ?>">
<?php echo $alt_beneficiary_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($alt_beneficiary->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="falt_beneficiarygrid">
</div>
<?php

// Close recordset
if ($alt_beneficiary_grid->Recordset)
	$alt_beneficiary_grid->Recordset->Close();
?>
<?php if ($alt_beneficiary_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($alt_beneficiary_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($alt_beneficiary->Export == "") { ?>
<script type="text/javascript">
falt_beneficiarygrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$alt_beneficiary_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$alt_beneficiary_grid->Page_Terminate();
?>
