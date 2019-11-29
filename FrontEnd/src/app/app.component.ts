import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';


import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { throwError } from 'rxjs';
import { MainService } from './services/main.service';
import { TokenService } from './services/token.service';
import { AuthService } from './services/auth.service';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
 
    constructor( private router: Router,  )
    {
      

    }

    
    /**
     * On init
     */
    ngOnInit(): void
    {


       
    }

 login(){
  this.router.navigateByUrl('login');

 }

}
