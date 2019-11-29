import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { throwError } from 'rxjs';
import { MainService } from '../services/main.service';
import { TokenService } from '../services/token.service';
import { AuthService } from '../services/auth.service';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  selectFormControl = new FormControl('', Validators.required);

  loginForm: FormGroup;

    constructor(
        private _formBuilder: FormBuilder,
        private mainService: MainService,
        private Token: TokenService,
        private router: Router,
        private Auth: AuthService,    )
    {
      

    }

    
    /**
     * On init
     */
    ngOnInit(): void
    {
        this.loginForm = this._formBuilder.group({
            email   : ['', [Validators.required, Validators.email]],
            password: ['', Validators.required],
          //  roleControl: ['', Validators.required],

        });
       
    }

 

    onSubmit(){

        this.mainService.login(this.loginForm.get('email').value, this.loginForm.get('password').value).subscribe(
            data => this.handleResponse(data),
            error => this.handleError(error)        );
    }



     handleResponse(data) {

      this.Token.handle(data.access_token);
      this.Auth.changeAuthStatus(true);   
      
      this.router.navigateByUrl('product');
      }
      

 

      handleError(error) {
        window.alert(error.message);

    }


}
