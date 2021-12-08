import { Component, ViewChild } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSlideToggleChange } from '@angular/material/slide-toggle';
import { Category } from 'src/models/category.model';
import { Task } from 'src/models/task.model';
import { ApiService } from 'src/services/api.service';
import { CategoryDialogComponent } from './category-dialog/category-dialog.component';
import { TaskDialogComponent } from './task-dialog/task-dialog.component';
import { SelectionModel } from '@angular/cdk/collections';
import { MatTable } from '@angular/material/table';
import { RemoveCategoryDialogComponent } from './remove-category-dialog/remove-category-dialog.component';
import { MatTableModule } from '@angular/material/table';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  @ViewChild(MatTable) table!: MatTable<any>;
  allTasks: string[][] = [];
  displayedColumns: string[] = ['category','task','dueDate','priorityLevel','status','delete'];
  dataSource = this.allTasks;
  toRemove: number[] = [];
  checked = false;
  allCategories: string[][] = [];
  selectedCategory: string[] = ["-1","All","null"];
  parentCategories: string[] = [];
  selectedDate: string = "";
  noRemovesSelected = true;

  constructor(private apiService: ApiService, public dialog: MatDialog){
    this.apiService.readTasks("All Time", this.selectedCategory[1], null).subscribe((tasks: any)=>{
      this.allTasks = tasks;
    });

    this.apiService.readCategorySub().subscribe((categories: any)=>{
      this.allCategories = categories;
    });

    this.apiService.readCategories().subscribe((categories: any)=>{
      this.parentCategories = categories;
    });
  }

  openCategoryDialog(): void {
    const dialogRef = this.dialog.open(CategoryDialogComponent, {
    });
    dialogRef.afterClosed().subscribe(result => {
      this.apiService.readCategorySub().subscribe((categories: any)=>{
        this.allCategories = categories;
      });
      this.apiService.readCategories().subscribe((categories: any)=>{
        this.parentCategories = categories;
      });
    });
  }

  openTaskDialog(): void {
    const dialogRef = this.dialog.open(TaskDialogComponent, {
    });
    dialogRef.afterClosed().subscribe(result => {
      this.applyFilters();
    });
  }

  openCategoryDeleteDialog(): void {
    const dialogRef = this.dialog.open(RemoveCategoryDialogComponent, {
    });
    dialogRef.afterClosed().subscribe(result => {
      this.apiService.readCategorySub().subscribe((categories: any)=>{
        this.allCategories = categories;
      });
      this.apiService.readCategories().subscribe((categories: any)=>{
        this.parentCategories = categories;
      });
    });
  }


  send(): void{
    this.table.renderRows();
  }

  toggle(id: number, status: number): void{
    var i = 0;
    while(this.allTasks[i][0] != id.toString()){
      i++
    }

    if(this.allTasks[i][5] == "1"){
      this.allTasks[i][5] = "0";
    }
    else{
      this.allTasks[i][5] = "1";
    }

    this.apiService.updateStatus(id,status).subscribe((tasks: any)=>{
    });
  }

  addOrRemove(id: number): void{
    var i = this.toRemove.indexOf(id);
    if(i == -1)
    {
      this.toRemove.push(id);
    }
    else
    {
      this.toRemove.splice(i,1);
    }
    if(this.toRemove.length == 0)
    {
      this.noRemovesSelected = true;
    }
    else{
      this.noRemovesSelected = false;
    }
  }

  deleteSelected(): void{
    this.apiService.deleteTask(this.toRemove).subscribe((tasks: any)=>{
    });
    var indexes: number[] = []
    for (let i = 0; i < this.toRemove.length; i++) {
      for (let j = 0; j < this.allTasks.length; j++) {
        if(this.allTasks[j][0] == this.toRemove[i].toString())
        {
          indexes.push(j);
          break;
        }
      }
    }

    indexes.forEach(element => {
      this.allTasks.splice(element,1);
    });

    this.toRemove = [];
    this.table.renderRows();
  }

  applyFilters(): void{
    var d: string
    var sub: string | null;
    sub = this.selectedCategory[2];
    if(sub == "null"){
      sub = null;
    }
    if(this.selectedDate == ""){
      d = "All Time"
    }
    else{
      d = this.selectedDate;
    }
    this.apiService.readTasks(d, this.selectedCategory[1], sub).subscribe((tasks: any)=>{
      this.allTasks = tasks;
    });
  }

  title = 'todo-list';
}
