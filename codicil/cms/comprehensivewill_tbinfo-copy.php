<?php

// Global variable for table object
$comprehensivewill_tb = NULL;

//
// Table class for comprehensivewill_tb
//
class ccomprehensivewill_tb extends cTable {
	var $id;
	var $uid;
	var $willtype;
	var $fullname;
	var $address;
	var $_email;
	var $phoneno;
	var $aphoneno;
	var $gender;
	var $dob;
	var $state;
	var $nationality;
	var $lga;
	var $employmentstatus;
	var $employer;
	var $employerphone;
	var $employeraddr;
	var $maritalstatus;
	var $spname;
	var $spemail;
	var $spphone;
	var $sdob;
	var $spaddr;
	var $spcity;
	var $spstate;
	var $marriagetype;
	var $marriageyear;
	var $marriagecert;
	var $marriagecity;
	var $marriagecountry;
	var $divorce;
	var $divorceyear;
	var $addinfo;
	var $datecreated;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'comprehensivewill_tb';
		$this->TableName = 'comprehensivewill_tb';
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
		$this->id = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// uid
		$this->uid = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_uid', 'uid', '`uid`', '`uid`', 3, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// willtype
		$this->willtype = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_willtype', 'willtype', '`willtype`', '`willtype`', 200, -1, FALSE, '`willtype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['willtype'] = &$this->willtype;

		// fullname
		$this->fullname = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_fullname', 'fullname', '`fullname`', '`fullname`', 200, -1, FALSE, '`fullname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fullname'] = &$this->fullname;

		// address
		$this->address = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_address', 'address', '`address`', '`address`', 201, -1, FALSE, '`address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['address'] = &$this->address;

		// email
		$this->_email = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['email'] = &$this->_email;

		// phoneno
		$this->phoneno = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_phoneno', 'phoneno', '`phoneno`', '`phoneno`', 200, -1, FALSE, '`phoneno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['phoneno'] = &$this->phoneno;

		// aphoneno
		$this->aphoneno = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_aphoneno', 'aphoneno', '`aphoneno`', '`aphoneno`', 200, -1, FALSE, '`aphoneno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['aphoneno'] = &$this->aphoneno;

		// gender
		$this->gender = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_gender', 'gender', '`gender`', '`gender`', 200, -1, FALSE, '`gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['gender'] = &$this->gender;

		// dob
		$this->dob = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_dob', 'dob', '`dob`', '`dob`', 200, -1, FALSE, '`dob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dob'] = &$this->dob;

		// state
		$this->state = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_state', 'state', '`state`', '`state`', 200, -1, FALSE, '`state`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['state'] = &$this->state;

		// nationality
		$this->nationality = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_nationality', 'nationality', '`nationality`', '`nationality`', 200, -1, FALSE, '`nationality`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nationality'] = &$this->nationality;

		// lga
		$this->lga = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_lga', 'lga', '`lga`', '`lga`', 200, -1, FALSE, '`lga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lga'] = &$this->lga;

		// employmentstatus
		$this->employmentstatus = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_employmentstatus', 'employmentstatus', '`employmentstatus`', '`employmentstatus`', 200, -1, FALSE, '`employmentstatus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employmentstatus'] = &$this->employmentstatus;

		// employer
		$this->employer = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_employer', 'employer', '`employer`', '`employer`', 201, -1, FALSE, '`employer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employer'] = &$this->employer;

		// employerphone
		$this->employerphone = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_employerphone', 'employerphone', '`employerphone`', '`employerphone`', 200, -1, FALSE, '`employerphone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employerphone'] = &$this->employerphone;

		// employeraddr
		$this->employeraddr = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_employeraddr', 'employeraddr', '`employeraddr`', '`employeraddr`', 201, -1, FALSE, '`employeraddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employeraddr'] = &$this->employeraddr;

		// maritalstatus
		$this->maritalstatus = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_maritalstatus', 'maritalstatus', '`maritalstatus`', '`maritalstatus`', 200, -1, FALSE, '`maritalstatus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['maritalstatus'] = &$this->maritalstatus;

		// spname
		$this->spname = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_spname', 'spname', '`spname`', '`spname`', 200, -1, FALSE, '`spname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spname'] = &$this->spname;

