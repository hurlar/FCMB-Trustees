<?php

// Global variable for table object
$will_tb = NULL;

//
// Table class for will_tb
//
class cwill_tb extends cTable {
	var $id;
	var $name;
	var $pdflink;
	var $url_link;
	var $rating_order;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'will_tb';
		$this->TableName = 'will_tb';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('will_tb', 'will_tb', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// name
		$this->name = new cField('will_tb', 'will_tb', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['name'] = &$this->name;

		// pdflink
		$this->pdflink = new cField('will_tb', 'will_tb', 'x_pdflink', 'pdflink', '`pdflink`', '`pdflink`', 200, -1, TRUE, '`pdflink`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pdflink'] = &$this->pdflink;

		// url_link
		$this->url_link = new cField('will_tb', 'will_tb', 'x_url_link', 'url_link', '`url_link`', '`url_link`', 200, -1, FALSE, '`url_link`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['url_link'] = &$this->url_link;

		// rating_order
		$this->rating_order = new cField('will_tb', 'will_tb', 'x_rating_order', 'rating_order', '`rating_order`', '`rating_order`', 202, -1, FALSE, '`rating_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rating_order'] = &$this->rating_order;
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`will_tb`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`will_tb`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL) {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id') . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType));
		}
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "will_tblist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "will_tblist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("will_tbview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("will_tbview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "will_tbadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("will_tbedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("will_tbadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("will_tbdelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["id"]; // id

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id->setDbValue($rs->fields('id'));
		$this->name->setDbValue($rs->fields('name'));
		$this->pdflink->Upload->DbValue = $rs->fields('pdflink');
		$this->url_link->setDbValue($rs->fields('url_link'));
		$this->rating_order->setDbValue($rs->fields('rating_order'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// name
		// pdflink
		// url_link
		// rating_order
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// pdflink
		$this->pdflink->UploadPath = "uploads/forms";
		if (!ew_Empty($this->pdflink->Upload->DbValue)) {
			$this->pdflink->ViewValue = $this->pdflink->Upload->DbValue;
		} else {
			$this->pdflink->ViewValue = "";
		}
		$this->pdflink->ViewCustomAttributes = "";

		// url_link
		$this->url_link->ViewValue = $this->url_link->CurrentValue;
		$this->url_link->ViewCustomAttributes = "";

		// rating_order
		if (strval($this->rating_order->CurrentValue) <> "") {
			switch ($this->rating_order->CurrentValue) {
				case $this->rating_order->FldTagValue(1):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(1) <> "" ? $this->rating_order->FldTagCaption(1) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(2):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(2) <> "" ? $this->rating_order->FldTagCaption(2) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(3):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(3) <> "" ? $this->rating_order->FldTagCaption(3) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(4):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(4) <> "" ? $this->rating_order->FldTagCaption(4) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(5):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(5) <> "" ? $this->rating_order->FldTagCaption(5) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(6):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(6) <> "" ? $this->rating_order->FldTagCaption(6) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(7):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(7) <> "" ? $this->rating_order->FldTagCaption(7) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(8):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(8) <> "" ? $this->rating_order->FldTagCaption(8) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(9):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(9) <> "" ? $this->rating_order->FldTagCaption(9) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(10):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(10) <> "" ? $this->rating_order->FldTagCaption(10) : $this->rating_order->CurrentValue;
					break;
				case $this->rating_order->FldTagValue(11):
					$this->rating_order->ViewValue = $this->rating_order->FldTagCaption(11) <> "" ? $this->rating_order->FldTagCaption(11) : $this->rating_order->CurrentValue;
					break;
				default:
					$this->rating_order->ViewValue = $this->rating_order->CurrentValue;
			}
		} else {
			$this->rating_order->ViewValue = NULL;
		}
		$this->rating_order->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// pdflink
		$this->pdflink->LinkCustomAttributes = "";
		$this->pdflink->UploadPath = "uploads/forms";
		if (!ew_Empty($this->pdflink->Upload->DbValue)) {
			$this->pdflink->HrefValue = ew_UploadPathEx(FALSE, $this->pdflink->UploadPath) . $this->pdflink->Upload->DbValue; // Add prefix/suffix
			$this->pdflink->LinkAttrs["target"] = "_blank"; // Add target
			if ($this->Export <> "") $this->pdflink->HrefValue = ew_ConvertFullUrl($this->pdflink->HrefValue);
		} else {
			$this->pdflink->HrefValue = "";
		}
		$this->pdflink->HrefValue2 = $this->pdflink->UploadPath . $this->pdflink->Upload->DbValue;
		$this->pdflink->TooltipValue = "";

		// url_link
		$this->url_link->LinkCustomAttributes = "";
		$this->url_link->HrefValue = "";
		$this->url_link->TooltipValue = "";

		// rating_order
		$this->rating_order->LinkCustomAttributes = "";
		$this->pdflink->UploadPath = "uploads/forms";
		if (!ew_Empty($this->pdflink->Upload->DbValue)) {
			$this->rating_order->HrefValue = ew_UploadPathEx(FALSE, $this->pdflink->UploadPath) . $this->pdflink->Upload->DbValue; // Add prefix/suffix
			$this->rating_order->LinkAttrs["target"] = ""; // Add target
			if ($this->Export <> "") $this->rating_order->HrefValue = ew_ConvertFullUrl($this->rating_order->HrefValue);
		} else {
			$this->rating_order->HrefValue = "";
		}
		$this->rating_order->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->name->Exportable) $Doc->ExportCaption($this->name);
				if ($this->pdflink->Exportable) $Doc->ExportCaption($this->pdflink);
				if ($this->url_link->Exportable) $Doc->ExportCaption($this->url_link);
				if ($this->rating_order->Exportable) $Doc->ExportCaption($this->rating_order);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->name->Exportable) $Doc->ExportCaption($this->name);
				if ($this->pdflink->Exportable) $Doc->ExportCaption($this->pdflink);
				if ($this->url_link->Exportable) $Doc->ExportCaption($this->url_link);
				if ($this->rating_order->Exportable) $Doc->ExportCaption($this->rating_order);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->name->Exportable) $Doc->ExportField($this->name);
					if ($this->pdflink->Exportable) $Doc->ExportField($this->pdflink);
					if ($this->url_link->Exportable) $Doc->ExportField($this->url_link);
					if ($this->rating_order->Exportable) $Doc->ExportField($this->rating_order);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->name->Exportable) $Doc->ExportField($this->name);
					if ($this->pdflink->Exportable) $Doc->ExportField($this->pdflink);
					if ($this->url_link->Exportable) $Doc->ExportField($this->url_link);
					if ($this->rating_order->Exportable) $Doc->ExportField($this->rating_order);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>