import { Component, OnInit } from '@angular/core';
import { MainService } from '../services/main.service';
import {promise} from "selenium-webdriver";
import Promise = promise.Promise;

@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {


  products: any;



  constructor(        private mainService: MainService
    ) { }

  ngOnInit() {


    let promise = new Promise((resolve, reject) => {
     this.mainService.all_products()
       .toPromise()
       .then(
         res => { // Success

         this.products = res;

         console.log(this.products);



           resolve();

           return promise;

         }
       );
   });

  }





}