		// spemail
		$this->spemail = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_spemail', 'spemail', '`spemail`', '`spemail`', 200, -1, FALSE, '`spemail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spemail'] = &$this->spemail;

		// spphone
		$this->spphone = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_spphone', 'spphone', '`spphone`', '`spphone`', 200, -1, FALSE, '`spphone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spphone'] = &$this->spphone;

		// sdob
		$this->sdob = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_sdob', 'sdob', '`sdob`', '`sdob`', 200, -1, FALSE, '`sdob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sdob'] = &$this->sdob;

		// spaddr
		$this->spaddr = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_spaddr', 'spaddr', '`spaddr`', '`spaddr`', 201, -1, FALSE, '`spaddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spaddr'] = &$this->spaddr;

		// spcity
		$this->spcity = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_spcity', 'spcity', '`spcity`', '`spcity`', 200, -1, FALSE, '`spcity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spcity'] = &$this->spcity;

		// spstate
		$this->spstate = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_spstate', 'spstate', '`spstate`', '`spstate`', 200, -1, FALSE, '`spstate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spstate'] = &$this->spstate;

		// marriagetype
		$this->marriagetype = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_marriagetype', 'marriagetype', '`marriagetype`', '`marriagetype`', 200, -1, FALSE, '`marriagetype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriagetype'] = &$this->marriagetype;

		// marriageyear
		$this->marriageyear = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_marriageyear', 'marriageyear', '`marriageyear`', '`marriageyear`', 200, -1, FALSE, '`marriageyear`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriageyear'] = &$this->marriageyear;

		// marriagecert
		$this->marriagecert = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_marriagecert', 'marriagecert', '`marriagecert`', '`marriagecert`', 200, -1, FALSE, '`marriagecert`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriagecert'] = &$this->marriagecert;

		// marriagecity
		$this->marriagecity = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_marriagecity', 'marriagecity', '`marriagecity`', '`marriagecity`', 200, -1, FALSE, '`marriagecity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriagecity'] = &$this->marriagecity;

		// marriagecountry
		$this->marriagecountry = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_marriagecountry', 'marriagecountry', '`marriagecountry`', '`marriagecountry`', 200, -1, FALSE, '`marriagecountry`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriagecountry'] = &$this->marriagecountry;

		// divorce
		$this->divorce = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_divorce', 'divorce', '`divorce`', '`divorce`', 200, -1, FALSE, '`divorce`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['divorce'] = &$this->divorce;

		// divorceyear
		$this->divorceyear = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_divorceyear', 'divorceyear', '`divorceyear`', '`divorceyear`', 200, -1, FALSE, '`divorceyear`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['divorceyear'] = &$this->divorceyear;

