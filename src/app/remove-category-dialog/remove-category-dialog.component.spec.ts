import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RemoveCategoryDialogComponent } from './remove-category-dialog.component';

describe('RemoveCategoryDialogComponent', () => {
  let component: RemoveCategoryDialogComponent;
  let fixture: ComponentFixture<RemoveCategoryDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RemoveCategoryDialogComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(RemoveCategoryDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
