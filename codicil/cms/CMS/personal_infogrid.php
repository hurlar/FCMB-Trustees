<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($personal_info_grid)) $personal_info_grid = new cpersonal_info_grid();

// Page init
$personal_info_grid->Page_Init();

// Page main
$personal_info_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$personal_info_grid->Page_Render();
?>
<?php if ($personal_info->Export == "") { ?>
<script type="text/javascript">

// Page object
var personal_info_grid = new ew_Page("personal_info_grid");
personal_info_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = personal_info_grid.PageID; // For backward compatibility

// Form object
var fpersonal_infogrid = new ew_Form("fpersonal_infogrid");
fpersonal_infogrid.FormKeyCountName = '<?php echo $personal_info_grid->FormKeyCountName ?>';

// Validate form
fpersonal_infogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_salutation");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->salutation->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_datecreated");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($personal_info->datecreated->FldCaption()) ?>");

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
fpersonal_infogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "salutation", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "mname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lname", false)) return false;
	if (ew_ValueChanged(fobj, infix, "phone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "aphone", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rstate", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gender", false)) return false;
	if (ew_ValueChanged(fobj, infix, "datecreated", false)) return false;
	return true;
}

// Form_CustomValidate event
fpersonal_infogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonal_infogrid.ValidateRequired = true;
<?php } else { ?>
fpersonal_infogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($personal_info_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $personal_info_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($personal_info->CurrentAction == "gridadd") {
	if ($personal_info->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$personal_info_grid->TotalRecs = $personal_info->SelectRecordCount();
			$personal_info_grid->Recordset = $personal_info_grid->LoadRecordset($personal_info_grid->StartRec-1, $personal_info_grid->DisplayRecs);
		} else {
			if ($personal_info_grid->Recordset = $personal_info_grid->LoadRecordset())
				$personal_info_grid->TotalRecs = $personal_info_grid->Recordset->RecordCount();
		}
		$personal_info_grid->StartRec = 1;
		$personal_info_grid->DisplayRecs = $personal_info_grid->TotalRecs;
	} else {
		$personal_info->CurrentFilter = "0=1";
		$personal_info_grid->StartRec = 1;
		$personal_info_grid->DisplayRecs = $personal_info->GridAddRowCount;
	}
	$personal_info_grid->TotalRecs = $personal_info_grid->DisplayRecs;
	$personal_info_grid->StopRec = $personal_info_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$personal_info_grid->TotalRecs = $personal_info->SelectRecordCount();
	} else {
		if ($personal_info_grid->Recordset = $personal_info_grid->LoadRecordset())
			$personal_info_grid->TotalRecs = $personal_info_grid->Recordset->RecordCount();
	}
	$personal_info_grid->StartRec = 1;
	$personal_info_grid->DisplayRecs = $personal_info_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$personal_info_grid->Recordset = $personal_info_grid->LoadRecordset($personal_info_grid->StartRec-1, $personal_info_grid->DisplayRecs);
}
$personal_info_grid->RenderOtherOptions();
?>
<?php $personal_info_grid->ShowPageHeader(); ?>
<?php
$personal_info_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fpersonal_infogrid" class="ewForm form-horizontal">
<div id="gmp_personal_info" class="ewGridMiddlePanel">
<table id="tbl_personal_infogrid" class="ewTable ewTableSeparate">
<?php echo $personal_info->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$personal_info_grid->RenderListOptions();

