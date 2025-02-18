export default class Diak{
    #id;
    #nev;
    #sor;
    #oszlop;

    constructor(id, nev, sor, oszlop){
        this.setId(id);
        this.setNev(nev);
        this.setSor(sor);
        this.setOszlop(oszlop);

        this.getId = this.getId.bind(this);
        this.getNev = this.getNev.bind(this);
        this.getSor = this.getSor.bind(this);
        this.getOszlop = this.getOszlop.bind(this);
    }

    setId(id){
        this.#id = id;
    }

    setNev(nev){
        this.#nev = nev;
    }

    setSor(sor){
        this.#sor = sor;
    }

    setOszlop(oszlop){
        this.#oszlop = oszlop;
    }

    getId(){
        return this.#id;
    }
   
    getNev(){
        return this.#nev;
    }

    getSor(){
        return this.#sor;
    }

    getOszlop(){
        return this.#oszlop;
    }
}