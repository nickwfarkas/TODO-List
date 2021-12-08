export class Task {
    private categoryID: string;
    private taskDescription: string;
    private dueDate: string;
    private priority: string;

    constructor(categoryID: string, taskDescription: string, dueDate: string, priority: string){
        this.categoryID = categoryID;
        this.taskDescription = taskDescription;
        this.dueDate = dueDate;
        this.priority = priority;
    }
}