<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($trustee_tb_grid)) $trustee_tb_grid = new ctrustee_tb_grid();

// Page init
$trustee_tb_grid->Page_Init();

// Page main
$trustee_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$trustee_tb_grid->Page_Render();
?>
<?php if ($trustee_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var trustee_tb_grid = new ew_Page("trustee_tb_grid");
trustee_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = trustee_tb_grid.PageID; // For backward compatibility

// Form object
var ftrustee_tbgrid = new ew_Form("ftrustee_tbgrid");
ftrustee_tbgrid.FormKeyCountName = '<?php echo $trustee_tb_grid->FormKeyCountName ?>';

// Validate form
ftrustee_tbgrid.Validate = function() {
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
ftrustee_tbgrid.EmptyRow = function(infix) {
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
ftrustee_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftrustee_tbgrid.ValidateRequired = true;
<?php } else { ?>
ftrustee_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($trustee_tb->getCurrentMasterTable() == "" && $trustee_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $trustee_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($trustee_tb->CurrentAction == "gridadd") {
	if ($trustee_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$trustee_tb_grid->TotalRecs = $trustee_tb->SelectRecordCount();
			$trustee_tb_grid->Recordset = $trustee_tb_grid->LoadRecordset($trustee_tb_grid->StartRec-1, $trustee_tb_grid->DisplayRecs);
		} else {
			if ($trustee_tb_grid->Recordset = $trustee_tb_grid->LoadRecordset())
				$trustee_tb_grid->TotalRecs = $trustee_tb_grid->Recordset->RecordCount();
		}
		$trustee_tb_grid->StartRec = 1;
		$trustee_tb_grid->DisplayRecs = $trustee_tb_grid->TotalRecs;
	} else {
		$trustee_tb->CurrentFilter = "0=1";
		$trustee_tb_grid->StartRec = 1;
		$trustee_tb_grid->DisplayRecs = $trustee_tb->GridAddRowCount;
	}
	$trustee_tb_grid->TotalRecs = $trustee_tb_grid->DisplayRecs;
	$trustee_tb_grid->StopRec = $trustee_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$trustee_tb_grid->TotalRecs = $trustee_tb->SelectRecordCount();
	} else {
		if ($trustee_tb_grid->Recordset = $trustee_tb_grid->LoadRecordset())
			$trustee_tb_grid->TotalRecs = $trustee_tb_grid->Recordset->RecordCount();
	}
	$trustee_tb_grid->StartRec = 1;
	$trustee_tb_grid->DisplayRecs = $trustee_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$trustee_tb_grid->Recordset = $trustee_tb_grid->LoadRecordset($trustee_tb_grid->StartRec-1, $trustee_tb_grid->DisplayRecs);
}
$trustee_tb_grid->RenderOtherOptions();
?>
<?php $trustee_tb_grid->ShowPageHeader(); ?>
<?php
$trustee_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="ftrustee_tbgrid" class="ewForm form-horizontal">
<div id="gmp_trustee_tb" class="ewGridMiddlePanel">
<table id="tbl_trustee_tbgrid" class="ewTable ewTableSeparate">
<?php echo $trustee_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$trustee_tb_grid->RenderListOptions();

// Render list options (header, left)
$trustee_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($trustee_tb->id->Visible) { // id ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->id) == "") { ?>
		<td><div id="elh_trustee_tb_id" class="trustee_tb_id"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_id" class="trustee_tb_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->title->Visible) { // title ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->title) == "") { ?>
		<td><div id="elh_trustee_tb_title" class="trustee_tb_title"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_title" class="trustee_tb_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->fullname->Visible) { // fullname ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->fullname) == "") { ?>
		<td><div id="elh_trustee_tb_fullname" class="trustee_tb_fullname"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_fullname" class="trustee_tb_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->rtionship->Visible) { // rtionship ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->rtionship) == "") { ?>
		<td><div id="elh_trustee_tb_rtionship" class="trustee_tb_rtionship"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->rtionship->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_rtionship" class="trustee_tb_rtionship">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->rtionship->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->rtionship->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->rtionship->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->_email->Visible) { // email ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->_email) == "") { ?>
		<td><div id="elh_trustee_tb__email" class="trustee_tb__email"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb__email" class="trustee_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->phone->Visible) { // phone ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->phone) == "") { ?>
		<td><div id="elh_trustee_tb_phone" class="trustee_tb_phone"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_phone" class="trustee_tb_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->city->Visible) { // city ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->city) == "") { ?>
		<td><div id="elh_trustee_tb_city" class="trustee_tb_city"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->city->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_city" class="trustee_tb_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->city->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->city->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->city->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->state->Visible) { // state ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->state) == "") { ?>
		<td><div id="elh_trustee_tb_state" class="trustee_tb_state"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->state->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_state" class="trustee_tb_state">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->state->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->state->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->state->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($trustee_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($trustee_tb->SortUrl($trustee_tb->datecreated) == "") { ?>
		<td><div id="elh_trustee_tb_datecreated" class="trustee_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $trustee_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_trustee_tb_datecreated" class="trustee_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $trustee_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($trustee_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($trustee_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$trustee_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$trustee_tb_grid->StartRec = 1;
$trustee_tb_grid->StopRec = $trustee_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($trustee_tb_grid->FormKeyCountName) && ($trustee_tb->CurrentAction == "gridadd" || $trustee_tb->CurrentAction == "gridedit" || $trustee_tb->CurrentAction == "F")) {
		$trustee_tb_grid->KeyCount = $objForm->GetValue($trustee_tb_grid->FormKeyCountName);
		$trustee_tb_grid->StopRec = $trustee_tb_grid->StartRec + $trustee_tb_grid->KeyCount - 1;
	}
}
$trustee_tb_grid->RecCnt = $trustee_tb_grid->StartRec - 1;
if ($trustee_tb_grid->Recordset && !$trustee_tb_grid->Recordset->EOF) {
	$trustee_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $trustee_tb_grid->StartRec > 1)
		$trustee_tb_grid->Recordset->Move($trustee_tb_grid->StartRec - 1);
} elseif (!$trustee_tb->AllowAddDeleteRow && $trustee_tb_grid->StopRec == 0) {
	$trustee_tb_grid->StopRec = $trustee_tb->GridAddRowCount;
}

