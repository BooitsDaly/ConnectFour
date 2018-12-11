class Game{
    constructor(player1, player2) {
        this.xhtmlns = "http://www.w3.org/1999/xhtml";
        this.svgns = "http://www.w3.org/2000/svg";
        this.BOARDWIDTH = 7;
        this.BOARDHEIGHT = 6;
        // [0][0][0] - 0 is empty
        // [0][0][0] - 1 player1
        // [1][2][1] - 2 player2
        this.boardArr = new Array();
        this.player1 = player1;
        this.player2 = player2;

        //create parent for the board
        let gameBoard = document.createElementNS(this.svgns,'g');
        //create the board
        for(let i = 0; i < this.BOARDWIDTH; i++){
            this.boardArr[i] = new Array();
            let col = this.createColumn(i);
            for(let j = 0; j < this.BOARDHEIGHT; j++){
                this.boardArr[i][j] = 0;
                let row = col.appendChild(this.createRow(j));
                row.appendChild(this.createCircle(i,j));
                $('#game-board').append(col);
            }
        }
    }
    getFree(col){
        let test;
        for(let i = 0; i < col.length; i++){
            if(col[i] === 0){
                //return i;
                test=i;
            }
        }
        return test;
    }
    animatePiece(i,next,player){
        for(let x = 0; x < next+1; x++){
            if(this.boardArr[i][x] === 0){
                //this is a free space
                if(x !== 0){
                    let prev = x -1;
                    setTimeout(()=> {
                        document.getElementById(i + "-" + prev).setAttributeNS(null, 'class', 'free');
                        if(player === true){
                            document.getElementById(i + "-" + x).setAttributeNS(null, 'class', 'yellow');
                        }else{
                            document.getElementById(i + "-" + x).setAttributeNS(null, 'class', 'red');
                        }

                    },1000);
                }else{
                    if(player === true){
                        document.getElementById(i + "-" + x).setAttributeNS(null, 'class', 'yellow');
                    }else{
                        document.getElementById(i + "-" + x).setAttributeNS(null, 'class', 'red');
                    }
                }
            }
        }
    }

    //for each column
    attachActionListener(i){
        console.log("you have been clicked bitch");
        //let checker = document.getElementsByClassName(i);
        //console.log(checker);
        console.log(this.boardArr);
        if(ajax.turn ===true){
            let col = this.boardArr[i];
            let free = this.getFree(col);
            if(free === undefined){
                displayFeedback('error','This row is full');
            }else{
                this.animatePiece(i,free,true);
                this.boardArr[i][free] = 1;
            }
            ajax.changeTurn('changeTurn',"{\"col\":\""+i +"\" ,\"row\":\""+free +"\"}");
        }else{
            displayFeedback('error','Not your turn');
        }



        //check if there are any empty spots in the col
        //find the next open col
        //place peice
        //send ajax call

    }
    createColumn(i){
        let col = document.createElement("div");
        col.setAttribute('id','column-' + i);
        col.setAttribute('data-x',i);
        col.setAttribute('class','column');
        col.onclick =()=>{this.attachActionListener(i)};
        return col;
    }
    createRow(i){
        let row = document.createElementNS(this.svgns,'svg');
        row.setAttributeNS(null,'height','100');
        row.setAttributeNS(null,'width', '100');
        row.setAttributeNS(null,'class','row-'+i);
        return row;
    }
    createCircle(i,j){
        let circle = document.createElementNS(this.svgns,'circle');
        circle.setAttributeNS(null,'cx', '50');
        circle.setAttributeNS(null, 'cy', '50');
        circle.setAttributeNS(null,'r', '40');
        circle.setAttributeNS(null,'stroke','#0B4E72');
        circle.setAttributeNS(null,'stroke-width','3');
        circle.setAttributeNS(null,'class', 'free');
        //circle.setAttributeNS(null,'class', i);
        circle.setAttributeNS(null, 'id', i + "-"+ j);
        return circle;
    }
}