		// addinfo
		$this->addinfo = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_addinfo', 'addinfo', '`addinfo`', '`addinfo`', 201, -1, FALSE, '`addinfo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['addinfo'] = &$this->addinfo;

		// datecreated
		$this->datecreated = new cField('comprehensivewill_tb', 'comprehensivewill_tb', 'x_datecreated', 'datecreated', '`datecreated`', 'DATE_FORMAT(`datecreated`, \'%d/%m/%y\')', 135, -1, FALSE, '`datecreated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		if ($this->getCurrentDetailTable() == "personal_info") {
			$sDetailUrl = $GLOBALS["personal_info"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "spouse_tb") {
			$sDetailUrl = $GLOBALS["spouse_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "divorce_tb") {
			$sDetailUrl = $GLOBALS["divorce_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "children_details") {
			$sDetailUrl = $GLOBALS["children_details"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "beneficiary_dump") {
			$sDetailUrl = $GLOBALS["beneficiary_dump"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "alt_beneficiary") {
			$sDetailUrl = $GLOBALS["alt_beneficiary"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "assets_tb") {
			$sDetailUrl = $GLOBALS["assets_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "overall_asset") {
			$sDetailUrl = $GLOBALS["overall_asset"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "executor_tb") {
			$sDetailUrl = $GLOBALS["executor_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "trustee_tb") {
			$sDetailUrl = $GLOBALS["trustee_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "witness_tb") {
			$sDetailUrl = $GLOBALS["witness_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "addinfo_tb") {
			$sDetailUrl = $GLOBALS["addinfo_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "comprehensivewill_tblist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`comprehensivewill_tb`";
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
	var $UpdateTable = "`comprehensivewill_tb`";

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

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["personal_info"])) $GLOBALS["personal_info"] = new cpersonal_info();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["personal_info"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["spouse_tb"])) $GLOBALS["spouse_tb"] = new cspouse_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["spouse_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["children_details"])) $GLOBALS["children_details"] = new cchildren_details();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["children_details"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["beneficiary_dump"])) $GLOBALS["beneficiary_dump"] = new cbeneficiary_dump();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["beneficiary_dump"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["alt_beneficiary"])) $GLOBALS["alt_beneficiary"] = new calt_beneficiary();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["alt_beneficiary"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["assets_tb"])) $GLOBALS["assets_tb"] = new cassets_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["assets_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["overall_asset"])) $GLOBALS["overall_asset"] = new coverall_asset();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["overall_asset"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["executor_tb"])) $GLOBALS["executor_tb"] = new cexecutor_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["executor_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["trustee_tb"])) $GLOBALS["trustee_tb"] = new ctrustee_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["trustee_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["witness_tb"])) $GLOBALS["witness_tb"] = new cwitness_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["witness_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}

		// Cascade update detail field 'uid'
		if (!is_null($rsold) && (isset($rs['uid']) && $rsold['uid'] <> $rs['uid'])) {
			if (!isset($GLOBALS["addinfo_tb"])) $GLOBALS["addinfo_tb"] = new caddinfo_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["addinfo_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
		}
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

		// Cascade delete detail table 'personal_info'
		if (!isset($GLOBALS["personal_info"])) $GLOBALS["personal_info"] = new cpersonal_info();
		$rscascade = array();
		$GLOBALS["personal_info"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'spouse_tb'
		if (!isset($GLOBALS["spouse_tb"])) $GLOBALS["spouse_tb"] = new cspouse_tb();
		$rscascade = array();
		$GLOBALS["spouse_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'children_details'
		if (!isset($GLOBALS["children_details"])) $GLOBALS["children_details"] = new cchildren_details();
		$rscascade = array();
		$GLOBALS["children_details"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'beneficiary_dump'
		if (!isset($GLOBALS["beneficiary_dump"])) $GLOBALS["beneficiary_dump"] = new cbeneficiary_dump();
		$rscascade = array();
		$GLOBALS["beneficiary_dump"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'alt_beneficiary'
		if (!isset($GLOBALS["alt_beneficiary"])) $GLOBALS["alt_beneficiary"] = new calt_beneficiary();
		$rscascade = array();
		$GLOBALS["alt_beneficiary"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'assets_tb'
		if (!isset($GLOBALS["assets_tb"])) $GLOBALS["assets_tb"] = new cassets_tb();
		$rscascade = array();
		$GLOBALS["assets_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'overall_asset'
		if (!isset($GLOBALS["overall_asset"])) $GLOBALS["overall_asset"] = new coverall_asset();
		$rscascade = array();
		$GLOBALS["overall_asset"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'executor_tb'
		if (!isset($GLOBALS["executor_tb"])) $GLOBALS["executor_tb"] = new cexecutor_tb();
		$rscascade = array();
		$GLOBALS["executor_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'trustee_tb'
		if (!isset($GLOBALS["trustee_tb"])) $GLOBALS["trustee_tb"] = new ctrustee_tb();
		$rscascade = array();
		$GLOBALS["trustee_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'witness_tb'
		if (!isset($GLOBALS["witness_tb"])) $GLOBALS["witness_tb"] = new cwitness_tb();
		$rscascade = array();
		$GLOBALS["witness_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'addinfo_tb'
		if (!isset($GLOBALS["addinfo_tb"])) $GLOBALS["addinfo_tb"] = new caddinfo_tb();
		$rscascade = array();
		$GLOBALS["addinfo_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));
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
			return "comprehensivewill_tblist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "comprehensivewill_tblist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("comprehensivewill_tbview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("comprehensivewill_tbview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "comprehensivewill_tbadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("comprehensivewill_tbedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("comprehensivewill_tbedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("comprehensivewill_tbadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("comprehensivewill_tbadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("comprehensivewill_tbdelete.php", $this->UrlParm());
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
		$this->willtype->setDbValue($rs->fields('willtype'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->address->setDbValue($rs->fields('address'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phoneno->setDbValue($rs->fields('phoneno'));
		$this->aphoneno->setDbValue($rs->fields('aphoneno'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->state->setDbValue($rs->fields('state'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->maritalstatus->setDbValue($rs->fields('maritalstatus'));
		$this->spname->setDbValue($rs->fields('spname'));
		$this->spemail->setDbValue($rs->fields('spemail'));
		$this->spphone->setDbValue($rs->fields('spphone'));
		$this->sdob->setDbValue($rs->fields('sdob'));
		$this->spaddr->setDbValue($rs->fields('spaddr'));
		$this->spcity->setDbValue($rs->fields('spcity'));
		$this->spstate->setDbValue($rs->fields('spstate'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->marriagecity->setDbValue($rs->fields('marriagecity'));
		$this->marriagecountry->setDbValue($rs->fields('marriagecountry'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->addinfo->setDbValue($rs->fields('addinfo'));
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
		// willtype
		// fullname
		// address
		// email
		// phoneno
		// aphoneno
		// gender
		// dob
		// state
		// nationality
		// lga
		// employmentstatus
		// employer
		// employerphone
		// employeraddr
		// maritalstatus
		// spname
		// spemail
		// spphone
		// sdob
		// spaddr
		// spcity
		// spstate
		// marriagetype
		// marriageyear
		// marriagecert
		// marriagecity
		// marriagecountry
		// divorce
		// divorceyear
		// addinfo
		// datecreated
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// willtype
		$this->willtype->ViewValue = $this->willtype->CurrentValue;
		$this->willtype->ViewCustomAttributes = "";

		// fullname
		$this->fullname->ViewValue = $this->fullname->CurrentValue;
		$this->fullname->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// phoneno
		$this->phoneno->ViewValue = $this->phoneno->CurrentValue;
		$this->phoneno->ViewCustomAttributes = "";

		// aphoneno
		$this->aphoneno->ViewValue = $this->aphoneno->CurrentValue;
		$this->aphoneno->ViewCustomAttributes = "";

		// gender
		$this->gender->ViewValue = $this->gender->CurrentValue;
		$this->gender->ViewCustomAttributes = "";

		// dob
		$this->dob->ViewValue = $this->dob->CurrentValue;
		$this->dob->ViewCustomAttributes = "";

		// state
		$this->state->ViewValue = $this->state->CurrentValue;
		$this->state->ViewCustomAttributes = "";

		// nationality
		$this->nationality->ViewValue = $this->nationality->CurrentValue;
		$this->nationality->ViewCustomAttributes = "";

		// lga
		$this->lga->ViewValue = $this->lga->CurrentValue;
		$this->lga->ViewCustomAttributes = "";

		// employmentstatus
		$this->employmentstatus->ViewValue = $this->employmentstatus->CurrentValue;
		$this->employmentstatus->ViewCustomAttributes = "";

		// employer
		$this->employer->ViewValue = $this->employer->CurrentValue;
		$this->employer->ViewCustomAttributes = "";

		// employerphone
		$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
		$this->employerphone->ViewCustomAttributes = "";

		// employeraddr
		$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
		$this->employeraddr->ViewCustomAttributes = "";

		// maritalstatus
		$this->maritalstatus->ViewValue = $this->maritalstatus->CurrentValue;
		$this->maritalstatus->ViewCustomAttributes = "";

		// spname
		$this->spname->ViewValue = $this->spname->CurrentValue;
		$this->spname->ViewCustomAttributes = "";

		// spemail
		$this->spemail->ViewValue = $this->spemail->CurrentValue;
		$this->spemail->ViewCustomAttributes = "";

		// spphone
		$this->spphone->ViewValue = $this->spphone->CurrentValue;
		$this->spphone->ViewCustomAttributes = "";

		// sdob
		$this->sdob->ViewValue = $this->sdob->CurrentValue;
		$this->sdob->ViewCustomAttributes = "";

		// spaddr
		$this->spaddr->ViewValue = $this->spaddr->CurrentValue;
		$this->spaddr->ViewCustomAttributes = "";

		// spcity
		$this->spcity->ViewValue = $this->spcity->CurrentValue;
		$this->spcity->ViewCustomAttributes = "";

		// spstate
		$this->spstate->ViewValue = $this->spstate->CurrentValue;
		$this->spstate->ViewCustomAttributes = "";

		// marriagetype
		$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
		$this->marriagetype->ViewCustomAttributes = "";

		// marriageyear
		$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
		$this->marriageyear->ViewCustomAttributes = "";

		// marriagecert
		$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
		$this->marriagecert->ViewCustomAttributes = "";

		// marriagecity
		$this->marriagecity->ViewValue = $this->marriagecity->CurrentValue;
		$this->marriagecity->ViewCustomAttributes = "";

		// marriagecountry
		$this->marriagecountry->ViewValue = $this->marriagecountry->CurrentValue;
		$this->marriagecountry->ViewCustomAttributes = "";

		// divorce
		$this->divorce->ViewValue = $this->divorce->CurrentValue;
		$this->divorce->ViewCustomAttributes = "";

		// divorceyear
		$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
		$this->divorceyear->ViewCustomAttributes = "";

		// addinfo
		$this->addinfo->ViewValue = $this->addinfo->CurrentValue;
		$this->addinfo->ViewCustomAttributes = "";

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

		// willtype
		$this->willtype->LinkCustomAttributes = "";
		$this->willtype->HrefValue = "";
		$this->willtype->TooltipValue = "";

		// fullname
		$this->fullname->LinkCustomAttributes = "";
		if (!ew_Empty($this->uid->CurrentValue)) {
			$this->fullname->HrefValue = "http://tisvdigital.com/trustees/portal/admincomprehensivewill-preview.php?a=" . ((!empty($this->uid->ViewValue)) ? $this->uid->ViewValue : $this->uid->CurrentValue); // Add prefix/suffix
			$this->fullname->LinkAttrs["target"] = "_blank"; // Add target
			if ($this->Export <> "") $this->fullname->HrefValue = ew_ConvertFullUrl($this->fullname->HrefValue);
		} else {
			$this->fullname->HrefValue = "";
		}
		$this->fullname->TooltipValue = "";

		// address
		$this->address->LinkCustomAttributes = "";
		$this->address->HrefValue = "";
		$this->address->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// phoneno
		$this->phoneno->LinkCustomAttributes = "";
		$this->phoneno->HrefValue = "";
		$this->phoneno->TooltipValue = "";

		// aphoneno
		$this->aphoneno->LinkCustomAttributes = "";
		$this->aphoneno->HrefValue = "";
		$this->aphoneno->TooltipValue = "";

		// gender
		$this->gender->LinkCustomAttributes = "";
		$this->gender->HrefValue = "";
		$this->gender->TooltipValue = "";

		// dob
		$this->dob->LinkCustomAttributes = "";
		$this->dob->HrefValue = "";
		$this->dob->TooltipValue = "";

		// state
		$this->state->LinkCustomAttributes = "";
		$this->state->HrefValue = "";
		$this->state->TooltipValue = "";

		// nationality
		$this->nationality->LinkCustomAttributes = "";
		$this->nationality->HrefValue = "";
		$this->nationality->TooltipValue = "";

		// lga
		$this->lga->LinkCustomAttributes = "";
		$this->lga->HrefValue = "";
		$this->lga->TooltipValue = "";

		// employmentstatus
		$this->employmentstatus->LinkCustomAttributes = "";
		$this->employmentstatus->HrefValue = "";
		$this->employmentstatus->TooltipValue = "";

		// employer
		$this->employer->LinkCustomAttributes = "";
		$this->employer->HrefValue = "";
		$this->employer->TooltipValue = "";

		// employerphone
		$this->employerphone->LinkCustomAttributes = "";
		$this->employerphone->HrefValue = "";
		$this->employerphone->TooltipValue = "";

		// employeraddr
		$this->employeraddr->LinkCustomAttributes = "";
		$this->employeraddr->HrefValue = "";
		$this->employeraddr->TooltipValue = "";

		// maritalstatus
		$this->maritalstatus->LinkCustomAttributes = "";
		$this->maritalstatus->HrefValue = "";
		$this->maritalstatus->TooltipValue = "";

		// spname
		$this->spname->LinkCustomAttributes = "";
		$this->spname->HrefValue = "";
		$this->spname->TooltipValue = "";

		// spemail
		$this->spemail->LinkCustomAttributes = "";
		$this->spemail->HrefValue = "";
		$this->spemail->TooltipValue = "";

		// spphone
		$this->spphone->LinkCustomAttributes = "";
		$this->spphone->HrefValue = "";
		$this->spphone->TooltipValue = "";

		// sdob
		$this->sdob->LinkCustomAttributes = "";
		$this->sdob->HrefValue = "";
		$this->sdob->TooltipValue = "";

		// spaddr
		$this->spaddr->LinkCustomAttributes = "";
		$this->spaddr->HrefValue = "";
		$this->spaddr->TooltipValue = "";

		// spcity
		$this->spcity->LinkCustomAttributes = "";
		$this->spcity->HrefValue = "";
		$this->spcity->TooltipValue = "";

		// spstate
		$this->spstate->LinkCustomAttributes = "";
		$this->spstate->HrefValue = "";
		$this->spstate->TooltipValue = "";

		// marriagetype
		$this->marriagetype->LinkCustomAttributes = "";
		$this->marriagetype->HrefValue = "";
		$this->marriagetype->TooltipValue = "";

		// marriageyear
		$this->marriageyear->LinkCustomAttributes = "";
		$this->marriageyear->HrefValue = "";
		$this->marriageyear->TooltipValue = "";

		// marriagecert
		$this->marriagecert->LinkCustomAttributes = "";
		$this->marriagecert->HrefValue = "";
		$this->marriagecert->TooltipValue = "";

		// marriagecity
		$this->marriagecity->LinkCustomAttributes = "";
		$this->marriagecity->HrefValue = "";
		$this->marriagecity->TooltipValue = "";

		// marriagecountry
		$this->marriagecountry->LinkCustomAttributes = "";
		$this->marriagecountry->HrefValue = "";
		$this->marriagecountry->TooltipValue = "";

		// divorce
		$this->divorce->LinkCustomAttributes = "";
		$this->divorce->HrefValue = "";
		$this->divorce->TooltipValue = "";

		// divorceyear
		$this->divorceyear->LinkCustomAttributes = "";
		$this->divorceyear->HrefValue = "";
		$this->divorceyear->TooltipValue = "";

		// addinfo
		$this->addinfo->LinkCustomAttributes = "";
		$this->addinfo->HrefValue = "";
		$this->addinfo->TooltipValue = "";

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
				if ($this->willtype->Exportable) $Doc->ExportCaption($this->willtype);
				if ($this->fullname->Exportable) $Doc->ExportCaption($this->fullname);
				if ($this->address->Exportable) $Doc->ExportCaption($this->address);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->phoneno->Exportable) $Doc->ExportCaption($this->phoneno);
				if ($this->aphoneno->Exportable) $Doc->ExportCaption($this->aphoneno);
				if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
				if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
				if ($this->lga->Exportable) $Doc->ExportCaption($this->lga);
				if ($this->employmentstatus->Exportable) $Doc->ExportCaption($this->employmentstatus);
				if ($this->employer->Exportable) $Doc->ExportCaption($this->employer);
				if ($this->employerphone->Exportable) $Doc->ExportCaption($this->employerphone);
				if ($this->employeraddr->Exportable) $Doc->ExportCaption($this->employeraddr);
				if ($this->maritalstatus->Exportable) $Doc->ExportCaption($this->maritalstatus);
				if ($this->spname->Exportable) $Doc->ExportCaption($this->spname);
				if ($this->spemail->Exportable) $Doc->ExportCaption($this->spemail);
				if ($this->spphone->Exportable) $Doc->ExportCaption($this->spphone);
				if ($this->sdob->Exportable) $Doc->ExportCaption($this->sdob);
				if ($this->spaddr->Exportable) $Doc->ExportCaption($this->spaddr);
				if ($this->spcity->Exportable) $Doc->ExportCaption($this->spcity);
				if ($this->spstate->Exportable) $Doc->ExportCaption($this->spstate);
				if ($this->marriagetype->Exportable) $Doc->ExportCaption($this->marriagetype);
				if ($this->marriageyear->Exportable) $Doc->ExportCaption($this->marriageyear);
				if ($this->marriagecert->Exportable) $Doc->ExportCaption($this->marriagecert);
				if ($this->marriagecity->Exportable) $Doc->ExportCaption($this->marriagecity);
				if ($this->marriagecountry->Exportable) $Doc->ExportCaption($this->marriagecountry);
				if ($this->divorce->Exportable) $Doc->ExportCaption($this->divorce);
				if ($this->divorceyear->Exportable) $Doc->ExportCaption($this->divorceyear);
				if ($this->addinfo->Exportable) $Doc->ExportCaption($this->addinfo);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->willtype->Exportable) $Doc->ExportCaption($this->willtype);
				if ($this->fullname->Exportable) $Doc->ExportCaption($this->fullname);
				if ($this->address->Exportable) $Doc->ExportCaption($this->address);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->phoneno->Exportable) $Doc->ExportCaption($this->phoneno);
				if ($this->aphoneno->Exportable) $Doc->ExportCaption($this->aphoneno);
				if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
				if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
				if ($this->lga->Exportable) $Doc->ExportCaption($this->lga);
				if ($this->employmentstatus->Exportable) $Doc->ExportCaption($this->employmentstatus);
				if ($this->employer->Exportable) $Doc->ExportCaption($this->employer);
				if ($this->employerphone->Exportable) $Doc->ExportCaption($this->employerphone);
				if ($this->employeraddr->Exportable) $Doc->ExportCaption($this->employeraddr);
				if ($this->maritalstatus->Exportable) $Doc->ExportCaption($this->maritalstatus);
				if ($this->spname->Exportable) $Doc->ExportCaption($this->spname);
				if ($this->spemail->Exportable) $Doc->ExportCaption($this->spemail);
				if ($this->spphone->Exportable) $Doc->ExportCaption($this->spphone);
				if ($this->sdob->Exportable) $Doc->ExportCaption($this->sdob);
				if ($this->spaddr->Exportable) $Doc->ExportCaption($this->spaddr);
				if ($this->spcity->Exportable) $Doc->ExportCaption($this->spcity);
				if ($this->spstate->Exportable) $Doc->ExportCaption($this->spstate);
				if ($this->marriagetype->Exportable) $Doc->ExportCaption($this->marriagetype);
				if ($this->marriageyear->Exportable) $Doc->ExportCaption($this->marriageyear);
				if ($this->marriagecert->Exportable) $Doc->ExportCaption($this->marriagecert);
				if ($this->marriagecity->Exportable) $Doc->ExportCaption($this->marriagecity);
				if ($this->marriagecountry->Exportable) $Doc->ExportCaption($this->marriagecountry);
				if ($this->divorce->Exportable) $Doc->ExportCaption($this->divorce);
				if ($this->divorceyear->Exportable) $Doc->ExportCaption($this->divorceyear);
				if ($this->addinfo->Exportable) $Doc->ExportCaption($this->addinfo);
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
					if ($this->willtype->Exportable) $Doc->ExportField($this->willtype);
					if ($this->fullname->Exportable) $Doc->ExportField($this->fullname);
					if ($this->address->Exportable) $Doc->ExportField($this->address);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->phoneno->Exportable) $Doc->ExportField($this->phoneno);
					if ($this->aphoneno->Exportable) $Doc->ExportField($this->aphoneno);
					if ($this->gender->Exportable) $Doc->ExportField($this->gender);
					if ($this->dob->Exportable) $Doc->ExportField($this->dob);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
					if ($this->lga->Exportable) $Doc->ExportField($this->lga);
					if ($this->employmentstatus->Exportable) $Doc->ExportField($this->employmentstatus);
					if ($this->employer->Exportable) $Doc->ExportField($this->employer);
					if ($this->employerphone->Exportable) $Doc->ExportField($this->employerphone);
					if ($this->employeraddr->Exportable) $Doc->ExportField($this->employeraddr);
					if ($this->maritalstatus->Exportable) $Doc->ExportField($this->maritalstatus);
					if ($this->spname->Exportable) $Doc->ExportField($this->spname);
					if ($this->spemail->Exportable) $Doc->ExportField($this->spemail);
					if ($this->spphone->Exportable) $Doc->ExportField($this->spphone);
					if ($this->sdob->Exportable) $Doc->ExportField($this->sdob);
					if ($this->spaddr->Exportable) $Doc->ExportField($this->spaddr);
					if ($this->spcity->Exportable) $Doc->ExportField($this->spcity);
					if ($this->spstate->Exportable) $Doc->ExportField($this->spstate);
					if ($this->marriagetype->Exportable) $Doc->ExportField($this->marriagetype);
					if ($this->marriageyear->Exportable) $Doc->ExportField($this->marriageyear);
					if ($this->marriagecert->Exportable) $Doc->ExportField($this->marriagecert);
					if ($this->marriagecity->Exportable) $Doc->ExportField($this->marriagecity);
					if ($this->marriagecountry->Exportable) $Doc->ExportField($this->marriagecountry);
					if ($this->divorce->Exportable) $Doc->ExportField($this->divorce);
					if ($this->divorceyear->Exportable) $Doc->ExportField($this->divorceyear);
					if ($this->addinfo->Exportable) $Doc->ExportField($this->addinfo);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->willtype->Exportable) $Doc->ExportField($this->willtype);
					if ($this->fullname->Exportable) $Doc->ExportField($this->fullname);
					if ($this->address->Exportable) $Doc->ExportField($this->address);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->phoneno->Exportable) $Doc->ExportField($this->phoneno);
					if ($this->aphoneno->Exportable) $Doc->ExportField($this->aphoneno);
					if ($this->gender->Exportable) $Doc->ExportField($this->gender);
					if ($this->dob->Exportable) $Doc->ExportField($this->dob);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
					if ($this->lga->Exportable) $Doc->ExportField($this->lga);
					if ($this->employmentstatus->Exportable) $Doc->ExportField($this->employmentstatus);
					if ($this->employer->Exportable) $Doc->ExportField($this->employer);
					if ($this->employerphone->Exportable) $Doc->ExportField($this->employerphone);
					if ($this->employeraddr->Exportable) $Doc->ExportField($this->employeraddr);
					if ($this->maritalstatus->Exportable) $Doc->ExportField($this->maritalstatus);
					if ($this->spname->Exportable) $Doc->ExportField($this->spname);
					if ($this->spemail->Exportable) $Doc->ExportField($this->spemail);
					if ($this->spphone->Exportable) $Doc->ExportField($this->spphone);
					if ($this->sdob->Exportable) $Doc->ExportField($this->sdob);
					if ($this->spaddr->Exportable) $Doc->ExportField($this->spaddr);
					if ($this->spcity->Exportable) $Doc->ExportField($this->spcity);
					if ($this->spstate->Exportable) $Doc->ExportField($this->spstate);
					if ($this->marriagetype->Exportable) $Doc->ExportField($this->marriagetype);
					if ($this->marriageyear->Exportable) $Doc->ExportField($this->marriageyear);
					if ($this->marriagecert->Exportable) $Doc->ExportField($this->marriagecert);
					if ($this->marriagecity->Exportable) $Doc->ExportField($this->marriagecity);
					if ($this->marriagecountry->Exportable) $Doc->ExportField($this->marriagecountry);
					if ($this->divorce->Exportable) $Doc->ExportField($this->divorce);
					if ($this->divorceyear->Exportable) $Doc->ExportField($this->divorceyear);
					if ($this->addinfo->Exportable) $Doc->ExportField($this->addinfo);
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
