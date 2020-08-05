<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($addinfo_tb_grid)) $addinfo_tb_grid = new caddinfo_tb_grid();

// Page init
$addinfo_tb_grid->Page_Init();

// Page main
$addinfo_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$addinfo_tb_grid->Page_Render();
?>
<?php if ($addinfo_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var addinfo_tb_grid = new ew_Page("addinfo_tb_grid");
addinfo_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = addinfo_tb_grid.PageID; // For backward compatibility

// Form object
var faddinfo_tbgrid = new ew_Form("faddinfo_tbgrid");
faddinfo_tbgrid.FormKeyCountName = '<?php echo $addinfo_tb_grid->FormKeyCountName ?>';

// Validate form
faddinfo_tbgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($addinfo_tb->uid->FldErrMsg()) ?>");

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
faddinfo_tbgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "uid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "addinfo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
faddinfo_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faddinfo_tbgrid.ValidateRequired = true;
<?php } else { ?>
faddinfo_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($addinfo_tb->getCurrentMasterTable() == "" && $addinfo_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $addinfo_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($addinfo_tb->CurrentAction == "gridadd") {
	if ($addinfo_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$addinfo_tb_grid->TotalRecs = $addinfo_tb->SelectRecordCount();
			$addinfo_tb_grid->Recordset = $addinfo_tb_grid->LoadRecordset($addinfo_tb_grid->StartRec-1, $addinfo_tb_grid->DisplayRecs);
		} else {
			if ($addinfo_tb_grid->Recordset = $addinfo_tb_grid->LoadRecordset())
				$addinfo_tb_grid->TotalRecs = $addinfo_tb_grid->Recordset->RecordCount();
		}
		$addinfo_tb_grid->StartRec = 1;
		$addinfo_tb_grid->DisplayRecs = $addinfo_tb_grid->TotalRecs;
	} else {
		$addinfo_tb->CurrentFilter = "0=1";
		$addinfo_tb_grid->StartRec = 1;
		$addinfo_tb_grid->DisplayRecs = $addinfo_tb->GridAddRowCount;
	}
	$addinfo_tb_grid->TotalRecs = $addinfo_tb_grid->DisplayRecs;
	$addinfo_tb_grid->StopRec = $addinfo_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$addinfo_tb_grid->TotalRecs = $addinfo_tb->SelectRecordCount();
	} else {
		if ($addinfo_tb_grid->Recordset = $addinfo_tb_grid->LoadRecordset())
			$addinfo_tb_grid->TotalRecs = $addinfo_tb_grid->Recordset->RecordCount();
	}
	$addinfo_tb_grid->StartRec = 1;
	$addinfo_tb_grid->DisplayRecs = $addinfo_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$addinfo_tb_grid->Recordset = $addinfo_tb_grid->LoadRecordset($addinfo_tb_grid->StartRec-1, $addinfo_tb_grid->DisplayRecs);
}
$addinfo_tb_grid->RenderOtherOptions();
?>
<?php $addinfo_tb_grid->ShowPageHeader(); ?>
<?php
$addinfo_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="faddinfo_tbgrid" class="ewForm form-horizontal">
<div id="gmp_addinfo_tb" class="ewGridMiddlePanel">
<table id="tbl_addinfo_tbgrid" class="ewTable ewTableSeparate">
<?php echo $addinfo_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$addinfo_tb_grid->RenderListOptions();

