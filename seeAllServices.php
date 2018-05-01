<?php
require_once 'pear/IT.php';
$tpl = new HTML_Template_IT();

$tpl->loadTemplatefile('templates/seeAllServices.tpl.htm', true, true);


$tpl->touchBlock("LOGO");
$name = "Fred";
$description = "Hello";

$tpl->setCurrentBLock("TABLE");
$tpl->setVariable("NAME", $name);
$tpl->setVariable("DESCRIPTION", $description);
$tpl->parseCurrentBlock();


$tpl->show();
 ?>
