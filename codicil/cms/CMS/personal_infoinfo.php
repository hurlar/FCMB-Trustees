<?php

// Global variable for table object
$personal_info = NULL;

//
// Table class for personal_info
//
class cpersonal_info extends cTable {
	var $id;
	var $uid;
	var $salutation;
	var $fname;
	var $mname;
	var $lname;
	var $phone;
	var $aphone;
	var $msg;
	var $city;
	var $rstate;
	var $dob;
	var $gender;
	var $lga;
	var $nationality;
	var $state;
	var $employment_status;
	var $employer;
	var $employerphone;
	var $employeraddr;
	var $datecreated;
	var $maidenname;
	var $passport;
	var $identification_type;
	var $identification_number;
	var $issuedate;
	var $expirydate;
	var $issuedplace;
	var $earning_type;
	var $earning_note;
	var $annual_income;
	var $nameofcompany;
	var $company_telephone;
	var $company_email;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'personal_info';
		$this->TableName = 'personal_info';
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
		$this->id = new cField('personal_info', 'personal_info', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// uid
		$this->uid = new cField('personal_info', 'personal_info', 'x_uid', 'uid', '`uid`', '`uid`', 3, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// salutation
		$this->salutation = new cField('personal_info', 'personal_info', 'x_salutation', 'salutation', '`salutation`', '`salutation`', 200, -1, FALSE, '`salutation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['salutation'] = &$this->salutation;

		// fname
		$this->fname = new cField('personal_info', 'personal_info', 'x_fname', 'fname', '`fname`', '`fname`', 200, -1, FALSE, '`fname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fname'] = &$this->fname;

		// mname
		$this->mname = new cField('personal_info', 'personal_info', 'x_mname', 'mname', '`mname`', '`mname`', 200, -1, FALSE, '`mname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['mname'] = &$this->mname;

		// lname
		$this->lname = new cField('personal_info', 'personal_info', 'x_lname', 'lname', '`lname`', '`lname`', 200, -1, FALSE, '`lname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lname'] = &$this->lname;

		// phone
		$this->phone = new cField('personal_info', 'personal_info', 'x_phone', 'phone', '`phone`', '`phone`', 200, -1, FALSE, '`phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['phone'] = &$this->phone;

		// aphone
		$this->aphone = new cField('personal_info', 'personal_info', 'x_aphone', 'aphone', '`aphone`', '`aphone`', 200, -1, FALSE, '`aphone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['aphone'] = &$this->aphone;

		// msg
		$this->msg = new cField('personal_info', 'personal_info', 'x_msg', 'msg', '`msg`', '`msg`', 201, -1, FALSE, '`msg`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['msg'] = &$this->msg;

		// city
		$this->city = new cField('personal_info', 'personal_info', 'x_city', 'city', '`city`', '`city`', 200, -1, FALSE, '`city`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['city'] = &$this->city;

		// rstate
		$this->rstate = new cField('personal_info', 'personal_info', 'x_rstate', 'rstate', '`rstate`', '`rstate`', 200, -1, FALSE, '`rstate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rstate'] = &$this->rstate;

		// dob
		$this->dob = new cField('personal_info', 'personal_info', 'x_dob', 'dob', '`dob`', '`dob`', 200, -1, FALSE, '`dob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dob'] = &$this->dob;

		// gender
		$this->gender = new cField('personal_info', 'personal_info', 'x_gender', 'gender', '`gender`', '`gender`', 200, -1, FALSE, '`gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['gender'] = &$this->gender;

		// lga
		$this->lga = new cField('personal_info', 'personal_info', 'x_lga', 'lga', '`lga`', '`lga`', 200, -1, FALSE, '`lga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lga'] = &$this->lga;

		// nationality
		$this->nationality = new cField('personal_info', 'personal_info', 'x_nationality', 'nationality', '`nationality`', '`nationality`', 200, -1, FALSE, '`nationality`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nationality'] = &$this->nationality;

		// state
		$this->state = new cField('personal_info', 'personal_info', 'x_state', 'state', '`state`', '`state`', 200, -1, FALSE, '`state`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['state'] = &$this->state;

		// employment_status
		$this->employment_status = new cField('personal_info', 'personal_info', 'x_employment_status', 'employment_status', '`employment_status`', '`employment_status`', 200, -1, FALSE, '`employment_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employment_status'] = &$this->employment_status;

		// employer
		$this->employer = new cField('personal_info', 'personal_info', 'x_employer', 'employer', '`employer`', '`employer`', 201, -1, FALSE, '`employer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employer'] = &$this->employer;

		// employerphone
		$this->employerphone = new cField('personal_info', 'personal_info', 'x_employerphone', 'employerphone', '`employerphone`', '`employerphone`', 200, -1, FALSE, '`employerphone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employerphone'] = &$this->employerphone;

		// employeraddr
		$this->employeraddr = new cField('personal_info', 'personal_info', 'x_employeraddr', 'employeraddr', '`employeraddr`', '`employeraddr`', 201, -1, FALSE, '`employeraddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employeraddr'] = &$this->employeraddr;

		// datecreated
		$this->datecreated = new cField('personal_info', 'personal_info', 'x_datecreated', 'datecreated', '`datecreated`', 'DATE_FORMAT(`datecreated`, \'%d/%m/%y\')', 133, -1, FALSE, '`datecreated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['datecreated'] = &$this->datecreated;

		// maidenname
		$this->maidenname = new cField('personal_info', 'personal_info', 'x_maidenname', 'maidenname', '`maidenname`', '`maidenname`', 200, -1, FALSE, '`maidenname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['maidenname'] = &$this->maidenname;

		// passport
		$this->passport = new cField('personal_info', 'personal_info', 'x_passport', 'passport', '`passport`', '`passport`', 200, -1, FALSE, '`passport`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['passport'] = &$this->passport;

		// identification_type
		$this->identification_type = new cField('personal_info', 'personal_info', 'x_identification_type', 'identification_type', '`identification_type`', '`identification_type`', 200, -1, FALSE, '`identification_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['identification_type'] = &$this->identification_type;

		// identification_number
		$this->identification_number = new cField('personal_info', 'personal_info', 'x_identification_number', 'identification_number', '`identification_number`', '`identification_number`', 200, -1, FALSE, '`identification_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['identification_number'] = &$this->identification_number;

		// issuedate
		$this->issuedate = new cField('personal_info', 'personal_info', 'x_issuedate', 'issuedate', '`issuedate`', '`issuedate`', 200, -1, FALSE, '`issuedate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['issuedate'] = &$this->issuedate;

		// expirydate
		$this->expirydate = new cField('personal_info', 'personal_info', 'x_expirydate', 'expirydate', '`expirydate`', '`expirydate`', 200, -1, FALSE, '`expirydate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['expirydate'] = &$this->expirydate;

		// issuedplace
		$this->issuedplace = new cField('personal_info', 'personal_info', 'x_issuedplace', 'issuedplace', '`issuedplace`', '`issuedplace`', 200, -1, FALSE, '`issuedplace`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['issuedplace'] = &$this->issuedplace;

		// earning_type
		$this->earning_type = new cField('personal_info', 'personal_info', 'x_earning_type', 'earning_type', '`earning_type`', '`earning_type`', 200, -1, FALSE, '`earning_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['earning_type'] = &$this->earning_type;

		// earning_note
		$this->earning_note = new cField('personal_info', 'personal_info', 'x_earning_note', 'earning_note', '`earning_note`', '`earning_note`', 201, -1, FALSE, '`earning_note`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['earning_note'] = &$this->earning_note;

		// annual_income
		$this->annual_income = new cField('personal_info', 'personal_info', 'x_annual_income', 'annual_income', '`annual_income`', '`annual_income`', 200, -1, FALSE, '`annual_income`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['annual_income'] = &$this->annual_income;

		// nameofcompany
		$this->nameofcompany = new cField('personal_info', 'personal_info', 'x_nameofcompany', 'nameofcompany', '`nameofcompany`', '`nameofcompany`', 200, -1, FALSE, '`nameofcompany`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nameofcompany'] = &$this->nameofcompany;

		// company_telephone
		$this->company_telephone = new cField('personal_info', 'personal_info', 'x_company_telephone', 'company_telephone', '`company_telephone`', '`company_telephone`', 200, -1, FALSE, '`company_telephone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['company_telephone'] = &$this->company_telephone;

		// company_email
		$this->company_email = new cField('personal_info', 'personal_info', 'x_company_email', 'company_email', '`company_email`', '`company_email`', 200, -1, FALSE, '`company_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['company_email'] = &$this->company_email;
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
		if ($this->getCurrentDetailTable() == "children_details") {
			$sDetailUrl = $GLOBALS["children_details"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "beneficiary_dump") {
			$sDetailUrl = $GLOBALS["beneficiary_dump"]->GetListUrl() . "?showmaster=" . $this->TableVar;
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
		if ($this->getCurrentDetailTable() == "nextofkin") {
			$sDetailUrl = $GLOBALS["nextofkin"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "spouse_tb") {
			$sDetailUrl = $GLOBALS["spouse_tb"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&uid=" . $this->uid->CurrentValue;
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "personal_infolist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`personal_info`";
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
	var $UpdateTable = "`personal_info`";

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
			if (!isset($GLOBALS["spouse_tb"])) $GLOBALS["spouse_tb"] = new cspouse_tb();
			$rscascade = array();
			$rscascade['uid'] = $rs['uid']; 
			$GLOBALS["spouse_tb"]->Update($rscascade, "`uid` = " . ew_QuotedValue($rsold['uid'], EW_DATATYPE_NUMBER));
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

		// Cascade delete detail table 'children_details'
		if (!isset($GLOBALS["children_details"])) $GLOBALS["children_details"] = new cchildren_details();
		$rscascade = array();
		$GLOBALS["children_details"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

		// Cascade delete detail table 'beneficiary_dump'
		if (!isset($GLOBALS["beneficiary_dump"])) $GLOBALS["beneficiary_dump"] = new cbeneficiary_dump();
		$rscascade = array();
		$GLOBALS["beneficiary_dump"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));

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

		// Cascade delete detail table 'spouse_tb'
		if (!isset($GLOBALS["spouse_tb"])) $GLOBALS["spouse_tb"] = new cspouse_tb();
		$rscascade = array();
		$GLOBALS["spouse_tb"]->Delete($rscascade, "`uid` = " . ew_QuotedValue($rs['uid'], EW_DATATYPE_NUMBER));
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
			return "personal_infolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "personal_infolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("personal_infoview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("personal_infoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "personal_infoadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("personal_infoedit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("personal_infoedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("personal_infoadd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("personal_infoadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("personal_infodelete.php", $this->UrlParm());
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
		$this->salutation->setDbValue($rs->fields('salutation'));
		$this->fname->setDbValue($rs->fields('fname'));
		$this->mname->setDbValue($rs->fields('mname'));
		$this->lname->setDbValue($rs->fields('lname'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->aphone->setDbValue($rs->fields('aphone'));
		$this->msg->setDbValue($rs->fields('msg'));
		$this->city->setDbValue($rs->fields('city'));
		$this->rstate->setDbValue($rs->fields('rstate'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->state->setDbValue($rs->fields('state'));
		$this->employment_status->setDbValue($rs->fields('employment_status'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->passport->setDbValue($rs->fields('passport'));
		$this->identification_type->setDbValue($rs->fields('identification_type'));
		$this->identification_number->setDbValue($rs->fields('identification_number'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->issuedplace->setDbValue($rs->fields('issuedplace'));
		$this->earning_type->setDbValue($rs->fields('earning_type'));
		$this->earning_note->setDbValue($rs->fields('earning_note'));
		$this->annual_income->setDbValue($rs->fields('annual_income'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->company_telephone->setDbValue($rs->fields('company_telephone'));
		$this->company_email->setDbValue($rs->fields('company_email'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// uid
		// salutation
		// fname
		// mname
		// lname
		// phone
		// aphone
		// msg
		// city
		// rstate
		// dob
		// gender
		// lga
		// nationality
		// state
		// employment_status
		// employer
		// employerphone
		// employeraddr
		// datecreated
		// maidenname
		// passport
		// identification_type
		// identification_number
		// issuedate
		// expirydate
		// issuedplace
		// earning_type
		// earning_note
		// annual_income
		// nameofcompany
		// company_telephone
		// company_email
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// salutation
		$this->salutation->ViewValue = $this->salutation->CurrentValue;
		$this->salutation->ViewCustomAttributes = "";

		// fname
		$this->fname->ViewValue = $this->fname->CurrentValue;
		$this->fname->ViewCustomAttributes = "";

		// mname
		$this->mname->ViewValue = $this->mname->CurrentValue;
		$this->mname->ViewCustomAttributes = "";

		// lname
		$this->lname->ViewValue = $this->lname->CurrentValue;
		$this->lname->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// aphone
		$this->aphone->ViewValue = $this->aphone->CurrentValue;
		$this->aphone->ViewCustomAttributes = "";

		// msg
		$this->msg->ViewValue = $this->msg->CurrentValue;
		$this->msg->ViewCustomAttributes = "";

		// city
		$this->city->ViewValue = $this->city->CurrentValue;
		$this->city->ViewCustomAttributes = "";

		// rstate
		$this->rstate->ViewValue = $this->rstate->CurrentValue;
		$this->rstate->ViewCustomAttributes = "";

		// dob
		$this->dob->ViewValue = $this->dob->CurrentValue;
		$this->dob->ViewCustomAttributes = "";

		// gender
		$this->gender->ViewValue = $this->gender->CurrentValue;
		$this->gender->ViewCustomAttributes = "";

		// lga
		$this->lga->ViewValue = $this->lga->CurrentValue;
		$this->lga->ViewCustomAttributes = "";

		// nationality
		$this->nationality->ViewValue = $this->nationality->CurrentValue;
		$this->nationality->ViewCustomAttributes = "";

		// state
		$this->state->ViewValue = $this->state->CurrentValue;
		$this->state->ViewCustomAttributes = "";

		// employment_status
		$this->employment_status->ViewValue = $this->employment_status->CurrentValue;
		$this->employment_status->ViewCustomAttributes = "";

		// employer
		$this->employer->ViewValue = $this->employer->CurrentValue;
		$this->employer->ViewCustomAttributes = "";

		// employerphone
		$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
		$this->employerphone->ViewCustomAttributes = "";

		// employeraddr
		$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
		$this->employeraddr->ViewCustomAttributes = "";

		// datecreated
		$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
		$this->datecreated->ViewCustomAttributes = "";

		// maidenname
		$this->maidenname->ViewValue = $this->maidenname->CurrentValue;
		$this->maidenname->ViewCustomAttributes = "";

		// passport
		$this->passport->ViewValue = $this->passport->CurrentValue;
		$this->passport->ViewCustomAttributes = "";

		// identification_type
		$this->identification_type->ViewValue = $this->identification_type->CurrentValue;
		$this->identification_type->ViewCustomAttributes = "";

		// identification_number
		$this->identification_number->ViewValue = $this->identification_number->CurrentValue;
		$this->identification_number->ViewCustomAttributes = "";

		// issuedate
		$this->issuedate->ViewValue = $this->issuedate->CurrentValue;
		$this->issuedate->ViewCustomAttributes = "";

		// expirydate
		$this->expirydate->ViewValue = $this->expirydate->CurrentValue;
		$this->expirydate->ViewCustomAttributes = "";

		// issuedplace
		$this->issuedplace->ViewValue = $this->issuedplace->CurrentValue;
		$this->issuedplace->ViewCustomAttributes = "";

		// earning_type
		$this->earning_type->ViewValue = $this->earning_type->CurrentValue;
		$this->earning_type->ViewCustomAttributes = "";

		// earning_note
		$this->earning_note->ViewValue = $this->earning_note->CurrentValue;
		$this->earning_note->ViewCustomAttributes = "";

		// annual_income
		$this->annual_income->ViewValue = $this->annual_income->CurrentValue;
		$this->annual_income->ViewCustomAttributes = "";

		// nameofcompany
		$this->nameofcompany->ViewValue = $this->nameofcompany->CurrentValue;
		$this->nameofcompany->ViewCustomAttributes = "";

		// company_telephone
		$this->company_telephone->ViewValue = $this->company_telephone->CurrentValue;
		$this->company_telephone->ViewCustomAttributes = "";

		// company_email
		$this->company_email->ViewValue = $this->company_email->CurrentValue;
		$this->company_email->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// salutation
		$this->salutation->LinkCustomAttributes = "";
		$this->salutation->HrefValue = "";
		$this->salutation->TooltipValue = "";

		// fname
		$this->fname->LinkCustomAttributes = "";
		$this->fname->HrefValue = "";
		$this->fname->TooltipValue = "";

		// mname
		$this->mname->LinkCustomAttributes = "";
		$this->mname->HrefValue = "";
		$this->mname->TooltipValue = "";

		// lname
		$this->lname->LinkCustomAttributes = "";
		$this->lname->HrefValue = "";
		$this->lname->TooltipValue = "";

		// phone
		$this->phone->LinkCustomAttributes = "";
		$this->phone->HrefValue = "";
		$this->phone->TooltipValue = "";

		// aphone
		$this->aphone->LinkCustomAttributes = "";
		$this->aphone->HrefValue = "";
		$this->aphone->TooltipValue = "";

		// msg
		$this->msg->LinkCustomAttributes = "";
		$this->msg->HrefValue = "";
		$this->msg->TooltipValue = "";

		// city
		$this->city->LinkCustomAttributes = "";
		$this->city->HrefValue = "";
		$this->city->TooltipValue = "";

		// rstate
		$this->rstate->LinkCustomAttributes = "";
		$this->rstate->HrefValue = "";
		$this->rstate->TooltipValue = "";

		// dob
		$this->dob->LinkCustomAttributes = "";
		$this->dob->HrefValue = "";
		$this->dob->TooltipValue = "";

		// gender
		$this->gender->LinkCustomAttributes = "";
		$this->gender->HrefValue = "";
		$this->gender->TooltipValue = "";

		// lga
		$this->lga->LinkCustomAttributes = "";
		$this->lga->HrefValue = "";
		$this->lga->TooltipValue = "";

		// nationality
		$this->nationality->LinkCustomAttributes = "";
		$this->nationality->HrefValue = "";
		$this->nationality->TooltipValue = "";

		// state
		$this->state->LinkCustomAttributes = "";
		$this->state->HrefValue = "";
		$this->state->TooltipValue = "";

		// employment_status
		$this->employment_status->LinkCustomAttributes = "";
		$this->employment_status->HrefValue = "";
		$this->employment_status->TooltipValue = "";

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

		// datecreated
		$this->datecreated->LinkCustomAttributes = "";
		$this->datecreated->HrefValue = "";
		$this->datecreated->TooltipValue = "";

		// maidenname
		$this->maidenname->LinkCustomAttributes = "";
		$this->maidenname->HrefValue = "";
		$this->maidenname->TooltipValue = "";

		// passport
		$this->passport->LinkCustomAttributes = "";
		$this->passport->HrefValue = "";
		$this->passport->TooltipValue = "";

		// identification_type
		$this->identification_type->LinkCustomAttributes = "";
		$this->identification_type->HrefValue = "";
		$this->identification_type->TooltipValue = "";

		// identification_number
		$this->identification_number->LinkCustomAttributes = "";
		$this->identification_number->HrefValue = "";
		$this->identification_number->TooltipValue = "";

		// issuedate
		$this->issuedate->LinkCustomAttributes = "";
		$this->issuedate->HrefValue = "";
		$this->issuedate->TooltipValue = "";

		// expirydate
		$this->expirydate->LinkCustomAttributes = "";
		$this->expirydate->HrefValue = "";
		$this->expirydate->TooltipValue = "";

		// issuedplace
		$this->issuedplace->LinkCustomAttributes = "";
		$this->issuedplace->HrefValue = "";
		$this->issuedplace->TooltipValue = "";

		// earning_type
		$this->earning_type->LinkCustomAttributes = "";
		$this->earning_type->HrefValue = "";
		$this->earning_type->TooltipValue = "";

		// earning_note
		$this->earning_note->LinkCustomAttributes = "";
		$this->earning_note->HrefValue = "";
		$this->earning_note->TooltipValue = "";

		// annual_income
		$this->annual_income->LinkCustomAttributes = "";
		$this->annual_income->HrefValue = "";
		$this->annual_income->TooltipValue = "";

		// nameofcompany
		$this->nameofcompany->LinkCustomAttributes = "";
		$this->nameofcompany->HrefValue = "";
		$this->nameofcompany->TooltipValue = "";

		// company_telephone
		$this->company_telephone->LinkCustomAttributes = "";
		$this->company_telephone->HrefValue = "";
		$this->company_telephone->TooltipValue = "";

		// company_email
		$this->company_email->LinkCustomAttributes = "";
		$this->company_email->HrefValue = "";
		$this->company_email->TooltipValue = "";

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
				if ($this->salutation->Exportable) $Doc->ExportCaption($this->salutation);
				if ($this->fname->Exportable) $Doc->ExportCaption($this->fname);
				if ($this->mname->Exportable) $Doc->ExportCaption($this->mname);
				if ($this->lname->Exportable) $Doc->ExportCaption($this->lname);
				if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
				if ($this->aphone->Exportable) $Doc->ExportCaption($this->aphone);
				if ($this->msg->Exportable) $Doc->ExportCaption($this->msg);
				if ($this->city->Exportable) $Doc->ExportCaption($this->city);
				if ($this->rstate->Exportable) $Doc->ExportCaption($this->rstate);
				if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
				if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
				if ($this->lga->Exportable) $Doc->ExportCaption($this->lga);
				if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->employment_status->Exportable) $Doc->ExportCaption($this->employment_status);
				if ($this->employer->Exportable) $Doc->ExportCaption($this->employer);
				if ($this->employerphone->Exportable) $Doc->ExportCaption($this->employerphone);
				if ($this->employeraddr->Exportable) $Doc->ExportCaption($this->employeraddr);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
				if ($this->maidenname->Exportable) $Doc->ExportCaption($this->maidenname);
				if ($this->passport->Exportable) $Doc->ExportCaption($this->passport);
				if ($this->identification_type->Exportable) $Doc->ExportCaption($this->identification_type);
				if ($this->identification_number->Exportable) $Doc->ExportCaption($this->identification_number);
				if ($this->issuedate->Exportable) $Doc->ExportCaption($this->issuedate);
				if ($this->expirydate->Exportable) $Doc->ExportCaption($this->expirydate);
				if ($this->issuedplace->Exportable) $Doc->ExportCaption($this->issuedplace);
				if ($this->earning_type->Exportable) $Doc->ExportCaption($this->earning_type);
				if ($this->earning_note->Exportable) $Doc->ExportCaption($this->earning_note);
				if ($this->annual_income->Exportable) $Doc->ExportCaption($this->annual_income);
				if ($this->nameofcompany->Exportable) $Doc->ExportCaption($this->nameofcompany);
				if ($this->company_telephone->Exportable) $Doc->ExportCaption($this->company_telephone);
				if ($this->company_email->Exportable) $Doc->ExportCaption($this->company_email);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->salutation->Exportable) $Doc->ExportCaption($this->salutation);
				if ($this->fname->Exportable) $Doc->ExportCaption($this->fname);
				if ($this->mname->Exportable) $Doc->ExportCaption($this->mname);
				if ($this->lname->Exportable) $Doc->ExportCaption($this->lname);
				if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
				if ($this->aphone->Exportable) $Doc->ExportCaption($this->aphone);
				if ($this->msg->Exportable) $Doc->ExportCaption($this->msg);
				if ($this->city->Exportable) $Doc->ExportCaption($this->city);
				if ($this->rstate->Exportable) $Doc->ExportCaption($this->rstate);
				if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
				if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
				if ($this->lga->Exportable) $Doc->ExportCaption($this->lga);
				if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->employment_status->Exportable) $Doc->ExportCaption($this->employment_status);
				if ($this->employer->Exportable) $Doc->ExportCaption($this->employer);
				if ($this->employerphone->Exportable) $Doc->ExportCaption($this->employerphone);
				if ($this->employeraddr->Exportable) $Doc->ExportCaption($this->employeraddr);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
				if ($this->maidenname->Exportable) $Doc->ExportCaption($this->maidenname);
				if ($this->passport->Exportable) $Doc->ExportCaption($this->passport);
				if ($this->identification_type->Exportable) $Doc->ExportCaption($this->identification_type);
				if ($this->identification_number->Exportable) $Doc->ExportCaption($this->identification_number);
				if ($this->issuedate->Exportable) $Doc->ExportCaption($this->issuedate);
				if ($this->expirydate->Exportable) $Doc->ExportCaption($this->expirydate);
				if ($this->issuedplace->Exportable) $Doc->ExportCaption($this->issuedplace);
				if ($this->earning_type->Exportable) $Doc->ExportCaption($this->earning_type);
				if ($this->earning_note->Exportable) $Doc->ExportCaption($this->earning_note);
				if ($this->annual_income->Exportable) $Doc->ExportCaption($this->annual_income);
				if ($this->nameofcompany->Exportable) $Doc->ExportCaption($this->nameofcompany);
				if ($this->company_telephone->Exportable) $Doc->ExportCaption($this->company_telephone);
				if ($this->company_email->Exportable) $Doc->ExportCaption($this->company_email);
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
					if ($this->salutation->Exportable) $Doc->ExportField($this->salutation);
					if ($this->fname->Exportable) $Doc->ExportField($this->fname);
					if ($this->mname->Exportable) $Doc->ExportField($this->mname);
					if ($this->lname->Exportable) $Doc->ExportField($this->lname);
					if ($this->phone->Exportable) $Doc->ExportField($this->phone);
					if ($this->aphone->Exportable) $Doc->ExportField($this->aphone);
					if ($this->msg->Exportable) $Doc->ExportField($this->msg);
					if ($this->city->Exportable) $Doc->ExportField($this->city);
					if ($this->rstate->Exportable) $Doc->ExportField($this->rstate);
					if ($this->dob->Exportable) $Doc->ExportField($this->dob);
					if ($this->gender->Exportable) $Doc->ExportField($this->gender);
					if ($this->lga->Exportable) $Doc->ExportField($this->lga);
					if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->employment_status->Exportable) $Doc->ExportField($this->employment_status);
					if ($this->employer->Exportable) $Doc->ExportField($this->employer);
					if ($this->employerphone->Exportable) $Doc->ExportField($this->employerphone);
					if ($this->employeraddr->Exportable) $Doc->ExportField($this->employeraddr);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
					if ($this->maidenname->Exportable) $Doc->ExportField($this->maidenname);
					if ($this->passport->Exportable) $Doc->ExportField($this->passport);
					if ($this->identification_type->Exportable) $Doc->ExportField($this->identification_type);
					if ($this->identification_number->Exportable) $Doc->ExportField($this->identification_number);
					if ($this->issuedate->Exportable) $Doc->ExportField($this->issuedate);
					if ($this->expirydate->Exportable) $Doc->ExportField($this->expirydate);
					if ($this->issuedplace->Exportable) $Doc->ExportField($this->issuedplace);
					if ($this->earning_type->Exportable) $Doc->ExportField($this->earning_type);
					if ($this->earning_note->Exportable) $Doc->ExportField($this->earning_note);
					if ($this->annual_income->Exportable) $Doc->ExportField($this->annual_income);
					if ($this->nameofcompany->Exportable) $Doc->ExportField($this->nameofcompany);
					if ($this->company_telephone->Exportable) $Doc->ExportField($this->company_telephone);
					if ($this->company_email->Exportable) $Doc->ExportField($this->company_email);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->salutation->Exportable) $Doc->ExportField($this->salutation);
					if ($this->fname->Exportable) $Doc->ExportField($this->fname);
					if ($this->mname->Exportable) $Doc->ExportField($this->mname);
					if ($this->lname->Exportable) $Doc->ExportField($this->lname);
					if ($this->phone->Exportable) $Doc->ExportField($this->phone);
					if ($this->aphone->Exportable) $Doc->ExportField($this->aphone);
					if ($this->msg->Exportable) $Doc->ExportField($this->msg);
					if ($this->city->Exportable) $Doc->ExportField($this->city);
					if ($this->rstate->Exportable) $Doc->ExportField($this->rstate);
					if ($this->dob->Exportable) $Doc->ExportField($this->dob);
					if ($this->gender->Exportable) $Doc->ExportField($this->gender);
					if ($this->lga->Exportable) $Doc->ExportField($this->lga);
					if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->employment_status->Exportable) $Doc->ExportField($this->employment_status);
					if ($this->employer->Exportable) $Doc->ExportField($this->employer);
					if ($this->employerphone->Exportable) $Doc->ExportField($this->employerphone);
					if ($this->employeraddr->Exportable) $Doc->ExportField($this->employeraddr);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
					if ($this->maidenname->Exportable) $Doc->ExportField($this->maidenname);
					if ($this->passport->Exportable) $Doc->ExportField($this->passport);
					if ($this->identification_type->Exportable) $Doc->ExportField($this->identification_type);
					if ($this->identification_number->Exportable) $Doc->ExportField($this->identification_number);
					if ($this->issuedate->Exportable) $Doc->ExportField($this->issuedate);
					if ($this->expirydate->Exportable) $Doc->ExportField($this->expirydate);
					if ($this->issuedplace->Exportable) $Doc->ExportField($this->issuedplace);
					if ($this->earning_type->Exportable) $Doc->ExportField($this->earning_type);
					if ($this->earning_note->Exportable) $Doc->ExportField($this->earning_note);
					if ($this->annual_income->Exportable) $Doc->ExportField($this->annual_income);
					if ($this->nameofcompany->Exportable) $Doc->ExportField($this->nameofcompany);
					if ($this->company_telephone->Exportable) $Doc->ExportField($this->company_telephone);
					if ($this->company_email->Exportable) $Doc->ExportField($this->company_email);
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