// Render list options (header, left)
$addinfo_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($addinfo_tb->id->Visible) { // id ?>
	<?php if ($addinfo_tb->SortUrl($addinfo_tb->id) == "") { ?>
		<td><div id="elh_addinfo_tb_id" class="addinfo_tb_id"><div class="ewTableHeaderCaption"><?php echo $addinfo_tb->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_addinfo_tb_id" class="addinfo_tb_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addinfo_tb->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addinfo_tb->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addinfo_tb->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($addinfo_tb->uid->Visible) { // uid ?>
	<?php if ($addinfo_tb->SortUrl($addinfo_tb->uid) == "") { ?>
		<td><div id="elh_addinfo_tb_uid" class="addinfo_tb_uid"><div class="ewTableHeaderCaption"><?php echo $addinfo_tb->uid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_addinfo_tb_uid" class="addinfo_tb_uid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addinfo_tb->uid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addinfo_tb->uid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addinfo_tb->uid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($addinfo_tb->addinfo->Visible) { // addinfo ?>
	<?php if ($addinfo_tb->SortUrl($addinfo_tb->addinfo) == "") { ?>
		<td><div id="elh_addinfo_tb_addinfo" class="addinfo_tb_addinfo"><div class="ewTableHeaderCaption"><?php echo $addinfo_tb->addinfo->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_addinfo_tb_addinfo" class="addinfo_tb_addinfo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addinfo_tb->addinfo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addinfo_tb->addinfo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addinfo_tb->addinfo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($addinfo_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($addinfo_tb->SortUrl($addinfo_tb->datecreated) == "") { ?>
		<td><div id="elh_addinfo_tb_datecreated" class="addinfo_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $addinfo_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_addinfo_tb_datecreated" class="addinfo_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addinfo_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addinfo_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addinfo_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$addinfo_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$addinfo_tb_grid->StartRec = 1;
$addinfo_tb_grid->StopRec = $addinfo_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($addinfo_tb_grid->FormKeyCountName) && ($addinfo_tb->CurrentAction == "gridadd" || $addinfo_tb->CurrentAction == "gridedit" || $addinfo_tb->CurrentAction == "F")) {
		$addinfo_tb_grid->KeyCount = $objForm->GetValue($addinfo_tb_grid->FormKeyCountName);
		$addinfo_tb_grid->StopRec = $addinfo_tb_grid->StartRec + $addinfo_tb_grid->KeyCount - 1;
	}
}
$addinfo_tb_grid->RecCnt = $addinfo_tb_grid->StartRec - 1;
if ($addinfo_tb_grid->Recordset && !$addinfo_tb_grid->Recordset->EOF) {
	$addinfo_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $addinfo_tb_grid->StartRec > 1)
		$addinfo_tb_grid->Recordset->Move($addinfo_tb_grid->StartRec - 1);
} elseif (!$addinfo_tb->AllowAddDeleteRow && $addinfo_tb_grid->StopRec == 0) {
	$addinfo_tb_grid->StopRec = $addinfo_tb->GridAddRowCount;
}

// Initialize aggregate
$addinfo_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$addinfo_tb->ResetAttrs();
$addinfo_tb_grid->RenderRow();
if ($addinfo_tb->CurrentAction == "gridadd")
	$addinfo_tb_grid->RowIndex = 0;
if ($addinfo_tb->CurrentAction == "gridedit")
	$addinfo_tb_grid->RowIndex = 0;
while ($addinfo_tb_grid->RecCnt < $addinfo_tb_grid->StopRec) {
	$addinfo_tb_grid->RecCnt++;
	if (intval($addinfo_tb_grid->RecCnt) >= intval($addinfo_tb_grid->StartRec)) {
		$addinfo_tb_grid->RowCnt++;
		if ($addinfo_tb->CurrentAction == "gridadd" || $addinfo_tb->CurrentAction == "gridedit" || $addinfo_tb->CurrentAction == "F") {
			$addinfo_tb_grid->RowIndex++;
			$objForm->Index = $addinfo_tb_grid->RowIndex;
			if ($objForm->HasValue($addinfo_tb_grid->FormActionName))
				$addinfo_tb_grid->RowAction = strval($objForm->GetValue($addinfo_tb_grid->FormActionName));
			elseif ($addinfo_tb->CurrentAction == "gridadd")
				$addinfo_tb_grid->RowAction = "insert";
			else
				$addinfo_tb_grid->RowAction = "";
		}

		// Set up key count
		$addinfo_tb_grid->KeyCount = $addinfo_tb_grid->RowIndex;

		// Init row class and style
		$addinfo_tb->ResetAttrs();
		$addinfo_tb->CssClass = "";
		if ($addinfo_tb->CurrentAction == "gridadd") {
			if ($addinfo_tb->CurrentMode == "copy") {
				$addinfo_tb_grid->LoadRowValues($addinfo_tb_grid->Recordset); // Load row values
				$addinfo_tb_grid->SetRecordKey($addinfo_tb_grid->RowOldKey, $addinfo_tb_grid->Recordset); // Set old record key
			} else {
				$addinfo_tb_grid->LoadDefaultValues(); // Load default values
				$addinfo_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$addinfo_tb_grid->LoadRowValues($addinfo_tb_grid->Recordset); // Load row values
		}
		$addinfo_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($addinfo_tb->CurrentAction == "gridadd") // Grid add
			$addinfo_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($addinfo_tb->CurrentAction == "gridadd" && $addinfo_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$addinfo_tb_grid->RestoreCurrentRowFormValues($addinfo_tb_grid->RowIndex); // Restore form values
		if ($addinfo_tb->CurrentAction == "gridedit") { // Grid edit
			if ($addinfo_tb->EventCancelled) {
				$addinfo_tb_grid->RestoreCurrentRowFormValues($addinfo_tb_grid->RowIndex); // Restore form values
			}
			if ($addinfo_tb_grid->RowAction == "insert")
				$addinfo_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$addinfo_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($addinfo_tb->CurrentAction == "gridedit" && ($addinfo_tb->RowType == EW_ROWTYPE_EDIT || $addinfo_tb->RowType == EW_ROWTYPE_ADD) && $addinfo_tb->EventCancelled) // Update failed
			$addinfo_tb_grid->RestoreCurrentRowFormValues($addinfo_tb_grid->RowIndex); // Restore form values
		if ($addinfo_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$addinfo_tb_grid->EditRowCnt++;
		if ($addinfo_tb->CurrentAction == "F") // Confirm row
			$addinfo_tb_grid->RestoreCurrentRowFormValues($addinfo_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$addinfo_tb->RowAttrs = array_merge($addinfo_tb->RowAttrs, array('data-rowindex'=>$addinfo_tb_grid->RowCnt, 'id'=>'r' . $addinfo_tb_grid->RowCnt . '_addinfo_tb', 'data-rowtype'=>$addinfo_tb->RowType));

		// Render row
		$addinfo_tb_grid->RenderRow();

		// Render list options
		$addinfo_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($addinfo_tb_grid->RowAction <> "delete" && $addinfo_tb_grid->RowAction <> "insertdelete" && !($addinfo_tb_grid->RowAction == "insert" && $addinfo_tb->CurrentAction == "F" && $addinfo_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $addinfo_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$addinfo_tb_grid->ListOptions->Render("body", "left", $addinfo_tb_grid->RowCnt);
?>
	<?php if ($addinfo_tb->id->Visible) { // id ?>
		<td<?php echo $addinfo_tb->id->CellAttributes() ?>>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_id" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($addinfo_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $addinfo_tb_grid->RowCnt ?>_addinfo_tb_id" class="control-group addinfo_tb_id">
<span<?php echo $addinfo_tb->id->ViewAttributes() ?>>
<?php echo $addinfo_tb->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_id" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($addinfo_tb->id->CurrentValue) ?>">
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $addinfo_tb->id->ViewAttributes() ?>>
<?php echo $addinfo_tb->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_id" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($addinfo_tb->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_id" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($addinfo_tb->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $addinfo_tb_grid->PageObjName . "_row_" . $addinfo_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($addinfo_tb->uid->Visible) { // uid ?>
		<td<?php echo $addinfo_tb->uid->CellAttributes() ?>>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($addinfo_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $addinfo_tb->uid->ViewAttributes() ?>>
<?php echo $addinfo_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $addinfo_tb->uid->PlaceHolder ?>" value="<?php echo $addinfo_tb->uid->EditValue ?>"<?php echo $addinfo_tb->uid->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_uid" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->OldValue) ?>">
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($addinfo_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $addinfo_tb->uid->ViewAttributes() ?>>
<?php echo $addinfo_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $addinfo_tb->uid->PlaceHolder ?>" value="<?php echo $addinfo_tb->uid->EditValue ?>"<?php echo $addinfo_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $addinfo_tb->uid->ViewAttributes() ?>>
<?php echo $addinfo_tb->uid->ListViewValue() ?></span>
<input type="hidden" data-field="x_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->FormValue) ?>">
<input type="hidden" data-field="x_uid" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $addinfo_tb_grid->PageObjName . "_row_" . $addinfo_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($addinfo_tb->addinfo->Visible) { // addinfo ?>
		<td<?php echo $addinfo_tb->addinfo->CellAttributes() ?>>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $addinfo_tb_grid->RowCnt ?>_addinfo_tb_addinfo" class="control-group addinfo_tb_addinfo">
<textarea data-field="x_addinfo" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" cols="35" rows="4" placeholder="<?php echo $addinfo_tb->addinfo->PlaceHolder ?>"<?php echo $addinfo_tb->addinfo->EditAttributes() ?>><?php echo $addinfo_tb->addinfo->EditValue ?></textarea>
</span>
<input type="hidden" data-field="x_addinfo" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" value="<?php echo ew_HtmlEncode($addinfo_tb->addinfo->OldValue) ?>">
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $addinfo_tb_grid->RowCnt ?>_addinfo_tb_addinfo" class="control-group addinfo_tb_addinfo">
<textarea data-field="x_addinfo" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" cols="35" rows="4" placeholder="<?php echo $addinfo_tb->addinfo->PlaceHolder ?>"<?php echo $addinfo_tb->addinfo->EditAttributes() ?>><?php echo $addinfo_tb->addinfo->EditValue ?></textarea>
</span>
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $addinfo_tb->addinfo->ViewAttributes() ?>>
<?php echo $addinfo_tb->addinfo->ListViewValue() ?></span>
<input type="hidden" data-field="x_addinfo" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" value="<?php echo ew_HtmlEncode($addinfo_tb->addinfo->FormValue) ?>">
<input type="hidden" data-field="x_addinfo" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" value="<?php echo ew_HtmlEncode($addinfo_tb->addinfo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $addinfo_tb_grid->PageObjName . "_row_" . $addinfo_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($addinfo_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $addinfo_tb->datecreated->CellAttributes() ?>>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $addinfo_tb_grid->RowCnt ?>_addinfo_tb_datecreated" class="control-group addinfo_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $addinfo_tb->datecreated->PlaceHolder ?>" value="<?php echo $addinfo_tb->datecreated->EditValue ?>"<?php echo $addinfo_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($addinfo_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $addinfo_tb_grid->RowCnt ?>_addinfo_tb_datecreated" class="control-group addinfo_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $addinfo_tb->datecreated->PlaceHolder ?>" value="<?php echo $addinfo_tb->datecreated->EditValue ?>"<?php echo $addinfo_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $addinfo_tb->datecreated->ViewAttributes() ?>>
<?php echo $addinfo_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($addinfo_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($addinfo_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $addinfo_tb_grid->PageObjName . "_row_" . $addinfo_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$addinfo_tb_grid->ListOptions->Render("body", "right", $addinfo_tb_grid->RowCnt);
?>
	</tr>
<?php if ($addinfo_tb->RowType == EW_ROWTYPE_ADD || $addinfo_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
faddinfo_tbgrid.UpdateOpts(<?php echo $addinfo_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($addinfo_tb->CurrentAction <> "gridadd" || $addinfo_tb->CurrentMode == "copy")
		if (!$addinfo_tb_grid->Recordset->EOF) $addinfo_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($addinfo_tb->CurrentMode == "add" || $addinfo_tb->CurrentMode == "copy" || $addinfo_tb->CurrentMode == "edit") {
		$addinfo_tb_grid->RowIndex = '$rowindex$';
		$addinfo_tb_grid->LoadDefaultValues();

		// Set row properties
		$addinfo_tb->ResetAttrs();
		$addinfo_tb->RowAttrs = array_merge($addinfo_tb->RowAttrs, array('data-rowindex'=>$addinfo_tb_grid->RowIndex, 'id'=>'r0_addinfo_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($addinfo_tb->RowAttrs["class"], "ewTemplate");
		$addinfo_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$addinfo_tb_grid->RenderRow();

		// Render list options
		$addinfo_tb_grid->RenderListOptions();
		$addinfo_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $addinfo_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$addinfo_tb_grid->ListOptions->Render("body", "left", $addinfo_tb_grid->RowIndex);
?>
	<?php if ($addinfo_tb->id->Visible) { // id ?>
		<td>
<?php if ($addinfo_tb->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_addinfo_tb_id" class="control-group addinfo_tb_id">
<span<?php echo $addinfo_tb->id->ViewAttributes() ?>>
<?php echo $addinfo_tb->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_id" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($addinfo_tb->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_id" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($addinfo_tb->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($addinfo_tb->uid->Visible) { // uid ?>
		<td>
<?php if ($addinfo_tb->CurrentAction <> "F") { ?>
<?php if ($addinfo_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $addinfo_tb->uid->ViewAttributes() ?>>
<?php echo $addinfo_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $addinfo_tb->uid->PlaceHolder ?>" value="<?php echo $addinfo_tb->uid->EditValue ?>"<?php echo $addinfo_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $addinfo_tb->uid->ViewAttributes() ?>>
<?php echo $addinfo_tb->uid->ViewValue ?></span>
<input type="hidden" data-field="x_uid" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_uid" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_uid" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($addinfo_tb->uid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($addinfo_tb->addinfo->Visible) { // addinfo ?>
		<td>
<?php if ($addinfo_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_addinfo_tb_addinfo" class="control-group addinfo_tb_addinfo">
<textarea data-field="x_addinfo" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" cols="35" rows="4" placeholder="<?php echo $addinfo_tb->addinfo->PlaceHolder ?>"<?php echo $addinfo_tb->addinfo->EditAttributes() ?>><?php echo $addinfo_tb->addinfo->EditValue ?></textarea>
</span>
<?php } else { ?>
<span id="el$rowindex$_addinfo_tb_addinfo" class="control-group addinfo_tb_addinfo">
<span<?php echo $addinfo_tb->addinfo->ViewAttributes() ?>>
<?php echo $addinfo_tb->addinfo->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_addinfo" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" value="<?php echo ew_HtmlEncode($addinfo_tb->addinfo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_addinfo" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_addinfo" value="<?php echo ew_HtmlEncode($addinfo_tb->addinfo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($addinfo_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($addinfo_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_addinfo_tb_datecreated" class="control-group addinfo_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $addinfo_tb->datecreated->PlaceHolder ?>" value="<?php echo $addinfo_tb->datecreated->EditValue ?>"<?php echo $addinfo_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_addinfo_tb_datecreated" class="control-group addinfo_tb_datecreated">
<span<?php echo $addinfo_tb->datecreated->ViewAttributes() ?>>
<?php echo $addinfo_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($addinfo_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $addinfo_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($addinfo_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$addinfo_tb_grid->ListOptions->Render("body", "right", $addinfo_tb_grid->RowCnt);
?>
<script type="text/javascript">
faddinfo_tbgrid.UpdateOpts(<?php echo $addinfo_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($addinfo_tb->CurrentMode == "add" || $addinfo_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $addinfo_tb_grid->FormKeyCountName ?>" id="<?php echo $addinfo_tb_grid->FormKeyCountName ?>" value="<?php echo $addinfo_tb_grid->KeyCount ?>">
<?php echo $addinfo_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($addinfo_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $addinfo_tb_grid->FormKeyCountName ?>" id="<?php echo $addinfo_tb_grid->FormKeyCountName ?>" value="<?php echo $addinfo_tb_grid->KeyCount ?>">
<?php echo $addinfo_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($addinfo_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="faddinfo_tbgrid">
</div>
<?php

// Close recordset
if ($addinfo_tb_grid->Recordset)
	$addinfo_tb_grid->Recordset->Close();
?>
<?php if ($addinfo_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($addinfo_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($addinfo_tb->Export == "") { ?>
<script type="text/javascript">
faddinfo_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$addinfo_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$addinfo_tb_grid->Page_Terminate();
?>
