export class Category {
    private tCategory: string;
    private pCategory: number;

    constructor(t: string, p: number){
        this.tCategory = t;
        this.pCategory = p;
    }

    getTCategory(): string{
        return this.tCategory;
    }

    getPCategory(): number{
        return this.pCategory;
    }

    setTCategory(t: string): void{
        this.tCategory = t;
    }

    setPCategory(p: number): void{
        this.pCategory = p;
    }
}
