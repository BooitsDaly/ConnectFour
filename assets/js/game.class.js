class Game{
    constructor() {
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
        let gameBoard = document.createElementNS(null,'g');
        //create the board
        for(let i = 0; i < this.BOARDWIDTH; i++){
            this.boardArr[i] = new Array();
        }

        //set the action listener for placing pieces

        //set colors for whose turn it is

        //find out whose turn it is
    }

    attachActionListener(){

    }
}