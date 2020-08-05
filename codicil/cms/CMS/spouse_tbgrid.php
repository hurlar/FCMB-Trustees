<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($spouse_tb_grid)) $spouse_tb_grid = new cspouse_tb_grid();

// Page init
$spouse_tb_grid->Page_Init();

// Page main
$spouse_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$spouse_tb_grid->Page_Render();
?>
<?php if ($spouse_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var spouse_tb_grid = new ew_Page("spouse_tb_grid");
spouse_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = spouse_tb_grid.PageID; // For backward compatibility

// Form object
var fspouse_tbgrid = new ew_Form("fspouse_tbgrid");
fspouse_tbgrid.FormKeyCountName = '<?php echo $spouse_tb_grid->FormKeyCountName ?>';

// Validate form
fspouse_tbgrid.Validate = function() {
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
fspouse_tbgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fullname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "phoneno", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fspouse_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fspouse_tbgrid.ValidateRequired = true;
<?php } else { ?>
fspouse_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($spouse_tb->getCurrentMasterTable() == "" && $spouse_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $spouse_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($spouse_tb->CurrentAction == "gridadd") {
	if ($spouse_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$spouse_tb_grid->TotalRecs = $spouse_tb->SelectRecordCount();
			$spouse_tb_grid->Recordset = $spouse_tb_grid->LoadRecordset($spouse_tb_grid->StartRec-1, $spouse_tb_grid->DisplayRecs);
		} else {
			if ($spouse_tb_grid->Recordset = $spouse_tb_grid->LoadRecordset())
				$spouse_tb_grid->TotalRecs = $spouse_tb_grid->Recordset->RecordCount();
		}
		$spouse_tb_grid->StartRec = 1;
		$spouse_tb_grid->DisplayRecs = $spouse_tb_grid->TotalRecs;
	} else {
		$spouse_tb->CurrentFilter = "0=1";
		$spouse_tb_grid->StartRec = 1;
		$spouse_tb_grid->DisplayRecs = $spouse_tb->GridAddRowCount;
	}
	$spouse_tb_grid->TotalRecs = $spouse_tb_grid->DisplayRecs;
	$spouse_tb_grid->StopRec = $spouse_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$spouse_tb_grid->TotalRecs = $spouse_tb->SelectRecordCount();
	} else {
		if ($spouse_tb_grid->Recordset = $spouse_tb_grid->LoadRecordset())
			$spouse_tb_grid->TotalRecs = $spouse_tb_grid->Recordset->RecordCount();
	}
	$spouse_tb_grid->StartRec = 1;
	$spouse_tb_grid->DisplayRecs = $spouse_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$spouse_tb_grid->Recordset = $spouse_tb_grid->LoadRecordset($spouse_tb_grid->StartRec-1, $spouse_tb_grid->DisplayRecs);
}
$spouse_tb_grid->RenderOtherOptions();
?>
<?php $spouse_tb_grid->ShowPageHeader(); ?>
<?php
$spouse_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fspouse_tbgrid" class="ewForm form-horizontal">
<div id="gmp_spouse_tb" class="ewGridMiddlePanel">
<table id="tbl_spouse_tbgrid" class="ewTable ewTableSeparate">
<?php echo $spouse_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$spouse_tb_grid->RenderListOptions();

// Render list options (header, left)
$spouse_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($spouse_tb->title->Visible) { // title ?>
	<?php if ($spouse_tb->SortUrl($spouse_tb->title) == "") { ?>
		<td><div id="elh_spouse_tb_title" class="spouse_tb_title"><div class="ewTableHeaderCaption"><?php echo $spouse_tb->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_spouse_tb_title" class="spouse_tb_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spouse_tb->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spouse_tb->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($spouse_tb->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
	<?php if ($spouse_tb->SortUrl($spouse_tb->fullname) == "") { ?>
		<td><div id="elh_spouse_tb_fullname" class="spouse_tb_fullname"><div class="ewTableHeaderCaption"><?php echo $spouse_tb->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_spouse_tb_fullname" class="spouse_tb_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spouse_tb->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spouse_tb->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($spouse_tb->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($spouse_tb->_email->Visible) { // email ?>
	<?php if ($spouse_tb->SortUrl($spouse_tb->_email) == "") { ?>
		<td><div id="elh_spouse_tb__email" class="spouse_tb__email"><div class="ewTableHeaderCaption"><?php echo $spouse_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_spouse_tb__email" class="spouse_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spouse_tb->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spouse_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($spouse_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
	<?php if ($spouse_tb->SortUrl($spouse_tb->phoneno) == "") { ?>
		<td><div id="elh_spouse_tb_phoneno" class="spouse_tb_phoneno"><div class="ewTableHeaderCaption"><?php echo $spouse_tb->phoneno->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_spouse_tb_phoneno" class="spouse_tb_phoneno">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spouse_tb->phoneno->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spouse_tb->phoneno->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($spouse_tb->phoneno->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($spouse_tb->SortUrl($spouse_tb->datecreated) == "") { ?>
		<td><div id="elh_spouse_tb_datecreated" class="spouse_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $spouse_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_spouse_tb_datecreated" class="spouse_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spouse_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spouse_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($spouse_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$spouse_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$spouse_tb_grid->StartRec = 1;
$spouse_tb_grid->StopRec = $spouse_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($spouse_tb_grid->FormKeyCountName) && ($spouse_tb->CurrentAction == "gridadd" || $spouse_tb->CurrentAction == "gridedit" || $spouse_tb->CurrentAction == "F")) {
		$spouse_tb_grid->KeyCount = $objForm->GetValue($spouse_tb_grid->FormKeyCountName);
		$spouse_tb_grid->StopRec = $spouse_tb_grid->StartRec + $spouse_tb_grid->KeyCount - 1;
	}
}
$spouse_tb_grid->RecCnt = $spouse_tb_grid->StartRec - 1;
if ($spouse_tb_grid->Recordset && !$spouse_tb_grid->Recordset->EOF) {
	$spouse_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $spouse_tb_grid->StartRec > 1)
		$spouse_tb_grid->Recordset->Move($spouse_tb_grid->StartRec - 1);
} elseif (!$spouse_tb->AllowAddDeleteRow && $spouse_tb_grid->StopRec == 0) {
	$spouse_tb_grid->StopRec = $spouse_tb->GridAddRowCount;
}

// Initialize aggregate
$spouse_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$spouse_tb->ResetAttrs();
$spouse_tb_grid->RenderRow();
if ($spouse_tb->CurrentAction == "gridadd")
	$spouse_tb_grid->RowIndex = 0;
if ($spouse_tb->CurrentAction == "gridedit")
	$spouse_tb_grid->RowIndex = 0;
while ($spouse_tb_grid->RecCnt < $spouse_tb_grid->StopRec) {
	$spouse_tb_grid->RecCnt++;
	if (intval($spouse_tb_grid->RecCnt) >= intval($spouse_tb_grid->StartRec)) {
		$spouse_tb_grid->RowCnt++;
		if ($spouse_tb->CurrentAction == "gridadd" || $spouse_tb->CurrentAction == "gridedit" || $spouse_tb->CurrentAction == "F") {
			$spouse_tb_grid->RowIndex++;
			$objForm->Index = $spouse_tb_grid->RowIndex;
			if ($objForm->HasValue($spouse_tb_grid->FormActionName))
				$spouse_tb_grid->RowAction = strval($objForm->GetValue($spouse_tb_grid->FormActionName));
			elseif ($spouse_tb->CurrentAction == "gridadd")
				$spouse_tb_grid->RowAction = "insert";
			else
				$spouse_tb_grid->RowAction = "";
		}

		// Set up key count
		$spouse_tb_grid->KeyCount = $spouse_tb_grid->RowIndex;

		// Init row class and style
		$spouse_tb->ResetAttrs();
		$spouse_tb->CssClass = "";
		if ($spouse_tb->CurrentAction == "gridadd") {
			if ($spouse_tb->CurrentMode == "copy") {
				$spouse_tb_grid->LoadRowValues($spouse_tb_grid->Recordset); // Load row values
				$spouse_tb_grid->SetRecordKey($spouse_tb_grid->RowOldKey, $spouse_tb_grid->Recordset); // Set old record key
			} else {
				$spouse_tb_grid->LoadDefaultValues(); // Load default values
				$spouse_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$spouse_tb_grid->LoadRowValues($spouse_tb_grid->Recordset); // Load row values
		}
		$spouse_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($spouse_tb->CurrentAction == "gridadd") // Grid add
			$spouse_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($spouse_tb->CurrentAction == "gridadd" && $spouse_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$spouse_tb_grid->RestoreCurrentRowFormValues($spouse_tb_grid->RowIndex); // Restore form values
		if ($spouse_tb->CurrentAction == "gridedit") { // Grid edit
			if ($spouse_tb->EventCancelled) {
				$spouse_tb_grid->RestoreCurrentRowFormValues($spouse_tb_grid->RowIndex); // Restore form values
			}
			if ($spouse_tb_grid->RowAction == "insert")
				$spouse_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$spouse_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($spouse_tb->CurrentAction == "gridedit" && ($spouse_tb->RowType == EW_ROWTYPE_EDIT || $spouse_tb->RowType == EW_ROWTYPE_ADD) && $spouse_tb->EventCancelled) // Update failed
			$spouse_tb_grid->RestoreCurrentRowFormValues($spouse_tb_grid->RowIndex); // Restore form values
		if ($spouse_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$spouse_tb_grid->EditRowCnt++;
		if ($spouse_tb->CurrentAction == "F") // Confirm row
			$spouse_tb_grid->RestoreCurrentRowFormValues($spouse_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$spouse_tb->RowAttrs = array_merge($spouse_tb->RowAttrs, array('data-rowindex'=>$spouse_tb_grid->RowCnt, 'id'=>'r' . $spouse_tb_grid->RowCnt . '_spouse_tb', 'data-rowtype'=>$spouse_tb->RowType));

		// Render row
		$spouse_tb_grid->RenderRow();

		// Render list options
		$spouse_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($spouse_tb_grid->RowAction <> "delete" && $spouse_tb_grid->RowAction <> "insertdelete" && !($spouse_tb_grid->RowAction == "insert" && $spouse_tb->CurrentAction == "F" && $spouse_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $spouse_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$spouse_tb_grid->ListOptions->Render("body", "left", $spouse_tb_grid->RowCnt);
?>
	<?php if ($spouse_tb->title->Visible) { // title ?>
		<td<?php echo $spouse_tb->title->CellAttributes() ?>>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_title" class="control-group spouse_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $spouse_tb_grid->RowIndex ?>_title" id="x<?php echo $spouse_tb_grid->RowIndex ?>_title" size="30" maxlength="10" placeholder="<?php echo $spouse_tb->title->PlaceHolder ?>" value="<?php echo $spouse_tb->title->EditValue ?>"<?php echo $spouse_tb->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $spouse_tb_grid->RowIndex ?>_title" id="o<?php echo $spouse_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($spouse_tb->title->OldValue) ?>">
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_title" class="control-group spouse_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $spouse_tb_grid->RowIndex ?>_title" id="x<?php echo $spouse_tb_grid->RowIndex ?>_title" size="30" maxlength="10" placeholder="<?php echo $spouse_tb->title->PlaceHolder ?>" value="<?php echo $spouse_tb->title->EditValue ?>"<?php echo $spouse_tb->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $spouse_tb->title->ViewAttributes() ?>>
<?php echo $spouse_tb->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $spouse_tb_grid->RowIndex ?>_title" id="x<?php echo $spouse_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($spouse_tb->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $spouse_tb_grid->RowIndex ?>_title" id="o<?php echo $spouse_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($spouse_tb->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $spouse_tb_grid->PageObjName . "_row_" . $spouse_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $spouse_tb_grid->RowIndex ?>_id" id="x<?php echo $spouse_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($spouse_tb->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $spouse_tb_grid->RowIndex ?>_id" id="o<?php echo $spouse_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($spouse_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_EDIT || $spouse_tb->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $spouse_tb_grid->RowIndex ?>_id" id="x<?php echo $spouse_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($spouse_tb->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $spouse_tb->fullname->CellAttributes() ?>>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_fullname" class="control-group spouse_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" size="30" maxlength="70" placeholder="<?php echo $spouse_tb->fullname->PlaceHolder ?>" value="<?php echo $spouse_tb->fullname->EditValue ?>"<?php echo $spouse_tb->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="o<?php echo $spouse_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($spouse_tb->fullname->OldValue) ?>">
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_fullname" class="control-group spouse_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" size="30" maxlength="70" placeholder="<?php echo $spouse_tb->fullname->PlaceHolder ?>" value="<?php echo $spouse_tb->fullname->EditValue ?>"<?php echo $spouse_tb->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $spouse_tb->fullname->ViewAttributes() ?>>
<?php echo $spouse_tb->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($spouse_tb->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="o<?php echo $spouse_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($spouse_tb->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $spouse_tb_grid->PageObjName . "_row_" . $spouse_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($spouse_tb->_email->Visible) { // email ?>
		<td<?php echo $spouse_tb->_email->CellAttributes() ?>>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb__email" class="control-group spouse_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $spouse_tb_grid->RowIndex ?>__email" id="x<?php echo $spouse_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->_email->PlaceHolder ?>" value="<?php echo $spouse_tb->_email->EditValue ?>"<?php echo $spouse_tb->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $spouse_tb_grid->RowIndex ?>__email" id="o<?php echo $spouse_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($spouse_tb->_email->OldValue) ?>">
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb__email" class="control-group spouse_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $spouse_tb_grid->RowIndex ?>__email" id="x<?php echo $spouse_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->_email->PlaceHolder ?>" value="<?php echo $spouse_tb->_email->EditValue ?>"<?php echo $spouse_tb->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $spouse_tb->_email->ViewAttributes() ?>>
<?php echo $spouse_tb->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $spouse_tb_grid->RowIndex ?>__email" id="x<?php echo $spouse_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($spouse_tb->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $spouse_tb_grid->RowIndex ?>__email" id="o<?php echo $spouse_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($spouse_tb->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $spouse_tb_grid->PageObjName . "_row_" . $spouse_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
		<td<?php echo $spouse_tb->phoneno->CellAttributes() ?>>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_phoneno" class="control-group spouse_tb_phoneno">
<input type="text" data-field="x_phoneno" name="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" size="30" maxlength="20" placeholder="<?php echo $spouse_tb->phoneno->PlaceHolder ?>" value="<?php echo $spouse_tb->phoneno->EditValue ?>"<?php echo $spouse_tb->phoneno->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phoneno" name="o<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="o<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" value="<?php echo ew_HtmlEncode($spouse_tb->phoneno->OldValue) ?>">
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_phoneno" class="control-group spouse_tb_phoneno">
<input type="text" data-field="x_phoneno" name="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" size="30" maxlength="20" placeholder="<?php echo $spouse_tb->phoneno->PlaceHolder ?>" value="<?php echo $spouse_tb->phoneno->EditValue ?>"<?php echo $spouse_tb->phoneno->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $spouse_tb->phoneno->ViewAttributes() ?>>
<?php echo $spouse_tb->phoneno->ListViewValue() ?></span>
<input type="hidden" data-field="x_phoneno" name="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" value="<?php echo ew_HtmlEncode($spouse_tb->phoneno->FormValue) ?>">
<input type="hidden" data-field="x_phoneno" name="o<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="o<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" value="<?php echo ew_HtmlEncode($spouse_tb->phoneno->OldValue) ?>">
<?php } ?>
<a id="<?php echo $spouse_tb_grid->PageObjName . "_row_" . $spouse_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $spouse_tb->datecreated->CellAttributes() ?>>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_datecreated" class="control-group spouse_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $spouse_tb->datecreated->PlaceHolder ?>" value="<?php echo $spouse_tb->datecreated->EditValue ?>"<?php echo $spouse_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($spouse_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $spouse_tb_grid->RowCnt ?>_spouse_tb_datecreated" class="control-group spouse_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $spouse_tb->datecreated->PlaceHolder ?>" value="<?php echo $spouse_tb->datecreated->EditValue ?>"<?php echo $spouse_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $spouse_tb->datecreated->ViewAttributes() ?>>
<?php echo $spouse_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($spouse_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($spouse_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $spouse_tb_grid->PageObjName . "_row_" . $spouse_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$spouse_tb_grid->ListOptions->Render("body", "right", $spouse_tb_grid->RowCnt);
?>
	</tr>
<?php if ($spouse_tb->RowType == EW_ROWTYPE_ADD || $spouse_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fspouse_tbgrid.UpdateOpts(<?php echo $spouse_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($spouse_tb->CurrentAction <> "gridadd" || $spouse_tb->CurrentMode == "copy")
		if (!$spouse_tb_grid->Recordset->EOF) $spouse_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($spouse_tb->CurrentMode == "add" || $spouse_tb->CurrentMode == "copy" || $spouse_tb->CurrentMode == "edit") {
		$spouse_tb_grid->RowIndex = '$rowindex$';
		$spouse_tb_grid->LoadDefaultValues();

		// Set row properties
		$spouse_tb->ResetAttrs();
		$spouse_tb->RowAttrs = array_merge($spouse_tb->RowAttrs, array('data-rowindex'=>$spouse_tb_grid->RowIndex, 'id'=>'r0_spouse_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($spouse_tb->RowAttrs["class"], "ewTemplate");
		$spouse_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$spouse_tb_grid->RenderRow();

		// Render list options
		$spouse_tb_grid->RenderListOptions();
		$spouse_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $spouse_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$spouse_tb_grid->ListOptions->Render("body", "left", $spouse_tb_grid->RowIndex);
?>
	<?php if ($spouse_tb->title->Visible) { // title ?>
		<td>
<?php if ($spouse_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_spouse_tb_title" class="control-group spouse_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $spouse_tb_grid->RowIndex ?>_title" id="x<?php echo $spouse_tb_grid->RowIndex ?>_title" size="30" maxlength="10" placeholder="<?php echo $spouse_tb->title->PlaceHolder ?>" value="<?php echo $spouse_tb->title->EditValue ?>"<?php echo $spouse_tb->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_spouse_tb_title" class="control-group spouse_tb_title">
<span<?php echo $spouse_tb->title->ViewAttributes() ?>>
<?php echo $spouse_tb->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $spouse_tb_grid->RowIndex ?>_title" id="x<?php echo $spouse_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($spouse_tb->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $spouse_tb_grid->RowIndex ?>_title" id="o<?php echo $spouse_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($spouse_tb->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($spouse_tb->fullname->Visible) { // fullname ?>
		<td>
<?php if ($spouse_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_spouse_tb_fullname" class="control-group spouse_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" size="30" maxlength="70" placeholder="<?php echo $spouse_tb->fullname->PlaceHolder ?>" value="<?php echo $spouse_tb->fullname->EditValue ?>"<?php echo $spouse_tb->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_spouse_tb_fullname" class="control-group spouse_tb_fullname">
<span<?php echo $spouse_tb->fullname->ViewAttributes() ?>>
<?php echo $spouse_tb->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="x<?php echo $spouse_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($spouse_tb->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $spouse_tb_grid->RowIndex ?>_fullname" id="o<?php echo $spouse_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($spouse_tb->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($spouse_tb->_email->Visible) { // email ?>
		<td>
<?php if ($spouse_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_spouse_tb__email" class="control-group spouse_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $spouse_tb_grid->RowIndex ?>__email" id="x<?php echo $spouse_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $spouse_tb->_email->PlaceHolder ?>" value="<?php echo $spouse_tb->_email->EditValue ?>"<?php echo $spouse_tb->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_spouse_tb__email" class="control-group spouse_tb__email">
<span<?php echo $spouse_tb->_email->ViewAttributes() ?>>
<?php echo $spouse_tb->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $spouse_tb_grid->RowIndex ?>__email" id="x<?php echo $spouse_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($spouse_tb->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $spouse_tb_grid->RowIndex ?>__email" id="o<?php echo $spouse_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($spouse_tb->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($spouse_tb->phoneno->Visible) { // phoneno ?>
		<td>
<?php if ($spouse_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_spouse_tb_phoneno" class="control-group spouse_tb_phoneno">
<input type="text" data-field="x_phoneno" name="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" size="30" maxlength="20" placeholder="<?php echo $spouse_tb->phoneno->PlaceHolder ?>" value="<?php echo $spouse_tb->phoneno->EditValue ?>"<?php echo $spouse_tb->phoneno->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_spouse_tb_phoneno" class="control-group spouse_tb_phoneno">
<span<?php echo $spouse_tb->phoneno->ViewAttributes() ?>>
<?php echo $spouse_tb->phoneno->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phoneno" name="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="x<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" value="<?php echo ew_HtmlEncode($spouse_tb->phoneno->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phoneno" name="o<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" id="o<?php echo $spouse_tb_grid->RowIndex ?>_phoneno" value="<?php echo ew_HtmlEncode($spouse_tb->phoneno->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($spouse_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($spouse_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_spouse_tb_datecreated" class="control-group spouse_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $spouse_tb->datecreated->PlaceHolder ?>" value="<?php echo $spouse_tb->datecreated->EditValue ?>"<?php echo $spouse_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_spouse_tb_datecreated" class="control-group spouse_tb_datecreated">
<span<?php echo $spouse_tb->datecreated->ViewAttributes() ?>>
<?php echo $spouse_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($spouse_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $spouse_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($spouse_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$spouse_tb_grid->ListOptions->Render("body", "right", $spouse_tb_grid->RowCnt);
?>
<script type="text/javascript">
fspouse_tbgrid.UpdateOpts(<?php echo $spouse_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($spouse_tb->CurrentMode == "add" || $spouse_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $spouse_tb_grid->FormKeyCountName ?>" id="<?php echo $spouse_tb_grid->FormKeyCountName ?>" value="<?php echo $spouse_tb_grid->KeyCount ?>">
<?php echo $spouse_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($spouse_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $spouse_tb_grid->FormKeyCountName ?>" id="<?php echo $spouse_tb_grid->FormKeyCountName ?>" value="<?php echo $spouse_tb_grid->KeyCount ?>">
<?php echo $spouse_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($spouse_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fspouse_tbgrid">
</div>
<?php

// Close recordset
if ($spouse_tb_grid->Recordset)
	$spouse_tb_grid->Recordset->Close();
?>
<?php if ($spouse_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($spouse_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($spouse_tb->Export == "") { ?>
<script type="text/javascript">
fspouse_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$spouse_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$spouse_tb_grid->Page_Terminate();
?>
