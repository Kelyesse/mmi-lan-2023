const board = document.getElementById('board');
const submitPseudo = document.getElementById('pseudo-zone-submit');
const inputPseudo = document.getElementById('pseudo-zone-input');
const inputPseudoWarning = document.getElementById('pseudo-zone-warning');

printLeaderboard();

async function printLeaderboard(){
    const rep = await fetch('./assets/json/gameLeaderboard.json');
    const json = await rep.json();

    buildLeaderboard(json);
}

var listPseudos;

getPseudos();

async function getPseudos(){
    const url = 'gameGetPseudoList.php';
    const rep = await fetch(url);
    listPseudos = await rep.json();
}

document.addEventListener('keydown', async function(event) {
    if (document.activeElement === inputPseudo) {
        if (/^[a-zA-Z0-9À-ÿ\u0300-\u036f!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~\s]$/.test(event.key)) {
            inputPseudo.value += event.key;
        }
        else if (event.key === 'Backspace' && inputPseudo.value.length > 0) {
            inputPseudo.value = inputPseudo.value.slice(0, -1);
        }
        else if (event.key === ' ') {
            inputElement.value += ' ';
        }

        let pseudo = inputPseudo.value;
        if(listPseudos.includes(pseudo.trim())) inputPseudoWarning.style.display = "block";
        else inputPseudoWarning.style.display = "none";

        event.preventDefault();
        event.stopPropagation();
    }
});

submitPseudo.addEventListener("click", () => {
    let pseudo = inputPseudo.value;
    if(pseudo !== "" && !listPseudos.includes(pseudo.trim())) pseudoLeaderboard(pseudo);
})

async function pseudoLeaderboard(pseudo){
    const url = 'gameSavePseudoInJSON.php';

    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'data=' + encodeURIComponent(pseudo),
    };

    const rep = await fetch(url, options);
    const json = await rep.json();

    buildLeaderboard(json);

    let pseudoZone = document.getElementById('pseudo-zone');
	let pseudoZoneBackground = document.getElementById('pseudo-zone-background');

	pseudoZone.style.display = 'none';
	pseudoZoneBackground.style.display = 'none';

    inputPseudo.value = "";
}


function buildLeaderboard(json) {
    while(board.firstChild){
        board.removeChild(board.firstChild);
    }

    let boardTop1 = document.createElement('div');
    boardTop1.classList.add('board-row-top1');
    board.appendChild(boardTop1);

    let boardZoneTop3 = document.createElement('div');
    boardZoneTop3.classList.add('board-top3-zone');
    board.appendChild(boardZoneTop3);

    let boardZoneOthers = document.createElement('div');
    boardZoneOthers.classList.add('board-others');
    board.appendChild(boardZoneOthers);

    let rank = 1;

    let smoothOuline7px = smoothTextOuline(7);
    let smoothOuline5px = smoothTextOuline(5);

    for (var i = 0; i < json.length; i++) {
        let score = json[i];
        console.log(score.state);

        if(!score.state) continue; // Cas où le score ne doit pas être affiché

        if(rank == 1){
            var boardRow = boardTop1;
        }
        else {
            var boardRow = document.createElement('div');
            if(rank == 2) {
                boardRow.classList.add('board-row-top2');
                boardZoneTop3.appendChild(boardRow);
            } else if(rank == 3) {
                boardRow.classList.add('board-row-top3');
                boardZoneTop3.appendChild(boardRow);
            } else if(rank <= 5) {
                boardRow.classList.add('board-row-others', 'board-row-top5');
                boardZoneOthers.appendChild(boardRow);
            } else if(rank <= 10) {
                boardRow.classList.add('board-row-others', 'board-row-top10');
                boardZoneOthers.appendChild(boardRow);
            } else if(rank > 10) {
                boardRow.classList.add('board-row-others', 'board-row-top100');
                boardZoneOthers.appendChild(boardRow);
            }
                
        }

        let boardRank = document.createElement('div');
        boardRank.classList.add('board-rank');
        boardRank.textContent = "#" + rank;
        if(rank <= 3)
            boardRank.style.textShadow = smoothOuline7px;
        else
            boardRank.style.textShadow = smoothOuline5px;
        boardRow.appendChild(boardRank);

        let zonePseudoTime = document.createElement('div');
        zonePseudoTime.classList.add('board-zone-pseudo-time');
        boardRow.appendChild(zonePseudoTime);

        let boardPseudo = document.createElement('div');
        let boardTime = document.createElement('div');

        boardPseudo.classList.add('board-pseudo');
        boardTime.classList.add('board-time');

        boardPseudo.textContent = score.pseudo;
        boardTime.innerHTML = score.time.m + ":" + score.time.s + "." + score.time.ms;
        
        zonePseudoTime.appendChild(boardPseudo);
        zonePseudoTime.appendChild(boardTime);
        
        rank += 1;
    }
}

function smoothTextOuline(r){
    const color = "#000";
    const n = Math.ceil(2*Math.PI*r) ;
    var str = '';
    for(var i = 0; i < n; i++)
    {
        const theta = 2 * Math.PI * i / n;
        str += (r * Math.cos(theta)) + "px " + (r * Math.sin(theta)) + "px 0 " + color + (i == n - 1 ?"":",")
    }
    return str;
}