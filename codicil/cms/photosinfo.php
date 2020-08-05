<?php

// Global variable for table object
$photos = NULL;

//
// Table class for photos
//
class cphotos extends cTable {
	var $id;
	var $img;
	var $uid;
	var $cat;
	var $sub;
	var $title;
	var $descp;
	var $location;
	var $datetaken;
	var $tags;
	var $views;
	var $photoby;
	var $active;
	var $featured;
	var $rate_ord;
	var $datep;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'photos';
		$this->TableName = 'photos';
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
		$this->id = new cField('photos', 'photos', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// img
		$this->img = new cField('photos', 'photos', 'x_img', 'img', '`img`', '`img`', 200, -1, TRUE, '`img`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['img'] = &$this->img;

		// uid
		$this->uid = new cField('photos', 'photos', 'x_uid', 'uid', '`uid`', '`uid`', 200, -1, FALSE, '`uid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['uid'] = &$this->uid;

		// cat
		$this->cat = new cField('photos', 'photos', 'x_cat', 'cat', '`cat`', '`cat`', 200, -1, FALSE, '`cat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['cat'] = &$this->cat;

		// sub
		$this->sub = new cField('photos', 'photos', 'x_sub', 'sub', '`sub`', '`sub`', 200, -1, FALSE, '`sub`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['sub'] = &$this->sub;

		// title
		$this->title = new cField('photos', 'photos', 'x_title', 'title', '`title`', '`title`', 200, -1, FALSE, '`title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['title'] = &$this->title;

		// descp
		$this->descp = new cField('photos', 'photos', 'x_descp', 'descp', '`descp`', '`descp`', 201, -1, FALSE, '`descp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['descp'] = &$this->descp;

		// location
		$this->location = new cField('photos', 'photos', 'x_location', 'location', '`location`', '`location`', 200, -1, FALSE, '`location`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['location'] = &$this->location;

		// datetaken
		$this->datetaken = new cField('photos', 'photos', 'x_datetaken', 'datetaken', '`datetaken`', 'DATE_FORMAT(`datetaken`, \'%d/%m/%y\')', 133, -1, FALSE, '`datetaken`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->datetaken->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['datetaken'] = &$this->datetaken;

		// tags
		$this->tags = new cField('photos', 'photos', 'x_tags', 'tags', '`tags`', '`tags`', 201, -1, FALSE, '`tags`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['tags'] = &$this->tags;

		// views
		$this->views = new cField('photos', 'photos', 'x_views', 'views', '`views`', '`views`', 3, -1, FALSE, '`views`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->views->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['views'] = &$this->views;

		// photoby
		$this->photoby = new cField('photos', 'photos', 'x_photoby', 'photoby', '`photoby`', '`photoby`', 200, -1, FALSE, '`photoby`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['photoby'] = &$this->photoby;

		// active
		$this->active = new cField('photos', 'photos', 'x_active', 'active', '`active`', '`active`', 202, -1, FALSE, '`active`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->active->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['active'] = &$this->active;

		// featured
		$this->featured = new cField('photos', 'photos', 'x_featured', 'featured', '`featured`', '`featured`', 202, -1, FALSE, '`featured`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->featured->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->fields['featured'] = &$this->featured;

		// rate_ord
		$this->rate_ord = new cField('photos', 'photos', 'x_rate_ord', 'rate_ord', '`rate_ord`', '`rate_ord`', 202, -1, FALSE, '`rate_ord`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['rate_ord'] = &$this->rate_ord;

		// datep
		$this->datep = new cField('photos', 'photos', 'x_datep', 'datep', '`datep`', 'DATE_FORMAT(`datep`, \'%d/%m/%y\')', 135, -1, FALSE, '`datep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
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
		return "`photos`";
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
		return "`id` DESC";
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
	var $UpdateTable = "`photos`";

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
			return "photoslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "photoslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("photosview.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("photosview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Add URL
	function GetAddUrl() {
		return "photosadd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		return $this->KeyUrl("photosedit.php", $this->UrlParm($parm));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		return $this->KeyUrl("photosadd.php", $this->UrlParm($parm));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("photosdelete.php", $this->UrlParm());
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
		$this->img->Upload->DbValue = $rs->fields('img');
		$this->uid->setDbValue($rs->fields('uid'));
		$this->cat->setDbValue($rs->fields('cat'));
		$this->sub->setDbValue($rs->fields('sub'));
		$this->title->setDbValue($rs->fields('title'));
		$this->descp->setDbValue($rs->fields('descp'));
		$this->location->setDbValue($rs->fields('location'));
		$this->datetaken->setDbValue($rs->fields('datetaken'));
		$this->tags->setDbValue($rs->fields('tags'));
		$this->views->setDbValue($rs->fields('views'));
		$this->photoby->setDbValue($rs->fields('photoby'));
		$this->active->setDbValue($rs->fields('active'));
		$this->featured->setDbValue($rs->fields('featured'));
		$this->rate_ord->setDbValue($rs->fields('rate_ord'));
		$this->datep->setDbValue($rs->fields('datep'));
	}

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// img
		// uid
		// cat
		// sub
		// title
		// descp
		// location
		// datetaken
		// tags
		// views
		// photoby
		// active
		// featured
		// rate_ord
		// datep
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// img
		$this->img->UploadPath = "../uploads/photos";
		if (!ew_Empty($this->img->Upload->DbValue)) {
			$this->img->ImageWidth = 50;
			$this->img->ImageHeight = 40;
			$this->img->ImageAlt = $this->img->FldAlt();
			$this->img->ViewValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue;
		} else {
			$this->img->ViewValue = "";
		}
		$this->img->ViewCustomAttributes = "";

		// uid
		$this->uid->ViewValue = $this->uid->CurrentValue;
		$this->uid->ViewCustomAttributes = "";

		// cat
		if (strval($this->cat->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->cat->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `id`, `category` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_cats`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->cat, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->cat->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->cat->ViewValue = $this->cat->CurrentValue;
			}
		} else {
			$this->cat->ViewValue = NULL;
		}
		$this->cat->ViewCustomAttributes = "";

		// sub
		if (strval($this->sub->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub->CurrentValue, EW_DATATYPE_NUMBER);
		$sSqlWrk = "SELECT `id`, `subcat` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `gallery_subcat`";
		$sWhereWrk = "";
		if ($sFilterWrk <> "") {
			ew_AddFilter($sWhereWrk, $sFilterWrk);
		}

		// Call Lookup selecting
		$this->Lookup_Selecting($this->sub, $sWhereWrk);
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$this->sub->ViewValue = $rswrk->fields('DispFld');
				$rswrk->Close();
			} else {
				$this->sub->ViewValue = $this->sub->CurrentValue;
			}
		} else {
			$this->sub->ViewValue = NULL;
		}
		$this->sub->ViewCustomAttributes = "";

		// title
		$this->title->ViewValue = $this->title->CurrentValue;
		$this->title->ViewCustomAttributes = "";

		// descp
		$this->descp->ViewValue = $this->descp->CurrentValue;
		$this->descp->ViewCustomAttributes = "";

		// location
		$this->location->ViewValue = $this->location->CurrentValue;
		$this->location->ViewCustomAttributes = "";

		// datetaken
		$this->datetaken->ViewValue = $this->datetaken->CurrentValue;
		$this->datetaken->ViewCustomAttributes = "";

		// tags
		$this->tags->ViewValue = $this->tags->CurrentValue;
		$this->tags->ViewCustomAttributes = "";

		// views
		$this->views->ViewValue = $this->views->CurrentValue;
		$this->views->ViewCustomAttributes = "";

		// photoby
		$this->photoby->ViewValue = $this->photoby->CurrentValue;
		$this->photoby->ViewCustomAttributes = "";

		// active
		if (ew_ConvertToBool($this->active->CurrentValue)) {
			$this->active->ViewValue = $this->active->FldTagCaption(2) <> "" ? $this->active->FldTagCaption(2) : "Visible";
		} else {
			$this->active->ViewValue = $this->active->FldTagCaption(1) <> "" ? $this->active->FldTagCaption(1) : "Disable";
		}
		$this->active->ViewCustomAttributes = "";

		// featured
		if (ew_ConvertToBool($this->featured->CurrentValue)) {
			$this->featured->ViewValue = $this->featured->FldTagCaption(2) <> "" ? $this->featured->FldTagCaption(2) : "Yes";
		} else {
			$this->featured->ViewValue = $this->featured->FldTagCaption(1) <> "" ? $this->featured->FldTagCaption(1) : "No";
		}
		$this->featured->ViewCustomAttributes = "";

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

		// datep
		$this->datep->ViewValue = $this->datep->CurrentValue;
		$this->datep->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// img
		$this->img->LinkCustomAttributes = "";
		$this->img->UploadPath = "../uploads/photos";
		if (!ew_Empty($this->img->Upload->DbValue)) {
			$this->img->HrefValue = ew_UploadPathEx(FALSE, $this->img->UploadPath) . $this->img->Upload->DbValue; // Add prefix/suffix
			$this->img->LinkAttrs["target"] = "_blank"; // Add target
			if ($this->Export <> "") $this->img->HrefValue = ew_ConvertFullUrl($this->img->HrefValue);
		} else {
			$this->img->HrefValue = "";
		}
		$this->img->HrefValue2 = $this->img->UploadPath . $this->img->Upload->DbValue;
		$this->img->TooltipValue = "";

		// uid
		$this->uid->LinkCustomAttributes = "";
		$this->uid->HrefValue = "";
		$this->uid->TooltipValue = "";

		// cat
		$this->cat->LinkCustomAttributes = "";
		$this->cat->HrefValue = "";
		$this->cat->TooltipValue = "";

		// sub
		$this->sub->LinkCustomAttributes = "";
		$this->sub->HrefValue = "";
		$this->sub->TooltipValue = "";

		// title
		$this->title->LinkCustomAttributes = "";
		$this->title->HrefValue = "";
		$this->title->TooltipValue = "";

		// descp
		$this->descp->LinkCustomAttributes = "";
		$this->descp->HrefValue = "";
		$this->descp->TooltipValue = "";

		// location
		$this->location->LinkCustomAttributes = "";
		$this->location->HrefValue = "";
		$this->location->TooltipValue = "";

		// datetaken
		$this->datetaken->LinkCustomAttributes = "";
		$this->datetaken->HrefValue = "";
		$this->datetaken->TooltipValue = "";

		// tags
		$this->tags->LinkCustomAttributes = "";
		$this->tags->HrefValue = "";
		$this->tags->TooltipValue = "";

		// views
		$this->views->LinkCustomAttributes = "";
		$this->views->HrefValue = "";
		$this->views->TooltipValue = "";

		// photoby
		$this->photoby->LinkCustomAttributes = "";
		$this->photoby->HrefValue = "";
		$this->photoby->TooltipValue = "";

		// active
		$this->active->LinkCustomAttributes = "";
		$this->active->HrefValue = "";
		$this->active->TooltipValue = "";

		// featured
		$this->featured->LinkCustomAttributes = "";
		$this->featured->HrefValue = "";
		$this->featured->TooltipValue = "";

		// rate_ord
		$this->rate_ord->LinkCustomAttributes = "";
		$this->rate_ord->HrefValue = "";
		$this->rate_ord->TooltipValue = "";

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
				if ($this->img->Exportable) $Doc->ExportCaption($this->img);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->cat->Exportable) $Doc->ExportCaption($this->cat);
				if ($this->sub->Exportable) $Doc->ExportCaption($this->sub);
				if ($this->title->Exportable) $Doc->ExportCaption($this->title);
				if ($this->descp->Exportable) $Doc->ExportCaption($this->descp);
				if ($this->location->Exportable) $Doc->ExportCaption($this->location);
				if ($this->datetaken->Exportable) $Doc->ExportCaption($this->datetaken);
				if ($this->tags->Exportable) $Doc->ExportCaption($this->tags);
				if ($this->views->Exportable) $Doc->ExportCaption($this->views);
				if ($this->photoby->Exportable) $Doc->ExportCaption($this->photoby);
				if ($this->active->Exportable) $Doc->ExportCaption($this->active);
				if ($this->featured->Exportable) $Doc->ExportCaption($this->featured);
				if ($this->datep->Exportable) $Doc->ExportCaption($this->datep);
			} else {
				if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				if ($this->img->Exportable) $Doc->ExportCaption($this->img);
				if ($this->uid->Exportable) $Doc->ExportCaption($this->uid);
				if ($this->cat->Exportable) $Doc->ExportCaption($this->cat);
				if ($this->sub->Exportable) $Doc->ExportCaption($this->sub);
				if ($this->title->Exportable) $Doc->ExportCaption($this->title);
				if ($this->location->Exportable) $Doc->ExportCaption($this->location);
				if ($this->datetaken->Exportable) $Doc->ExportCaption($this->datetaken);
				if ($this->views->Exportable) $Doc->ExportCaption($this->views);
				if ($this->photoby->Exportable) $Doc->ExportCaption($this->photoby);
				if ($this->active->Exportable) $Doc->ExportCaption($this->active);
				if ($this->featured->Exportable) $Doc->ExportCaption($this->featured);
				if ($this->rate_ord->Exportable) $Doc->ExportCaption($this->rate_ord);
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
					if ($this->img->Exportable) $Doc->ExportField($this->img);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->cat->Exportable) $Doc->ExportField($this->cat);
					if ($this->sub->Exportable) $Doc->ExportField($this->sub);
					if ($this->title->Exportable) $Doc->ExportField($this->title);
					if ($this->descp->Exportable) $Doc->ExportField($this->descp);
					if ($this->location->Exportable) $Doc->ExportField($this->location);
					if ($this->datetaken->Exportable) $Doc->ExportField($this->datetaken);
					if ($this->tags->Exportable) $Doc->ExportField($this->tags);
					if ($this->views->Exportable) $Doc->ExportField($this->views);
					if ($this->photoby->Exportable) $Doc->ExportField($this->photoby);
					if ($this->active->Exportable) $Doc->ExportField($this->active);
					if ($this->featured->Exportable) $Doc->ExportField($this->featured);
					if ($this->datep->Exportable) $Doc->ExportField($this->datep);
				} else {
					if ($this->id->Exportable) $Doc->ExportField($this->id);
					if ($this->img->Exportable) $Doc->ExportField($this->img);
					if ($this->uid->Exportable) $Doc->ExportField($this->uid);
					if ($this->cat->Exportable) $Doc->ExportField($this->cat);
					if ($this->sub->Exportable) $Doc->ExportField($this->sub);
					if ($this->title->Exportable) $Doc->ExportField($this->title);
					if ($this->location->Exportable) $Doc->ExportField($this->location);
					if ($this->datetaken->Exportable) $Doc->ExportField($this->datetaken);
					if ($this->views->Exportable) $Doc->ExportField($this->views);
					if ($this->photoby->Exportable) $Doc->ExportField($this->photoby);
					if ($this->active->Exportable) $Doc->ExportField($this->active);
					if ($this->featured->Exportable) $Doc->ExportField($this->featured);
					if ($this->rate_ord->Exportable) $Doc->ExportField($this->rate_ord);
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
		  $_SESSION['lastid'] = $rsnew['id'];      
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
