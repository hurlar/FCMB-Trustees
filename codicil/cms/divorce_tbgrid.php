<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($divorce_tb_grid)) $divorce_tb_grid = new cdivorce_tb_grid();

// Page init
$divorce_tb_grid->Page_Init();

// Page main
$divorce_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$divorce_tb_grid->Page_Render();
?>
<?php if ($divorce_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var divorce_tb_grid = new ew_Page("divorce_tb_grid");
divorce_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = divorce_tb_grid.PageID; // For backward compatibility

// Form object
var fdivorce_tbgrid = new ew_Form("fdivorce_tbgrid");
fdivorce_tbgrid.FormKeyCountName = '<?php echo $divorce_tb_grid->FormKeyCountName ?>';

// Validate form
fdivorce_tbgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_uid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($divorce_tb->uid->FldErrMsg()) ?>");

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
fdivorce_tbgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "uid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "divorce", false)) return false;
	if (ew_ValueChanged(fobj, infix, "divorceyear", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fdivorce_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdivorce_tbgrid.ValidateRequired = true;
<?php } else { ?>
fdivorce_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($divorce_tb->getCurrentMasterTable() == "" && $divorce_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $divorce_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($divorce_tb->CurrentAction == "gridadd") {
	if ($divorce_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$divorce_tb_grid->TotalRecs = $divorce_tb->SelectRecordCount();
			$divorce_tb_grid->Recordset = $divorce_tb_grid->LoadRecordset($divorce_tb_grid->StartRec-1, $divorce_tb_grid->DisplayRecs);
		} else {
			if ($divorce_tb_grid->Recordset = $divorce_tb_grid->LoadRecordset())
				$divorce_tb_grid->TotalRecs = $divorce_tb_grid->Recordset->RecordCount();
		}
		$divorce_tb_grid->StartRec = 1;
		$divorce_tb_grid->DisplayRecs = $divorce_tb_grid->TotalRecs;
	} else {
		$divorce_tb->CurrentFilter = "0=1";
		$divorce_tb_grid->StartRec = 1;
		$divorce_tb_grid->DisplayRecs = $divorce_tb->GridAddRowCount;
	}
	$divorce_tb_grid->TotalRecs = $divorce_tb_grid->DisplayRecs;
	$divorce_tb_grid->StopRec = $divorce_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$divorce_tb_grid->TotalRecs = $divorce_tb->SelectRecordCount();
	} else {
		if ($divorce_tb_grid->Recordset = $divorce_tb_grid->LoadRecordset())
			$divorce_tb_grid->TotalRecs = $divorce_tb_grid->Recordset->RecordCount();
	}
	$divorce_tb_grid->StartRec = 1;
	$divorce_tb_grid->DisplayRecs = $divorce_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$divorce_tb_grid->Recordset = $divorce_tb_grid->LoadRecordset($divorce_tb_grid->StartRec-1, $divorce_tb_grid->DisplayRecs);
}
$divorce_tb_grid->RenderOtherOptions();
?>
<?php $divorce_tb_grid->ShowPageHeader(); ?>
<?php
$divorce_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fdivorce_tbgrid" class="ewForm form-horizontal">
<div id="gmp_divorce_tb" class="ewGridMiddlePanel">
<table id="tbl_divorce_tbgrid" class="ewTable ewTableSeparate">
<?php echo $divorce_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$divorce_tb_grid->RenderListOptions();

// Render list options (header, left)
$divorce_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($divorce_tb->id->Visible) { // id ?>
	<?php if ($divorce_tb->SortUrl($divorce_tb->id) == "") { ?>
		<td><div id="elh_divorce_tb_id" class="divorce_tb_id"><div class="ewTableHeaderCaption"><?php echo $divorce_tb->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_divorce_tb_id" class="divorce_tb_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $divorce_tb->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($divorce_tb->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($divorce_tb->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($divorce_tb->uid->Visible) { // uid ?>
	<?php if ($divorce_tb->SortUrl($divorce_tb->uid) == "") { ?>
		<td><div id="elh_divorce_tb_uid" class="divorce_tb_uid"><div class="ewTableHeaderCaption"><?php echo $divorce_tb->uid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_divorce_tb_uid" class="divorce_tb_uid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $divorce_tb->uid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($divorce_tb->uid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($divorce_tb->uid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($divorce_tb->divorce->Visible) { // divorce ?>
	<?php if ($divorce_tb->SortUrl($divorce_tb->divorce) == "") { ?>
		<td><div id="elh_divorce_tb_divorce" class="divorce_tb_divorce"><div class="ewTableHeaderCaption"><?php echo $divorce_tb->divorce->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_divorce_tb_divorce" class="divorce_tb_divorce">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $divorce_tb->divorce->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($divorce_tb->divorce->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($divorce_tb->divorce->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($divorce_tb->divorceyear->Visible) { // divorceyear ?>
	<?php if ($divorce_tb->SortUrl($divorce_tb->divorceyear) == "") { ?>
		<td><div id="elh_divorce_tb_divorceyear" class="divorce_tb_divorceyear"><div class="ewTableHeaderCaption"><?php echo $divorce_tb->divorceyear->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_divorce_tb_divorceyear" class="divorce_tb_divorceyear">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $divorce_tb->divorceyear->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($divorce_tb->divorceyear->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($divorce_tb->divorceyear->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($divorce_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($divorce_tb->SortUrl($divorce_tb->datecreated) == "") { ?>
		<td><div id="elh_divorce_tb_datecreated" class="divorce_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $divorce_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_divorce_tb_datecreated" class="divorce_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $divorce_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($divorce_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($divorce_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$divorce_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$divorce_tb_grid->StartRec = 1;
$divorce_tb_grid->StopRec = $divorce_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($divorce_tb_grid->FormKeyCountName) && ($divorce_tb->CurrentAction == "gridadd" || $divorce_tb->CurrentAction == "gridedit" || $divorce_tb->CurrentAction == "F")) {
		$divorce_tb_grid->KeyCount = $objForm->GetValue($divorce_tb_grid->FormKeyCountName);
		$divorce_tb_grid->StopRec = $divorce_tb_grid->StartRec + $divorce_tb_grid->KeyCount - 1;
	}
}
$divorce_tb_grid->RecCnt = $divorce_tb_grid->StartRec - 1;
if ($divorce_tb_grid->Recordset && !$divorce_tb_grid->Recordset->EOF) {
	$divorce_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $divorce_tb_grid->StartRec > 1)
		$divorce_tb_grid->Recordset->Move($divorce_tb_grid->StartRec - 1);
} elseif (!$divorce_tb->AllowAddDeleteRow && $divorce_tb_grid->StopRec == 0) {
	$divorce_tb_grid->StopRec = $divorce_tb->GridAddRowCount;
}

// Initialize aggregate
$divorce_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$divorce_tb->ResetAttrs();
$divorce_tb_grid->RenderRow();
if ($divorce_tb->CurrentAction == "gridadd")
	$divorce_tb_grid->RowIndex = 0;
if ($divorce_tb->CurrentAction == "gridedit")
	$divorce_tb_grid->RowIndex = 0;
while ($divorce_tb_grid->RecCnt < $divorce_tb_grid->StopRec) {
	$divorce_tb_grid->RecCnt++;
	if (intval($divorce_tb_grid->RecCnt) >= intval($divorce_tb_grid->StartRec)) {
		$divorce_tb_grid->RowCnt++;
		if ($divorce_tb->CurrentAction == "gridadd" || $divorce_tb->CurrentAction == "gridedit" || $divorce_tb->CurrentAction == "F") {
			$divorce_tb_grid->RowIndex++;
			$objForm->Index = $divorce_tb_grid->RowIndex;
			if ($objForm->HasValue($divorce_tb_grid->FormActionName))
				$divorce_tb_grid->RowAction = strval($objForm->GetValue($divorce_tb_grid->FormActionName));
			elseif ($divorce_tb->CurrentAction == "gridadd")
				$divorce_tb_grid->RowAction = "insert";
			else
				$divorce_tb_grid->RowAction = "";
		}

		// Set up key count
		$divorce_tb_grid->KeyCount = $divorce_tb_grid->RowIndex;

		// Init row class and style
		$divorce_tb->ResetAttrs();
		$divorce_tb->CssClass = "";
		if ($divorce_tb->CurrentAction == "gridadd") {
			if ($divorce_tb->CurrentMode == "copy") {
				$divorce_tb_grid->LoadRowValues($divorce_tb_grid->Recordset); // Load row values
				$divorce_tb_grid->SetRecordKey($divorce_tb_grid->RowOldKey, $divorce_tb_grid->Recordset); // Set old record key
			} else {
				$divorce_tb_grid->LoadDefaultValues(); // Load default values
				$divorce_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$divorce_tb_grid->LoadRowValues($divorce_tb_grid->Recordset); // Load row values
		}
		$divorce_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($divorce_tb->CurrentAction == "gridadd") // Grid add
			$divorce_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($divorce_tb->CurrentAction == "gridadd" && $divorce_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$divorce_tb_grid->RestoreCurrentRowFormValues($divorce_tb_grid->RowIndex); // Restore form values
		if ($divorce_tb->CurrentAction == "gridedit") { // Grid edit
			if ($divorce_tb->EventCancelled) {
				$divorce_tb_grid->RestoreCurrentRowFormValues($divorce_tb_grid->RowIndex); // Restore form values
			}
			if ($divorce_tb_grid->RowAction == "insert")
				$divorce_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$divorce_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($divorce_tb->CurrentAction == "gridedit" && ($divorce_tb->RowType == EW_ROWTYPE_EDIT || $divorce_tb->RowType == EW_ROWTYPE_ADD) && $divorce_tb->EventCancelled) // Update failed
			$divorce_tb_grid->RestoreCurrentRowFormValues($divorce_tb_grid->RowIndex); // Restore form values
		if ($divorce_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$divorce_tb_grid->EditRowCnt++;
		if ($divorce_tb->CurrentAction == "F") // Confirm row
			$divorce_tb_grid->RestoreCurrentRowFormValues($divorce_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$divorce_tb->RowAttrs = array_merge($divorce_tb->RowAttrs, array('data-rowindex'=>$divorce_tb_grid->RowCnt, 'id'=>'r' . $divorce_tb_grid->RowCnt . '_divorce_tb', 'data-rowtype'=>$divorce_tb->RowType));

		// Render row
		$divorce_tb_grid->RenderRow();

		// Render list options
		$divorce_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($divorce_tb_grid->RowAction <> "delete" && $divorce_tb_grid->RowAction <> "insertdelete" && !($divorce_tb_grid->RowAction == "insert" && $divorce_tb->CurrentAction == "F" && $divorce_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $divorce_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$divorce_tb_grid->ListOptions->Render("body", "left", $divorce_tb_grid->RowCnt);
?>
	<?php if ($divorce_tb->id->Visible) { // id ?>
		<td<?php echo $divorce_tb->id->CellAttributes() ?>>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $divorce_tb_grid->RowIndex ?>_id" id="o<?php echo $divorce_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($divorce_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_id" class="control-group divorce_tb_id">
<span<?php echo $divorce_tb->id->ViewAttributes() ?>>
<?php echo $divorce_tb->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $divorce_tb_grid->RowIndex ?>_id" id="x<?php echo $divorce_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($divorce_tb->id->CurrentValue) ?>">
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $divorce_tb->id->ViewAttributes() ?>>
<?php echo $divorce_tb->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $divorce_tb_grid->RowIndex ?>_id" id="x<?php echo $divorce_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($divorce_tb->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $divorce_tb_grid->RowIndex ?>_id" id="o<?php echo $divorce_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($divorce_tb->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $divorce_tb_grid->PageObjName . "_row_" . $divorce_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($divorce_tb->uid->Visible) { // uid ?>
		<td<?php echo $divorce_tb->uid->CellAttributes() ?>>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($divorce_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $divorce_tb->uid->ViewAttributes() ?>>
<?php echo $divorce_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $divorce_tb->uid->PlaceHolder ?>" value="<?php echo $divorce_tb->uid->EditValue ?>"<?php echo $divorce_tb->uid->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_uid" name="o<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="o<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->OldValue) ?>">
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($divorce_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $divorce_tb->uid->ViewAttributes() ?>>
<?php echo $divorce_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $divorce_tb->uid->PlaceHolder ?>" value="<?php echo $divorce_tb->uid->EditValue ?>"<?php echo $divorce_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $divorce_tb->uid->ViewAttributes() ?>>
<?php echo $divorce_tb->uid->ListViewValue() ?></span>
<input type="hidden" data-field="x_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->FormValue) ?>">
<input type="hidden" data-field="x_uid" name="o<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="o<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $divorce_tb_grid->PageObjName . "_row_" . $divorce_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($divorce_tb->divorce->Visible) { // divorce ?>
		<td<?php echo $divorce_tb->divorce->CellAttributes() ?>>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_divorce" class="control-group divorce_tb_divorce">
<input type="text" data-field="x_divorce" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" size="30" maxlength="10" placeholder="<?php echo $divorce_tb->divorce->PlaceHolder ?>" value="<?php echo $divorce_tb->divorce->EditValue ?>"<?php echo $divorce_tb->divorce->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_divorce" name="o<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="o<?php echo $divorce_tb_grid->RowIndex ?>_divorce" value="<?php echo ew_HtmlEncode($divorce_tb->divorce->OldValue) ?>">
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_divorce" class="control-group divorce_tb_divorce">
<input type="text" data-field="x_divorce" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" size="30" maxlength="10" placeholder="<?php echo $divorce_tb->divorce->PlaceHolder ?>" value="<?php echo $divorce_tb->divorce->EditValue ?>"<?php echo $divorce_tb->divorce->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $divorce_tb->divorce->ViewAttributes() ?>>
<?php echo $divorce_tb->divorce->ListViewValue() ?></span>
<input type="hidden" data-field="x_divorce" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" value="<?php echo ew_HtmlEncode($divorce_tb->divorce->FormValue) ?>">
<input type="hidden" data-field="x_divorce" name="o<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="o<?php echo $divorce_tb_grid->RowIndex ?>_divorce" value="<?php echo ew_HtmlEncode($divorce_tb->divorce->OldValue) ?>">
<?php } ?>
<a id="<?php echo $divorce_tb_grid->PageObjName . "_row_" . $divorce_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($divorce_tb->divorceyear->Visible) { // divorceyear ?>
		<td<?php echo $divorce_tb->divorceyear->CellAttributes() ?>>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_divorceyear" class="control-group divorce_tb_divorceyear">
<input type="text" data-field="x_divorceyear" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" size="30" maxlength="10" placeholder="<?php echo $divorce_tb->divorceyear->PlaceHolder ?>" value="<?php echo $divorce_tb->divorceyear->EditValue ?>"<?php echo $divorce_tb->divorceyear->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_divorceyear" name="o<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="o<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" value="<?php echo ew_HtmlEncode($divorce_tb->divorceyear->OldValue) ?>">
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_divorceyear" class="control-group divorce_tb_divorceyear">
<input type="text" data-field="x_divorceyear" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" size="30" maxlength="10" placeholder="<?php echo $divorce_tb->divorceyear->PlaceHolder ?>" value="<?php echo $divorce_tb->divorceyear->EditValue ?>"<?php echo $divorce_tb->divorceyear->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $divorce_tb->divorceyear->ViewAttributes() ?>>
<?php echo $divorce_tb->divorceyear->ListViewValue() ?></span>
<input type="hidden" data-field="x_divorceyear" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" value="<?php echo ew_HtmlEncode($divorce_tb->divorceyear->FormValue) ?>">
<input type="hidden" data-field="x_divorceyear" name="o<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="o<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" value="<?php echo ew_HtmlEncode($divorce_tb->divorceyear->OldValue) ?>">
<?php } ?>
<a id="<?php echo $divorce_tb_grid->PageObjName . "_row_" . $divorce_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($divorce_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $divorce_tb->datecreated->CellAttributes() ?>>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_datecreated" class="control-group divorce_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $divorce_tb->datecreated->PlaceHolder ?>" value="<?php echo $divorce_tb->datecreated->EditValue ?>"<?php echo $divorce_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($divorce_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $divorce_tb_grid->RowCnt ?>_divorce_tb_datecreated" class="control-group divorce_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $divorce_tb->datecreated->PlaceHolder ?>" value="<?php echo $divorce_tb->datecreated->EditValue ?>"<?php echo $divorce_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $divorce_tb->datecreated->ViewAttributes() ?>>
<?php echo $divorce_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($divorce_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($divorce_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $divorce_tb_grid->PageObjName . "_row_" . $divorce_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$divorce_tb_grid->ListOptions->Render("body", "right", $divorce_tb_grid->RowCnt);
?>
	</tr>
<?php if ($divorce_tb->RowType == EW_ROWTYPE_ADD || $divorce_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdivorce_tbgrid.UpdateOpts(<?php echo $divorce_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($divorce_tb->CurrentAction <> "gridadd" || $divorce_tb->CurrentMode == "copy")
		if (!$divorce_tb_grid->Recordset->EOF) $divorce_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($divorce_tb->CurrentMode == "add" || $divorce_tb->CurrentMode == "copy" || $divorce_tb->CurrentMode == "edit") {
		$divorce_tb_grid->RowIndex = '$rowindex$';
		$divorce_tb_grid->LoadDefaultValues();

		// Set row properties
		$divorce_tb->ResetAttrs();
		$divorce_tb->RowAttrs = array_merge($divorce_tb->RowAttrs, array('data-rowindex'=>$divorce_tb_grid->RowIndex, 'id'=>'r0_divorce_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($divorce_tb->RowAttrs["class"], "ewTemplate");
		$divorce_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$divorce_tb_grid->RenderRow();

		// Render list options
		$divorce_tb_grid->RenderListOptions();
		$divorce_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $divorce_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$divorce_tb_grid->ListOptions->Render("body", "left", $divorce_tb_grid->RowIndex);
?>
	<?php if ($divorce_tb->id->Visible) { // id ?>
		<td>
<?php if ($divorce_tb->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_divorce_tb_id" class="control-group divorce_tb_id">
<span<?php echo $divorce_tb->id->ViewAttributes() ?>>
<?php echo $divorce_tb->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $divorce_tb_grid->RowIndex ?>_id" id="x<?php echo $divorce_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($divorce_tb->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $divorce_tb_grid->RowIndex ?>_id" id="o<?php echo $divorce_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($divorce_tb->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($divorce_tb->uid->Visible) { // uid ?>
		<td>
<?php if ($divorce_tb->CurrentAction <> "F") { ?>
<?php if ($divorce_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $divorce_tb->uid->ViewAttributes() ?>>
<?php echo $divorce_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $divorce_tb->uid->PlaceHolder ?>" value="<?php echo $divorce_tb->uid->EditValue ?>"<?php echo $divorce_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $divorce_tb->uid->ViewAttributes() ?>>
<?php echo $divorce_tb->uid->ViewValue ?></span>
<input type="hidden" data-field="x_uid" name="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="x<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_uid" name="o<?php echo $divorce_tb_grid->RowIndex ?>_uid" id="o<?php echo $divorce_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($divorce_tb->uid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($divorce_tb->divorce->Visible) { // divorce ?>
		<td>
<?php if ($divorce_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_divorce_tb_divorce" class="control-group divorce_tb_divorce">
<input type="text" data-field="x_divorce" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" size="30" maxlength="10" placeholder="<?php echo $divorce_tb->divorce->PlaceHolder ?>" value="<?php echo $divorce_tb->divorce->EditValue ?>"<?php echo $divorce_tb->divorce->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_divorce_tb_divorce" class="control-group divorce_tb_divorce">
<span<?php echo $divorce_tb->divorce->ViewAttributes() ?>>
<?php echo $divorce_tb->divorce->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_divorce" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorce" value="<?php echo ew_HtmlEncode($divorce_tb->divorce->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_divorce" name="o<?php echo $divorce_tb_grid->RowIndex ?>_divorce" id="o<?php echo $divorce_tb_grid->RowIndex ?>_divorce" value="<?php echo ew_HtmlEncode($divorce_tb->divorce->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($divorce_tb->divorceyear->Visible) { // divorceyear ?>
		<td>
<?php if ($divorce_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_divorce_tb_divorceyear" class="control-group divorce_tb_divorceyear">
<input type="text" data-field="x_divorceyear" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" size="30" maxlength="10" placeholder="<?php echo $divorce_tb->divorceyear->PlaceHolder ?>" value="<?php echo $divorce_tb->divorceyear->EditValue ?>"<?php echo $divorce_tb->divorceyear->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_divorce_tb_divorceyear" class="control-group divorce_tb_divorceyear">
<span<?php echo $divorce_tb->divorceyear->ViewAttributes() ?>>
<?php echo $divorce_tb->divorceyear->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_divorceyear" name="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="x<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" value="<?php echo ew_HtmlEncode($divorce_tb->divorceyear->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_divorceyear" name="o<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" id="o<?php echo $divorce_tb_grid->RowIndex ?>_divorceyear" value="<?php echo ew_HtmlEncode($divorce_tb->divorceyear->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($divorce_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($divorce_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_divorce_tb_datecreated" class="control-group divorce_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $divorce_tb->datecreated->PlaceHolder ?>" value="<?php echo $divorce_tb->datecreated->EditValue ?>"<?php echo $divorce_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_divorce_tb_datecreated" class="control-group divorce_tb_datecreated">
<span<?php echo $divorce_tb->datecreated->ViewAttributes() ?>>
<?php echo $divorce_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($divorce_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $divorce_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($divorce_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$divorce_tb_grid->ListOptions->Render("body", "right", $divorce_tb_grid->RowCnt);
?>
<script type="text/javascript">
fdivorce_tbgrid.UpdateOpts(<?php echo $divorce_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($divorce_tb->CurrentMode == "add" || $divorce_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $divorce_tb_grid->FormKeyCountName ?>" id="<?php echo $divorce_tb_grid->FormKeyCountName ?>" value="<?php echo $divorce_tb_grid->KeyCount ?>">
<?php echo $divorce_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($divorce_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $divorce_tb_grid->FormKeyCountName ?>" id="<?php echo $divorce_tb_grid->FormKeyCountName ?>" value="<?php echo $divorce_tb_grid->KeyCount ?>">
<?php echo $divorce_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($divorce_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdivorce_tbgrid">
</div>
<?php

// Close recordset
if ($divorce_tb_grid->Recordset)
	$divorce_tb_grid->Recordset->Close();
?>
<?php if ($divorce_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($divorce_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($divorce_tb->Export == "") { ?>
<script type="text/javascript">
fdivorce_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$divorce_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$divorce_tb_grid->Page_Terminate();
?>
