import { Routes } from '@angular/router';
import { Product } from './product/product';
import { AddProduct } from './product/Addproduct';

export const routes: Routes = [
  {path: '', redirectTo: 'product', pathMatch: 'full'},

  {path : "product", component: Product},
  {path: "addProduct", component: AddProduct},
];
