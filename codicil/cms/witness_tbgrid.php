<?php include_once "adminusersinfo.php" ?>
<?php

// Create page object
if (!isset($witness_tb_grid)) $witness_tb_grid = new cwitness_tb_grid();

// Page init
$witness_tb_grid->Page_Init();

// Page main
$witness_tb_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$witness_tb_grid->Page_Render();
?>
<?php if ($witness_tb->Export == "") { ?>
<script type="text/javascript">

// Page object
var witness_tb_grid = new ew_Page("witness_tb_grid");
witness_tb_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = witness_tb_grid.PageID; // For backward compatibility

// Form object
var fwitness_tbgrid = new ew_Form("fwitness_tbgrid");
fwitness_tbgrid.FormKeyCountName = '<?php echo $witness_tb_grid->FormKeyCountName ?>';

// Validate form
fwitness_tbgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($witness_tb->uid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_title");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($witness_tb->title->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_rtionship");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($witness_tb->rtionship->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($witness_tb->_email->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_phone");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($witness_tb->phone->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_city");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($witness_tb->city->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_state");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($witness_tb->state->FldCaption()) ?>");

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
fwitness_tbgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "uid", false)) return false;
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
fwitness_tbgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwitness_tbgrid.ValidateRequired = true;
<?php } else { ?>
fwitness_tbgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php if ($witness_tb->getCurrentMasterTable() == "" && $witness_tb_grid->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $witness_tb_grid->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
if ($witness_tb->CurrentAction == "gridadd") {
	if ($witness_tb->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$witness_tb_grid->TotalRecs = $witness_tb->SelectRecordCount();
			$witness_tb_grid->Recordset = $witness_tb_grid->LoadRecordset($witness_tb_grid->StartRec-1, $witness_tb_grid->DisplayRecs);
		} else {
			if ($witness_tb_grid->Recordset = $witness_tb_grid->LoadRecordset())
				$witness_tb_grid->TotalRecs = $witness_tb_grid->Recordset->RecordCount();
		}
		$witness_tb_grid->StartRec = 1;
		$witness_tb_grid->DisplayRecs = $witness_tb_grid->TotalRecs;
	} else {
		$witness_tb->CurrentFilter = "0=1";
		$witness_tb_grid->StartRec = 1;
		$witness_tb_grid->DisplayRecs = $witness_tb->GridAddRowCount;
	}
	$witness_tb_grid->TotalRecs = $witness_tb_grid->DisplayRecs;
	$witness_tb_grid->StopRec = $witness_tb_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$witness_tb_grid->TotalRecs = $witness_tb->SelectRecordCount();
	} else {
		if ($witness_tb_grid->Recordset = $witness_tb_grid->LoadRecordset())
			$witness_tb_grid->TotalRecs = $witness_tb_grid->Recordset->RecordCount();
	}
	$witness_tb_grid->StartRec = 1;
	$witness_tb_grid->DisplayRecs = $witness_tb_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$witness_tb_grid->Recordset = $witness_tb_grid->LoadRecordset($witness_tb_grid->StartRec-1, $witness_tb_grid->DisplayRecs);
}
$witness_tb_grid->RenderOtherOptions();
?>
<?php $witness_tb_grid->ShowPageHeader(); ?>
<?php
$witness_tb_grid->ShowMessage();
?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fwitness_tbgrid" class="ewForm form-horizontal">
<div id="gmp_witness_tb" class="ewGridMiddlePanel">
<table id="tbl_witness_tbgrid" class="ewTable ewTableSeparate">
<?php echo $witness_tb->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$witness_tb_grid->RenderListOptions();

