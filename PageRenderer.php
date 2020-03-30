<?php
include (dirname(__FILE__) . "/config/config.php");
include_once("haggle/main.php");
include("{$BasePath}/config/editmode.php");
include("{$BasePath}Structures/Sections/Header.php");
?>
<body>

<?php
$PageStructure = "{$BasePath}Structures/Pages/" . $data->Structure . ".php";
if (isset($data->Structure) && file_exists($PageStructure)) {
    include($PageStructure);
} else {
    include("{$BasePath}Structures/Pages/NoSideBar.php");
}

?>


</body>
<?php
if ($EditMode) {
    ?>
    <a href="#"
       datatype="ConfigEditor"
       data-position="SiteTextLogo"
    >Edit</a>
<?php } ?>

<?php include("{$BasePath}Structures/Sections/Scripts.php"); ?>