// Initialize aggregate
$trustee_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$trustee_tb->ResetAttrs();
$trustee_tb_grid->RenderRow();
if ($trustee_tb->CurrentAction == "gridadd")
	$trustee_tb_grid->RowIndex = 0;
if ($trustee_tb->CurrentAction == "gridedit")
	$trustee_tb_grid->RowIndex = 0;
while ($trustee_tb_grid->RecCnt < $trustee_tb_grid->StopRec) {
	$trustee_tb_grid->RecCnt++;
	if (intval($trustee_tb_grid->RecCnt) >= intval($trustee_tb_grid->StartRec)) {
		$trustee_tb_grid->RowCnt++;
		if ($trustee_tb->CurrentAction == "gridadd" || $trustee_tb->CurrentAction == "gridedit" || $trustee_tb->CurrentAction == "F") {
			$trustee_tb_grid->RowIndex++;
			$objForm->Index = $trustee_tb_grid->RowIndex;
			if ($objForm->HasValue($trustee_tb_grid->FormActionName))
				$trustee_tb_grid->RowAction = strval($objForm->GetValue($trustee_tb_grid->FormActionName));
			elseif ($trustee_tb->CurrentAction == "gridadd")
				$trustee_tb_grid->RowAction = "insert";
			else
				$trustee_tb_grid->RowAction = "";
		}

		// Set up key count
		$trustee_tb_grid->KeyCount = $trustee_tb_grid->RowIndex;

		// Init row class and style
		$trustee_tb->ResetAttrs();
		$trustee_tb->CssClass = "";
		if ($trustee_tb->CurrentAction == "gridadd") {
			if ($trustee_tb->CurrentMode == "copy") {
				$trustee_tb_grid->LoadRowValues($trustee_tb_grid->Recordset); // Load row values
				$trustee_tb_grid->SetRecordKey($trustee_tb_grid->RowOldKey, $trustee_tb_grid->Recordset); // Set old record key
			} else {
				$trustee_tb_grid->LoadDefaultValues(); // Load default values
				$trustee_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$trustee_tb_grid->LoadRowValues($trustee_tb_grid->Recordset); // Load row values
		}
		$trustee_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($trustee_tb->CurrentAction == "gridadd") // Grid add
			$trustee_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($trustee_tb->CurrentAction == "gridadd" && $trustee_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$trustee_tb_grid->RestoreCurrentRowFormValues($trustee_tb_grid->RowIndex); // Restore form values
		if ($trustee_tb->CurrentAction == "gridedit") { // Grid edit
			if ($trustee_tb->EventCancelled) {
				$trustee_tb_grid->RestoreCurrentRowFormValues($trustee_tb_grid->RowIndex); // Restore form values
			}
			if ($trustee_tb_grid->RowAction == "insert")
				$trustee_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$trustee_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($trustee_tb->CurrentAction == "gridedit" && ($trustee_tb->RowType == EW_ROWTYPE_EDIT || $trustee_tb->RowType == EW_ROWTYPE_ADD) && $trustee_tb->EventCancelled) // Update failed
			$trustee_tb_grid->RestoreCurrentRowFormValues($trustee_tb_grid->RowIndex); // Restore form values
		if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$trustee_tb_grid->EditRowCnt++;
		if ($trustee_tb->CurrentAction == "F") // Confirm row
			$trustee_tb_grid->RestoreCurrentRowFormValues($trustee_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$trustee_tb->RowAttrs = array_merge($trustee_tb->RowAttrs, array('data-rowindex'=>$trustee_tb_grid->RowCnt, 'id'=>'r' . $trustee_tb_grid->RowCnt . '_trustee_tb', 'data-rowtype'=>$trustee_tb->RowType));

		// Render row
		$trustee_tb_grid->RenderRow();

		// Render list options
		$trustee_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($trustee_tb_grid->RowAction <> "delete" && $trustee_tb_grid->RowAction <> "insertdelete" && !($trustee_tb_grid->RowAction == "insert" && $trustee_tb->CurrentAction == "F" && $trustee_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $trustee_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trustee_tb_grid->ListOptions->Render("body", "left", $trustee_tb_grid->RowCnt);
?>
	<?php if ($trustee_tb->id->Visible) { // id ?>
		<td<?php echo $trustee_tb->id->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $trustee_tb_grid->RowIndex ?>_id" id="o<?php echo $trustee_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trustee_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_id" class="control-group trustee_tb_id">
<span<?php echo $trustee_tb->id->ViewAttributes() ?>>
<?php echo $trustee_tb->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $trustee_tb_grid->RowIndex ?>_id" id="x<?php echo $trustee_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trustee_tb->id->CurrentValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->id->ViewAttributes() ?>>
<?php echo $trustee_tb->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $trustee_tb_grid->RowIndex ?>_id" id="x<?php echo $trustee_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trustee_tb->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $trustee_tb_grid->RowIndex ?>_id" id="o<?php echo $trustee_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trustee_tb->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->title->Visible) { // title ?>
		<td<?php echo $trustee_tb->title->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_title" class="control-group trustee_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $trustee_tb_grid->RowIndex ?>_title" id="x<?php echo $trustee_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->title->PlaceHolder ?>" value="<?php echo $trustee_tb->title->EditValue ?>"<?php echo $trustee_tb->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $trustee_tb_grid->RowIndex ?>_title" id="o<?php echo $trustee_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($trustee_tb->title->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_title" class="control-group trustee_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $trustee_tb_grid->RowIndex ?>_title" id="x<?php echo $trustee_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->title->PlaceHolder ?>" value="<?php echo $trustee_tb->title->EditValue ?>"<?php echo $trustee_tb->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->title->ViewAttributes() ?>>
<?php echo $trustee_tb->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $trustee_tb_grid->RowIndex ?>_title" id="x<?php echo $trustee_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($trustee_tb->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $trustee_tb_grid->RowIndex ?>_title" id="o<?php echo $trustee_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($trustee_tb->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $trustee_tb->fullname->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_fullname" class="control-group trustee_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $trustee_tb->fullname->PlaceHolder ?>" value="<?php echo $trustee_tb->fullname->EditValue ?>"<?php echo $trustee_tb->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="o<?php echo $trustee_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($trustee_tb->fullname->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_fullname" class="control-group trustee_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $trustee_tb->fullname->PlaceHolder ?>" value="<?php echo $trustee_tb->fullname->EditValue ?>"<?php echo $trustee_tb->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->fullname->ViewAttributes() ?>>
<?php echo $trustee_tb->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($trustee_tb->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="o<?php echo $trustee_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($trustee_tb->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->rtionship->Visible) { // rtionship ?>
		<td<?php echo $trustee_tb->rtionship->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_rtionship" class="control-group trustee_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->rtionship->PlaceHolder ?>" value="<?php echo $trustee_tb->rtionship->EditValue ?>"<?php echo $trustee_tb->rtionship->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($trustee_tb->rtionship->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_rtionship" class="control-group trustee_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->rtionship->PlaceHolder ?>" value="<?php echo $trustee_tb->rtionship->EditValue ?>"<?php echo $trustee_tb->rtionship->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->rtionship->ViewAttributes() ?>>
<?php echo $trustee_tb->rtionship->ListViewValue() ?></span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($trustee_tb->rtionship->FormValue) ?>">
<input type="hidden" data-field="x_rtionship" name="o<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($trustee_tb->rtionship->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->_email->Visible) { // email ?>
		<td<?php echo $trustee_tb->_email->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb__email" class="control-group trustee_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $trustee_tb_grid->RowIndex ?>__email" id="x<?php echo $trustee_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $trustee_tb->_email->PlaceHolder ?>" value="<?php echo $trustee_tb->_email->EditValue ?>"<?php echo $trustee_tb->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $trustee_tb_grid->RowIndex ?>__email" id="o<?php echo $trustee_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($trustee_tb->_email->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb__email" class="control-group trustee_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $trustee_tb_grid->RowIndex ?>__email" id="x<?php echo $trustee_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $trustee_tb->_email->PlaceHolder ?>" value="<?php echo $trustee_tb->_email->EditValue ?>"<?php echo $trustee_tb->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->_email->ViewAttributes() ?>>
<?php echo $trustee_tb->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $trustee_tb_grid->RowIndex ?>__email" id="x<?php echo $trustee_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($trustee_tb->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $trustee_tb_grid->RowIndex ?>__email" id="o<?php echo $trustee_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($trustee_tb->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->phone->Visible) { // phone ?>
		<td<?php echo $trustee_tb->phone->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_phone" class="control-group trustee_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->phone->PlaceHolder ?>" value="<?php echo $trustee_tb->phone->EditValue ?>"<?php echo $trustee_tb->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="o<?php echo $trustee_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($trustee_tb->phone->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_phone" class="control-group trustee_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->phone->PlaceHolder ?>" value="<?php echo $trustee_tb->phone->EditValue ?>"<?php echo $trustee_tb->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->phone->ViewAttributes() ?>>
<?php echo $trustee_tb->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($trustee_tb->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="o<?php echo $trustee_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($trustee_tb->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->city->Visible) { // city ?>
		<td<?php echo $trustee_tb->city->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_city" class="control-group trustee_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $trustee_tb_grid->RowIndex ?>_city" id="x<?php echo $trustee_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->city->PlaceHolder ?>" value="<?php echo $trustee_tb->city->EditValue ?>"<?php echo $trustee_tb->city->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_city" name="o<?php echo $trustee_tb_grid->RowIndex ?>_city" id="o<?php echo $trustee_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($trustee_tb->city->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_city" class="control-group trustee_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $trustee_tb_grid->RowIndex ?>_city" id="x<?php echo $trustee_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->city->PlaceHolder ?>" value="<?php echo $trustee_tb->city->EditValue ?>"<?php echo $trustee_tb->city->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->city->ViewAttributes() ?>>
<?php echo $trustee_tb->city->ListViewValue() ?></span>
<input type="hidden" data-field="x_city" name="x<?php echo $trustee_tb_grid->RowIndex ?>_city" id="x<?php echo $trustee_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($trustee_tb->city->FormValue) ?>">
<input type="hidden" data-field="x_city" name="o<?php echo $trustee_tb_grid->RowIndex ?>_city" id="o<?php echo $trustee_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($trustee_tb->city->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->state->Visible) { // state ?>
		<td<?php echo $trustee_tb->state->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_state" class="control-group trustee_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $trustee_tb_grid->RowIndex ?>_state" id="x<?php echo $trustee_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->state->PlaceHolder ?>" value="<?php echo $trustee_tb->state->EditValue ?>"<?php echo $trustee_tb->state->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_state" name="o<?php echo $trustee_tb_grid->RowIndex ?>_state" id="o<?php echo $trustee_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($trustee_tb->state->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_state" class="control-group trustee_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $trustee_tb_grid->RowIndex ?>_state" id="x<?php echo $trustee_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->state->PlaceHolder ?>" value="<?php echo $trustee_tb->state->EditValue ?>"<?php echo $trustee_tb->state->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->state->ViewAttributes() ?>>
<?php echo $trustee_tb->state->ListViewValue() ?></span>
<input type="hidden" data-field="x_state" name="x<?php echo $trustee_tb_grid->RowIndex ?>_state" id="x<?php echo $trustee_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($trustee_tb->state->FormValue) ?>">
<input type="hidden" data-field="x_state" name="o<?php echo $trustee_tb_grid->RowIndex ?>_state" id="o<?php echo $trustee_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($trustee_tb->state->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($trustee_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $trustee_tb->datecreated->CellAttributes() ?>>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_datecreated" class="control-group trustee_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $trustee_tb->datecreated->PlaceHolder ?>" value="<?php echo $trustee_tb->datecreated->EditValue ?>"<?php echo $trustee_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($trustee_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $trustee_tb_grid->RowCnt ?>_trustee_tb_datecreated" class="control-group trustee_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $trustee_tb->datecreated->PlaceHolder ?>" value="<?php echo $trustee_tb->datecreated->EditValue ?>"<?php echo $trustee_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $trustee_tb->datecreated->ViewAttributes() ?>>
<?php echo $trustee_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($trustee_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($trustee_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $trustee_tb_grid->PageObjName . "_row_" . $trustee_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$trustee_tb_grid->ListOptions->Render("body", "right", $trustee_tb_grid->RowCnt);
?>
	</tr>
<?php if ($trustee_tb->RowType == EW_ROWTYPE_ADD || $trustee_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftrustee_tbgrid.UpdateOpts(<?php echo $trustee_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($trustee_tb->CurrentAction <> "gridadd" || $trustee_tb->CurrentMode == "copy")
		if (!$trustee_tb_grid->Recordset->EOF) $trustee_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($trustee_tb->CurrentMode == "add" || $trustee_tb->CurrentMode == "copy" || $trustee_tb->CurrentMode == "edit") {
		$trustee_tb_grid->RowIndex = '$rowindex$';
		$trustee_tb_grid->LoadDefaultValues();

		// Set row properties
		$trustee_tb->ResetAttrs();
		$trustee_tb->RowAttrs = array_merge($trustee_tb->RowAttrs, array('data-rowindex'=>$trustee_tb_grid->RowIndex, 'id'=>'r0_trustee_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($trustee_tb->RowAttrs["class"], "ewTemplate");
		$trustee_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$trustee_tb_grid->RenderRow();

		// Render list options
		$trustee_tb_grid->RenderListOptions();
		$trustee_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $trustee_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$trustee_tb_grid->ListOptions->Render("body", "left", $trustee_tb_grid->RowIndex);
?>
	<?php if ($trustee_tb->id->Visible) { // id ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_id" class="control-group trustee_tb_id">
<span<?php echo $trustee_tb->id->ViewAttributes() ?>>
<?php echo $trustee_tb->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $trustee_tb_grid->RowIndex ?>_id" id="x<?php echo $trustee_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trustee_tb->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $trustee_tb_grid->RowIndex ?>_id" id="o<?php echo $trustee_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($trustee_tb->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->title->Visible) { // title ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_title" class="control-group trustee_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $trustee_tb_grid->RowIndex ?>_title" id="x<?php echo $trustee_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->title->PlaceHolder ?>" value="<?php echo $trustee_tb->title->EditValue ?>"<?php echo $trustee_tb->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_title" class="control-group trustee_tb_title">
<span<?php echo $trustee_tb->title->ViewAttributes() ?>>
<?php echo $trustee_tb->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $trustee_tb_grid->RowIndex ?>_title" id="x<?php echo $trustee_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($trustee_tb->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $trustee_tb_grid->RowIndex ?>_title" id="o<?php echo $trustee_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($trustee_tb->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->fullname->Visible) { // fullname ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_fullname" class="control-group trustee_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $trustee_tb->fullname->PlaceHolder ?>" value="<?php echo $trustee_tb->fullname->EditValue ?>"<?php echo $trustee_tb->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_fullname" class="control-group trustee_tb_fullname">
<span<?php echo $trustee_tb->fullname->ViewAttributes() ?>>
<?php echo $trustee_tb->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="x<?php echo $trustee_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($trustee_tb->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $trustee_tb_grid->RowIndex ?>_fullname" id="o<?php echo $trustee_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($trustee_tb->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->rtionship->Visible) { // rtionship ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_rtionship" class="control-group trustee_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->rtionship->PlaceHolder ?>" value="<?php echo $trustee_tb->rtionship->EditValue ?>"<?php echo $trustee_tb->rtionship->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_rtionship" class="control-group trustee_tb_rtionship">
<span<?php echo $trustee_tb->rtionship->ViewAttributes() ?>>
<?php echo $trustee_tb->rtionship->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($trustee_tb->rtionship->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $trustee_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($trustee_tb->rtionship->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->_email->Visible) { // email ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb__email" class="control-group trustee_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $trustee_tb_grid->RowIndex ?>__email" id="x<?php echo $trustee_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $trustee_tb->_email->PlaceHolder ?>" value="<?php echo $trustee_tb->_email->EditValue ?>"<?php echo $trustee_tb->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb__email" class="control-group trustee_tb__email">
<span<?php echo $trustee_tb->_email->ViewAttributes() ?>>
<?php echo $trustee_tb->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $trustee_tb_grid->RowIndex ?>__email" id="x<?php echo $trustee_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($trustee_tb->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $trustee_tb_grid->RowIndex ?>__email" id="o<?php echo $trustee_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($trustee_tb->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->phone->Visible) { // phone ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_phone" class="control-group trustee_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->phone->PlaceHolder ?>" value="<?php echo $trustee_tb->phone->EditValue ?>"<?php echo $trustee_tb->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_phone" class="control-group trustee_tb_phone">
<span<?php echo $trustee_tb->phone->ViewAttributes() ?>>
<?php echo $trustee_tb->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="x<?php echo $trustee_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($trustee_tb->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $trustee_tb_grid->RowIndex ?>_phone" id="o<?php echo $trustee_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($trustee_tb->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->city->Visible) { // city ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_city" class="control-group trustee_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $trustee_tb_grid->RowIndex ?>_city" id="x<?php echo $trustee_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->city->PlaceHolder ?>" value="<?php echo $trustee_tb->city->EditValue ?>"<?php echo $trustee_tb->city->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_city" class="control-group trustee_tb_city">
<span<?php echo $trustee_tb->city->ViewAttributes() ?>>
<?php echo $trustee_tb->city->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_city" name="x<?php echo $trustee_tb_grid->RowIndex ?>_city" id="x<?php echo $trustee_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($trustee_tb->city->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_city" name="o<?php echo $trustee_tb_grid->RowIndex ?>_city" id="o<?php echo $trustee_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($trustee_tb->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->state->Visible) { // state ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_state" class="control-group trustee_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $trustee_tb_grid->RowIndex ?>_state" id="x<?php echo $trustee_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $trustee_tb->state->PlaceHolder ?>" value="<?php echo $trustee_tb->state->EditValue ?>"<?php echo $trustee_tb->state->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_state" class="control-group trustee_tb_state">
<span<?php echo $trustee_tb->state->ViewAttributes() ?>>
<?php echo $trustee_tb->state->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_state" name="x<?php echo $trustee_tb_grid->RowIndex ?>_state" id="x<?php echo $trustee_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($trustee_tb->state->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_state" name="o<?php echo $trustee_tb_grid->RowIndex ?>_state" id="o<?php echo $trustee_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($trustee_tb->state->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($trustee_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($trustee_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_trustee_tb_datecreated" class="control-group trustee_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $trustee_tb->datecreated->PlaceHolder ?>" value="<?php echo $trustee_tb->datecreated->EditValue ?>"<?php echo $trustee_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_trustee_tb_datecreated" class="control-group trustee_tb_datecreated">
<span<?php echo $trustee_tb->datecreated->ViewAttributes() ?>>
<?php echo $trustee_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($trustee_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $trustee_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($trustee_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$trustee_tb_grid->ListOptions->Render("body", "right", $trustee_tb_grid->RowCnt);
?>
<script type="text/javascript">
ftrustee_tbgrid.UpdateOpts(<?php echo $trustee_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($trustee_tb->CurrentMode == "add" || $trustee_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $trustee_tb_grid->FormKeyCountName ?>" id="<?php echo $trustee_tb_grid->FormKeyCountName ?>" value="<?php echo $trustee_tb_grid->KeyCount ?>">
<?php echo $trustee_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trustee_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $trustee_tb_grid->FormKeyCountName ?>" id="<?php echo $trustee_tb_grid->FormKeyCountName ?>" value="<?php echo $trustee_tb_grid->KeyCount ?>">
<?php echo $trustee_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($trustee_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftrustee_tbgrid">
</div>
<?php

// Close recordset
if ($trustee_tb_grid->Recordset)
	$trustee_tb_grid->Recordset->Close();
?>
<?php if ($trustee_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($trustee_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($trustee_tb->Export == "") { ?>
<script type="text/javascript">
ftrustee_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$trustee_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$trustee_tb_grid->Page_Terminate();
?>
