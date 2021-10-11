var globlefuncgeneral = {
    gameover_text: "",
    wheel_text_color: "",
    wheel_stroke_color: "",
    segmentsForSpin: [],
    arrSegmentsList: [],
    theWheel: [],
    actual_JSON: [],
    arrsp: [],
    strarr: "",
    cookidy: 0,
    wheelPower: 0,
    wheelSpinning: false
};

$(document).ready(function () {
    init();
});

function init() {

    var canspin = getCookie("canspin");
    if (canspin != "") {
        if (canspin == "no") {
            $("#spin_button").removeAttr("onclick");
            $(".power_controls").hide();
            $(".reset_btn").show();
        }
        else
        {
            $(".power_controls").show();
            $(".reset_btn").hide();
        }
    }
    else
    {
        $(".power_controls").show();
    }

    loadJSON(function (response) {
        // Parse JSON string into object 
        globlefuncgeneral.actual_JSON = JSON.parse(response);
        var segList = globlefuncgeneral.actual_JSON.data[0].segmentsList;
        globlefuncgeneral.cookidy = globlefuncgeneral.actual_JSON.data[0].cookiedays;

        // Set Background Image, Pointer Image, Wheel Center Image
        var centerWheelImage = globlefuncgeneral.actual_JSON.data[0].centerWheelImage;
        var $WheelPinImage = globlefuncgeneral.actual_JSON.data[0].WheelPinImage;
        var backgroundImage = globlefuncgeneral.actual_JSON.data[0].backgroundOption;
        var $IntroText = globlefuncgeneral.actual_JSON.data[0].IntroText;

        $(".power_controls .title").html($IntroText);
        if ($WheelPinImage != "") {
            var $imgpth = "images/" + $WheelPinImage;
            $(".spin_pin").css({
                'background-repeat': "no-repeat",
                'background-image': 'url(' + $imgpth + ')'
            });
        }

        if (centerWheelImage != "") {
            var $imgpthback = "images/" + centerWheelImage;
            $(".wheel_inner").css({
                'background-image': 'url(' + $imgpthback + ')'
            });
        }

        var $backgroundtype = backgroundImage.type;
        var $backgroundvalue = backgroundImage.value;
        if ($backgroundtype == "text") {
            $(".bgMaindiv").css("background-color", $backgroundvalue);
        }
        else {
            var $imgpthbackmain = "images/" + $backgroundvalue;
            $(".bgMaindiv").css({
                'background-size': '100% auto',
                'background-repeat': 'no-repeat',
                'background-image': 'url(' + $imgpthbackmain + ')'
            });
        }
        // END Set Background Image, Pointer Image, Wheel Center Image

        var segno = 1;
        for (i = 0; i < segList.length; i++) {
            globlefuncgeneral.segmentsForSpin.push(segList[i].txtDisplayText);
            var v = parseInt(segList[i].hdnGravityPerc);
            var rang = v / 10;
            var cntrec = Math.round(rang);
            for (var p = 0; p < cntrec; p++) {
                globlefuncgeneral.arrsp.push(segno);
            }
            globlefuncgeneral.arrSegmentsList.push({
                fillStyle: segList[i].txtBackgroundColor,
                text: segList[i].txtDisplayText,
                winResult: segList[i].txtResultText,
                isCouponExist: segList[i].IsCouponCode,
                CouponCode: segList[i].CouponCode,
            });
            segno = segno + 1;
        }
        globlefuncgeneral.strarr = globlefuncgeneral.arrsp.join('|');
    });

    setTimeout(function () {
        if (globlefuncgeneral.arrSegmentsList.length > 0) {
            var font_size = (globlefuncgeneral.actual_JSON.data[0].WheelTextSize != null && globlefuncgeneral.actual_JSON.data[0].WheelTextSize != "" && globlefuncgeneral.actual_JSON.data[0].WheelTextSize != undefined ? globlefuncgeneral.actual_JSON.data[0].WheelTextSize : 50);
            globlefuncgeneral.gameover_text = (globlefuncgeneral.actual_JSON.data[0].GameOverText != null && globlefuncgeneral.actual_JSON.data[0].GameOverText != "" && globlefuncgeneral.actual_JSON.data[0].GameOverText != undefined ? globlefuncgeneral.actual_JSON.data[0].GameOverText : 'Thanks');
            globlefuncgeneral.wheel_text_color = (globlefuncgeneral.actual_JSON.data[0].WheelTextColor != null && globlefuncgeneral.actual_JSON.data[0].WheelTextColor != "" && globlefuncgeneral.actual_JSON.data[0].WheelTextColor != undefined ? globlefuncgeneral.actual_JSON.data[0].WheelTextColor : '#000000');
            globlefuncgeneral.wheel_stroke_color = (globlefuncgeneral.actual_JSON.data[0].WheelStrokeColor != null && globlefuncgeneral.actual_JSON.data[0].WheelStrokeColor != "" && globlefuncgeneral.actual_JSON.data[0].WheelStrokeColor != undefined ? globlefuncgeneral.actual_JSON.data[0].WheelStrokeColor : '#000000');
            wheel_stroke_width = (globlefuncgeneral.actual_JSON.data[0].WheelStrokeWidth != null && globlefuncgeneral.actual_JSON.data[0].WheelStrokeWidth != "" && globlefuncgeneral.actual_JSON.data[0].WheelStrokeWidth != undefined ? globlefuncgeneral.actual_JSON.data[0].WheelStrokeWidth : '3');
            wheel_inner_radious = (globlefuncgeneral.actual_JSON.data[0].InnerRadius != null && globlefuncgeneral.actual_JSON.data[0].InnerRadius != "" && globlefuncgeneral.actual_JSON.data[0].InnerRadius != undefined ? globlefuncgeneral.actual_JSON.data[0].InnerRadius : '212');
            wheel_outer_radious = (globlefuncgeneral.actual_JSON.data[0].OuterRadius != null && globlefuncgeneral.actual_JSON.data[0].OuterRadius != "" && globlefuncgeneral.actual_JSON.data[0].OuterRadius != undefined ? globlefuncgeneral.actual_JSON.data[0].OuterRadius : '60');

            globlefuncgeneral.theWheel = new Luckywheel({
                'numSegments': globlefuncgeneral.arrSegmentsList.length, // Specify number of segments.
                'outerRadius': parseInt(wheel_outer_radious), // Set radius to so wheel fits the background.
                'innerRadius': parseInt(wheel_inner_radious), // Set inner radius to make wheel hollow.
                'textFontSize': font_size, // Set font size accordingly.
                'textMargin': 0, // Take out default margin.
                'segments': globlefuncgeneral.arrSegmentsList,
                'wheelTextColor': globlefuncgeneral.wheel_text_color, // Set font size accordingly.
                'WheelStrokeColor': globlefuncgeneral.wheel_stroke_color,
                'WheelStrokeWidth': wheel_stroke_width,
                'animation': // Define spin to stop animation.
                        {
                            'type': 'spinToStop',
                            'duration': 5,
                            'spins': 8,
                            'callbackFinished': alertWinResult,
                            'callbackAfter': animafter,
                            'callbackSound': playSpinSound, // Function to call when the tick sound is to be triggered.
                        },
            });

            var audio = new Audio('spinsound.mp3');  // Create audio object and load tick.mp3 file.

            function playSpinSound() {
                jQuery(".spin_pin").rotate(-20);
                audio.pause();
                audio.currentTime = 0;

                // Play the sound.
                audio.play();
            }

            function animafter() {
                jQuery(".spin_pin").rotate(-10);
            }
        }

    }, 500);
}

