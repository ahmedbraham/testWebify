import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class MainService {

  constructor(private httpClient: HttpClient) { 

  }

  
  login(email:string, password:string) {
    return this.httpClient.post('http://localhost:8000/api/login', {email, password});
   }

   all_products() {
    return this.httpClient.get('http://localhost:8000/api/products');
   }


}
