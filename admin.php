
<?php
$str = file_get_contents('settings.json');
$json = json_decode($str, true);

$lstSegments = $json['data'][0]['segmentsList'];

$BackgroundImage = $json['data'][0]['backgroundOption'];
$IntroText = $json['data'][0]['IntroText'];

$enablediscountbar = $json['data'][0]['enablediscountbar'];
$countdowntime = $json['data'][0]['countdowntime'];
$position = $json['data'][0]['position'];

$showdesktop = $json['data'][0]['showdesktop'];
$desktopintent = $json['data'][0]['desktopintent'];
$desktopinterval = $json['data'][0]['desktopinterval'];
$DesktopIntervaltext = $json['data'][0]['DesktopIntervaltext'];

$showmobile = $json['data'][0]['showmobile'];
$mobileintent = $json['data'][0]['mobileintent'];
$mobileinterval = $json['data'][0]['mobileinterval'];
$MobileIntervaltext = $json['data'][0]['MobileIntervaltext'];
$cookiedays = $json['data'][0]['cookiedays'];
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $str = file_get_contents('settings.json');
    $json = json_decode($str, true);

    $enablediscountbar = ((isset($_POST['enablediscountbar']) ? 'on' : 'off'));
    $countdowntime = ((isset($_POST['countdowntime']) ? $_POST['countdowntime'] : '0'));
    $position = ((isset($_POST['position']) ? $_POST['position'] : '0'));

    $showdesktop = ((isset($_POST['showdesktop']) ? 'on' : 'off'));
    $desktopintent = ((isset($_POST['desktopintent']) ? 'on' : 'off'));
    $desktopinterval = ((isset($_POST['desktopinterval']) ? 'on' : 'off'));
    $DesktopIntervaltext = ((isset($_POST['DesktopIntervaltext']) ? $_POST['DesktopIntervaltext'] : '0'));

    $showmobile = ((isset($_POST['showmobile']) ? 'on' : 'off'));
    $mobileintent = ((isset($_POST['mobileintent']) ? 'on' : 'off'));
    $mobileinterval = ((isset($_POST['mobileinterval']) ? 'on' : 'off'));
    $MobileIntervaltext = ((isset($_POST['MobileIntervaltext']) ? $_POST['MobileIntervaltext'] : '0'));

    $cookiedays = ((isset($_POST['cookiedays']) ? $_POST['cookiedays'] : '0'));


    $segmentCnt = $_POST['hdnSegmentCount'];
    if ($_POST['hdnSegmentCount'] != "" && $_POST['hdnSegmentCount'] != null) {
        $strSegments = explode(",", $_POST['hdnSegmentCount']);
    } else {
        $strSegments = array();
    }

    $segmentArray = array();
    if (count($strSegments) > 0) {
        for ($i = 0; $i < count($strSegments); $i++) {

            $txtDisplayText = $_POST['txtDisplayText' . $strSegments[$i] . ''];
            $txtResultText = $_POST['txtResultText' . $strSegments[$i] . ''];
            $txtBackgroundColor = $_POST['txtBackgroundColor' . $strSegments[$i] . ''];
            $gravity = $_POST['ddl_gravity' . $strSegments[$i] . ''];
            $gravityPerc = $_POST['hdnGravityPerc' . $strSegments[$i] . ''];

            $IsCouponCode = $_POST['chkCouponCode' . $strSegments[$i] . ''];
            $txtCouponCodeText = $_POST['txtCouponCodeText' . $strSegments[$i] . ''];

            $segments[] = array(
                'txtDisplayText' => $txtDisplayText,
                'txtResultText' => $txtResultText,
                'txtBackgroundColor' => "#" . $txtBackgroundColor,
                'ddlGravity' => $gravity,
                'hdnGravityPerc' => $gravityPerc,
                'IsCouponCode' => ($IsCouponCode == 'Yes' ? 'true' : 'false'),
                'CouponCode' => ($IsCouponCode == 'Yes' ? $txtCouponCodeText : ''),
            );
        }
    }

    /* Background Image/Text - START */
    if ($_POST['ddlBackgroundOption'] == 'text') {
        $backgroundOption = array(
            "type" => "text",
            "value" => "#" . $_POST['txtBackgroundColor']
        );
    } else {

        $uploadFileName = basename($_FILES['backgroung-image-file']['name']);

        if ($uploadFileName != "" && $uploadFileName != null) {
            $extension = pathinfo($uploadFileName, PATHINFO_EXTENSION);
            $newfilename = "background_" . md5($uploadFileName) . '.' . $extension;
            $uploadfile = 'images/' . $newfilename;

            // Remove Old image
            $BackgroundImage = $json['data'][0]['backgroundOption'];
            $imagefiletodelete = "images/" . $BackgroundImage['value'];
            unlink($imagefiletodelete);

            if (move_uploaded_file($_FILES["backgroung-image-file"]["tmp_name"], $uploadfile)) {
                // echo "The file " . basename($_FILES["backgroung-image-file"]["name"]) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
            }
        } else {
            $newfilename = $_POST['hdnBackgroungImage'];
        }

        $backgroundOption = array(
            "type" => "image",
            "value" => $newfilename
        );
    }

    /* Background Image/Text - END */

    /* Wheel Center Image - START */
    $centerWheelImageFileName = basename($_FILES['wheelcenterimagefile']['name']);

    if ($centerWheelImageFileName != "" && $centerWheelImageFileName != null) {

        $centerWheelImageFileEncryptedFilename = "";
        if ($centerWheelImageFileName != "" && $centerWheelImageFileName != null) {
            $centerWheelImageFileextension = pathinfo($centerWheelImageFileName, PATHINFO_EXTENSION);
            $centerWheelImageFileEncryptedFilename = "wheelcenter_" . md5($centerWheelImageFileName) . '.' . $centerWheelImageFileextension;
            $centerWheelImagefileFullpath = 'images/' . $centerWheelImageFileEncryptedFilename;

            // Remove Old image
            $wheelcenterimagename = $json['data'][0]['centerWheelImage'];
            $_wheelcenterimage_filetodelete = "images/" . $wheelcenterimagename;
            unlink($_wheelcenterimage_filetodelete);

            if (move_uploaded_file($_FILES["wheelcenterimagefile"]["tmp_name"], $centerWheelImagefileFullpath)) {
                // echo "The file " . basename($_FILES["wheelcenterimagefile"]["name"]) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {

        $centerWheelImageFileEncryptedFilename = $_POST["hdnWheelCenterImage"];
    }
    /* Wheel Center Image - END */

    /* Wheel Pin Image - START */
    $pinWheelImageFileName = basename($_FILES['wheelpinimagefile']['name']);

    if ($pinWheelImageFileName != "" && $pinWheelImageFileName != null) {

        $pinWheelImageFileEncryptedFilename = "";
        if ($pinWheelImageFileName != "" && $pinWheelImageFileName != null) {
            $pinWheelImageFileextension = pathinfo($pinWheelImageFileName, PATHINFO_EXTENSION);
            $pinWheelImageFileEncryptedFilename = "wheelcenter_" . md5($pinWheelImageFileName) . '.' . $pinWheelImageFileextension;
            $pinWheelImagefileFullpath = 'images/' . $pinWheelImageFileEncryptedFilename;

            // Remove Old image
            $wheelcenterimagename = $json['data'][0]['centerWheelImage'];
            $pinwheelimage_filetodelete = "images/" . $wheelcenterimagename;
            unlink($pinwheelimage_filetodelete);

            if (move_uploaded_file($_FILES["wheelpinimagefile"]["tmp_name"], $pinWheelImagefileFullpath)) {
                // echo "The file " . basename($_FILES["wheelcenterimagefile"]["name"]) . " has been uploaded.";
            } else {
                // echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {

        $pinWheelImageFileEncryptedFilename = $_POST["hdnWheelPinImage"];
    }
    /* Wheel Pin Image - END */


//store the entire response
    $response = array();
//the array that will hold the titles and links
    $object = array();

//each item from the rows go in their respective vars and into the posts array
    $object[] = array(
        'segmentsList' => $segments,
        'OuterRadius' => $_POST['txtOuterRadius'],
        'InnerRadius' => $_POST['txtInnerRadius'],
        'WheelStrokeColor' => "#" . $_POST['txtWheelStrokeColor'],
        'WheelStrokeWidth' => $_POST['txtWheelStrokeWidth'],
        'WheelTextColor' => "#" . $_POST['txtwheelTextColor'],
        'WheelTextSize' => $_POST['txtwheelTextSize'],
        'GameOverText' => $_POST['txtgameOverText'],
        'IntroText' => $_POST['txtintroText'],
        'backgroundOption' => $backgroundOption,
        'centerWheelImage' => $centerWheelImageFileEncryptedFilename,
        'WheelPinImage' => $pinWheelImageFileEncryptedFilename,
        'enablediscountbar' => $enablediscountbar,
        'countdowntime' => ($enablediscountbar == 'on' ? $countdowntime : '0'),
        'position' => $position,
        'showdesktop' => $showdesktop,
        'desktopintent' => $desktopintent,
        'desktopinterval' => $desktopinterval,
        'DesktopIntervaltext' => $DesktopIntervaltext,
        'showmobile' => $showmobile,
        'mobileintent' => $mobileintent,
        'mobileinterval' => $mobileinterval,
        'MobileIntervaltext' => $MobileIntervaltext,
        'cookiedays' => $cookiedays,
    );

    $response['data'] = $object;

//creates the file
    $fp = fopen('settings.json', 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);

    echo '<script> alert("Setting Updated Successfully"); </script>';
    $server_url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $server_url);
}
?>

<html>
    <head>

        <title> Alian Software-Spin Win </title>
        <link href="css/bootstrap.css" rel="stylesheet"> 
        <link href="css/luckySpin.min.css" rel="stylesheet"> 
    </head>
    <body>

        <div class="container body-content">

            <div class="empty_div" id="h1"></div>

            <form autocomplete="off" enctype="multipart/form-data" id="settingform"  method="post" onsubmit="return formValidation();
                  " >
                <div class="form-horizontal wheel_app" style="display: block;
                     ">
                    <div class="branding">
                        <div class="main_sec">
                            <h2 class="title"> LUCKY SPIN </h2>
                            <p class="page_p">Spin it, Win it ! Be the Lucky One</p>
                        </div>

                        <div class="general">
                            <div class="form-group">

                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <h2 class="title">Wheel Center Image</h2>
                                            <p class="page_p">438 x 582px image, max 500 kb</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="image_logo small_logo">

                                                <?php if ($json['data'][0]['centerWheelImage'] != NULL && $json['data'][0]['centerWheelImage'] != '') : ?>
                                                    <img src="images/<?php echo $json['data'][0]['centerWheelImage'];
                                                    ?>" id="imgWheelCenterImage" name="imgWheelCenterImage" class="big_logo_preview ">
                                                     <?php else : ?>
                                                    <img src="images/no_img.png" id="imgWheelCenterImage" name="imgWheelCenterImage" class="big_logo_preview ">
                                                <?php endif; ?> 
                                                <input type="hidden" name="hdnWheelCenterImage" id="hdnWheelCenterImage" value="<?php echo ($json['data'][0]['centerWheelImage'] != NULL && $json['data'][0]['centerWheelImage'] ? $json['data'][0]['centerWheelImage'] : ""); ?>">
                                            </div>

                                            <div class="upload_btn">
                                                <span class="fake_upload_btn page_btn">Upload</span>
                                                <input type="file" id="wheelcenterimagefile" name="wheelcenterimagefile" onchange="UploadImage(this, 'imgWheelCenterImage');">
                                            </div>
                                            <input type="button" value="X" id="btnRemoveWheelCenterImage" name="btnRemoveWheelCenterImage" class="page_btn">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <h2 class="title">Wheel Pin Image</h2>
                                            <p class="page_p">50 x 50px image, max 50 kb</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="image_logo small_logo"> 
                                                <?php if ($json['data'][0]['WheelPinImage'] != NULL && $json['data'][0]['WheelPinImage'] != '') : ?>
                                                    <img src="images/<?php echo $json['data'][0]['WheelPinImage'];
                                                    ?>" id="imgWheelPinImage" name="imgWheelPinImage" class="big_logo_preview ">
                                                     <?php else : ?>
                                                    <img src="images/no_img.png" id="imgWheelPinImage" name="imgWheelPinImage" class="big_logo_preview ">
                                                <?php endif; ?> 
                                                <input type="hidden" name="hdnWheelPinImage" id="hdnWheelPinImage" value="<?php echo ($json['data'][0]['WheelPinImage'] != NULL && $json['data'][0]['WheelPinImage'] ? $json['data'][0]['WheelPinImage'] : ""); ?>">
                                            </div> 
                                            <div class="upload_btn">
                                                <span class="fake_upload_btn page_btn">Upload</span>
                                                <input type="file" id="wheelpinimagefile" name="wheelpinimagefile" onchange="UploadImage(this, 'imgWheelPinImage');">
                                            </div>
                                            <input type="button" value="X" id="btnRemoveWheelPinImage" name="btnRemoveWheelPinImage" class="page_btn">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="page_hr">


                            <div class="field_text">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h2 class="title">Customize Wheel</h2>
                                    </div>
                                    <div class="col-sm-9">
                                        <table class="table" id="tabletext" name="tabletext">
                                            <thead>
                                                <tr>
                                                    <td>Text name</td>
                                                    <td>Value</td>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                                <tr>
                                                    <td>
                                                        Wheel Outer Radius:
                                                    </td>
                                                    <td>                                                
                                                        <input type="text" class="form-control col-sm-12 text-box single-line" id="txtOuterRadius" placeholder="Enter wheel outer radius" name="txtOuterRadius" value="<?php echo $json['data'][0]['OuterRadius'] ?>">
                                                        <span class="frmError" id="spn_OuterRadius" name="spn_OuterRadius"> This field is required. </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Wheel Inner Radius:
                                                    </td>
                                                    <td>                                                
                                                        <input type="text" class="form-control col-sm-12 text-box single-line" id="txtInnerRadius" placeholder="Enter wheel outer radius" name="txtInnerRadius" value="<?php echo $json['data'][0]['InnerRadius'] ?>">
                                                        <span class="frmError" id="spn_InnerRadius" name="spn_InnerRadius"> This field is required. </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Wheel Stroke Width:
                                                    </td>
                                                    <td>                                                
                                                        <input type="text" class="form-control col-sm-12 text-box single-line" id="txtWheelStrokeWidth" placeholder="Enter Wheel Stroke Width" name="txtWheelStrokeWidth" value="<?php echo $json['data'][0]['WheelStrokeWidth'] ?>">
                                                        <span class="frmError" id="spn_WheelStrokeWidth" name="spn_WheelStrokeWidth"> This field is required. </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Wheel Text Size :
                                                    </td>
                                                    <td>                                                
                                                        <input type="text" class="form-control  col-sm-12 text-box single-line" id="txtwheelTextSize" placeholder="Enter Wheel Text Size" name="txtwheelTextSize" value="<?php echo $json['data'][0]['WheelTextSize'] ?>">
                                                        <span class="frmError" id="spn_wheelTextSize" name="spn_wheelTextSize"> This field is required. </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Game Over Text :
                                                    </td>
                                                    <td>                                                
                                                        <input type="text" class="form-control col-sm-12 text-box single-line" id="txtgameOverText" placeholder="Enter Game Over Text" name="txtgameOverText" value="<?php echo $json['data'][0]['GameOverText'] ?>">
                                                        <span class="frmError" id="spn_gameOverText" name="spn_gameOverText"> This field is required. </span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Intro Text :
                                                    </td>
                                                    <td>                                                
                                                        <input type="text" class="form-control col-sm-12 text-box single-line" id="txtintroText" placeholder="Enter Intro Text" name="txtintroText" value="<?php echo isset($json['data'][0]['IntroText']) ? $json['data'][0]['IntroText'] : "" ?>">
                                                        <span class="frmError" id="spn_introText" name="spn_introText"> This field is required. </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="page_hr">
                            <div class="preview_wheel row">
                                <div class="col-sm-3">
                                    <h2 class="title">Color</h2>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <div class="col-xs-8">
                                            <div class="color_box">
                                                <label class="form-label inline_label">Wheel Stroke Color:</label>
                                                <div class="color_input">
                                                    <input type="text"  class="form-control jscolor" id="txtWheelStrokeColor" placeholder="Enter Wheel Stroke Color" name="txtWheelStrokeColor" value="<?php echo $json['data'][0]['WheelStrokeColor'] ?>">
                                                </div>
                                            </div>
                                            <div class="color_box">
                                                <label class="form-label inline_label">Wheel Text Color :</label>
                                                <div class="color_input">
                                                    <input type="text"  class="form-control jscolor" id="txtwheelTextColor" placeholder="Enter Wheel Text OffsetY" name="txtwheelTextColor" value="<?php echo $json['data'][0]['WheelTextColor'] ?>">
                                                </div>
                                            </div>

                                            <div class="color_box">
                                                <div class="">
                                                    <label class="form-label inline_label">Background Color/Image :</label>
                                                    <div class="color_input">
                                                        <select id="ddlBackgroundOption" name="ddlBackgroundOption" class="input_box" >
                                                            <option value="text" <?php echo ($BackgroundImage['type'] == 'text' ? 'selected="selected"' : '') ?>>Text</option>
                                                            <option value="image" <?php echo ($BackgroundImage['type'] == 'image' ? 'selected="selected"' : '') ?>>Image</option> 
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="color_picker" id="dvBackgroundColor" style="display:<?php echo ($BackgroundImage['type'] == '' || $BackgroundImage['type'] == 'text') ? 'block' : 'none' ?>">                                                
                                                    <div class="image_text">
                                                        <input type="text" class="form-control jscolor" style="width: 110px;margin-top: 11px;" id="txtBackgroundColor" placeholder="Select Background Color" name="txtBackgroundColor" value="<?php echo ($BackgroundImage['type'] == 'text') ? $BackgroundImage['value'] : '' ?>">
                                                    </div>
                                                </div>

                                                <div class="image_selector"  id="dvBackgroundImage" style="display:<?php echo ($BackgroundImage['type'] == 'image') ? 'block' : 'none' ?>">
                                                    <div class="image_text">
                                                        <div class="image_logo big_logo">
                                                            <?php if ($BackgroundImage['type'] == 'image' && $BackgroundImage['value'] != NULL && $BackgroundImage['value'] != '') : ?>
                                                                <img src="images/<?php echo $BackgroundImage['value']; ?>" id="imgBackgroungImage" name="imgBackgroungImage" class="big_logo_preview ">
                                                            <?php else : ?>
                                                                <img src="images/no_img.png" id="imgBackgroungImage" name="imgBackgroungImage" class="big_logo_preview ">
                                                            <?php endif; ?> 
                                                            <input type="hidden" name="hdnBackgroungImage" id="hdnBackgroungImage" value="<?php echo ($BackgroundImage['value'] != NULL && $BackgroundImage['value'] ? $BackgroundImage['value'] : ""); ?>">
                                                        </div>

                                                        <div class="upload_btn">
                                                            <span class="fake_upload_btn page_btn">Upload</span>
                                                            <input type="file" id="backgroung-image-file" name="backgroung-image-file" onchange="UploadImage(this, 'imgBackgroungImage');">
                                                        </div>
                                                        <input type="button" value="X" id="btnRemoveBackgroudImage" name="btnRemoveBackgroudImage" class="page_btn">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="blank_space"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <hr class="page_hr">
                            <div class="form-group coupon" id="h3">
                                <div class="segments_section">
                                    <div class="col-sm-3">
                                        <h2 class="title"> Segments </h2>
                                        <p class="page_p"> From here you can add Coupons/create Segments which will display on the Lucky Spin.You have to provide Segment Name, Win Result (text will display on the segment user got), Coupon Code and Gravity. </p>
                                        <p class="page_p"> Gravity setting example: If you have a segment with 100 gravity and all other slices to 0 gravity, then 100 gravity slice will win every time. </p>
                                    </div>
                                    <div class="col-sm-9">
                                        <table id="tblurl" class="comp_body table">
                                            <thead>
                                                <tr>
                                                    <td>Segment Name</td>
                                                    <td>Segment Background Color </td>
                                                    <td>Win Result</td>
                                                    <td>Coupon Code</td>
                                                    <td>Gravity</td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody id="tblsegments">

                                                <?php if (count($lstSegments) > 0) : $temp = 1; ?>
                                                    <?php foreach ($lstSegments as $value) : ?>
                                                        <tr id="dvdelete_<?php echo $temp; ?>"  class="clscombinations" data-count="<?php echo $temp; ?>">
                                                            <td width="20%">
                                                                <input type="text" id="txtDisplayText<?php echo $temp; ?>" name="txtDisplayText<?php echo $temp; ?>" class="token_input input_box" placeholder="Enter Segment Name" value="<?php echo $value['txtDisplayText']; ?>" />
                                                                <span id="spn_DisplayText<?php echo $temp; ?>" name="spn_DisplayText<?php echo $temp; ?>" class="frmError"> This field is required. </span>
                                                            </td> 
                                                            <td width="10%">
                                                                <input type="text" id="txtBackgroundColor<?php echo $temp; ?>" name="txtBackgroundColor<?php echo $temp; ?>" class="token_input input_box jscolor" placeholder="Select Background Color" value="<?php echo $value['txtBackgroundColor']; ?>" />                                                                
                                                            </td>

                                                            <td width="20%">
                                                                <input type="text" id="txtResultText<?php echo $temp; ?>" name="txtResultText<?php echo $temp; ?>" class="token_input input_box" placeholder="Enter Result Text" value="<?php echo $value['txtResultText']; ?>" />
                                                                <span id="spn_ResultText<?php echo $temp; ?>" name="spn_ResultText<?php echo $temp; ?>" class="frmError"> This field is required. </span>
                                                            </td>

                                                            <td width="40%">
                                                                <div  style="text-align: left;">
                                                                    <span style="text-align: left;"> Have a coupon code ? </span>
                                                                </div>
                                                                <div  style="text-align: left;">
                                                                    <input type="radio" name="chkCouponCode<?php echo $temp; ?>" value="Yes" <?php echo ($value['IsCouponCode'] == 'true' ? 'checked="checked"' : ''); ?>  data-id="<?php echo $temp; ?>" class="clsCouponCode"> Yes
                                                                    <input type="radio" name="chkCouponCode<?php echo $temp; ?>" value="No" <?php echo ($value['IsCouponCode'] == 'false' ? 'checked="checked"' : ''); ?> data-id="<?php echo $temp; ?>" class="clsCouponCode"> No 
                                                                </div>
                                                                <input type="text" id="txtCouponCodeText<?php echo $temp; ?>" name="txtCouponCodeText<?php echo $temp; ?>" class="token_input input_box" placeholder="Enter Coupon Code" value="<?php echo $value['CouponCode']; ?>" style="display:<?php echo ($value['IsCouponCode'] == 'true' ? 'block' : 'none'); ?>;" />
                                                            </td>

                                                            <td width="20%">
                                                                <div class="copon_pr">

                                                                    <select id="ddl_gravity<?php echo $temp; ?>" name="ddl_gravity<?php echo $temp; ?>" class="gravityclass" data-val="true" data-val-number="The field Gravity must be a number." data-val-required="The Gravity field is required." id="ddlgravity_1" name="item.Gravity" onchange="CalculateGravity(<?php echo $temp; ?>, <?php echo $temp; ?>)">
                                                                        <option value="0">0</option>
                                                                        <option value="10" <?php echo ($value['ddlGravity'] == '10' ? 'selected="selected"' : ''); ?>>10</option>
                                                                        <option value="20" <?php echo ($value['ddlGravity'] == '20' ? 'selected="selected"' : ''); ?>>20</option>
                                                                        <option value="30" <?php echo ($value['ddlGravity'] == '30' ? 'selected="selected"' : ''); ?>>30</option>
                                                                        <option value="40" <?php echo ($value['ddlGravity'] == '40' ? 'selected="selected"' : ''); ?>>40</option>
                                                                        <option value="50" <?php echo ($value['ddlGravity'] == '50' ? 'selected="selected"' : ''); ?>>50</option>
                                                                        <option value="60" <?php echo ($value['ddlGravity'] == '60' ? 'selected="selected"' : ''); ?>>60</option>
                                                                        <option value="70" <?php echo ($value['ddlGravity'] == '70' ? 'selected="selected"' : ''); ?>>70</option>
                                                                        <option value="80" <?php echo ($value['ddlGravity'] == '80' ? 'selected="selected"' : ''); ?>>80</option>
                                                                        <option value="90" <?php echo ($value['ddlGravity'] == '90' ? 'selected="selected"' : ''); ?>>90</option>
                                                                        <option value="100" <?php echo ($value['ddlGravity'] == '100' ? 'selected="selected"' : ''); ?>>100</option>
                                                                    </select>
                                                                    <span class="gravityperclass">
                                                                        <?php echo $value['hdnGravityPerc']; ?>%
                                                                    </span>
                                                                    <input type="hidden" id="hdnGravityPerc<?php echo $temp; ?>" name="hdnGravityPerc<?php echo $temp; ?>" class="hdnGravity" value="<?php echo $value['hdnGravityPerc']; ?>" />
                                                                </div>
                                                            </td>

                                                            <td width="5%">
                                                                <?php if ($temp > 1) : ?>
                                                                    <input type="button" value="Delete" id="btndelete_<?php echo $temp; ?>" name="btndelete_<?php echo $temp; ?>" onclick="return DeleteDiv(<?php echo $temp; ?>)" class="clsDeleteDiv del_btn"/>
                                                                <?php endif; ?> 
                                                            </td>
                                                        </tr>
                                                        <?php $temp++; ?>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr id="dvdelete_1"  class="clscombinations" data-count="1">
                                                        <td  width="20%">
                                                            <input type="text" id="txtDisplayText1" name="txtDisplayText1" class="token_input input_box" placeholder="Enter Segment Name" value="" />
                                                            <span id="spn_DisplayText1" name="spn_DisplayText1" class="frmError"> This field is required. </span>
                                                        </td> 
                                                        <td  width="10%">
                                                            <input type="text" id="txtBackgroundColor1" name="txtBackgroundColor1" class="token_input input_box jscolor" placeholder="Select Background Color" value="" />
                                                        </td> 
                                                        <td  width="20%">
                                                            <input type="text" id="txtResultText1" name="txtResultText1" class="token_input input_box" placeholder="Enter Result Text" value="" />
                                                            <span id="spn_ResultText1" name="spn_ResultText1" class="frmError"> This field is required. </span>
                                                        </td>
                                                        <td width="40%">
                                                            <div  style="text-align: left;">
                                                                <span style="text-align: left;"> Have a coupon code ? </span>
                                                            </div>
                                                            <div  style="text-align: left;">
                                                                <input type="radio" name="chkCouponCode1" value="Yes" data-id="1" class="clsCouponCode"> Yes
                                                                <input type="radio" name="chkCouponCode1" value="No" data-id="1" class="clsCouponCode"> No 
                                                            </div>
                                                            <input type="text" id="txtCouponCodeText1" name="txtCouponCodeText1" class="token_input input_box" placeholder="Enter Coupon Code" value="" />
                                                        </td>
                                                        <td width="20%">
                                                            <div class="copon_pr">


                                                                <select id="ddl_gravity1" name="ddl_gravity1" class="gravityclass" data-val="true" data-val-number="The field Gravity must be a number." data-val-required="The Gravity field is required." id="ddlgravity_1" name="item.Gravity" onchange="CalculateGravity(1, 1)">
                                                                    <option value="0">0</option>
                                                                    <option value="10">10</option>
                                                                    <option value="20">20</option>
                                                                    <option value="30">30</option>
                                                                    <option value="40">40</option>
                                                                    <option value="50">50</option>
                                                                    <option value="60">60</option>
                                                                    <option value="70">70</option>
                                                                    <option value="80">80</option>
                                                                    <option value="90">90</option>
                                                                    <option value="100">100</option>
                                                                </select>
                                                                <span class="gravityperclass">
                                                                    0%
                                                                </span>
                                                                <input type="hidden" id="hdnGravityPerc" name="hdnGravityPerc" class="hdnGravity" value="0" />
                                                            </div>
                                                        </td>
                                                        <td  width="5%">
                                                            <input type="button" value="Delete" id="btndelete_1" name="btndelete_1" onclick="return DeleteDiv(1)" class="clsDeleteDiv del_btn"/>
                                                        </td>
                                                    <?php endif; ?>

                                            </tbody>
                                        </table>
                                        <input type="text" id="txtresult" style="display:none;" name="txtresult">
                                        <div>
                                            <input type="button" id="btnAdd" value="Add More" onclick="return AddOption();" class="btn_add page_btn">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr class="page_hr ">
                                </div>
                                <div class="enable_timer">
                                    <div class="col-sm-3">
                                        <h2 class="title">Enable / Disable Discount</h2>
                                    </div>
                                    <div class="col-sm-9">
                                        <label class="switch">
                                            <input type="checkbox" id="enablediscountbar" name="enablediscountbar" <?php echo ($enablediscountbar == 'on' ? 'checked="checked"' : ''); ?>> 
                                            <span class="slider round"></span> Enable <b>discount coupon code bar</b> and countdown
                                        </label>
                                    </div>
                                </div>

                                <div class="timer">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="disable-me" style="display:<?php echo ($enablediscountbar == 'on' ? 'none' : 'block'); ?>"></div>
                                        <div class="input_left">
                                            <label>Countdown time</label>
                                            <input class="input_box text-box single-line" data-val="true" data-val-number="The field CountDownTime must be a number." data-val-required="The CountDownTime field is required." id="countdowntime" name="countdowntime" type="number" value="<?php echo $countdowntime; ?>" <?php echo ($enablediscountbar == 'on' ? '' : 'disabled'); ?>>
                                            <span>min.</span>
                                        </div>
                                        <div class="input_left">
                                            <label>Position</label>
                                            <select id="position" name="position" class="col-md-4 input_box" <?php echo ($enablediscountbar == 'on' ? '' : 'disabled'); ?>>
                                                <option  value="screen_top" <?php echo ($position == 'screen_top' ? 'selected="selected"' : ''); ?>>Screen top</option>
                                                <option value="screen_bottom" <?php echo ($position == 'screen_bottom' ? 'selected="selected"' : ''); ?>>Screen bottom</option>
                                                <option value="page_top" <?php echo ($position == 'page_top' ? 'selected="selected"' : ''); ?>>Page top</option>
                                                <option value="page_bottom" <?php echo ($position == 'page_bottom' ? 'selected="selected"' : ''); ?>>Page bottom</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <hr class="page_hr ">
                                </div>
                                <div class="trigger" id="h2">
                                    <div class="col-sm-3">
                                        <h2 class="title">Triggers &amp; Placement</h2>
                                        <p class="page_p">You can select where you want to display Lucky Spin on Desktop/Mobile.</p>
                                    </div>
                                    <div class=" col-sm-9">
                                        <div class="tab_txt">
                                            <h4>Pullout tab trigger:</h4>
                                            <p class="page_p"> A small Icon which will display on the left side, it opens when any user clicks on it.</p>
                                        </div>
                                        <div class="tab_txt">
                                            <h4>Placement:</h4>
                                            <p class="page_p">Default placement setting is site wide. Spin Win Optin will display on all areas of your site. If you do not want this, please select a specific URL.</p>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-6 show_desk">
                                                <label class="switch">
                                                    <input type="checkbox" id="showdesktop" name="showdesktop" <?php echo ($showdesktop == 'on' ? 'checked="checked"' : ''); ?>>
                                                    <span class="slider round"></span>Show on desktop computers
                                                </label>
                                                <div class="desk_comp">
                                                    <div id="dvdesktop" class="<?php echo ($showdesktop == 'on' ? '' : 'disabled'); ?>" <?php echo ($showdesktop == 'on' ? '' : 'disabled'); ?>>
                                                        <label class="switch">
                                                            <input type="checkbox" id="desktopintent" name="desktopintent" <?php echo ($desktopintent == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <span class="slider round"></span>On user's leave intent<span class="page_p">When mouse leaves browser's viewport</span>
                                                        </label>
                                                        <div class="time_set">
                                                            <label class="switch chk_btn">
                                                                <input type="checkbox" id="desktopinterval" name="desktopinterval" <?php echo ($desktopinterval == 'on' ? 'checked="checked"' : ''); ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                            <div class="after">
                                                                <label for="desktopinterval">After</label>  <input class="form-control col-md-2 input_box text-box single-line" data-val="true" data-val-number="The field DesktopInterval must be a number." data-val-required="The DesktopInterval field is required." <?php echo ($desktopinterval == 'on' ? '' : 'disabled'); ?> id="DesktopIntervaltext" name="DesktopIntervaltext" type="number" value="<?php echo $DesktopIntervaltext; ?>"><span>Seconds</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 show_desk">
                                                <label class="switch">
                                                    <input type="checkbox" id="showmobile" name="showmobile" <?php echo ($showmobile == 'on' ? 'checked="checked"' : ''); ?>>
                                                    <span class="slider round"></span>Show on tablets and mobiles
                                                </label>
                                                <div class="desk_comp">
                                                    <div id="dvmobile" class="<?php echo ($showmobile == 'on' ? '' : 'disabled'); ?>" <?php echo ($showmobile == 'on' ? '' : 'disabled'); ?>>
                                                        <label class="switch">
                                                            <input type="checkbox" id="mobileintent" name="mobileintent" <?php echo ($mobileintent == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <span class="slider round"></span>On user's leave intent<span class="page_p">When users suddenly scrolls upwards</span>
                                                        </label>
                                                        <div class="time_set">
                                                            <label class="switch chk_btn">
                                                                <input type="checkbox" id="mobileinterval" name="mobileinterval" <?php echo ($mobileinterval == 'on' ? 'checked="checked"' : ''); ?>>
                                                                <span class="slider round"></span>
                                                            </label>
                                                            <div class="after">
                                                                <label for="mobileinterval">After</label> <input class="form-control col-md-2 input_box text-box single-line" data-val="true" data-val-number="The field MobileInterval must be a number." data-val-required="The MobileInterval field is required." <?php echo ($mobileinterval == 'on' ? '' : 'disabled'); ?> id="MobileIntervaltext" name="MobileIntervaltext" type="number" value="<?php echo $MobileIntervaltext; ?>"> <span>Seconds</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="page_hr">
                                        <div class="form-group reset_cookie">
                                            <div class="col-sm-12">
                                                <p class="page_p">
                                                    Do not show SpinWinOptin to the same visitor again for that many days (30 days by default):
                                                </p>
                                                <div class="cookie_input">
                                                    <input class="col-md-4 input_box text-box single-line" data-val="true" data-val-number="The field CookieDays must be a number." data-val-required="The CookieDays field is required." id="cookiedays" name="cookiedays" type="number" value="<?php echo $cookiedays; ?>"><span>Days</span>
                                                </div>
                                                <p class="page_p">
                                                    start a new SpinWinOptin campaign! Show it again to everyone no matter how many days have passed.
                                                </p>
                                                <input type="button" value="Reset cookies for all users" class="page_btn resetcookie">
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>

                            <input type="hidden" id="hdnSegmentCount" name="hdnSegmentCount" value="" />
                            <input type="submit" value="Save" id="btnSaveSetting" name="btnSaveSetting" class="page_btn" style="float: right;">
                        </div>
                    </div>
                </div>

            </form>

            <div class="footer_section footer">
                <div class="container">
                    <p>If you have any suggestions, please get in touch with an email: <a href="mailto:support@aliansoftware.net">support@aliansoftware.net</a></p>
                    <p>If you like Spin Win, it would mean the world to us if you could leave a review. For more support, please open a help ticket</p>
                </div>
            </div>

        </div>

    </body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jscolor.js" type="text/javascript"></script>
<script src="js/setting.js" type="text/javascript"></script>
