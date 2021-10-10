
var addedSegments = 1;

function formValidation()
{
    var flag = true;
    $(".frmError").hide();

    var txtWheelStrokeWidth = $("#txtWheelStrokeWidth").val().trim();
    var txtwheelTextSize = $("#txtwheelTextSize").val().trim();
    var txtgameOverText = $("#txtgameOverText").val().trim();
    var txtintroText = $("#txtintroText").val().trim();
    var txtOuterRadius = $("#txtOuterRadius").val().trim();
    var txtInnerRadius = $("#txtInnerRadius").val().trim();

    if (txtWheelStrokeWidth == "" || txtWheelStrokeWidth == null)
    {
        flag = false;
        $("#spn_WheelStrokeWidth").show();
    }
    if (txtwheelTextSize == "" || txtwheelTextSize == null)
    {
        flag = false;
        $("#spn_wheelTextSize").show();
    }
    if (txtgameOverText == "" || txtgameOverText == null)
    {
        flag = false;
        $("#spn_gameOverText").show();
    }
    
    if (txtintroText == "" || txtintroText == null)
    {
        flag = false;
        $("#spn_introText").show();
    }

    if (txtOuterRadius == "" || txtOuterRadius == null)
    {
        flag = false;
        $("#spn_OuterRadius").show();
    }
    if (txtInnerRadius == "" || txtInnerRadius == null)
    {
        flag = false;
        $("#spn_InnerRadius").show();
    }

    $("#tblsegments tr").each(function () {
        var id = $(this).attr("data-count");
        var display_text = $("#txtDisplayText" + id + "").val().trim();
        var result_text = $("#txtResultText" + id + "").val().trim();
        if (display_text == "" || display_text == null)
        {
            flag = false;
            $("#spn_DisplayText" + id + "").show();
        }
        if (result_text == "" || result_text == null)
        {
            flag = false;
            $("#spn_ResultText" + id + "").show();
        }
    });

    if (flag == true)
    {
        var segment_count_string = "";

        $("#tblsegments tr").each(function () {
            segment_count_string += $(this).attr("data-count") + ",";
        });
        $("#hdnSegmentCount").val(segment_count_string.substring(0, segment_count_string.length - 1));

        return true;
    }
    else
    {
        $("html, body").animate({scrollTop: 0}, "slow");
        return false;
    }

}
  
$("#btnRemoveBackgroudImage").click(function () {
    $("#imgBackgroungImage").attr('src', '');
    $("#hdnBackgroungImage").val('');
    $("#backgroung-image-file").val('');
});

$("#btnRemoveWheelCenterImage").click(function () {
    $("#imgWheelCenterImage").attr('src', 'images/no_img.png');
    $("#hdnWheelCenterImage").val("");
});

$("#btnRemoveWheelPinImage").click(function () {
    $("#imgWheelPinImage").attr('src', '');
    $("#hdnWheelPinImage").val('');
    $("#wheelpinimagefile").val('');
});

$(document).on("change", "#ddlBackgroundOption", function () {
    var selectedOption = $("#ddlBackgroundOption option:selected").val();
    if (selectedOption == "text")
    {
        $("#dvBackgroundColor").show();
        $("#dvBackgroundImage").hide();
    }
    else
    {
        $("#dvBackgroundColor").hide();
        $("#dvBackgroundImage").show();
    }

});

$(document).on("change", ".clsCouponCode", function () {
    var id = $(this).attr("data-id");
    var value = $(this).val();

    if (value == "Yes")
    {
        $("#txtCouponCodeText" + id).show();
    }
    else
    {
        $("#txtCouponCodeText" + id).hide();
    }

});

