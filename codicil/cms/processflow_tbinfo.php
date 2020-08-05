<?php

// Global variable for table object
$processflow_tb = NULL;

//
// Table class for processflow_tb
//
class cprocessflow_tb extends cTable {
	var $id;
	var $uid;
	var $name;
	var $_email;
	var $stage;
	var $progress;
	var $stage2;
	var $progress2;
	var $stage3;
	var $progress3;
	var $stage4;
	var $progress4;
	var $stage5;
	var $progress5;
	var $stage6;
	var $progress6;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'processflow_tb';
		$this->TableName = 'processflow_tb';
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
		$this->id = new cField('processflow_tb', 'processflow_tb', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// uid
		$this->uid = new cField('processflow_tb', 'processflow_tb', 'x_uid', 'uid', '`uid`', '`uid`', 3, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// name
		$this->name = new cField('processflow_tb', 'processflow_tb', 'x_name', 'name', '`name`', '`name`', 200, -1, FALSE, '`name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['name'] = &$this->name;

		// email
		$this->_email = new cField('processflow_tb', 'processflow_tb', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['email'] = &$this->_email;

		// stage
		$this->stage = new cField('processflow_tb', 'processflow_tb', 'x_stage', 'stage', '`stage`', '`stage`', 200, -1, FALSE, '`stage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['stage'] = &$this->stage;

		// progress
		$this->progress = new cField('processflow_tb', 'processflow_tb', 'x_progress', 'progress', '`progress`', '`progress`', 202, -1, FALSE, '`progress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['progress'] = &$this->progress;

		// stage2
		$this->stage2 = new cField('processflow_tb', 'processflow_tb', 'x_stage2', 'stage2', '`stage2`', '`stage2`', 200, -1, FALSE, '`stage2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['stage2'] = &$this->stage2;

		// progress2
		$this->progress2 = new cField('processflow_tb', 'processflow_tb', 'x_progress2', 'progress2', '`progress2`', '`progress2`', 202, -1, FALSE, '`progress2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['progress2'] = &$this->progress2;

		// stage3
		$this->stage3 = new cField('processflow_tb', 'processflow_tb', 'x_stage3', 'stage3', '`stage3`', '`stage3`', 200, -1, FALSE, '`stage3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['stage3'] = &$this->stage3;

		// progress3
		$this->progress3 = new cField('processflow_tb', 'processflow_tb', 'x_progress3', 'progress3', '`progress3`', '`progress3`', 202, -1, FALSE, '`progress3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['progress3'] = &$this->progress3;

		// stage4
		$this->stage4 = new cField('processflow_tb', 'processflow_tb', 'x_stage4', 'stage4', '`stage4`', '`stage4`', 200, -1, FALSE, '`stage4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['stage4'] = &$this->stage4;

		// progress4
		$this->progress4 = new cField('processflow_tb', 'processflow_tb', 'x_progress4', 'progress4', '`progress4`', '`progress4`', 202, -1, FALSE, '`progress4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['progress4'] = &$this->progress4;

		// stage5
		$this->stage5 = new cField('processflow_tb', 'processflow_tb', 'x_stage5', 'stage5', '`stage5`', '`stage5`', 200, -1, FALSE, '`stage5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['stage5'] = &$this->stage5;

		// progress5
		$this->progress5 = new cField('processflow_tb', 'processflow_tb', 'x_progress5', 'progress5', '`progress5`', '`progress5`', 202, -1, FALSE, '`progress5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['progress5'] = &$this->progress5;

		// stage6
		$this->stage6 = new cField('processflow_tb', 'processflow_tb', 'x_stage6', 'stage6', '`stage6`', '`stage6`', 200, -1, FALSE, '`stage6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['stage6'] = &$this->stage6;

		// progress6
		$this->progress6 = new cField('processflow_tb', 'processflow_tb', 'x_progress6', 'progress6', '`progress6`', '`progress6`', 202, -1, FALSE, '`progress6`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['progress6'] = &$this->progress6;
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
		return "`processflow_tb`";
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
	var $UpdateTable = "`processflow_tb`";

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
			return "processflow_tblist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "processflow_tblist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("processflow_tbview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("processflow_tbview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "processflow_tbadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("processflow_tbedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("processflow_tbadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("processflow_tbdelete.php", $this->UrlParm());
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
		$this->uid->setDbValue($rs->fields('uid'));
		$this->name->setDbValue($rs->fields('name'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->stage->setDbValue($rs->fields('stage'));
		$this->progress->setDbValue($rs->fields('progress'));
		$this->stage2->setDbValue($rs->fields('stage2'));
		$this->progress2->setDbValue($rs->fields('progress2'));
		$this->stage3->setDbValue($rs->fields('stage3'));
		$this->progress3->setDbValue($rs->fields('progress3'));
		$this->stage4->setDbValue($rs->fields('stage4'));
		$this->progress4->setDbValue($rs->fields('progress4'));
		$this->stage5->setDbValue($rs->fields('stage5'));
		$this->progress5->setDbValue($rs->fields('progress5'));
		$this->stage6->setDbValue($rs->fields('stage6'));
		$this->progress6->setDbValue($rs->fields('progress6'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// uid

		$this->uid->CellCssStyle = "white-space: nowrap;";

		// name
		// email
		// stage

		$this->stage->CellCssStyle = "white-space: nowrap;";

		// progress
		// stage2

		$this->stage2->CellCssStyle = "white-space: nowrap;";

		// progress2
		// stage3

		$this->stage3->CellCssStyle = "white-space: nowrap;";

		// progress3
		// stage4

		$this->stage4->CellCssStyle = "white-space: nowrap;";

		// progress4
		// stage5

		$this->stage5->CellCssStyle = "white-space: nowrap;";

		// progress5
		// stage6

		$this->stage6->CellCssStyle = "white-space: nowrap;";

		// progress6
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// stage
		$this->stage->ViewValue = $this->stage->CurrentValue;
		$this->stage->ViewCustomAttributes = "";

		// progress
		if (strval($this->progress->CurrentValue) <> "") {
			switch ($this->progress->CurrentValue) {
				case $this->progress->FldTagValue(1):
					$this->progress->ViewValue = $this->progress->FldTagCaption(1) <> "" ? $this->progress->FldTagCaption(1) : $this->progress->CurrentValue;
					break;
				case $this->progress->FldTagValue(2):
					$this->progress->ViewValue = $this->progress->FldTagCaption(2) <> "" ? $this->progress->FldTagCaption(2) : $this->progress->CurrentValue;
					break;
				case $this->progress->FldTagValue(3):
					$this->progress->ViewValue = $this->progress->FldTagCaption(3) <> "" ? $this->progress->FldTagCaption(3) : $this->progress->CurrentValue;
					break;
				default:
					$this->progress->ViewValue = $this->progress->CurrentValue;
			}
		} else {
			$this->progress->ViewValue = NULL;
		}
		$this->progress->ViewCustomAttributes = "";

		// stage2
		$this->stage2->ViewValue = $this->stage2->CurrentValue;
		$this->stage2->ViewCustomAttributes = "";

		// progress2
		if (strval($this->progress2->CurrentValue) <> "") {
			switch ($this->progress2->CurrentValue) {
				case $this->progress2->FldTagValue(1):
					$this->progress2->ViewValue = $this->progress2->FldTagCaption(1) <> "" ? $this->progress2->FldTagCaption(1) : $this->progress2->CurrentValue;
					break;
				case $this->progress2->FldTagValue(2):
					$this->progress2->ViewValue = $this->progress2->FldTagCaption(2) <> "" ? $this->progress2->FldTagCaption(2) : $this->progress2->CurrentValue;
					break;
				case $this->progress2->FldTagValue(3):
					$this->progress2->ViewValue = $this->progress2->FldTagCaption(3) <> "" ? $this->progress2->FldTagCaption(3) : $this->progress2->CurrentValue;
					break;
				default:
					$this->progress2->ViewValue = $this->progress2->CurrentValue;
			}
		} else {
			$this->progress2->ViewValue = NULL;
		}
		$this->progress2->ViewCustomAttributes = "";

		// stage3
		$this->stage3->ViewValue = $this->stage3->CurrentValue;
		$this->stage3->ViewCustomAttributes = "";

		// progress3
		if (strval($this->progress3->CurrentValue) <> "") {
			switch ($this->progress3->CurrentValue) {
				case $this->progress3->FldTagValue(1):
					$this->progress3->ViewValue = $this->progress3->FldTagCaption(1) <> "" ? $this->progress3->FldTagCaption(1) : $this->progress3->CurrentValue;
					break;
				case $this->progress3->FldTagValue(2):
					$this->progress3->ViewValue = $this->progress3->FldTagCaption(2) <> "" ? $this->progress3->FldTagCaption(2) : $this->progress3->CurrentValue;
					break;
				case $this->progress3->FldTagValue(3):
					$this->progress3->ViewValue = $this->progress3->FldTagCaption(3) <> "" ? $this->progress3->FldTagCaption(3) : $this->progress3->CurrentValue;
					break;
				default:
					$this->progress3->ViewValue = $this->progress3->CurrentValue;
			}
		} else {
			$this->progress3->ViewValue = NULL;
		}
		$this->progress3->ViewCustomAttributes = "";

		// stage4
		$this->stage4->ViewValue = $this->stage4->CurrentValue;
		$this->stage4->ViewCustomAttributes = "";

		// progress4
		if (strval($this->progress4->CurrentValue) <> "") {
			switch ($this->progress4->CurrentValue) {
				case $this->progress4->FldTagValue(1):
					$this->progress4->ViewValue = $this->progress4->FldTagCaption(1) <> "" ? $this->progress4->FldTagCaption(1) : $this->progress4->CurrentValue;
					break;
				case $this->progress4->FldTagValue(2):
					$this->progress4->ViewValue = $this->progress4->FldTagCaption(2) <> "" ? $this->progress4->FldTagCaption(2) : $this->progress4->CurrentValue;
					break;
				case $this->progress4->FldTagValue(3):
					$this->progress4->ViewValue = $this->progress4->FldTagCaption(3) <> "" ? $this->progress4->FldTagCaption(3) : $this->progress4->CurrentValue;
					break;
				default:
					$this->progress4->ViewValue = $this->progress4->CurrentValue;
			}
		} else {
			$this->progress4->ViewValue = NULL;
		}
		$this->progress4->ViewCustomAttributes = "";

		// stage5
		$this->stage5->ViewValue = $this->stage5->CurrentValue;
		$this->stage5->ViewCustomAttributes = "";

		// progress5
		if (strval($this->progress5->CurrentValue) <> "") {
			switch ($this->progress5->CurrentValue) {
				case $this->progress5->FldTagValue(1):
					$this->progress5->ViewValue = $this->progress5->FldTagCaption(1) <> "" ? $this->progress5->FldTagCaption(1) : $this->progress5->CurrentValue;
					break;
				case $this->progress5->FldTagValue(2):
					$this->progress5->ViewValue = $this->progress5->FldTagCaption(2) <> "" ? $this->progress5->FldTagCaption(2) : $this->progress5->CurrentValue;
					break;
				case $this->progress5->FldTagValue(3):
					$this->progress5->ViewValue = $this->progress5->FldTagCaption(3) <> "" ? $this->progress5->FldTagCaption(3) : $this->progress5->CurrentValue;
					break;
				default:
					$this->progress5->ViewValue = $this->progress5->CurrentValue;
			}
		} else {
			$this->progress5->ViewValue = NULL;
		}
		$this->progress5->ViewCustomAttributes = "";

		// stage6
		$this->stage6->ViewValue = $this->stage6->CurrentValue;
		$this->stage6->ViewCustomAttributes = "";

		// progress6
		if (strval($this->progress6->CurrentValue) <> "") {
			switch ($this->progress6->CurrentValue) {
				case $this->progress6->FldTagValue(1):
					$this->progress6->ViewValue = $this->progress6->FldTagCaption(1) <> "" ? $this->progress6->FldTagCaption(1) : $this->progress6->CurrentValue;
					break;
				case $this->progress6->FldTagValue(2):
					$this->progress6->ViewValue = $this->progress6->FldTagCaption(2) <> "" ? $this->progress6->FldTagCaption(2) : $this->progress6->CurrentValue;
					break;
				case $this->progress6->FldTagValue(3):
					$this->progress6->ViewValue = $this->progress6->FldTagCaption(3) <> "" ? $this->progress6->FldTagCaption(3) : $this->progress6->CurrentValue;
					break;
				default:
					$this->progress6->ViewValue = $this->progress6->CurrentValue;
			}
		} else {
			$this->progress6->ViewValue = NULL;
		}
		$this->progress6->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// name
		$this->name->LinkCustomAttributes = "";
		$this->name->HrefValue = "";
		$this->name->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// stage
		$this->stage->LinkCustomAttributes = "";
		$this->stage->HrefValue = "";
		$this->stage->TooltipValue = "";

		// progress
		$this->progress->LinkCustomAttributes = "";
		$this->progress->HrefValue = "";
		$this->progress->TooltipValue = "";

		// stage2
		$this->stage2->LinkCustomAttributes = "";
		$this->stage2->HrefValue = "";
		$this->stage2->TooltipValue = "";

		// progress2
		$this->progress2->LinkCustomAttributes = "";
		$this->progress2->HrefValue = "";
		$this->progress2->TooltipValue = "";

		// stage3
		$this->stage3->LinkCustomAttributes = "";
		$this->stage3->HrefValue = "";
		$this->stage3->TooltipValue = "";

		// progress3
		$this->progress3->LinkCustomAttributes = "";
		$this->progress3->HrefValue = "";
		$this->progress3->TooltipValue = "";

		// stage4
		$this->stage4->LinkCustomAttributes = "";
		$this->stage4->HrefValue = "";
		$this->stage4->TooltipValue = "";

		// progress4
		$this->progress4->LinkCustomAttributes = "";
		$this->progress4->HrefValue = "";
		$this->progress4->TooltipValue = "";

		// stage5
		$this->stage5->LinkCustomAttributes = "";
		$this->stage5->HrefValue = "";
		$this->stage5->TooltipValue = "";

		// progress5
		$this->progress5->LinkCustomAttributes = "";
		$this->progress5->HrefValue = "";
		$this->progress5->TooltipValue = "";

		// stage6
		$this->stage6->LinkCustomAttributes = "";
		$this->stage6->HrefValue = "";
		$this->stage6->TooltipValue = "";

		// progress6
		$this->progress6->LinkCustomAttributes = "";
		$this->progress6->HrefValue = "";
		$this->progress6->TooltipValue = "";

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
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->progress->Exportable) $Doc->ExportCaption($this->progress);
				if ($this->progress2->Exportable) $Doc->ExportCaption($this->progress2);
				if ($this->progress3->Exportable) $Doc->ExportCaption($this->progress3);
				if ($this->progress4->Exportable) $Doc->ExportCaption($this->progress4);
				if ($this->progress5->Exportable) $Doc->ExportCaption($this->progress5);
				if ($this->progress6->Exportable) $Doc->ExportCaption($this->progress6);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->name->Exportable) $Doc->ExportCaption($this->name);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->progress->Exportable) $Doc->ExportCaption($this->progress);
				if ($this->progress2->Exportable) $Doc->ExportCaption($this->progress2);
				if ($this->progress3->Exportable) $Doc->ExportCaption($this->progress3);
				if ($this->progress4->Exportable) $Doc->ExportCaption($this->progress4);
				if ($this->progress5->Exportable) $Doc->ExportCaption($this->progress5);
				if ($this->progress6->Exportable) $Doc->ExportCaption($this->progress6);
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
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->progress->Exportable) $Doc->ExportField($this->progress);
					if ($this->progress2->Exportable) $Doc->ExportField($this->progress2);
					if ($this->progress3->Exportable) $Doc->ExportField($this->progress3);
					if ($this->progress4->Exportable) $Doc->ExportField($this->progress4);
					if ($this->progress5->Exportable) $Doc->ExportField($this->progress5);
					if ($this->progress6->Exportable) $Doc->ExportField($this->progress6);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->name->Exportable) $Doc->ExportField($this->name);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->progress->Exportable) $Doc->ExportField($this->progress);
					if ($this->progress2->Exportable) $Doc->ExportField($this->progress2);
					if ($this->progress3->Exportable) $Doc->ExportField($this->progress3);
					if ($this->progress4->Exportable) $Doc->ExportField($this->progress4);
					if ($this->progress5->Exportable) $Doc->ExportField($this->progress5);
					if ($this->progress6->Exportable) $Doc->ExportField($this->progress6);
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
