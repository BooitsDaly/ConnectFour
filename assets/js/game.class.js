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
    getFree(i,length){
        let board = this.boardArr;
        //let length = board[i].length;
        let number = length;
        console.log(board[i]);
        for(let x = 0; x< length ; x++){
            if(board[i][x] !== 0){
                console.log(x);
                number = x;
                break;
            }
        }
        console.log(number);
        return number;
    }
    animatePiece(i,next){
        console.log(next);
        for(let x = 0; x < next; x++){
            if(this.boardArr[i][x] === 0){
                //this is a free space
                if(x !== 0){
                    let prev = x -1;
                    setTimeout(()=> {
                        document.getElementById(i + "-" + prev).setAttributeNS(null, 'class', 'free');
                        document.getElementById(i + "-" + x).setAttributeNS(null, 'class', 'red');
                    },1000);
                }else{
                    document.getElementById(i+ "-"+ x).setAttributeNS(null,'class','red');
                }
            }
        }
    }

    //for each column
    attachActionListener(i){
        console.log("you have been clicked bitch");
        console.log(i);
        //let checker = document.getElementsByClassName(i);
        //console.log(checker);
        let col = this.boardArr[i];
        let free = this.getFree(i,col);
        this.animatePiece(i,free);
        this.boardArr[i][free] = 1;

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