jQuery.fn.rotate = function (degrees) {
    $(this).css({
        '-webkit-transform': 'rotate(' + degrees + 'deg)',
        '-moz-transform': 'rotate(' + degrees + 'deg)',
        '-ms-transform': 'rotate(' + degrees + 'deg)',
        'transform': 'rotate(' + degrees + 'deg)'
    });
    return $(this);
};

/* Function to handle the onClick on the speed buttons. */
function selectedSpeed(speedLevel) {
    // Ensure that power can't be changed while wheel is spinning.
    if (globlefuncgeneral.wheelSpinning == false) {
        // Reset all to grey incase this is not the first time the user has selected the power.             document.getElementById('lowspeed').className = "";             document.getElementById('mediumspeed').className = "";             document.getElementById('pw3').className = "";

        if (speedLevel >= 1) {
            document.getElementById('lowspeed').className = "lowspeed";
        }

        if (speedLevel >= 2) {
            document.getElementById('mediumspeed').className = "mediumspeed";
        }
        else {
            document.getElementById('mediumspeed').className = "";
        }

        if (speedLevel >= 3) {
            document.getElementById('highspeed').className = "highspeed";
        }
        else {
            document.getElementById('highspeed').className = "";
        }
        // Set wheelPower var used when spin button is clicked.
        globlefuncgeneral.wheelPower = speedLevel;

        // Light up the spin button by changing it's source image and adding a clickable class to it.             
        document.getElementById('spin_button').src = "spin_on.png";
        document.getElementById('spin_button').className = "clickable";
    }
}