// Render list options (header, left)
$witness_tb_grid->ListOptions->Render("header", "left");
?>
<?php if ($witness_tb->id->Visible) { // id ?>
	<?php if ($witness_tb->SortUrl($witness_tb->id) == "") { ?>
		<td><div id="elh_witness_tb_id" class="witness_tb_id"><div class="ewTableHeaderCaption"><?php echo $witness_tb->id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_id" class="witness_tb_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->uid->Visible) { // uid ?>
	<?php if ($witness_tb->SortUrl($witness_tb->uid) == "") { ?>
		<td><div id="elh_witness_tb_uid" class="witness_tb_uid"><div class="ewTableHeaderCaption"><?php echo $witness_tb->uid->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_uid" class="witness_tb_uid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->uid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->uid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->uid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->title->Visible) { // title ?>
	<?php if ($witness_tb->SortUrl($witness_tb->title) == "") { ?>
		<td><div id="elh_witness_tb_title" class="witness_tb_title"><div class="ewTableHeaderCaption"><?php echo $witness_tb->title->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_title" class="witness_tb_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->fullname->Visible) { // fullname ?>
	<?php if ($witness_tb->SortUrl($witness_tb->fullname) == "") { ?>
		<td><div id="elh_witness_tb_fullname" class="witness_tb_fullname"><div class="ewTableHeaderCaption"><?php echo $witness_tb->fullname->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_fullname" class="witness_tb_fullname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->fullname->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->fullname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->fullname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->rtionship->Visible) { // rtionship ?>
	<?php if ($witness_tb->SortUrl($witness_tb->rtionship) == "") { ?>
		<td><div id="elh_witness_tb_rtionship" class="witness_tb_rtionship"><div class="ewTableHeaderCaption"><?php echo $witness_tb->rtionship->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_rtionship" class="witness_tb_rtionship">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->rtionship->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->rtionship->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->rtionship->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->_email->Visible) { // email ?>
	<?php if ($witness_tb->SortUrl($witness_tb->_email) == "") { ?>
		<td><div id="elh_witness_tb__email" class="witness_tb__email"><div class="ewTableHeaderCaption"><?php echo $witness_tb->_email->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb__email" class="witness_tb__email">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->_email->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->_email->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->_email->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->phone->Visible) { // phone ?>
	<?php if ($witness_tb->SortUrl($witness_tb->phone) == "") { ?>
		<td><div id="elh_witness_tb_phone" class="witness_tb_phone"><div class="ewTableHeaderCaption"><?php echo $witness_tb->phone->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_phone" class="witness_tb_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->phone->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->city->Visible) { // city ?>
	<?php if ($witness_tb->SortUrl($witness_tb->city) == "") { ?>
		<td><div id="elh_witness_tb_city" class="witness_tb_city"><div class="ewTableHeaderCaption"><?php echo $witness_tb->city->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_city" class="witness_tb_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->city->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->city->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->city->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->state->Visible) { // state ?>
	<?php if ($witness_tb->SortUrl($witness_tb->state) == "") { ?>
		<td><div id="elh_witness_tb_state" class="witness_tb_state"><div class="ewTableHeaderCaption"><?php echo $witness_tb->state->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_state" class="witness_tb_state">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->state->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->state->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->state->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($witness_tb->datecreated->Visible) { // datecreated ?>
	<?php if ($witness_tb->SortUrl($witness_tb->datecreated) == "") { ?>
		<td><div id="elh_witness_tb_datecreated" class="witness_tb_datecreated"><div class="ewTableHeaderCaption"><?php echo $witness_tb->datecreated->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div><div id="elh_witness_tb_datecreated" class="witness_tb_datecreated">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $witness_tb->datecreated->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($witness_tb->datecreated->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($witness_tb->datecreated->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$witness_tb_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$witness_tb_grid->StartRec = 1;
$witness_tb_grid->StopRec = $witness_tb_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($witness_tb_grid->FormKeyCountName) && ($witness_tb->CurrentAction == "gridadd" || $witness_tb->CurrentAction == "gridedit" || $witness_tb->CurrentAction == "F")) {
		$witness_tb_grid->KeyCount = $objForm->GetValue($witness_tb_grid->FormKeyCountName);
		$witness_tb_grid->StopRec = $witness_tb_grid->StartRec + $witness_tb_grid->KeyCount - 1;
	}
}
$witness_tb_grid->RecCnt = $witness_tb_grid->StartRec - 1;
if ($witness_tb_grid->Recordset && !$witness_tb_grid->Recordset->EOF) {
	$witness_tb_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $witness_tb_grid->StartRec > 1)
		$witness_tb_grid->Recordset->Move($witness_tb_grid->StartRec - 1);
} elseif (!$witness_tb->AllowAddDeleteRow && $witness_tb_grid->StopRec == 0) {
	$witness_tb_grid->StopRec = $witness_tb->GridAddRowCount;
}

// Initialize aggregate
$witness_tb->RowType = EW_ROWTYPE_AGGREGATEINIT;
$witness_tb->ResetAttrs();
$witness_tb_grid->RenderRow();
if ($witness_tb->CurrentAction == "gridadd")
	$witness_tb_grid->RowIndex = 0;
if ($witness_tb->CurrentAction == "gridedit")
	$witness_tb_grid->RowIndex = 0;
while ($witness_tb_grid->RecCnt < $witness_tb_grid->StopRec) {
	$witness_tb_grid->RecCnt++;
	if (intval($witness_tb_grid->RecCnt) >= intval($witness_tb_grid->StartRec)) {
		$witness_tb_grid->RowCnt++;
		if ($witness_tb->CurrentAction == "gridadd" || $witness_tb->CurrentAction == "gridedit" || $witness_tb->CurrentAction == "F") {
			$witness_tb_grid->RowIndex++;
			$objForm->Index = $witness_tb_grid->RowIndex;
			if ($objForm->HasValue($witness_tb_grid->FormActionName))
				$witness_tb_grid->RowAction = strval($objForm->GetValue($witness_tb_grid->FormActionName));
			elseif ($witness_tb->CurrentAction == "gridadd")
				$witness_tb_grid->RowAction = "insert";
			else
				$witness_tb_grid->RowAction = "";
		}

		// Set up key count
		$witness_tb_grid->KeyCount = $witness_tb_grid->RowIndex;

		// Init row class and style
		$witness_tb->ResetAttrs();
		$witness_tb->CssClass = "";
		if ($witness_tb->CurrentAction == "gridadd") {
			if ($witness_tb->CurrentMode == "copy") {
				$witness_tb_grid->LoadRowValues($witness_tb_grid->Recordset); // Load row values
				$witness_tb_grid->SetRecordKey($witness_tb_grid->RowOldKey, $witness_tb_grid->Recordset); // Set old record key
			} else {
				$witness_tb_grid->LoadDefaultValues(); // Load default values
				$witness_tb_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$witness_tb_grid->LoadRowValues($witness_tb_grid->Recordset); // Load row values
		}
		$witness_tb->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($witness_tb->CurrentAction == "gridadd") // Grid add
			$witness_tb->RowType = EW_ROWTYPE_ADD; // Render add
		if ($witness_tb->CurrentAction == "gridadd" && $witness_tb->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$witness_tb_grid->RestoreCurrentRowFormValues($witness_tb_grid->RowIndex); // Restore form values
		if ($witness_tb->CurrentAction == "gridedit") { // Grid edit
			if ($witness_tb->EventCancelled) {
				$witness_tb_grid->RestoreCurrentRowFormValues($witness_tb_grid->RowIndex); // Restore form values
			}
			if ($witness_tb_grid->RowAction == "insert")
				$witness_tb->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$witness_tb->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($witness_tb->CurrentAction == "gridedit" && ($witness_tb->RowType == EW_ROWTYPE_EDIT || $witness_tb->RowType == EW_ROWTYPE_ADD) && $witness_tb->EventCancelled) // Update failed
			$witness_tb_grid->RestoreCurrentRowFormValues($witness_tb_grid->RowIndex); // Restore form values
		if ($witness_tb->RowType == EW_ROWTYPE_EDIT) // Edit row
			$witness_tb_grid->EditRowCnt++;
		if ($witness_tb->CurrentAction == "F") // Confirm row
			$witness_tb_grid->RestoreCurrentRowFormValues($witness_tb_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$witness_tb->RowAttrs = array_merge($witness_tb->RowAttrs, array('data-rowindex'=>$witness_tb_grid->RowCnt, 'id'=>'r' . $witness_tb_grid->RowCnt . '_witness_tb', 'data-rowtype'=>$witness_tb->RowType));

		// Render row
		$witness_tb_grid->RenderRow();

		// Render list options
		$witness_tb_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($witness_tb_grid->RowAction <> "delete" && $witness_tb_grid->RowAction <> "insertdelete" && !($witness_tb_grid->RowAction == "insert" && $witness_tb->CurrentAction == "F" && $witness_tb_grid->EmptyRow())) {
?>
	<tr<?php echo $witness_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$witness_tb_grid->ListOptions->Render("body", "left", $witness_tb_grid->RowCnt);
?>
	<?php if ($witness_tb->id->Visible) { // id ?>
		<td<?php echo $witness_tb->id->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_id" name="o<?php echo $witness_tb_grid->RowIndex ?>_id" id="o<?php echo $witness_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($witness_tb->id->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_id" class="control-group witness_tb_id">
<span<?php echo $witness_tb->id->ViewAttributes() ?>>
<?php echo $witness_tb->id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $witness_tb_grid->RowIndex ?>_id" id="x<?php echo $witness_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($witness_tb->id->CurrentValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->id->ViewAttributes() ?>>
<?php echo $witness_tb->id->ListViewValue() ?></span>
<input type="hidden" data-field="x_id" name="x<?php echo $witness_tb_grid->RowIndex ?>_id" id="x<?php echo $witness_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($witness_tb->id->FormValue) ?>">
<input type="hidden" data-field="x_id" name="o<?php echo $witness_tb_grid->RowIndex ?>_id" id="o<?php echo $witness_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($witness_tb->id->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->uid->Visible) { // uid ?>
		<td<?php echo $witness_tb->uid->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($witness_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $witness_tb->uid->ViewAttributes() ?>>
<?php echo $witness_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $witness_tb->uid->PlaceHolder ?>" value="<?php echo $witness_tb->uid->EditValue ?>"<?php echo $witness_tb->uid->EditAttributes() ?>>
<?php } ?>
<input type="hidden" data-field="x_uid" name="o<?php echo $witness_tb_grid->RowIndex ?>_uid" id="o<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($witness_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $witness_tb->uid->ViewAttributes() ?>>
<?php echo $witness_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $witness_tb->uid->PlaceHolder ?>" value="<?php echo $witness_tb->uid->EditValue ?>"<?php echo $witness_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->uid->ViewAttributes() ?>>
<?php echo $witness_tb->uid->ListViewValue() ?></span>
<input type="hidden" data-field="x_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->FormValue) ?>">
<input type="hidden" data-field="x_uid" name="o<?php echo $witness_tb_grid->RowIndex ?>_uid" id="o<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->title->Visible) { // title ?>
		<td<?php echo $witness_tb->title->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_title" class="control-group witness_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $witness_tb_grid->RowIndex ?>_title" id="x<?php echo $witness_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $witness_tb->title->PlaceHolder ?>" value="<?php echo $witness_tb->title->EditValue ?>"<?php echo $witness_tb->title->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_title" name="o<?php echo $witness_tb_grid->RowIndex ?>_title" id="o<?php echo $witness_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($witness_tb->title->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_title" class="control-group witness_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $witness_tb_grid->RowIndex ?>_title" id="x<?php echo $witness_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $witness_tb->title->PlaceHolder ?>" value="<?php echo $witness_tb->title->EditValue ?>"<?php echo $witness_tb->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->title->ViewAttributes() ?>>
<?php echo $witness_tb->title->ListViewValue() ?></span>
<input type="hidden" data-field="x_title" name="x<?php echo $witness_tb_grid->RowIndex ?>_title" id="x<?php echo $witness_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($witness_tb->title->FormValue) ?>">
<input type="hidden" data-field="x_title" name="o<?php echo $witness_tb_grid->RowIndex ?>_title" id="o<?php echo $witness_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($witness_tb->title->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $witness_tb->fullname->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_fullname" class="control-group witness_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $witness_tb->fullname->PlaceHolder ?>" value="<?php echo $witness_tb->fullname->EditValue ?>"<?php echo $witness_tb->fullname->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_fullname" name="o<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="o<?php echo $witness_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($witness_tb->fullname->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_fullname" class="control-group witness_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $witness_tb->fullname->PlaceHolder ?>" value="<?php echo $witness_tb->fullname->EditValue ?>"<?php echo $witness_tb->fullname->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->fullname->ViewAttributes() ?>>
<?php echo $witness_tb->fullname->ListViewValue() ?></span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($witness_tb->fullname->FormValue) ?>">
<input type="hidden" data-field="x_fullname" name="o<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="o<?php echo $witness_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($witness_tb->fullname->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->rtionship->Visible) { // rtionship ?>
		<td<?php echo $witness_tb->rtionship->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_rtionship" class="control-group witness_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $witness_tb->rtionship->PlaceHolder ?>" value="<?php echo $witness_tb->rtionship->EditValue ?>"<?php echo $witness_tb->rtionship->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $witness_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($witness_tb->rtionship->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_rtionship" class="control-group witness_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $witness_tb->rtionship->PlaceHolder ?>" value="<?php echo $witness_tb->rtionship->EditValue ?>"<?php echo $witness_tb->rtionship->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->rtionship->ViewAttributes() ?>>
<?php echo $witness_tb->rtionship->ListViewValue() ?></span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($witness_tb->rtionship->FormValue) ?>">
<input type="hidden" data-field="x_rtionship" name="o<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $witness_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($witness_tb->rtionship->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->_email->Visible) { // email ?>
		<td<?php echo $witness_tb->_email->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb__email" class="control-group witness_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $witness_tb_grid->RowIndex ?>__email" id="x<?php echo $witness_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $witness_tb->_email->PlaceHolder ?>" value="<?php echo $witness_tb->_email->EditValue ?>"<?php echo $witness_tb->_email->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x__email" name="o<?php echo $witness_tb_grid->RowIndex ?>__email" id="o<?php echo $witness_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($witness_tb->_email->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb__email" class="control-group witness_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $witness_tb_grid->RowIndex ?>__email" id="x<?php echo $witness_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $witness_tb->_email->PlaceHolder ?>" value="<?php echo $witness_tb->_email->EditValue ?>"<?php echo $witness_tb->_email->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->_email->ViewAttributes() ?>>
<?php echo $witness_tb->_email->ListViewValue() ?></span>
<input type="hidden" data-field="x__email" name="x<?php echo $witness_tb_grid->RowIndex ?>__email" id="x<?php echo $witness_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($witness_tb->_email->FormValue) ?>">
<input type="hidden" data-field="x__email" name="o<?php echo $witness_tb_grid->RowIndex ?>__email" id="o<?php echo $witness_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($witness_tb->_email->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->phone->Visible) { // phone ?>
		<td<?php echo $witness_tb->phone->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_phone" class="control-group witness_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $witness_tb_grid->RowIndex ?>_phone" id="x<?php echo $witness_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $witness_tb->phone->PlaceHolder ?>" value="<?php echo $witness_tb->phone->EditValue ?>"<?php echo $witness_tb->phone->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_phone" name="o<?php echo $witness_tb_grid->RowIndex ?>_phone" id="o<?php echo $witness_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($witness_tb->phone->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_phone" class="control-group witness_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $witness_tb_grid->RowIndex ?>_phone" id="x<?php echo $witness_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $witness_tb->phone->PlaceHolder ?>" value="<?php echo $witness_tb->phone->EditValue ?>"<?php echo $witness_tb->phone->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->phone->ViewAttributes() ?>>
<?php echo $witness_tb->phone->ListViewValue() ?></span>
<input type="hidden" data-field="x_phone" name="x<?php echo $witness_tb_grid->RowIndex ?>_phone" id="x<?php echo $witness_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($witness_tb->phone->FormValue) ?>">
<input type="hidden" data-field="x_phone" name="o<?php echo $witness_tb_grid->RowIndex ?>_phone" id="o<?php echo $witness_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($witness_tb->phone->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->city->Visible) { // city ?>
		<td<?php echo $witness_tb->city->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_city" class="control-group witness_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $witness_tb_grid->RowIndex ?>_city" id="x<?php echo $witness_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $witness_tb->city->PlaceHolder ?>" value="<?php echo $witness_tb->city->EditValue ?>"<?php echo $witness_tb->city->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_city" name="o<?php echo $witness_tb_grid->RowIndex ?>_city" id="o<?php echo $witness_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($witness_tb->city->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_city" class="control-group witness_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $witness_tb_grid->RowIndex ?>_city" id="x<?php echo $witness_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $witness_tb->city->PlaceHolder ?>" value="<?php echo $witness_tb->city->EditValue ?>"<?php echo $witness_tb->city->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->city->ViewAttributes() ?>>
<?php echo $witness_tb->city->ListViewValue() ?></span>
<input type="hidden" data-field="x_city" name="x<?php echo $witness_tb_grid->RowIndex ?>_city" id="x<?php echo $witness_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($witness_tb->city->FormValue) ?>">
<input type="hidden" data-field="x_city" name="o<?php echo $witness_tb_grid->RowIndex ?>_city" id="o<?php echo $witness_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($witness_tb->city->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->state->Visible) { // state ?>
		<td<?php echo $witness_tb->state->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_state" class="control-group witness_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $witness_tb_grid->RowIndex ?>_state" id="x<?php echo $witness_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $witness_tb->state->PlaceHolder ?>" value="<?php echo $witness_tb->state->EditValue ?>"<?php echo $witness_tb->state->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_state" name="o<?php echo $witness_tb_grid->RowIndex ?>_state" id="o<?php echo $witness_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($witness_tb->state->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_state" class="control-group witness_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $witness_tb_grid->RowIndex ?>_state" id="x<?php echo $witness_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $witness_tb->state->PlaceHolder ?>" value="<?php echo $witness_tb->state->EditValue ?>"<?php echo $witness_tb->state->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->state->ViewAttributes() ?>>
<?php echo $witness_tb->state->ListViewValue() ?></span>
<input type="hidden" data-field="x_state" name="x<?php echo $witness_tb_grid->RowIndex ?>_state" id="x<?php echo $witness_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($witness_tb->state->FormValue) ?>">
<input type="hidden" data-field="x_state" name="o<?php echo $witness_tb_grid->RowIndex ?>_state" id="o<?php echo $witness_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($witness_tb->state->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($witness_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $witness_tb->datecreated->CellAttributes() ?>>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_datecreated" class="control-group witness_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $witness_tb->datecreated->PlaceHolder ?>" value="<?php echo $witness_tb->datecreated->EditValue ?>"<?php echo $witness_tb->datecreated->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $witness_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($witness_tb->datecreated->OldValue) ?>">
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $witness_tb_grid->RowCnt ?>_witness_tb_datecreated" class="control-group witness_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $witness_tb->datecreated->PlaceHolder ?>" value="<?php echo $witness_tb->datecreated->EditValue ?>"<?php echo $witness_tb->datecreated->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($witness_tb->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $witness_tb->datecreated->ViewAttributes() ?>>
<?php echo $witness_tb->datecreated->ListViewValue() ?></span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($witness_tb->datecreated->FormValue) ?>">
<input type="hidden" data-field="x_datecreated" name="o<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $witness_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($witness_tb->datecreated->OldValue) ?>">
<?php } ?>
<a id="<?php echo $witness_tb_grid->PageObjName . "_row_" . $witness_tb_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php

// Render list options (body, right)
$witness_tb_grid->ListOptions->Render("body", "right", $witness_tb_grid->RowCnt);
?>
	</tr>
<?php if ($witness_tb->RowType == EW_ROWTYPE_ADD || $witness_tb->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fwitness_tbgrid.UpdateOpts(<?php echo $witness_tb_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($witness_tb->CurrentAction <> "gridadd" || $witness_tb->CurrentMode == "copy")
		if (!$witness_tb_grid->Recordset->EOF) $witness_tb_grid->Recordset->MoveNext();
}
?>
<?php
	if ($witness_tb->CurrentMode == "add" || $witness_tb->CurrentMode == "copy" || $witness_tb->CurrentMode == "edit") {
		$witness_tb_grid->RowIndex = '$rowindex$';
		$witness_tb_grid->LoadDefaultValues();

		// Set row properties
		$witness_tb->ResetAttrs();
		$witness_tb->RowAttrs = array_merge($witness_tb->RowAttrs, array('data-rowindex'=>$witness_tb_grid->RowIndex, 'id'=>'r0_witness_tb', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($witness_tb->RowAttrs["class"], "ewTemplate");
		$witness_tb->RowType = EW_ROWTYPE_ADD;

		// Render row
		$witness_tb_grid->RenderRow();

		// Render list options
		$witness_tb_grid->RenderListOptions();
		$witness_tb_grid->StartRowCnt = 0;
?>
	<tr<?php echo $witness_tb->RowAttributes() ?>>
<?php

// Render list options (body, left)
$witness_tb_grid->ListOptions->Render("body", "left", $witness_tb_grid->RowIndex);
?>
	<?php if ($witness_tb->id->Visible) { // id ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_id" class="control-group witness_tb_id">
<span<?php echo $witness_tb->id->ViewAttributes() ?>>
<?php echo $witness_tb->id->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_id" name="x<?php echo $witness_tb_grid->RowIndex ?>_id" id="x<?php echo $witness_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($witness_tb->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_id" name="o<?php echo $witness_tb_grid->RowIndex ?>_id" id="o<?php echo $witness_tb_grid->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($witness_tb->id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->uid->Visible) { // uid ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<?php if ($witness_tb->uid->getSessionValue() <> "") { ?>
<span<?php echo $witness_tb->uid->ViewAttributes() ?>>
<?php echo $witness_tb->uid->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->CurrentValue) ?>">
<?php } else { ?>
<input type="text" data-field="x_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" size="30" placeholder="<?php echo $witness_tb->uid->PlaceHolder ?>" value="<?php echo $witness_tb->uid->EditValue ?>"<?php echo $witness_tb->uid->EditAttributes() ?>>
<?php } ?>
<?php } else { ?>
<span<?php echo $witness_tb->uid->ViewAttributes() ?>>
<?php echo $witness_tb->uid->ViewValue ?></span>
<input type="hidden" data-field="x_uid" name="x<?php echo $witness_tb_grid->RowIndex ?>_uid" id="x<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_uid" name="o<?php echo $witness_tb_grid->RowIndex ?>_uid" id="o<?php echo $witness_tb_grid->RowIndex ?>_uid" value="<?php echo ew_HtmlEncode($witness_tb->uid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->title->Visible) { // title ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_title" class="control-group witness_tb_title">
<input type="text" data-field="x_title" name="x<?php echo $witness_tb_grid->RowIndex ?>_title" id="x<?php echo $witness_tb_grid->RowIndex ?>_title" size="30" maxlength="20" placeholder="<?php echo $witness_tb->title->PlaceHolder ?>" value="<?php echo $witness_tb->title->EditValue ?>"<?php echo $witness_tb->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_title" class="control-group witness_tb_title">
<span<?php echo $witness_tb->title->ViewAttributes() ?>>
<?php echo $witness_tb->title->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_title" name="x<?php echo $witness_tb_grid->RowIndex ?>_title" id="x<?php echo $witness_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($witness_tb->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_title" name="o<?php echo $witness_tb_grid->RowIndex ?>_title" id="o<?php echo $witness_tb_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($witness_tb->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->fullname->Visible) { // fullname ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_fullname" class="control-group witness_tb_fullname">
<input type="text" data-field="x_fullname" name="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" size="30" maxlength="50" placeholder="<?php echo $witness_tb->fullname->PlaceHolder ?>" value="<?php echo $witness_tb->fullname->EditValue ?>"<?php echo $witness_tb->fullname->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_fullname" class="control-group witness_tb_fullname">
<span<?php echo $witness_tb->fullname->ViewAttributes() ?>>
<?php echo $witness_tb->fullname->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_fullname" name="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="x<?php echo $witness_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($witness_tb->fullname->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fullname" name="o<?php echo $witness_tb_grid->RowIndex ?>_fullname" id="o<?php echo $witness_tb_grid->RowIndex ?>_fullname" value="<?php echo ew_HtmlEncode($witness_tb->fullname->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->rtionship->Visible) { // rtionship ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_rtionship" class="control-group witness_tb_rtionship">
<input type="text" data-field="x_rtionship" name="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" size="30" maxlength="20" placeholder="<?php echo $witness_tb->rtionship->PlaceHolder ?>" value="<?php echo $witness_tb->rtionship->EditValue ?>"<?php echo $witness_tb->rtionship->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_rtionship" class="control-group witness_tb_rtionship">
<span<?php echo $witness_tb->rtionship->ViewAttributes() ?>>
<?php echo $witness_tb->rtionship->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_rtionship" name="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="x<?php echo $witness_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($witness_tb->rtionship->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_rtionship" name="o<?php echo $witness_tb_grid->RowIndex ?>_rtionship" id="o<?php echo $witness_tb_grid->RowIndex ?>_rtionship" value="<?php echo ew_HtmlEncode($witness_tb->rtionship->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->_email->Visible) { // email ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb__email" class="control-group witness_tb__email">
<input type="text" data-field="x__email" name="x<?php echo $witness_tb_grid->RowIndex ?>__email" id="x<?php echo $witness_tb_grid->RowIndex ?>__email" size="30" maxlength="50" placeholder="<?php echo $witness_tb->_email->PlaceHolder ?>" value="<?php echo $witness_tb->_email->EditValue ?>"<?php echo $witness_tb->_email->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb__email" class="control-group witness_tb__email">
<span<?php echo $witness_tb->_email->ViewAttributes() ?>>
<?php echo $witness_tb->_email->ViewValue ?></span>
</span>
<input type="hidden" data-field="x__email" name="x<?php echo $witness_tb_grid->RowIndex ?>__email" id="x<?php echo $witness_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($witness_tb->_email->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x__email" name="o<?php echo $witness_tb_grid->RowIndex ?>__email" id="o<?php echo $witness_tb_grid->RowIndex ?>__email" value="<?php echo ew_HtmlEncode($witness_tb->_email->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->phone->Visible) { // phone ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_phone" class="control-group witness_tb_phone">
<input type="text" data-field="x_phone" name="x<?php echo $witness_tb_grid->RowIndex ?>_phone" id="x<?php echo $witness_tb_grid->RowIndex ?>_phone" size="30" maxlength="20" placeholder="<?php echo $witness_tb->phone->PlaceHolder ?>" value="<?php echo $witness_tb->phone->EditValue ?>"<?php echo $witness_tb->phone->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_phone" class="control-group witness_tb_phone">
<span<?php echo $witness_tb->phone->ViewAttributes() ?>>
<?php echo $witness_tb->phone->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_phone" name="x<?php echo $witness_tb_grid->RowIndex ?>_phone" id="x<?php echo $witness_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($witness_tb->phone->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_phone" name="o<?php echo $witness_tb_grid->RowIndex ?>_phone" id="o<?php echo $witness_tb_grid->RowIndex ?>_phone" value="<?php echo ew_HtmlEncode($witness_tb->phone->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->city->Visible) { // city ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_city" class="control-group witness_tb_city">
<input type="text" data-field="x_city" name="x<?php echo $witness_tb_grid->RowIndex ?>_city" id="x<?php echo $witness_tb_grid->RowIndex ?>_city" size="30" maxlength="20" placeholder="<?php echo $witness_tb->city->PlaceHolder ?>" value="<?php echo $witness_tb->city->EditValue ?>"<?php echo $witness_tb->city->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_city" class="control-group witness_tb_city">
<span<?php echo $witness_tb->city->ViewAttributes() ?>>
<?php echo $witness_tb->city->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_city" name="x<?php echo $witness_tb_grid->RowIndex ?>_city" id="x<?php echo $witness_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($witness_tb->city->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_city" name="o<?php echo $witness_tb_grid->RowIndex ?>_city" id="o<?php echo $witness_tb_grid->RowIndex ?>_city" value="<?php echo ew_HtmlEncode($witness_tb->city->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->state->Visible) { // state ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_state" class="control-group witness_tb_state">
<input type="text" data-field="x_state" name="x<?php echo $witness_tb_grid->RowIndex ?>_state" id="x<?php echo $witness_tb_grid->RowIndex ?>_state" size="30" maxlength="20" placeholder="<?php echo $witness_tb->state->PlaceHolder ?>" value="<?php echo $witness_tb->state->EditValue ?>"<?php echo $witness_tb->state->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_state" class="control-group witness_tb_state">
<span<?php echo $witness_tb->state->ViewAttributes() ?>>
<?php echo $witness_tb->state->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_state" name="x<?php echo $witness_tb_grid->RowIndex ?>_state" id="x<?php echo $witness_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($witness_tb->state->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_state" name="o<?php echo $witness_tb_grid->RowIndex ?>_state" id="o<?php echo $witness_tb_grid->RowIndex ?>_state" value="<?php echo ew_HtmlEncode($witness_tb->state->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($witness_tb->datecreated->Visible) { // datecreated ?>
		<td>
<?php if ($witness_tb->CurrentAction <> "F") { ?>
<span id="el$rowindex$_witness_tb_datecreated" class="control-group witness_tb_datecreated">
<input type="text" data-field="x_datecreated" name="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" placeholder="<?php echo $witness_tb->datecreated->PlaceHolder ?>" value="<?php echo $witness_tb->datecreated->EditValue ?>"<?php echo $witness_tb->datecreated->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_witness_tb_datecreated" class="control-group witness_tb_datecreated">
<span<?php echo $witness_tb->datecreated->ViewAttributes() ?>>
<?php echo $witness_tb->datecreated->ViewValue ?></span>
</span>
<input type="hidden" data-field="x_datecreated" name="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="x<?php echo $witness_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($witness_tb->datecreated->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_datecreated" name="o<?php echo $witness_tb_grid->RowIndex ?>_datecreated" id="o<?php echo $witness_tb_grid->RowIndex ?>_datecreated" value="<?php echo ew_HtmlEncode($witness_tb->datecreated->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$witness_tb_grid->ListOptions->Render("body", "right", $witness_tb_grid->RowCnt);
?>
<script type="text/javascript">
fwitness_tbgrid.UpdateOpts(<?php echo $witness_tb_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($witness_tb->CurrentMode == "add" || $witness_tb->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $witness_tb_grid->FormKeyCountName ?>" id="<?php echo $witness_tb_grid->FormKeyCountName ?>" value="<?php echo $witness_tb_grid->KeyCount ?>">
<?php echo $witness_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($witness_tb->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $witness_tb_grid->FormKeyCountName ?>" id="<?php echo $witness_tb_grid->FormKeyCountName ?>" value="<?php echo $witness_tb_grid->KeyCount ?>">
<?php echo $witness_tb_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($witness_tb->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fwitness_tbgrid">
</div>
<?php

// Close recordset
if ($witness_tb_grid->Recordset)
	$witness_tb_grid->Recordset->Close();
?>
<?php if ($witness_tb_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel ewListOtherOptions">
<?php
	foreach ($witness_tb_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<?php } ?>
</div>
</td></tr></table>
<?php if ($witness_tb->Export == "") { ?>
<script type="text/javascript">
fwitness_tbgrid.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php } ?>
<?php
$witness_tb_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$witness_tb_grid->Page_Terminate();
?>
