import { Routes } from '@angular/router';
import { Product } from './product/product';
import { AddProduct } from './product/Addproduct';
import { Category } from './category/category';
// import { Login } from './auth/login';
// import { Register } from './auth/register';
// import { authGuard } from './services/auth-guard';

export const routes: Routes = [
  { path: '', redirectTo: 'product', pathMatch: 'full' },
  // Authentification temporairement désactivée :
  // { path: 'login', component: Login },
  // { path: 'register', component: Register },
  // { path: 'product', component: Product, canActivate: [authGuard] },
  // { path: 'addProduct', component: AddProduct, canActivate: [authGuard] },
  // { path: 'editProduct/:id', component: AddProduct, canActivate: [authGuard] },

  { path: 'product', component: Product },
  { path: 'addProduct', component: AddProduct },
  { path: 'editProduct/:id', component: AddProduct },
  { path: 'categories', component: Category },
  { path: '**', redirectTo: 'product' },
];