// -------------------------------------------------------
// Click handler for spin button.
// -------------------------------------------------------
$(document).on("click", "#spin_button", function () {

    // Ensure that spinning can't be clicked again while already running.
    if (globlefuncgeneral.wheelSpinning == false) {

        // Based on the power level selected adjust the number of spins for the wheel, the more times is has
        // to rotate with the duration of the animation the quicker the wheel spins.
        if (globlefuncgeneral.wheelPower == 1) {
            globlefuncgeneral.theWheel.animation.spins = 3;
        }
        else if (globlefuncgeneral.wheelPower == 2) {
            globlefuncgeneral.theWheel.animation.spins = 8;
        }
        else if (globlefuncgeneral.wheelPower == 3) {
            globlefuncgeneral.theWheel.animation.spins = 15;
        }

        var c = globlefuncgeneral.arrsp.splice(globlefuncgeneral.arrsp.length * Math.random() | 0, 1)[0];
        globlefuncgeneral.theWheel.animation.stopAngle = globlefuncgeneral.theWheel.getRandomForSegment(c);
        if (globlefuncgeneral.arrsp.length == 0) {
            globlefuncgeneral.arrsp = globlefuncgeneral.strarr.split('|');
            //   c = arrsp.splice(arrsp.length * Math.random() | 0, 1)[0] ;
        }

        if (inputName.value === "") {
            alert("Por favor, escribe tu Nombre Completo.");
            inputName.focus();
            return false;
          }
          
          if (inputCar.value === "") {
              
              alert("Por favor, Escriba el modelo de su vehiculo");
              inputCar.focus();
              return false;
            }
            if (inputYear.value === "") {
              alert("Por favor, Escriba el año de su carro");
              inputYear.focus();
              return false;
            }
            if (inputPhone.value === "") {
              alert("Por favor, Escriba su Celular");
              inputPhone.focus();
              return false;
            }
          if (inputAddress.value === "") {
              alert("Por favor, escribe su Dirección");
              inputAddress.focus();
              return false;
            }
            if (inputEmail.value === "") {
              alert("Por favor, escribe tu correo electrónico");
              inputEmail.focus();
              return false;
            }

            

        

        // Disable the spin button so can't click again while wheel is spinning.             document.getElementById('spin_button').src = "spin_off.png";
        document.getElementById('spin_button').className = "";

        // Begin the spin animation by calling startAnimation on the wheel object.
        globlefuncgeneral.theWheel.startAnimation();

        // Set to true so that power can't be changed and spin button re-enabled during
        // the current animation. The user will have to reset before spinning again.
        globlefuncgeneral.wheelSpinning = true;
    }


    

    setCookie("canspin", "no", globlefuncgeneral.cookidy);
    $("#spin_button").removeAttr("onclick");
    $(".power_controls").hide();


});


// -------------------------------------------------------
// Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters.
// note the indicated segment is passed in as a parmeter as 99% of the time you will want to know this to inform the user of their prize.
// -------------------------------------------------------

function alertWinResult(selectedSegment) {

    // Do basic alert of the segment text. You would probably want to do something more interesting with this information.
    //alert(selectedSegment.text + " = " + gameover_text); 
    jQuery(".spin_pin").rotate(0);
    $("#spinWinResult").text(globlefuncgeneral.gameover_text);
    $(".power_controls").hide();

    var response = "";
    if (selectedSegment.isCouponExist == "true")
    {
        response += "<p>" + selectedSegment.winResult + "</p>";
        response += "<p> Tu Codigo de cupon " + selectedSegment.CouponCode + "</p>";
    }
    else
    {
        response += "<p>" + selectedSegment.winResult + "</p>";
    }

    $("#displayprice").html(response);
    $('#spin').modal('show');
    $(".reset_btn").show();

    
}

