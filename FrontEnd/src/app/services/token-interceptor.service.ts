import { Injectable, Injector } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpHeaders } from '@angular/common/http';
import { TokenService } from './token.service';
import 'rxjs/add/observable/fromPromise';
import { Observable } from 'rxjs';


@Injectable({
  providedIn: 'root'
})
export class TokenInterceptorService implements HttpInterceptor{

constructor() {}

intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
  const jwt = localStorage.getItem('token');
  if (jwt) {
   req = req.clone({
     setHeaders: {
      'Content-Type' : 'application/json; charset=utf-8',
      'Accept'       : 'application/json',
       'Authorization': `Bearer ${jwt}`
     }
   });
 }
 return next.handle(req);
} 


}
