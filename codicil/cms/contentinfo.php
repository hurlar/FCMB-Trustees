<?php

// Global variable for table object
$content = NULL;

//
// Table class for content
//
class ccontent extends cTable {
	var $id;
	var $pg_name;
	var $pg_cat;
	var $content;
	var $pg_alias;
	var $pg_type;
	var $pg_menu;
	var $pg_title;
	var $keywords;
	var $pr_status;
	var $pg_url;
	var $secured_st;
	var $rate_ord;
	var $uploads;
	var $intro;
	var $sidebar;
	var $postdate;
	var $img1;
	var $img2;
	var $creator;
	var $datep;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'content';
		$this->TableName = 'content';
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
		$this->id = new cField('content', 'content', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// pg_name
		$this->pg_name = new cField('content', 'content', 'x_pg_name', 'pg_name', '`pg_name`', '`pg_name`', 200, -1, FALSE, '`pg_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_name'] = &$this->pg_name;

		// pg_cat
		$this->pg_cat = new cField('content', 'content', 'x_pg_cat', 'pg_cat', '`pg_cat`', '`pg_cat`', 200, -1, FALSE, '`pg_cat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_cat'] = &$this->pg_cat;

		// content
		$this->content = new cField('content', 'content', 'x_content', 'content', '`content`', '`content`', 201, -1, FALSE, '`content`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['content'] = &$this->content;

		// pg_alias
		$this->pg_alias = new cField('content', 'content', 'x_pg_alias', 'pg_alias', '`pg_alias`', '`pg_alias`', 200, -1, FALSE, '`pg_alias`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_alias'] = &$this->pg_alias;

		// pg_type
		$this->pg_type = new cField('content', 'content', 'x_pg_type', 'pg_type', '`pg_type`', '`pg_type`', 200, -1, FALSE, '`pg_type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_type'] = &$this->pg_type;

		// pg_menu
		$this->pg_menu = new cField('content', 'content', 'x_pg_menu', 'pg_menu', '`pg_menu`', '`pg_menu`', 200, -1, FALSE, '`pg_menu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_menu'] = &$this->pg_menu;

		// pg_title
		$this->pg_title = new cField('content', 'content', 'x_pg_title', 'pg_title', '`pg_title`', '`pg_title`', 200, -1, FALSE, '`pg_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_title'] = &$this->pg_title;

		// keywords
		$this->keywords = new cField('content', 'content', 'x_keywords', 'keywords', '`keywords`', '`keywords`', 201, -1, FALSE, '`keywords`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['keywords'] = &$this->keywords;

		// pr_status
		$this->pr_status = new cField('content', 'content', 'x_pr_status', 'pr_status', '`pr_status`', '`pr_status`', 202, -1, FALSE, '`pr_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pr_status'] = &$this->pr_status;

		// pg_url
		$this->pg_url = new cField('content', 'content', 'x_pg_url', 'pg_url', '`pg_url`', '`pg_url`', 200, -1, FALSE, '`pg_url`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['pg_url'] = &$this->pg_url;

		// secured_st
		$this->secured_st = new cField('content', 'content', 'x_secured_st', 'secured_st', '`secured_st`', '`secured_st`', 202, -1, FALSE, '`secured_st`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->secured_st->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['secured_st'] = &$this->secured_st;

		// rate_ord
		$this->rate_ord = new cField('content', 'content', 'x_rate_ord', 'rate_ord', '`rate_ord`', '`rate_ord`', 202, -1, FALSE, '`rate_ord`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rate_ord'] = &$this->rate_ord;

		// uploads
		$this->uploads = new cField('content', 'content', 'x_uploads', 'uploads', '`uploads`', '`uploads`', 200, -1, TRUE, '`uploads`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['uploads'] = &$this->uploads;

		// intro
		$this->intro = new cField('content', 'content', 'x_intro', 'intro', '`intro`', '`intro`', 201, -1, FALSE, '`intro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['intro'] = &$this->intro;

		// sidebar
		$this->sidebar = new cField('content', 'content', 'x_sidebar', 'sidebar', '`sidebar`', '`sidebar`', 201, -1, FALSE, '`sidebar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sidebar'] = &$this->sidebar;

		// postdate
		$this->postdate = new cField('content', 'content', 'x_postdate', 'postdate', '`postdate`', 'DATE_FORMAT(`postdate`, \'%d/%m/%y\')', 133, -1, FALSE, '`postdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->postdate->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['postdate'] = &$this->postdate;

		// img1
		$this->img1 = new cField('content', 'content', 'x_img1', 'img1', '`img1`', '`img1`', 200, -1, FALSE, '`img1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['img1'] = &$this->img1;

		// img2
		$this->img2 = new cField('content', 'content', 'x_img2', 'img2', '`img2`', '`img2`', 200, -1, FALSE, '`img2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['img2'] = &$this->img2;

		// creator
		$this->creator = new cField('content', 'content', 'x_creator', 'creator', '`creator`', '`creator`', 200, -1, FALSE, '`creator`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['creator'] = &$this->creator;

		// datep
		$this->datep = new cField('content', 'content', 'x_datep', 'datep', '`datep`', 'DATE_FORMAT(`datep`, \'%d/%m/%y\')', 135, -1, FALSE, '`datep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['datep'] = &$this->datep;
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
		return "`content`";
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
	var $UpdateTable = "`content`";

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
			return "contentlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "contentlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("contentview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("contentview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "contentadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("contentedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("contentadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("contentdelete.php", $this->UrlParm());
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
		$this->pg_name->setDbValue($rs->fields('pg_name'));
		$this->pg_cat->setDbValue($rs->fields('pg_cat'));
		$this->content->setDbValue($rs->fields('content'));
		$this->pg_alias->setDbValue($rs->fields('pg_alias'));
		$this->pg_type->setDbValue($rs->fields('pg_type'));
		$this->pg_menu->setDbValue($rs->fields('pg_menu'));
		$this->pg_title->setDbValue($rs->fields('pg_title'));
		$this->keywords->setDbValue($rs->fields('keywords'));
		$this->pr_status->setDbValue($rs->fields('pr_status'));
		$this->pg_url->setDbValue($rs->fields('pg_url'));
		$this->secured_st->setDbValue($rs->fields('secured_st'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->uploads->Upload->DbValue = $rs->fields('uploads');
		$this->intro->setDbValue($rs->fields('intro'));
		$this->sidebar->setDbValue($rs->fields('sidebar'));
		$this->postdate->setDbValue($rs->fields('postdate'));
		$this->img1->setDbValue($rs->fields('img1'));
		$this->img2->setDbValue($rs->fields('img2'));
		$this->creator->setDbValue($rs->fields('creator'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// pg_name
		// pg_cat
		// content
		// pg_alias
		// pg_type
		// pg_menu
		// pg_title
		// keywords
		// pr_status
		// pg_url
		// secured_st

		$this->secured_st->CellCssStyle = "white-space: nowrap;";

		// rate_ord
		// uploads
		// intro
		// sidebar
		// postdate
		// img1
		// img2
		// creator
		// datep
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// pg_name
		$this->pg_name->ViewValue = $this->pg_name->CurrentValue;
		$this->pg_name->ViewCustomAttributes = "";

		// pg_cat
		if (strval($this->pg_cat->CurrentValue) <> "") {
			$sFilterWrk = "`pg_cat`" . ew_SearchString("=", $this->pg_cat->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `pg_cat`, `pg_cat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_cat`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->pg_cat, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->pg_cat->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->pg_cat->ViewValue = $this->pg_cat->CurrentValue;
			}
		} else {
			$this->pg_cat->ViewValue = NULL;
		}
		$this->pg_cat->ViewCustomAttributes = "";

		// content
		$this->content->ViewValue = $this->content->CurrentValue;
		$this->content->ViewCustomAttributes = "";

		// pg_alias
		$this->pg_alias->ViewValue = $this->pg_alias->CurrentValue;
		$this->pg_alias->ViewCustomAttributes = "";

		// pg_type
		$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
		if (strval($this->pg_type->CurrentValue) <> "") {
			$sFilterWrk = "`name`" . ew_SearchString("=", $this->pg_type->CurrentValue, EW_DATATYPE_STRING);
		$sSqlWrk = "SELECT `name`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `page_template`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->pg_type, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->pg_type->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->pg_type->ViewValue = $this->pg_type->CurrentValue;
			}
		} else {
			$this->pg_type->ViewValue = NULL;
		}
		$this->pg_type->ViewCustomAttributes = "";

		// pg_menu
		$this->pg_menu->ViewValue = $this->pg_menu->CurrentValue;
		$this->pg_menu->ViewCustomAttributes = "";

		// pg_title
		$this->pg_title->ViewValue = $this->pg_title->CurrentValue;
		$this->pg_title->ViewCustomAttributes = "";

		// keywords
		$this->keywords->ViewValue = $this->keywords->CurrentValue;
		$this->keywords->ViewCustomAttributes = "";

		// pr_status
		if (strval($this->pr_status->CurrentValue) <> "") {
			switch ($this->pr_status->CurrentValue) {
				case $this->pr_status->FldTagValue(1):
					$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(1) <> "" ? $this->pr_status->FldTagCaption(1) : $this->pr_status->CurrentValue;
					break;
				case $this->pr_status->FldTagValue(2):
					$this->pr_status->ViewValue = $this->pr_status->FldTagCaption(2) <> "" ? $this->pr_status->FldTagCaption(2) : $this->pr_status->CurrentValue;
					break;
				default:
					$this->pr_status->ViewValue = $this->pr_status->CurrentValue;
			}
		} else {
			$this->pr_status->ViewValue = NULL;
		}
		$this->pr_status->ViewCustomAttributes = "";

		// pg_url
		$this->pg_url->ViewValue = $this->pg_url->CurrentValue;
		$this->pg_url->ViewCustomAttributes = "";

		// secured_st
		if (ew_ConvertToBool($this->secured_st->CurrentValue)) {
			$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(2) <> "" ? $this->secured_st->FldTagCaption(2) : "Secured";
		} else {
			$this->secured_st->ViewValue = $this->secured_st->FldTagCaption(1) <> "" ? $this->secured_st->FldTagCaption(1) : "Public";
		}
		$this->secured_st->ViewCustomAttributes = "";

		// rate_ord
		if (strval($this->rate_ord->CurrentValue) <> "") {
			switch ($this->rate_ord->CurrentValue) {
				case $this->rate_ord->FldTagValue(1):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(1) <> "" ? $this->rate_ord->FldTagCaption(1) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(2):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(2) <> "" ? $this->rate_ord->FldTagCaption(2) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(3):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(3) <> "" ? $this->rate_ord->FldTagCaption(3) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(4):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(4) <> "" ? $this->rate_ord->FldTagCaption(4) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(5):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(5) <> "" ? $this->rate_ord->FldTagCaption(5) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(6):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(6) <> "" ? $this->rate_ord->FldTagCaption(6) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(7):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(7) <> "" ? $this->rate_ord->FldTagCaption(7) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(8):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(8) <> "" ? $this->rate_ord->FldTagCaption(8) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(9):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(9) <> "" ? $this->rate_ord->FldTagCaption(9) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(10):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(10) <> "" ? $this->rate_ord->FldTagCaption(10) : $this->rate_ord->CurrentValue;
					break;
				case $this->rate_ord->FldTagValue(11):
					$this->rate_ord->ViewValue = $this->rate_ord->FldTagCaption(11) <> "" ? $this->rate_ord->FldTagCaption(11) : $this->rate_ord->CurrentValue;
					break;
				default:
					$this->rate_ord->ViewValue = $this->rate_ord->CurrentValue;
			}
		} else {
			$this->rate_ord->ViewValue = NULL;
		}
		$this->rate_ord->ViewCustomAttributes = "";

		// uploads
		$this->uploads->UploadPath = "../uploads/";
		if (!ew_Empty($this->uploads->Upload->DbValue)) {
			$this->uploads->ViewValue = $this->uploads->Upload->DbValue;
		} else {
			$this->uploads->ViewValue = "";
		}
		$this->uploads->ViewCustomAttributes = "";

		// intro
		$this->intro->ViewValue = $this->intro->CurrentValue;
		$this->intro->ViewCustomAttributes = "";

		// sidebar
		$this->sidebar->ViewValue = $this->sidebar->CurrentValue;
		$this->sidebar->ViewCustomAttributes = "";

		// postdate
		$this->postdate->ViewValue = $this->postdate->CurrentValue;
		$this->postdate->ViewCustomAttributes = "";

		// img1
		$this->img1->ViewValue = $this->img1->CurrentValue;
		$this->img1->ViewCustomAttributes = "";

		// img2
		$this->img2->ViewValue = $this->img2->CurrentValue;
		$this->img2->ViewCustomAttributes = "";

		// creator
		$this->creator->ViewValue = $this->creator->CurrentValue;
		$this->creator->ViewCustomAttributes = "";

		// datep
		$this->datep->ViewValue = $this->datep->CurrentValue;
		$this->datep->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// pg_name
		$this->pg_name->LinkCustomAttributes = "";
		$this->pg_name->HrefValue = "";
		$this->pg_name->TooltipValue = "";

		// pg_cat
		$this->pg_cat->LinkCustomAttributes = "";
		$this->pg_cat->HrefValue = "";
		$this->pg_cat->TooltipValue = "";

		// content
		$this->content->LinkCustomAttributes = "";
		$this->content->HrefValue = "";
		$this->content->TooltipValue = "";

		// pg_alias
		$this->pg_alias->LinkCustomAttributes = "";
		$this->pg_alias->HrefValue = "";
		$this->pg_alias->TooltipValue = "";

		// pg_type
		$this->pg_type->LinkCustomAttributes = "";
		$this->pg_type->HrefValue = "";
		$this->pg_type->TooltipValue = "";

		// pg_menu
		$this->pg_menu->LinkCustomAttributes = "";
		$this->pg_menu->HrefValue = "";
		$this->pg_menu->TooltipValue = "";

		// pg_title
		$this->pg_title->LinkCustomAttributes = "";
		$this->pg_title->HrefValue = "";
		$this->pg_title->TooltipValue = "";

		// keywords
		$this->keywords->LinkCustomAttributes = "";
		$this->keywords->HrefValue = "";
		$this->keywords->TooltipValue = "";

		// pr_status
		$this->pr_status->LinkCustomAttributes = "";
		$this->pr_status->HrefValue = "";
		$this->pr_status->TooltipValue = "";

		// pg_url
		$this->pg_url->LinkCustomAttributes = "";
		$this->pg_url->HrefValue = "";
		$this->pg_url->TooltipValue = "";

		// secured_st
		$this->secured_st->LinkCustomAttributes = "";
		$this->secured_st->HrefValue = "";
		$this->secured_st->TooltipValue = "";

		// rate_ord
		$this->rate_ord->LinkCustomAttributes = "";
		$this->rate_ord->HrefValue = "";
		$this->rate_ord->TooltipValue = "";

		// uploads
		$this->uploads->LinkCustomAttributes = "";
		$this->uploads->HrefValue = "";
		$this->uploads->HrefValue2 = $this->uploads->UploadPath . $this->uploads->Upload->DbValue;
		$this->uploads->TooltipValue = "";

		// intro
		$this->intro->LinkCustomAttributes = "";
		$this->intro->HrefValue = "";
		$this->intro->TooltipValue = "";

		// sidebar
		$this->sidebar->LinkCustomAttributes = "";
		$this->sidebar->HrefValue = "";
		$this->sidebar->TooltipValue = "";

		// postdate
		$this->postdate->LinkCustomAttributes = "";
		$this->postdate->HrefValue = "";
		$this->postdate->TooltipValue = "";

		// img1
		$this->img1->LinkCustomAttributes = "";
		$this->img1->HrefValue = "";
		$this->img1->TooltipValue = "";

		// img2
		$this->img2->LinkCustomAttributes = "";
		$this->img2->HrefValue = "";
		$this->img2->TooltipValue = "";

		// creator
		$this->creator->LinkCustomAttributes = "";
		$this->creator->HrefValue = "";
		$this->creator->TooltipValue = "";

		// datep
		$this->datep->LinkCustomAttributes = "";
		$this->datep->HrefValue = "";
		$this->datep->TooltipValue = "";

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
				if ($this->pg_name->Exportable) $Doc->ExportCaption($this->pg_name);
				if ($this->pg_cat->Exportable) $Doc->ExportCaption($this->pg_cat);
				if ($this->content->Exportable) $Doc->ExportCaption($this->content);
				if ($this->pg_alias->Exportable) $Doc->ExportCaption($this->pg_alias);
				if ($this->pg_type->Exportable) $Doc->ExportCaption($this->pg_type);
				if ($this->pg_title->Exportable) $Doc->ExportCaption($this->pg_title);
				if ($this->keywords->Exportable) $Doc->ExportCaption($this->keywords);
				if ($this->pr_status->Exportable) $Doc->ExportCaption($this->pr_status);
				if ($this->rate_ord->Exportable) $Doc->ExportCaption($this->rate_ord);
				if ($this->uploads->Exportable) $Doc->ExportCaption($this->uploads);
				if ($this->datep->Exportable) $Doc->ExportCaption($this->datep);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->pg_name->Exportable) $Doc->ExportCaption($this->pg_name);
				if ($this->pg_cat->Exportable) $Doc->ExportCaption($this->pg_cat);
				if ($this->content->Exportable) $Doc->ExportCaption($this->content);
				if ($this->pg_alias->Exportable) $Doc->ExportCaption($this->pg_alias);
				if ($this->pg_type->Exportable) $Doc->ExportCaption($this->pg_type);
				if ($this->pg_menu->Exportable) $Doc->ExportCaption($this->pg_menu);
				if ($this->pg_title->Exportable) $Doc->ExportCaption($this->pg_title);
				if ($this->keywords->Exportable) $Doc->ExportCaption($this->keywords);
				if ($this->pr_status->Exportable) $Doc->ExportCaption($this->pr_status);
				if ($this->pg_url->Exportable) $Doc->ExportCaption($this->pg_url);
				if ($this->secured_st->Exportable) $Doc->ExportCaption($this->secured_st);
				if ($this->rate_ord->Exportable) $Doc->ExportCaption($this->rate_ord);
				if ($this->uploads->Exportable) $Doc->ExportCaption($this->uploads);
				if ($this->intro->Exportable) $Doc->ExportCaption($this->intro);
				if ($this->sidebar->Exportable) $Doc->ExportCaption($this->sidebar);
				if ($this->postdate->Exportable) $Doc->ExportCaption($this->postdate);
				if ($this->img1->Exportable) $Doc->ExportCaption($this->img1);
				if ($this->img2->Exportable) $Doc->ExportCaption($this->img2);
				if ($this->creator->Exportable) $Doc->ExportCaption($this->creator);
				if ($this->datep->Exportable) $Doc->ExportCaption($this->datep);
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
					if ($this->pg_name->Exportable) $Doc->ExportField($this->pg_name);
					if ($this->pg_cat->Exportable) $Doc->ExportField($this->pg_cat);
					if ($this->content->Exportable) $Doc->ExportField($this->content);
					if ($this->pg_alias->Exportable) $Doc->ExportField($this->pg_alias);
					if ($this->pg_type->Exportable) $Doc->ExportField($this->pg_type);
					if ($this->pg_title->Exportable) $Doc->ExportField($this->pg_title);
					if ($this->keywords->Exportable) $Doc->ExportField($this->keywords);
					if ($this->pr_status->Exportable) $Doc->ExportField($this->pr_status);
					if ($this->rate_ord->Exportable) $Doc->ExportField($this->rate_ord);
					if ($this->uploads->Exportable) $Doc->ExportField($this->uploads);
					if ($this->datep->Exportable) $Doc->ExportField($this->datep);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->pg_name->Exportable) $Doc->ExportField($this->pg_name);
					if ($this->pg_cat->Exportable) $Doc->ExportField($this->pg_cat);
					if ($this->content->Exportable) $Doc->ExportField($this->content);
					if ($this->pg_alias->Exportable) $Doc->ExportField($this->pg_alias);
					if ($this->pg_type->Exportable) $Doc->ExportField($this->pg_type);
					if ($this->pg_menu->Exportable) $Doc->ExportField($this->pg_menu);
					if ($this->pg_title->Exportable) $Doc->ExportField($this->pg_title);
					if ($this->keywords->Exportable) $Doc->ExportField($this->keywords);
					if ($this->pr_status->Exportable) $Doc->ExportField($this->pr_status);
					if ($this->pg_url->Exportable) $Doc->ExportField($this->pg_url);
					if ($this->secured_st->Exportable) $Doc->ExportField($this->secured_st);
					if ($this->rate_ord->Exportable) $Doc->ExportField($this->rate_ord);
					if ($this->uploads->Exportable) $Doc->ExportField($this->uploads);
					if ($this->intro->Exportable) $Doc->ExportField($this->intro);
					if ($this->sidebar->Exportable) $Doc->ExportField($this->sidebar);
					if ($this->postdate->Exportable) $Doc->ExportField($this->postdate);
					if ($this->img1->Exportable) $Doc->ExportField($this->img1);
					if ($this->img2->Exportable) $Doc->ExportField($this->img2);
					if ($this->creator->Exportable) $Doc->ExportField($this->creator);
					if ($this->datep->Exportable) $Doc->ExportField($this->datep);
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
