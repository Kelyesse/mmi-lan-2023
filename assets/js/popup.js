$(document).ready(function () {
  $(".remove-mate").on("click", function () {
    $("#confirmationPopup").css("display", "flex");
    $("#confirmationPopup .confirmYes").on("click", function () {
      $("#confirmationPopup").css("display", "none");
    });
    $("#confirmationPopup .confirmNo").on("click", function () {
      $("#confirmationPopup").css("display", "none");
    });
  });

  $("#remove-team").on("click", function () {
    $("#popUpTeam").css("display", "flex");
    $("#popUpTeam .confirmYes").on("click", function () {
      $("#popUpTeam").css("display", "none");
    });
    $("#popUpTeam .confirmNo").on("click", function () {
      $("#popUpTeam").css("display", "none");
    });
  });

  $("#remove-account").on("click", function () {
    $("#popUpAccount").css("display", "flex");
    $("#popUpAccount .confirmYes").on("click", function () {
      $("#popUpAccount").css("display", "none");
    });
    $("#popUpAccount .confirmNo").on("click", function () {
      $("#popUpAccount").css("display", "none");
    });
  });

  $("#leave-team").on("click", function () {
    // Utiliser la variable JavaScript teamIdValue ici
    $('#popUpLeave input[name="teamId"]').val(teamIdValue);
    $("#popUpLeave").css("display", "flex");
    $("#popUpLeave .confirmYes").on("click", function () {
      $("#popUpLeave").css("display", "none");
    });
    $("#popUpLeave .confirmNo").on("click", function () {
      $("#popUpLeave").css("display", "none");
    });
  });
});
