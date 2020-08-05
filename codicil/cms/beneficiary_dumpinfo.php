<?php

// Global variable for table object
$beneficiary_dump = NULL;

//
// Table class for beneficiary_dump
//
class cbeneficiary_dump extends cTable {
	var $id;
	var $uid;
	var $childid;
	var $title;
	var $fullname;
	var $rtionship;
	var $_email;
	var $phone;
	var $addr;
	var $city;
	var $state;
	var $percentage;
	var $percentage1;
	var $percentage2;
	var $percentage3;
	var $datecreated;
	var $passport;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'beneficiary_dump';
		$this->TableName = 'beneficiary_dump';
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
		$this->id = new cField('beneficiary_dump', 'beneficiary_dump', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// uid
		$this->uid = new cField('beneficiary_dump', 'beneficiary_dump', 'x_uid', 'uid', '`uid`', '`uid`', 3, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// childid
		$this->childid = new cField('beneficiary_dump', 'beneficiary_dump', 'x_childid', 'childid', '`childid`', '`childid`', 200, -1, FALSE, '`childid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['childid'] = &$this->childid;

		// title
		$this->title = new cField('beneficiary_dump', 'beneficiary_dump', 'x_title', 'title', '`title`', '`title`', 200, -1, FALSE, '`title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['title'] = &$this->title;

		// fullname
		$this->fullname = new cField('beneficiary_dump', 'beneficiary_dump', 'x_fullname', 'fullname', '`fullname`', '`fullname`', 200, -1, FALSE, '`fullname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fullname'] = &$this->fullname;

		// rtionship
		$this->rtionship = new cField('beneficiary_dump', 'beneficiary_dump', 'x_rtionship', 'rtionship', '`rtionship`', '`rtionship`', 200, -1, FALSE, '`rtionship`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rtionship'] = &$this->rtionship;

		// email
		$this->_email = new cField('beneficiary_dump', 'beneficiary_dump', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['email'] = &$this->_email;

		// phone
		$this->phone = new cField('beneficiary_dump', 'beneficiary_dump', 'x_phone', 'phone', '`phone`', '`phone`', 200, -1, FALSE, '`phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['phone'] = &$this->phone;

		// addr
		$this->addr = new cField('beneficiary_dump', 'beneficiary_dump', 'x_addr', 'addr', '`addr`', '`addr`', 201, -1, FALSE, '`addr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['addr'] = &$this->addr;

		// city
		$this->city = new cField('beneficiary_dump', 'beneficiary_dump', 'x_city', 'city', '`city`', '`city`', 200, -1, FALSE, '`city`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['city'] = &$this->city;

		// state
		$this->state = new cField('beneficiary_dump', 'beneficiary_dump', 'x_state', 'state', '`state`', '`state`', 200, -1, FALSE, '`state`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['state'] = &$this->state;

		// percentage
		$this->percentage = new cField('beneficiary_dump', 'beneficiary_dump', 'x_percentage', 'percentage', '`percentage`', '`percentage`', 200, -1, FALSE, '`percentage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['percentage'] = &$this->percentage;

		// percentage1
		$this->percentage1 = new cField('beneficiary_dump', 'beneficiary_dump', 'x_percentage1', 'percentage1', '`percentage1`', '`percentage1`', 200, -1, FALSE, '`percentage1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['percentage1'] = &$this->percentage1;

		// percentage2
		$this->percentage2 = new cField('beneficiary_dump', 'beneficiary_dump', 'x_percentage2', 'percentage2', '`percentage2`', '`percentage2`', 200, -1, FALSE, '`percentage2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['percentage2'] = &$this->percentage2;

		// percentage3
		$this->percentage3 = new cField('beneficiary_dump', 'beneficiary_dump', 'x_percentage3', 'percentage3', '`percentage3`', '`percentage3`', 200, -1, FALSE, '`percentage3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['percentage3'] = &$this->percentage3;

		// datecreated
		$this->datecreated = new cField('beneficiary_dump', 'beneficiary_dump', 'x_datecreated', 'datecreated', '`datecreated`', 'DATE_FORMAT(`datecreated`, \'%d/%m/%y\')', 135, -1, FALSE, '`datecreated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['datecreated'] = &$this->datecreated;

		// passport
		$this->passport = new cField('beneficiary_dump', 'beneficiary_dump', 'x_passport', 'passport', '`passport`', '`passport`', 200, -1, FALSE, '`passport`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['passport'] = &$this->passport;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "children_details") {
			if ($this->uid->getSessionValue() <> "")
				$sMasterFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "comprehensivewill_tb") {
			if ($this->uid->getSessionValue() <> "")
				$sMasterFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "premiumwill_tb") {
			if ($this->uid->getSessionValue() <> "")
				$sMasterFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "personal_info") {
			if ($this->uid->getSessionValue() <> "")
				$sMasterFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "privatetrust_tb") {
			if ($this->uid->getSessionValue() <> "")
				$sMasterFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "children_details") {
			if ($this->uid->getSessionValue() <> "")
				$sDetailFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "comprehensivewill_tb") {
			if ($this->uid->getSessionValue() <> "")
				$sDetailFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "premiumwill_tb") {
			if ($this->uid->getSessionValue() <> "")
				$sDetailFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "personal_info") {
			if ($this->uid->getSessionValue() <> "")
				$sDetailFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		if ($this->getCurrentMasterTable() == "privatetrust_tb") {
			if ($this->uid->getSessionValue() <> "")
				$sDetailFilter .= "`uid`=" . ew_QuotedValue($this->uid->getSessionValue(), EW_DATATYPE_NUMBER);
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_children_details() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_children_details() {
		return "`uid`=@uid@";
	}

	// Master filter
	function SqlMasterFilter_comprehensivewill_tb() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_comprehensivewill_tb() {
		return "`uid`=@uid@";
	}

	// Master filter
	function SqlMasterFilter_premiumwill_tb() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_premiumwill_tb() {
		return "`uid`=@uid@";
	}

	// Master filter
	function SqlMasterFilter_personal_info() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_personal_info() {
		return "`uid`=@uid@";
	}

	// Master filter
	function SqlMasterFilter_privatetrust_tb() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_privatetrust_tb() {
		return "`uid`=@uid@";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "assets_tb") {
			$sDetailUrl = $GLOBALS["assets_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "alt_beneficiary") {
			$sDetailUrl = $GLOBALS["alt_beneficiary"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&childid=" . $this->childid->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "beneficiary_dumplist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`beneficiary_dump`";
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
	var $UpdateTable = "`beneficiary_dump`";

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
			return "beneficiary_dumplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "beneficiary_dumplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("beneficiary_dumpview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("beneficiary_dumpview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "beneficiary_dumpadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("beneficiary_dumpedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("beneficiary_dumpedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("beneficiary_dumpadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("beneficiary_dumpadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("beneficiary_dumpdelete.php", $this->UrlParm());
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
		$this->childid->setDbValue($rs->fields('childid'));
		$this->title->setDbValue($rs->fields('title'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->rtionship->setDbValue($rs->fields('rtionship'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->addr->setDbValue($rs->fields('addr'));
		$this->city->setDbValue($rs->fields('city'));
		$this->state->setDbValue($rs->fields('state'));
		$this->percentage->setDbValue($rs->fields('percentage'));
		$this->percentage1->setDbValue($rs->fields('percentage1'));
		$this->percentage2->setDbValue($rs->fields('percentage2'));
		$this->percentage3->setDbValue($rs->fields('percentage3'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->passport->setDbValue($rs->fields('passport'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// uid
		// childid
		// title
		// fullname
		// rtionship
		// email
		// phone
		// addr
		// city
		// state
		// percentage
		// percentage1
		// percentage2
		// percentage3
		// datecreated
		// passport
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// childid
		$this->childid->ViewValue = $this->childid->CurrentValue;
		$this->childid->ViewCustomAttributes = "";

		// title
		$this->title->ViewValue = $this->title->CurrentValue;
		$this->title->ViewCustomAttributes = "";

		// fullname
		$this->fullname->ViewValue = $this->fullname->CurrentValue;
		$this->fullname->ViewCustomAttributes = "";

		// rtionship
		$this->rtionship->ViewValue = $this->rtionship->CurrentValue;
		$this->rtionship->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// addr
		$this->addr->ViewValue = $this->addr->CurrentValue;
		$this->addr->ViewCustomAttributes = "";

		// city
		$this->city->ViewValue = $this->city->CurrentValue;
		$this->city->ViewCustomAttributes = "";

		// state
		$this->state->ViewValue = $this->state->CurrentValue;
		$this->state->ViewCustomAttributes = "";

		// percentage
		$this->percentage->ViewValue = $this->percentage->CurrentValue;
		$this->percentage->ViewCustomAttributes = "";

		// percentage1
		$this->percentage1->ViewValue = $this->percentage1->CurrentValue;
		$this->percentage1->ViewCustomAttributes = "";

		// percentage2
		$this->percentage2->ViewValue = $this->percentage2->CurrentValue;
		$this->percentage2->ViewCustomAttributes = "";

		// percentage3
		$this->percentage3->ViewValue = $this->percentage3->CurrentValue;
		$this->percentage3->ViewCustomAttributes = "";

		// datecreated
		$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
		$this->datecreated->ViewCustomAttributes = "";

		// passport
		$this->passport->ViewValue = $this->passport->CurrentValue;
		$this->passport->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// childid
		$this->childid->LinkCustomAttributes = "";
		$this->childid->HrefValue = "";
		$this->childid->TooltipValue = "";

		// title
		$this->title->LinkCustomAttributes = "";
		$this->title->HrefValue = "";
		$this->title->TooltipValue = "";

		// fullname
		$this->fullname->LinkCustomAttributes = "";
		$this->fullname->HrefValue = "";
		$this->fullname->TooltipValue = "";

		// rtionship
		$this->rtionship->LinkCustomAttributes = "";
		$this->rtionship->HrefValue = "";
		$this->rtionship->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// phone
		$this->phone->LinkCustomAttributes = "";
		$this->phone->HrefValue = "";
		$this->phone->TooltipValue = "";

		// addr
		$this->addr->LinkCustomAttributes = "";
		$this->addr->HrefValue = "";
		$this->addr->TooltipValue = "";

		// city
		$this->city->LinkCustomAttributes = "";
		$this->city->HrefValue = "";
		$this->city->TooltipValue = "";

		// state
		$this->state->LinkCustomAttributes = "";
		$this->state->HrefValue = "";
		$this->state->TooltipValue = "";

		// percentage
		$this->percentage->LinkCustomAttributes = "";
		$this->percentage->HrefValue = "";
		$this->percentage->TooltipValue = "";

		// percentage1
		$this->percentage1->LinkCustomAttributes = "";
		$this->percentage1->HrefValue = "";
		$this->percentage1->TooltipValue = "";

		// percentage2
		$this->percentage2->LinkCustomAttributes = "";
		$this->percentage2->HrefValue = "";
		$this->percentage2->TooltipValue = "";

		// percentage3
		$this->percentage3->LinkCustomAttributes = "";
		$this->percentage3->HrefValue = "";
		$this->percentage3->TooltipValue = "";

		// datecreated
		$this->datecreated->LinkCustomAttributes = "";
		$this->datecreated->HrefValue = "";
		$this->datecreated->TooltipValue = "";

		// passport
		$this->passport->LinkCustomAttributes = "";
		$this->passport->HrefValue = "";
		$this->passport->TooltipValue = "";

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
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->childid->Exportable) $Doc->ExportCaption($this->childid);
				if ($this->title->Exportable) $Doc->ExportCaption($this->title);
				if ($this->fullname->Exportable) $Doc->ExportCaption($this->fullname);
				if ($this->rtionship->Exportable) $Doc->ExportCaption($this->rtionship);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
				if ($this->addr->Exportable) $Doc->ExportCaption($this->addr);
				if ($this->city->Exportable) $Doc->ExportCaption($this->city);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->percentage->Exportable) $Doc->ExportCaption($this->percentage);
				if ($this->percentage1->Exportable) $Doc->ExportCaption($this->percentage1);
				if ($this->percentage2->Exportable) $Doc->ExportCaption($this->percentage2);
				if ($this->percentage3->Exportable) $Doc->ExportCaption($this->percentage3);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
				if ($this->passport->Exportable) $Doc->ExportCaption($this->passport);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->childid->Exportable) $Doc->ExportCaption($this->childid);
				if ($this->title->Exportable) $Doc->ExportCaption($this->title);
				if ($this->fullname->Exportable) $Doc->ExportCaption($this->fullname);
				if ($this->rtionship->Exportable) $Doc->ExportCaption($this->rtionship);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
				if ($this->addr->Exportable) $Doc->ExportCaption($this->addr);
				if ($this->city->Exportable) $Doc->ExportCaption($this->city);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->percentage->Exportable) $Doc->ExportCaption($this->percentage);
				if ($this->percentage1->Exportable) $Doc->ExportCaption($this->percentage1);
				if ($this->percentage2->Exportable) $Doc->ExportCaption($this->percentage2);
				if ($this->percentage3->Exportable) $Doc->ExportCaption($this->percentage3);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
				if ($this->passport->Exportable) $Doc->ExportCaption($this->passport);
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
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->childid->Exportable) $Doc->ExportField($this->childid);
					if ($this->title->Exportable) $Doc->ExportField($this->title);
					if ($this->fullname->Exportable) $Doc->ExportField($this->fullname);
					if ($this->rtionship->Exportable) $Doc->ExportField($this->rtionship);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->phone->Exportable) $Doc->ExportField($this->phone);
					if ($this->addr->Exportable) $Doc->ExportField($this->addr);
					if ($this->city->Exportable) $Doc->ExportField($this->city);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->percentage->Exportable) $Doc->ExportField($this->percentage);
					if ($this->percentage1->Exportable) $Doc->ExportField($this->percentage1);
					if ($this->percentage2->Exportable) $Doc->ExportField($this->percentage2);
					if ($this->percentage3->Exportable) $Doc->ExportField($this->percentage3);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
					if ($this->passport->Exportable) $Doc->ExportField($this->passport);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->childid->Exportable) $Doc->ExportField($this->childid);
					if ($this->title->Exportable) $Doc->ExportField($this->title);
					if ($this->fullname->Exportable) $Doc->ExportField($this->fullname);
					if ($this->rtionship->Exportable) $Doc->ExportField($this->rtionship);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->phone->Exportable) $Doc->ExportField($this->phone);
					if ($this->addr->Exportable) $Doc->ExportField($this->addr);
					if ($this->city->Exportable) $Doc->ExportField($this->city);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->percentage->Exportable) $Doc->ExportField($this->percentage);
					if ($this->percentage1->Exportable) $Doc->ExportField($this->percentage1);
					if ($this->percentage2->Exportable) $Doc->ExportField($this->percentage2);
					if ($this->percentage3->Exportable) $Doc->ExportField($this->percentage3);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
					if ($this->passport->Exportable) $Doc->ExportField($this->passport);
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
