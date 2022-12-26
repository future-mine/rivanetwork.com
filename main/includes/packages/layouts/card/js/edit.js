var $statusClick = true;

$("#play-button").on("click", function() {
    function playButton(type)
    {
        if (type == false) {
            return $('#play-button').attr('disabled', 'disabled').addClass('disabled').css('cursor', 'no-drop');
        } else if (type == true) {
            return $('#play-button').removeAttr('disabled').removeClass('disabled').css('cursor', 'pointer');
        }
    }
    playButton(false);
    var $ajaxUrl = "/main/includes/packages/layouts/card/php/proccess.php";
    
    function playMusic(type)
    {
        var $type = type;
        if ($type == "click") {
            let musicClick = new Audio('/main/includes/packages/layouts/card/sounds/click.mp3').play();
            return musicClick;
        } else if ($type == "winner") {
            let musicWinner = new Audio('/main/includes/packages/layouts/card/sounds/winner.ogg').play();
            return musicWinner;
        } else if ($type == "loser") {
            let musicLoser = new Audio('/main/includes/packages/layouts/card/sounds/loser.mp3').play();
            return musicLoser;
        }
    }
    
    function reward(name, image, credit, type, cardType)
    {
      if (cardType == "1") {
        if (type == "winner") {
          playMusic("winner");
          swal.fire({
            title: name + " " + $languages["cardGameJSWinner"],
            html: "<center><div class=\"row card-game\">  <div class=\"col-md-3\"></div>  <div class=\"col-md-6 ml-2\">    <div class=\"card-game-card flip\">      <div class=\"card-game-back\">        <img style=\"transform: rotateX(0) rotateY(360deg);\" src=\"" + image + "\" alt=\"" + $languages["cardGameJSReward"] + " - " + name + "\">      </div>    </div>  </div></div><br>" + $languages["cardGameJSWinnerText"].replaceAll("&credit", credit).replaceAll("&reward", name) + "</center>",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          }).then(function() {
              window.location = $links["inventory"];
          });
        } else if (type == "loser") {
          playMusic("loser");
          swal.fire({
            title: $languages["cardGameJSLoserTitle"],
            html: "<center><div class=\"row card-game\">  <div class=\"col-md-3\"></div>  <div class=\"col-md-6 ml-2\">    <div class=\"card-game-card flip\">      <div class=\"card-game-back\">        <img style=\"transform: rotateX(0) rotateY(360deg);\" src=\"" + image + "\" alt=\"" + $languages["cardGameJSReward"] + " - " + name + "\">      </div>    </div>  </div></div><br>" + $languages["cardGameJSLoserText"].replaceAll("&credit", credit) + "</center>",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          }).then(function() {
              location.reload();
          });
        }
      } else if (cardType == "0") {
        if (type == "winner") {
          playMusic("winner");
          swal.fire({
            title: name + " " + $languages["cardGameJSWinner"],
            html: "<center><div class=\"row card-game\">  <div class=\"col-md-3\"></div>  <div class=\"col-md-6 ml-2\">    <div class=\"card-game-card flip\">      <div class=\"card-game-back\">        <img style=\"transform: rotateX(0) rotateY(360deg);\" src=\"" + image + "\" alt=\"" + $languages["cardGameJSReward"] + " - " + name + "\">      </div>    </div>  </div></div><br>" + $languages["cardGameJSWinnerText0"].replaceAll("&reward", name) + "</center>",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          }).then(function() {
              window.location = $links["inventory"];
          });
        } else if (type == "loser") {
          playMusic("loser");
          swal.fire({
            title: $languages["cardGameJSLoserTitle"],
            html: "<center><div class=\"row card-game\">  <div class=\"col-md-3\"></div>  <div class=\"col-md-6 ml-2\">    <div class=\"card-game-card flip\">      <div class=\"card-game-back\">        <img style=\"transform: rotateX(0) rotateY(360deg);\" src=\"" + image + "\" alt=\"" + $languages["cardGameJSReward"] + " - " + name + "\">      </div>    </div>  </div></div><br>" + $languages["cardGameJSLoserText0"] + "</center>",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          }).then(function() {
              location.reload();
          });
        }
      }
    }
    
    $.ajax({
      type: "POST",
      url: $ajaxUrl,
      data: {cardID: cardID},
      success: function(result) {
        var ajaxData = JSON.parse(result);
        if (ajaxData.code == "successyfull") {
          swal.fire({
            title: $languages["info"],
            text: $languages["cardGameJSInfoText"],
            icon: "warning",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          });
          
          var visibleID = document.getElementById('card-game-visible');
          visibleID.style.display = "none";
          
          $('#card-game-info').css('display', 'none');
          if ($statusClick == true) {
            $('.card-game-card').on("click", function(e) {
              visibleID.style.display = "block";
              $('.card-game-card').attr('disabled', 'disabled').addClass('disabled').css('cursor', 'no-drop');
              playMusic("click");
              var $statusClick = false;
              swal.fire({
                title:  $languages["warning"],
                html: $languages["cardGameJSOpenText"] + '<br><br><div class="loader-bars"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div></div><br>',
                icon: "warning",
                allowOutsideClick: false,
                showConfirmButton: false
              });
              
              // REWARD DATA
              var $rewardName = ajaxData.name;
              var $rewardImage = ajaxData.image;
              var $rewardCredit = ajaxData.credit;
              var $rewardType = ajaxData.type;
              var $cardType = ajaxData.cardType;
              setTimeout(() => {
                reward($rewardName, $rewardImage, $rewardCredit, $rewardType, $cardType);
              }, 2000);
            });
          }
        } else if (ajaxData.code == "dataError" || ajaxData.code == "systemError" || ajaxData.code == "") {
          swal.fire({
            title: $languages["error"],
            text: $languages["systemError"],
            icon: "error",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          }).then(function() {
            location.reload();
          });
        } else if (ajaxData.code == "notLogin") {
          swal.fire({
            title: $languages["error"],
            text: $languages["cardGameJSLoginError"],
            icon: "error",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["login"]
          }).then(function() {
            window.location = '/giris-yap';
          });
       } else if (ajaxData.code == "insufficientCredit") {
          swal.fire({
            title: $languages["error"],
            text: $languages["cardGameJSCreditError"],
            icon: "error",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["creditUpload"]
          }).then(function() {
            window.location = '/kredi/yukle';
          });
       } else if (ajaxData.code == "inventorySlot") {
          swal.fire({
            title: $languages["error"],
            text: $languages["cardGameJSInventoryError"],
            icon: "error",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["goInventory"]
          }).then(function() {
            window.location = '/envanter';
          });
       } else if (ajaxData.code == "notHours") {
          swal.fire({
            title: $languages["error"],
            text: $languages["cardGameJSHoursError"].replaceAll("&date", ajaxData.after),
            icon: "error",
            confirmButtonColor: "#02b875",
            confirmButtonText: $languages["okey"]
          });
          playButton(true);
       }
     }
    });
});