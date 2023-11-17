pageAvatars = [".prem", ".sec", ".trois", ".quatre"]
let currentIndex = 0

$(document).ready(function () {
    let avatarOptions = $(".avatar-option")
    let avatarInput = $("#avatar")

    $("#next").click(function () {
        currentIndex += 1
        displayAvatarPage(currentIndex)
    })

    $("#pre").click(function () {
        currentIndex -= 1
        displayAvatarPage(currentIndex)
    })

    avatarOptions.on("click", function () {
        avatarOptions.removeClass("active")
        $(this).addClass("active")

        var selectedAvatarSrc = $(this).find("img").attr("src")

        var fileName = selectedAvatarSrc.split("/").pop()

        avatarInput.val(fileName)
    })
})

const avatarImgs = document.querySelectorAll(".avatar-img")

const displayAvatarPage = (page) => {
    let avatarValue = 0

    if (page < 0) {
        page = 0
    }
    if (page > pageAvatars.length - 1) {
        page = pageAvatars.length - 1
    }
    document.querySelector(".avatar-img1").src = `./assets/img/avatar${
        1 + page * 6
    }.png`
    document.querySelector(".avatar-img2").src = `./assets/img/avatar${
        2 + page * 6
    }.png`
    document.querySelector(".avatar-img3").src = `./assets/img/avatar${
        3 + page * 6
    }.png`
    document.querySelector(".avatar-img4").src = `./assets/img/avatar${
        4 + page * 6
    }.png`
    document.querySelector(".avatar-img5").src = `./assets/img/avatar${
        5 + page * 6
    }.png`
    document.querySelector(".avatar-img6").src = `./assets/img/avatar${
        6 + page * 6
    }.png`
}

displayAvatarPage(0)
