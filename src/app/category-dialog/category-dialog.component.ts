import { Component, Inject, OnInit } from '@angular/core';
import { FormControl, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Category } from 'src/models/category.model';
import { ApiService } from 'src/services/api.service';
import { AppComponent } from '../app.component';
import { SnackBarComponent } from '../snack-bar/snack-bar.component';

@Component({
  selector: 'app-category-dialog',
  templateUrl: './category-dialog.component.html',
  styleUrls: ['./category-dialog.component.css']
})
export class CategoryDialogComponent implements OnInit {
  p: number = 0;
  selectedCategory: string ="";
  allCategories: string[] = [];
  categoryName: string ="";
  categoryFormControl: FormControl = new FormControl('', [Validators.required]);
  disableButton = false;
  constructor(
    public dialogRef: MatDialogRef<CategoryDialogComponent>,
    private apiService: ApiService,
    private snackBar: MatSnackBar
  )
  {
    this.apiService.readCategories().subscribe((categories: any)=>{
      this.allCategories = categories;
    });
  }

  openSnackBar() {
    this.snackBar.openFromComponent(SnackBarComponent, {
      duration: 5 * 1000,
      panelClass: ['red-snackbar']
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  exists(arr: any[], search: any): boolean {
    return arr.some(row => row.includes(search));
  } 

  sendNewCategory(): void{
    if(this.exists(this.allCategories,this.categoryFormControl.value))
    {
      this.openSnackBar();
      this.categoryFormControl.reset();
    }
    else
    {
      this.disableButton = true;
      this.apiService.createCategory(new Category(this.categoryFormControl.value,+this.selectedCategory)).subscribe((c: any)=>{
        if(c == "Success"){
          this.disableButton = false;
          this.dialogRef.close();
        }
      });;

    }
  }

  isUnique(s: string): boolean{
    if(s in this.allCategories)
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  ngOnInit(): void {
  }

}
