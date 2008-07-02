<?php session_start();

?>

<html>
<head>
<title>apollo -- novedades</title>
<meta name="generator" http-equiv="content-type" content="text/html">
<style type="text/css">
  body {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
  .bd {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
  .tbl {
    background-color: #FFFFFF;
  }
  a:link { 
    background-color: #FFFFFF01;
    color: #FF0000;
    font-family: Arial;
    font-size: 12px;
  }
  a:active { 
    background-color: #FFFFFF01;
    color: #0000FF;
    font-family: Arial;
    font-size: 12px;
  }
  a:visited { 
    color: #800080;
    font-family: Arial;
    font-size: 12px;
  }
  .hr {
    background-color: #800000;
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  a.hr:link {
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  a.hr:active {
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  a.hr:visited {
    color: #FFFFFF;
    font-family: Arial;
    font-size: 12px;
  }
  .dr {
    background-color: #FFFFFF;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
  .sr {
    background-color: #FFFBF0;
    color: #000000;
    font-family: Arial;
    font-size: 12px;
  }
</style>
</head>
<body>
<table class="bd" width="100%"><tr><td class="hr"><h2>Administrar informacion de la Unidad de PostGrados</h2></td></tr></table>
<?php
  $conn = connect();
  $showrecs = 10;
  $pagerange = 10;

  $a = @$_GET["a"];
  $recid = @$_GET["recid"];
  $page = @$_GET["page"];
  if (!isset($page)) $page = 1;

  $sql = @$_POST["sql"];

  switch ($sql) {
    case "insert":
      sql_insert();
      break;
    case "update":
      sql_update();
      break;
    case "delete":
      sql_delete();
      break;
  }

  switch ($a) {
    case "add":
      addrec();
      break;
    case "view":
      viewrec($recid);
      break;
    case "edit":
      editrec($recid);
      break;
    case "del":
      deleterec($recid);
      break;
    default:
      select();
      break;
  }


  mysql_close($conn);
?>
<table class="bd" width="100%"><tr><td class="hr"><center>Unidad de PostGrados, UES-FMOcc</center></td></tr></table>
</body>
</html>

<?php function select()
  {
  global $a;
  global $showrecs;
  global $page;

  $res = sql_select();
  $count = sql_getrecordcount();
  if ($count % $showrecs != 0) {
    $pagecount = intval($count / $showrecs) + 1;
  }
  else {
    $pagecount = intval($count / $showrecs);
  }
  $startrec = $showrecs * ($page - 1);
  if ($startrec < $count) {mysql_data_seek($res, $startrec);}
  $reccount = min($showrecs * $page, $count);
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr><td>Tabla: novedades</td></tr>
<tr><td>Registros mostrados <?php echo $startrec + 1 ?> - <?php echo $reccount ?> de <?php echo $count ?></td></tr>
</table>
<hr size="1" noshade>
<?php showpagenav($page, $pagecount); ?>
<br>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="100%">
<tr>
<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>
<td class="hr">&nbsp;</td>
<td class="hr"><?php echo "Titulo" ?></td>
<td class="hr"><?php echo "Vinculo/URL" ?></td>
<td class="hr"><?php echo "Descripcion" ?></td>
<td class="hr"><?php echo "Fecha" ?></td>
</tr>
<?php
  for ($i = $startrec; $i < $reccount; $i++)
  {
    $row = mysql_fetch_assoc($res);
    $style = "dr";
    if ($i % 2 != 0) {
      $style = "sr";
    }
?>
<tr>
<td class="<?php echo $style ?>"><a href="novedades.php?a=view&recid=<?php echo $i ?>">Ver</a></td>
<td class="<?php echo $style ?>"><a href="novedades.php?a=edit&recid=<?php echo $i ?>">Modificar</a></td>
<td class="<?php echo $style ?>"><a href="novedades.php?a=del&recid=<?php echo $i ?>">Eliminar</a></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["titulo"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["vinculo"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["descripcion"]) ?></td>
<td class="<?php echo $style ?>"><?php echo htmlspecialchars($row["fecha"]) ?></td>
</tr>
<?php
  }
  mysql_free_result($res);
?>
</table>
<br>
<?php } ?>

<?php function showrow($row, $recid)
  {
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
<tr>
<td class="hr"><?php echo htmlspecialchars("Titulo")."&nbsp;" ?></td>
<td class="dr"><?php echo htmlspecialchars($row["titulo"]) ?></td>
</tr>
<tr>
<td class="hr"><?php echo htmlspecialchars("Vinculo/URL")."&nbsp;" ?></td>
<td class="dr"><?php echo htmlspecialchars($row["vinculo"]) ?></td>
</tr>
<tr>
<td class="hr"><?php echo htmlspecialchars("Descripcion")."&nbsp;" ?></td>
<td class="dr"><?php echo htmlspecialchars($row["descripcion"]) ?></td>
</tr>
<tr>
<td class="hr"><?php echo htmlspecialchars("Fecha")."&nbsp;" ?></td>
<td class="dr"><?php echo htmlspecialchars($row["fecha"]) ?></td>
</tr>
</table>
<?php } ?>

<?php function showroweditor($row, $iseditmode)
  {
  global $conn;
?>
<table class="tbl" border="0" cellspacing="1" cellpadding="5"width="50%">
<tr>
<td class="hr"><?php echo htmlspecialchars("Titulo")."&nbsp;" ?></td>
<td class="dr"><input type="text" name="titulo" value="<?php echo str_replace('"', '&quot;', trim($row["titulo"])) ?>"></td>
</tr>
<tr>
<td class="hr"><?php echo htmlspecialchars("Vinculo/URL")."&nbsp;" ?></td>
<td class="dr"><textarea cols="35" rows="4" name="vinculo" maxlength="50"><?php echo str_replace('"', '&quot;', trim($row["vinculo"])) ?></textarea></td>
</tr>
<tr>
<td class="hr"><?php echo htmlspecialchars("Descripcion")."&nbsp;" ?></td>
<td class="dr"><textarea cols="35" rows="4" name="descripcion" maxlength="100"><?php echo str_replace('"', '&quot;', trim($row["descripcion"])) ?></textarea></td>
</tr>
<tr>
<td class="hr"><?php echo htmlspecialchars("Fecha")."&nbsp;" ?></td>
<td class="dr"><input type="text" name="fecha" maxlength="65535" value="<?php echo str_replace('"', '&quot;', trim($row["fecha"])) ?>"></td>
</tr>
</table>
<?php } ?>

<?php function showpagenav($page, $pagecount)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="novedades.php?a=add">Agregar Registro</a>&nbsp;</td>
<?php if ($page > 1) { ?>
<td><a href="novedades.php?page=<?php echo $page - 1 ?>">&lt;&lt;&nbsp;Anterior</a>&nbsp;</td>
<?php } ?>
<?php
  global $pagerange;

  if ($pagecount > 1) {

  if ($pagecount % $pagerange != 0) {
    $rangecount = intval($pagecount / $pagerange) + 1;
  }
  else {
    $rangecount = intval($pagecount / $pagerange);
  }
  for ($i = 1; $i < $rangecount + 1; $i++) {
    $startpage = (($i - 1) * $pagerange) + 1;
    $count = min($i * $pagerange, $pagecount);

    if ((($page >= $startpage) && ($page <= ($i * $pagerange)))) {
      for ($j = $startpage; $j < $count + 1; $j++) {
        if ($j == $page) {
?>
<td><b><?php echo $j ?></b></td>
<?php } else { ?>
<td><a href="novedades.php?page=<?php echo $j ?>"><?php echo $j ?></a></td>
<?php } } } else { ?>
<td><a href="novedades.php?page=<?php echo $startpage ?>"><?php echo $startpage ."..." .$count ?></a></td>
<?php } } } ?>
<?php if ($page < $pagecount) { ?>
<td>&nbsp;<a href="novedades.php?page=<?php echo $page + 1 ?>">Siguiente&nbsp;&gt;&gt;</a>&nbsp;</td>
<?php } ?>
</tr>
</table>
<?php } ?>

<?php function showrecnav($a, $recid, $count)
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="novedades.php">Pagina principal</a></td>
<?php if ($recid > 0) { ?>
<td><a href="novedades.php?a=<?php echo $a ?>&recid=<?php echo $recid - 1 ?>">Registro Anterior</a></td>
<?php } if ($recid < $count - 1) { ?>
<td><a href="novedades.php?a=<?php echo $a ?>&recid=<?php echo $recid + 1 ?>">Registro Siguiente</a></td>
<?php } ?>
</tr>
</table>
<hr size="1" noshade>
<?php } ?>

<?php function addrec()
{
?>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="novedades.php">Pagina principal</a></td>
</tr>
</table>
<hr size="1" noshade>
<form enctype="multipart/form-data" action="novedades.php" method="post">
<p><input type="hidden" name="sql" value="insert"></p>
<?php
$row = array(
  "id" => "",
  "titulo" => "",
  "vinculo" => "",
  "descripcion" => "",
  "fecha" => "");
showroweditor($row, false);
?>
<p><input type="submit" name="action" value="Establecer"></p>
</form>
<?php } ?>

<?php function viewrec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("view", $recid, $count);
?>
<br>
<?php showrow($row, $recid) ?>
<br>
<hr size="1" noshade>
<table class="bd" border="0" cellspacing="1" cellpadding="4">
<tr>
<td><a href="novedades.php?a=add">Agregar Registro</a></td>
<td><a href="novedades.php?a=edit&recid=<?php echo $recid ?>">Editar Registro</a></td>
<td><a href="novedades.php?a=del&recid=<?php echo $recid ?>">Eliminar Registro</a></td>
</tr>
</table>
<?php
  mysql_free_result($res);
} ?>

<?php function editrec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("edit", $recid, $count);
?>
<br>
<form enctype="multipart/form-data" action="novedades.php" method="post">
<input type="hidden" name="sql" value="update">
<input type="hidden" name="xid" value="<?php echo $row["id"] ?>">
<?php showroweditor($row, true); ?>
<p><input type="submit" name="action" value="Establecer"></p>
</form>
<?php
  mysql_free_result($res);
} ?>

<?php function deleterec($recid)
{
  $res = sql_select();
  $count = sql_getrecordcount();
  mysql_data_seek($res, $recid);
  $row = mysql_fetch_assoc($res);
  showrecnav("del", $recid, $count);
?>
<br>
<form action="novedades.php" method="post">
<input type="hidden" name="sql" value="delete">
<input type="hidden" name="xid" value="<?php echo $row["id"] ?>">
<?php showrow($row, $recid) ?>
<p><input type="submit" name="action" value="Confirmar"></p>
</form>
<?php
  mysql_free_result($res);
} ?>

<?php function connect()
{
  $conn = mysql_connect("localhost", "root", "toor");
  mysql_select_db("apollo");
  return $conn;
}

function sqlvalue($val, $quote)
{
  if ($quote)
    $tmp = sqlstr($val);
  else
    $tmp = $val;
  if ($tmp == "")
    $tmp = "NULL";
  elseif ($quote)
    $tmp = "'".$tmp."'";
  return $tmp;
}

function sqlstr($val)
{
  return str_replace("'", "''", $val);
}

function sql_select()
{
  global $conn;
  $sql = "SELECT `id`, `titulo`, `vinculo`, `descripcion`, `fecha` FROM `novedades`";
  $res = mysql_query($sql, $conn) or die(mysql_error());
  return $res;
}

function sql_getrecordcount()
{
  global $conn;
  $sql = "SELECT COUNT(*) FROM `novedades`";
  $res = mysql_query($sql, $conn) or die(mysql_error());
  $row = mysql_fetch_assoc($res);
  reset($row);
  return current($row);
}

function sql_insert()
{
  global $conn;
  global $_POST;

  $sql = "insert into `novedades` (`titulo`, `vinculo`, `descripcion`, `fecha`) values (" .sqlvalue(@$_POST["titulo"], true).", " .sqlvalue(@$_POST["vinculo"], true).", " .sqlvalue(@$_POST["descripcion"], true).", " .sqlvalue(@$_POST["fecha"], true).")";
  mysql_query($sql, $conn) or die(mysql_error());
}

function sql_update()
{
  global $conn;
  global $_POST;

  $sql = "update `novedades` set `titulo`=" .sqlvalue(@$_POST["titulo"], true).", `vinculo`=" .sqlvalue(@$_POST["vinculo"], true).", `descripcion`=" .sqlvalue(@$_POST["descripcion"], true).", `fecha`=" .sqlvalue(@$_POST["fecha"], true) ." where " .primarykeycondition();
  mysql_query($sql, $conn) or die(mysql_error());
}

function sql_delete()
{
  global $conn;

  $sql = "delete from `novedades` where " .primarykeycondition();
  mysql_query($sql, $conn) or die(mysql_error());
}
function primarykeycondition()
{
  global $_POST;
  $pk = "";
  $pk .= "(`id`";
  if (@$_POST["xid"] == "") {
    $pk .= " IS NULL";
  }else{
  $pk .= " = " .sqlvalue(@$_POST["xid"], false);
  };
  $pk .= ")";
  return $pk;
}
 ?>
