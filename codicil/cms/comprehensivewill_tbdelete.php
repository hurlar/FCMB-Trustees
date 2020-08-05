<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "comprehensivewill_tbinfo.php" ?>
<?php include_once "adminusersinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$comprehensivewill_tb_delete = NULL; // Initialize page object first

class ccomprehensivewill_tb_delete extends ccomprehensivewill_tb {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{D9B361E7-B2C1-4293-B9B3-B581986A15CC}";

	// Table name
	var $TableName = 'comprehensivewill_tb';

	// Page object name
	var $PageObjName = 'comprehensivewill_tb_delete';

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

		// Table object (comprehensivewill_tb)
		if (!isset($GLOBALS["comprehensivewill_tb"])) {
			$GLOBALS["comprehensivewill_tb"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["comprehensivewill_tb"];
		}

		// Table object (adminusers)
		if (!isset($GLOBALS['adminusers'])) $GLOBALS['adminusers'] = new cadminusers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'comprehensivewill_tb', TRUE);

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
			$this->Page_Terminate("comprehensivewill_tblist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in comprehensivewill_tb class, comprehensivewill_tbinfo.php

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

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->uid->DbValue = $row['uid'];
		$this->willtype->DbValue = $row['willtype'];
		$this->fullname->DbValue = $row['fullname'];
		$this->address->DbValue = $row['address'];
		$this->_email->DbValue = $row['email'];
		$this->phoneno->DbValue = $row['phoneno'];
		$this->aphoneno->DbValue = $row['aphoneno'];
		$this->gender->DbValue = $row['gender'];
		$this->dob->DbValue = $row['dob'];
		$this->state->DbValue = $row['state'];
		$this->nationality->DbValue = $row['nationality'];
		$this->lga->DbValue = $row['lga'];
		$this->employmentstatus->DbValue = $row['employmentstatus'];
		$this->employer->DbValue = $row['employer'];
		$this->employerphone->DbValue = $row['employerphone'];
		$this->employeraddr->DbValue = $row['employeraddr'];
		$this->maritalstatus->DbValue = $row['maritalstatus'];
		$this->spname->DbValue = $row['spname'];
		$this->spemail->DbValue = $row['spemail'];
		$this->spphone->DbValue = $row['spphone'];
		$this->sdob->DbValue = $row['sdob'];
		$this->spaddr->DbValue = $row['spaddr'];
		$this->spcity->DbValue = $row['spcity'];
		$this->spstate->DbValue = $row['spstate'];
		$this->marriagetype->DbValue = $row['marriagetype'];
		$this->marriageyear->DbValue = $row['marriageyear'];
		$this->marriagecert->DbValue = $row['marriagecert'];
		$this->marriagecity->DbValue = $row['marriagecity'];
		$this->marriagecountry->DbValue = $row['marriagecountry'];
		$this->divorce->DbValue = $row['divorce'];
		$this->divorceyear->DbValue = $row['divorceyear'];
		$this->addinfo->DbValue = $row['addinfo'];
		$this->datecreated->DbValue = $row['datecreated'];
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// employerphone
			$this->employerphone->LinkCustomAttributes = "";
			$this->employerphone->HrefValue = "";
			$this->employerphone->TooltipValue = "";

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
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "comprehensivewill_tblist.php", $this->TableVar);
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
if (!isset($comprehensivewill_tb_delete)) $comprehensivewill_tb_delete = new ccomprehensivewill_tb_delete();

// Page init
$comprehensivewill_tb_delete->Page_Init();

// Page main
$comprehensivewill_tb_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$comprehensivewill_tb_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var comprehensivewill_tb_delete = new ew_Page("comprehensivewill_tb_delete");
comprehensivewill_tb_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = comprehensivewill_tb_delete.PageID; // For backward compatibility

// Form object
var fcomprehensivewill_tbdelete = new ew_Form("fcomprehensivewill_tbdelete");

// Form_CustomValidate event
fcomprehensivewill_tbdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcomprehensivewill_tbdelete.ValidateRequired = true;
<?php } else { ?>
fcomprehensivewill_tbdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($comprehensivewill_tb_delete->Recordset = $comprehensivewill_tb_delete->LoadRecordset())
	$comprehensivewill_tb_deleteTotalRecs = $comprehensivewill_tb_delete->Recordset->RecordCount(); // Get record count
if ($comprehensivewill_tb_deleteTotalRecs <= 0) { // No record found, exit
	if ($comprehensivewill_tb_delete->Recordset)
		$comprehensivewill_tb_delete->Recordset->Close();
	$comprehensivewill_tb_delete->Page_Terminate("comprehensivewill_tblist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $comprehensivewill_tb_delete->ShowPageHeader(); ?>
<?php
$comprehensivewill_tb_delete->ShowMessage();
?>
<form name="fcomprehensivewill_tbdelete" id="fcomprehensivewill_tbdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="comprehensivewill_tb">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($comprehensivewill_tb_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_comprehensivewill_tbdelete" class="ewTable ewTableSeparate">
<?php echo $comprehensivewill_tb->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
		<td><span id="elh_comprehensivewill_tb_willtype" class="comprehensivewill_tb_willtype"><?php echo $comprehensivewill_tb->willtype->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
		<td><span id="elh_comprehensivewill_tb_fullname" class="comprehensivewill_tb_fullname"><?php echo $comprehensivewill_tb->fullname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
		<td><span id="elh_comprehensivewill_tb__email" class="comprehensivewill_tb__email"><?php echo $comprehensivewill_tb->_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
		<td><span id="elh_comprehensivewill_tb_phoneno" class="comprehensivewill_tb_phoneno"><?php echo $comprehensivewill_tb->phoneno->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
		<td><span id="elh_comprehensivewill_tb_aphoneno" class="comprehensivewill_tb_aphoneno"><?php echo $comprehensivewill_tb->aphoneno->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
		<td><span id="elh_comprehensivewill_tb_gender" class="comprehensivewill_tb_gender"><?php echo $comprehensivewill_tb->gender->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
		<td><span id="elh_comprehensivewill_tb_dob" class="comprehensivewill_tb_dob"><?php echo $comprehensivewill_tb->dob->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
		<td><span id="elh_comprehensivewill_tb_state" class="comprehensivewill_tb_state"><?php echo $comprehensivewill_tb->state->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
		<td><span id="elh_comprehensivewill_tb_nationality" class="comprehensivewill_tb_nationality"><?php echo $comprehensivewill_tb->nationality->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
		<td><span id="elh_comprehensivewill_tb_lga" class="comprehensivewill_tb_lga"><?php echo $comprehensivewill_tb->lga->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
		<td><span id="elh_comprehensivewill_tb_employmentstatus" class="comprehensivewill_tb_employmentstatus"><?php echo $comprehensivewill_tb->employmentstatus->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
		<td><span id="elh_comprehensivewill_tb_employerphone" class="comprehensivewill_tb_employerphone"><?php echo $comprehensivewill_tb->employerphone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
		<td><span id="elh_comprehensivewill_tb_maritalstatus" class="comprehensivewill_tb_maritalstatus"><?php echo $comprehensivewill_tb->maritalstatus->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
		<td><span id="elh_comprehensivewill_tb_spname" class="comprehensivewill_tb_spname"><?php echo $comprehensivewill_tb->spname->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
		<td><span id="elh_comprehensivewill_tb_spemail" class="comprehensivewill_tb_spemail"><?php echo $comprehensivewill_tb->spemail->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
		<td><span id="elh_comprehensivewill_tb_spphone" class="comprehensivewill_tb_spphone"><?php echo $comprehensivewill_tb->spphone->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
		<td><span id="elh_comprehensivewill_tb_sdob" class="comprehensivewill_tb_sdob"><?php echo $comprehensivewill_tb->sdob->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
		<td><span id="elh_comprehensivewill_tb_spcity" class="comprehensivewill_tb_spcity"><?php echo $comprehensivewill_tb->spcity->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
		<td><span id="elh_comprehensivewill_tb_spstate" class="comprehensivewill_tb_spstate"><?php echo $comprehensivewill_tb->spstate->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
		<td><span id="elh_comprehensivewill_tb_marriagetype" class="comprehensivewill_tb_marriagetype"><?php echo $comprehensivewill_tb->marriagetype->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
		<td><span id="elh_comprehensivewill_tb_marriageyear" class="comprehensivewill_tb_marriageyear"><?php echo $comprehensivewill_tb->marriageyear->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
		<td><span id="elh_comprehensivewill_tb_marriagecert" class="comprehensivewill_tb_marriagecert"><?php echo $comprehensivewill_tb->marriagecert->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
		<td><span id="elh_comprehensivewill_tb_marriagecity" class="comprehensivewill_tb_marriagecity"><?php echo $comprehensivewill_tb->marriagecity->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
		<td><span id="elh_comprehensivewill_tb_marriagecountry" class="comprehensivewill_tb_marriagecountry"><?php echo $comprehensivewill_tb->marriagecountry->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
		<td><span id="elh_comprehensivewill_tb_divorce" class="comprehensivewill_tb_divorce"><?php echo $comprehensivewill_tb->divorce->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
		<td><span id="elh_comprehensivewill_tb_divorceyear" class="comprehensivewill_tb_divorceyear"><?php echo $comprehensivewill_tb->divorceyear->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
		<td><span id="elh_comprehensivewill_tb_addinfo" class="comprehensivewill_tb_addinfo"><?php echo $comprehensivewill_tb->addinfo->FldCaption() ?></span></td>
<?php } ?>
<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
		<td><span id="elh_comprehensivewill_tb_datecreated" class="comprehensivewill_tb_datecreated"><?php echo $comprehensivewill_tb->datecreated->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$comprehensivewill_tb_delete->RecCnt = 0;
$i = 0;
while (!$comprehensivewill_tb_delete->Recordset->EOF) {
	$comprehensivewill_tb_delete->RecCnt++;
	$comprehensivewill_tb_delete->RowCnt++;

	// Set row properties
	$comprehensivewill_tb->ResetAttrs();
	$comprehensivewill_tb->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$comprehensivewill_tb_delete->LoadRowValues($comprehensivewill_tb_delete->Recordset);

	// Render row
	$comprehensivewill_tb_delete->RenderRow();
?>
	<tr<?php echo $comprehensivewill_tb->RowAttributes() ?>>
<?php if ($comprehensivewill_tb->willtype->Visible) { // willtype ?>
		<td<?php echo $comprehensivewill_tb->willtype->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_willtype" class="control-group comprehensivewill_tb_willtype">
<span<?php echo $comprehensivewill_tb->willtype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->willtype->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->fullname->Visible) { // fullname ?>
		<td<?php echo $comprehensivewill_tb->fullname->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_fullname" class="control-group comprehensivewill_tb_fullname">
<span<?php echo $comprehensivewill_tb->fullname->ViewAttributes() ?>>
<?php if (!ew_EmptyStr($comprehensivewill_tb->fullname->ListViewValue()) && $comprehensivewill_tb->fullname->LinkAttributes() <> "") { ?>
<a<?php echo $comprehensivewill_tb->fullname->LinkAttributes() ?>><?php echo $comprehensivewill_tb->fullname->ListViewValue() ?></a>
<?php } else { ?>
<?php echo $comprehensivewill_tb->fullname->ListViewValue() ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->_email->Visible) { // email ?>
		<td<?php echo $comprehensivewill_tb->_email->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb__email" class="control-group comprehensivewill_tb__email">
<span<?php echo $comprehensivewill_tb->_email->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->phoneno->Visible) { // phoneno ?>
		<td<?php echo $comprehensivewill_tb->phoneno->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_phoneno" class="control-group comprehensivewill_tb_phoneno">
<span<?php echo $comprehensivewill_tb->phoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->phoneno->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->aphoneno->Visible) { // aphoneno ?>
		<td<?php echo $comprehensivewill_tb->aphoneno->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_aphoneno" class="control-group comprehensivewill_tb_aphoneno">
<span<?php echo $comprehensivewill_tb->aphoneno->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->aphoneno->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->gender->Visible) { // gender ?>
		<td<?php echo $comprehensivewill_tb->gender->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_gender" class="control-group comprehensivewill_tb_gender">
<span<?php echo $comprehensivewill_tb->gender->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->gender->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->dob->Visible) { // dob ?>
		<td<?php echo $comprehensivewill_tb->dob->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_dob" class="control-group comprehensivewill_tb_dob">
<span<?php echo $comprehensivewill_tb->dob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->dob->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->state->Visible) { // state ?>
		<td<?php echo $comprehensivewill_tb->state->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_state" class="control-group comprehensivewill_tb_state">
<span<?php echo $comprehensivewill_tb->state->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->state->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->nationality->Visible) { // nationality ?>
		<td<?php echo $comprehensivewill_tb->nationality->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_nationality" class="control-group comprehensivewill_tb_nationality">
<span<?php echo $comprehensivewill_tb->nationality->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->nationality->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->lga->Visible) { // lga ?>
		<td<?php echo $comprehensivewill_tb->lga->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_lga" class="control-group comprehensivewill_tb_lga">
<span<?php echo $comprehensivewill_tb->lga->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->lga->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->employmentstatus->Visible) { // employmentstatus ?>
		<td<?php echo $comprehensivewill_tb->employmentstatus->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_employmentstatus" class="control-group comprehensivewill_tb_employmentstatus">
<span<?php echo $comprehensivewill_tb->employmentstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employmentstatus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->employerphone->Visible) { // employerphone ?>
		<td<?php echo $comprehensivewill_tb->employerphone->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_employerphone" class="control-group comprehensivewill_tb_employerphone">
<span<?php echo $comprehensivewill_tb->employerphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->employerphone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->maritalstatus->Visible) { // maritalstatus ?>
		<td<?php echo $comprehensivewill_tb->maritalstatus->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_maritalstatus" class="control-group comprehensivewill_tb_maritalstatus">
<span<?php echo $comprehensivewill_tb->maritalstatus->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->maritalstatus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->spname->Visible) { // spname ?>
		<td<?php echo $comprehensivewill_tb->spname->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_spname" class="control-group comprehensivewill_tb_spname">
<span<?php echo $comprehensivewill_tb->spname->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->spemail->Visible) { // spemail ?>
		<td<?php echo $comprehensivewill_tb->spemail->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_spemail" class="control-group comprehensivewill_tb_spemail">
<span<?php echo $comprehensivewill_tb->spemail->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spemail->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->spphone->Visible) { // spphone ?>
		<td<?php echo $comprehensivewill_tb->spphone->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_spphone" class="control-group comprehensivewill_tb_spphone">
<span<?php echo $comprehensivewill_tb->spphone->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spphone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->sdob->Visible) { // sdob ?>
		<td<?php echo $comprehensivewill_tb->sdob->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_sdob" class="control-group comprehensivewill_tb_sdob">
<span<?php echo $comprehensivewill_tb->sdob->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->sdob->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->spcity->Visible) { // spcity ?>
		<td<?php echo $comprehensivewill_tb->spcity->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_spcity" class="control-group comprehensivewill_tb_spcity">
<span<?php echo $comprehensivewill_tb->spcity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spcity->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->spstate->Visible) { // spstate ?>
		<td<?php echo $comprehensivewill_tb->spstate->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_spstate" class="control-group comprehensivewill_tb_spstate">
<span<?php echo $comprehensivewill_tb->spstate->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->spstate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagetype->Visible) { // marriagetype ?>
		<td<?php echo $comprehensivewill_tb->marriagetype->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_marriagetype" class="control-group comprehensivewill_tb_marriagetype">
<span<?php echo $comprehensivewill_tb->marriagetype->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagetype->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriageyear->Visible) { // marriageyear ?>
		<td<?php echo $comprehensivewill_tb->marriageyear->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_marriageyear" class="control-group comprehensivewill_tb_marriageyear">
<span<?php echo $comprehensivewill_tb->marriageyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriageyear->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecert->Visible) { // marriagecert ?>
		<td<?php echo $comprehensivewill_tb->marriagecert->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_marriagecert" class="control-group comprehensivewill_tb_marriagecert">
<span<?php echo $comprehensivewill_tb->marriagecert->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecert->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecity->Visible) { // marriagecity ?>
		<td<?php echo $comprehensivewill_tb->marriagecity->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_marriagecity" class="control-group comprehensivewill_tb_marriagecity">
<span<?php echo $comprehensivewill_tb->marriagecity->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecity->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->marriagecountry->Visible) { // marriagecountry ?>
		<td<?php echo $comprehensivewill_tb->marriagecountry->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_marriagecountry" class="control-group comprehensivewill_tb_marriagecountry">
<span<?php echo $comprehensivewill_tb->marriagecountry->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->marriagecountry->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->divorce->Visible) { // divorce ?>
		<td<?php echo $comprehensivewill_tb->divorce->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_divorce" class="control-group comprehensivewill_tb_divorce">
<span<?php echo $comprehensivewill_tb->divorce->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorce->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->divorceyear->Visible) { // divorceyear ?>
		<td<?php echo $comprehensivewill_tb->divorceyear->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_divorceyear" class="control-group comprehensivewill_tb_divorceyear">
<span<?php echo $comprehensivewill_tb->divorceyear->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->divorceyear->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->addinfo->Visible) { // addinfo ?>
		<td<?php echo $comprehensivewill_tb->addinfo->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_addinfo" class="control-group comprehensivewill_tb_addinfo">
<span<?php echo $comprehensivewill_tb->addinfo->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->addinfo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($comprehensivewill_tb->datecreated->Visible) { // datecreated ?>
		<td<?php echo $comprehensivewill_tb->datecreated->CellAttributes() ?>>
<span id="el<?php echo $comprehensivewill_tb_delete->RowCnt ?>_comprehensivewill_tb_datecreated" class="control-group comprehensivewill_tb_datecreated">
<span<?php echo $comprehensivewill_tb->datecreated->ViewAttributes() ?>>
<?php echo $comprehensivewill_tb->datecreated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$comprehensivewill_tb_delete->Recordset->MoveNext();
}
$comprehensivewill_tb_delete->Recordset->Close();
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
fcomprehensivewill_tbdelete.Init();
</script>
<?php
$comprehensivewill_tb_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$comprehensivewill_tb_delete->Page_Terminate();
?>
