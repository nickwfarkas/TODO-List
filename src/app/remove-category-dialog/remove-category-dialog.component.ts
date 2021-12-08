import { Component, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { MatDialogRef } from '@angular/material/dialog';
import { ApiService } from 'src/services/api.service';

@Component({
  selector: 'app-remove-category-dialog',
  templateUrl: './remove-category-dialog.component.html',
  styleUrls: ['./remove-category-dialog.component.css']
})
export class RemoveCategoryDialogComponent implements OnInit {
  allCategories: string[] = [];
  categoryFormControl: FormControl = new FormControl('', [Validators.required]);
  disableButton = false;
  
  constructor(
    private apiService: ApiService,
    public dialogRef: MatDialogRef<RemoveCategoryDialogComponent>) {
    apiService.readCategories().subscribe((categories: any)=>{
      this.allCategories = categories;
    });
   }

  ngOnInit(): void {
  }

  deleteCategory(): void{
    this.disableButton = true;
    this.apiService.removeCategory(this.categoryFormControl.value).subscribe((c: any)=>{
      if(c == "Success"){
        this.disableButton = false;
        this.dialogRef.close();
      }
    });
  }

  onNoClick(): void{
    this.dialogRef.close();
  }

}
