class Peice{
    constructor(board, player, cellRow, cellCol){
        this.board = board;
        this.player = player;
        this.cellRow = cellRow;
        this.cellCol = cellCol;
        this.currentCell = []; //this will be the spot on the board that the peice was placed
    }
}