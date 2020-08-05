<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($nextofkin_grid)) $nextofkin_grid = new cnextofkin_grid();

// Page init
$nextofkin_grid->Page_Init();

// Page main
$nextofkin_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$nextofkin_grid->Page_Render();
?>
<?php if ($nextofkin->Export == "") { ?>
<script type="text/javascript">

// Page object
var nextofkin_grid = new ew_Page("nextofkin_grid");
nextofkin_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = nextofkin_grid.PageID; // For backward compatibility

// Form object
var fnextofkingrid = new ew_Form("fnextofkingrid");
fnextofkingrid.FormKeyCountName = '<?php echo $nextofkin_grid->FormKeyCountName ?>';

// Validate form
fnextofkingrid.Validate = function() {
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
fnextofkingrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "fullname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "telephone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dateposted", false)) return false;
	return true;
}

// Form_CustomValidate event
fnextofkingrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnextofkingrid.ValidateRequired = true;
<?php } else { ?>
fnextofkingrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($nextofkin->getCurrentMasterTable() == "" && $nextofkin_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $nextofkin_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($nextofkin->CurrentAction == "gridadd") {
	if ($nextofkin->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$nextofkin_grid->TotalRecs = $nextofkin->SelectRecordCount();
			$nextofkin_grid->Recordset = $nextofkin_grid->LoadRecordset($nextofkin_grid->StartRec-1, $nextofkin_grid->DisplayRecs);
		} else {
			if ($nextofkin_grid->Recordset = $nextofkin_grid->LoadRecordset())
				$nextofkin_grid->TotalRecs = $nextofkin_grid->Recordset->RecordCount();
		}
		$nextofkin_grid->StartRec = 1;
		$nextofkin_grid->DisplayRecs = $nextofkin_grid->TotalRecs;
	} else {
		$nextofkin->CurrentFilter = "0=1";
		$nextofkin_grid->StartRec = 1;
		$nextofkin_grid->DisplayRecs = $nextofkin->GridAddRowCount;
	}
	$nextofkin_grid->TotalRecs = $nextofkin_grid->DisplayRecs;
	$nextofkin_grid->StopRec = $nextofkin_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$nextofkin_grid->TotalRecs = $nextofkin->SelectRecordCount();
	} else {
		if ($nextofkin_grid->Recordset = $nextofkin_grid->LoadRecordset())
			$nextofkin_grid->TotalRecs = $nextofkin_grid->Recordset->RecordCount();
	}
	$nextofkin_grid->StartRec = 1;
	$nextofkin_grid->DisplayRecs = $nextofkin_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$nextofkin_grid->Recordset = $nextofkin_grid->LoadRecordset($nextofkin_grid->StartRec-1, $nextofkin_grid->DisplayRecs);
}
$nextofkin_grid->RenderOtherOptions();
?>
<?php $nextofkin_grid->ShowPageHeader(); ?>
<?php
$nextofkin_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fnextofkingrid" class="ewForm form-horizontal">
<div id="gmp_nextofkin" class="ewGridMiddlePanel">
<table id="tbl_nextofkingrid" class="ewTable ewTableSeparate">
<?php echo $nextofkin->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$nextofkin_grid->RenderListOptions();