// Render list options (header, left)
$personal_info_grid->ListOptions->Render("header", "left");
?>
<?php if ($personal_info->salutation->Visible) { // salutation ?>
	<?php if ($personal_info->SortUrl($personal_info->salutation) == "") { ?>
		<td><div id="elh_personal_info_salutation" class="personal_info_salutation"><div class="ewTableHeaderCaption"><?php echo $personal_info->salutation->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_salutation" class="personal_info_salutation">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->salutation->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->salutation->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->salutation->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->fname->Visible) { // fname ?>
	<?php if ($personal_info->SortUrl($personal_info->fname) == "") { ?>
		<td><div id="elh_personal_info_fname" class="personal_info_fname"><div class="ewTableHeaderCaption"><?php echo $personal_info->fname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_fname" class="personal_info_fname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->fname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->fname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->fname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->mname->Visible) { // mname ?>
	<?php if ($personal_info->SortUrl($personal_info->mname) == "") { ?>
		<td><div id="elh_personal_info_mname" class="personal_info_mname"><div class="ewTableHeaderCaption"><?php echo $personal_info->mname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_mname" class="personal_info_mname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->mname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->mname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->mname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->lname->Visible) { // lname ?>
	<?php if ($personal_info->SortUrl($personal_info->lname) == "") { ?>
		<td><div id="elh_personal_info_lname" class="personal_info_lname"><div class="ewTableHeaderCaption"><?php echo $personal_info->lname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_lname" class="personal_info_lname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->lname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->lname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->lname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->phone->Visible) { // phone ?>
	<?php if ($personal_info->SortUrl($personal_info->phone) == "") { ?>
		<td><div id="elh_personal_info_phone" class="personal_info_phone"><div class="ewTableHeaderCaption"><?php echo $personal_info->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_phone" class="personal_info_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->aphone->Visible) { // aphone ?>
	<?php if ($personal_info->SortUrl($personal_info->aphone) == "") { ?>
		<td><div id="elh_personal_info_aphone" class="personal_info_aphone"><div class="ewTableHeaderCaption"><?php echo $personal_info->aphone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_aphone" class="personal_info_aphone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->aphone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->aphone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->aphone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->rstate->Visible) { // rstate ?>
	<?php if ($personal_info->SortUrl($personal_info->rstate) == "") { ?>
		<td><div id="elh_personal_info_rstate" class="personal_info_rstate"><div class="ewTableHeaderCaption"><?php echo $personal_info->rstate->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_rstate" class="personal_info_rstate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->rstate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->rstate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->rstate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->gender->Visible) { // gender ?>
	<?php if ($personal_info->SortUrl($personal_info->gender) == "") { ?>
		<td><div id="elh_personal_info_gender" class="personal_info_gender"><div class="ewTableHeaderCaption"><?php echo $personal_info->gender->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_gender" class="personal_info_gender">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->gender->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->gender->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->gender->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
	<?php if ($personal_info->SortUrl($personal_info->datecreated) == "") { ?>
		<td><div id="elh_personal_info_datecreated" class="personal_info_datecreated"><div class="ewTableHeaderCaption"><?php echo $personal_info->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_personal_info_datecreated" class="personal_info_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $personal_info->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($personal_info->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($personal_info->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$personal_info_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$personal_info_grid->StartRec = 1;
$personal_info_grid->StopRec = $personal_info_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($personal_info_grid->FormKeyCountName) && ($personal_info->CurrentAction == "gridadd" || $personal_info->CurrentAction == "gridedit" || $personal_info->CurrentAction == "F")) {
		$personal_info_grid->KeyCount = $objForm->GetValue($personal_info_grid->FormKeyCountName);
		$personal_info_grid->StopRec = $personal_info_grid->StartRec + $personal_info_grid->KeyCount - 1;
	}
}
$personal_info_grid->RecCnt = $personal_info_grid->StartRec - 1;
if ($personal_info_grid->Recordset && !$personal_info_grid->Recordset->EOF) {
	$personal_info_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $personal_info_grid->StartRec > 1)
		$personal_info_grid->Recordset->Move($personal_info_grid->StartRec - 1);
} elseif (!$personal_info->AllowAddDeleteRow && $personal_info_grid->StopRec == 0) {
	$personal_info_grid->StopRec = $personal_info->GridAddRowCount;
}

// Initialize aggregate
$personal_info->RowType = EW_ROWTYPE_AGGREGATEINIT;
$personal_info->ResetAttrs();
$personal_info_grid->RenderRow();
if ($personal_info->CurrentAction == "gridadd")
	$personal_info_grid->RowIndex = 0;
if ($personal_info->CurrentAction == "gridedit")
	$personal_info_grid->RowIndex = 0;
while ($personal_info_grid->RecCnt < $personal_info_grid->StopRec) {
	$personal_info_grid->RecCnt++;
	if (intval($personal_info_grid->RecCnt) >= intval($personal_info_grid->StartRec)) {
		$personal_info_grid->RowCnt++;
		if ($personal_info->CurrentAction == "gridadd" || $personal_info->CurrentAction == "gridedit" || $personal_info->CurrentAction == "F") {
			$personal_info_grid->RowIndex++;
			$objForm->Index = $personal_info_grid->RowIndex;
			if ($objForm->HasValue($personal_info_grid->FormActionName))
				$personal_info_grid->RowAction = strval($objForm->GetValue($personal_info_grid->FormActionName));
			elseif ($personal_info->CurrentAction == "gridadd")
				$personal_info_grid->RowAction = "insert";
			else
				$personal_info_grid->RowAction = "";
		}

		// Set up key count
		$personal_info_grid->KeyCount = $personal_info_grid->RowIndex;

		// Init row class and style
		$personal_info->ResetAttrs();
		$personal_info->CssClass = "";
		if ($personal_info->CurrentAction == "gridadd") {
			if ($personal_info->CurrentMode == "copy") {
				$personal_info_grid->LoadRowValues($personal_info_grid->Recordset); // Load row values
				$personal_info_grid->SetRecordKey($personal_info_grid->RowOldKey, $personal_info_grid->Recordset); // Set old record key
			} else {
				$personal_info_grid->LoadDefaultValues(); // Load default values
				$personal_info_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$personal_info_grid->LoadRowValues($personal_info_grid->Recordset); // Load row values
		}
		$personal_info->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($personal_info->CurrentAction == "gridadd") // Grid add
			$personal_info->RowType = EW_ROWTYPE_ADD; // Render add
		if ($personal_info->CurrentAction == "gridadd" && $personal_info->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$personal_info_grid->RestoreCurrentRowFormValues($personal_info_grid->RowIndex); // Restore form values
		if ($personal_info->CurrentAction == "gridedit") { // Grid edit
			if ($personal_info->EventCancelled) {
				$personal_info_grid->RestoreCurrentRowFormValues($personal_info_grid->RowIndex); // Restore form values
			}
			if ($personal_info_grid->RowAction == "insert")
				$personal_info->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$personal_info->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($personal_info->CurrentAction == "gridedit" && ($personal_info->RowType == EW_ROWTYPE_EDIT || $personal_info->RowType == EW_ROWTYPE_ADD) && $personal_info->EventCancelled) // Update failed
			$personal_info_grid->RestoreCurrentRowFormValues($personal_info_grid->RowIndex); // Restore form values
		if ($personal_info->RowType == EW_ROWTYPE_EDIT) // Edit row
			$personal_info_grid->EditRowCnt++;
		if ($personal_info->CurrentAction == "F") // Confirm row
			$personal_info_grid->RestoreCurrentRowFormValues($personal_info_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$personal_info->RowAttrs = array_merge($personal_info->RowAttrs, array('data-rowindex'=>$personal_info_grid->RowCnt, 'id'=>'r' . $personal_info_grid->RowCnt . '_personal_info', 'data-rowtype'=>$personal_info->RowType));

		// Render row
		$personal_info_grid->RenderRow();

		// Render list options
		$personal_info_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($personal_info_grid->RowAction <> "delete" && $personal_info_grid->RowAction <> "insertdelete" && !($personal_info_grid->RowAction == "insert" && $personal_info->CurrentAction == "F" && $personal_info_grid->EmptyRow())) {
?>
	<tr<?php echo $personal_info->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personal_info_grid->ListOptions->Render("body", "left", $personal_info_grid->RowCnt);
?>
	<?php if ($personal_info->salutation->Visible) { // salutation ?>
		<td<?php echo $personal_info->salutation->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_salutation" class="control-group personal_info_salutation">
<input type="text" data-field="x_salutation" name="x<?php echo $personal_info_grid->RowIndex ?>_salutation" id="x<?php echo $personal_info_grid->RowIndex ?>_salutation" size="30" maxlength="20" placeholder="<?php echo $personal_info->salutation->PlaceHolder ?>" value="<?php echo $personal_info->salutation->EditValue ?>"<?php echo $personal_info->salutation->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_salutation" name="o<?php echo $personal_info_grid->RowIndex ?>_salutation" id="o<?php echo $personal_info_grid->RowIndex ?>_salutation" value="<?php echo ew_HtmlEncode($personal_info->salutation->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_salutation" class="control-group personal_info_salutation">
<input type="text" data-field="x_salutation" name="x<?php echo $personal_info_grid->RowIndex ?>_salutation" id="x<?php echo $personal_info_grid->RowIndex ?>_salutation" size="30" maxlength="20" placeholder="<?php echo $personal_info->salutation->PlaceHolder ?>" value="<?php echo $personal_info->salutation->EditValue ?>"<?php echo $personal_info->salutation->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->salutation->ViewAttributes() ?>>
<?php echo $personal_info->salutation->ListViewValue() ?></span>
<input type="hidden" data-field="x_salutation" name="x<?php echo $personal_info_grid->RowIndex ?>_salutation" id="x<?php echo $personal_info_grid->RowIndex ?>_salutation" value="<?php echo ew_HtmlEncode($personal_info->salutation->FormValue) ?>">
<input type="hidden" data-field="x_salutation" name="o<?php echo $personal_info_grid->RowIndex ?>_salutation" id="o<?php echo $personal_info_grid->RowIndex ?>_salutation" value="<?php echo ew_HtmlEncode($personal_info->salutation->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="x<?php echo $personal_info_grid->RowIndex ?>_id" id="x<?php echo $personal_info_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($personal_info->id->CurrentValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $personal_info_grid->RowIndex ?>_id" id="o<?php echo $personal_info_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($personal_info->id->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT || $personal_info->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_id" name="x<?php echo $personal_info_grid->RowIndex ?>_id" id="x<?php echo $personal_info_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($personal_info->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($personal_info->fname->Visible) { // fname ?>
		<td<?php echo $personal_info->fname->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_fname" class="control-group personal_info_fname">
<input type="text" data-field="x_fname" name="x<?php echo $personal_info_grid->RowIndex ?>_fname" id="x<?php echo $personal_info_grid->RowIndex ?>_fname" size="30" maxlength="50" placeholder="<?php echo $personal_info->fname->PlaceHolder ?>" value="<?php echo $personal_info->fname->EditValue ?>"<?php echo $personal_info->fname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fname" name="o<?php echo $personal_info_grid->RowIndex ?>_fname" id="o<?php echo $personal_info_grid->RowIndex ?>_fname" value="<?php echo ew_HtmlEncode($personal_info->fname->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_fname" class="control-group personal_info_fname">
<input type="text" data-field="x_fname" name="x<?php echo $personal_info_grid->RowIndex ?>_fname" id="x<?php echo $personal_info_grid->RowIndex ?>_fname" size="30" maxlength="50" placeholder="<?php echo $personal_info->fname->PlaceHolder ?>" value="<?php echo $personal_info->fname->EditValue ?>"<?php echo $personal_info->fname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->fname->ViewAttributes() ?>>
<?php echo $personal_info->fname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fname" name="x<?php echo $personal_info_grid->RowIndex ?>_fname" id="x<?php echo $personal_info_grid->RowIndex ?>_fname" value="<?php echo ew_HtmlEncode($personal_info->fname->FormValue) ?>">
<input type="hidden" data-field="x_fname" name="o<?php echo $personal_info_grid->RowIndex ?>_fname" id="o<?php echo $personal_info_grid->RowIndex ?>_fname" value="<?php echo ew_HtmlEncode($personal_info->fname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->mname->Visible) { // mname ?>
		<td<?php echo $personal_info->mname->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_mname" class="control-group personal_info_mname">
<input type="text" data-field="x_mname" name="x<?php echo $personal_info_grid->RowIndex ?>_mname" id="x<?php echo $personal_info_grid->RowIndex ?>_mname" size="30" maxlength="50" placeholder="<?php echo $personal_info->mname->PlaceHolder ?>" value="<?php echo $personal_info->mname->EditValue ?>"<?php echo $personal_info->mname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_mname" name="o<?php echo $personal_info_grid->RowIndex ?>_mname" id="o<?php echo $personal_info_grid->RowIndex ?>_mname" value="<?php echo ew_HtmlEncode($personal_info->mname->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_mname" class="control-group personal_info_mname">
<input type="text" data-field="x_mname" name="x<?php echo $personal_info_grid->RowIndex ?>_mname" id="x<?php echo $personal_info_grid->RowIndex ?>_mname" size="30" maxlength="50" placeholder="<?php echo $personal_info->mname->PlaceHolder ?>" value="<?php echo $personal_info->mname->EditValue ?>"<?php echo $personal_info->mname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->mname->ViewAttributes() ?>>
<?php echo $personal_info->mname->ListViewValue() ?></span>
<input type="hidden" data-field="x_mname" name="x<?php echo $personal_info_grid->RowIndex ?>_mname" id="x<?php echo $personal_info_grid->RowIndex ?>_mname" value="<?php echo ew_HtmlEncode($personal_info->mname->FormValue) ?>">
<input type="hidden" data-field="x_mname" name="o<?php echo $personal_info_grid->RowIndex ?>_mname" id="o<?php echo $personal_info_grid->RowIndex ?>_mname" value="<?php echo ew_HtmlEncode($personal_info->mname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->lname->Visible) { // lname ?>
		<td<?php echo $personal_info->lname->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_lname" class="control-group personal_info_lname">
<input type="text" data-field="x_lname" name="x<?php echo $personal_info_grid->RowIndex ?>_lname" id="x<?php echo $personal_info_grid->RowIndex ?>_lname" size="30" maxlength="50" placeholder="<?php echo $personal_info->lname->PlaceHolder ?>" value="<?php echo $personal_info->lname->EditValue ?>"<?php echo $personal_info->lname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_lname" name="o<?php echo $personal_info_grid->RowIndex ?>_lname" id="o<?php echo $personal_info_grid->RowIndex ?>_lname" value="<?php echo ew_HtmlEncode($personal_info->lname->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_lname" class="control-group personal_info_lname">
<input type="text" data-field="x_lname" name="x<?php echo $personal_info_grid->RowIndex ?>_lname" id="x<?php echo $personal_info_grid->RowIndex ?>_lname" size="30" maxlength="50" placeholder="<?php echo $personal_info->lname->PlaceHolder ?>" value="<?php echo $personal_info->lname->EditValue ?>"<?php echo $personal_info->lname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->lname->ViewAttributes() ?>>
<?php echo $personal_info->lname->ListViewValue() ?></span>
<input type="hidden" data-field="x_lname" name="x<?php echo $personal_info_grid->RowIndex ?>_lname" id="x<?php echo $personal_info_grid->RowIndex ?>_lname" value="<?php echo ew_HtmlEncode($personal_info->lname->FormValue) ?>">
<input type="hidden" data-field="x_lname" name="o<?php echo $personal_info_grid->RowIndex ?>_lname" id="o<?php echo $personal_info_grid->RowIndex ?>_lname" value="<?php echo ew_HtmlEncode($personal_info->lname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->phone->Visible) { // phone ?>
		<td<?php echo $personal_info->phone->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_phone" class="control-group personal_info_phone">
<input type="text" data-field="x_phone" name="x<?php echo $personal_info_grid->RowIndex ?>_phone" id="x<?php echo $personal_info_grid->RowIndex ?>_phone" size="30" maxlength="15" placeholder="<?php echo $personal_info->phone->PlaceHolder ?>" value="<?php echo $personal_info->phone->EditValue ?>"<?php echo $personal_info->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $personal_info_grid->RowIndex ?>_phone" id="o<?php echo $personal_info_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($personal_info->phone->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_phone" class="control-group personal_info_phone">
<input type="text" data-field="x_phone" name="x<?php echo $personal_info_grid->RowIndex ?>_phone" id="x<?php echo $personal_info_grid->RowIndex ?>_phone" size="30" maxlength="15" placeholder="<?php echo $personal_info->phone->PlaceHolder ?>" value="<?php echo $personal_info->phone->EditValue ?>"<?php echo $personal_info->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->phone->ViewAttributes() ?>>
<?php echo $personal_info->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $personal_info_grid->RowIndex ?>_phone" id="x<?php echo $personal_info_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($personal_info->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $personal_info_grid->RowIndex ?>_phone" id="o<?php echo $personal_info_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($personal_info->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->aphone->Visible) { // aphone ?>
		<td<?php echo $personal_info->aphone->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_aphone" class="control-group personal_info_aphone">
<input type="text" data-field="x_aphone" name="x<?php echo $personal_info_grid->RowIndex ?>_aphone" id="x<?php echo $personal_info_grid->RowIndex ?>_aphone" size="30" maxlength="15" placeholder="<?php echo $personal_info->aphone->PlaceHolder ?>" value="<?php echo $personal_info->aphone->EditValue ?>"<?php echo $personal_info->aphone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_aphone" name="o<?php echo $personal_info_grid->RowIndex ?>_aphone" id="o<?php echo $personal_info_grid->RowIndex ?>_aphone" value="<?php echo ew_HtmlEncode($personal_info->aphone->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_aphone" class="control-group personal_info_aphone">
<input type="text" data-field="x_aphone" name="x<?php echo $personal_info_grid->RowIndex ?>_aphone" id="x<?php echo $personal_info_grid->RowIndex ?>_aphone" size="30" maxlength="15" placeholder="<?php echo $personal_info->aphone->PlaceHolder ?>" value="<?php echo $personal_info->aphone->EditValue ?>"<?php echo $personal_info->aphone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->aphone->ViewAttributes() ?>>
<?php echo $personal_info->aphone->ListViewValue() ?></span>
<input type="hidden" data-field="x_aphone" name="x<?php echo $personal_info_grid->RowIndex ?>_aphone" id="x<?php echo $personal_info_grid->RowIndex ?>_aphone" value="<?php echo ew_HtmlEncode($personal_info->aphone->FormValue) ?>">
<input type="hidden" data-field="x_aphone" name="o<?php echo $personal_info_grid->RowIndex ?>_aphone" id="o<?php echo $personal_info_grid->RowIndex ?>_aphone" value="<?php echo ew_HtmlEncode($personal_info->aphone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->rstate->Visible) { // rstate ?>
		<td<?php echo $personal_info->rstate->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_rstate" class="control-group personal_info_rstate">
<input type="text" data-field="x_rstate" name="x<?php echo $personal_info_grid->RowIndex ?>_rstate" id="x<?php echo $personal_info_grid->RowIndex ?>_rstate" size="30" maxlength="20" placeholder="<?php echo $personal_info->rstate->PlaceHolder ?>" value="<?php echo $personal_info->rstate->EditValue ?>"<?php echo $personal_info->rstate->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_rstate" name="o<?php echo $personal_info_grid->RowIndex ?>_rstate" id="o<?php echo $personal_info_grid->RowIndex ?>_rstate" value="<?php echo ew_HtmlEncode($personal_info->rstate->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_rstate" class="control-group personal_info_rstate">
<input type="text" data-field="x_rstate" name="x<?php echo $personal_info_grid->RowIndex ?>_rstate" id="x<?php echo $personal_info_grid->RowIndex ?>_rstate" size="30" maxlength="20" placeholder="<?php echo $personal_info->rstate->PlaceHolder ?>" value="<?php echo $personal_info->rstate->EditValue ?>"<?php echo $personal_info->rstate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->rstate->ViewAttributes() ?>>
<?php echo $personal_info->rstate->ListViewValue() ?></span>
<input type="hidden" data-field="x_rstate" name="x<?php echo $personal_info_grid->RowIndex ?>_rstate" id="x<?php echo $personal_info_grid->RowIndex ?>_rstate" value="<?php echo ew_HtmlEncode($personal_info->rstate->FormValue) ?>">
<input type="hidden" data-field="x_rstate" name="o<?php echo $personal_info_grid->RowIndex ?>_rstate" id="o<?php echo $personal_info_grid->RowIndex ?>_rstate" value="<?php echo ew_HtmlEncode($personal_info->rstate->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->gender->Visible) { // gender ?>
		<td<?php echo $personal_info->gender->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_gender" class="control-group personal_info_gender">
<input type="text" data-field="x_gender" name="x<?php echo $personal_info_grid->RowIndex ?>_gender" id="x<?php echo $personal_info_grid->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $personal_info->gender->PlaceHolder ?>" value="<?php echo $personal_info->gender->EditValue ?>"<?php echo $personal_info->gender->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_gender" name="o<?php echo $personal_info_grid->RowIndex ?>_gender" id="o<?php echo $personal_info_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($personal_info->gender->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_gender" class="control-group personal_info_gender">
<input type="text" data-field="x_gender" name="x<?php echo $personal_info_grid->RowIndex ?>_gender" id="x<?php echo $personal_info_grid->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $personal_info->gender->PlaceHolder ?>" value="<?php echo $personal_info->gender->EditValue ?>"<?php echo $personal_info->gender->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->gender->ViewAttributes() ?>>
<?php echo $personal_info->gender->ListViewValue() ?></span>
<input type="hidden" data-field="x_gender" name="x<?php echo $personal_info_grid->RowIndex ?>_gender" id="x<?php echo $personal_info_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($personal_info->gender->FormValue) ?>">
<input type="hidden" data-field="x_gender" name="o<?php echo $personal_info_grid->RowIndex ?>_gender" id="o<?php echo $personal_info_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($personal_info->gender->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
		<td<?php echo $personal_info->datecreated->CellAttributes() ?>>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_datecreated" class="control-group personal_info_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" placeholder="<?php echo $personal_info->datecreated->PlaceHolder ?>" value="<?php echo $personal_info->datecreated->EditValue ?>"<?php echo $personal_info->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="o<?php echo $personal_info_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($personal_info->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $personal_info_grid->RowCnt ?>_personal_info_datecreated" class="control-group personal_info_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" placeholder="<?php echo $personal_info->datecreated->PlaceHolder ?>" value="<?php echo $personal_info->datecreated->EditValue ?>"<?php echo $personal_info->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($personal_info->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $personal_info->datecreated->ViewAttributes() ?>>
<?php echo $personal_info->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($personal_info->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="o<?php echo $personal_info_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($personal_info->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $personal_info_grid->PageObjName . "_row_" . $personal_info_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$personal_info_grid->ListOptions->Render("body", "right", $personal_info_grid->RowCnt);
?>
	</tr>
<?php if ($personal_info->RowType == EW_ROWTYPE_ADD || $personal_info->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersonal_infogrid.UpdateOpts(<?php echo $personal_info_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($personal_info->CurrentAction <> "gridadd" || $personal_info->CurrentMode == "copy")
		if (!$personal_info_grid->Recordset->EOF) $personal_info_grid->Recordset->MoveNext();
}
?>
<?php
	if ($personal_info->CurrentMode == "add" || $personal_info->CurrentMode == "copy" || $personal_info->CurrentMode == "edit") {
		$personal_info_grid->RowIndex = '$rowindex$';
		$personal_info_grid->LoadDefaultValues();

		// Set row properties
		$personal_info->ResetAttrs();
		$personal_info->RowAttrs = array_merge($personal_info->RowAttrs, array('data-rowindex'=>$personal_info_grid->RowIndex, 'id'=>'r0_personal_info', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($personal_info->RowAttrs["class"], "ewTemplate");
		$personal_info->RowType = EW_ROWTYPE_ADD;

		// Render row
		$personal_info_grid->RenderRow();

		// Render list options
		$personal_info_grid->RenderListOptions();
		$personal_info_grid->StartRowCnt = 0;
?>
	<tr<?php echo $personal_info->RowAttributes() ?>>
<?php

// Render list options (body, left)
$personal_info_grid->ListOptions->Render("body", "left", $personal_info_grid->RowIndex);
?>
	<?php if ($personal_info->salutation->Visible) { // salutation ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_salutation" class="control-group personal_info_salutation">
<input type="text" data-field="x_salutation" name="x<?php echo $personal_info_grid->RowIndex ?>_salutation" id="x<?php echo $personal_info_grid->RowIndex ?>_salutation" size="30" maxlength="20" placeholder="<?php echo $personal_info->salutation->PlaceHolder ?>" value="<?php echo $personal_info->salutation->EditValue ?>"<?php echo $personal_info->salutation->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_salutation" class="control-group personal_info_salutation">
<span<?php echo $personal_info->salutation->ViewAttributes() ?>>
<?php echo $personal_info->salutation->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_salutation" name="x<?php echo $personal_info_grid->RowIndex ?>_salutation" id="x<?php echo $personal_info_grid->RowIndex ?>_salutation" value="<?php echo ew_HtmlEncode($personal_info->salutation->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_salutation" name="o<?php echo $personal_info_grid->RowIndex ?>_salutation" id="o<?php echo $personal_info_grid->RowIndex ?>_salutation" value="<?php echo ew_HtmlEncode($personal_info->salutation->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->fname->Visible) { // fname ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_fname" class="control-group personal_info_fname">
<input type="text" data-field="x_fname" name="x<?php echo $personal_info_grid->RowIndex ?>_fname" id="x<?php echo $personal_info_grid->RowIndex ?>_fname" size="30" maxlength="50" placeholder="<?php echo $personal_info->fname->PlaceHolder ?>" value="<?php echo $personal_info->fname->EditValue ?>"<?php echo $personal_info->fname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_fname" class="control-group personal_info_fname">
<span<?php echo $personal_info->fname->ViewAttributes() ?>>
<?php echo $personal_info->fname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fname" name="x<?php echo $personal_info_grid->RowIndex ?>_fname" id="x<?php echo $personal_info_grid->RowIndex ?>_fname" value="<?php echo ew_HtmlEncode($personal_info->fname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fname" name="o<?php echo $personal_info_grid->RowIndex ?>_fname" id="o<?php echo $personal_info_grid->RowIndex ?>_fname" value="<?php echo ew_HtmlEncode($personal_info->fname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->mname->Visible) { // mname ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_mname" class="control-group personal_info_mname">
<input type="text" data-field="x_mname" name="x<?php echo $personal_info_grid->RowIndex ?>_mname" id="x<?php echo $personal_info_grid->RowIndex ?>_mname" size="30" maxlength="50" placeholder="<?php echo $personal_info->mname->PlaceHolder ?>" value="<?php echo $personal_info->mname->EditValue ?>"<?php echo $personal_info->mname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_mname" class="control-group personal_info_mname">
<span<?php echo $personal_info->mname->ViewAttributes() ?>>
<?php echo $personal_info->mname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_mname" name="x<?php echo $personal_info_grid->RowIndex ?>_mname" id="x<?php echo $personal_info_grid->RowIndex ?>_mname" value="<?php echo ew_HtmlEncode($personal_info->mname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_mname" name="o<?php echo $personal_info_grid->RowIndex ?>_mname" id="o<?php echo $personal_info_grid->RowIndex ?>_mname" value="<?php echo ew_HtmlEncode($personal_info->mname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->lname->Visible) { // lname ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_lname" class="control-group personal_info_lname">
<input type="text" data-field="x_lname" name="x<?php echo $personal_info_grid->RowIndex ?>_lname" id="x<?php echo $personal_info_grid->RowIndex ?>_lname" size="30" maxlength="50" placeholder="<?php echo $personal_info->lname->PlaceHolder ?>" value="<?php echo $personal_info->lname->EditValue ?>"<?php echo $personal_info->lname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_lname" class="control-group personal_info_lname">
<span<?php echo $personal_info->lname->ViewAttributes() ?>>
<?php echo $personal_info->lname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_lname" name="x<?php echo $personal_info_grid->RowIndex ?>_lname" id="x<?php echo $personal_info_grid->RowIndex ?>_lname" value="<?php echo ew_HtmlEncode($personal_info->lname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_lname" name="o<?php echo $personal_info_grid->RowIndex ?>_lname" id="o<?php echo $personal_info_grid->RowIndex ?>_lname" value="<?php echo ew_HtmlEncode($personal_info->lname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->phone->Visible) { // phone ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_phone" class="control-group personal_info_phone">
<input type="text" data-field="x_phone" name="x<?php echo $personal_info_grid->RowIndex ?>_phone" id="x<?php echo $personal_info_grid->RowIndex ?>_phone" size="30" maxlength="15" placeholder="<?php echo $personal_info->phone->PlaceHolder ?>" value="<?php echo $personal_info->phone->EditValue ?>"<?php echo $personal_info->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_phone" class="control-group personal_info_phone">
<span<?php echo $personal_info->phone->ViewAttributes() ?>>
<?php echo $personal_info->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $personal_info_grid->RowIndex ?>_phone" id="x<?php echo $personal_info_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($personal_info->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $personal_info_grid->RowIndex ?>_phone" id="o<?php echo $personal_info_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($personal_info->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->aphone->Visible) { // aphone ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_aphone" class="control-group personal_info_aphone">
<input type="text" data-field="x_aphone" name="x<?php echo $personal_info_grid->RowIndex ?>_aphone" id="x<?php echo $personal_info_grid->RowIndex ?>_aphone" size="30" maxlength="15" placeholder="<?php echo $personal_info->aphone->PlaceHolder ?>" value="<?php echo $personal_info->aphone->EditValue ?>"<?php echo $personal_info->aphone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_aphone" class="control-group personal_info_aphone">
<span<?php echo $personal_info->aphone->ViewAttributes() ?>>
<?php echo $personal_info->aphone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_aphone" name="x<?php echo $personal_info_grid->RowIndex ?>_aphone" id="x<?php echo $personal_info_grid->RowIndex ?>_aphone" value="<?php echo ew_HtmlEncode($personal_info->aphone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_aphone" name="o<?php echo $personal_info_grid->RowIndex ?>_aphone" id="o<?php echo $personal_info_grid->RowIndex ?>_aphone" value="<?php echo ew_HtmlEncode($personal_info->aphone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->rstate->Visible) { // rstate ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_rstate" class="control-group personal_info_rstate">
<input type="text" data-field="x_rstate" name="x<?php echo $personal_info_grid->RowIndex ?>_rstate" id="x<?php echo $personal_info_grid->RowIndex ?>_rstate" size="30" maxlength="20" placeholder="<?php echo $personal_info->rstate->PlaceHolder ?>" value="<?php echo $personal_info->rstate->EditValue ?>"<?php echo $personal_info->rstate->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_rstate" class="control-group personal_info_rstate">
<span<?php echo $personal_info->rstate->ViewAttributes() ?>>
<?php echo $personal_info->rstate->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_rstate" name="x<?php echo $personal_info_grid->RowIndex ?>_rstate" id="x<?php echo $personal_info_grid->RowIndex ?>_rstate" value="<?php echo ew_HtmlEncode($personal_info->rstate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_rstate" name="o<?php echo $personal_info_grid->RowIndex ?>_rstate" id="o<?php echo $personal_info_grid->RowIndex ?>_rstate" value="<?php echo ew_HtmlEncode($personal_info->rstate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->gender->Visible) { // gender ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_gender" class="control-group personal_info_gender">
<input type="text" data-field="x_gender" name="x<?php echo $personal_info_grid->RowIndex ?>_gender" id="x<?php echo $personal_info_grid->RowIndex ?>_gender" size="30" maxlength="10" placeholder="<?php echo $personal_info->gender->PlaceHolder ?>" value="<?php echo $personal_info->gender->EditValue ?>"<?php echo $personal_info->gender->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_gender" class="control-group personal_info_gender">
<span<?php echo $personal_info->gender->ViewAttributes() ?>>
<?php echo $personal_info->gender->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_gender" name="x<?php echo $personal_info_grid->RowIndex ?>_gender" id="x<?php echo $personal_info_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($personal_info->gender->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_gender" name="o<?php echo $personal_info_grid->RowIndex ?>_gender" id="o<?php echo $personal_info_grid->RowIndex ?>_gender" value="<?php echo ew_HtmlEncode($personal_info->gender->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($personal_info->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($personal_info->CurrentAction <> "F") { ?>
<span id="el$rowindex$_personal_info_datecreated" class="control-group personal_info_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" placeholder="<?php echo $personal_info->datecreated->PlaceHolder ?>" value="<?php echo $personal_info->datecreated->EditValue ?>"<?php echo $personal_info->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_personal_info_datecreated" class="control-group personal_info_datecreated">
<span<?php echo $personal_info->datecreated->ViewAttributes() ?>>
<?php echo $personal_info->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="x<?php echo $personal_info_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($personal_info->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $personal_info_grid->RowIndex ?>_datecreated" id="o<?php echo $personal_info_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($personal_info->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$personal_info_grid->ListOptions->Render("body", "right", $personal_info_grid->RowCnt);
?>
<script type="text/javascript">
fpersonal_infogrid.UpdateOpts(<?php echo $personal_info_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($personal_info->CurrentMode == "add" || $personal_info->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $personal_info_grid->FormKeyCountName ?>" id="<?php echo $personal_info_grid->FormKeyCountName ?>" value="<?php echo $personal_info_grid->KeyCount ?>">
<?php echo $personal_info_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($personal_info->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $personal_info_grid->FormKeyCountName ?>" id="<?php echo $personal_info_grid->FormKeyCountName ?>" value="<?php echo $personal_info_grid->KeyCount ?>">
<?php echo $personal_info_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($personal_info->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpersonal_infogrid">
</div>
<?php

// Close recordset
if ($personal_info_grid->Recordset)
	$personal_info_grid->Recordset->Close();
?>
<?php if ($personal_info_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($personal_info_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($personal_info->Export == "") { ?>
<script type="text/javascript">
fpersonal_infogrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$personal_info_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$personal_info_grid->Page_Terminate();
?>