function AddOption() {
    addedSegments++;
    $("#tblsegments").append('<tr id="dvdelete_' + addedSegments + '"  class="clscombinations" data-count="' + addedSegments + '"><td width="20%">' +
            '<input type="text" id="txtDisplayText' + addedSegments + '" name="txtDisplayText' + addedSegments + '" class="token_input input_box" placeholder="Enter Segment Name" />' +
            '<span id="spn_DisplayText" name="spn_DisplayText' + addedSegments + '" class="frmError"> This field is required. </span></td>' +
            '<td width="10%">' +
            '<input type="text" id="txtBackgroundColor' + addedSegments + '" name="txtBackgroundColor' + addedSegments + '" class="token_input input_box jscolor" placeholder="Select Background Color" />' +
            '</td>' +
            '<td width="20%">' +
            '<input type="text" id="txtResultText' + addedSegments + '" name="txtResultText' + addedSegments + '" class="token_input input_box" placeholder="Enter Result Text" />' +
            '<span id="spn_ResultText' + addedSegments + '" name="spn_ResultText' + addedSegments + '" class="frmError"> This field is required. </span>' +
            '</td>' +
            '<td width="40%">' +
            '<div  style="text-align: left;">' +
            '<span style="text-align: left;"> Have a coupon code ? </span>' +
            '</div>' +
            '<div  style="text-align: left;">' +
            '<input type="radio" name="chkCouponCode' + addedSegments + '" checked="checked" value="Yes" data-id="' + addedSegments + '" class="clsCouponCode"> Yes' +
            '<input type="radio" name="chkCouponCode' + addedSegments + '" value="No" data-id="' + addedSegments + '" class="clsCouponCode" style="margin-left: 5px;"> No ' +
            '</div>' +
            '<input type="text" id="txtCouponCodeText' + addedSegments + '" name="txtCouponCodeText' + addedSegments + '" class="token_input input_box" placeholder="Enter Coupon Code" value="" />' +
            '</td>' +
            '<td width="20%">' +
            '<div class="copon_pr">' +
            '<select id="ddl_gravity' + addedSegments + '" name="ddl_gravity' + addedSegments + '" class="gravityclass" data-val="true" data-val-number="The field Gravity must be a number." data-val-required="The Gravity field is required." onchange="CalculateGravity(' + addedSegments + ', ' + addedSegments + ')">' +
            '<option value="0">0</option>' +
            '<option value="10">10</option>' +
            '<option value="20">20</option>' +
            '<option value="30">30</option>' +
            '<option value="40">40</option>' +
            '<option value="50">50</option>' +
            '<option value="60">60</option>' +
            '<option value="70">70</option>' +
            '<option value="80">80</option>' +
            '<option value="90">90</option>' +
            '<option value="100">100</option>' +
            '</select>' +
            '<span class="gravityperclass">0%</span>' +
            '<input type="hidden" id="hdnGravityPerc' + addedSegments + '" name="hdnGravityPerc' + addedSegments + '" class="hdnGravity" value="0" />' +
            '</div>' +
            '</td>' +
            '<td width="5%"><input type="button" value="Delete" id="btndelete_' + addedSegments + '" name="btndelete_' + addedSegments + '" onclick="return DeleteDiv(' + addedSegments + ')" class="clsDeleteDiv del_btn"/></td>' +
            '</tr>');

    /* open color picker for dynamic elements */
    jscolor.installByClassName("jscolor");
}

function DeleteDiv(id) {
    id = $.trim(id);
    $("#dvdelete_" + id).remove();
}

function UploadImage(target, imageid) {
    var file = target.files[0];
    if (file.size <= 500000) {
        if (file) {
            // Create a new image
            var img = new Image();
            // Handle onload (will contain data after file has loaded)
            img.src = (window.URL || window.webkitURL).createObjectURL(file);
            $("#" + imageid).attr('src', (window.URL || window.webkitURL).createObjectURL(file));
        }
    }
    else {
        alert("Image size should be less than 500 kb !");
    }
}

function CalculateGravity(index, id) {
    var values = [];

    $('#tblurl tbody tr').each(function (row, tr) {
        values.push($(tr).find('.gravityclass').val());
    });

    var total = 0;
    for (var i = 0; i < values.length; i++) {
        total += values[i] << 0;
    }

    var perarray = [];
    for (var i = 0; i < values.length; i++) {

        var grav = values[i];
        var gravper;

        if (total == 0)
            gravper = 0;
        else
            gravper = grav / total;

        gravper = Math.round(gravper * 100);
        perarray.push(gravper);
    }

    var index = 0;
    $('#tblurl tbody tr').each(function (row, tr) {
        $(tr).find('.gravityperclass').text(perarray[index] + "%");
        $(tr).find('.hdnGravity').val(perarray[index]);

        index++;
    });

}

$('#enablediscountbar').change(function () {
    if (this.checked) {
        $(".disable-me").css("display", "none");
        $("#countdowntime").prop("disabled", false);
        $("#position").prop("disabled", false);
    }
    else {
        $(".disable-me").css("display", "block");
        $("#countdowntime").prop("disabled", true);
        $("#position").prop("disabled", true);
    }
});

$('#showdesktop').change(function () {
    $("#dvdesktop").toggleClass("disabled");
});

$('#showmobile').change(function () {
    $("#dvmobile").toggleClass("disabled");
});

$('#desktopinterval').change(function () {
    if (this.checked) {
        $("#DesktopIntervaltext").prop("disabled", false);
    }
    else {
        $("#DesktopIntervaltext").prop("disabled", true);
    }
});

$('#mobileinterval').change(function () {
    if (this.checked) {
        $("#MobileIntervaltext").prop("disabled", false);
    }
    else {
        $("#MobileIntervaltext").prop("disabled", true);
    }
});

$(document).on("click", ".resetcookie", function (event) {

    if (confirm("Are you sure want to reset cookies for all users ?") == true) {
        alert("Cookies are reset.");
    }

});