function loadJSON(callback) {

    try
    {
        if (window.location.host == "")  // when demo run with 'file://index.html
        {
            callback('{"data":[{"segmentsList":[{"txtDisplayText":"20%","txtResultText":"You got 20% discount.","txtBackgroundColor":"#FFC252","ddlGravity":"30","hdnGravityPerc":"15","IsCouponCode":"true","CouponCode":"4444"},{"txtDisplayText":"5%","txtResultText":"You got 5% discount.","txtBackgroundColor":"#FF8CDB","ddlGravity":"30","hdnGravityPerc":"15","IsCouponCode":"true","CouponCode":"456123"},{"txtDisplayText":"15%","txtResultText":"You got 15% discount.","txtBackgroundColor":"#24CFFF","ddlGravity":"10","hdnGravityPerc":"5","IsCouponCode":"true","CouponCode":"4000"},{"txtDisplayText":"25%","txtResultText":"You got 25% discount.","txtBackgroundColor":"#5CFFA0","ddlGravity":"20","hdnGravityPerc":"10","IsCouponCode":"true","CouponCode":"645123"},{"txtDisplayText":"20%","txtResultText":"You got 20% discount.","txtBackgroundColor":"#7A6EFF","ddlGravity":"10","hdnGravityPerc":"5","IsCouponCode":"true","CouponCode":"12345"},{"txtDisplayText":"40%","txtResultText":"You got 40% discount.","txtBackgroundColor":"#FFC457","ddlGravity":"10","hdnGravityPerc":"5","IsCouponCode":"true","CouponCode":"555666"},{"txtDisplayText":"Loss","txtResultText":"You Loss the game.","txtBackgroundColor":"#D09EFF","ddlGravity":"80","hdnGravityPerc":"40","IsCouponCode":"false","CouponCode":""},{"txtDisplayText":"70%","txtResultText":"You got 70% discount.","txtBackgroundColor":"#ABF2FF","ddlGravity":"0","hdnGravityPerc":"0","IsCouponCode":"true","CouponCode":"465456"},{"txtDisplayText":"55%","txtResultText":"You got 55% discount.","txtBackgroundColor":"#9582FF","ddlGravity":"0","hdnGravityPerc":"0","IsCouponCode":"true","CouponCode":"9859895"},{"txtDisplayText":"Jackpot","txtResultText":"You Win Jackpot.","txtBackgroundColor":"#FFBA70","ddlGravity":"0","hdnGravityPerc":"0","IsCouponCode":"true","CouponCode":"111111"},{"txtDisplayText":"95%","txtResultText":"You got 95% discount.","txtBackgroundColor":"#46C97D","ddlGravity":"0","hdnGravityPerc":"0","IsCouponCode":"true","CouponCode":"959595"},{"txtDisplayText":"50%","txtResultText":"You got 50% discount.","txtBackgroundColor":"#87D9FF","ddlGravity":"10","hdnGravityPerc":"5","IsCouponCode":"true","CouponCode":"786512"}],"OuterRadius":"212","InnerRadius":"60","WheelStrokeColor":"#FFFFFF","WheelStrokeWidth":"3","WheelTextColor":"#FFFFFF","WheelTextSize":"20","GameOverText":"THANK YOU FOR PLAYING SPIN2WIN WHEEL. COME AND PLAY AGAIN SOON!","IntroText":"YOU HAVE TO CLICK SPIN BUTTON TO WIN IT!","backgroundOption":{"type":"image","value":"background_12ec1d70a7c72c01f48a1d4416074129.jpg"},"centerWheelImage":"wheelcenter_b8aba481386aabee47bb588032606137.png","WheelPinImage":"wheelcenter_42b535480fd11de938ec249bf2b60678.png","enablediscountbar":"on","countdowntime":"15","position":"screen_bottom","showdesktop":"on","desktopintent":"on","desktopinterval":"on","DesktopIntervaltext":"17","showmobile":"off","mobileintent":"on","mobileinterval":"on","MobileIntervaltext":"19","cookiedays":"5"}]}');
        }
        else
        {

            var xobj = new XMLHttpRequest();
            xobj.overrideMimeType("application/json");
            xobj.open('GET', 'settings.json', true); // Replace 'my_data' with the path to your file
            xobj.onreadystatechange = function () {
                if (xobj.readyState == 4 && xobj.status == "200") {
                    // Required use of an anonymous callback as .open will NOT return a value but simply returns undefined in asynchronous mode
                    callback(xobj.responseText);
                }
            };
            xobj.send(null);
        }
    }
    catch (e)
    {

    }


}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(document).on("click", ".reset_btn", function () {
    setCookie("canspin", "yes", 1);
    alert("Spin reset successfully");
    window.location.reload();
});
