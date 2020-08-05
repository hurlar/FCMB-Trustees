<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($children_details_grid)) $children_details_grid = new cchildren_details_grid();

// Page init
$children_details_grid->Page_Init();

// Page main
$children_details_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$children_details_grid->Page_Render();
?>
<?php if ($children_details->Export == "") { ?>
<script type="text/javascript">

// Page object
var children_details_grid = new ew_Page("children_details_grid");
children_details_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = children_details_grid.PageID; // For backward compatibility

// Form object
var fchildren_detailsgrid = new ew_Form("fchildren_detailsgrid");
fchildren_detailsgrid.FormKeyCountName = '<?php echo $children_details_grid->FormKeyCountName ?>';

// Validate form
fchildren_detailsgrid.Validate = function() {
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
fchildren_detailsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gender", false)) return false;
	if (ew_ValueChanged(fobj, infix, "dob", false)) return false;
	if (ew_ValueChanged(fobj, infix, "age", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "guardianname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rtionship", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_email", false)) return false;
	if (ew_ValueChanged(fobj, infix, "phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fchildren_detailsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fchildren_detailsgrid.ValidateRequired = true;
<?php } else { ?>
fchildren_detailsgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($children_details->getCurrentMasterTable() == "" && $children_details_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $children_details_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($children_details->CurrentAction == "gridadd") {
	if ($children_details->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$children_details_grid->TotalRecs = $children_details->SelectRecordCount();
			$children_details_grid->Recordset = $children_details_grid->LoadRecordset($children_details_grid->StartRec-1, $children_details_grid->DisplayRecs);
		} else {
			if ($children_details_grid->Recordset = $children_details_grid->LoadRecordset())
				$children_details_grid->TotalRecs = $children_details_grid->Recordset->RecordCount();
		}
		$children_details_grid->StartRec = 1;
		$children_details_grid->DisplayRecs = $children_details_grid->TotalRecs;
	} else {
		$children_details->CurrentFilter = "0=1";
		$children_details_grid->StartRec = 1;
		$children_details_grid->DisplayRecs = $children_details->GridAddRowCount;
	}
	$children_details_grid->TotalRecs = $children_details_grid->DisplayRecs;
	$children_details_grid->StopRec = $children_details_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$children_details_grid->TotalRecs = $children_details->SelectRecordCount();
	} else {
		if ($children_details_grid->Recordset = $children_details_grid->LoadRecordset())
			$children_details_grid->TotalRecs = $children_details_grid->Recordset->RecordCount();
	}
	$children_details_grid->StartRec = 1;
	$children_details_grid->DisplayRecs = $children_details_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$children_details_grid->Recordset = $children_details_grid->LoadRecordset($children_details_grid->StartRec-1, $children_details_grid->DisplayRecs);
}
$children_details_grid->RenderOtherOptions();
?>
<?php $children_details_grid->ShowPageHeader(); ?>
<?php
$children_details_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fchildren_detailsgrid" class="ewForm form-horizontal">
<div id="gmp_children_details" class="ewGridMiddlePanel">
<table id="tbl_children_detailsgrid" class="ewTable ewTableSeparate">
<?php echo $children_details->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$children_details_grid->RenderListOptions();

// Render list options (header, left)
$children_details_grid->ListOptions->Render("header", "left");
?>
<?php if ($children_details->id->Visible) { // id ?>
	<?php if ($children_details->SortUrl($children_details->id) == "") { ?>
		<td><div id="elh_children_details_id" class="children_details_id"><div class="ewTableHeaderCaption"><?php echo $children_details->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_id" class="children_details_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->name->Visible) { // name ?>
	<?php if ($children_details->SortUrl($children_details->name) == "") { ?>
		<td><div id="elh_children_details_name" class="children_details_name"><div class="ewTableHeaderCaption"><?php echo $children_details->name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_name" class="children_details_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->gender->Visible) { // gender ?>
	<?php if ($children_details->SortUrl($children_details->gender) == "") { ?>
		<td><div id="elh_children_details_gender" class="children_details_gender"><div class="ewTableHeaderCaption"><?php echo $children_details->gender->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_gender" class="children_details_gender">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->gender->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->dob->Visible) { // dob ?>
	<?php if ($children_details->SortUrl($children_details->dob) == "") { ?>
		<td><div id="elh_children_details_dob" class="children_details_dob"><div class="ewTableHeaderCaption"><?php echo $children_details->dob->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_dob" class="children_details_dob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->dob->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->dob->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->dob->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->age->Visible) { // age ?>
	<?php if ($children_details->SortUrl($children_details->age) == "") { ?>
		<td><div id="elh_children_details_age" class="children_details_age"><div class="ewTableHeaderCaption"><?php echo $children_details->age->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_age" class="children_details_age">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->age->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->age->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->age->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->title->Visible) { // title ?>
	<?php if ($children_details->SortUrl($children_details->title) == "") { ?>
		<td><div id="elh_children_details_title" class="children_details_title"><div class="ewTableHeaderCaption"><?php echo $children_details->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_title" class="children_details_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->guardianname->Visible) { // guardianname ?>
	<?php if ($children_details->SortUrl($children_details->guardianname) == "") { ?>
		<td><div id="elh_children_details_guardianname" class="children_details_guardianname"><div class="ewTableHeaderCaption"><?php echo $children_details->guardianname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_guardianname" class="children_details_guardianname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->guardianname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->guardianname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->guardianname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->rtionship->Visible) { // rtionship ?>
	<?php if ($children_details->SortUrl($children_details->rtionship) == "") { ?>
		<td><div id="elh_children_details_rtionship" class="children_details_rtionship"><div class="ewTableHeaderCaption"><?php echo $children_details->rtionship->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_rtionship" class="children_details_rtionship">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->rtionship->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->rtionship->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->rtionship->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->_email->Visible) { // email ?>
	<?php if ($children_details->SortUrl($children_details->_email) == "") { ?>
		<td><div id="elh_children_details__email" class="children_details__email"><div class="ewTableHeaderCaption"><?php echo $children_details->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details__email" class="children_details__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->phone->Visible) { // phone ?>
	<?php if ($children_details->SortUrl($children_details->phone) == "") { ?>
		<td><div id="elh_children_details_phone" class="children_details_phone"><div class="ewTableHeaderCaption"><?php echo $children_details->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_phone" class="children_details_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($children_details->datecreated->Visible) { // datecreated ?>
	<?php if ($children_details->SortUrl($children_details->datecreated) == "") { ?>
		<td><div id="elh_children_details_datecreated" class="children_details_datecreated"><div class="ewTableHeaderCaption"><?php echo $children_details->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_children_details_datecreated" class="children_details_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $children_details->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($children_details->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($children_details->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$children_details_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$children_details_grid->StartRec = 1;
$children_details_grid->StopRec = $children_details_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($children_details_grid->FormKeyCountName) && ($children_details->CurrentAction == "gridadd" || $children_details->CurrentAction == "gridedit" || $children_details->CurrentAction == "F")) {
		$children_details_grid->KeyCount = $objForm->GetValue($children_details_grid->FormKeyCountName);
		$children_details_grid->StopRec = $children_details_grid->StartRec + $children_details_grid->KeyCount - 1;
	}
}
$children_details_grid->RecCnt = $children_details_grid->StartRec - 1;
if ($children_details_grid->Recordset && !$children_details_grid->Recordset->EOF) {
	$children_details_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $children_details_grid->StartRec > 1)
		$children_details_grid->Recordset->Move($children_details_grid->StartRec - 1);
} elseif (!$children_details->AllowAddDeleteRow && $children_details_grid->StopRec == 0) {
	$children_details_grid->StopRec = $children_details->GridAddRowCount;
}

// Initialize aggregate
$children_details->RowType = EW_ROWTYPE_AGGREGATEINIT;
$children_details->ResetAttrs();
$children_details_grid->RenderRow();
if ($children_details->CurrentAction == "gridadd")
	$children_details_grid->RowIndex = 0;
if ($children_details->CurrentAction == "gridedit")
	$children_details_grid->RowIndex = 0;
while ($children_details_grid->RecCnt < $children_details_grid->StopRec) {
	$children_details_grid->RecCnt++;
	if (intval($children_details_grid->RecCnt) >= intval($children_details_grid->StartRec)) {
		$children_details_grid->RowCnt++;
		if ($children_details->CurrentAction == "gridadd" || $children_details->CurrentAction == "gridedit" || $children_details->CurrentAction == "F") {
			$children_details_grid->RowIndex++;
			$objForm->Index = $children_details_grid->RowIndex;
			if ($objForm->HasValue($children_details_grid->FormActionName))
				$children_details_grid->RowAction = strval($objForm->GetValue($children_details_grid->FormActionName));
			elseif ($children_details->CurrentAction == "gridadd")
				$children_details_grid->RowAction = "insert";
			else
				$children_details_grid->RowAction = "";
		}

		// Set up key count
		$children_details_grid->KeyCount = $children_details_grid->RowIndex;

		// Init row class and style
		$children_details->ResetAttrs();
		$children_details->CssClass = "";
		if ($children_details->CurrentAction == "gridadd") {
			if ($children_details->CurrentMode == "copy") {
				$children_details_grid->LoadRowValues($children_details_grid->Recordset); // Load row values
				$children_details_grid->SetRecordKey($children_details_grid->RowOldKey, $children_details_grid->Recordset); // Set old record key
			} else {
				$children_details_grid->LoadDefaultValues(); // Load default values
				$children_details_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$children_details_grid->LoadRowValues($children_details_grid->Recordset); // Load row values
		}
		$children_details->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($children_details->CurrentAction == "gridadd") // Grid add
			$children_details->RowType = EW_ROWTYPE_ADD; // Render add
		if ($children_details->CurrentAction == "gridadd" && $children_details->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$children_details_grid->RestoreCurrentRowFormValues($children_details_grid->RowIndex); // Restore form values
		if ($children_details->CurrentAction == "gridedit") { // Grid edit
			if ($children_details->EventCancelled) {
				$children_details_grid->RestoreCurrentRowFormValues($children_details_grid->RowIndex); // Restore form values
			}
			if ($children_details_grid->RowAction == "insert")
				$children_details->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$children_details->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($children_details->CurrentAction == "gridedit" && ($children_details->RowType == EW_ROWTYPE_EDIT || $children_details->RowType == EW_ROWTYPE_ADD) && $children_details->EventCancelled) // Update failed
			$children_details_grid->RestoreCurrentRowFormValues($children_details_grid->RowIndex); // Restore form values
		if ($children_details->RowType == EW_ROWTYPE_EDIT) // Edit row
			$children_details_grid->EditRowCnt++;
		if ($children_details->CurrentAction == "F") // Confirm row
			$children_details_grid->RestoreCurrentRowFormValues($children_details_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$children_details->RowAttrs = array_merge($children_details->RowAttrs, array('data-rowindex'=>$children_details_grid->RowCnt, 'id'=>'r' . $children_details_grid->RowCnt . '_children_details', 'data-rowtype'=>$children_details->RowType));

		// Render row
		$children_details_grid->RenderRow();

		// Render list options
		$children_details_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($children_details_grid->RowAction <> "delete" && $children_details_grid->RowAction <> "insertdelete" && !($children_details_grid->RowAction == "insert" && $children_details->CurrentAction == "F" && $children_details_grid->EmptyRow())) {
?>
	<tr<?php echo $children_details->RowAttributes() ?>>
<?php

// Render list options (body, left)
$children_details_grid->ListOptions->Render("body", "left", $children_details_grid->RowCnt);
?>
	<?php if ($children_details->id->Visible) { // id ?>
		<td<?php echo $children_details->id->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $children_details_grid->RowIndex ?>_id" id="o<?php echo $children_details_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($children_details->id->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_id" class="control-group children_details_id">
<span<?php echo $children_details->id->ViewAttributes() ?>>
<?php echo $children_details->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $children_details_grid->RowIndex ?>_id" id="x<?php echo $children_details_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($children_details->id->CurrentValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->id->ViewAttributes() ?>>
<?php echo $children_details->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $children_details_grid->RowIndex ?>_id" id="x<?php echo $children_details_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($children_details->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $children_details_grid->RowIndex ?>_id" id="o<?php echo $children_details_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($children_details->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->name->Visible) { // name ?>
		<td<?php echo $children_details->name->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_name" class="control-group children_details_name">
<input type="text" data-field="x_name" name="x<?php echo $children_details_grid->RowIndex ?>_name" id="x<?php echo $children_details_grid->RowIndex ?>_name" size="30" maxlength="100" placeholder="<?php echo $children_details->name->PlaceHolder ?>" value="<?php echo $children_details->name->EditValue ?>"<?php echo $children_details->name->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_name" name="o<?php echo $children_details_grid->RowIndex ?>_name" id="o<?php echo $children_details_grid->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($children_details->name->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_name" class="control-group children_details_name">
<input type="text" data-field="x_name" name="x<?php echo $children_details_grid->RowIndex ?>_name" id="x<?php echo $children_details_grid->RowIndex ?>_name" size="30" maxlength="100" placeholder="<?php echo $children_details->name->PlaceHolder ?>" value="<?php echo $children_details->name->EditValue ?>"<?php echo $children_details->name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->name->ViewAttributes() ?>>
<?php echo $children_details->name->ListViewValue() ?></span>
<input type="hidden" data-field="x_name" name="x<?php echo $children_details_grid->RowIndex ?>_name" id="x<?php echo $children_details_grid->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($children_details->name->FormValue) ?>">
<input type="hidden" data-field="x_name" name="o<?php echo $children_details_grid->RowIndex ?>_name" id="o<?php echo $children_details_grid->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($children_details->name->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->gender->Visible) { // gender ?>
		<td<?php echo $children_details->gender->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_gender" class="control-group children_details_gender">
<input type="text" data-field="x_gender" name="x<?php echo $children_details_grid->RowIndex ?>_gender" id="x<?php echo $children_details_grid->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $children_details->gender->PlaceHolder ?>" value="<?php echo $children_details->gender->EditValue ?>"<?php echo $children_details->gender->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_gender" name="o<?php echo $children_details_grid->RowIndex ?>_gender" id="o<?php echo $children_details_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($children_details->gender->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_gender" class="control-group children_details_gender">
<input type="text" data-field="x_gender" name="x<?php echo $children_details_grid->RowIndex ?>_gender" id="x<?php echo $children_details_grid->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $children_details->gender->PlaceHolder ?>" value="<?php echo $children_details->gender->EditValue ?>"<?php echo $children_details->gender->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->gender->ViewAttributes() ?>>
<?php echo $children_details->gender->ListViewValue() ?></span>
<input type="hidden" data-field="x_gender" name="x<?php echo $children_details_grid->RowIndex ?>_gender" id="x<?php echo $children_details_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($children_details->gender->FormValue) ?>">
<input type="hidden" data-field="x_gender" name="o<?php echo $children_details_grid->RowIndex ?>_gender" id="o<?php echo $children_details_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($children_details->gender->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->dob->Visible) { // dob ?>
		<td<?php echo $children_details->dob->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_dob" class="control-group children_details_dob">
<input type="text" data-field="x_dob" name="x<?php echo $children_details_grid->RowIndex ?>_dob" id="x<?php echo $children_details_grid->RowIndex ?>_dob" size="30" maxlength="20" placeholder="<?php echo $children_details->dob->PlaceHolder ?>" value="<?php echo $children_details->dob->EditValue ?>"<?php echo $children_details->dob->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_dob" name="o<?php echo $children_details_grid->RowIndex ?>_dob" id="o<?php echo $children_details_grid->RowIndex ?>_dob" value="<?php echo ew_HtmlEncode($children_details->dob->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_dob" class="control-group children_details_dob">
<input type="text" data-field="x_dob" name="x<?php echo $children_details_grid->RowIndex ?>_dob" id="x<?php echo $children_details_grid->RowIndex ?>_dob" size="30" maxlength="20" placeholder="<?php echo $children_details->dob->PlaceHolder ?>" value="<?php echo $children_details->dob->EditValue ?>"<?php echo $children_details->dob->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->dob->ViewAttributes() ?>>
<?php echo $children_details->dob->ListViewValue() ?></span>
<input type="hidden" data-field="x_dob" name="x<?php echo $children_details_grid->RowIndex ?>_dob" id="x<?php echo $children_details_grid->RowIndex ?>_dob" value="<?php echo ew_HtmlEncode($children_details->dob->FormValue) ?>">
<input type="hidden" data-field="x_dob" name="o<?php echo $children_details_grid->RowIndex ?>_dob" id="o<?php echo $children_details_grid->RowIndex ?>_dob" value="<?php echo ew_HtmlEncode($children_details->dob->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->age->Visible) { // age ?>
		<td<?php echo $children_details->age->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_age" class="control-group children_details_age">
<input type="text" data-field="x_age" name="x<?php echo $children_details_grid->RowIndex ?>_age" id="x<?php echo $children_details_grid->RowIndex ?>_age" size="30" maxlength="5" placeholder="<?php echo $children_details->age->PlaceHolder ?>" value="<?php echo $children_details->age->EditValue ?>"<?php echo $children_details->age->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_age" name="o<?php echo $children_details_grid->RowIndex ?>_age" id="o<?php echo $children_details_grid->RowIndex ?>_age" value="<?php echo ew_HtmlEncode($children_details->age->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_age" class="control-group children_details_age">
<input type="text" data-field="x_age" name="x<?php echo $children_details_grid->RowIndex ?>_age" id="x<?php echo $children_details_grid->RowIndex ?>_age" size="30" maxlength="5" placeholder="<?php echo $children_details->age->PlaceHolder ?>" value="<?php echo $children_details->age->EditValue ?>"<?php echo $children_details->age->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->age->ViewAttributes() ?>>
<?php echo $children_details->age->ListViewValue() ?></span>
<input type="hidden" data-field="x_age" name="x<?php echo $children_details_grid->RowIndex ?>_age" id="x<?php echo $children_details_grid->RowIndex ?>_age" value="<?php echo ew_HtmlEncode($children_details->age->FormValue) ?>">
<input type="hidden" data-field="x_age" name="o<?php echo $children_details_grid->RowIndex ?>_age" id="o<?php echo $children_details_grid->RowIndex ?>_age" value="<?php echo ew_HtmlEncode($children_details->age->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->title->Visible) { // title ?>
		<td<?php echo $children_details->title->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_title" class="control-group children_details_title">
<input type="text" data-field="x_title" name="x<?php echo $children_details_grid->RowIndex ?>_title" id="x<?php echo $children_details_grid->RowIndex ?>_title" size="30" maxlength="10" placeholder="<?php echo $children_details->title->PlaceHolder ?>" value="<?php echo $children_details->title->EditValue ?>"<?php echo $children_details->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $children_details_grid->RowIndex ?>_title" id="o<?php echo $children_details_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($children_details->title->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_title" class="control-group children_details_title">
<input type="text" data-field="x_title" name="x<?php echo $children_details_grid->RowIndex ?>_title" id="x<?php echo $children_details_grid->RowIndex ?>_title" size="30" maxlength="10" placeholder="<?php echo $children_details->title->PlaceHolder ?>" value="<?php echo $children_details->title->EditValue ?>"<?php echo $children_details->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->title->ViewAttributes() ?>>
<?php echo $children_details->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $children_details_grid->RowIndex ?>_title" id="x<?php echo $children_details_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($children_details->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $children_details_grid->RowIndex ?>_title" id="o<?php echo $children_details_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($children_details->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->guardianname->Visible) { // guardianname ?>
		<td<?php echo $children_details->guardianname->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_guardianname" class="control-group children_details_guardianname">
<input type="text" data-field="x_guardianname" name="x<?php echo $children_details_grid->RowIndex ?>_guardianname" id="x<?php echo $children_details_grid->RowIndex ?>_guardianname" size="30" maxlength="50" placeholder="<?php echo $children_details->guardianname->PlaceHolder ?>" value="<?php echo $children_details->guardianname->EditValue ?>"<?php echo $children_details->guardianname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_guardianname" name="o<?php echo $children_details_grid->RowIndex ?>_guardianname" id="o<?php echo $children_details_grid->RowIndex ?>_guardianname" value="<?php echo ew_HtmlEncode($children_details->guardianname->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_guardianname" class="control-group children_details_guardianname">
<input type="text" data-field="x_guardianname" name="x<?php echo $children_details_grid->RowIndex ?>_guardianname" id="x<?php echo $children_details_grid->RowIndex ?>_guardianname" size="30" maxlength="50" placeholder="<?php echo $children_details->guardianname->PlaceHolder ?>" value="<?php echo $children_details->guardianname->EditValue ?>"<?php echo $children_details->guardianname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->guardianname->ViewAttributes() ?>>
<?php echo $children_details->guardianname->ListViewValue() ?></span>
<input type="hidden" data-field="x_guardianname" name="x<?php echo $children_details_grid->RowIndex ?>_guardianname" id="x<?php echo $children_details_grid->RowIndex ?>_guardianname" value="<?php echo ew_HtmlEncode($children_details->guardianname->FormValue) ?>">
<input type="hidden" data-field="x_guardianname" name="o<?php echo $children_details_grid->RowIndex ?>_guardianname" id="o<?php echo $children_details_grid->RowIndex ?>_guardianname" value="<?php echo ew_HtmlEncode($children_details->guardianname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->rtionship->Visible) { // rtionship ?>
		<td<?php echo $children_details->rtionship->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_rtionship" class="control-group children_details_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $children_details_grid->RowIndex ?>_rtionship" id="x<?php echo $children_details_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $children_details->rtionship->PlaceHolder ?>" value="<?php echo $children_details->rtionship->EditValue ?>"<?php echo $children_details->rtionship->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $children_details_grid->RowIndex ?>_rtionship" id="o<?php echo $children_details_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($children_details->rtionship->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_rtionship" class="control-group children_details_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $children_details_grid->RowIndex ?>_rtionship" id="x<?php echo $children_details_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $children_details->rtionship->PlaceHolder ?>" value="<?php echo $children_details->rtionship->EditValue ?>"<?php echo $children_details->rtionship->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->rtionship->ViewAttributes() ?>>
<?php echo $children_details->rtionship->ListViewValue() ?></span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $children_details_grid->RowIndex ?>_rtionship" id="x<?php echo $children_details_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($children_details->rtionship->FormValue) ?>">
<input type="hidden" data-field="x_rtionship" name="o<?php echo $children_details_grid->RowIndex ?>_rtionship" id="o<?php echo $children_details_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($children_details->rtionship->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->_email->Visible) { // email ?>
		<td<?php echo $children_details->_email->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details__email" class="control-group children_details__email">
<input type="text" data-field="x__email" name="x<?php echo $children_details_grid->RowIndex ?>__email" id="x<?php echo $children_details_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $children_details->_email->PlaceHolder ?>" value="<?php echo $children_details->_email->EditValue ?>"<?php echo $children_details->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $children_details_grid->RowIndex ?>__email" id="o<?php echo $children_details_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($children_details->_email->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details__email" class="control-group children_details__email">
<input type="text" data-field="x__email" name="x<?php echo $children_details_grid->RowIndex ?>__email" id="x<?php echo $children_details_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $children_details->_email->PlaceHolder ?>" value="<?php echo $children_details->_email->EditValue ?>"<?php echo $children_details->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->_email->ViewAttributes() ?>>
<?php echo $children_details->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $children_details_grid->RowIndex ?>__email" id="x<?php echo $children_details_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($children_details->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $children_details_grid->RowIndex ?>__email" id="o<?php echo $children_details_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($children_details->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->phone->Visible) { // phone ?>
		<td<?php echo $children_details->phone->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_phone" class="control-group children_details_phone">
<input type="text" data-field="x_phone" name="x<?php echo $children_details_grid->RowIndex ?>_phone" id="x<?php echo $children_details_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $children_details->phone->PlaceHolder ?>" value="<?php echo $children_details->phone->EditValue ?>"<?php echo $children_details->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $children_details_grid->RowIndex ?>_phone" id="o<?php echo $children_details_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($children_details->phone->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_phone" class="control-group children_details_phone">
<input type="text" data-field="x_phone" name="x<?php echo $children_details_grid->RowIndex ?>_phone" id="x<?php echo $children_details_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $children_details->phone->PlaceHolder ?>" value="<?php echo $children_details->phone->EditValue ?>"<?php echo $children_details->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->phone->ViewAttributes() ?>>
<?php echo $children_details->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $children_details_grid->RowIndex ?>_phone" id="x<?php echo $children_details_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($children_details->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $children_details_grid->RowIndex ?>_phone" id="o<?php echo $children_details_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($children_details->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($children_details->datecreated->Visible) { // datecreated ?>
		<td<?php echo $children_details->datecreated->CellAttributes() ?>>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_datecreated" class="control-group children_details_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $children_details_grid->RowIndex ?>_datecreated" id="x<?php echo $children_details_grid->RowIndex ?>_datecreated" placeholder="<?php echo $children_details->datecreated->PlaceHolder ?>" value="<?php echo $children_details->datecreated->EditValue ?>"<?php echo $children_details->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $children_details_grid->RowIndex ?>_datecreated" id="o<?php echo $children_details_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($children_details->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $children_details_grid->RowCnt ?>_children_details_datecreated" class="control-group children_details_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $children_details_grid->RowIndex ?>_datecreated" id="x<?php echo $children_details_grid->RowIndex ?>_datecreated" placeholder="<?php echo $children_details->datecreated->PlaceHolder ?>" value="<?php echo $children_details->datecreated->EditValue ?>"<?php echo $children_details->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($children_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $children_details->datecreated->ViewAttributes() ?>>
<?php echo $children_details->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $children_details_grid->RowIndex ?>_datecreated" id="x<?php echo $children_details_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($children_details->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $children_details_grid->RowIndex ?>_datecreated" id="o<?php echo $children_details_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($children_details->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $children_details_grid->PageObjName . "_row_" . $children_details_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$children_details_grid->ListOptions->Render("body", "right", $children_details_grid->RowCnt);
?>
	</tr>
<?php if ($children_details->RowType == EW_ROWTYPE_ADD || $children_details->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fchildren_detailsgrid.UpdateOpts(<?php echo $children_details_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($children_details->CurrentAction <> "gridadd" || $children_details->CurrentMode == "copy")
		if (!$children_details_grid->Recordset->EOF) $children_details_grid->Recordset->MoveNext();
}
?>
<?php
	if ($children_details->CurrentMode == "add" || $children_details->CurrentMode == "copy" || $children_details->CurrentMode == "edit") {
		$children_details_grid->RowIndex = '$rowindex$';
		$children_details_grid->LoadDefaultValues();

		// Set row properties
		$children_details->ResetAttrs();
		$children_details->RowAttrs = array_merge($children_details->RowAttrs, array('data-rowindex'=>$children_details_grid->RowIndex, 'id'=>'r0_children_details', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($children_details->RowAttrs["class"], "ewTemplate");
		$children_details->RowType = EW_ROWTYPE_ADD;

		// Render row
		$children_details_grid->RenderRow();

		// Render list options
		$children_details_grid->RenderListOptions();
		$children_details_grid->StartRowCnt = 0;
?>
	<tr<?php echo $children_details->RowAttributes() ?>>
<?php

// Render list options (body, left)
$children_details_grid->ListOptions->Render("body", "left", $children_details_grid->RowIndex);
?>
	<?php if ($children_details->id->Visible) { // id ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_children_details_id" class="control-group children_details_id">
<span<?php echo $children_details->id->ViewAttributes() ?>>
<?php echo $children_details->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $children_details_grid->RowIndex ?>_id" id="x<?php echo $children_details_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($children_details->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $children_details_grid->RowIndex ?>_id" id="o<?php echo $children_details_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($children_details->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->name->Visible) { // name ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_name" class="control-group children_details_name">
<input type="text" data-field="x_name" name="x<?php echo $children_details_grid->RowIndex ?>_name" id="x<?php echo $children_details_grid->RowIndex ?>_name" size="30" maxlength="100" placeholder="<?php echo $children_details->name->PlaceHolder ?>" value="<?php echo $children_details->name->EditValue ?>"<?php echo $children_details->name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_name" class="control-group children_details_name">
<span<?php echo $children_details->name->ViewAttributes() ?>>
<?php echo $children_details->name->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_name" name="x<?php echo $children_details_grid->RowIndex ?>_name" id="x<?php echo $children_details_grid->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($children_details->name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_name" name="o<?php echo $children_details_grid->RowIndex ?>_name" id="o<?php echo $children_details_grid->RowIndex ?>_name" value="<?php echo ew_HtmlEncode($children_details->name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->gender->Visible) { // gender ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_gender" class="control-group children_details_gender">
<input type="text" data-field="x_gender" name="x<?php echo $children_details_grid->RowIndex ?>_gender" id="x<?php echo $children_details_grid->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $children_details->gender->PlaceHolder ?>" value="<?php echo $children_details->gender->EditValue ?>"<?php echo $children_details->gender->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_gender" class="control-group children_details_gender">
<span<?php echo $children_details->gender->ViewAttributes() ?>>
<?php echo $children_details->gender->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_gender" name="x<?php echo $children_details_grid->RowIndex ?>_gender" id="x<?php echo $children_details_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($children_details->gender->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_gender" name="o<?php echo $children_details_grid->RowIndex ?>_gender" id="o<?php echo $children_details_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($children_details->gender->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->dob->Visible) { // dob ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_dob" class="control-group children_details_dob">
<input type="text" data-field="x_dob" name="x<?php echo $children_details_grid->RowIndex ?>_dob" id="x<?php echo $children_details_grid->RowIndex ?>_dob" size="30" maxlength="20" placeholder="<?php echo $children_details->dob->PlaceHolder ?>" value="<?php echo $children_details->dob->EditValue ?>"<?php echo $children_details->dob->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_dob" class="control-group children_details_dob">
<span<?php echo $children_details->dob->ViewAttributes() ?>>
<?php echo $children_details->dob->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_dob" name="x<?php echo $children_details_grid->RowIndex ?>_dob" id="x<?php echo $children_details_grid->RowIndex ?>_dob" value="<?php echo ew_HtmlEncode($children_details->dob->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_dob" name="o<?php echo $children_details_grid->RowIndex ?>_dob" id="o<?php echo $children_details_grid->RowIndex ?>_dob" value="<?php echo ew_HtmlEncode($children_details->dob->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->age->Visible) { // age ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_age" class="control-group children_details_age">
<input type="text" data-field="x_age" name="x<?php echo $children_details_grid->RowIndex ?>_age" id="x<?php echo $children_details_grid->RowIndex ?>_age" size="30" maxlength="5" placeholder="<?php echo $children_details->age->PlaceHolder ?>" value="<?php echo $children_details->age->EditValue ?>"<?php echo $children_details->age->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_age" class="control-group children_details_age">
<span<?php echo $children_details->age->ViewAttributes() ?>>
<?php echo $children_details->age->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_age" name="x<?php echo $children_details_grid->RowIndex ?>_age" id="x<?php echo $children_details_grid->RowIndex ?>_age" value="<?php echo ew_HtmlEncode($children_details->age->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_age" name="o<?php echo $children_details_grid->RowIndex ?>_age" id="o<?php echo $children_details_grid->RowIndex ?>_age" value="<?php echo ew_HtmlEncode($children_details->age->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->title->Visible) { // title ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_title" class="control-group children_details_title">
<input type="text" data-field="x_title" name="x<?php echo $children_details_grid->RowIndex ?>_title" id="x<?php echo $children_details_grid->RowIndex ?>_title" size="30" maxlength="10" placeholder="<?php echo $children_details->title->PlaceHolder ?>" value="<?php echo $children_details->title->EditValue ?>"<?php echo $children_details->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_title" class="control-group children_details_title">
<span<?php echo $children_details->title->ViewAttributes() ?>>
<?php echo $children_details->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $children_details_grid->RowIndex ?>_title" id="x<?php echo $children_details_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($children_details->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $children_details_grid->RowIndex ?>_title" id="o<?php echo $children_details_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($children_details->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->guardianname->Visible) { // guardianname ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_guardianname" class="control-group children_details_guardianname">
<input type="text" data-field="x_guardianname" name="x<?php echo $children_details_grid->RowIndex ?>_guardianname" id="x<?php echo $children_details_grid->RowIndex ?>_guardianname" size="30" maxlength="50" placeholder="<?php echo $children_details->guardianname->PlaceHolder ?>" value="<?php echo $children_details->guardianname->EditValue ?>"<?php echo $children_details->guardianname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_guardianname" class="control-group children_details_guardianname">
<span<?php echo $children_details->guardianname->ViewAttributes() ?>>
<?php echo $children_details->guardianname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_guardianname" name="x<?php echo $children_details_grid->RowIndex ?>_guardianname" id="x<?php echo $children_details_grid->RowIndex ?>_guardianname" value="<?php echo ew_HtmlEncode($children_details->guardianname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_guardianname" name="o<?php echo $children_details_grid->RowIndex ?>_guardianname" id="o<?php echo $children_details_grid->RowIndex ?>_guardianname" value="<?php echo ew_HtmlEncode($children_details->guardianname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->rtionship->Visible) { // rtionship ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_rtionship" class="control-group children_details_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $children_details_grid->RowIndex ?>_rtionship" id="x<?php echo $children_details_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $children_details->rtionship->PlaceHolder ?>" value="<?php echo $children_details->rtionship->EditValue ?>"<?php echo $children_details->rtionship->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_rtionship" class="control-group children_details_rtionship">
<span<?php echo $children_details->rtionship->ViewAttributes() ?>>
<?php echo $children_details->rtionship->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $children_details_grid->RowIndex ?>_rtionship" id="x<?php echo $children_details_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($children_details->rtionship->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $children_details_grid->RowIndex ?>_rtionship" id="o<?php echo $children_details_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($children_details->rtionship->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->_email->Visible) { // email ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details__email" class="control-group children_details__email">
<input type="text" data-field="x__email" name="x<?php echo $children_details_grid->RowIndex ?>__email" id="x<?php echo $children_details_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $children_details->_email->PlaceHolder ?>" value="<?php echo $children_details->_email->EditValue ?>"<?php echo $children_details->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details__email" class="control-group children_details__email">
<span<?php echo $children_details->_email->ViewAttributes() ?>>
<?php echo $children_details->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $children_details_grid->RowIndex ?>__email" id="x<?php echo $children_details_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($children_details->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $children_details_grid->RowIndex ?>__email" id="o<?php echo $children_details_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($children_details->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->phone->Visible) { // phone ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_phone" class="control-group children_details_phone">
<input type="text" data-field="x_phone" name="x<?php echo $children_details_grid->RowIndex ?>_phone" id="x<?php echo $children_details_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $children_details->phone->PlaceHolder ?>" value="<?php echo $children_details->phone->EditValue ?>"<?php echo $children_details->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_phone" class="control-group children_details_phone">
<span<?php echo $children_details->phone->ViewAttributes() ?>>
<?php echo $children_details->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $children_details_grid->RowIndex ?>_phone" id="x<?php echo $children_details_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($children_details->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $children_details_grid->RowIndex ?>_phone" id="o<?php echo $children_details_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($children_details->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($children_details->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($children_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_children_details_datecreated" class="control-group children_details_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $children_details_grid->RowIndex ?>_datecreated" id="x<?php echo $children_details_grid->RowIndex ?>_datecreated" placeholder="<?php echo $children_details->datecreated->PlaceHolder ?>" value="<?php echo $children_details->datecreated->EditValue ?>"<?php echo $children_details->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_children_details_datecreated" class="control-group children_details_datecreated">
<span<?php echo $children_details->datecreated->ViewAttributes() ?>>
<?php echo $children_details->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $children_details_grid->RowIndex ?>_datecreated" id="x<?php echo $children_details_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($children_details->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $children_details_grid->RowIndex ?>_datecreated" id="o<?php echo $children_details_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($children_details->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$children_details_grid->ListOptions->Render("body", "right", $children_details_grid->RowCnt);
?>
<script type="text/javascript">
fchildren_detailsgrid.UpdateOpts(<?php echo $children_details_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($children_details->CurrentMode == "add" || $children_details->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $children_details_grid->FormKeyCountName ?>" id="<?php echo $children_details_grid->FormKeyCountName ?>" value="<?php echo $children_details_grid->KeyCount ?>">
<?php echo $children_details_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($children_details->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $children_details_grid->FormKeyCountName ?>" id="<?php echo $children_details_grid->FormKeyCountName ?>" value="<?php echo $children_details_grid->KeyCount ?>">
<?php echo $children_details_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($children_details->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fchildren_detailsgrid">
</div>
<?php

// Close recordset
if ($children_details_grid->Recordset)
	$children_details_grid->Recordset->Close();
?>
<?php if ($children_details_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($children_details_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($children_details->Export == "") { ?>
<script type="text/javascript">
fchildren_detailsgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$children_details_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$children_details_grid->Page_Terminate();
?>
