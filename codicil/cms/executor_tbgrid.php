<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($executor_tb_grid)) $executor_tb_grid = new cexecutor_tb_grid();

// Page init
$executor_tb_grid->Page_Init();

// Page main
$executor_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$executor_tb_grid->Page_Render();
?>
<?php if ($executor_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var executor_tb_grid = new ew_Page("executor_tb_grid");
executor_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = executor_tb_grid.PageID; // For backward compatibility

// Form object
var fexecutor_tbgrid = new ew_Form("fexecutor_tbgrid");
fexecutor_tbgrid.FormKeyCountName = '<?php echo $executor_tb_grid->FormKeyCountName ?>';

// Validate form
fexecutor_tbgrid.Validate = function() {
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
fexecutor_tbgrid.EmptyRow = function(infix) {
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
fexecutor_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fexecutor_tbgrid.ValidateRequired = true;
<?php } else { ?>
fexecutor_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($executor_tb->getCurrentMasterTable() == "" && $executor_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $executor_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($executor_tb->CurrentAction == "gridadd") {
	if ($executor_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$executor_tb_grid->TotalRecs = $executor_tb->SelectRecordCount();
			$executor_tb_grid->Recordset = $executor_tb_grid->LoadRecordset($executor_tb_grid->StartRec-1, $executor_tb_grid->DisplayRecs);
		} else {
			if ($executor_tb_grid->Recordset = $executor_tb_grid->LoadRecordset())
				$executor_tb_grid->TotalRecs = $executor_tb_grid->Recordset->RecordCount();
		}
		$executor_tb_grid->StartRec = 1;
		$executor_tb_grid->DisplayRecs = $executor_tb_grid->TotalRecs;
	} else {
		$executor_tb->CurrentFilter = "0=1";
		$executor_tb_grid->StartRec = 1;
		$executor_tb_grid->DisplayRecs = $executor_tb->GridAddRowCount;
	}
	$executor_tb_grid->TotalRecs = $executor_tb_grid->DisplayRecs;
	$executor_tb_grid->StopRec = $executor_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$executor_tb_grid->TotalRecs = $executor_tb->SelectRecordCount();
	} else {
		if ($executor_tb_grid->Recordset = $executor_tb_grid->LoadRecordset())
			$executor_tb_grid->TotalRecs = $executor_tb_grid->Recordset->RecordCount();
	}
	$executor_tb_grid->StartRec = 1;
	$executor_tb_grid->DisplayRecs = $executor_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$executor_tb_grid->Recordset = $executor_tb_grid->LoadRecordset($executor_tb_grid->StartRec-1, $executor_tb_grid->DisplayRecs);
}
$executor_tb_grid->RenderOtherOptions();
?>
<?php $executor_tb_grid->ShowPageHeader(); ?>
<?php
$executor_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fexecutor_tbgrid" class="ewForm form-horizontal">
<div id="gmp_executor_tb" class="ewGridMiddlePanel">
<table id="tbl_executor_tbgrid" class="ewTable ewTableSeparate">
<?php echo $executor_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$executor_tb_grid->RenderListOptions();

// Render list options (header, left)
$executor_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($executor_tb->id->Visible) { // id ?>
	<?php if ($executor_tb->SortUrl($executor_tb->id) == "") { ?>
		<td><div id="elh_executor_tb_id" class="executor_tb_id"><div class="ewTableHeaderCaption"><?php echo $executor_tb->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_id" class="executor_tb_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->title->Visible) { // title ?>
	<?php if ($executor_tb->SortUrl($executor_tb->title) == "") { ?>
		<td><div id="elh_executor_tb_title" class="executor_tb_title"><div class="ewTableHeaderCaption"><?php echo $executor_tb->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_title" class="executor_tb_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->fullname->Visible) { // fullname ?>
	<?php if ($executor_tb->SortUrl($executor_tb->fullname) == "") { ?>
		<td><div id="elh_executor_tb_fullname" class="executor_tb_fullname"><div class="ewTableHeaderCaption"><?php echo $executor_tb->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_fullname" class="executor_tb_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->rtionship->Visible) { // rtionship ?>
	<?php if ($executor_tb->SortUrl($executor_tb->rtionship) == "") { ?>
		<td><div id="elh_executor_tb_rtionship" class="executor_tb_rtionship"><div class="ewTableHeaderCaption"><?php echo $executor_tb->rtionship->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_rtionship" class="executor_tb_rtionship">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->rtionship->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->rtionship->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->rtionship->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->_email->Visible) { // email ?>
	<?php if ($executor_tb->SortUrl($executor_tb->_email) == "") { ?>
		<td><div id="elh_executor_tb__email" class="executor_tb__email"><div class="ewTableHeaderCaption"><?php echo $executor_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb__email" class="executor_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->phone->Visible) { // phone ?>
	<?php if ($executor_tb->SortUrl($executor_tb->phone) == "") { ?>
		<td><div id="elh_executor_tb_phone" class="executor_tb_phone"><div class="ewTableHeaderCaption"><?php echo $executor_tb->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_phone" class="executor_tb_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->city->Visible) { // city ?>
	<?php if ($executor_tb->SortUrl($executor_tb->city) == "") { ?>
		<td><div id="elh_executor_tb_city" class="executor_tb_city"><div class="ewTableHeaderCaption"><?php echo $executor_tb->city->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_city" class="executor_tb_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->city->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->city->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->city->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->state->Visible) { // state ?>
	<?php if ($executor_tb->SortUrl($executor_tb->state) == "") { ?>
		<td><div id="elh_executor_tb_state" class="executor_tb_state"><div class="ewTableHeaderCaption"><?php echo $executor_tb->state->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_state" class="executor_tb_state">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->state->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->state->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->state->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($executor_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($executor_tb->SortUrl($executor_tb->datecreated) == "") { ?>
		<td><div id="elh_executor_tb_datecreated" class="executor_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $executor_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_executor_tb_datecreated" class="executor_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $executor_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($executor_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($executor_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$executor_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$executor_tb_grid->StartRec = 1;
$executor_tb_grid->StopRec = $executor_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($executor_tb_grid->FormKeyCountName) && ($executor_tb->CurrentAction == "gridadd" || $executor_tb->CurrentAction == "gridedit" || $executor_tb->CurrentAction == "F")) {
		$executor_tb_grid->KeyCount = $objForm->GetValue($executor_tb_grid->FormKeyCountName);
		$executor_tb_grid->StopRec = $executor_tb_grid->StartRec + $executor_tb_grid->KeyCount - 1;
	}
}
$executor_tb_grid->RecCnt = $executor_tb_grid->StartRec - 1;
if ($executor_tb_grid->Recordset && !$executor_tb_grid->Recordset->EOF) {
	$executor_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $executor_tb_grid->StartRec > 1)
		$executor_tb_grid->Recordset->Move($executor_tb_grid->StartRec - 1);
} elseif (!$executor_tb->AllowAddDeleteRow && $executor_tb_grid->StopRec == 0) {
	$executor_tb_grid->StopRec = $executor_tb->GridAddRowCount;
}

// Initialize aggregate
$executor_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$executor_tb->ResetAttrs();
$executor_tb_grid->RenderRow();
if ($executor_tb->CurrentAction == "gridadd")
	$executor_tb_grid->RowIndex = 0;
if ($executor_tb->CurrentAction == "gridedit")
	$executor_tb_grid->RowIndex = 0;
while ($executor_tb_grid->RecCnt < $executor_tb_grid->StopRec) {
	$executor_tb_grid->RecCnt++;
	if (intval($executor_tb_grid->RecCnt) >= intval($executor_tb_grid->StartRec)) {
		$executor_tb_grid->RowCnt++;
		if ($executor_tb->CurrentAction == "gridadd" || $executor_tb->CurrentAction == "gridedit" || $executor_tb->CurrentAction == "F") {
			$executor_tb_grid->RowIndex++;
			$objForm->Index = $executor_tb_grid->RowIndex;
			if ($objForm->HasValue($executor_tb_grid->FormActionName))
				$executor_tb_grid->RowAction = strval($objForm->GetValue($executor_tb_grid->FormActionName));
			elseif ($executor_tb->CurrentAction == "gridadd")
				$executor_tb_grid->RowAction = "insert";
			else
				$executor_tb_grid->RowAction = "";
		}

		// Set up key count
		$executor_tb_grid->KeyCount = $executor_tb_grid->RowIndex;

		// Init row class and style
		$executor_tb->ResetAttrs();
		$executor_tb->CssClass = "";
		if ($executor_tb->CurrentAction == "gridadd") {
			if ($executor_tb->CurrentMode == "copy") {
				$executor_tb_grid->LoadRowValues($executor_tb_grid->Recordset); // Load row values
				$executor_tb_grid->SetRecordKey($executor_tb_grid->RowOldKey, $executor_tb_grid->Recordset); // Set old record key
			} else {
				$executor_tb_grid->LoadDefaultValues(); // Load default values
				$executor_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$executor_tb_grid->LoadRowValues($executor_tb_grid->Recordset); // Load row values
		}
		$executor_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($executor_tb->CurrentAction == "gridadd") // Grid add
			$executor_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($executor_tb->CurrentAction == "gridadd" && $executor_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$executor_tb_grid->RestoreCurrentRowFormValues($executor_tb_grid->RowIndex); // Restore form values
		if ($executor_tb->CurrentAction == "gridedit") { // Grid edit
			if ($executor_tb->EventCancelled) {
				$executor_tb_grid->RestoreCurrentRowFormValues($executor_tb_grid->RowIndex); // Restore form values
			}
			if ($executor_tb_grid->RowAction == "insert")
				$executor_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$executor_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($executor_tb->CurrentAction == "gridedit" && ($executor_tb->RowType == EW_ROWTYPE_EDIT || $executor_tb->RowType == EW_ROWTYPE_ADD) && $executor_tb->EventCancelled) // Update failed
			$executor_tb_grid->RestoreCurrentRowFormValues($executor_tb_grid->RowIndex); // Restore form values
		if ($executor_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$executor_tb_grid->EditRowCnt++;
		if ($executor_tb->CurrentAction == "F") // Confirm row
			$executor_tb_grid->RestoreCurrentRowFormValues($executor_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$executor_tb->RowAttrs = array_merge($executor_tb->RowAttrs, array('data-rowindex'=>$executor_tb_grid->RowCnt, 'id'=>'r' . $executor_tb_grid->RowCnt . '_executor_tb', 'data-rowtype'=>$executor_tb->RowType));

		// Render row
		$executor_tb_grid->RenderRow();

		// Render list options
		$executor_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($executor_tb_grid->RowAction <> "delete" && $executor_tb_grid->RowAction <> "insertdelete" && !($executor_tb_grid->RowAction == "insert" && $executor_tb->CurrentAction == "F" && $executor_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $executor_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$executor_tb_grid->ListOptions->Render("body", "left", $executor_tb_grid->RowCnt);
?>
	<?php if ($executor_tb->id->Visible) { // id ?>
		<td<?php echo $executor_tb->id->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $executor_tb_grid->RowIndex ?>_id" id="o<?php echo $executor_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($executor_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_id" class="control-group executor_tb_id">
<span<?php echo $executor_tb->id->ViewAttributes() ?>>
<?php echo $executor_tb->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $executor_tb_grid->RowIndex ?>_id" id="x<?php echo $executor_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($executor_tb->id->CurrentValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->id->ViewAttributes() ?>>
<?php echo $executor_tb->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $executor_tb_grid->RowIndex ?>_id" id="x<?php echo $executor_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($executor_tb->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $executor_tb_grid->RowIndex ?>_id" id="o<?php echo $executor_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($executor_tb->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->title->Visible) { // title ?>
		<td<?php echo $executor_tb->title->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_title" class="control-group executor_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $executor_tb_grid->RowIndex ?>_title" id="x<?php echo $executor_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $executor_tb->title->PlaceHolder ?>" value="<?php echo $executor_tb->title->EditValue ?>"<?php echo $executor_tb->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $executor_tb_grid->RowIndex ?>_title" id="o<?php echo $executor_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($executor_tb->title->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_title" class="control-group executor_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $executor_tb_grid->RowIndex ?>_title" id="x<?php echo $executor_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $executor_tb->title->PlaceHolder ?>" value="<?php echo $executor_tb->title->EditValue ?>"<?php echo $executor_tb->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->title->ViewAttributes() ?>>
<?php echo $executor_tb->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $executor_tb_grid->RowIndex ?>_title" id="x<?php echo $executor_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($executor_tb->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $executor_tb_grid->RowIndex ?>_title" id="o<?php echo $executor_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($executor_tb->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $executor_tb->fullname->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_fullname" class="control-group executor_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $executor_tb->fullname->PlaceHolder ?>" value="<?php echo $executor_tb->fullname->EditValue ?>"<?php echo $executor_tb->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="o<?php echo $executor_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($executor_tb->fullname->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_fullname" class="control-group executor_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $executor_tb->fullname->PlaceHolder ?>" value="<?php echo $executor_tb->fullname->EditValue ?>"<?php echo $executor_tb->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->fullname->ViewAttributes() ?>>
<?php echo $executor_tb->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($executor_tb->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="o<?php echo $executor_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($executor_tb->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->rtionship->Visible) { // rtionship ?>
		<td<?php echo $executor_tb->rtionship->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_rtionship" class="control-group executor_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $executor_tb->rtionship->PlaceHolder ?>" value="<?php echo $executor_tb->rtionship->EditValue ?>"<?php echo $executor_tb->rtionship->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $executor_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($executor_tb->rtionship->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_rtionship" class="control-group executor_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $executor_tb->rtionship->PlaceHolder ?>" value="<?php echo $executor_tb->rtionship->EditValue ?>"<?php echo $executor_tb->rtionship->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->rtionship->ViewAttributes() ?>>
<?php echo $executor_tb->rtionship->ListViewValue() ?></span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($executor_tb->rtionship->FormValue) ?>">
<input type="hidden" data-field="x_rtionship" name="o<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $executor_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($executor_tb->rtionship->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->_email->Visible) { // email ?>
		<td<?php echo $executor_tb->_email->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb__email" class="control-group executor_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $executor_tb_grid->RowIndex ?>__email" id="x<?php echo $executor_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $executor_tb->_email->PlaceHolder ?>" value="<?php echo $executor_tb->_email->EditValue ?>"<?php echo $executor_tb->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $executor_tb_grid->RowIndex ?>__email" id="o<?php echo $executor_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($executor_tb->_email->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb__email" class="control-group executor_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $executor_tb_grid->RowIndex ?>__email" id="x<?php echo $executor_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $executor_tb->_email->PlaceHolder ?>" value="<?php echo $executor_tb->_email->EditValue ?>"<?php echo $executor_tb->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->_email->ViewAttributes() ?>>
<?php echo $executor_tb->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $executor_tb_grid->RowIndex ?>__email" id="x<?php echo $executor_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($executor_tb->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $executor_tb_grid->RowIndex ?>__email" id="o<?php echo $executor_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($executor_tb->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->phone->Visible) { // phone ?>
		<td<?php echo $executor_tb->phone->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_phone" class="control-group executor_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $executor_tb_grid->RowIndex ?>_phone" id="x<?php echo $executor_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $executor_tb->phone->PlaceHolder ?>" value="<?php echo $executor_tb->phone->EditValue ?>"<?php echo $executor_tb->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $executor_tb_grid->RowIndex ?>_phone" id="o<?php echo $executor_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($executor_tb->phone->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_phone" class="control-group executor_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $executor_tb_grid->RowIndex ?>_phone" id="x<?php echo $executor_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $executor_tb->phone->PlaceHolder ?>" value="<?php echo $executor_tb->phone->EditValue ?>"<?php echo $executor_tb->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->phone->ViewAttributes() ?>>
<?php echo $executor_tb->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $executor_tb_grid->RowIndex ?>_phone" id="x<?php echo $executor_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($executor_tb->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $executor_tb_grid->RowIndex ?>_phone" id="o<?php echo $executor_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($executor_tb->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->city->Visible) { // city ?>
		<td<?php echo $executor_tb->city->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_city" class="control-group executor_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $executor_tb_grid->RowIndex ?>_city" id="x<?php echo $executor_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $executor_tb->city->PlaceHolder ?>" value="<?php echo $executor_tb->city->EditValue ?>"<?php echo $executor_tb->city->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_city" name="o<?php echo $executor_tb_grid->RowIndex ?>_city" id="o<?php echo $executor_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($executor_tb->city->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_city" class="control-group executor_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $executor_tb_grid->RowIndex ?>_city" id="x<?php echo $executor_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $executor_tb->city->PlaceHolder ?>" value="<?php echo $executor_tb->city->EditValue ?>"<?php echo $executor_tb->city->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->city->ViewAttributes() ?>>
<?php echo $executor_tb->city->ListViewValue() ?></span>
<input type="hidden" data-field="x_city" name="x<?php echo $executor_tb_grid->RowIndex ?>_city" id="x<?php echo $executor_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($executor_tb->city->FormValue) ?>">
<input type="hidden" data-field="x_city" name="o<?php echo $executor_tb_grid->RowIndex ?>_city" id="o<?php echo $executor_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($executor_tb->city->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->state->Visible) { // state ?>
		<td<?php echo $executor_tb->state->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_state" class="control-group executor_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $executor_tb_grid->RowIndex ?>_state" id="x<?php echo $executor_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $executor_tb->state->PlaceHolder ?>" value="<?php echo $executor_tb->state->EditValue ?>"<?php echo $executor_tb->state->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_state" name="o<?php echo $executor_tb_grid->RowIndex ?>_state" id="o<?php echo $executor_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($executor_tb->state->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_state" class="control-group executor_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $executor_tb_grid->RowIndex ?>_state" id="x<?php echo $executor_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $executor_tb->state->PlaceHolder ?>" value="<?php echo $executor_tb->state->EditValue ?>"<?php echo $executor_tb->state->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->state->ViewAttributes() ?>>
<?php echo $executor_tb->state->ListViewValue() ?></span>
<input type="hidden" data-field="x_state" name="x<?php echo $executor_tb_grid->RowIndex ?>_state" id="x<?php echo $executor_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($executor_tb->state->FormValue) ?>">
<input type="hidden" data-field="x_state" name="o<?php echo $executor_tb_grid->RowIndex ?>_state" id="o<?php echo $executor_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($executor_tb->state->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($executor_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $executor_tb->datecreated->CellAttributes() ?>>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_datecreated" class="control-group executor_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $executor_tb->datecreated->PlaceHolder ?>" value="<?php echo $executor_tb->datecreated->EditValue ?>"<?php echo $executor_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $executor_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($executor_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $executor_tb_grid->RowCnt ?>_executor_tb_datecreated" class="control-group executor_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $executor_tb->datecreated->PlaceHolder ?>" value="<?php echo $executor_tb->datecreated->EditValue ?>"<?php echo $executor_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($executor_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $executor_tb->datecreated->ViewAttributes() ?>>
<?php echo $executor_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($executor_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $executor_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($executor_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $executor_tb_grid->PageObjName . "_row_" . $executor_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$executor_tb_grid->ListOptions->Render("body", "right", $executor_tb_grid->RowCnt);
?>
	</tr>
<?php if ($executor_tb->RowType == EW_ROWTYPE_ADD || $executor_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fexecutor_tbgrid.UpdateOpts(<?php echo $executor_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($executor_tb->CurrentAction <> "gridadd" || $executor_tb->CurrentMode == "copy")
		if (!$executor_tb_grid->Recordset->EOF) $executor_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($executor_tb->CurrentMode == "add" || $executor_tb->CurrentMode == "copy" || $executor_tb->CurrentMode == "edit") {
		$executor_tb_grid->RowIndex = '$rowindex$';
		$executor_tb_grid->LoadDefaultValues();

		// Set row properties
		$executor_tb->ResetAttrs();
		$executor_tb->RowAttrs = array_merge($executor_tb->RowAttrs, array('data-rowindex'=>$executor_tb_grid->RowIndex, 'id'=>'r0_executor_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($executor_tb->RowAttrs["class"], "ewTemplate");
		$executor_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$executor_tb_grid->RenderRow();

		// Render list options
		$executor_tb_grid->RenderListOptions();
		$executor_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $executor_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$executor_tb_grid->ListOptions->Render("body", "left", $executor_tb_grid->RowIndex);
?>
	<?php if ($executor_tb->id->Visible) { // id ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_id" class="control-group executor_tb_id">
<span<?php echo $executor_tb->id->ViewAttributes() ?>>
<?php echo $executor_tb->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $executor_tb_grid->RowIndex ?>_id" id="x<?php echo $executor_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($executor_tb->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $executor_tb_grid->RowIndex ?>_id" id="o<?php echo $executor_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($executor_tb->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->title->Visible) { // title ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_title" class="control-group executor_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $executor_tb_grid->RowIndex ?>_title" id="x<?php echo $executor_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $executor_tb->title->PlaceHolder ?>" value="<?php echo $executor_tb->title->EditValue ?>"<?php echo $executor_tb->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_title" class="control-group executor_tb_title">
<span<?php echo $executor_tb->title->ViewAttributes() ?>>
<?php echo $executor_tb->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $executor_tb_grid->RowIndex ?>_title" id="x<?php echo $executor_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($executor_tb->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $executor_tb_grid->RowIndex ?>_title" id="o<?php echo $executor_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($executor_tb->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->fullname->Visible) { // fullname ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_fullname" class="control-group executor_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $executor_tb->fullname->PlaceHolder ?>" value="<?php echo $executor_tb->fullname->EditValue ?>"<?php echo $executor_tb->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_fullname" class="control-group executor_tb_fullname">
<span<?php echo $executor_tb->fullname->ViewAttributes() ?>>
<?php echo $executor_tb->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="x<?php echo $executor_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($executor_tb->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $executor_tb_grid->RowIndex ?>_fullname" id="o<?php echo $executor_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($executor_tb->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->rtionship->Visible) { // rtionship ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_rtionship" class="control-group executor_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $executor_tb->rtionship->PlaceHolder ?>" value="<?php echo $executor_tb->rtionship->EditValue ?>"<?php echo $executor_tb->rtionship->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_rtionship" class="control-group executor_tb_rtionship">
<span<?php echo $executor_tb->rtionship->ViewAttributes() ?>>
<?php echo $executor_tb->rtionship->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $executor_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($executor_tb->rtionship->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $executor_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $executor_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($executor_tb->rtionship->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->_email->Visible) { // email ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb__email" class="control-group executor_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $executor_tb_grid->RowIndex ?>__email" id="x<?php echo $executor_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $executor_tb->_email->PlaceHolder ?>" value="<?php echo $executor_tb->_email->EditValue ?>"<?php echo $executor_tb->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb__email" class="control-group executor_tb__email">
<span<?php echo $executor_tb->_email->ViewAttributes() ?>>
<?php echo $executor_tb->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $executor_tb_grid->RowIndex ?>__email" id="x<?php echo $executor_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($executor_tb->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $executor_tb_grid->RowIndex ?>__email" id="o<?php echo $executor_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($executor_tb->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->phone->Visible) { // phone ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_phone" class="control-group executor_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $executor_tb_grid->RowIndex ?>_phone" id="x<?php echo $executor_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $executor_tb->phone->PlaceHolder ?>" value="<?php echo $executor_tb->phone->EditValue ?>"<?php echo $executor_tb->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_phone" class="control-group executor_tb_phone">
<span<?php echo $executor_tb->phone->ViewAttributes() ?>>
<?php echo $executor_tb->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $executor_tb_grid->RowIndex ?>_phone" id="x<?php echo $executor_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($executor_tb->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $executor_tb_grid->RowIndex ?>_phone" id="o<?php echo $executor_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($executor_tb->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->city->Visible) { // city ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_city" class="control-group executor_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $executor_tb_grid->RowIndex ?>_city" id="x<?php echo $executor_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $executor_tb->city->PlaceHolder ?>" value="<?php echo $executor_tb->city->EditValue ?>"<?php echo $executor_tb->city->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_city" class="control-group executor_tb_city">
<span<?php echo $executor_tb->city->ViewAttributes() ?>>
<?php echo $executor_tb->city->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_city" name="x<?php echo $executor_tb_grid->RowIndex ?>_city" id="x<?php echo $executor_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($executor_tb->city->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_city" name="o<?php echo $executor_tb_grid->RowIndex ?>_city" id="o<?php echo $executor_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($executor_tb->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->state->Visible) { // state ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_state" class="control-group executor_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $executor_tb_grid->RowIndex ?>_state" id="x<?php echo $executor_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $executor_tb->state->PlaceHolder ?>" value="<?php echo $executor_tb->state->EditValue ?>"<?php echo $executor_tb->state->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_state" class="control-group executor_tb_state">
<span<?php echo $executor_tb->state->ViewAttributes() ?>>
<?php echo $executor_tb->state->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_state" name="x<?php echo $executor_tb_grid->RowIndex ?>_state" id="x<?php echo $executor_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($executor_tb->state->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_state" name="o<?php echo $executor_tb_grid->RowIndex ?>_state" id="o<?php echo $executor_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($executor_tb->state->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($executor_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($executor_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_executor_tb_datecreated" class="control-group executor_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $executor_tb->datecreated->PlaceHolder ?>" value="<?php echo $executor_tb->datecreated->EditValue ?>"<?php echo $executor_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_executor_tb_datecreated" class="control-group executor_tb_datecreated">
<span<?php echo $executor_tb->datecreated->ViewAttributes() ?>>
<?php echo $executor_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $executor_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($executor_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $executor_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $executor_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($executor_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$executor_tb_grid->ListOptions->Render("body", "right", $executor_tb_grid->RowCnt);
?>
<script type="text/javascript">
fexecutor_tbgrid.UpdateOpts(<?php echo $executor_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($executor_tb->CurrentMode == "add" || $executor_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $executor_tb_grid->FormKeyCountName ?>" id="<?php echo $executor_tb_grid->FormKeyCountName ?>" value="<?php echo $executor_tb_grid->KeyCount ?>">
<?php echo $executor_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($executor_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $executor_tb_grid->FormKeyCountName ?>" id="<?php echo $executor_tb_grid->FormKeyCountName ?>" value="<?php echo $executor_tb_grid->KeyCount ?>">
<?php echo $executor_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($executor_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fexecutor_tbgrid">
</div>
<?php

// Close recordset
if ($executor_tb_grid->Recordset)
	$executor_tb_grid->Recordset->Close();
?>
<?php if ($executor_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($executor_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($executor_tb->Export == "") { ?>
<script type="text/javascript">
fexecutor_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$executor_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$executor_tb_grid->Page_Terminate();
?>
