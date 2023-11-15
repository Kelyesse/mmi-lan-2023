$(document).ready(function () {
  $(".remove-mate").on("click", function () {
    $("#confirmationPopup").css("display", "flex");
    var userIdToDelete = $(this).data("userid");
    $("#userIdToDelete").val(userIdToDelete);
  });

  $(".accept-mate").on("click", function () {
    var userIdToAccept = $(this).data("userid");
    var teamIdToAccept = $(this).data("teamid");
    $("#userIdToAccept").val(userIdToAccept);
    $('#popUpLeave input[name="teamId"]').val(teamIdToAccept);
    $("#acceptMemberPopup").css("display", "flex");
  });

  $(".reject-mate").on("click", function () {
    var userIdToReject = $(this).data("userid");
    $("#userIdToReject").val(userIdToReject);
    $("#rejectMemberPopup").css("display", "flex");
  });

  $("#remove-team").on("click", function () {
    $("#popUpTeam").css("display", "flex");
  });

  $("#remove-account").on("click", function () {
    $("#popUpAccount").css("display", "flex");
  });

  $("#leave-team").on("click", function () {
    $("#popUpLeave").css("display", "flex");
    var teamId = $(this).data("teamid");
    $('#popUpLeave input[name="teamId"]').val(teamId);
  });

  $(".confirmYes").on("click", function () {
    $(".popup").css("display", "none");
  });

  $(".confirmNo").on("click", function () {
    $(".popup").css("display", "none");
  });
  $("#change-logo").on("click", function () {
    $("#changeLogoPopup").css("display", "flex");
  });
});
