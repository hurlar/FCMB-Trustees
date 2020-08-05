<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "investmenttrust_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$investmenttrust_tb_delete = NULL; // Initialize page object first

class cinvestmenttrust_tb_delete extends cinvestmenttrust_tb {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'investmenttrust_tb';

	// Page object name
	var $PageObjName = 'investmenttrust_tb_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language, $UserAgent;

		// User agent
		$UserAgent = ew_UserAgent();
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (investmenttrust_tb)
		if (!isset($GLOBALS["investmenttrust_tb"])) {
			$GLOBALS["investmenttrust_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["investmenttrust_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'investmenttrust_tb', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("investmenttrust_tblist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in investmenttrust_tb class, investmenttrust_tbinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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
		$this->expirydate->setDbValue($rs->fields('expirydate'));
		$this->datecreated->setDbValue($rs->fields('datecreated'));
		$this->willtype->setDbValue($rs->fields('willtype'));
		$this->identificationtype->setDbValue($rs->fields('identificationtype'));
		$this->issueplace->setDbValue($rs->fields('issueplace'));
		$this->employmentstatus->setDbValue($rs->fields('employmentstatus'));
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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->fullname->DbValue = $row['fullname'];
		$this->address->DbValue = $row['address'];
		$this->_email->DbValue = $row['email'];
		$this->maidenname->DbValue = $row['maidenname'];
		$this->phoneno->DbValue = $row['phoneno'];
		$this->aphoneno->DbValue = $row['aphoneno'];
		$this->maritalstatus->DbValue = $row['maritalstatus'];
		$this->gender->DbValue = $row['gender'];
		$this->dob->DbValue = $row['dob'];
		$this->state->DbValue = $row['state'];
		$this->nationality->DbValue = $row['nationality'];
		$this->lga->DbValue = $row['lga'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->idnumber->DbValue = $row['idnumber'];
		$this->issuedate->DbValue = $row['issuedate'];
		$this->expirydate->DbValue = $row['expirydate'];
		$this->datecreated->DbValue = $row['datecreated'];
		$this->willtype->DbValue = $row['willtype'];
		$this->identificationtype->DbValue = $row['identificationtype'];
		$this->issueplace->DbValue = $row['issueplace'];
		$this->employmentstatus->DbValue = $row['employmentstatus'];
		$this->spousename->DbValue = $row['spousename'];
		$this->spouseemail->DbValue = $row['spouseemail'];
		$this->spousephone->DbValue = $row['spousephone'];
		$this->spousedob->DbValue = $row['spousedob'];
		$this->spouseaddr->DbValue = $row['spouseaddr'];
		$this->spousecity->DbValue = $row['spousecity'];
		$this->spousestate->DbValue = $row['spousestate'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->cityofmarriage->DbValue = $row['cityofmarriage'];
		$this->countryofmarriage->DbValue = $row['countryofmarriage'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->nextofkinfullname->DbValue = $row['nextofkinfullname'];
		$this->nextofkintelephone->DbValue = $row['nextofkintelephone'];
		$this->nextofkinemail->DbValue = $row['nextofkinemail'];
		$this->nextofkinaddress->DbValue = $row['nextofkinaddress'];
		$this->nameofcompany->DbValue = $row['nameofcompany'];
		$this->humanresourcescontacttelephone->DbValue = $row['humanresourcescontacttelephone'];
		$this->humanresourcescontactemailaddress->DbValue = $row['humanresourcescontactemailaddress'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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
		// expirydate
		// datecreated
		// willtype
		// identificationtype
		// issueplace
		// employmentstatus
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// employmentstatus
			$this->employmentstatus->ViewValue = $this->employmentstatus->CurrentValue;
			$this->employmentstatus->ViewCustomAttributes = "";

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

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

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

			// datecreated
			$this->datecreated->LinkCustomAttributes = "";
			$this->datecreated->HrefValue = "";
			$this->datecreated->TooltipValue = "";

			// employmentstatus
			$this->employmentstatus->LinkCustomAttributes = "";
			$this->employmentstatus->HrefValue = "";
			$this->employmentstatus->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "investmenttrust_tblist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($investmenttrust_tb_delete)) $investmenttrust_tb_delete = new cinvestmenttrust_tb_delete();

// Page init
$investmenttrust_tb_delete->Page_Init();

// Page main
$investmenttrust_tb_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$investmenttrust_tb_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var investmenttrust_tb_delete = new ew_Page("investmenttrust_tb_delete");
investmenttrust_tb_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = investmenttrust_tb_delete.PageID; // For backward compatibility

// Form object
var finvestmenttrust_tbdelete = new ew_Form("finvestmenttrust_tbdelete");

// Form_CustomValidate event
finvestmenttrust_tbdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
finvestmenttrust_tbdelete.ValidateRequired = true;
<?php } else { ?>
finvestmenttrust_tbdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($investmenttrust_tb_delete->Recordset = $investmenttrust_tb_delete->LoadRecordset())
	$investmenttrust_tb_deleteTotalRecs = $investmenttrust_tb_delete->Recordset->RecordCount(); // Get record count
if ($investmenttrust_tb_deleteTotalRecs <= 0) { // No record found, exit
	if ($investmenttrust_tb_delete->Recordset)
		$investmenttrust_tb_delete->Recordset->Close();
	$investmenttrust_tb_delete->Page_Terminate("investmenttrust_tblist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $investmenttrust_tb_delete->ShowPageHeader(); ?>
<?php
$investmenttrust_tb_delete->ShowMessage();
?>
<form name="finvestmenttrust_tbdelete" id="finvestmenttrust_tbdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="investmenttrust_tb">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($investmenttrust_tb_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_investmenttrust_tbdelete" class="ewTable ewTableSeparate">
<?php echo $investmenttrust_tb->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($investmenttrust_tb->fullname->Visible) { // fullname ?>
		<td><span id="elh_investmenttrust_tb_fullname" class="investmenttrust_tb_fullname"><?php echo $investmenttrust_tb->fullname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->_email->Visible) { // email ?>
		<td><span id="elh_investmenttrust_tb__email" class="investmenttrust_tb__email"><?php echo $investmenttrust_tb->_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->phoneno->Visible) { // phoneno ?>
		<td><span id="elh_investmenttrust_tb_phoneno" class="investmenttrust_tb_phoneno"><?php echo $investmenttrust_tb->phoneno->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->aphoneno->Visible) { // aphoneno ?>
		<td><span id="elh_investmenttrust_tb_aphoneno" class="investmenttrust_tb_aphoneno"><?php echo $investmenttrust_tb->aphoneno->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->maritalstatus->Visible) { // maritalstatus ?>
		<td><span id="elh_investmenttrust_tb_maritalstatus" class="investmenttrust_tb_maritalstatus"><?php echo $investmenttrust_tb->maritalstatus->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->gender->Visible) { // gender ?>
		<td><span id="elh_investmenttrust_tb_gender" class="investmenttrust_tb_gender"><?php echo $investmenttrust_tb->gender->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->dob->Visible) { // dob ?>
		<td><span id="elh_investmenttrust_tb_dob" class="investmenttrust_tb_dob"><?php echo $investmenttrust_tb->dob->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->state->Visible) { // state ?>
		<td><span id="elh_investmenttrust_tb_state" class="investmenttrust_tb_state"><?php echo $investmenttrust_tb->state->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->datecreated->Visible) { // datecreated ?>
		<td><span id="elh_investmenttrust_tb_datecreated" class="investmenttrust_tb_datecreated"><?php echo $investmenttrust_tb->datecreated->FldCaption() ?></span></td>
<?php } ?>
<?php if ($investmenttrust_tb->employmentstatus->Visible) { // employmentstatus ?>
		<td><span id="elh_investmenttrust_tb_employmentstatus" class="investmenttrust_tb_employmentstatus"><?php echo $investmenttrust_tb->employmentstatus->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$investmenttrust_tb_delete->RecCnt = 0;
$i = 0;
while (!$investmenttrust_tb_delete->Recordset->EOF) {
	$investmenttrust_tb_delete->RecCnt++;
	$investmenttrust_tb_delete->RowCnt++;

	// Set row properties
	$investmenttrust_tb->ResetAttrs();
	$investmenttrust_tb->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$investmenttrust_tb_delete->LoadRowValues($investmenttrust_tb_delete->Recordset);

	// Render row
	$investmenttrust_tb_delete->RenderRow();
?>
	<tr<?php echo $investmenttrust_tb->RowAttributes() ?>>
<?php if ($investmenttrust_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $investmenttrust_tb->fullname->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_fullname" class="control-group investmenttrust_tb_fullname">
<span<?php echo $investmenttrust_tb->fullname->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->fullname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->_email->Visible) { // email ?>
		<td<?php echo $investmenttrust_tb->_email->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb__email" class="control-group investmenttrust_tb__email">
<span<?php echo $investmenttrust_tb->_email->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->phoneno->Visible) { // phoneno ?>
		<td<?php echo $investmenttrust_tb->phoneno->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_phoneno" class="control-group investmenttrust_tb_phoneno">
<span<?php echo $investmenttrust_tb->phoneno->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->aphoneno->Visible) { // aphoneno ?>
		<td<?php echo $investmenttrust_tb->aphoneno->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_aphoneno" class="control-group investmenttrust_tb_aphoneno">
<span<?php echo $investmenttrust_tb->aphoneno->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->aphoneno->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->maritalstatus->Visible) { // maritalstatus ?>
		<td<?php echo $investmenttrust_tb->maritalstatus->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_maritalstatus" class="control-group investmenttrust_tb_maritalstatus">
<span<?php echo $investmenttrust_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->maritalstatus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->gender->Visible) { // gender ?>
		<td<?php echo $investmenttrust_tb->gender->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_gender" class="control-group investmenttrust_tb_gender">
<span<?php echo $investmenttrust_tb->gender->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->gender->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->dob->Visible) { // dob ?>
		<td<?php echo $investmenttrust_tb->dob->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_dob" class="control-group investmenttrust_tb_dob">
<span<?php echo $investmenttrust_tb->dob->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->dob->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->state->Visible) { // state ?>
		<td<?php echo $investmenttrust_tb->state->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_state" class="control-group investmenttrust_tb_state">
<span<?php echo $investmenttrust_tb->state->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->state->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $investmenttrust_tb->datecreated->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_datecreated" class="control-group investmenttrust_tb_datecreated">
<span<?php echo $investmenttrust_tb->datecreated->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($investmenttrust_tb->employmentstatus->Visible) { // employmentstatus ?>
		<td<?php echo $investmenttrust_tb->employmentstatus->CellAttributes() ?>>
<span id="el<?php echo $investmenttrust_tb_delete->RowCnt ?>_investmenttrust_tb_employmentstatus" class="control-group investmenttrust_tb_employmentstatus">
<span<?php echo $investmenttrust_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $investmenttrust_tb->employmentstatus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$investmenttrust_tb_delete->Recordset->MoveNext();
}
$investmenttrust_tb_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
finvestmenttrust_tbdelete.Init();
</script>
<?php
$investmenttrust_tb_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$investmenttrust_tb_delete->Page_Terminate();
?>
