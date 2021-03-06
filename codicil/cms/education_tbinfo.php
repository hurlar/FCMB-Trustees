<?php

// Global variable for table object
$education_tb = NULL;

//
// Table class for education_tb
//
class ceducation_tb extends cTable {
	var $id;
	var $uid;
	var $fullname;
	var $address;
	var $_email;
	var $maidenname;
	var $phoneno;
	var $aphoneno;
	var $maritalstatus;
	var $gender;
	var $dob;
	var $state;
	var $nationality;
	var $lga;
	var $employer;
	var $employerphone;
	var $employeraddr;
	var $idnumber;
	var $issuedate;
	var $employmentstatus;
	var $expirydate;
	var $datecreated;
	var $willtype;
	var $identificationtype;
	var $issueplace;
	var $spousename;
	var $spouseemail;
	var $spousephone;
	var $spousedob;
	var $spouseaddr;
	var $spousecity;
	var $spousestate;
	var $marriagetype;
	var $marriageyear;
	var $marriagecert;
	var $cityofmarriage;
	var $countryofmarriage;
	var $divorce;
	var $divorceyear;
	var $nextofkinfullname;
	var $nextofkintelephone;
	var $nextofkinemail;
	var $nextofkinaddress;
	var $nameofcompany;
	var $humanresourcescontacttelephone;
	var $humanresourcescontactemailaddress;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'education_tb';
		$this->TableName = 'education_tb';
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
		$this->id = new cField('education_tb', 'education_tb', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// uid
		$this->uid = new cField('education_tb', 'education_tb', 'x_uid', 'uid', '`uid`', '`uid`', 3, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->uid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['uid'] = &$this->uid;

		// fullname
		$this->fullname = new cField('education_tb', 'education_tb', 'x_fullname', 'fullname', '`fullname`', '`fullname`', 200, -1, FALSE, '`fullname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['fullname'] = &$this->fullname;

		// address
		$this->address = new cField('education_tb', 'education_tb', 'x_address', 'address', '`address`', '`address`', 201, -1, FALSE, '`address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['address'] = &$this->address;

		// email
		$this->_email = new cField('education_tb', 'education_tb', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['email'] = &$this->_email;

		// maidenname
		$this->maidenname = new cField('education_tb', 'education_tb', 'x_maidenname', 'maidenname', '`maidenname`', '`maidenname`', 200, -1, FALSE, '`maidenname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['maidenname'] = &$this->maidenname;

		// phoneno
		$this->phoneno = new cField('education_tb', 'education_tb', 'x_phoneno', 'phoneno', '`phoneno`', '`phoneno`', 200, -1, FALSE, '`phoneno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['phoneno'] = &$this->phoneno;

		// aphoneno
		$this->aphoneno = new cField('education_tb', 'education_tb', 'x_aphoneno', 'aphoneno', '`aphoneno`', '`aphoneno`', 200, -1, FALSE, '`aphoneno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['aphoneno'] = &$this->aphoneno;

		// maritalstatus
		$this->maritalstatus = new cField('education_tb', 'education_tb', 'x_maritalstatus', 'maritalstatus', '`maritalstatus`', '`maritalstatus`', 200, -1, FALSE, '`maritalstatus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['maritalstatus'] = &$this->maritalstatus;

		// gender
		$this->gender = new cField('education_tb', 'education_tb', 'x_gender', 'gender', '`gender`', '`gender`', 200, -1, FALSE, '`gender`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['gender'] = &$this->gender;

		// dob
		$this->dob = new cField('education_tb', 'education_tb', 'x_dob', 'dob', '`dob`', '`dob`', 200, -1, FALSE, '`dob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['dob'] = &$this->dob;

		// state
		$this->state = new cField('education_tb', 'education_tb', 'x_state', 'state', '`state`', '`state`', 200, -1, FALSE, '`state`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['state'] = &$this->state;

		// nationality
		$this->nationality = new cField('education_tb', 'education_tb', 'x_nationality', 'nationality', '`nationality`', '`nationality`', 200, -1, FALSE, '`nationality`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nationality'] = &$this->nationality;

		// lga
		$this->lga = new cField('education_tb', 'education_tb', 'x_lga', 'lga', '`lga`', '`lga`', 200, -1, FALSE, '`lga`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['lga'] = &$this->lga;

		// employer
		$this->employer = new cField('education_tb', 'education_tb', 'x_employer', 'employer', '`employer`', '`employer`', 201, -1, FALSE, '`employer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employer'] = &$this->employer;

		// employerphone
		$this->employerphone = new cField('education_tb', 'education_tb', 'x_employerphone', 'employerphone', '`employerphone`', '`employerphone`', 200, -1, FALSE, '`employerphone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employerphone'] = &$this->employerphone;

		// employeraddr
		$this->employeraddr = new cField('education_tb', 'education_tb', 'x_employeraddr', 'employeraddr', '`employeraddr`', '`employeraddr`', 201, -1, FALSE, '`employeraddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employeraddr'] = &$this->employeraddr;

		// idnumber
		$this->idnumber = new cField('education_tb', 'education_tb', 'x_idnumber', 'idnumber', '`idnumber`', '`idnumber`', 200, -1, FALSE, '`idnumber`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['idnumber'] = &$this->idnumber;

		// issuedate
		$this->issuedate = new cField('education_tb', 'education_tb', 'x_issuedate', 'issuedate', '`issuedate`', '`issuedate`', 200, -1, FALSE, '`issuedate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['issuedate'] = &$this->issuedate;

		// employmentstatus
		$this->employmentstatus = new cField('education_tb', 'education_tb', 'x_employmentstatus', 'employmentstatus', '`employmentstatus`', '`employmentstatus`', 200, -1, FALSE, '`employmentstatus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['employmentstatus'] = &$this->employmentstatus;

		// expirydate
		$this->expirydate = new cField('education_tb', 'education_tb', 'x_expirydate', 'expirydate', '`expirydate`', '`expirydate`', 200, -1, FALSE, '`expirydate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['expirydate'] = &$this->expirydate;

		// datecreated
		$this->datecreated = new cField('education_tb', 'education_tb', 'x_datecreated', 'datecreated', '`datecreated`', 'DATE_FORMAT(`datecreated`, \'%d/%m/%y\')', 135, -1, FALSE, '`datecreated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['datecreated'] = &$this->datecreated;

		// willtype
		$this->willtype = new cField('education_tb', 'education_tb', 'x_willtype', 'willtype', '`willtype`', '`willtype`', 200, -1, FALSE, '`willtype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['willtype'] = &$this->willtype;

		// identificationtype
		$this->identificationtype = new cField('education_tb', 'education_tb', 'x_identificationtype', 'identificationtype', '`identificationtype`', '`identificationtype`', 200, -1, FALSE, '`identificationtype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['identificationtype'] = &$this->identificationtype;

		// issueplace
		$this->issueplace = new cField('education_tb', 'education_tb', 'x_issueplace', 'issueplace', '`issueplace`', '`issueplace`', 200, -1, FALSE, '`issueplace`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['issueplace'] = &$this->issueplace;

		// spousename
		$this->spousename = new cField('education_tb', 'education_tb', 'x_spousename', 'spousename', '`spousename`', '`spousename`', 200, -1, FALSE, '`spousename`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spousename'] = &$this->spousename;

		// spouseemail
		$this->spouseemail = new cField('education_tb', 'education_tb', 'x_spouseemail', 'spouseemail', '`spouseemail`', '`spouseemail`', 200, -1, FALSE, '`spouseemail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spouseemail'] = &$this->spouseemail;

		// spousephone
		$this->spousephone = new cField('education_tb', 'education_tb', 'x_spousephone', 'spousephone', '`spousephone`', '`spousephone`', 200, -1, FALSE, '`spousephone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spousephone'] = &$this->spousephone;

		// spousedob
		$this->spousedob = new cField('education_tb', 'education_tb', 'x_spousedob', 'spousedob', '`spousedob`', '`spousedob`', 200, -1, FALSE, '`spousedob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spousedob'] = &$this->spousedob;

		// spouseaddr
		$this->spouseaddr = new cField('education_tb', 'education_tb', 'x_spouseaddr', 'spouseaddr', '`spouseaddr`', '`spouseaddr`', 201, -1, FALSE, '`spouseaddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spouseaddr'] = &$this->spouseaddr;

		// spousecity
		$this->spousecity = new cField('education_tb', 'education_tb', 'x_spousecity', 'spousecity', '`spousecity`', '`spousecity`', 200, -1, FALSE, '`spousecity`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spousecity'] = &$this->spousecity;

		// spousestate
		$this->spousestate = new cField('education_tb', 'education_tb', 'x_spousestate', 'spousestate', '`spousestate`', '`spousestate`', 200, -1, FALSE, '`spousestate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['spousestate'] = &$this->spousestate;

		// marriagetype
		$this->marriagetype = new cField('education_tb', 'education_tb', 'x_marriagetype', 'marriagetype', '`marriagetype`', '`marriagetype`', 200, -1, FALSE, '`marriagetype`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriagetype'] = &$this->marriagetype;

		// marriageyear
		$this->marriageyear = new cField('education_tb', 'education_tb', 'x_marriageyear', 'marriageyear', '`marriageyear`', '`marriageyear`', 200, -1, FALSE, '`marriageyear`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriageyear'] = &$this->marriageyear;

		// marriagecert
		$this->marriagecert = new cField('education_tb', 'education_tb', 'x_marriagecert', 'marriagecert', '`marriagecert`', '`marriagecert`', 200, -1, FALSE, '`marriagecert`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['marriagecert'] = &$this->marriagecert;

		// cityofmarriage
		$this->cityofmarriage = new cField('education_tb', 'education_tb', 'x_cityofmarriage', 'cityofmarriage', '`cityofmarriage`', '`cityofmarriage`', 200, -1, FALSE, '`cityofmarriage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cityofmarriage'] = &$this->cityofmarriage;

		// countryofmarriage
		$this->countryofmarriage = new cField('education_tb', 'education_tb', 'x_countryofmarriage', 'countryofmarriage', '`countryofmarriage`', '`countryofmarriage`', 200, -1, FALSE, '`countryofmarriage`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['countryofmarriage'] = &$this->countryofmarriage;

		// divorce
		$this->divorce = new cField('education_tb', 'education_tb', 'x_divorce', 'divorce', '`divorce`', '`divorce`', 200, -1, FALSE, '`divorce`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['divorce'] = &$this->divorce;

		// divorceyear
		$this->divorceyear = new cField('education_tb', 'education_tb', 'x_divorceyear', 'divorceyear', '`divorceyear`', '`divorceyear`', 200, -1, FALSE, '`divorceyear`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['divorceyear'] = &$this->divorceyear;

		// nextofkinfullname
		$this->nextofkinfullname = new cField('education_tb', 'education_tb', 'x_nextofkinfullname', 'nextofkinfullname', '`nextofkinfullname`', '`nextofkinfullname`', 200, -1, FALSE, '`nextofkinfullname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nextofkinfullname'] = &$this->nextofkinfullname;

		// nextofkintelephone
		$this->nextofkintelephone = new cField('education_tb', 'education_tb', 'x_nextofkintelephone', 'nextofkintelephone', '`nextofkintelephone`', '`nextofkintelephone`', 200, -1, FALSE, '`nextofkintelephone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nextofkintelephone'] = &$this->nextofkintelephone;

		// nextofkinemail
		$this->nextofkinemail = new cField('education_tb', 'education_tb', 'x_nextofkinemail', 'nextofkinemail', '`nextofkinemail`', '`nextofkinemail`', 200, -1, FALSE, '`nextofkinemail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nextofkinemail'] = &$this->nextofkinemail;

		// nextofkinaddress
		$this->nextofkinaddress = new cField('education_tb', 'education_tb', 'x_nextofkinaddress', 'nextofkinaddress', '`nextofkinaddress`', '`nextofkinaddress`', 201, -1, FALSE, '`nextofkinaddress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nextofkinaddress'] = &$this->nextofkinaddress;

		// nameofcompany
		$this->nameofcompany = new cField('education_tb', 'education_tb', 'x_nameofcompany', 'nameofcompany', '`nameofcompany`', '`nameofcompany`', 200, -1, FALSE, '`nameofcompany`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['nameofcompany'] = &$this->nameofcompany;

		// humanresourcescontacttelephone
		$this->humanresourcescontacttelephone = new cField('education_tb', 'education_tb', 'x_humanresourcescontacttelephone', 'humanresourcescontacttelephone', '`humanresourcescontacttelephone`', '`humanresourcescontacttelephone`', 200, -1, FALSE, '`humanresourcescontacttelephone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['humanresourcescontacttelephone'] = &$this->humanresourcescontacttelephone;

		// humanresourcescontactemailaddress
		$this->humanresourcescontactemailaddress = new cField('education_tb', 'education_tb', 'x_humanresourcescontactemailaddress', 'humanresourcescontactemailaddress', '`humanresourcescontactemailaddress`', '`humanresourcescontactemailaddress`', 200, -1, FALSE, '`humanresourcescontactemailaddress`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['humanresourcescontactemailaddress'] = &$this->humanresourcescontactemailaddress;
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
		return "`education_tb`";
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
	var $UpdateTable = "`education_tb`";

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
			return "education_tblist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "education_tblist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("education_tbview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("education_tbview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "education_tbadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("education_tbedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("education_tbadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("education_tbdelete.php", $this->UrlParm());
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
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->address->setDbValue($rs->fields('address'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->maidenname->setDbValue($rs->fields('maidenname'));
		$this->phoneno->setDbValue($rs->fields('phoneno'));
		$this->aphoneno->setDbValue($rs->fields('aphoneno'));
		$this->maritalstatus->setDbValue($rs->fields('maritalstatus'));
		$this->gender->setDbValue($rs->fields('gender'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->state->setDbValue($rs->fields('state'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->lga->setDbValue($rs->fields('lga'));
		$this->employer->setDbValue($rs->fields('employer'));
		$this->employerphone->setDbValue($rs->fields('employerphone'));
		$this->employeraddr->setDbValue($rs->fields('employeraddr'));
		$this->idnumber->setDbValue($rs->fields('idnumber'));
		$this->issuedate->setDbValue($rs->fields('issuedate'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->willtype->setDbValue($rs->fields('willtype'));
		$this->identificationtype->setDbValue($rs->fields('identificationtype'));
		$this->issueplace->setDbValue($rs->fields('issueplace'));
		$this->spousename->setDbValue($rs->fields('spousename'));
		$this->spouseemail->setDbValue($rs->fields('spouseemail'));
		$this->spousephone->setDbValue($rs->fields('spousephone'));
		$this->spousedob->setDbValue($rs->fields('spousedob'));
		$this->spouseaddr->setDbValue($rs->fields('spouseaddr'));
		$this->spousecity->setDbValue($rs->fields('spousecity'));
		$this->spousestate->setDbValue($rs->fields('spousestate'));
		$this->marriagetype->setDbValue($rs->fields('marriagetype'));
		$this->marriageyear->setDbValue($rs->fields('marriageyear'));
		$this->marriagecert->setDbValue($rs->fields('marriagecert'));
		$this->cityofmarriage->setDbValue($rs->fields('cityofmarriage'));
		$this->countryofmarriage->setDbValue($rs->fields('countryofmarriage'));
		$this->divorce->setDbValue($rs->fields('divorce'));
		$this->divorceyear->setDbValue($rs->fields('divorceyear'));
		$this->nextofkinfullname->setDbValue($rs->fields('nextofkinfullname'));
		$this->nextofkintelephone->setDbValue($rs->fields('nextofkintelephone'));
		$this->nextofkinemail->setDbValue($rs->fields('nextofkinemail'));
		$this->nextofkinaddress->setDbValue($rs->fields('nextofkinaddress'));
		$this->nameofcompany->setDbValue($rs->fields('nameofcompany'));
		$this->humanresourcescontacttelephone->setDbValue($rs->fields('humanresourcescontacttelephone'));
		$this->humanresourcescontactemailaddress->setDbValue($rs->fields('humanresourcescontactemailaddress'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// uid
		// fullname
		// address
		// email
		// maidenname
		// phoneno
		// aphoneno
		// maritalstatus
		// gender
		// dob
		// state
		// nationality
		// lga
		// employer
		// employerphone
		// employeraddr
		// idnumber
		// issuedate
		// employmentstatus
		// expirydate
		// datecreated
		// willtype
		// identificationtype
		// issueplace
		// spousename
		// spouseemail
		// spousephone
		// spousedob
		// spouseaddr
		// spousecity
		// spousestate
		// marriagetype
		// marriageyear
		// marriagecert
		// cityofmarriage
		// countryofmarriage
		// divorce
		// divorceyear
		// nextofkinfullname
		// nextofkintelephone
		// nextofkinemail
		// nextofkinaddress
		// nameofcompany
		// humanresourcescontacttelephone
		// humanresourcescontactemailaddress
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// fullname
		$this->fullname->ViewValue = $this->fullname->CurrentValue;
		$this->fullname->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// maidenname
		$this->maidenname->ViewValue = $this->maidenname->CurrentValue;
		$this->maidenname->ViewCustomAttributes = "";

		// phoneno
		$this->phoneno->ViewValue = $this->phoneno->CurrentValue;
		$this->phoneno->ViewCustomAttributes = "";

		// aphoneno
		$this->aphoneno->ViewValue = $this->aphoneno->CurrentValue;
		$this->aphoneno->ViewCustomAttributes = "";

		// maritalstatus
		$this->maritalstatus->ViewValue = $this->maritalstatus->CurrentValue;
		$this->maritalstatus->ViewCustomAttributes = "";

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

		// employer
		$this->employer->ViewValue = $this->employer->CurrentValue;
		$this->employer->ViewCustomAttributes = "";

		// employerphone
		$this->employerphone->ViewValue = $this->employerphone->CurrentValue;
		$this->employerphone->ViewCustomAttributes = "";

		// employeraddr
		$this->employeraddr->ViewValue = $this->employeraddr->CurrentValue;
		$this->employeraddr->ViewCustomAttributes = "";

		// idnumber
		$this->idnumber->ViewValue = $this->idnumber->CurrentValue;
		$this->idnumber->ViewCustomAttributes = "";

		// issuedate
		$this->issuedate->ViewValue = $this->issuedate->CurrentValue;
		$this->issuedate->ViewCustomAttributes = "";

		// employmentstatus
		$this->employmentstatus->ViewValue = $this->employmentstatus->CurrentValue;
		$this->employmentstatus->ViewCustomAttributes = "";

		// expirydate
		$this->expirydate->ViewValue = $this->expirydate->CurrentValue;
		$this->expirydate->ViewCustomAttributes = "";

		// datecreated
		$this->datecreated->ViewValue = $this->datecreated->CurrentValue;
		$this->datecreated->ViewCustomAttributes = "";

		// willtype
		$this->willtype->ViewValue = $this->willtype->CurrentValue;
		$this->willtype->ViewCustomAttributes = "";

		// identificationtype
		$this->identificationtype->ViewValue = $this->identificationtype->CurrentValue;
		$this->identificationtype->ViewCustomAttributes = "";

		// issueplace
		$this->issueplace->ViewValue = $this->issueplace->CurrentValue;
		$this->issueplace->ViewCustomAttributes = "";

		// spousename
		$this->spousename->ViewValue = $this->spousename->CurrentValue;
		$this->spousename->ViewCustomAttributes = "";

		// spouseemail
		$this->spouseemail->ViewValue = $this->spouseemail->CurrentValue;
		$this->spouseemail->ViewCustomAttributes = "";

		// spousephone
		$this->spousephone->ViewValue = $this->spousephone->CurrentValue;
		$this->spousephone->ViewCustomAttributes = "";

		// spousedob
		$this->spousedob->ViewValue = $this->spousedob->CurrentValue;
		$this->spousedob->ViewCustomAttributes = "";

		// spouseaddr
		$this->spouseaddr->ViewValue = $this->spouseaddr->CurrentValue;
		$this->spouseaddr->ViewCustomAttributes = "";

		// spousecity
		$this->spousecity->ViewValue = $this->spousecity->CurrentValue;
		$this->spousecity->ViewCustomAttributes = "";

		// spousestate
		$this->spousestate->ViewValue = $this->spousestate->CurrentValue;
		$this->spousestate->ViewCustomAttributes = "";

		// marriagetype
		$this->marriagetype->ViewValue = $this->marriagetype->CurrentValue;
		$this->marriagetype->ViewCustomAttributes = "";

		// marriageyear
		$this->marriageyear->ViewValue = $this->marriageyear->CurrentValue;
		$this->marriageyear->ViewCustomAttributes = "";

		// marriagecert
		$this->marriagecert->ViewValue = $this->marriagecert->CurrentValue;
		$this->marriagecert->ViewCustomAttributes = "";

		// cityofmarriage
		$this->cityofmarriage->ViewValue = $this->cityofmarriage->CurrentValue;
		$this->cityofmarriage->ViewCustomAttributes = "";

		// countryofmarriage
		$this->countryofmarriage->ViewValue = $this->countryofmarriage->CurrentValue;
		$this->countryofmarriage->ViewCustomAttributes = "";

		// divorce
		$this->divorce->ViewValue = $this->divorce->CurrentValue;
		$this->divorce->ViewCustomAttributes = "";

		// divorceyear
		$this->divorceyear->ViewValue = $this->divorceyear->CurrentValue;
		$this->divorceyear->ViewCustomAttributes = "";

		// nextofkinfullname
		$this->nextofkinfullname->ViewValue = $this->nextofkinfullname->CurrentValue;
		$this->nextofkinfullname->ViewCustomAttributes = "";

		// nextofkintelephone
		$this->nextofkintelephone->ViewValue = $this->nextofkintelephone->CurrentValue;
		$this->nextofkintelephone->ViewCustomAttributes = "";

		// nextofkinemail
		$this->nextofkinemail->ViewValue = $this->nextofkinemail->CurrentValue;
		$this->nextofkinemail->ViewCustomAttributes = "";

		// nextofkinaddress
		$this->nextofkinaddress->ViewValue = $this->nextofkinaddress->CurrentValue;
		$this->nextofkinaddress->ViewCustomAttributes = "";

		// nameofcompany
		$this->nameofcompany->ViewValue = $this->nameofcompany->CurrentValue;
		$this->nameofcompany->ViewCustomAttributes = "";

		// humanresourcescontacttelephone
		$this->humanresourcescontacttelephone->ViewValue = $this->humanresourcescontacttelephone->CurrentValue;
		$this->humanresourcescontacttelephone->ViewCustomAttributes = "";

		// humanresourcescontactemailaddress
		$this->humanresourcescontactemailaddress->ViewValue = $this->humanresourcescontactemailaddress->CurrentValue;
		$this->humanresourcescontactemailaddress->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// fullname
		$this->fullname->LinkCustomAttributes = "";
		$this->fullname->HrefValue = "";
		$this->fullname->TooltipValue = "";

		// address
		$this->address->LinkCustomAttributes = "";
		$this->address->HrefValue = "";
		$this->address->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// maidenname
		$this->maidenname->LinkCustomAttributes = "";
		$this->maidenname->HrefValue = "";
		$this->maidenname->TooltipValue = "";

		// phoneno
		$this->phoneno->LinkCustomAttributes = "";
		$this->phoneno->HrefValue = "";
		$this->phoneno->TooltipValue = "";

		// aphoneno
		$this->aphoneno->LinkCustomAttributes = "";
		$this->aphoneno->HrefValue = "";
		$this->aphoneno->TooltipValue = "";

		// maritalstatus
		$this->maritalstatus->LinkCustomAttributes = "";
		$this->maritalstatus->HrefValue = "";
		$this->maritalstatus->TooltipValue = "";

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

		// idnumber
		$this->idnumber->LinkCustomAttributes = "";
		$this->idnumber->HrefValue = "";
		$this->idnumber->TooltipValue = "";

		// issuedate
		$this->issuedate->LinkCustomAttributes = "";
		$this->issuedate->HrefValue = "";
		$this->issuedate->TooltipValue = "";

		// employmentstatus
		$this->employmentstatus->LinkCustomAttributes = "";
		$this->employmentstatus->HrefValue = "";
		$this->employmentstatus->TooltipValue = "";

		// expirydate
		$this->expirydate->LinkCustomAttributes = "";
		$this->expirydate->HrefValue = "";
		$this->expirydate->TooltipValue = "";

		// datecreated
		$this->datecreated->LinkCustomAttributes = "";
		$this->datecreated->HrefValue = "";
		$this->datecreated->TooltipValue = "";

		// willtype
		$this->willtype->LinkCustomAttributes = "";
		$this->willtype->HrefValue = "";
		$this->willtype->TooltipValue = "";

		// identificationtype
		$this->identificationtype->LinkCustomAttributes = "";
		$this->identificationtype->HrefValue = "";
		$this->identificationtype->TooltipValue = "";

		// issueplace
		$this->issueplace->LinkCustomAttributes = "";
		$this->issueplace->HrefValue = "";
		$this->issueplace->TooltipValue = "";

		// spousename
		$this->spousename->LinkCustomAttributes = "";
		$this->spousename->HrefValue = "";
		$this->spousename->TooltipValue = "";

		// spouseemail
		$this->spouseemail->LinkCustomAttributes = "";
		$this->spouseemail->HrefValue = "";
		$this->spouseemail->TooltipValue = "";

		// spousephone
		$this->spousephone->LinkCustomAttributes = "";
		$this->spousephone->HrefValue = "";
		$this->spousephone->TooltipValue = "";

		// spousedob
		$this->spousedob->LinkCustomAttributes = "";
		$this->spousedob->HrefValue = "";
		$this->spousedob->TooltipValue = "";

		// spouseaddr
		$this->spouseaddr->LinkCustomAttributes = "";
		$this->spouseaddr->HrefValue = "";
		$this->spouseaddr->TooltipValue = "";

		// spousecity
		$this->spousecity->LinkCustomAttributes = "";
		$this->spousecity->HrefValue = "";
		$this->spousecity->TooltipValue = "";

		// spousestate
		$this->spousestate->LinkCustomAttributes = "";
		$this->spousestate->HrefValue = "";
		$this->spousestate->TooltipValue = "";

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

		// cityofmarriage
		$this->cityofmarriage->LinkCustomAttributes = "";
		$this->cityofmarriage->HrefValue = "";
		$this->cityofmarriage->TooltipValue = "";

		// countryofmarriage
		$this->countryofmarriage->LinkCustomAttributes = "";
		$this->countryofmarriage->HrefValue = "";
		$this->countryofmarriage->TooltipValue = "";

		// divorce
		$this->divorce->LinkCustomAttributes = "";
		$this->divorce->HrefValue = "";
		$this->divorce->TooltipValue = "";

		// divorceyear
		$this->divorceyear->LinkCustomAttributes = "";
		$this->divorceyear->HrefValue = "";
		$this->divorceyear->TooltipValue = "";

		// nextofkinfullname
		$this->nextofkinfullname->LinkCustomAttributes = "";
		$this->nextofkinfullname->HrefValue = "";
		$this->nextofkinfullname->TooltipValue = "";

		// nextofkintelephone
		$this->nextofkintelephone->LinkCustomAttributes = "";
		$this->nextofkintelephone->HrefValue = "";
		$this->nextofkintelephone->TooltipValue = "";

		// nextofkinemail
		$this->nextofkinemail->LinkCustomAttributes = "";
		$this->nextofkinemail->HrefValue = "";
		$this->nextofkinemail->TooltipValue = "";

		// nextofkinaddress
		$this->nextofkinaddress->LinkCustomAttributes = "";
		$this->nextofkinaddress->HrefValue = "";
		$this->nextofkinaddress->TooltipValue = "";

		// nameofcompany
		$this->nameofcompany->LinkCustomAttributes = "";
		$this->nameofcompany->HrefValue = "";
		$this->nameofcompany->TooltipValue = "";

		// humanresourcescontacttelephone
		$this->humanresourcescontacttelephone->LinkCustomAttributes = "";
		$this->humanresourcescontacttelephone->HrefValue = "";
		$this->humanresourcescontacttelephone->TooltipValue = "";

		// humanresourcescontactemailaddress
		$this->humanresourcescontactemailaddress->LinkCustomAttributes = "";
		$this->humanresourcescontactemailaddress->HrefValue = "";
		$this->humanresourcescontactemailaddress->TooltipValue = "";

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
				if ($this->fullname->Exportable) $Doc->ExportCaption($this->fullname);
				if ($this->address->Exportable) $Doc->ExportCaption($this->address);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->maidenname->Exportable) $Doc->ExportCaption($this->maidenname);
				if ($this->phoneno->Exportable) $Doc->ExportCaption($this->phoneno);
				if ($this->aphoneno->Exportable) $Doc->ExportCaption($this->aphoneno);
				if ($this->maritalstatus->Exportable) $Doc->ExportCaption($this->maritalstatus);
				if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
				if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
				if ($this->lga->Exportable) $Doc->ExportCaption($this->lga);
				if ($this->employer->Exportable) $Doc->ExportCaption($this->employer);
				if ($this->employerphone->Exportable) $Doc->ExportCaption($this->employerphone);
				if ($this->employeraddr->Exportable) $Doc->ExportCaption($this->employeraddr);
				if ($this->idnumber->Exportable) $Doc->ExportCaption($this->idnumber);
				if ($this->issuedate->Exportable) $Doc->ExportCaption($this->issuedate);
				if ($this->employmentstatus->Exportable) $Doc->ExportCaption($this->employmentstatus);
				if ($this->expirydate->Exportable) $Doc->ExportCaption($this->expirydate);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
				if ($this->willtype->Exportable) $Doc->ExportCaption($this->willtype);
				if ($this->identificationtype->Exportable) $Doc->ExportCaption($this->identificationtype);
				if ($this->issueplace->Exportable) $Doc->ExportCaption($this->issueplace);
				if ($this->spousename->Exportable) $Doc->ExportCaption($this->spousename);
				if ($this->spouseemail->Exportable) $Doc->ExportCaption($this->spouseemail);
				if ($this->spousephone->Exportable) $Doc->ExportCaption($this->spousephone);
				if ($this->spousedob->Exportable) $Doc->ExportCaption($this->spousedob);
				if ($this->spouseaddr->Exportable) $Doc->ExportCaption($this->spouseaddr);
				if ($this->spousecity->Exportable) $Doc->ExportCaption($this->spousecity);
				if ($this->spousestate->Exportable) $Doc->ExportCaption($this->spousestate);
				if ($this->marriagetype->Exportable) $Doc->ExportCaption($this->marriagetype);
				if ($this->marriageyear->Exportable) $Doc->ExportCaption($this->marriageyear);
				if ($this->marriagecert->Exportable) $Doc->ExportCaption($this->marriagecert);
				if ($this->cityofmarriage->Exportable) $Doc->ExportCaption($this->cityofmarriage);
				if ($this->countryofmarriage->Exportable) $Doc->ExportCaption($this->countryofmarriage);
				if ($this->divorce->Exportable) $Doc->ExportCaption($this->divorce);
				if ($this->divorceyear->Exportable) $Doc->ExportCaption($this->divorceyear);
				if ($this->nextofkinfullname->Exportable) $Doc->ExportCaption($this->nextofkinfullname);
				if ($this->nextofkintelephone->Exportable) $Doc->ExportCaption($this->nextofkintelephone);
				if ($this->nextofkinemail->Exportable) $Doc->ExportCaption($this->nextofkinemail);
				if ($this->nextofkinaddress->Exportable) $Doc->ExportCaption($this->nextofkinaddress);
				if ($this->nameofcompany->Exportable) $Doc->ExportCaption($this->nameofcompany);
				if ($this->humanresourcescontacttelephone->Exportable) $Doc->ExportCaption($this->humanresourcescontacttelephone);
				if ($this->humanresourcescontactemailaddress->Exportable) $Doc->ExportCaption($this->humanresourcescontactemailaddress);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->fullname->Exportable) $Doc->ExportCaption($this->fullname);
				if ($this->address->Exportable) $Doc->ExportCaption($this->address);
				if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
				if ($this->maidenname->Exportable) $Doc->ExportCaption($this->maidenname);
				if ($this->phoneno->Exportable) $Doc->ExportCaption($this->phoneno);
				if ($this->aphoneno->Exportable) $Doc->ExportCaption($this->aphoneno);
				if ($this->maritalstatus->Exportable) $Doc->ExportCaption($this->maritalstatus);
				if ($this->gender->Exportable) $Doc->ExportCaption($this->gender);
				if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
				if ($this->state->Exportable) $Doc->ExportCaption($this->state);
				if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
				if ($this->lga->Exportable) $Doc->ExportCaption($this->lga);
				if ($this->employer->Exportable) $Doc->ExportCaption($this->employer);
				if ($this->employerphone->Exportable) $Doc->ExportCaption($this->employerphone);
				if ($this->employeraddr->Exportable) $Doc->ExportCaption($this->employeraddr);
				if ($this->idnumber->Exportable) $Doc->ExportCaption($this->idnumber);
				if ($this->issuedate->Exportable) $Doc->ExportCaption($this->issuedate);
				if ($this->employmentstatus->Exportable) $Doc->ExportCaption($this->employmentstatus);
				if ($this->expirydate->Exportable) $Doc->ExportCaption($this->expirydate);
				if ($this->datecreated->Exportable) $Doc->ExportCaption($this->datecreated);
				if ($this->willtype->Exportable) $Doc->ExportCaption($this->willtype);
				if ($this->identificationtype->Exportable) $Doc->ExportCaption($this->identificationtype);
				if ($this->issueplace->Exportable) $Doc->ExportCaption($this->issueplace);
				if ($this->spousename->Exportable) $Doc->ExportCaption($this->spousename);
				if ($this->spouseemail->Exportable) $Doc->ExportCaption($this->spouseemail);
				if ($this->spousephone->Exportable) $Doc->ExportCaption($this->spousephone);
				if ($this->spousedob->Exportable) $Doc->ExportCaption($this->spousedob);
				if ($this->spouseaddr->Exportable) $Doc->ExportCaption($this->spouseaddr);
				if ($this->spousecity->Exportable) $Doc->ExportCaption($this->spousecity);
				if ($this->spousestate->Exportable) $Doc->ExportCaption($this->spousestate);
				if ($this->marriagetype->Exportable) $Doc->ExportCaption($this->marriagetype);
				if ($this->marriageyear->Exportable) $Doc->ExportCaption($this->marriageyear);
				if ($this->marriagecert->Exportable) $Doc->ExportCaption($this->marriagecert);
				if ($this->cityofmarriage->Exportable) $Doc->ExportCaption($this->cityofmarriage);
				if ($this->countryofmarriage->Exportable) $Doc->ExportCaption($this->countryofmarriage);
				if ($this->divorce->Exportable) $Doc->ExportCaption($this->divorce);
				if ($this->divorceyear->Exportable) $Doc->ExportCaption($this->divorceyear);
				if ($this->nextofkinfullname->Exportable) $Doc->ExportCaption($this->nextofkinfullname);
				if ($this->nextofkintelephone->Exportable) $Doc->ExportCaption($this->nextofkintelephone);
				if ($this->nextofkinemail->Exportable) $Doc->ExportCaption($this->nextofkinemail);
				if ($this->nextofkinaddress->Exportable) $Doc->ExportCaption($this->nextofkinaddress);
				if ($this->nameofcompany->Exportable) $Doc->ExportCaption($this->nameofcompany);
				if ($this->humanresourcescontacttelephone->Exportable) $Doc->ExportCaption($this->humanresourcescontacttelephone);
				if ($this->humanresourcescontactemailaddress->Exportable) $Doc->ExportCaption($this->humanresourcescontactemailaddress);
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
					if ($this->fullname->Exportable) $Doc->ExportField($this->fullname);
					if ($this->address->Exportable) $Doc->ExportField($this->address);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->maidenname->Exportable) $Doc->ExportField($this->maidenname);
					if ($this->phoneno->Exportable) $Doc->ExportField($this->phoneno);
					if ($this->aphoneno->Exportable) $Doc->ExportField($this->aphoneno);
					if ($this->maritalstatus->Exportable) $Doc->ExportField($this->maritalstatus);
					if ($this->gender->Exportable) $Doc->ExportField($this->gender);
					if ($this->dob->Exportable) $Doc->ExportField($this->dob);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
					if ($this->lga->Exportable) $Doc->ExportField($this->lga);
					if ($this->employer->Exportable) $Doc->ExportField($this->employer);
					if ($this->employerphone->Exportable) $Doc->ExportField($this->employerphone);
					if ($this->employeraddr->Exportable) $Doc->ExportField($this->employeraddr);
					if ($this->idnumber->Exportable) $Doc->ExportField($this->idnumber);
					if ($this->issuedate->Exportable) $Doc->ExportField($this->issuedate);
					if ($this->employmentstatus->Exportable) $Doc->ExportField($this->employmentstatus);
					if ($this->expirydate->Exportable) $Doc->ExportField($this->expirydate);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
					if ($this->willtype->Exportable) $Doc->ExportField($this->willtype);
					if ($this->identificationtype->Exportable) $Doc->ExportField($this->identificationtype);
					if ($this->issueplace->Exportable) $Doc->ExportField($this->issueplace);
					if ($this->spousename->Exportable) $Doc->ExportField($this->spousename);
					if ($this->spouseemail->Exportable) $Doc->ExportField($this->spouseemail);
					if ($this->spousephone->Exportable) $Doc->ExportField($this->spousephone);
					if ($this->spousedob->Exportable) $Doc->ExportField($this->spousedob);
					if ($this->spouseaddr->Exportable) $Doc->ExportField($this->spouseaddr);
					if ($this->spousecity->Exportable) $Doc->ExportField($this->spousecity);
					if ($this->spousestate->Exportable) $Doc->ExportField($this->spousestate);
					if ($this->marriagetype->Exportable) $Doc->ExportField($this->marriagetype);
					if ($this->marriageyear->Exportable) $Doc->ExportField($this->marriageyear);
					if ($this->marriagecert->Exportable) $Doc->ExportField($this->marriagecert);
					if ($this->cityofmarriage->Exportable) $Doc->ExportField($this->cityofmarriage);
					if ($this->countryofmarriage->Exportable) $Doc->ExportField($this->countryofmarriage);
					if ($this->divorce->Exportable) $Doc->ExportField($this->divorce);
					if ($this->divorceyear->Exportable) $Doc->ExportField($this->divorceyear);
					if ($this->nextofkinfullname->Exportable) $Doc->ExportField($this->nextofkinfullname);
					if ($this->nextofkintelephone->Exportable) $Doc->ExportField($this->nextofkintelephone);
					if ($this->nextofkinemail->Exportable) $Doc->ExportField($this->nextofkinemail);
					if ($this->nextofkinaddress->Exportable) $Doc->ExportField($this->nextofkinaddress);
					if ($this->nameofcompany->Exportable) $Doc->ExportField($this->nameofcompany);
					if ($this->humanresourcescontacttelephone->Exportable) $Doc->ExportField($this->humanresourcescontacttelephone);
					if ($this->humanresourcescontactemailaddress->Exportable) $Doc->ExportField($this->humanresourcescontactemailaddress);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->fullname->Exportable) $Doc->ExportField($this->fullname);
					if ($this->address->Exportable) $Doc->ExportField($this->address);
					if ($this->_email->Exportable) $Doc->ExportField($this->_email);
					if ($this->maidenname->Exportable) $Doc->ExportField($this->maidenname);
					if ($this->phoneno->Exportable) $Doc->ExportField($this->phoneno);
					if ($this->aphoneno->Exportable) $Doc->ExportField($this->aphoneno);
					if ($this->maritalstatus->Exportable) $Doc->ExportField($this->maritalstatus);
					if ($this->gender->Exportable) $Doc->ExportField($this->gender);
					if ($this->dob->Exportable) $Doc->ExportField($this->dob);
					if ($this->state->Exportable) $Doc->ExportField($this->state);
					if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
					if ($this->lga->Exportable) $Doc->ExportField($this->lga);
					if ($this->employer->Exportable) $Doc->ExportField($this->employer);
					if ($this->employerphone->Exportable) $Doc->ExportField($this->employerphone);
					if ($this->employeraddr->Exportable) $Doc->ExportField($this->employeraddr);
					if ($this->idnumber->Exportable) $Doc->ExportField($this->idnumber);
					if ($this->issuedate->Exportable) $Doc->ExportField($this->issuedate);
					if ($this->employmentstatus->Exportable) $Doc->ExportField($this->employmentstatus);
					if ($this->expirydate->Exportable) $Doc->ExportField($this->expirydate);
					if ($this->datecreated->Exportable) $Doc->ExportField($this->datecreated);
					if ($this->willtype->Exportable) $Doc->ExportField($this->willtype);
					if ($this->identificationtype->Exportable) $Doc->ExportField($this->identificationtype);
					if ($this->issueplace->Exportable) $Doc->ExportField($this->issueplace);
					if ($this->spousename->Exportable) $Doc->ExportField($this->spousename);
					if ($this->spouseemail->Exportable) $Doc->ExportField($this->spouseemail);
					if ($this->spousephone->Exportable) $Doc->ExportField($this->spousephone);
					if ($this->spousedob->Exportable) $Doc->ExportField($this->spousedob);
					if ($this->spouseaddr->Exportable) $Doc->ExportField($this->spouseaddr);
					if ($this->spousecity->Exportable) $Doc->ExportField($this->spousecity);
					if ($this->spousestate->Exportable) $Doc->ExportField($this->spousestate);
					if ($this->marriagetype->Exportable) $Doc->ExportField($this->marriagetype);
					if ($this->marriageyear->Exportable) $Doc->ExportField($this->marriageyear);
					if ($this->marriagecert->Exportable) $Doc->ExportField($this->marriagecert);
					if ($this->cityofmarriage->Exportable) $Doc->ExportField($this->cityofmarriage);
					if ($this->countryofmarriage->Exportable) $Doc->ExportField($this->countryofmarriage);
					if ($this->divorce->Exportable) $Doc->ExportField($this->divorce);
					if ($this->divorceyear->Exportable) $Doc->ExportField($this->divorceyear);
					if ($this->nextofkinfullname->Exportable) $Doc->ExportField($this->nextofkinfullname);
					if ($this->nextofkintelephone->Exportable) $Doc->ExportField($this->nextofkintelephone);
					if ($this->nextofkinemail->Exportable) $Doc->ExportField($this->nextofkinemail);
					if ($this->nextofkinaddress->Exportable) $Doc->ExportField($this->nextofkinaddress);
					if ($this->nameofcompany->Exportable) $Doc->ExportField($this->nameofcompany);
					if ($this->humanresourcescontacttelephone->Exportable) $Doc->ExportField($this->humanresourcescontacttelephone);
					if ($this->humanresourcescontactemailaddress->Exportable) $Doc->ExportField($this->humanresourcescontactemailaddress);
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
