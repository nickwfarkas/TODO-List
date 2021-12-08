import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { MatDialogRef } from '@angular/material/dialog';
import { Task } from 'src/models/task.model';
import { ApiService } from 'src/services/api.service';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-task-dialog',
  templateUrl: './task-dialog.component.html',
  styleUrls: ['./task-dialog.component.css']
})
export class TaskDialogComponent implements OnInit {
  allCategories: string[] = [];
  selectedPriorityLevel: string = "";
  stringDate!: string | null;
  taskFormControl: FormControl = new FormControl('', [Validators.required]);
  taskDueDateFormControl: FormControl = new FormControl('', [Validators.required]);
  categoryFormControl: FormControl = new FormControl('', []);
  disableButton = false;
  constructor(private apiService: ApiService, 
    public dialogRef: MatDialogRef<TaskDialogComponent>,
    public datepipe: DatePipe
    ) {
    this.apiService.readCategories().subscribe((categories: any)=>{
      this.allCategories = categories;
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  ngOnInit(): void {
  }


  sendNewTask(): void{
    this.stringDate = this.datepipe.transform(this.taskDueDateFormControl.value, 'yyyy-MM-dd');
    if(this.stringDate == null){
      this.stringDate = "";
    }
    var r = "";
    var t = new Task(this.categoryFormControl.value,this.taskFormControl.value,this.stringDate,this.selectedPriorityLevel);
    this.disableButton = true;
    this.apiService.createTask(t).subscribe((task: any)=>{
      if(task == "Success"){
        this.disableButton = false;
        this.dialogRef.close();
      }
    });
    
  }
}
