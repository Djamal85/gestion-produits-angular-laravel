import { Component, inject, signal } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ProductModel } from '../models/product-model';
import { ProductService } from '../services/product-service';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-product',
  imports: [RouterLink],
  templateUrl: './product.html',
  styleUrl: './product.css',
})
export class Product {
  tabProduct = signal<ProductModel[]>([]);
  //Injection
  /*public constructor(public http: HttpClient ) {

  }*/

  private productService = inject(ProductService);

  //constructeur
  ngOnInit() {
    this.getAll();
  }

  getAll() {
    this.productService.getAll().subscribe((res) => {
      this.tabProduct.set(res);
      console.log(res);
    });
  }

  delete(id: number): void {
    this.productService.delete(id).subscribe((res) => {
      this.getAll();
    });
  }
}
