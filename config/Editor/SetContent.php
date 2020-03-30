<?php
$Images = array_diff(scandir(dirname(__FILE__) . "/../../images"), array('.', '..'));

include_once(dirname(__FILE__) . "../../../config/config.php");
if (isset($_REQUEST['SetContent'])) {

    if (!isset($_REQUEST['Text'])) {
        $Nodes = [];
    } else {
        $Nodes = $_REQUEST['Text'];
    }
    if ($Nodes === null) {
        $Nodes = [];
    }
    $newContent = array("Text" => $Nodes);

    SetCurrentValueByDataPosition($_REQUEST['dp'], $_REQUEST['overwrite'], $newContent);
    echo "Content Updated. Refresh to see changes.";
}
if (isset($_REQUEST['Delete'])) {
    DeleteCurrentValueByDataPosition($_REQUEST['dp'], $_REQUEST['overwrite']);
    echo "Content Updated. Refresh to see changes.";
    exit;
}

if (!preg_match('/\[\]$/', $_REQUEST['dp'])) {


    $Content = GetCurrentValueByDataPosition($_REQUEST['dp'], $_REQUEST['overwrite']);
    if (!isset($Content)) {
        echo "No such Content " . $_REQUEST['dp'] . ' ' . $_REQUEST['overwrite'];
        $Content = (object)array("ImageBefore" => '', "ImageAfter" => '', "Text" => [], "SubHeader" => '');
    } else {
        $Content = (object)$Content;
    }
} else {
    $Content = (object)array("ImageBefore" => '', "ImageAfter" => '', "Text" => [], "SubHeader" => '');
}

?>
<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet"
          href="/assets/css/main<?php if (isset($_REQUEST['variation'])) echo $_REQUEST['variation']; ?>.css"/>
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <button type="submit" name="Delete">Delete this node (careful no undo)</button>

    <div id="TextNodes">
        <br/>
        <?php foreach ($Content->Text as $Text) { ?>
            <div>
                <label for="Text">Html sections
                    <br/>
                    <button type="button" onclick="$(this).parent().parent().remove()">delete this html section</button>
                    <button type="button" class="  primary" onclick="AddNode($(this).parent().parent())">Add Html
                        section
                        Before this one
                    </button>
                    <button type="button" onclick="AddNode()">Add Html section After</button>
                </label>
                <textarea rows="<?php echo count(explode("\n", $Text)); ?>"
                          name="Text[]"><?php echo htmlentities($Text); ?></textarea>
            </div>
        <?php } ?>

    </div>
    <?php

    if (count($Content->Text) === 0) {
        ?>
        <div>
            <label for="Text">Html sections
                <br/>
                <button type="button" onclick="$(this).parent().parent().remove()">delete this html section</button>
                <button type="button" class="  primary" onclick="AddNode($(this).parent().parent())">Add Html
                    section
                    Before this one
                </button>
                <button type="button" onclick="AddNode()">Add Html section After</button>
            </label>
            <textarea rows="<?php echo count(explode("\n", $Text)); ?>"
                      name="Text[]"><?php echo htmlentities($Text); ?></textarea>
        </div>
        <?php
    }
    ?>

    <input type="hidden" name="dp" value="<?php echo $_REQUEST['dp']; ?>"/>
    <input type="hidden" name="overwrite" value="<?php echo $_REQUEST['overwrite']; ?>"/>

    <button type="submit" class="fit" value="Set Content" name="SetContent">Update/Save Content</button>
</form>
<script src="/assets/js/jquery.min.js"></script>
<script>
    function AddNode(node) {
        if (node) {
            $(node).before($("<div>    <label for=\"Text\">Html Node\n" +
                "                    <button onclick=\"$(this).parent().parent().remove()\">delete</button>               <button type=\"button\" class=\"  primary\" onclick=\"AddNode($(this).parent().parent())\">Add Html Node Before this one</button>\n" +
                "                </label>\n" +
                "                <textarea name=\"Text[]\"></textarea>"))
            return;
        }
        $('#TextNodes').append($("<div>    <label for=\"Text\">Html Node\n" +
            "                    <button onclick=\"$(this).parent().parent().remove()\">delete</button>               <button type=\"button\" class=\"  primary\" onclick=\"AddNode($(this).parent().parent())\">Add Html Node Before this one</button>\n" +
            "                </label>\n" +
            "                <textarea name=\"Text[]\"></textarea>"))
    }
</script>
</body>
</html>