import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map, Observable } from 'rxjs';
import { Category } from 'src/models/category.model';
import { Task } from 'src/models/task.model';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  PHP_API_SERVER = "http://csc4710-group7.000webhostapp.com";
  constructor(private httpClient: HttpClient) { }

  // readTasks(): Observable<any>{
	// 	return this.httpClient.get<any>(`${this.PHP_API_SERVER}/getTasks.php`);
	// }

  readCategories(): Observable<any>{
		return this.httpClient.get<any>(`${this.PHP_API_SERVER}/getCategories.php`);
	}

  createCategory(category: Category): Observable<any>{
		return this.httpClient.post<any>(`${this.PHP_API_SERVER}/db_add_category_from_request.php`, JSON.stringify(category));
	}

  createTask(task: Task): Observable<any>{
		return this.httpClient.post<any>(`${this.PHP_API_SERVER}/db_add_task_from_request.php`, JSON.stringify(task));
	}

  updateStatus(id: number, status: number): Observable<any>{
    return this.httpClient.post(`${this.PHP_API_SERVER}/db_update_status_from_request.php`, JSON.stringify({id: id,status: status}), {responseType: 'text'});
  }

  deleteTask(ids: number[]): Observable<any>{
    return this.httpClient.post(`${this.PHP_API_SERVER}/db_delete_task_from_request.php`, JSON.stringify({ids: ids}), {responseType: 'text'});
  }

  readCategorySub(): Observable<any>{
    return this.httpClient.get<any>(`${this.PHP_API_SERVER}/db_get_category_and_sub_from_request.php`);
  }

  readTasks(date: string, parent: string, subCategory: string | null): Observable<any>{
    if(date == ""){
      date = "All Time"
    }
    
    return this.httpClient.post<any>(`${this.PHP_API_SERVER}/getTasks.php`, JSON.stringify({parent: parent, subcategory: subCategory, date: date}));
  }

  removeCategory(id: string): Observable<any>{
    return this.httpClient.post<any>(`${this.PHP_API_SERVER}/db_remove_category_from_request.php`, JSON.stringify({id: id}));
  }
}
