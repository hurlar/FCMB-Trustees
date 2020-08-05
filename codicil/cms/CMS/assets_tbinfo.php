<?php

// Global variable for table object
$assets_tb = NULL;

//
// Table class for assets_tb
//
class cassets_tb extends cTable {
	var $id;
	var $uid;
	var $asset_type;
	var $property_location;
	var $property_type;
	var $property_registered;
	var $shares_company;
	var $shares_volume;
	var $shares_percent;
	var $shares_cscs;
	var $shares_chn;
	var $insurance_company;
	var $insurance_type;
	var $insurance_owner;
	var $insurance_facevalue;
	var $bvn;
	var $account_name;
	var $account_no;
	var $bankname;
	var $accounttype;
	var $pension_name;
	var $pension_owner;
	var $pension_plan;
	var $rsano;
	var $pension_admin;
	var $datecreated;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'assets_tb';
		$this->TableName = 'assets_tb';
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
		$this->id = new cField('assets_tb', 'assets_tb', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// uid
		$this->uid = new cField('assets_tb', 'assets_tb', 'x_uid', 'uid', '`uid`', '`uid`', 3, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// asset_type
		$this->asset_type = new cField('assets_tb', 'assets_tb', 'x_asset_type', 'asset_type', '`asset_type`', '`asset_type`', 201, -1, FALSE, '`asset_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['asset_type'] = &$this->asset_type;

		// property_location
		$this->property_location = new cField('assets_tb', 'assets_tb', 'x_property_location', 'property_location', '`property_location`', '`property_location`', 201, -1, FALSE, '`property_location`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['property_location'] = &$this->property_location;

		// property_type
		$this->property_type = new cField('assets_tb', 'assets_tb', 'x_property_type', 'property_type', '`property_type`', '`property_type`', 201, -1, FALSE, '`property_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['property_type'] = &$this->property_type;

		// property_registered
		$this->property_registered = new cField('assets_tb', 'assets_tb', 'x_property_registered', 'property_registered', '`property_registered`', '`property_registered`', 201, -1, FALSE, '`property_registered`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['property_registered'] = &$this->property_registered;

		// shares_company
		$this->shares_company = new cField('assets_tb', 'assets_tb', 'x_shares_company', 'shares_company', '`shares_company`', '`shares_company`', 201, -1, FALSE, '`shares_company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['shares_company'] = &$this->shares_company;

		// shares_volume
		$this->shares_volume = new cField('assets_tb', 'assets_tb', 'x_shares_volume', 'shares_volume', '`shares_volume`', '`shares_volume`', 201, -1, FALSE, '`shares_volume`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['shares_volume'] = &$this->shares_volume;

		// shares_percent
		$this->shares_percent = new cField('assets_tb', 'assets_tb', 'x_shares_percent', 'shares_percent', '`shares_percent`', '`shares_percent`', 201, -1, FALSE, '`shares_percent`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['shares_percent'] = &$this->shares_percent;

		// shares_cscs
		$this->shares_cscs = new cField('assets_tb', 'assets_tb', 'x_shares_cscs', 'shares_cscs', '`shares_cscs`', '`shares_cscs`', 201, -1, FALSE, '`shares_cscs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['shares_cscs'] = &$this->shares_cscs;

		// shares_chn
		$this->shares_chn = new cField('assets_tb', 'assets_tb', 'x_shares_chn', 'shares_chn', '`shares_chn`', '`shares_chn`', 200, -1, FALSE, '`shares_chn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['shares_chn'] = &$this->shares_chn;

		// insurance_company
		$this->insurance_company = new cField('assets_tb', 'assets_tb', 'x_insurance_company', 'insurance_company', '`insurance_company`', '`insurance_company`', 201, -1, FALSE, '`insurance_company`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['insurance_company'] = &$this->insurance_company;

		// insurance_type
		$this->insurance_type = new cField('assets_tb', 'assets_tb', 'x_insurance_type', 'insurance_type', '`insurance_type`', '`insurance_type`', 201, -1, FALSE, '`insurance_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['insurance_type'] = &$this->insurance_type;

		// insurance_owner
		$this->insurance_owner = new cField('assets_tb', 'assets_tb', 'x_insurance_owner', 'insurance_owner', '`insurance_owner`', '`insurance_owner`', 201, -1, FALSE, '`insurance_owner`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['insurance_owner'] = &$this->insurance_owner;

		// insurance_facevalue
		$this->insurance_facevalue = new cField('assets_tb', 'assets_tb', 'x_insurance_facevalue', 'insurance_facevalue', '`insurance_facevalue`', '`insurance_facevalue`', 201, -1, FALSE, '`insurance_facevalue`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['insurance_facevalue'] = &$this->insurance_facevalue;

		// bvn
		$this->bvn = new cField('assets_tb', 'assets_tb', 'x_bvn', 'bvn', '`bvn`', '`bvn`', 201, -1, FALSE, '`bvn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['bvn'] = &$this->bvn;

		// account_name
		$this->account_name = new cField('assets_tb', 'assets_tb', 'x_account_name', 'account_name', '`account_name`', '`account_name`', 201, -1, FALSE, '`account_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['account_name'] = &$this->account_name;

		// account_no
		$this->account_no = new cField('assets_tb', 'assets_tb', 'x_account_no', 'account_no', '`account_no`', '`account_no`', 201, -1, FALSE, '`account_no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['account_no'] = &$this->account_no;

		// bankname
		$this->bankname = new cField('assets_tb', 'assets_tb', 'x_bankname', 'bankname', '`bankname`', '`bankname`', 201, -1, FALSE, '`bankname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['bankname'] = &$this->bankname;

		// accounttype
		$this->accounttype = new cField('assets_tb', 'assets_tb', 'x_accounttype', 'accounttype', '`accounttype`', '`accounttype`', 201, -1, FALSE, '`accounttype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['accounttype'] = &$this->accounttype;

		// pension_name
		$this->pension_name = new cField('assets_tb', 'assets_tb', 'x_pension_name', 'pension_name', '`pension_name`', '`pension_name`', 201, -1, FALSE, '`pension_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pension_name'] = &$this->pension_name;

		// pension_owner
		$this->pension_owner = new cField('assets_tb', 'assets_tb', 'x_pension_owner', 'pension_owner', '`pension_owner`', '`pension_owner`', 201, -1, FALSE, '`pension_owner`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pension_owner'] = &$this->pension_owner;

		// pension_plan
		$this->pension_plan = new cField('assets_tb', 'assets_tb', 'x_pension_plan', 'pension_plan', '`pension_plan`', '`pension_plan`', 201, -1, FALSE, '`pension_plan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pension_plan'] = &$this->pension_plan;

		// rsano
		$this->rsano = new cField('assets_tb', 'assets_tb', 'x_rsano', 'rsano', '`rsano`', '`rsano`', 201, -1, FALSE, '`rsano`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rsano'] = &$this->rsano;

		// pension_admin
		$this->pension_admin = new cField('assets_tb', 'assets_tb', 'x_pension_admin', 'pension_admin', '`pension_admin`', '`pension_admin`', 201, -1, FALSE, '`pension_admin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pension_admin'] = &$this->pension_admin;

		// datecreated
		$this->datecreated = new cField('assets_tb', 'assets_tb', 'x_datecreated', 'datecreated', '`datecreated`', 'DATE_FORMAT(`datecreated`, \'%d/%m/%y\')', 135, -1, FALSE, '`datecreated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['datecreated'] = &$this->datecreated;
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
		if ($this->getCurrentMasterTable() == "beneficiary_dump") {
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
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "beneficiary_dump") {
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
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_beneficiary_dump() {
		return "`uid`=@uid@";
	}

	// Detail filter
	function SqlDetailFilter_beneficiary_dump() {
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
		if ($this->getCurrentDetailTable() == "overall_asset") {
			$sDetailUrl = $GLOBALS["overall_asset"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "assets_tblist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`assets_tb`";
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
	var $UpdateTable = "`assets_tb`";

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
			return "assets_tblist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "assets_tblist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("assets_tbview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("assets_tbview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "assets_tbadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("assets_tbedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("assets_tbedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("assets_tbadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("assets_tbadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("assets_tbdelete.php", $this->UrlParm());
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
		$this->asset_type->setDbValue($rs->fields('asset_type'));
		$this->property_location->setDbValue($rs->fields('property_location'));
		$this->property_type->setDbValue($rs->fields('property_type'));
		$this->property_registered->setDbValue($rs->fields('property_registered'));
		$this->shares_company->setDbValue($rs->fields('shares_company'));
		$this->shares_volume->setDbValue($rs->fields('shares_volume'));
		$this->shares_percent->setDbValue($rs->fields('shares_percent'));
		$this->shares_cscs->setDbValue($rs->fields('shares_cscs'));
		$this->shares_chn->setDbValue($rs->fields('shares_chn'));
		$this->insurance_company->setDbValue($rs->fields('insurance_company'));
		$this->insurance_type->setDbValue($rs->fields('insurance_type'));
		$this->insurance_owner->setDbValue($rs->fields('insurance_owner'));
		$this->insurance_facevalue->setDbValue($rs->fields('insurance_facevalue'));
		$this->bvn->setDbValue($rs->fields('bvn'));
		$this->account_name->setDbValue($rs->fields('account_name'));
		$this->account_no->setDbValue($rs->fields('account_no'));
		$this->bankname->setDbValue($rs->fields('bankname'));
		$this->accounttype->setDbValue($rs->fields('accounttype'));
		$this->pension_name->setDbValue($rs->fields('pension_name'));
		$this->pension_owner->setDbValue($rs->fields('pension_owner'));
		$this->pension_plan->setDbValue($rs->fields('pension_plan'));
		$this->rsano->setDbValue($rs->fields('rsano'));
		$this->pension_admin->setDbValue($rs->fields('pension_admin'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// uid
		// asset_type
		// property_location
		// property_type
		// property_registered
		// shares_company
		// shares_volume
		// shares_percent
		// shares_cscs
		// shares_chn
		// insurance_company
		// insurance_type
		// insurance_owner
		// insurance_facevalue
		// bvn
		// account_name
		// account_no
		// bankname
		// accounttype
		// pension_name
		// pension_owner
		// pension_plan
		// rsano
		// pension_admin
		// datecreated
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// asset_type
		$this->asset_type->ViewValue = $this->asset_type->CurrentValue;
		$this->asset_type->ViewCustomAttributes = "";

		// property_location
		$this->property_location->ViewValue = $this->property_location->CurrentValue;
		$this->property_location->ViewCustomAttributes = "";

		// property_type
		$this->property_type->ViewValue = $this->property_type->CurrentValue;
		$this->property_type->ViewCustomAttributes = "";

		// property_registered
		$this->property_registered->ViewValue = $this->property_registered->CurrentValue;
		$this->property_registered->ViewCustomAttributes = "";

		// shares_company
		$this->shares_company->ViewValue = $this->shares_company->CurrentValue;
		$this->shares_company->ViewCustomAttributes = "";

		// shares_volume
		$this->shares_volume->ViewValue = $this->shares_volume->CurrentValue;
		$this->shares_volume->ViewCustomAttributes = "";

		// shares_percent
		$this->shares_percent->ViewValue = $this->shares_percent->CurrentValue;
		$this->shares_percent->ViewCustomAttributes = "";

		// shares_cscs
		$this->shares_cscs->ViewValue = $this->shares_cscs->CurrentValue;
		$this->shares_cscs->ViewCustomAttributes = "";

		// shares_chn
		$this->shares_chn->ViewValue = $this->shares_chn->CurrentValue;
		$this->shares_chn->ViewCustomAttributes = "";

		// insurance_company
		$this->insurance_company->ViewValue = $this->insurance_company->CurrentValue;
		$this->insurance_company->ViewCustomAttributes = "";

		// insurance_type
		$this->insurance_type->ViewValue = $this->insurance_type->CurrentValue;
		$this->insurance_type->ViewCustomAttributes = "";

		// insurance_owner
		$this->insurance_owner->ViewValue = $this->insurance_owner->CurrentValue;
		$this->insurance_owner->ViewCustomAttributes = "";

		// insurance_facevalue
		$this->insurance_facevalue->ViewValue = $this->insurance_facevalue->CurrentValue;
		$this->insurance_facevalue->ViewCustomAttributes = "";

		// bvn
		$this->bvn->ViewValue = $this->bvn->CurrentValue;
		$this->bvn->ViewCustomAttributes = "";

		// account_name
		$this->account_name->ViewValue = $this->account_name->CurrentValue;
		$this->account_name->ViewCustomAttributes = "";

		// account_no
		$this->account_no->ViewValue = $this->account_no->CurrentValue;
		$this->account_no->ViewCustomAttributes = "";

		// bankname
		$this->bankname->ViewValue = $this->bankname->CurrentValue;
		$this->bankname->ViewCustomAttributes = "";

		// accounttype
		$this->accounttype->ViewValue = $this->accounttype->CurrentValue;
		$this->accounttype->ViewCustomAttributes = "";

		// pension_name
		$this->pension_name->ViewValue = $this->pension_name->CurrentValue;
		$this->pension_name->ViewCustomAttributes = "";

		// pension_owner
		$this->pension_owner->ViewValue = $this->pension_owner->CurrentValue;
		$this->pension_owner->ViewCustomAttributes = "";

		// pension_plan
		$this->pension_plan->ViewValue = $this->pension_plan->CurrentValue;
		$this->pension_plan->ViewCustomAttributes = "";

		// rsano
		$this->rsano->ViewValue = $this->rsano->CurrentValue;
		$this->rsano->ViewCustomAttributes = "";

		// pension_admin
		$this->pension_admin->ViewValue = $this->pension_admin->CurrentValue;
		$this->pension_admin->ViewCustomAttributes = "";

		// datecreated
		$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
		$this->datecreated->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// asset_type
		$this->asset_type->LinkCustomAttributes = "";
		$this->asset_type->HrefValue = "";
		$this->asset_type->TooltipValue = "";

		// property_location
		$this->property_location->LinkCustomAttributes = "";
		$this->property_location->HrefValue = "";
		$this->property_location->TooltipValue = "";

		// property_type
		$this->property_type->LinkCustomAttributes = "";
		$this->property_type->HrefValue = "";
		$this->property_type->TooltipValue = "";

		// property_registered
		$this->property_registered->LinkCustomAttributes = "";
		$this->property_registered->HrefValue = "";
		$this->property_registered->TooltipValue = "";

		// shares_company
		$this->shares_company->LinkCustomAttributes = "";
		$this->shares_company->HrefValue = "";
		$this->shares_company->TooltipValue = "";

		// shares_volume
		$this->shares_volume->LinkCustomAttributes = "";
		$this->shares_volume->HrefValue = "";
		$this->shares_volume->TooltipValue = "";

		// shares_percent
		$this->shares_percent->LinkCustomAttributes = "";
		$this->shares_percent->HrefValue = "";
		$this->shares_percent->TooltipValue = "";

		// shares_cscs
		$this->shares_cscs->LinkCustomAttributes = "";
		$this->shares_cscs->HrefValue = "";
		$this->shares_cscs->TooltipValue = "";

		// shares_chn
		$this->shares_chn->LinkCustomAttributes = "";
		$this->shares_chn->HrefValue = "";
		$this->shares_chn->TooltipValue = "";

		// insurance_company
		$this->insurance_company->LinkCustomAttributes = "";
		$this->insurance_company->HrefValue = "";
		$this->insurance_company->TooltipValue = "";

		// insurance_type
		$this->insurance_type->LinkCustomAttributes = "";
		$this->insurance_type->HrefValue = "";
		$this->insurance_type->TooltipValue = "";

		// insurance_owner
		$this->insurance_owner->LinkCustomAttributes = "";
		$this->insurance_owner->HrefValue = "";
		$this->insurance_owner->TooltipValue = "";

		// insurance_facevalue
		$this->insurance_facevalue->LinkCustomAttributes = "";
		$this->insurance_facevalue->HrefValue = "";
		$this->insurance_facevalue->TooltipValue = "";

		// bvn
		$this->bvn->LinkCustomAttributes = "";
		$this->bvn->HrefValue = "";
		$this->bvn->TooltipValue = "";

		// account_name
		$this->account_name->LinkCustomAttributes = "";
		$this->account_name->HrefValue = "";
		$this->account_name->TooltipValue = "";

		// account_no
		$this->account_no->LinkCustomAttributes = "";
		$this->account_no->HrefValue = "";
		$this->account_no->TooltipValue = "";

		// bankname
		$this->bankname->LinkCustomAttributes = "";
		$this->bankname->HrefValue = "";
		$this->bankname->TooltipValue = "";

		// accounttype
		$this->accounttype->LinkCustomAttributes = "";
		$this->accounttype->HrefValue = "";
		$this->accounttype->TooltipValue = "";

		// pension_name
		$this->pension_name->LinkCustomAttributes = "";
		$this->pension_name->HrefValue = "";
		$this->pension_name->TooltipValue = "";

		// pension_owner
		$this->pension_owner->LinkCustomAttributes = "";
		$this->pension_owner->HrefValue = "";
		$this->pension_owner->TooltipValue = "";

		// pension_plan
		$this->pension_plan->LinkCustomAttributes = "";
		$this->pension_plan->HrefValue = "";
		$this->pension_plan->TooltipValue = "";

		// rsano
		$this->rsano->LinkCustomAttributes = "";
		$this->rsano->HrefValue = "";
		$this->rsano->TooltipValue = "";

		// pension_admin
		$this->pension_admin->LinkCustomAttributes = "";
		$this->pension_admin->HrefValue = "";
		$this->pension_admin->TooltipValue = "";

		// datecreated
		$this->datecreated->LinkCustomAttributes = "";
		$this->datecreated->HrefValue = "";
		$this->datecreated->TooltipValue = "";

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
				if ($this->asset_type->Exportable) $Doc->ExportCaption($this->asset_type);
				if ($this->property_location->Exportable) $Doc->ExportCaption($this->property_location);
				if ($this->property_type->Exportable) $Doc->ExportCaption($this->property_type);
				if ($this->property_registered->Exportable) $Doc->ExportCaption($this->property_registered);
				if ($this->shares_company->Exportable) $Doc->ExportCaption($this->shares_company);
				if ($this->shares_volume->Exportable) $Doc->ExportCaption($this->shares_volume);
				if ($this->shares_percent->Exportable) $Doc->ExportCaption($this->shares_percent);
				if ($this->shares_cscs->Exportable) $Doc->ExportCaption($this->shares_cscs);
				if ($this->shares_chn->Exportable) $Doc->ExportCaption($this->shares_chn);
				if ($this->insurance_company->Exportable) $Doc->ExportCaption($this->insurance_company);
				if ($this->insurance_type->Exportable) $Doc->ExportCaption($this->insurance_type);
				if ($this->insurance_owner->Exportable) $Doc->ExportCaption($this->insurance_owner);
				if ($this->insurance_facevalue->Exportable) $Doc->ExportCaption($this->insurance_facevalue);
				if ($this->bvn->Exportable) $Doc->ExportCaption($this->bvn);
				if ($this->account_name->Exportable) $Doc->ExportCaption($this->account_name);
				if ($this->account_no->Exportable) $Doc->ExportCaption($this->account_no);
				if ($this->bankname->Exportable) $Doc->ExportCaption($this->bankname);
				if ($this->accounttype->Exportable) $Doc->ExportCaption($this->accounttype);
				if ($this->pension_name->Exportable) $Doc->ExportCaption($this->pension_name);
				if ($this->pension_owner->Exportable) $Doc->ExportCaption($this->pension_owner);
				if ($this->pension_plan->Exportable) $Doc->ExportCaption($this->pension_plan);
				if ($this->rsano->Exportable) $Doc->ExportCaption($this->rsano);
				if ($this->pension_admin->Exportable) $Doc->ExportCaption($this->pension_admin);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->asset_type->Exportable) $Doc->ExportCaption($this->asset_type);
				if ($this->property_location->Exportable) $Doc->ExportCaption($this->property_location);
				if ($this->property_type->Exportable) $Doc->ExportCaption($this->property_type);
				if ($this->property_registered->Exportable) $Doc->ExportCaption($this->property_registered);
				if ($this->shares_company->Exportable) $Doc->ExportCaption($this->shares_company);
				if ($this->shares_volume->Exportable) $Doc->ExportCaption($this->shares_volume);
				if ($this->shares_percent->Exportable) $Doc->ExportCaption($this->shares_percent);
				if ($this->shares_cscs->Exportable) $Doc->ExportCaption($this->shares_cscs);
				if ($this->shares_chn->Exportable) $Doc->ExportCaption($this->shares_chn);
				if ($this->insurance_company->Exportable) $Doc->ExportCaption($this->insurance_company);
				if ($this->insurance_type->Exportable) $Doc->ExportCaption($this->insurance_type);
				if ($this->insurance_owner->Exportable) $Doc->ExportCaption($this->insurance_owner);
				if ($this->insurance_facevalue->Exportable) $Doc->ExportCaption($this->insurance_facevalue);
				if ($this->bvn->Exportable) $Doc->ExportCaption($this->bvn);
				if ($this->account_name->Exportable) $Doc->ExportCaption($this->account_name);
				if ($this->account_no->Exportable) $Doc->ExportCaption($this->account_no);
				if ($this->bankname->Exportable) $Doc->ExportCaption($this->bankname);
				if ($this->accounttype->Exportable) $Doc->ExportCaption($this->accounttype);
				if ($this->pension_name->Exportable) $Doc->ExportCaption($this->pension_name);
				if ($this->pension_owner->Exportable) $Doc->ExportCaption($this->pension_owner);
				if ($this->pension_plan->Exportable) $Doc->ExportCaption($this->pension_plan);
				if ($this->rsano->Exportable) $Doc->ExportCaption($this->rsano);
				if ($this->pension_admin->Exportable) $Doc->ExportCaption($this->pension_admin);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
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
					if ($this->asset_type->Exportable) $Doc->ExportField($this->asset_type);
					if ($this->property_location->Exportable) $Doc->ExportField($this->property_location);
					if ($this->property_type->Exportable) $Doc->ExportField($this->property_type);
					if ($this->property_registered->Exportable) $Doc->ExportField($this->property_registered);
					if ($this->shares_company->Exportable) $Doc->ExportField($this->shares_company);
					if ($this->shares_volume->Exportable) $Doc->ExportField($this->shares_volume);
					if ($this->shares_percent->Exportable) $Doc->ExportField($this->shares_percent);
					if ($this->shares_cscs->Exportable) $Doc->ExportField($this->shares_cscs);
					if ($this->shares_chn->Exportable) $Doc->ExportField($this->shares_chn);
					if ($this->insurance_company->Exportable) $Doc->ExportField($this->insurance_company);
					if ($this->insurance_type->Exportable) $Doc->ExportField($this->insurance_type);
					if ($this->insurance_owner->Exportable) $Doc->ExportField($this->insurance_owner);
					if ($this->insurance_facevalue->Exportable) $Doc->ExportField($this->insurance_facevalue);
					if ($this->bvn->Exportable) $Doc->ExportField($this->bvn);
					if ($this->account_name->Exportable) $Doc->ExportField($this->account_name);
					if ($this->account_no->Exportable) $Doc->ExportField($this->account_no);
					if ($this->bankname->Exportable) $Doc->ExportField($this->bankname);
					if ($this->accounttype->Exportable) $Doc->ExportField($this->accounttype);
					if ($this->pension_name->Exportable) $Doc->ExportField($this->pension_name);
					if ($this->pension_owner->Exportable) $Doc->ExportField($this->pension_owner);
					if ($this->pension_plan->Exportable) $Doc->ExportField($this->pension_plan);
					if ($this->rsano->Exportable) $Doc->ExportField($this->rsano);
					if ($this->pension_admin->Exportable) $Doc->ExportField($this->pension_admin);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->asset_type->Exportable) $Doc->ExportField($this->asset_type);
					if ($this->property_location->Exportable) $Doc->ExportField($this->property_location);
					if ($this->property_type->Exportable) $Doc->ExportField($this->property_type);
					if ($this->property_registered->Exportable) $Doc->ExportField($this->property_registered);
					if ($this->shares_company->Exportable) $Doc->ExportField($this->shares_company);
					if ($this->shares_volume->Exportable) $Doc->ExportField($this->shares_volume);
					if ($this->shares_percent->Exportable) $Doc->ExportField($this->shares_percent);
					if ($this->shares_cscs->Exportable) $Doc->ExportField($this->shares_cscs);
					if ($this->shares_chn->Exportable) $Doc->ExportField($this->shares_chn);
					if ($this->insurance_company->Exportable) $Doc->ExportField($this->insurance_company);
					if ($this->insurance_type->Exportable) $Doc->ExportField($this->insurance_type);
					if ($this->insurance_owner->Exportable) $Doc->ExportField($this->insurance_owner);
					if ($this->insurance_facevalue->Exportable) $Doc->ExportField($this->insurance_facevalue);
					if ($this->bvn->Exportable) $Doc->ExportField($this->bvn);
					if ($this->account_name->Exportable) $Doc->ExportField($this->account_name);
					if ($this->account_no->Exportable) $Doc->ExportField($this->account_no);
					if ($this->bankname->Exportable) $Doc->ExportField($this->bankname);
					if ($this->accounttype->Exportable) $Doc->ExportField($this->accounttype);
					if ($this->pension_name->Exportable) $Doc->ExportField($this->pension_name);
					if ($this->pension_owner->Exportable) $Doc->ExportField($this->pension_owner);
					if ($this->pension_plan->Exportable) $Doc->ExportField($this->pension_plan);
					if ($this->rsano->Exportable) $Doc->ExportField($this->rsano);
					if ($this->pension_admin->Exportable) $Doc->ExportField($this->pension_admin);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
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