// Render list options (header, left)
$nextofkin_grid->ListOptions->Render("header", "left");
?>
<?php if ($nextofkin->fullname->Visible) { // fullname ?>
	<?php if ($nextofkin->SortUrl($nextofkin->fullname) == "") { ?>
		<td><div id="elh_nextofkin_fullname" class="nextofkin_fullname"><div class="ewTableHeaderCaption"><?php echo $nextofkin->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_nextofkin_fullname" class="nextofkin_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nextofkin->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nextofkin->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nextofkin->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($nextofkin->telephone->Visible) { // telephone ?>
	<?php if ($nextofkin->SortUrl($nextofkin->telephone) == "") { ?>
		<td><div id="elh_nextofkin_telephone" class="nextofkin_telephone"><div class="ewTableHeaderCaption"><?php echo $nextofkin->telephone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_nextofkin_telephone" class="nextofkin_telephone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nextofkin->telephone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nextofkin->telephone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nextofkin->telephone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($nextofkin->_email->Visible) { // email ?>
	<?php if ($nextofkin->SortUrl($nextofkin->_email) == "") { ?>
		<td><div id="elh_nextofkin__email" class="nextofkin__email"><div class="ewTableHeaderCaption"><?php echo $nextofkin->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_nextofkin__email" class="nextofkin__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nextofkin->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nextofkin->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nextofkin->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($nextofkin->dateposted->Visible) { // dateposted ?>
	<?php if ($nextofkin->SortUrl($nextofkin->dateposted) == "") { ?>
		<td><div id="elh_nextofkin_dateposted" class="nextofkin_dateposted"><div class="ewTableHeaderCaption"><?php echo $nextofkin->dateposted->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_nextofkin_dateposted" class="nextofkin_dateposted">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $nextofkin->dateposted->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($nextofkin->dateposted->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($nextofkin->dateposted->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$nextofkin_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$nextofkin_grid->StartRec = 1;
$nextofkin_grid->StopRec = $nextofkin_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($nextofkin_grid->FormKeyCountName) && ($nextofkin->CurrentAction == "gridadd" || $nextofkin->CurrentAction == "gridedit" || $nextofkin->CurrentAction == "F")) {
		$nextofkin_grid->KeyCount = $objForm->GetValue($nextofkin_grid->FormKeyCountName);
		$nextofkin_grid->StopRec = $nextofkin_grid->StartRec + $nextofkin_grid->KeyCount - 1;
	}
}
$nextofkin_grid->RecCnt = $nextofkin_grid->StartRec - 1;
if ($nextofkin_grid->Recordset && !$nextofkin_grid->Recordset->EOF) {
	$nextofkin_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $nextofkin_grid->StartRec > 1)
		$nextofkin_grid->Recordset->Move($nextofkin_grid->StartRec - 1);
} elseif (!$nextofkin->AllowAddDeleteRow && $nextofkin_grid->StopRec == 0) {
	$nextofkin_grid->StopRec = $nextofkin->GridAddRowCount;
}

// Initialize aggregate
$nextofkin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$nextofkin->ResetAttrs();
$nextofkin_grid->RenderRow();
if ($nextofkin->CurrentAction == "gridadd")
	$nextofkin_grid->RowIndex = 0;
if ($nextofkin->CurrentAction == "gridedit")
	$nextofkin_grid->RowIndex = 0;
while ($nextofkin_grid->RecCnt < $nextofkin_grid->StopRec) {
	$nextofkin_grid->RecCnt++;
	if (intval($nextofkin_grid->RecCnt) >= intval($nextofkin_grid->StartRec)) {
		$nextofkin_grid->RowCnt++;
		if ($nextofkin->CurrentAction == "gridadd" || $nextofkin->CurrentAction == "gridedit" || $nextofkin->CurrentAction == "F") {
			$nextofkin_grid->RowIndex++;
			$objForm->Index = $nextofkin_grid->RowIndex;
			if ($objForm->HasValue($nextofkin_grid->FormActionName))
				$nextofkin_grid->RowAction = strval($objForm->GetValue($nextofkin_grid->FormActionName));
			elseif ($nextofkin->CurrentAction == "gridadd")
				$nextofkin_grid->RowAction = "insert";
			else
				$nextofkin_grid->RowAction = "";
		}

		// Set up key count
		$nextofkin_grid->KeyCount = $nextofkin_grid->RowIndex;

		// Init row class and style
		$nextofkin->ResetAttrs();
		$nextofkin->CssClass = "";
		if ($nextofkin->CurrentAction == "gridadd") {
			if ($nextofkin->CurrentMode == "copy") {
				$nextofkin_grid->LoadRowValues($nextofkin_grid->Recordset); // Load row values
				$nextofkin_grid->SetRecordKey($nextofkin_grid->RowOldKey, $nextofkin_grid->Recordset); // Set old record key
			} else {
				$nextofkin_grid->LoadDefaultValues(); // Load default values
				$nextofkin_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$nextofkin_grid->LoadRowValues($nextofkin_grid->Recordset); // Load row values
		}
		$nextofkin->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($nextofkin->CurrentAction == "gridadd") // Grid add
			$nextofkin->RowType = EW_ROWTYPE_ADD; // Render add
		if ($nextofkin->CurrentAction == "gridadd" && $nextofkin->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$nextofkin_grid->RestoreCurrentRowFormValues($nextofkin_grid->RowIndex); // Restore form values
		if ($nextofkin->CurrentAction == "gridedit") { // Grid edit
			if ($nextofkin->EventCancelled) {
				$nextofkin_grid->RestoreCurrentRowFormValues($nextofkin_grid->RowIndex); // Restore form values
			}
			if ($nextofkin_grid->RowAction == "insert")
				$nextofkin->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$nextofkin->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($nextofkin->CurrentAction == "gridedit" && ($nextofkin->RowType == EW_ROWTYPE_EDIT || $nextofkin->RowType == EW_ROWTYPE_ADD) && $nextofkin->EventCancelled) // Update failed
			$nextofkin_grid->RestoreCurrentRowFormValues($nextofkin_grid->RowIndex); // Restore form values
		if ($nextofkin->RowType == EW_ROWTYPE_EDIT) // Edit row
			$nextofkin_grid->EditRowCnt++;
		if ($nextofkin->CurrentAction == "F") // Confirm row
			$nextofkin_grid->RestoreCurrentRowFormValues($nextofkin_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$nextofkin->RowAttrs = array_merge($nextofkin->RowAttrs, array('data-rowindex'=>$nextofkin_grid->RowCnt, 'id'=>'r' . $nextofkin_grid->RowCnt . '_nextofkin', 'data-rowtype'=>$nextofkin->RowType));

		// Render row
		$nextofkin_grid->RenderRow();

		// Render list options
		$nextofkin_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($nextofkin_grid->RowAction <> "delete" && $nextofkin_grid->RowAction <> "insertdelete" && !($nextofkin_grid->RowAction == "insert" && $nextofkin->CurrentAction == "F" && $nextofkin_grid->EmptyRow())) {
?>
	<tr<?php echo $nextofkin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$nextofkin_grid->ListOptions->Render("body", "left", $nextofkin_grid->RowCnt);
?>
	<?php if ($nextofkin->fullname->Visible) { // fullname ?>
		<td<?php echo $nextofkin->fullname->CellAttributes() ?>>
<?php if ($nextofkin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin_fullname" class="control-group nextofkin_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" size="30" maxlength="100" placeholder="<?php echo $nextofkin->fullname->PlaceHolder ?>" value="<?php echo $nextofkin->fullname->EditValue ?>"<?php echo $nextofkin->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="o<?php echo $nextofkin_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($nextofkin->fullname->OldValue) ?>">
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin_fullname" class="control-group nextofkin_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" size="30" maxlength="100" placeholder="<?php echo $nextofkin->fullname->PlaceHolder ?>" value="<?php echo $nextofkin->fullname->EditValue ?>"<?php echo $nextofkin->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $nextofkin->fullname->ViewAttributes() ?>>
<?php echo $nextofkin->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($nextofkin->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="o<?php echo $nextofkin_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($nextofkin->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $nextofkin_grid->PageObjName . "_row_" . $nextofkin_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $nextofkin_grid->RowIndex ?>_id" id="x<?php echo $nextofkin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($nextofkin->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $nextofkin_grid->RowIndex ?>_id" id="o<?php echo $nextofkin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($nextofkin->id->OldValue) ?>">
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_EDIT || $nextofkin->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $nextofkin_grid->RowIndex ?>_id" id="x<?php echo $nextofkin_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($nextofkin->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($nextofkin->telephone->Visible) { // telephone ?>
		<td<?php echo $nextofkin->telephone->CellAttributes() ?>>
<?php if ($nextofkin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin_telephone" class="control-group nextofkin_telephone">
<input type="text" data-field="x_telephone" name="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" size="30" maxlength="20" placeholder="<?php echo $nextofkin->telephone->PlaceHolder ?>" value="<?php echo $nextofkin->telephone->EditValue ?>"<?php echo $nextofkin->telephone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_telephone" name="o<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="o<?php echo $nextofkin_grid->RowIndex ?>_telephone" value="<?php echo ew_HtmlEncode($nextofkin->telephone->OldValue) ?>">
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin_telephone" class="control-group nextofkin_telephone">
<input type="text" data-field="x_telephone" name="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" size="30" maxlength="20" placeholder="<?php echo $nextofkin->telephone->PlaceHolder ?>" value="<?php echo $nextofkin->telephone->EditValue ?>"<?php echo $nextofkin->telephone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $nextofkin->telephone->ViewAttributes() ?>>
<?php echo $nextofkin->telephone->ListViewValue() ?></span>
<input type="hidden" data-field="x_telephone" name="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" value="<?php echo ew_HtmlEncode($nextofkin->telephone->FormValue) ?>">
<input type="hidden" data-field="x_telephone" name="o<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="o<?php echo $nextofkin_grid->RowIndex ?>_telephone" value="<?php echo ew_HtmlEncode($nextofkin->telephone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $nextofkin_grid->PageObjName . "_row_" . $nextofkin_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($nextofkin->_email->Visible) { // email ?>
		<td<?php echo $nextofkin->_email->CellAttributes() ?>>
<?php if ($nextofkin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin__email" class="control-group nextofkin__email">
<input type="text" data-field="x__email" name="x<?php echo $nextofkin_grid->RowIndex ?>__email" id="x<?php echo $nextofkin_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $nextofkin->_email->PlaceHolder ?>" value="<?php echo $nextofkin->_email->EditValue ?>"<?php echo $nextofkin->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $nextofkin_grid->RowIndex ?>__email" id="o<?php echo $nextofkin_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($nextofkin->_email->OldValue) ?>">
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin__email" class="control-group nextofkin__email">
<input type="text" data-field="x__email" name="x<?php echo $nextofkin_grid->RowIndex ?>__email" id="x<?php echo $nextofkin_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $nextofkin->_email->PlaceHolder ?>" value="<?php echo $nextofkin->_email->EditValue ?>"<?php echo $nextofkin->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $nextofkin->_email->ViewAttributes() ?>>
<?php echo $nextofkin->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $nextofkin_grid->RowIndex ?>__email" id="x<?php echo $nextofkin_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($nextofkin->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $nextofkin_grid->RowIndex ?>__email" id="o<?php echo $nextofkin_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($nextofkin->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $nextofkin_grid->PageObjName . "_row_" . $nextofkin_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($nextofkin->dateposted->Visible) { // dateposted ?>
		<td<?php echo $nextofkin->dateposted->CellAttributes() ?>>
<?php if ($nextofkin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin_dateposted" class="control-group nextofkin_dateposted">
<input type="text" data-field="x_dateposted" name="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" placeholder="<?php echo $nextofkin->dateposted->PlaceHolder ?>" value="<?php echo $nextofkin->dateposted->EditValue ?>"<?php echo $nextofkin->dateposted->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_dateposted" name="o<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="o<?php echo $nextofkin_grid->RowIndex ?>_dateposted" value="<?php echo ew_HtmlEncode($nextofkin->dateposted->OldValue) ?>">
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $nextofkin_grid->RowCnt ?>_nextofkin_dateposted" class="control-group nextofkin_dateposted">
<input type="text" data-field="x_dateposted" name="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" placeholder="<?php echo $nextofkin->dateposted->PlaceHolder ?>" value="<?php echo $nextofkin->dateposted->EditValue ?>"<?php echo $nextofkin->dateposted->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($nextofkin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $nextofkin->dateposted->ViewAttributes() ?>>
<?php echo $nextofkin->dateposted->ListViewValue() ?></span>
<input type="hidden" data-field="x_dateposted" name="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" value="<?php echo ew_HtmlEncode($nextofkin->dateposted->FormValue) ?>">
<input type="hidden" data-field="x_dateposted" name="o<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="o<?php echo $nextofkin_grid->RowIndex ?>_dateposted" value="<?php echo ew_HtmlEncode($nextofkin->dateposted->OldValue) ?>">
<?php } ?>
<a id="<?php echo $nextofkin_grid->PageObjName . "_row_" . $nextofkin_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$nextofkin_grid->ListOptions->Render("body", "right", $nextofkin_grid->RowCnt);
?>
	</tr>
<?php if ($nextofkin->RowType == EW_ROWTYPE_ADD || $nextofkin->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fnextofkingrid.UpdateOpts(<?php echo $nextofkin_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($nextofkin->CurrentAction <> "gridadd" || $nextofkin->CurrentMode == "copy")
		if (!$nextofkin_grid->Recordset->EOF) $nextofkin_grid->Recordset->MoveNext();
}
?>
<?php
	if ($nextofkin->CurrentMode == "add" || $nextofkin->CurrentMode == "copy" || $nextofkin->CurrentMode == "edit") {
		$nextofkin_grid->RowIndex = '$rowindex$';
		$nextofkin_grid->LoadDefaultValues();

		// Set row properties
		$nextofkin->ResetAttrs();
		$nextofkin->RowAttrs = array_merge($nextofkin->RowAttrs, array('data-rowindex'=>$nextofkin_grid->RowIndex, 'id'=>'r0_nextofkin', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($nextofkin->RowAttrs["class"], "ewTemplate");
		$nextofkin->RowType = EW_ROWTYPE_ADD;

		// Render row
		$nextofkin_grid->RenderRow();

		// Render list options
		$nextofkin_grid->RenderListOptions();
		$nextofkin_grid->StartRowCnt = 0;
?>
	<tr<?php echo $nextofkin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$nextofkin_grid->ListOptions->Render("body", "left", $nextofkin_grid->RowIndex);
?>
	<?php if ($nextofkin->fullname->Visible) { // fullname ?>
		<td>
<?php if ($nextofkin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_nextofkin_fullname" class="control-group nextofkin_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" size="30" maxlength="100" placeholder="<?php echo $nextofkin->fullname->PlaceHolder ?>" value="<?php echo $nextofkin->fullname->EditValue ?>"<?php echo $nextofkin->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_nextofkin_fullname" class="control-group nextofkin_fullname">
<span<?php echo $nextofkin->fullname->ViewAttributes() ?>>
<?php echo $nextofkin->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="x<?php echo $nextofkin_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($nextofkin->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $nextofkin_grid->RowIndex ?>_fullname" id="o<?php echo $nextofkin_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($nextofkin->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($nextofkin->telephone->Visible) { // telephone ?>
		<td>
<?php if ($nextofkin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_nextofkin_telephone" class="control-group nextofkin_telephone">
<input type="text" data-field="x_telephone" name="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" size="30" maxlength="20" placeholder="<?php echo $nextofkin->telephone->PlaceHolder ?>" value="<?php echo $nextofkin->telephone->EditValue ?>"<?php echo $nextofkin->telephone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_nextofkin_telephone" class="control-group nextofkin_telephone">
<span<?php echo $nextofkin->telephone->ViewAttributes() ?>>
<?php echo $nextofkin->telephone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_telephone" name="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="x<?php echo $nextofkin_grid->RowIndex ?>_telephone" value="<?php echo ew_HtmlEncode($nextofkin->telephone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_telephone" name="o<?php echo $nextofkin_grid->RowIndex ?>_telephone" id="o<?php echo $nextofkin_grid->RowIndex ?>_telephone" value="<?php echo ew_HtmlEncode($nextofkin->telephone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($nextofkin->_email->Visible) { // email ?>
		<td>
<?php if ($nextofkin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_nextofkin__email" class="control-group nextofkin__email">
<input type="text" data-field="x__email" name="x<?php echo $nextofkin_grid->RowIndex ?>__email" id="x<?php echo $nextofkin_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $nextofkin->_email->PlaceHolder ?>" value="<?php echo $nextofkin->_email->EditValue ?>"<?php echo $nextofkin->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_nextofkin__email" class="control-group nextofkin__email">
<span<?php echo $nextofkin->_email->ViewAttributes() ?>>
<?php echo $nextofkin->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $nextofkin_grid->RowIndex ?>__email" id="x<?php echo $nextofkin_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($nextofkin->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $nextofkin_grid->RowIndex ?>__email" id="o<?php echo $nextofkin_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($nextofkin->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($nextofkin->dateposted->Visible) { // dateposted ?>
		<td>
<?php if ($nextofkin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_nextofkin_dateposted" class="control-group nextofkin_dateposted">
<input type="text" data-field="x_dateposted" name="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" placeholder="<?php echo $nextofkin->dateposted->PlaceHolder ?>" value="<?php echo $nextofkin->dateposted->EditValue ?>"<?php echo $nextofkin->dateposted->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_nextofkin_dateposted" class="control-group nextofkin_dateposted">
<span<?php echo $nextofkin->dateposted->ViewAttributes() ?>>
<?php echo $nextofkin->dateposted->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_dateposted" name="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="x<?php echo $nextofkin_grid->RowIndex ?>_dateposted" value="<?php echo ew_HtmlEncode($nextofkin->dateposted->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_dateposted" name="o<?php echo $nextofkin_grid->RowIndex ?>_dateposted" id="o<?php echo $nextofkin_grid->RowIndex ?>_dateposted" value="<?php echo ew_HtmlEncode($nextofkin->dateposted->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$nextofkin_grid->ListOptions->Render("body", "right", $nextofkin_grid->RowCnt);
?>
<script type="text/javascript">
fnextofkingrid.UpdateOpts(<?php echo $nextofkin_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($nextofkin->CurrentMode == "add" || $nextofkin->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $nextofkin_grid->FormKeyCountName ?>" id="<?php echo $nextofkin_grid->FormKeyCountName ?>" value="<?php echo $nextofkin_grid->KeyCount ?>">
<?php echo $nextofkin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($nextofkin->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $nextofkin_grid->FormKeyCountName ?>" id="<?php echo $nextofkin_grid->FormKeyCountName ?>" value="<?php echo $nextofkin_grid->KeyCount ?>">
<?php echo $nextofkin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($nextofkin->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fnextofkingrid">
</div>
<?php

// Close recordset
if ($nextofkin_grid->Recordset)
	$nextofkin_grid->Recordset->Close();
?>
<?php if ($nextofkin_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($nextofkin_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($nextofkin->Export == "") { ?>
<script type="text/javascript">
fnextofkingrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$nextofkin_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$nextofkin_grid->Page_Terminate();
?>
